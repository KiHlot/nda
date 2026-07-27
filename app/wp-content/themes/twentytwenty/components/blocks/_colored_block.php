<?php
function get_colored_block(){
  return '<div class="colored_block bgc" style="background-image: url('.gf_img(
      'clb_background_image',
      'option',
      'origin'
    ).')"></div>';
}