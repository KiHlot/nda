<?php
  
  function get_posts_preview(): string
  {
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    
    $query = new WP_Query([
      'category_name' => 'stati',
      'posts_per_page' => 10,
      'post_type' => 'post',
      'post_status' => 'publish',
      'order' => 'DESC',
      'paged' => $paged,
    ]);
    
    wp_reset_postdata();
    
    $posts = $query->get_posts();
    
    if (!$posts) {
      return '';
    }
    
    $posts_result = '';
    
    foreach ($posts as $post) {
      $posts_result .= get_post_preview($post);
    }
    
    $pagination = paginate_links(array(
      'total' => $query->max_num_pages,
      'current' => $paged,
      'prev_text' => '« Назад',
      'next_text' => 'Вперед »',
    ));
    
    return '
      <section class="posts_preview">
        <div class="posts_list">
          '.$posts_result.'
        </div>
        <nav class="pagination">
          '.$pagination.'
        </nav>
      </section>';
  }