<?php
  
  class Api_Helper
  {
    
    function __construct()
    {
    }
    
    public function public_route(string $route, array $callback)
    {
      register_rest_route('/rest', $route, [
        [
          'methods' => [WP_REST_Server::CREATABLE, WP_REST_Server::READABLE],
          'callback' => $callback,
          'permission_callback' => '__return_true',
        ]
      ]);
    }
    
    /**
     * Формирует стандартизированный ответ API
     *
     * @param  array|null  $data  Основные данные ответа
     * @param  array|null  $settings  Настройки ответа (ошибки, редирект и т.д.)
     * @return array Стандартизированный ответ
     */
    public function response(
      ?array $data = null,
      ?array $settings = null,
    ): array {
      $errors = $settings['errors'] ?? null;
      $redirect = $settings['redirect'] ?? null;
      
      $result = match (true) {
        !empty($errors) => 'errors',
        !empty($redirect) => 'redirect',
        !empty($settings['logout'] ?? null) => 'logout',
        !empty($settings['notfound'] ?? null) => 'notfound',
        default => 'ok',
      };
      
      $response = [
        'result' => $result,
        'data' => ($result === 'ok') ? $data : null,
      ];
      
      if ($result === 'errors') {
        $response['errors'] = isset($errors['code']) ? [$errors] : $errors;
      }
      
      if ($result === 'redirect') {
        $response['redirectUrl'] = $redirect;
      }
      
      return $response;
    }
    
    /**
     * Создает массив с описанием ошибки
     *
     * @param  string  $code  Код ошибки
     * @param  string|null  $field_name  Название поля (если ошибка связана с конкретным полем)
     * @param  string|null  $add_info  Дополнительная информация об ошибке
     * @return array Структурированное описание ошибки
     */
    public function set_error(string $code, ?string $field_name = null, ?string $add_info = null): array
    {
      return [
        'code' => $code,
        ...($field_name !== null ? ['fieldName' => $field_name] : []),
        ...($add_info !== null ? ['addInfo' => $add_info] : []),
      ];
    }
    
    public function get_user_ip(): string
    {
      $ip = '';
      
      switch (true) {
        case isset($_SERVER['HTTP_CF_CONNECTING_IP']):
          $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
          break;
        
        case isset($_SERVER['HTTP_X_FORWARDED_FOR']):
          $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
          break;
        
        case isset($_SERVER['HTTP_X_REAL_IP']):
          $ip = $_SERVER['HTTP_X_REAL_IP'];
          break;
        
        case isset($_SERVER['REMOTE_ADDR']):
          $ip = $_SERVER['REMOTE_ADDR'];
          break;
      }
      
      return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : '0.0.0.0';
    }
  }
