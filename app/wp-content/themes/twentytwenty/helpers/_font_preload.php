<?php
	
	function do_font_preload(): string {
		return '
		<link rel="preload" href="' . get_template_directory_uri() . '/assets/fonts/InterRegular/InterRegular.woff2" as="font" type="font/woff2" crossorigin>
		<link rel="preload" href="' . get_template_directory_uri() . '/assets/fonts/InterBold/InterBold.woff2" as="font" type="font/woff2" crossorigin>';
	}
