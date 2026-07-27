<?php
  
  function get_payment_options_section(int $page_id): string
  {
    if (!$options_list = gf('div_options_payment', $page_id)) {
      return '';
    }
    
    $options_block_data = [];
    
    foreach ($options_list as $faq) {
      $options_block_data[] = ['label' => $faq['div_opt_pay_label'], 'content' => $faq['div_opt_pay_content']];
    }
    
    return '
      <section id="payment_options_section" class="payment_options_section pd_com">
        <div class="main_wrapper flcol gap_block">
          <h2 class="section_title inverse">'.gf('dlv_pay_label', $page_id).'</h2>
          '.get_faq_block($options_block_data, true, false).'
        </div>
      </section>';
  }