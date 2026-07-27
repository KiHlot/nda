<?php
  
  function get_callback_promo_section(int $page_id): string
  {
    return '
      <section id="callback_promo_section" class="callback_promo_section layout_section">
        <img class="main_image" src="'.gf_img('cnt_promo_image', $page_id, 'origin').'" alt="Жираф">
        <div class="title_block flc">
          <h1 class="title">'.gf('cnt_title', $page_id).'</h1>
        </div>
      </section>';
  }