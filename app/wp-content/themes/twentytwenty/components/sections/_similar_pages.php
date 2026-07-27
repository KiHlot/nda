<?php
  
  function get_similar_pages_section(int $page_id): string
  {
    $pages = get_similar_products_by_tags_weighted($page_id);
    
    if (empty($pages)) {
      return '';
    }

    return '<section id="similar_pages_section" class="similar_pages_section">
    <div class="main_wrapper flcol gap_block">
      <h2 class="section_title">Похожие товары</h2>
      <div id="similar_pages_slider" class="similar_pages_slider swiper">
        <div class="swiper-wrapper">
          '.get_product_slides_html($pages, true).'
        </div>
      </div>
    </div>
  </section>';
  }