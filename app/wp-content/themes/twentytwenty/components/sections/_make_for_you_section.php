<?php
  
  function get_make_for_you_section(int $page_id)
  {
    if (!$services = gf('mfy_services', $page_id)) {
      return '';
    }

    $left_bg = gf_img('mfy_left_bg', $page_id, 'origin');
    $right_bg = gf_img('mfy_right_bg', $page_id, 'origin');
    
    $services_list_html = '';
    foreach ($services as $item) {
      $services_list_html .= '<li>
          <span class="label">'.$item['mfy_srv_label'].'</span>
          <span class="content">'.$item['mfy_srv_content'].'</span>
        </li>';
    }
    $services_list_html = '<ul class="services_list flcol">'.$services_list_html.'</ul>';
    
    
    return '
			<section id="make_for_you_section" class="make_for_you_section">
        <div class="left_bg bgc" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('.$left_bg.');"></div>
        <div class="right_bg bgc" style="background-image: url('.$right_bg.')"></div>
        <div class="logo_wrapper flc">'.get_svg('logo_with_text').'</div>
        <div class="main_wrapper">
          <div class="content_wrapper flcol">
          <h2 class="section_title">'.gf('mfy_title', $page_id).'</h2>
            '.$services_list_html.'
          </div>
        </div>
        '.get_button([
          'label' => gf('mfy_button_label', $page_id),
          'class' => 'open_contacts_form',
        ]).'
			</section>
		';
  }