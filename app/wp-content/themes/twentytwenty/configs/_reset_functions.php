<?php
  
  //Disable gutenberg style in Front
  function wps_deregister_styles()
  {
    wp_dequeue_style('wp-block-library');
  }
  
  add_action('wp_print_styles', 'wps_deregister_styles', 100);
  
  //EMBED LINK
  add_action('init', function () { // Remove the REST API endpoint.
    remove_action(
      'rest_api_init',
      'wp_oembed_register_route'
    ); // Turn off oEmbed auto discovery. // Don't filter oEmbed results.
    remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10); // Remove oEmbed discovery links.
    remove_action(
      'wp_head',
      'wp_oembed_add_discovery_links'
    ); // Remove oEmbed-specific JavaScript from the front-end and back-end.
    remove_action('wp_head', 'wp_oembed_add_host_js');
  }, PHP_INT_MAX - 1);
  
  function mywptheme_child_deregister_styles()
  {
    wp_dequeue_style('classic-theme-styles');
    wp_dequeue_style('global-styles');
  }
  
  add_action('wp_enqueue_scripts', 'mywptheme_child_deregister_styles', 20);
  
  remove_action(
    'wp_head',
    'rsd_link'
  ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
  remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
  remove_action('wp_head', 'index_rel_link'); // index link
  remove_action('wp_head', 'parent_post_rel_link', 10); // prev link
  remove_action('wp_head', 'start_post_rel_link', 10); // start link
  remove_action(
    'wp_head',
    'adjacent_posts_rel_link',
    10
  ); // Display relational links for the posts adjacent to the current post.
  remove_action(
    'wp_head',
    'wp_generator'
  ); // Display the XHTML generator that is generated on the wp_head hook, WP version
  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('wp_print_styles', 'print_emoji_styles');
  remove_action('admin_print_scripts', 'print_emoji_detection_script');
  remove_action('admin_print_styles', 'print_emoji_styles');
  remove_action('wp_head', 'wp_shortlink_wp_head'); //removes shortlink.
  remove_action('wp_head', 'feed_links', 2); //removes feed links.
  remove_action('wp_head', 'feed_links_extra', 3);  //removes comments feed.
  
  function disable_yoast_schema_data($data)
  {
    $data = array();
    
    return $data;
  }
  
  add_filter('wpseo_json_ld_output', 'disable_yoast_schema_data', 10, 1);
  
  //noopener к ссылкам
  function true_wp_posts_nofollow($content)
  {
    return stripslashes(wp_rel_nofollow($content));
  }
  
  add_filter('the_content', 'true_wp_posts_nofollow');
  
  //alt картинкам
  function change_empty_alt_to_title($response)
  {
    if (!$response['alt']) {
      $response['alt'] = sanitize_text_field($response['uploadedToTitle']);
    }
    return $response;
  }
  
  add_filter('wp_prepare_attachment_for_js', 'change_empty_alt_to_title');
  