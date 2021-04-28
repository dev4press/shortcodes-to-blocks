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
		/* load generated asset file to get JavaScript dependencies and various */
		$asset_file = include( SHORTCODES_TO_BLOCKS_PATH . 'build/index.asset.php' );

		/* register generated blocks JavaScript file using previously loaded assets */
		wp_register_script( 'shortcodes-to-blocks-editor', SHORTCODES_TO_BLOCKS_URL . 'build/index.js', $asset_file['dependencies'], $asset_file['version'] );

		/* set the translations domain and link it to the blocks script */
		wp_set_script_translations( 'shortcodes-to-blocks-editor', 'shortcodes-to-blocks' );

		/* register 'press-notice' block */
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
			'varColorBorder'     => 'var-color-border'
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

	public function callback_notice( $attributes ) : string {
		$atts = $this->normalize_attributes( $attributes );
		//print_r($attributes);

		//print_r($atts);
		return Shortcodes::instance()->shortcode_notice( $atts );
	}
}