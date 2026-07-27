<?php
  
  function get_callback_form(bool $is_inverted = false)
  {

    
    return '<form id="callback_form" class="callback_form '.($is_inverted ? 'inverted' : '').'">
      <div id="callback_form_anchor" class="callback_form_anchor"></div>
      <div class="form_content flcol">
          '.get_input([
          'name' => 'name',
          'placeholder' => 'Ваше имя',
          'label' => 'Введите ваше имя',
          'is_inverted' => $is_inverted
        ]).'
          '.get_input([
          'name' => 'phone',
          'placeholder' => '+375 29 *** ** **',
          'label' => 'Телефон для связи',
          'is_inverted' => $is_inverted
        ]).'
          '.get_input([
          'name' => 'message',
          'placeholder' => 'Опишите пожалуйста какой мерч вы хотите изготовить',
          'label' => 'Ваш запрос',
          'is_inverted' => $is_inverted
        ]).'
        '.get_button([
          'label' => 'Готово',
          'type' => 'submit',
          'class' => 'submit',
          'variant' => $is_inverted ? 'secondary' : 'main'
        ]).'
      </div>
    </form>';
  }