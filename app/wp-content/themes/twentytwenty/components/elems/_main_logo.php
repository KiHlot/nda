<?php
  
  function get_main_logo()
  {

    return is_front_page()
      ? '<span class="main_logo flc">'.get_svg('short_logo').'</span>'
      : '<a class="main_logo flc" href="/" aria-label="Главная">'.get_svg('short_logo').'</a>';
  }