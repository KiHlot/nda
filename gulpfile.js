const fileswatch = "html,htm,txt,json,md,woff2,php";
const theme = "twentytwenty";
const proxy = "http://nda.local";

import * as pkg from "gulp";
import browserSync from "browser-sync";
import webpack from "webpack";
import webpackStream from "webpack-stream";
import TerserPlugin from "terser-webpack-plugin";
import * as gulpSass from "gulp-sass";
import * as dartSass from "sass";
import sassglob from "gulp-sass-glob";
import postCss from "gulp-postcss";
import cssnano from "cssnano";
import autoprefixer from "autoprefixer";
import concat from "gulp-concat";
import { deleteAsync } from "del";
import cleanCss from "gulp-clean-css";

const { src, dest, parallel, series, watch } = pkg;
const sass = gulpSass.default(dartSass.default);

function browsersync() {
  return browserSync.init({
    proxy: proxy,
    notify: true,
    open: true,
  });
}

function scripts() {
  return src([
    `app/wp-content/themes/${theme}/assets/js/*.js`,
    `app/wp-content/themes/${theme}/assets/js/**/*.js`,
    `!app/wp-content/themes/${theme}/assets/js/*.min.js`,
    `!app/wp-content/themes/${theme}/assets/js/**/*.min.js`,
  ])
    .pipe(
      webpackStream(
        {
          mode: "production",
          performance: { hints: false },
          module: {
            rules: [
              {
                test: /\.m?js$/,
                exclude: /node_modules/,
                use: {
                  loader: "babel-loader",
                  options: {
                    presets: ["@babel/preset-env"],
                    plugins: ["babel-plugin-root-import"],
                  },
                },
              },
            ],
          },
          optimization: {
            minimize: true,
            minimizer: [
              new TerserPlugin({
                terserOptions: { format: { comments: false } },
                extractComments: false,
              }),
            ],
          },
        },
        webpack,
      ),
    )
    .on("error", function handleError(e) {
      console.error(e);
      this.emit("end");
    })
    .pipe(concat("app.min.js"))
    .pipe(dest(`app/wp-content/themes/${theme}/assets/js`))
    .pipe(browserSync.stream());
}

function styles() {
  return src([
    `app/wp-content/themes/${theme}/assets/styles/*.scss`,
    `!app/wp-content/themes/${theme}/assets/styles/_*.scss`,
  ])
    .pipe(sassglob())
    .pipe(sass({ "include css": true }).on("error", sass.logError))
    .pipe(
      postCss([
        autoprefixer({ grid: "autoplace" }),
        cssnano({
          preset: ["default", { discardComments: { removeAll: true } }],
        }),
      ]),
    )
    .pipe(concat("app.min.css"))
    .pipe(cleanCss())
    .pipe(dest(`app/wp-content/themes/${theme}/assets/css`))
    .pipe(browserSync.stream());
}

function buildcopy() {
  return src(
    [
      `app/wp-content/themes/${theme}/assets/js/*.min.js`,
      `app/wp-content/themes/${theme}/assets/css/*.min.css`,
      `app/wp-content/themes/${theme}/**/*.{${fileswatch}}`,
      `!app/wp-content/themes/${theme}/{src,src/**}`,
    ],
    { base: "app/" },
  ).pipe(dest("dist"));
}

async function buildhtml() {
  const includes = new ssi("app/", "dist/", "/**/*.html");
  includes.compile();
  await deleteAsync("dist/parts", { force: true });
}

async function cleandist() {
  await deleteAsync("dist/**/*", { force: true });
}

function startwatch() {
  watch(
    `app/wp-content/themes/${theme}/assets/styles/**/*`,
    { usePolling: true },
    styles,
  );

  watch(
    [
      `app/wp-content/themes/${theme}/assets/js/*.js`,
      `app/wp-content/themes/${theme}/assets/js/**/*.js`,
      `!app/wp-content/themes/${theme}/assets/js/*.min.js`,
      `!app/wp-content/themes/${theme}/assets/js/**/*.min.js`,
    ],
    { usePolling: true },
    scripts,
  );

  watch(`app/wp-content/themes/${theme}/**/*.{${fileswatch}}`, {
    usePolling: true,
  }).on("change", browserSync.reload);
}

export { scripts, styles };
export const assets = series(scripts, styles);
export const build = series(cleandist, scripts, styles, buildcopy, buildhtml);
export default series(
  parallel(scripts, styles),
  parallel(browsersync, startwatch),
);
