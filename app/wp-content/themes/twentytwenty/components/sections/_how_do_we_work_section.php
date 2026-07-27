<?php
  
  function get_how_do_we_work_section(int $page_id)
  {
    if (!$faq_list = gf('mrc_hdw_faq', $page_id)) {
      return '';
    }
    
    $faq_block_data = [];
    
    foreach ($faq_list as $faq) {
      $faq_block_data[] = ['label' => $faq['mrc_hdw_faq_label'], 'content' => $faq['mrc_hdw_faq_content']];
    }
    
    return '
    <section id="how_do_we_work_section" class="how_do_we_work_section pd_com" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('.gf_img(
        'mrc_hdw_background',
        $page_id,
        'origin'
      ).');">
      <div class="logo">'.get_svg('short_logo').'</div>
      <div class="main_wrapper">
        <h2 class="section_title">'.gf('mrc_hdw_title', $page_id).'</h2>
        '.get_faq_block($faq_block_data, false, true).'
      </div >
    </section > ';
  }