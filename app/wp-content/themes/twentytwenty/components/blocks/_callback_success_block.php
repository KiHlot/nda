<?php
function get_callback_success_block():string {
  $success_content = gf('scs_content', 'option');
  $add_content = gf('scs_additional_content', 'option');
  $image = gf_img('scs_image', 'option');
  
  return '<div style="display: none;" id="callback_success_block" class="callback_success_block">
    <img class="success_image" src="'.$image.'" alt="success">
    <div class="success_content flcol">
      <div class="content">'.$success_content.'</div>
      <div class="add_content">'.$add_content.' '.get_svg('love').'</div>
    </div>
  </div>';
}