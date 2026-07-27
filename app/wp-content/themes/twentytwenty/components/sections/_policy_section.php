<?php
  
  function get_policy_section(int $page_id): string
  {
    return '<section id="policy_section" class="policy_section pd_com flcol gap_block">
      '.get_breadcrumbs(true).'
      <div class="main_wrapper">
        <div class="the_content">
          '.gf('prp_content', $page_id).'
        </div>
      </div>
    </section>';
  }