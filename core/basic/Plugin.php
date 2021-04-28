<?php

namespace Dev4Press\Plugin\ShortcodesToBlocks\Basic;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Plugin {
	public function __construct() {
	}

	public static function instance() : Plugin {
		static $instance = null;

		if ( ! isset( $instance ) ) {
			$instance = new Plugin();
			$instance->run();
		}

		return $instance;
	}

	private function run() {
		Shortcodes::instance();
		Blocks::instance();

		add_action( 'init', array( $this, 'styles' ) );
		add_action( 'init', array( $this, 'init' ), 20 );
	}

	public function styles() {
		wp_register_style( 'shortcodes-to-blocks', SHORTCODES_TO_BLOCKS_URL . 'css/shortcodes.css', array(), SHORTCODES_TO_BLOCKS_VERSION );
	}

	public function init() {
		do_action( 'shortcodes-to-blocks-init' );
	}
}
