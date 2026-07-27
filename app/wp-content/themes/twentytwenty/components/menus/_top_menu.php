<?php
  
  function get_top_menu_HTML()
  {
    $menu_items = wp_get_nav_menu_items(3);
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
        <button type="button" id="menu_close" class="menu_close flc">'.get_svg('close').'</button>
				<ul>'.$menu_list.'</ul>
			</nav>';
  }
  
  function get_top_menu(): string
  {
    if ( is_404() ) {
      return '';
    }

    $tg_login = gf('cnt_telegram', 18);
    
    return '
      <header id="top_menu" class="top_menu '.(is_inverted_page() ? 'inverted' : '').'">
        '.get_main_logo().'
        <div class="main_wrapper">
          '.get_top_menu_HTML().'
          <div class="right_block">
            '.get_contact_html('phone', gf('cnt_phone', 18)).'
            '.($tg_login ? get_button([
              'icon' => 'telegram',
              'label' => 'В телеграм',
              'class' => 'telegram_button',
              'href' => 'https://t.me/'.gf('cnt_telegram', 18),
              'variant' => 'outline',
              'is_outside_link' => true
            ]) : '').'
          </div>
        </div>
        <button type="button" title="Mobile menu" id="menu_open" class="menu_open flc">'.get_svg('burger').'</button>
      </header>';
  }