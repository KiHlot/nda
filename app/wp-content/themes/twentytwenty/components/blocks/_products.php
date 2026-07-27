<?php
  
  function _get_sorted_data(): array|null
  {
    $query = new WP_Query([
      'posts_per_page' => -1,
      'post_type' => 'merch',
      'post_status' => 'publish',
      'orderby' => 'date',
      'order' => 'DESC',
    ]);
    
    $posts = $query->get_posts();
    
    if (!$posts) {
      return null;
    }
    
    $result = [];
    
    foreach ($posts as $post) {
      // Получаем рубрики (категории) поста
      $categories = wp_get_post_terms($post->ID, 'category');
      
      // Получаем типы продуктов
      $product_types = wp_get_post_terms($post->ID, 'merch_type');
      
      // Если нет рубрики или типа продукта - пропускаем
      if (empty($categories) || empty($product_types)) {
        continue;
      }
      
      // Берем первую рубрику
      $category = $categories[0];
      
      // Берем первый тип продукта
      $product_type = $product_types[0];
      
      // Используем slug как ключ для рубрики (безопаснее)
      $category_key = $category->slug;
      
      // Инициализируем массив для рубрики, если еще нет
      if (!isset($result[$category_key])) {
        $result[$category_key] = [
          'name' => $category->name,
          'slug' => $category->slug,
          'types' => []
        ];
      }
      
      // Используем slug как ключ для типа продукта
      $type_key = $product_type->slug;
      
      // Инициализируем массив для типа продукта в этой рубрике, если еще нет
      if (!isset($result[$category_key]['types'][$type_key])) {
        $result[$category_key]['types'][$type_key] = [
          'name' => $product_type->name,
          'slug' => $product_type->slug,
          'posts' => []
        ];
      }
      
      // Добавляем ID поста
      $result[$category_key]['types'][$type_key]['posts'][] = $post->ID;
    }
    return $result;
  }
  
  function _get_block_data(array $data): string
  {
    $posts = null;
    
    $navigation_html = '';
    $is_selected = false;
    
    foreach ($data['types'] as $slug => $item) {
      if (!$is_selected) {
        $posts = $item['posts'];
      }
      
      $navigation_html .= '<button data-posts="'.implode(
          ',',
          $item['posts']
        ).'" type="button" class="'.(!$is_selected ? 'selected' : '').'">'.$item['name'].'</button>';
      
      $is_selected = true;
    }
    
    return '
      <div class="block_data">
        <div class="navigation flcol">
          <h3 class="category_label">'.$data['name'].'</h3>
          <div class="buttons_list flcol">
            '.$navigation_html.'
          </div>
        </div>
        <div class="products_slider_block">'.get_products_slider($posts).'</div>
      </div>';
  }
  
  function get_products(): string
  {
    if (!$sorted_data = _get_sorted_data()) {
      return '';
    }
    
    $data_html = '';
    
    foreach ($sorted_data as $block_data) {
      $data_html .= _get_block_data($block_data);
    }
    
    return '<div class="products_wrapper flcol gap_block">'.$data_html.'</div>';
  }
  
  function change_product_type(): void
  {
    $posts = isset($_POST['posts']) ? explode(',', $_POST['posts']) : null;
    
    send_api(is_array($posts) ? get_products_slider($posts) : null);
  }