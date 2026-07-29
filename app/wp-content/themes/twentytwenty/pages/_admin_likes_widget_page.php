<?php

	add_filter('set_screen_option_'.'logs_per_page', function ($status, $option, $value) {
		return (int)$value;
	}, 10, 3);

	add_action('admin_menu', function () {
		$hook = add_menu_page(
			'Список лайков',
			'Список лайков',
			'manage_options',
			'page-slug',
			'table_page',
			'dashicons-products',
			100
		);
		
		add_action("load-$hook", 'table_page_load');
	});
	
	function table_page_load()
	{
		$GLOBALS['Likes_Widget_Table'] = new Likes_Widget_Table();
	}
	
	function table_page()
	{
		?>
		<div class="wrap">
			<h2>Список лайков</h2>
			<?php
				echo '<form action="" method="POST">';
				$GLOBALS['Likes_Widget_Table']->display();
				echo '</form>';
			?>
		</div>
		<?php
	}