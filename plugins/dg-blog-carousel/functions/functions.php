<?php
if ( !function_exists('DGgetPostViews')) {
    function DGgetPostViews($postID) {
        $count_key = 'post_views_count';
        $count = get_post_meta($postID, $count_key, true);
        if($count==''){
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
            return "0 View";
        }
        return $count.' Views';
    }
}

if ( !function_exists('DGsetPostViews')) {
    function DGsetPostViews($postID) {
        $count_key = 'post_views_count';
        $count = get_post_meta($postID, $count_key, true);
        if($count==''){
            $count = 0;
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
        }else{
            $count++;
            update_post_meta($postID, $count_key, $count);
        }
    }
}

if ( !function_exists('DG_filter_the_content_in_the_main_loop')) {
    function DG_filter_the_content_in_the_main_loop( $content ) {
        if ( is_single() && in_the_loop() && is_main_query() ) {
            DGsetPostViews(get_the_ID());
        }
        return $content;
    }
    add_filter( 'the_content', 'DG_filter_the_content_in_the_main_loop' );
}


/**
 * Add a filter for post content
 * @return content
 */
function dg_get_post_content_output( $content_text, $content_length ) {
    $content_text = ($content_length > 0) && !empty($content_text) ? 
                    substr($content_text, 0, $content_length) . '...': $content_text ;
    return $content_text;
}
add_filter('dg_get_post_content', 'dg_get_post_content_output', 10, 2);

/**
 * Render post meta markup
 * For both top and default location
 * 
 * @return HTML markup
 */
function dg_render_post_meta_markup( $args = array(), $location = 'default', $position_class='' ) {
    $post_meta = dg_post_meta_array( $args, $location );
    $post_meta_markup_default = '';
    $post_meta_markup_top = '';
    $prev_location = 0;

    foreach ( $post_meta as $key => $markup ) {
        if( $key === 'author' && 'on' === $args['author_on_top'] && 'on' === $args['show_author'] ) {
            $post_meta_markup_top .= $markup;
        } else if ( $key === 'date' && 'on' === $args['date_on_top'] && 'on' === $args['show_date'] ) {
            $date = sprintf('<span class="published"><span class="month">%1$s</span><span class="day">%2$s</span><span class="year">%3$s</span></span>', 
                esc_html( get_the_date( 'M' ) ),
                esc_html( get_the_date( 'd' ) ),
                esc_html( get_the_date( 'Y' ) )
            );
            // $markup =  et_get_safe_localization( sprintf( __( '%s', 'et_builder' ), $date) );
            $markup =  sprintf( __( '%s', 'et_builder' ), $date);
            $post_meta_markup_top .= $markup;
        } else {
            $separator = '';
            if ( '' !== $markup  ) {
                if($prev_location !== 0) {
                    if ( 'on' === $args['use_meta_icon'] ) {
                        $separator = '<span class="blank-separator"></span>';
                    } else {
                        $separator = '<span class="pipe-separator">|</span>';
                    }
                }
                $prev_location++;
            }
            $post_meta_markup_default .= sprintf('%2$s%1$s', $markup, $separator);   
        }
    }

    if ( $location ===  'default') {
        return $post_meta_markup_default = !empty($post_meta_markup_default) ? 
            sprintf('<p class="post-meta%2$s">%1$s</p>', $post_meta_markup_default, $position_class) : '';
    } else {
        return $post_meta_markup_top;
    }
}
/**
 * Create post meta array
 * 
 * @return array
 */
function dg_post_meta_array( $args = array() , $location = 'default') {
    $post_meta = array();

    $meta_icon = 'on' === $args['use_meta_icon'] && 'default' === $location ? '<span class="meta-icon"></span>' : '';
    $post_meta['author'] = 'on' === $args['show_author'] ? 
    et_get_safe_localization( sprintf( __( '%s', 'et_builder' ), '<span class="author vcard">' . $meta_icon .  et_pb_get_the_author_posts_link() . '</span>' ) ) : '';

    $post_meta['date'] = 'on' === $args['show_date'] ? 
    et_get_safe_localization( sprintf( __( '%s', 'et_builder' ), '<span class="published">' .$meta_icon. esc_html( get_the_date( $args['meta_date'] ) ) . '</span>' ) ) : '';

    $post_meta['category'] = 'on' === $args['show_categories'] ? 
    sprintf( '<span class="categories">%2$s %1$s</span>', get_the_category_list(', '), $meta_icon ) : '';

    $comments = sprintf( esc_html( _nx( '%s Comment', '%s Comments', get_comments_number(), 'number of comments', 'et_builder' ) ), number_format_i18n( get_comments_number() ) );
    $post_meta['comment'] = 'on' === $args['show_comments'] ? 
    sprintf( '<span class="comments">%2$s %1$s</span>', $comments, $meta_icon ) : '';

    return $post_meta;
}
/**
 * render the post meta content
 * 
 * @return $post_meta
 */
