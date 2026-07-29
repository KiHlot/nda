<?php
  
  function get_likes_widget(WP_Post $post): string
  {
    $likes_widget = new Likes_Widget_Controller();
    $count = $likes_widget->get_total_likes($post->ID);
    $db_data = $likes_widget->get_user_likes_data_by_post_id($post->ID);
    $type = $db_data ? $db_data->type : null;
    
    return '
      <div class="likes_widget" data-post-id="'.$post->ID.'">
        <button class="button decrement" data-type="decrement" '.($type === '-1' ? 'disabled' : '' ).'>
          <svg width="13" height="2" viewBox="0 0 13 2" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 1H1" stroke="white" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>
        <div class="count">'.$count.'</div>
        <button class="button increment" data-type="increment" '.($type === '1' ? 'disabled' : '' ).'>
          <svg xmlns="http://www.w3.org/2000/svg" width="12px" height="12px" viewBox="0 0 0.34396 0.34396" fill="#ffffff">
            <path d="M0.19844 0.3175c0,0.01461 -0.01185,0.02646 -0.02646,0.02646 -0.01461,0 -0.02646,-0.01185 -0.02646,-0.02646l0 -0.11906 -0.11906 0c-0.01461,0 -0.02646,-0.01185 -0.02646,-0.02646 0,-0.01461 0.01185,-0.02646 0.02646,-0.02646l0.11906 0 0 -0.11906c0,-0.01461 0.01185,-0.02646 0.02646,-0.02646 0.01461,0 0.02646,0.01185 0.02646,0.02646l0 0.11906 0.11906 0c0.01461,0 0.02646,0.01185 0.02646,0.02646 0,0.01461 -0.01185,0.02646 -0.02646,0.02646l-0.11906 0 0 0.11906z"/>
          </svg>
        </button>
      </div>';
  }
  