<?php
  
  function get_breadcrumbs(bool $is_inverted = false): string
  {
    $merch_link = '';
    
    if (is_singular('merch')) {
      $merch_link = '<a href="/merch">Мерч</a>';
    }
    
    return '<div class="breadcrumbs_wrapper '.($is_inverted ? 'inverted' : '').'">
				<div class="main_wrapper">
          <div class="crumbs">
            <a href="/">Главная</a>
            '.$merch_link.'
            <span class="breadcrumb_last" aria-current="page">'.get_the_title(get_the_ID()).'</span>
          </div>
				</div>
			</div>';
  }