<?php

	function set_api_endpoint( string $name ): void {
		add_action( "wp_ajax_" . $name, $name );
		add_action( "wp_ajax_nopriv_" . $name, $name );
	}

	function send_api( mixed $data, string $result = 'ok' ): void {
		echo json_encode( [
			'result' => $result,
			'data'   => $data ?? null,
		], JSON_UNESCAPED_UNICODE );
		wp_die();
	}

	function send_error( mixed $exceptions ): void {
		echo json_encode( [
			'result' => 'error',
			'data'   => [
				'exceptions' => $exceptions
			],
		], JSON_UNESCAPED_UNICODE );
		wp_die();
	}

