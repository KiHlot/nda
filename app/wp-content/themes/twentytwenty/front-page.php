<?php $page_id = get_the_ID(); ?>
<?php get_header(); ?>
  <div class="main_layout">
    <div class="main_wrapper">
      <div class="layout_content">
	      <h1 class="layout_heading">Статьи</h1>
        <?php echo get_posts_preview(); ?>
      </div>
      <h2 class="layout_sidebar">Sidebar</h2>
    </div>
  </div>
<?php get_footer(); ?>