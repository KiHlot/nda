<?php
  
  function get_visited_pages_section(): string
  {
    $pages = get_visited_pages();
    
    if (empty($pages)) {
      return '';
    }

    return '<section id="visited_pages_section" class="visited_pages_section">
    <div class="main_wrapper flcol gap_block">
      <h2 class="section_title">Просмотренные ранее</h2>
      <div id="visited_pages_slider" class="visited_pages_slider swiper">
        <div class="swiper-wrapper">
          '.get_product_slides_html($pages, true).'
        </div>
      </div>
    </div>
  </section>';
  }