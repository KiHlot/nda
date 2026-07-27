<?php
  
  function get_contact_html(string $type, string $value, bool $use_icon = false): string
  {

    switch ($type) {
      case "phone":
        $trimmed = preg_replace("/[^0-9]/", '', $value);
        $label = $use_icon ? get_svg('phone') : $value;
        $result = '<a href="tel:+'.$trimmed.'">'.$label.'</a>';
        break;
      case "email":
        $label = $use_icon ? get_svg('email') : $value;
        $result = '<a href="mailto:'.$value.'" title="email">'.$label.'</a>';
        break;
      case "telegram":
        $full_url = str_starts_with($value, 'http') ? $value : 'https://t.me/'.ltrim($value, '@');
        $label = $use_icon ? get_svg('telegram') : _get_social_label($value, '@');
        $result = '<a href="'.$full_url.'" target="_blank" title="telegram" rel="noopener noreferrer">'.$label.'</a>';
        break;
      case "instagram":
        $full_url = str_starts_with($value, 'http') ? $value : 'https://instagram.com/'.ltrim($value, '@');
        $label = $use_icon ? get_svg('instagram') : _get_social_label($value, '@');
        $result = '<a href="'.$full_url.'" target="_blank" title="instagram" rel="noopener noreferrer">'.$label.'</a>';
        break;
      case "linkedin":
        if (str_starts_with($value, 'http')) {
          $full_url = $value;
        } elseif (str_starts_with($value, 'linkedin.com/') || str_starts_with($value, '/')) {
          $full_url = 'https://'.$value;
        } else {
          $full_url = 'https://linkedin.com/in/'.ltrim($value, '/@');
        }
        $label = $use_icon ? get_svg('linkedin') : _get_social_label($value);
        $result = '<a href="'.$full_url.'" target="_blank" title="linkedin" rel="noopener noreferrer">'.$label.'</a>';
        break;
      default:
        $label = $use_icon ? '' : $value;
        $result = '<a href="'.$value.'">'.$label.'</a>';
        break;
    }
    
    return $result;
  }
  
  function _get_social_label(string $value, string $prefix = ''): string
  {
    // Если есть @ в начале - оставляем его
    if (str_starts_with($value, '@')) {
      return $value;
    }
    
    // Если это URL - извлекаем имя
    if (str_starts_with($value, 'http')) {
      $parsed = parse_url($value);
      if (isset($parsed['path'])) {
        $path = ltrim($parsed['path'], '/');
        if ($path) {
          return $prefix.$path;
        }
      }
    }
    
    // Иначе добавляем префикс к значению
    return $prefix.ltrim($value, '/@');
  }