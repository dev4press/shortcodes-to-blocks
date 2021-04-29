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
		add_shortcode( 'press-meta', array( $this, 'shortcode_meta' ) );
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

	public function shortcode_meta( $atts = array() ) : string {
		$defaults = array(
			'_source'           => 'shortcode',
			'title'             => 'Meta',
			'class'             => '',
			'show-site-admin'   => true,
			'show-profile-edit' => true,
			'show-log-in'       => true,
			'show-log-out'      => true,
			'show-register'     => true,
			'show-home-page'    => true,
			'show-rss-posts'    => true,
			'show-rss-comments' => true
		);

		$atts = shortcode_atts( $defaults, $atts );

		$lists = array(
			array(),
			array()
		);

		if ( is_user_logged_in() ) {
			if ( $atts['show-site-admin'] ) {
				$lists[0][] = '<a href="' . admin_url() . '">' . __( "Site Admin", "shortcodes-to-blocks" ) . '</a>';
			}

			if ( $atts['show-profile-edit'] ) {
				$lists[0][] = '<a href="' . admin_url( 'profile.php' ) . '">' . __( "Profile", "shortcodes-to-blocks" ) . '</a>';
			}

			if ( $atts['show-log-out'] ) {
				$lists[0][] = '<a href="' . wp_logout_url() . '">' . __( "Log Out", "shortcodes-to-blocks" ) . '</a>';
			}
		} else {
			if ( $atts['show-log-in'] ) {
				$lists[0][] = '<a href="' . wp_login_url() . '">' . __( "Log In", "shortcodes-to-blocks" ) . '</a>';
			}

			if ( $atts['show-register'] ) {
				$lists[0][] = '<a href="' . wp_registration_url() . '">' . __( "Register", "shortcodes-to-blocks" ) . '</a>';
			}
		}

		if ( $atts['show-home-page'] ) {
			$lists[1][] = '<a href="' . site_url() . '">' . __( "Home Page", "shortcodes-to-blocks" ) . '</a>';
		}

		if ( $atts['show-rss-posts'] ) {
			$lists[1][] = '<a href="' . get_bloginfo( 'rss2_url' ) . '">' . __( "Entries <abbr title='Really Simple Syndication'>RSS</abbr>", "shortcodes-to-blocks" ) . '</a>';
		}

		if ( $atts['show-rss-comments'] ) {
			$lists[1][] = '<a href="' . get_bloginfo( 'comments_rss2_url' ) . '">' . __( "Comments <abbr title='Really Simple Syndication'>RSS</abbr>", "shortcodes-to-blocks" ) . '</a>';
		}

		$classes = array(
			'press-meta-wrapper'
		);

		if ( ! empty( $atts['class'] ) ) {
			$classes[] = $atts['class'];
		}

		$blocks = array();

		if ( ! empty( $lists[0] ) ) {
			$blocks[] = '<div class="press-meta-links"><span>' . join( '</span><span>', $lists[0] ) . '</span></div>';
		}

		if ( ! empty( $lists[1] ) ) {
			$blocks[] = '<div class="press-meta-links"><span>' . join( '</span><span>', $lists[1] ) . '</span></div>';
		}

		$id = 'press-meta-block-' . ( ++ $this->id );

		$render = '<div class="wp-' . $atts['_source'] . '-press-notice">';
		$render .= '<div id="' . $id . '" class="' . join( ' ', $classes ) . '">';
		$render .= '<h4>' . $atts['title'] . '</h4>';
		$render .= join( '<hr/>', $blocks );
		$render .= '</div>';
		$render .= '</div>';

		wp_enqueue_style( 'shortcodes-to-blocks' );

		return $render;
	}

	private function styling_notice( $id, $args = array() ) : string {
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