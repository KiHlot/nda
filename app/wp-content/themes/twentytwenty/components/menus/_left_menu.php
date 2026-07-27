<?php
  
  function get_left_menu_HTML()
  {
    $menu_items = wp_get_nav_menu_items(4);
    $menu_list = '';
    $page_id = get_the_ID();

    foreach ((array)$menu_items as $menu_item) {
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
  
  function get_left_menu(): string
  {
    if ( is_404() ) {
      return '';
    }
    
    return '
      <div id="left_menu" class="left_menu flcol">
          '.get_contacts_list().'
      </div>';
  }