function dg_render_post_meta($args) {

    $post_meta = '';

    if ( 'on' === $args['show_author'] || 'on' === $args['show_date'] || 'on' === $args['show_categories'] || 'on' === $args['show_comments'] ) {
        $post_meta = sprintf( '<p class="post-meta">%1$s %2$s %3$s %4$s %5$s %6$s %7$s</p>',
            (
                'on' === $args['show_author']
                    ? et_get_safe_localization( sprintf( __( 'by %s', 'et_builder' ), '<span class="author vcard">' .  et_pb_get_the_author_posts_link() . '</span>' ) )
                    : ''
            ),
            (
                ( 'on' === $args['show_author'] && 'on' === $args['show_date'] )
                    ? ' | '
                    : ''
            ),
            (
                'on' === $args['show_date']
                    ? et_get_safe_localization( sprintf( __( '%s', 'et_builder' ), '<span class="published">' . esc_html( get_the_date( $args['meta_date'] ) ) . '</span>' ) )
                    : ''
            ),
            (
                (( 'on' === $args['show_author'] || 'on' === $args['show_date'] ) && 'on' === $args['show_categories'] )
                    ? ' | '
                    : ''
            ),
            (
                'on' === $args['show_categories']
                    ? get_the_category_list(', ')
                    : ''
            ),
            (
                (( 'on' === $args['show_author'] || 'on' === $args['show_date'] || 'on' === $args['show_categories'] ) && 'on' === $args['show_comments'])
                    ? ' | '
                    : ''
            ),
            (
                'on' === $args['show_comments']
                    ? sprintf( esc_html( _nx( '%s Comment', '%s Comments', get_comments_number(), 'number of comments', 'et_builder' ) ), number_format_i18n( get_comments_number() ) )
                    : ''
            )
        );
    }
    return $post_meta;
}

/**
 * Dg render button
 * 
 */
function dg_render_button( $args = array() ) {
    // Prepare arguments
    $defaults = array(
        'button_id'        => '',
        'button_classname' => array(),
        'button_custom'    => '',
        'button_rel'       => '',
        'button_text'      => '',
        'button_url'       => '',
        'custom_icon'      => '',
        'display_button'   => true,
        'has_wrapper'      => true,
        'url_new_window'   => '',
    );

    $args = wp_parse_args( $args, $defaults );

    // Do not proceed if no button URL or text found
    if ( ! $args['display_button'] || '' === $args['button_text'] ) {
        return '';
    }

    // Button classname
    $button_classname = array( 'et_pb_button' );

    if ( '' !== $args['custom_icon'] && 'on' === $args['button_custom'] ) {
        $button_classname[] = 'et_pb_custom_button_icon';
    }

    if ( ! empty( $args['button_classname'] ) ) {
        $button_classname = array_merge( $button_classname, $args['button_classname'] );
    }

    // Custom icon data attribute
    $use_data_icon = '' !== $args['custom_icon'] && 'on' === $args['button_custom'];
    $data_icon     = $use_data_icon ? sprintf(
        ' data-icon="%1$s"',
        esc_attr( et_pb_process_font_icon( $args['custom_icon'] ) )
    ) : '';

    // Render button
    return sprintf( '%6$s<a%8$s class="%5$s" href="%1$s"%3$s%4$s>%2$s</a>%7$s',
        esc_url( $args['button_url'] ),
        esc_html( $args['button_text'] ),
        ( 'on' === $args['url_new_window'] ? ' target="_blank"' : '' ),
        et_esc_previously( $data_icon ),
        esc_attr( implode( ' ', array_unique( $button_classname ) ) ), // #5
        // et_esc_previously( $this->get_rel_attributes( $args['button_rel'] ) ),
        $args['has_wrapper'] ? '<div class="et_pb_button_wrapper">' : '',
        $args['has_wrapper'] ? '</div>' : '',
        '' !== $args['button_id'] ? sprintf( ' id="%1$s"', esc_attr( $args['button_id'] ) ) : ''
    );
}

