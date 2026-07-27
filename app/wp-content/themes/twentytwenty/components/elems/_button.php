<?php
  
  /**
   * @param  string  $label  Текст кнопки (обязательный)
   * @param  string  $class  Дополнительные CSS-классы
   * @param  string  $id  ID элемента
   * @param  string  $variant  Вариант стилизации (по умолчанию 'main')
   * @param  bool  is_outside_link
   * @param  string  $href  URL для ссылки (только если $is_link = true)
   * @param  string  $icon  Название иконки для функции get_svg()
   * @param  string  $data_label  Значение для data-label атрибута
   * @example get_button([
   *     'label' => 'Кнопка',
   *     'variant' => 'primary',
   *     'class' => 'btn',
   *     'icon' => 'arrow-right',
   *     'href' => 'https://example.com'
   *     'type' => 'https://example.com'
   * ])
   */
  function get_button(?array $data): string
  {
    if (empty($data) || empty($data['label'])) {
      return '';
    }
    
    $class = trim(($data['class'] ?? '').' '.($data['variant'] ?? 'main'));
    $id = $data['id'] ?? null;
    $tag = !empty($data['href']) ? 'a' : 'button';
    $icon = !empty($data['icon']) ? get_svg($data['icon']) : '';
    $type = !empty($data['type']) ? $data['type'] : '';
    
    $attributes = 'class="button '.$class.'"';
    
    if ($id) {
      $attributes .= ' id="'.esc_attr($id).'"';
    }
    
    if ($tag === 'a' && !empty($data['href'])) {
      $attributes .= ' href="'.esc_url($data['href']).'"';
    }
    
    if ($tag === 'a' && !!$data['is_outside_link']) {
      $attributes .= ' target="_blank" rel="nofollow noopener noreferrer"';
    }
    
    if (!empty($data['data_label'])) {
      $attributes .= ' data-label="'.esc_attr($data['data_label']).'"';
    }
    
    if ($tag !== 'a') {
      $attributes .= ' type="'.$type.'"';
    }
    
    return "<{$tag} {$attributes}>".$icon.esc_html($data['label'])."</{$tag}>";
  }