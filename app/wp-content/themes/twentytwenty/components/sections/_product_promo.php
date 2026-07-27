<?php
  
  function _get_characteristics(int $page_id): string
  {
    if (!$data = gf('prd_characteristics_list', $page_id)) {
      return '';
    }
    
    $characteristics_html = '';
    
    foreach ($data as $item) {
      $characteristics_html .= '<li>
        <span class="label">'.$item['prd_chr_label'].': </span>
        <span class="description">'.$item['prd_chr_description'].'</span>
      </li>';
    }
    
    return '
      <div class="characteristics product_promo_block flcol">
        <h2 class="title">Характеристики</h2>
        <ul class="characteristics_list">
          '.$characteristics_html.'
        </ul>
      </div>';
  }
  
  function _get_types_application(int $page_id): string
  {
    if (!$data = gf('prd_types_application', $page_id)) {
      return '';
    }
    
    $types_application_html = '';
    
    foreach ($data as $index => $item) {
      $types_application_html .= '<span class="label">'.$item['prd_tps_type'].($index + 1 < count(
          $data
        ) ? ', ' : '').' </span>';
    }
    
    return '
      <div class="types_application product_promo_block flcol">
        <h2 class="title">Виды нанесения</h2>
        <div class="types_application_list">
          '.$types_application_html.'
        </div>
      </div>';
  }
  
  function _get_size_chart(int $page_id): string
  {
    if (!$size_chart_large = gf_img('prd_size_chart_image', $page_id)) {
      return '';
    }
    
    $is_hide = gf('prd_hide_chart_image', $page_id);
    
    $description_html = '';
    if ($sublabel = gf('prd_size_chart_description', $page_id)) {
      $description_html = '<div class="description">'.$sublabel.'</div>';
    }
    
    $show_button_html = $is_hide
      ? '<button class="show_chart_button" type="button" aria-label="fancybox button" data-fancybox="size_chart" data-src="'.$size_chart_large.'">'.get_svg('eye').'Смотреть сетку</button>'
      : '<img role="button" aria-label="fancybox button" src="'.$size_chart_large.'" data-fancybox="size_chart" data-src="'.$size_chart_large.'" class="size_chart_image" alt="Размерная сетка">';
    
    return '
      <div class="size_chart product_promo_block flcol">
        <h2 class="title">Размерная сетка</h2>
        '.$description_html.'
        '.$show_button_html.'
      </div>';
  }
  
  
  function _get_main_image_preview_html(int $page_id): string
  {
    $preview_img = wp_get_attachment_image_url(get_post_thumbnail_id($page_id), 'img500');
    $preview_img_thumbnail = wp_get_attachment_image_url(get_post_thumbnail_id($page_id));
    $additional_images = gf('prd_images', $page_id);
    
    $slides_html = $preview_img_thumbnail ? '<button class="swiper-slide bgc active" type="button" data-full="'.$preview_img.'" style="background-image: url('.$preview_img_thumbnail.')"></button>' : '';
    
    if (isset($additional_images) && count($additional_images) > 0) {
      foreach ($additional_images as $image) {
        $slides_html .= '<button class="swiper-slide bgc" type="button" data-full="'.$image['prd_img_image']['url'].'" style="background-image: url('.$image['prd_img_image']['sizes']['thumbnail'].')"></button>';
      }
    }
    
    return '
      <div id="merch_preview_block" class="merch_preview_block bgc">
        <button id="merch_preview_main_image" class="main_image bgc" type="button" aria-label="fancybox button" data-fancybox="gallery_promo_'.$page_id.'" data-src="'.$preview_img.'" style="background-image: url('.$preview_img.')"></button>
        <div class="merch_preview_slider_wrapper">
          <button type="button" class="navigation_button navigation_prev flc"></button>
          <div id="merch_preview_slider" class="merch_preview_slider swiper">
            <div class="swiper-wrapper">
              '.$slides_html.'
            </div>
          </div>
          <button type="button" class="navigation_button navigation_next flc"></button>
        </div>
      </div>';
  }
  
  
  function get_product_promo(int $page_id): string
  {
    return '
    <section id="product_promo" class="product_promo">
      <div class="main_wrapper">
        <h1 class="section_title inverse">'.gf('prd_label', $page_id).'</h1>
        <div class="code">Код товара: '.gf('prd_code', $page_id).'</div>
        <div class="product_preview">
          '._get_main_image_preview_html($page_id).'
          <div class="characteristics_wrapper flcol gap_block">
            '._get_characteristics($page_id).'
            '._get_types_application($page_id).'
            '._get_size_chart($page_id).'
          </div>
        </div>
      </div>
    </section>';
  }
