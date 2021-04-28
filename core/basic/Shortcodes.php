<?php

namespace Dev4Press\Plugin\ShortcodesToBlocks\Basic;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Shortcodes {
	protected $id = 0;

	public function __construct() {
	}

	public static function instance() : Shortcodes {
		static $instance = null;

		if ( ! isset( $instance ) ) {
			$instance = new Shortcodes();
			$instance->run();
		}

		return $instance;
	}

	private function run() {
		add_action( 'shortcodes-to-blocks-init', array( $this, 'register' ) );
	}

	public function register() {
		add_shortcode( 'press-notice', array( $this, 'shortcode_notice' ) );
		//add_shortcode('press-notice', array($this, 'shortcode_notice'));
	}

	public function shortcode_notice( $atts = array() ) : string {
		$defaults = array(
			'_source'              => 'shortcode',
			'text'                 => 'This is just a notice.',
			'icon'                 => 'warning',
			'class'                => '',
			'var-color-background' => '',
			'var-color-border'     => '',
			'var-color-text'       => '',
			'var-font-size'        => '',
			'var-line-height'      => ''
		);

		$atts = shortcode_atts( $defaults, $atts );

		$classes = array(
			'press-notice-wrapper'
		);

		if ( ! empty( $atts['class'] ) ) {
			$classes[] = $atts['class'];
		}

		$id = 'press-notice-block-' . ( ++ $this->id );

		$render = '<div class="wp-' . $atts['_source'] . '-press-notice">';
		$render .= '<div id="' . $id . '" class="' . join( ' ', $classes ) . '">';
		$render .= '<span class="dashicons dashicons-' . esc_attr( $atts['icon'] ) . '"></span>';
		$render .= $atts['text'];
		$render .= '</div>';
		$render .= $this->styling_notice( $id, $atts );
		$render .= '</div>';

		wp_enqueue_style( 'shortcodes-to-blocks' );

		return $render;
	}

	protected function styling_notice( $id, $args = array() ) : string {
		$vars      = array();
		$supported = array(
			'color-background',
			'color-border',
			'color-text',
			'font-size',
			'line-height'
		);

		foreach ( $supported as $key ) {
			if ( isset( $args[ 'var-' . $key ] ) && ! empty( $args[ 'var-' . $key ] ) ) {
				$vars[] = '--press-notice-' . $key . ': ' . $args[ 'var-' . $key ] . ';';
			}
		}

		if ( ! empty( $vars ) ) {
			return '<style>#' . $id . '{' . join( '', $vars ) . '}</style>';
		}

		return '';
	}
}