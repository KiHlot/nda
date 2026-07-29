<?php
  
  require_once ABSPATH.'wp-admin/includes/class-wp-list-table.php';
  
  class Likes_Widget_Table extends WP_List_Table
  {
    
    private $wpdb;
    private $table_name;
    
    public function __construct()
    {
      parent::__construct([
        'singular' => 'like_stat',
        'plural' => 'like_stats',
        'ajax' => false,
      ]);
      
      global $wpdb;
      $this->wpdb = $wpdb;
      $this->table_name = $wpdb->prefix.'likes_widget';
      $this->bulk_action_handler();
      
      add_screen_option('per_page', [
        'label' => 'Показывать на странице',
        'default' => 20,
        'option' => 'logs_per_page',
      ]);
      
      $this->prepare_items();
    }
    
    public function get_columns()
    {
      return [
        'post_id' => 'ID поста',
        'post_title' => 'Название',
        'likes' => 'Лайков (+)',
        'dislikes' => 'Дизлайков (-)',
        'balance' => 'Баланс',
        'total_votes' => 'Всего голосов',
      ];
    }
    
    public function get_sortable_columns()
    {
      return [
        'post_id' => array('post_id', true)
      ];
    }
    
    protected function column_default($item, $column_name)
    {
      return isset($item[$column_name]) ? esc_html($item[$column_name]) : '';
    }
    
    protected function column_post_title($item)
    {
      $title = empty($item['post_title']) ? '(без названия)' : $item['post_title'];
      $edit_link = get_edit_post_link($item['post_id']);
      
      return sprintf('<a href="%s" target="_blank">%s</a>', $edit_link, esc_html($title));
    }
    
    public function prepare_items()
    {
      $per_page = $this->get_items_per_page('likes_stats_per_page');
      $current_page = $this->get_pagenum();
      
      $orderby = isset($_GET['orderby']) && $_GET['orderby'] === 'post_id' ? 'post_id' : 'post_id';
      $order = isset($_GET['order']) && strtoupper($_GET['order']) === 'ASC' ? 'ASC' : 'DESC';
      
      $sql = "SELECT
                    post_id,
                    SUM(type) AS balance,
                    SUM(IF(type = 1, 1, 0)) AS likes,
                    SUM(IF(type = -1, 1, 0)) AS dislikes,
                    COUNT(*) AS total_votes
                FROM {$this->table_name}
                WHERE 1=1";
      $sql .= " GROUP BY post_id";
      $sql .= " ORDER BY $orderby $order";
      
      $count_sql = "SELECT COUNT(DISTINCT post_id) FROM ({$sql}) AS subquery";
      $total_items = (int)$this->wpdb->get_var($count_sql);
      
      $sql .= " LIMIT %d OFFSET %d";
      $sql = $this->wpdb->prepare($sql, $per_page, ($current_page - 1) * $per_page);
      
      $data = $this->wpdb->get_results($sql, ARRAY_A);
      
      if (!empty($data)) {
        $post_ids = array_column($data, 'post_id');
        $posts = get_posts([
          'post_type' => 'post',
          'post__in' => $post_ids,
          'numberposts' => -1,
          'suppress_filters' => false,
        ]);
        $titles = [];
        
        foreach ($posts as $post) {
          $titles[$post->ID] = $post->post_title;
        }
        
        foreach ($data as &$row) {
          $row['post_title'] = isset($titles[$row['post_id']]) ? $titles[$row['post_id']] : '';
        }
        
        unset($row);
      }
      
      $this->items = $data;
      
      $this->set_pagination_args([
        'total_items' => $total_items,
        'per_page' => $per_page,
        'total_pages' => ceil($total_items / $per_page),
      ]);
    }
  }