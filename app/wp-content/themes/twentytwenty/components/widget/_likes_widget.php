<?php
  
  function get_likes_widget(WP_Post $post): string
  {
    return '
      <div id="likes_widget" class="likes_widget">
        <button class="button decrement" data-type="decrement">
          <svg width="13" height="2" viewBox="0 0 13 2" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 1H1" stroke="white" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>
        <div class="count">0</div>
        <button class="button increment" data-type="increment">
          <svg xmlns="http://www.w3.org/2000/svg" width="12px" height="12px" viewBox="0 0 0.34396 0.34396" fill="#ffffff">
            <path d="M0.19844 0.3175c0,0.01461 -0.01185,0.02646 -0.02646,0.02646 -0.01461,0 -0.02646,-0.01185 -0.02646,-0.02646l0 -0.11906 -0.11906 0c-0.01461,0 -0.02646,-0.01185 -0.02646,-0.02646 0,-0.01461 0.01185,-0.02646 0.02646,-0.02646l0.11906 0 0 -0.11906c0,-0.01461 0.01185,-0.02646 0.02646,-0.02646 0.01461,0 0.02646,0.01185 0.02646,0.02646l0 0.11906 0.11906 0c0.01461,0 0.02646,0.01185 0.02646,0.02646 0,0.01461 -0.01185,0.02646 -0.02646,0.02646l-0.11906 0 0 0.11906z"/>
          </svg>
        </button>
      </div>';
  }