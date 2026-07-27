<?php
  
  function get_accordion_block(array $data, bool $is_reversed = false): string
  {
    $items = '';
    
    foreach ($data as $item) {
      $items .= '<div class="accordion_item">
      <button type="button" class="acc_label">'.$item['question'].'</button>
      <div class="acc_desc">
        <span>'.$item['answer'].'</span>
      </div>
    </div>';
    }
    
    return '<div class="accordion_wrapper flcol '.($is_reversed ? 'reversed' : '').'">'.$items.'</div>';
  }