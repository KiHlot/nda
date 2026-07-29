<?php
  
  foreach (glob((dirname(__FILE__).'/class*.php')) as $file) {
    include_once $file;
  }
