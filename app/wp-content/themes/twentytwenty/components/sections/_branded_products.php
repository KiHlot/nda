<?php
  
  function get_branded_products(int $page_id): string
  {
    return '
    <section id="branded_products" class="branded_products pd_com flcol gap_block">
      '.get_breadcrumbs().'
      <div class="main_wrapper flcol gap_block">
        <div class="section_title">'.gf('mrc_prb_title', $page_id).'</div>
          '.get_products().'
      </div>
    </section>';
  }