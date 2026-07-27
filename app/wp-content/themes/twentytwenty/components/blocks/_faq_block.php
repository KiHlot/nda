<?php
  
  function get_faq_block(array $data, bool $is_reverse = false, bool $has_border = false): string
  {
    $content = '';
    
    foreach ($data as $index => $item) {
      $content .= '
        <li class="item flcol">
          <span class="index flc">'.($index + 1).'</span>
          <span class="label">'.$item['label'].'</span>
          <span class="content flcol">'.$item['content'].'</span>
        </li>';
    }
    
    return '<ul class="faq_block flcol '.($has_border ? 'has_border' : '').' '.($is_reverse ? 'reverse' : '').'">'.$content.'</ul>';
  }