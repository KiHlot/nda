<?php
  
  function get_product_slides_html(array $posts, bool $is_link_preview = false)
  {
    $slides_list_html = '';
    
    foreach ($posts as $post_id) {
      $preview_img = wp_get_attachment_image_url(get_post_thumbnail_id($post_id), 'img350');
      $main_image = '';
      
      $additional_images = gf('prd_images', $post_id);
      
      $additional_images_html = '';
      if (!$is_link_preview && isset($additional_images) && count($additional_images) > 0) {
        $main_image = $additional_images[0]['prd_img_image']['url'];
        
        if (count($additional_images) > 1) {
          foreach ($additional_images as $index => $image) {
            if ($index === 0) {
              continue;
            }
            
            $img_url = esc_url($image['prd_img_image']['url']);
            $additional_images_html .= '<span data-fancybox="gallery_'.$post_id.'" class="additional_images" data-src="'.$img_url.'"></span>';
          }
        }
      }
      
      $label = gf('prd_label', $post_id);
      $prise = gf('prd_prise', $post_id);
      $page_link = get_permalink($post_id);
      
      $images_preview_html = $is_link_preview
        ? '<div class="images_list">
            <a href="'.get_the_permalink($post_id).'" class="image bgc" style="background-image: url('.$preview_img.')"></a>
          </div>'
        : '<div class="images_list">
            <button aria-label="fancybox button" type="button" data-fancybox="gallery_'.$post_id.'" data-src="'.$main_image.'" class="image bgc" style="background-image: url('.$preview_img.')"></button>
            '.$additional_images_html.'
          </div>';
      
      $slides_list_html .= '
        <div class="swiper-slide flcol">
          '.$images_preview_html.'
          <div class="content_wrapper flcol">
            <a href="'.$page_link.'">'.$label.'</a>
            <div class="prise">'.$prise.'</div>
          </div>
        </div>';
    }
    
    return $slides_list_html;
  }
  
  function get_products_slider(array $posts)
  {
    if (!isset($posts)) {
      return '';
    }
    
    return '
      <div class="products_slider_wrapper">
        <button type="button" class="navigation_button navigation_prev"></button>
          <div class="products_slider swiper">
            <div class="swiper-wrapper">
              '.get_product_slides_html($posts).'
            </div>
          </div>
        <button type="button" class="navigation_button navigation_next"></button>
      </div>';
  }