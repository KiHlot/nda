<?php
function get_footer_section(){
  if ( is_404() ) {
    return '';
  }
  
  $page_id = 18;
  $address = gf('cnt_address', $page_id);
  $legal_name = gf('cnt_legal_name', $page_id);
  $phone = gf('cnt_phone', $page_id);
  $footer_bg = gf_img('footer_bg', 'option', 'origin');
  $menu_items = wp_get_nav_menu_items(5);
  $menu_list = '';

  foreach ((array)$menu_items as $menu_item) {
    $current_class = $page_id === intval($menu_item->object_id) ? 'current' : '';
    
    $menu_list .= '
				<li title="'.$menu_item->title.'">
          <a href="'.$menu_item->url.'" class="link '.$current_class.'">
            '.$menu_item->title.'
          </a>
        </li>';
  }
  
  return '
    <footer id="footer" class="footer bgc" style="background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('.$footer_bg.')">
      <div class="main_wrapper">
        <div class="column flcol legal">
          <span>'.$legal_name.'</span>
          <span>'.$address.'</span>
          <span>'.get_contact_html('phone', $phone).'</span>
        </div>
        <div class="column flc logo">'.get_svg('logo').'</div>
        <div class="column menu">
          <ul class="footer_menu flcol">
            '.$menu_list.'
          </ul>
      </div>
    </footer>';
}