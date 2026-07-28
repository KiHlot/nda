<?php
  
  function get_post_preview(WP_Post $post): string
  {
    $author_data = get_userdata($post->post_author);
    $image_url = get_the_post_thumbnail_url($post->ID, 'large');
    $excerpt = get_the_excerpt($post);
    $link = get_permalink($post);
    $title = $post->post_title;
    
    return '
      <div class="post_preview">
        <a href="'.$link.'" class="image" style="background-image: url('.$image_url.')" aria-label="'.$title.'"></a>
        <div class="content">
          <a href="'.$link.'">
            <h2 class="title">'.$title.'</h2>
          </a>
          <span class="description">'.$excerpt.'</span>
          <div class="preview_footer">
            <div class="author">Автор: <span>'.$author_data->display_name.'</span></div>
            '.get_likes_widget($post).'
          </div>
        </div>
      </div>';
  }