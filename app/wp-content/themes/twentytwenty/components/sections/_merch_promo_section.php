<?php
  
  function get_merch_promo_section(int $page_id)
  {
    return '
    <section id="merch_promo_section" class="merch_promo_section bgc" style="background-image: url('.gf_img(
        'mrc_background_image',
        $page_id,
        'origin'
      ).')">
      <div class="main_wrapper flcol flc gap_block">
        <h1 class="section_title">'.gf('mrc_title', $page_id).'</h1>
        <div class="subtitle">'.gf('mrc_subtitle', $page_id).'</div>
                    '.get_button([
        'label' => gf('mrc_button_label', $page_id),
        'class' => 'promo_button open_contacts_form',
      ]).'
      </div>
    </section>';
  }