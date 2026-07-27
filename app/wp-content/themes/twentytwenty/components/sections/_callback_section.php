<?php
  
  function get_callback_section(int $page_id, bool $is_inverted = false): string
  {
    $contacts_page_id = 18;
    $is_contacts_page = $contacts_page_id === $page_id;
    
    $add_text = gf('cnt_add_text', $contacts_page_id);
    $departments = gf('cnt_departaments', $contacts_page_id);
    $address = gf('cnt_address', $contacts_page_id);
    $legal_name = gf('cnt_legal_name', $contacts_page_id);
    $legal_details = gf('cnt_legal_details', $contacts_page_id);
    
    $departments_list_html = '';
    
    $legal_file = gf('cnt_legal_file', $contacts_page_id);
    $legal_file_html = $legal_file ? '<a href="'.$legal_file.'" class="legal_file" target="_blank" rel="noopener noreferrer">Скачать реквизиты</a>' : '';
    
    if (!empty($departments)) {
      foreach ($departments as $department) {
        $department_row = '';
        foreach ($department['cnt_dep_contacts'] as $department_item) {
          $department_row .= '<div class="department_row '.($is_inverted ? 'inverted' : '').'">
              <div class="name">'.$department_item['cnt_dep_cnt_type']['label'].':</div>
              '.get_contact_html(
              $department_item['cnt_dep_cnt_type']['value'],
              $department_item['cnt_dep_cnt_value']
            ).'
          </div>';
        }
        
        $departments_list_html .= '
          <div class="department flcol">
            <div class="department_label">'.$department['cnt_dep_label'].'</div>
            '.$department_row.'
          </div>';
      }
      
      $departments_list_html = '<div class="department_list flcol gap_block">'.$departments_list_html.'</div>';
    }
    
    return '
			<section id="callback_section" class="callback_section pd_com flcol gap_block '.($is_inverted ? 'inverted' : '').'">
        '.($is_contacts_page ? get_breadcrumbs(true) : '').'
        <div class="main_wrapper sides">
          <div class="left_side">
            <div class="content_wrapper">
              <div class="add_text">'.$add_text.'</div>
              '.$departments_list_html.'
              <div class="address"><span>Адрес: </span>'.$address.'<br/>'.$legal_name.'</div>
              <div class="soclinks '.($is_inverted ? 'inverted' : '').'">
                '.get_contact_html('instagram', gf('cnt_instagram', $contacts_page_id), true).'
                '.get_contact_html('telegram', gf('cnt_telegram', $contacts_page_id), true).'
                '.get_contact_html('linkedin', gf('cnt_linkedin', $contacts_page_id), true).'
              </div>
            </div>
          </div>
          <div class="right_side">
            '.get_callback_form($is_inverted).'
          </div>
        </div>
        '.($is_contacts_page
        ? '<div class="main_wrapper legal flcol">
              <div class="label">Реквизиты</div>
              <div class="legal_details">'.$legal_details.'</div>
              '.$legal_file_html.'
           </div>'
        : '').'
			</section>
		';
  }