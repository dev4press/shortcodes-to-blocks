<?php

namespace Dev4Press\Plugin\ShortcodesToBlocks\Basic;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Blocks {
	public function __construct() {
	}

	/**
	 * Return instance of the Blocks object.
	 *
	 * @return Blocks
	 */
	public static function instance() : Blocks {
		static $instance = null;

		if ( ! isset( $instance ) ) {
			$instance = new Blocks();
			$instance->run();
		}

		return $instance;
	}

	/**
	 * Main Blocks class entry point, add new block category and register blocks
	 */
	private function run() {
		add_filter( 'block_categories', array( $this, 'categories' ) );
		add_action( 'init', array( $this, 'blocks' ), 30 );
	}

	/**
	 * Add new blocks category to use for our shortcodes. This is optional step.
	 *
	 * @param array $categories
	 *
	 * @return array
	 */
	public function categories( $categories ) : array {
		return array_merge(
			$categories,
			array(
				array(
					'slug'  => 'shortcodesblocks',
					'title' => __( 'ShortcodesBlocks', 'shortcodes-to-blocks' )
				)
			)
		);
	}

	/**
	 * Register blocks script, translations for it and register blocks.
	 */
	public function blocks() {
		$this->_register_script();
		$this->_register_notice_block();
		$this->_register_meta_block();
	}

	/**
	 * Register JavaScript code with the blocks. And, load translations for it.
	 */
	private function _register_script() {
		/* load generated asset file to get JavaScript dependencies and various */
		$asset_file = include( SHORTCODES_TO_BLOCKS_PATH . 'build/index.asset.php' );

		/* register generated blocks JavaScript file using previously loaded assets */
		wp_register_script( 'shortcodes-to-blocks-editor', SHORTCODES_TO_BLOCKS_URL . 'build/index.js', $asset_file['dependencies'], $asset_file['version'] );

		/* set the translations domain and link it to the blocks script */
		wp_set_script_translations( 'shortcodes-to-blocks-editor', 'shortcodes-to-blocks' );
	}

	/**
	 * Register block for 'press-notice'.
	 *
	 * The attributes listed here must be a match to the attributes listed in the JavaScript file for this block.
	 * Block definition (name, title, description, category, icon) can be listed here and in JavaScript file, but it
	 * can be listed in one place only, it doesn't need to be in both.
	 *
	 * Value for render_callback HAS to be listed here only, it can't be in the JavaScript block code.
	 * Values for editor_script and editor_style also have to be listed here only, not in JavaScript block code.
	 */
	private function _register_notice_block() {
		register_block_type( 'shortcodes-to-blocks/press-notice', array(
			'apiVersion'      => 2,
			'name'            => 'shortcodes-to-blocks/press-notice',
			'title'           => __( 'Press Notice', 'shortcodes-to-blocks' ),
			'description'     => __( 'Display simple notice.', 'shortcodes-to-blocks' ),
			'category'        => 'shortcodesblocks',
			'icon'            => 'warning',
			'render_callback' => array( $this, 'callback_notice' ),
			'attributes'      => array(
				'text'               => array(
					'type'    => 'string',
					'default' => 'This is just a notice.'
				),
				'icon'               => array(
					'type'    => 'string',
					'enum'    => array(
						'warning',
						'info',
						'yes-alt',
						'star-filled',
						'flag'
					),
					'default' => 'warning'
				),
				'class'              => array(
					'type'    => 'string',
					'default' => ''
				),
				'varFontSize'        => array(
					'type'    => 'integer',
					'default' => 16,
					'minimal' => 1
				),
				'varLineHeight'      => array(
					'type'    => 'string',
					'default' => ''
				),
				'varColorBackground' => array(
					'type'    => 'string',
					'default' => ''
				),
				'varColorText'       => array(
					'type'    => 'string',
					'default' => ''
				),
				'varColorBorder'     => array(
					'type'    => 'string',
					'default' => ''
				)
			),
			'textdomain'      => 'shortcodes-to-blocks',
			'editor_script'   => 'shortcodes-to-blocks-editor',
			'editor_style'    => 'shortcodes-to-blocks'
		) );
	}

