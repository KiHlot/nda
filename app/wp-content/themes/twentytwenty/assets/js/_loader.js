import { toggleBodyOverflow } from "./helpers/_utils.js";

export const showLoader = (isShow) => {
  const loader = document.getElementById("global_loader");

  if (!loader) {
    return;
  }

  if (isShow) {
    loader.classList.add("showed");
    toggleBodyOverflow(true);
  } else {
    loader.classList.remove("showed");
    toggleBodyOverflow(false);
  }
};
