<?php
  
  function get_answers_questions_section(int $page_id)
  {
    if (!$accordion_list = gf('anq_list', $page_id)) {
      return '';
    }
    
    $data = [];
    
    foreach ($accordion_list as $item) {
      $data[] = ['question' => $item['anq_lst_question'], 'answer' => $item['anq_lst_answer']];
    }
    
    return '
    <section id="answers_questions_section" class="answers_questions_section pd_com">
      <div class="main_wrapper flcol gap_block">
        <h2 class="section_title inverse">'.gf('anq_title', $page_id).'</h2>
        '.get_accordion_block($data, true).'
      </div>
    </section>';
  }