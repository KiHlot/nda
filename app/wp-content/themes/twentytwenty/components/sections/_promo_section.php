<?php
  
  function get_promo_section(int $page_id)
  {
    $main_image = gf('man_promo_image', $page_id);
    $button_label = gf('man_promo_button_label', $page_id);
    $title = gf('man_promo_title', $page_id);
    
    return '
			<section id="promo_section" class="promo_section layout_section">
        <img src="'.$main_image['url'].'" class="main_image" alt="'.($main_image['alt']).'">
          '.get_button([
        'label' => $button_label,
        'class' => 'promo_button open_contacts_form',
      ]).'
          <div class="container flc">
            <h1 class="title">'.$title.'</h1>
          </div>
			</section>
		';
  }