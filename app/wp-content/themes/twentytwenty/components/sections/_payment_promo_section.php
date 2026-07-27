<?php
  
  function get_payment_promo_section(int $page_id): string
  {

    return '
          <section id="payment_promo_section" class="payment_promo_section bgc" style="background-image: url('.gf_img(
        'dlv_background_image',
        $page_id,
        'origin'
      ).')">
        <div class="main_wrapper flc flcol gap_block">
          <h1 class="section_title">'.gf('dlv_title', $page_id).'</h1>
          <div class="subtitle">'.gf('dlv_subtitle', $page_id).'</div>
          '.get_button([
            'label' => gf('dlv_button_label', $page_id),
            'class' => 'promo_button open_contacts_form',
            'variant' => 'black',
          ]).'
        </div>
      </section>
		';
  }