<?php
  
  if (strpos(get_home_url(), '.local') !== false) {
        ini_set('error_reporting', E_ALL);
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
    }
