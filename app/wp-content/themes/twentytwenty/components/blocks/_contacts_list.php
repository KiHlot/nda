<?php
  
  function get_contacts_list(bool $use_icon = true): string
  {
    $page_id = 18;
    $items = [];
    
    $contacts = [
      'phone' => ['field' => 'cnt_phone', 'icon' => 'phone', 'aria' => 'Позвонить'],
      'instagram' => ['field' => 'cnt_instagram', 'icon' => 'instagram', 'aria' => 'Instagram'],
      'telegram' => ['field' => 'cnt_telegram', 'icon' => 'telegram', 'aria' => 'Telegram'],
      'linkedin' => ['field' => 'cnt_linkedin', 'icon' => 'linkedin', 'aria' => 'LinkedIn'],
    ];
    
    foreach ($contacts as $type => $config) {
      $value = gf($config['field'], $page_id);
      if (empty($value)) {
        continue;
      }
      
      if ($use_icon) {
        $contact_html = get_contact_html($type, $value, true);
        preg_match('/href="([^"]+)"/', $contact_html, $matches);
        $url = $matches[1] ?? $value;
        
        $href = ($type === 'phone')
          ? 'href="'.esc_attr($url).'"'
          : 'href="'.esc_url($url).'" target="_blank" rel="noopener noreferrer"';
        
        $items[] = '<a '.$href.' aria-label="'.$config['aria'].'">'.get_svg($config['icon']).'</a>';
      } else {
        $items[] = get_contact_html($type, $value);
      }
    }
    
    return empty($items) ? '' : '<div class="contacts_list flcol flc">'.implode('', $items).'</div>';
  }