	/**
	 * Register block for 'press-meta'.
	 *
	 * The attributes listed here must be a match to the attributes listed in the JavaScript file for this block.
	 * Block definition (name, title, description, category, icon) can be listed here and in JavaScript file, but it
	 * can be listed in one place only, it doesn't need to be in both.
	 *
	 * Value for render_callback HAS to be listed here only, it can't be in the JavaScript block code.
	 * Values for editor_script and editor_style also have to be listed here only, not in JavaScript block code.
	 */
	private function _register_meta_block() {
		register_block_type( 'shortcodes-to-blocks/press-meta', array(
			'apiVersion'      => 2,
			'name'            => 'shortcodes-to-blocks/press-meta',
			'title'           => __( 'Press Meta', 'shortcodes-to-blocks' ),
			'description'     => __( 'Display simple notice.', 'shortcodes-to-blocks' ),
			'category'        => 'shortcodesblocks',
			'icon'            => 'menu-alt',
			'render_callback' => array( $this, 'callback_meta' ),
			'attributes'      => array(
				'title'           => array(
					'type'    => 'string',
					'default' => 'This is just a notice.'
				),
				'class'           => array(
					'type'    => 'string',
					'default' => ''
				),
				'showSiteAdmin'   => array(
					'type'    => 'boolean',
					'default' => true
				),
				'showProfileEdit' => array(
					'type'    => 'boolean',
					'default' => true
				),
				'showLogIn'       => array(
					'type'    => 'boolean',
					'default' => true
				),
				'showLogOut'      => array(
					'type'    => 'boolean',
					'default' => true
				),
				'showRegister'    => array(
					'type'    => 'boolean',
					'default' => true
				),
				'showHomePage'    => array(
					'type'    => 'boolean',
					'default' => true
				),
				'showRSSPosts'    => array(
					'type'    => 'boolean',
					'default' => true
				),
				'showRSSComments' => array(
					'type'    => 'boolean',
					'default' => true
				)
			),
			'textdomain'      => 'shortcodes-to-blocks',
			'editor_script'   => 'shortcodes-to-blocks-editor',
			'editor_style'    => 'shortcodes-to-blocks'
		) );
	}

	/**
	 * Block attributes names can be different than attributes for the shortcodes. This function
	 * changes the attributes names to match the shortcodes functions. We are also setting '_source'
	 * attribute to 'block' to changes the rendered shortcode class to make the difference between
	 * shortcode and block.
	 *
	 * Also, font size value is missing the 'px', it has only value when set in the block attribute.
	 *
	 * @param string[] $attributes
	 *
	 * @return string[]
	 */
	private function normalize_attributes( $attributes ) : array {
		$output = array(
			'_source' => 'block'
		);

		$map = array(
			'varLineHeight'      => 'var-line-height',
			'varFontSize'        => 'var-font-size',
			'varColorBackground' => 'var-color-background',
			'varColorText'       => 'var-color-text',
			'varColorBorder'     => 'var-color-border',
			'showSiteAdmin'      => 'show-site-admin',
			'showProfileEdit'    => 'show-profile-edit',
			'showLogIn'          => 'show-log-in',
			'showLogOut'         => 'show-log-out',
			'showRegister'       => 'show-register',
			'showHomePage'       => 'show-home-page',
			'showRSSPosts'       => 'show-rss-posts',
			'showRSSComments'    => 'show-rss-comments'
		);

		foreach ( $attributes as $key => $value ) {
			$new_key            = $map[ $key ] ?? $key;
			$output[ $new_key ] = $value;
		}

		if ( ! empty( $output['var-font-size'] ) ) {
			$output['var-font-size'] = $output['var-font-size'] . 'px';
		}

		return $output;
	}

	/**
	 * Callback method for the 'press-notice' block as defined for this block. The method is called by the
	 * Block Editor Server Side Rendering component, and it has all the block attributes as parameter.
	 *
	 * @param array $attributes
	 *
	 * @return string
	 */
	public function callback_notice( $attributes ) : string {
		$atts = $this->normalize_attributes( $attributes );

		return Shortcodes::instance()->shortcode_notice( $atts );
	}

	public function callback_meta( $attributes ) : string {
		$atts = $this->normalize_attributes( $attributes );

		return Shortcodes::instance()->shortcode_meta( $atts );
	}
}