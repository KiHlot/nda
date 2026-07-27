<?php
  
  function get_page_404()
  {
    $tg_login = gf('cnt_telegram', 18);
    $main_image = gf('pnf_image', 'option');
    
    return '<div class="page_404">
      <div class="head_wrapper">
        '.get_main_logo().'
        '.($tg_login ? get_button([
        'icon' => 'telegram',
        'label' => 'В телеграм',
        'class' => 'telegram_button',
        'href' => 'https://t.me/'.gf('cnt_telegram', 18),
        'variant' => 'outline',
        'is_outside_link' => true
      ]) : '').'
      </div>
      <div class="main_wrapper flcol gap_block">
        <h1 class="section_title">'.gf('pnf_title', 'option').'</h1>
        <div class="marker">404</div>
        '.get_button([
        'label' => gf('pnf_button_label', 'option'),
        'class' => 'home_button',
        'href' => '/',
        'is_outside_link' => false,
        ]).'
      </div>
      <img class="main_image" src="'.$main_image['url'].'" alt="'.$main_image['alt'].'">
    </div>';
  }