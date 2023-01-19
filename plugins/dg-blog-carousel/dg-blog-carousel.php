<?php
/*
Plugin Name: Divi Blog Carousel
Plugin URI:  https://www.divigear.com/
Description: A Blog Carousel module for DIVI Theme
Version:     1.0.15
Author:      DiviGear
Author URI:  https://www.divigear.com/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: dgbc-dg-blog-carousel
Domain Path: /languages
*/


if ( ! function_exists( 'dgbc_initialize_extension' ) ):
/**
 * Creates the extension's main class instance.
 *
 * @since 1.0.0
 */
function dgbc_initialize_extension() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/DgBlogCarousel.php';
}
add_action( 'divi_extensions_init', 'dgbc_initialize_extension' );

function dgbc_scripts(){
    wp_enqueue_style('swipe-style', trailingslashit(plugin_dir_url(__FILE__)) .  'styles/swiper.min.css');
    wp_enqueue_script('swipe-script', trailingslashit(plugin_dir_url(__FILE__)) . 'scripts/swiper.min.js' , array('jquery'), '5.2.1', true );
}
add_action('wp_enqueue_scripts', 'dgbc_scripts');

endif;

define( "DGBC_MAIN_DIR", __DIR__ );

add_action ('after_setup_theme', 'dgbc_init');
function dgbc_init() {
    // include plugin settings
    require_once (__DIR__ . '/functions/functions.php');
    // include plugin settings
    require_once (__DIR__ . '/core/init.php');
}

