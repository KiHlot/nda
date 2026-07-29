<?php
  
  add_action('rest_api_init', 'register_custom_rest_routes');
  
  function register_custom_rest_routes()
  {
    (new Likes_Widget_Controller())->register_routes();
  }