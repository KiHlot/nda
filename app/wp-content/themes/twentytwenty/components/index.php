<?php
	foreach (glob((dirname(__FILE__) . '/_*.php')) as $file) {
		include_once $file;
	}
	
	foreach (glob((dirname(__FILE__) . '/**/index.php')) as $file) {
		include_once $file;
	}