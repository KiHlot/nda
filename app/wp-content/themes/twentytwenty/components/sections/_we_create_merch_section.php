<?php
  
  function _generate_products_list_HTML($products_list): string
  {
    $html = '';
    $product_count = count($products_list);
    $global_index = 1;
    
    for ($i = 0; $i < $product_count; $i += 4) {
      $html .= _generate_product_group_HTML(array_slice($products_list, $i, 4), $global_index);
      $global_index += min(4, count(array_slice($products_list, $i, 4)));
    }
    
    return $html;
  }
  
  function _generate_product_group_HTML($group_products, &$start_index): string
  {
    $html = '';
    $group_count = count($group_products);
    $current_index = $start_index;
    
    if ($group_count >= 1) {
      $product1 = $group_products[0];
      $html .= _generate_product_inline_HTML($product1, false, $current_index);
      $current_index++;
    }
    
    if ($group_count >= 3) {
      // Блок с 2 и 3 продуктом
      $product2 = $group_products[1];
      $product3 = $group_products[2];
      $html .= _generate_product_block_HTML($product2, $product3, $current_index);
      $current_index += 2;
    }
    
    if ($group_count >= 4) {
      // Четвертый продукт в группе
      $product4 = $group_products[3];
      $html .= _generate_product_inline_HTML($product4, true, $current_index);
      $current_index++;
    }
    
    // Обработка случая, когда в группе только 2 продукта
    if ($group_count == 2) {
      $product2 = $group_products[1];
      $html .= _generate_product_inline_HTML($product2, true, $current_index);
    }
    
    return $html;
  }
  
  function _generate_product_inline_HTML($product, $reversed = false, $index = 1): string
  {
    $content_html = '
      <div class="content flcol '.($index % 2 === 0 ? 'first_width' : 'second_width').'">
        <div class="product_number flc">'.$index.'</div>
        <h3>'.$product['wcm_pl_label'].'</h3>
        <div class="description_wrapper">
          <div class="description">'.($product['wcm_pl_content'] ?? '').'</div>
          <a href="'.$product['wcm_pl_qr_link'].'" class="qr_code_wrapper">
            <div class="qr_code bgc" style="background-image: url('.$product['wcm_pl_qr']['sizes']['medium'].')"></div>
            <div class="text">'.$product['wcm_pl_qr_text'].'</div>
          </a>
        </div>
      </div>';
    $image_wrapper_html = '<div class="image_wrapper bgc '.($index % 2 === 0 ? 'second_width' : 'first_width').'" style="background-image: url('.$product['wcm_pl_image']['sizes']['img900'].')"></div>';
    
    if ($reversed) {
      return '
        <div class="product_inline reversed">
            '.$content_html.'
            '.$image_wrapper_html.'
        </div>';
    }
    
    return '<div class="product_inline">
        '.$image_wrapper_html.'
        '.$content_html.'
    </div>';
  }
  
  function _generate_product_block_HTML($product2, $product3, $start_index): string
  {
    $index2 = $start_index;
    $index3 = $start_index + 1;
    
    return '
    <div class="block">
        <div class="column flcol first_width gap_block">
            <div class="content">
                <div class="product_number flc lb">'.$index2.'</div>
                <h3>'.$product2['wcm_pl_label'].'</h3>
                <div class="description_wrapper">
                  <div class="description">'.($product2['wcm_pl_content'] ?? '').'</div>
                  <a href="'.$product2['wcm_pl_qr_link'].'" class="qr_code_wrapper">
                    <div class="qr_code bgc" style="background-image: url('.$product2['wcm_pl_qr']['sizes']['medium'].')"></div>
                    <div class="text">'.$product2['wcm_pl_qr_text'].'</div>
                  </a>
                </div>
            </div>
            <div class="image_wrapper bgc" style="background-image: url('.$product3['wcm_pl_image']['sizes']['img900'].')"></div>
        </div>
        <div class="column flcol second_width gap_block">
            <div class="image_wrapper bgc" style="background-image: url('.$product2['wcm_pl_image']['sizes']['img900'].')"></div>
            <div class="content">
                <div class="product_number flc">'.$index3.'</div>
                <h3>'.$product3['wcm_pl_label'].'</h3>
                <div class="description_wrapper">
                  <div class="description">'.($product3['wcm_pl_content'] ?? '').'</div>
                  <a href="'.$product3['wcm_pl_qr_link'].'" class="qr_code_wrapper">
                    <div class="qr_code bgc" style="background-image: url('.$product3['wcm_pl_qr']['sizes']['medium'].')"></div>
                    <div class="text">'.$product3['wcm_pl_qr_text'].'</div>
                  </a>
                </div>
            </div>
        </div>
    </div>';
  }
  
  function get_we_create_merch_section(int $page_id): string
  {
    $products_list = gf('wcm_products_list', $page_id);
    
    if (!$products_list) {
      return '';
    }
    
    $products_list_HTML = _generate_products_list_HTML($products_list);
    
    if (!$products_list_HTML) {
      return '';
    }
    
    return '
      <section id="we_create_merch" class="we_create_merch_section pd_com">
        <div class="main_wrapper flcol">
          <h2 class="section_title">'.gf('wcm_title', $page_id).'</h2>
          <div class="products_container flcol gap_block">
            '.$products_list_HTML.'
          </div>
        </div>
      </section>
    ';
  }