<?php
function my_theme_enqueue_styles() { 
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

add_filter( 'big_image_size_threshold', '__return_false' );


/*
================================================ 
#Load custom Blog Module 
================================================
*/ 

function divi_custom_blog_module() { 
get_template_part( '/includes/Blog' ); 
$dcfm = new custom_ET_Builder_Module_Blog(); 
remove_shortcode( 'et_pb_blog' ); 
add_shortcode( 'et_pb_blog', array( $dcfm, '_shortcode_callback' ) ); } 

add_action( 'et_builder_ready', 'divi_custom_blog_module' ); 

function divi_custom_blog_class( $classlist ) { 
// Blog Module 'classname' overwrite. 
$classlist['et_pb_blog'] = array( 'classname' => 'custom_ET_Builder_Module_Blog',); 
return $classlist; 
} 

add_filter( 'et_module_classes', 'divi_custom_blog_class' );

add_filter('comment_form_defaults',function($defaults){
	$defaults['title_reply_before'] = '<p id="reply-title" class="comment-reply-title">';
	$defaults['title_reply_after'] = '</p>';

	return $defaults;
}, 10, 1);

add_filter('comment_form_default_fields', 'unset_url_field');
function unset_url_field($fields){
    if(isset($fields['url']))
       unset($fields['url']);
       return $fields;
}

add_filter(‘comment_form_field_url’, ‘__return_false’);


add_action('wp_print_scripts', function () {
    global $post;
    if ( is_a( $post, 'WP_Post' ) && !has_shortcode( $post->post_content, 'contact-form-7') ) {
        wp_dequeue_script( 'google-recaptcha' );
        wp_dequeue_script( 'wpcf7-recaptcha' );
    }
});

// Remove dashicons in frontend for unauthenticated users
add_action( 'wp_enqueue_scripts', 'bs_dequeue_dashicons' );
function bs_dequeue_dashicons() {
    if ( ! is_user_logged_in() ) {
        wp_deregister_style( 'dashicons' );
    }
}

function new_meta_viewport() {
echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">';
}
add_action( 'wp_head', 'new_meta_viewport', 1 );