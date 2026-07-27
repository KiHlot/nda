<?php
	
	function do_font_preload(): string {
		return '
		<link rel="preload" href="' . get_template_directory_uri() . '/assets/fonts/UbuntuRegular/UbuntuRegular.woff2" as="font" type="font/woff2" crossorigin>
		<link rel="preload" href="' . get_template_directory_uri() . '/assets/fonts/UbuntuLight/UbuntuLight.woff2" as="font" type="font/woff2" crossorigin>
		<link rel="preload" href="' . get_template_directory_uri() . '/assets/fonts/UbuntuMedium/UbuntuMedium.woff2" as="font" type="font/woff2" crossorigin>
		<link rel="preload" href="' . get_template_directory_uri() . '/assets/fonts/UbuntuBold/UbuntuBold.woff2" as="font" type="font/woff2" crossorigin>';
	}
