<?php
  
  function get_theme_header(): string
  {
    return '
      <header class="theme_header">
        <div class="main_wrapper">
          <div class="label">Header</div>
          '.get_top_menu().'
        </div>
      </header>';
  }