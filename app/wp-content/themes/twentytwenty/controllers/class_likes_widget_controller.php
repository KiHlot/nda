<?php
  
  class Likes_Widget_Controller extends WP_REST_Controller
  {
    private $wpdb;
    private readonly Api_Helper $api;
    private readonly string $base_route;
    private readonly string $table_name;
    
    public function __construct()
    {
      global $wpdb;
      $this->wpdb = $wpdb;
      $this->base_route = '/likes-widget';
      $this->api = new Api_Helper();
      $this->table_name = $wpdb->prefix.'likes_widget';
    }
    
    public function register_routes(): void
    {
      $this->api->public_route($this->base_route, [$this, 'update_like']);
    }
    
    public function get_total_likes(int|string $post_id): int
    {
      $result = $this->wpdb->get_var(
        $this->wpdb->prepare(
          "SELECT SUM(type) FROM {$this->table_name} WHERE post_id = %d",
          $post_id
        )
      );
      
      return $result !== null ? (int)$result : 0;
    }
    
    private function get_disabled_type(int $count): string|null
    {
      if (!$count) {
        return null;
      }
      
      return $count === 1 ? 'increment' : 'decrement';
    }
    
    public function get_user_likes_data_by_post_id(int|string $post_id, ?string $ip = null): ?stdClass
    {
      $user_ip = $ip ?: $this->api->get_user_ip();
      
      $data = $this->wpdb->get_row(
        $this->wpdb->prepare(
          "SELECT * FROM {$this->table_name} WHERE post_id = %d AND user_ip = %s",
          $post_id,
          $user_ip
        )
      );
      
      return $data ?: null;
    }
    
    public function update_like(WP_REST_Request $request)
    {

      $post_id = $request->get_param('postId');
      $type = $request->get_param('type');
      $page_url = $request->get_param('pageUrl');
      
      if (empty($post_id) || empty($type) || empty($page_url)) {
        return $this->api->response(null, ['errors' => [$this->api->set_error('Не хватает данных')]]);
      }
      
      if (!in_array($type, ['increment', 'decrement'])) {
        return $this->api->response(null, ['errors' => [$this->api->set_error('Не верное действие')]]);
      }
      
      $type_value = ($type === 'increment') ? 1 : -1;
      $user_ip = $this->api->get_user_ip();
      $old_db_data = $this->get_user_likes_data_by_post_id($post_id, $user_ip);
      
      if (isset($old_db_data->type)) {
        $old_type = intval($old_db_data->type);
        
        if ($old_type === $type_value) {
          return $this->api->response(['count' => $this->get_total_likes($post_id)]);
        }
        
        $type_value = $old_type + $type_value;
      }
      
      $result = $this->wpdb->replace(
        $this->table_name,
        [
          'post_id' => $post_id,
          'user_ip' => $user_ip,
          'type' => $type_value,
          'page_url' => $page_url,
        ],
        ['%d', '%s', '%d', '%s']
      );
      
      if ($result === false) {
        return $this->api->response(null, ['errors' => [$this->api->set_error('Не удалось обновить БД')]]);
      }
      
      return $this->api->response(
        [
          'count' => $this->get_total_likes($post_id),
          'disabledType' => $this->get_disabled_type($type_value)
        ]
      );
    }
    
    public function create_likes_widget_db(): void
    {
      if (get_option('likes_widget') === 'completed') {
        return;
      }

      require_once(ABSPATH.'wp-admin/includes/upgrade.php');
      
      $table_name = $this->table_name;
      $charset_collate = $this->wpdb->get_charset_collate();
      
      $sql = "CREATE TABLE $table_name (
        post_id bigint(20) UNSIGNED NOT NULL,
        user_ip varchar(45) NOT NULL,
        type tinyint NOT NULL,
        page_url varchar(255) NOT NULL,
        liked_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (post_id, user_ip)
    ) $charset_collate;";
      
      dbDelta($sql);
      
      update_option('likes_widget', 'completed');
    }
    
  }