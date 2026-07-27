<?php
  
  function get_map_section(): string
  {
    if (!$map = gf('cnt_map_code', 18)) {
      return '';
    }
    
    return '
      <section id="map_section" class="map_section">
        <div id="map_overlay" class="map_overlay"></div>
          '.$map.'
      </section>';
  }