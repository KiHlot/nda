<?php
  
  function get_top_menu_HTML()
  {
    $page_id = get_the_ID();
    $menu_items = wp_get_nav_menu_items(5);
    $menu_list = '';
    
    if (!$menu_items) {
      return '';
    }
    
    foreach ($menu_items as $menu_item) {
      $current_class = $page_id === intval($menu_item->object_id) ? 'current' : '';
      
      $menu_list .= '
				<li title="'.$menu_item->title.'">
          <a href="'.$menu_item->url.'" class="flc link '.$current_class.'">
            '.$menu_item->title.'
          </a>
        </li>';
    }
    
    return '
			<nav class="navigation flc">
				<ul>'.$menu_list.'</ul>
			</nav>';
  }
