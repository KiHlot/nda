<?php
  
  function get_delivery_options_section(int $page_id): string
  {
    if (!$options_list = gf('div_options', $page_id)) {
      return '';
    }
    
    $options_block_data = [];
    
    foreach ($options_list as $faq) {
      $options_block_data[] = ['label' => $faq['div_opt_label'], 'content' => $faq['div_opt_content']];
    }
    
    return '
      <section id="delivery_options_section" class="delivery_options_section pd_com flcol gap_block">
        '.get_breadcrumbs().'
        <div class="main_wrapper flcol gap_block">
          <h2 class="section_title">'.gf('dlv_opt_label', $page_id).'</h2>
          '.get_faq_block($options_block_data).'
        </div>
      </section>';
  }