/**
 * Render the image with default image size
 * @return html output
 */
function dg_print_default_image($thumbnail = '', $alttext = '',  $class = '' ) {
    if ( is_array( $thumbnail ) ) {
        extract( $thumbnail );
    }
    $output = '<img src="' . esc_url( $thumbnail )  . '"';

    if ( ! empty( $class ) ) $output .= " class='" . esc_attr( $class ) . "' ";

    $output .= " alt='" . esc_attr( strip_tags( $alttext ) ) . "' />";
    echo et_core_intentionally_unescaped( $output, 'html' );
}

/**
 * VB HTML on AJAX request
 * @return json response
 */
add_action( 'wp_ajax_dgbc_requestdata', 'dgbc_requestdata' );

function dgbc_requestdata() {
    global $paged, $post, $wp_query, $et_fb_processing_shortcode_object;
    $data = json_decode(file_get_contents('php://input'), true);
    $options = $data['props'];

    $defaults = array(
        'posts_number'                  => '',
        'include_categories'            => '',
        'meta_date'                     => '',
        'show_thumbnail'                => '',
        'show_excerpt'                  => '',
        'show_author'                   => '',
        'show_date'                     => '',
        'show_categories'               => '',
        'show_comments'                 => '',
        'show_more'                     => '',
        'read_more_text'				=> '',
        'use_button_icon'				=> '',
        'button_icon'					=> '',
        'image_size'					=> '',
        'show_excerpt_length'			=> '',
        'type'							=> '',
        'orderby'						=> '',
        'author_on_top'					=> '',
        'date_on_top'					=> '',
        'button_at_bottom'				=> '',
        'use_meta_icon'					=> '',
        'meta_position_bottom'			=> '',
        'offset_number'                 => '',
        'header_level'                  => '',
        'overlay_icon'					=> '',
        'use_overlay_icon'				=> '',
        'meta_date'                     => ''
    );

    $args = wp_parse_args( $options, $defaults );

    $query_args = array(
        'post_type' => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => intval( $args['posts_number'] ),
    );

    if ( '' !== $args['include_categories'] ) {
        $query_args['cat'] = $args['include_categories'];
    }

    $data_icon = ('on' === $args['use_button_icon']) ? 
        sprintf( 'data-icon="%1$s"', esc_attr( et_pb_process_font_icon($args['button_icon']) ) ) : '';
    $overlay_data_icon = ('on' === $args['use_overlay_icon']) ? 
        sprintf( 'data-icon="%1$s"', esc_attr( et_pb_process_font_icon($args['overlay_icon']) ) ) : 'data-icon="1"';

    // orderby
    if(  '2' !== $args['type']  ) {
        if ( '3' === $args['orderby'] ) {
            $query_args['orderby'] = 'rand';
        } else if ( '2' === $args['orderby'] ) {
            $query_args['orderby'] = 'date';
            $query_args['order'] = 'ASC';
        } else {
            $query_args['orderby'] = 'date';
            $query_args['order'] = 'DESC';
        }
    } else {
        $query_args['meta_key'] = 'post_views_count';
        $query_args['orderby'] = 'meta_value_num';
        $query_args['order'] = 'DESC';
    }
    // offset 
    if ( '' !== $args['offset_number'] && ! empty( $args['offset_number'] ) ) {
        /**
         * Offset + pagination don't play well. Manual offset calculation required
         * @see: https://codex.wordpress.org/Making_Custom_Queries_using_Offset_and_Pagination
         */
        $query_args['offset'] = intval( $args['offset_number'] );
    }
    // Get query
    $query = new WP_Query( $query_args );
    // start query
    ob_start();
    
    // query_posts( $query_args );
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            global $post, $et_fb_processing_shortcode_object;

            $image_size     = !empty($args['image_size']) ? $args['image_size'] : 'mid';
            $width          = $image_size === 'large' ? 1080 : 400;
            $width          = (int) apply_filters( 'et_pb_blog_image_width', $width );
            $height         = $image_size === 'large' ? 675 : 250;
            $height         = (int) apply_filters( 'et_pb_blog_image_height', $height );
            $classtext      = 'et_pb_post_main_image';
            $titletext      = get_the_title();
            $thumbnail      = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
            $thumb          = $thumbnail["thumb"];
            
            // read more button
            $btn_at_bottom = 'on' === $args['button_at_bottom'] ? ' btn-at-bottm' : '';
            $read_more_button = 'on' === $args['show_more'] ? 
                    sprintf('<div class="dg_read_more_wrapper%4$s"><a class="read-more" href="%2$s" %3$s><span>%1$s</span></a></div>', 
                    $args['read_more_text'],
                    get_the_permalink(),
                    $data_icon,
                    $btn_at_bottom
            ) : '';
            // post title markup
            $post_title = sprintf( '<%3$s class="dg_bc_title"><a href="%2$s">%1$s</a></%3$s>', 
                $titletext, 
                get_the_permalink(), 
                et_pb_process_header_level( $args['header_level'], 'h4' ) );
            ?>
            
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'dgbc_post_item' ) ?>>
                <div class="dgbc_post_inner_wrapper">
                    <?php 
                        if ( '' !== $thumb && 'on' === $args['show_thumbnail']) {
                            echo '<div class="dg-post-thumb">'.dg_render_post_meta_markup($args , 'top').'<a href="'.get_the_permalink().'" '.$overlay_data_icon.'>';
                                if($image_size !== 'default_image') {
                                    print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height );
                                } else {
                                    dg_print_default_image($thumb, $titletext );
                                }
                                
                            echo '</a></div>';
                        }
                    ?>
                    <div class="content-wrapper">
                        
                        <?php 
                            // Background Pattern and Mask style for builder
                            echo isset($args['background_enable_pattern_style']) ? dgbc_render_pattern_or_mask_html($args['background_enable_pattern_style'], 'pattern') : '';
                            echo isset($args['background_enable_mask_style']) ? dgbc_render_pattern_or_mask_html($args['background_enable_mask_style'], 'mask') : '';
                            echo $post_title;
                        
                            if($args['meta_position_bottom'] !== 'on') {
                                echo dg_render_post_meta_markup($args); 
                            }
                        
                        // render post content
                        if('on' === $args['show_excerpt']) {
                            $content_length = empty($args['show_excerpt_length']) ? 120 : $args['show_excerpt_length'];

                            if ( trim(get_the_excerpt()) !== '' ) {
                                $excerpt = apply_filters( 'the_excerpt', get_the_excerpt() );
                                echo '<div class="post-content">'.apply_filters('dg_get_post_content', $excerpt, $content_length).'</div>';
                            } else {
                                echo '<div class="post-content">' .et_core_intentionally_unescaped( wpautop( et_delete_post_first_video( strip_shortcodes( truncate_post( $content_length, false, '', true ) ) ) ), 'html' ). '</div>';
                            }
                        }
                        ?>
                        <?php echo $read_more_button; ?>
                        <?php 
                            if($args['meta_position_bottom'] == 'on') {
                                echo dg_render_post_meta_markup($args, 'default', ' meta-position-bottom'); 
                            }
                        ?>  
                    </div>
                </div>
            </article>
            <?php
            
        }
    }

    wp_reset_query();
    $posts = ob_get_contents();
    ob_end_clean();
    // Response with HTML markup
    wp_send_json_success($posts);
} 
/**
 * Make sure the VB getting the data on ajax load
 * @return json response
 */
function dg_et_builder_load_actions( $actions ) {
	$actions[] = 'dgbc_requestdata';

	return $actions;
}
add_filter( 'et_builder_load_actions', 'dg_et_builder_load_actions' );

/**
 * render pattern or mask markup
 * 
 */
function dgbc_render_pattern_or_mask_html( $props, $type ) {
    $html = array(
        'pattern' => '<span class="et_pb_background_pattern"></span>',
        'mask' => '<span class="et_pb_background_mask"></span>'
    );
    return $html[$type];
}

