<?php
  /**
   * twentytwenty functions and definitions
   *
   * @package twentytwenty
   */
  
  if (!defined('_S_VERSION')) {
    define('_S_VERSION', '1.0.4');
  }
  
  function twentytwenty_setup()
  {
    load_theme_textdomain('twentytwenty', get_template_directory().'/languages');
    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    
    register_nav_menus(
      array(
        'HeadMenu' => esc_html__('HeadMenu', 'twentytwenty'),
      )
    );
    
    add_theme_support(
      'html5',
      array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
      )
    );
    
    add_theme_support(
      'custom-background',
      apply_filters(
        'twentytwenty_custom_background_args',
        array(
          'default-color' => 'ffffff',
          'default-image' => '',
        )
      )
    );
    
    add_theme_support('customize-selective-refresh-widgets');
  }
  
  add_action('after_setup_theme', 'twentytwenty_setup');
  
  function twentytwenty_content_width()
  {
    $GLOBALS['content_width'] = apply_filters('twentytwenty_content_width', 640);
  }
  
  add_action('after_setup_theme', 'twentytwenty_content_width', 0);
  
  function twentytwenty_widgets_init()
  {
    register_sidebar(
      array(
        'name' => esc_html__('Sidebar', 'twentytwenty'),
        'id' => 'sidebar-1',
        'description' => esc_html__('Add widgets here.', 'twentytwenty'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
      )
    );
  }
  
  add_action('widgets_init', 'twentytwenty_widgets_init');
  
  function remove_default_sizes($sizes)
  {
    unset($sizes['1536x1536']);
    unset($sizes['2048x2048']);
    unset($sizes['medium_large']);
    
    return $sizes;
  }
  
  add_filter('intermediate_image_sizes_advanced', 'remove_default_sizes');
  
  add_image_size('img300', 300, 300, true);
  
  function twentytwenty_scripts()
  {
    if (!is_admin()) {
      wp_deregister_script('jquery');
    }
    
    wp_enqueue_script(
      'app_scripts',
      get_template_directory_uri().'/assets/js/app.min.js?v='._S_VERSION,
      [],
      null,
      true
    );
    
    wp_enqueue_style('app_style', get_template_directory_uri().'/assets/css/app.min.css?v='._S_VERSION, [], null);
    
    wp_localize_script('app_scripts', 'ajax_var', array(
      'url' => admin_url('admin-ajax.php'),
      'nonce' => wp_create_nonce('ajaxnonce')
    ));
  }
  
  add_action('wp_enqueue_scripts', 'twentytwenty_scripts');
  
  include_once 'configs/index.php';
  