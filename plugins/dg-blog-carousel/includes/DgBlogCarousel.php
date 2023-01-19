<?php

class DGBC_DgBlogCarousel extends DiviExtension {

	/**
	 * The gettext domain for the extension's translations.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $gettext_domain = 'dgbc-dg-blog-carousel';

	/**
	 * The extension's WP Plugin name.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $name = 'dg-blog-carousel';

	/**
	 * The extension's version
	 *
	 * @since 1.0.11
	 *
	 * @var string
	 */
	public $version = '1.0.15';

	/**
	 * DGBC_DgBlogCarousel constructor.
	 *
	 * @param string $name
	 * @param array  $args
	 */
	public function __construct( $name = 'dg-blog-carousel', $args = array() ) {
		$this->plugin_dir     = plugin_dir_path( __FILE__ );
		$this->plugin_dir_url = plugin_dir_url( $this->plugin_dir );

		parent::__construct( $name, $args );
	}
}

new DGBC_DgBlogCarousel;
