<?php
require_once ( DGBC_MAIN_DIR . '/functions/extends.php');

class DGbc_BlogCarousel extends ET_Builder_Module {

	public $slug       = 'dgbc_blog_carousel';
	public $vb_support = 'on';
	public static $post_content_type = array();

	protected $module_credits = array(
		'module_uri' => 'https://www.divigear.com/',
		'author'     => 'DiviGear',
		'author_uri' => 'https://www.divigear.com/',
	);

	public function init() {
		$this->name 				= esc_html__( 'Divi Blog Carousel', 'et_builder' );
		$this->icon_path = plugin_dir_path( __FILE__ ). 'icon.svg';
		$this->main_css_element 	= '%%order_class%%';
		
	}
	public function get_settings_modal_toggles(){
		return array(
			'general'  => array(
					'toggles' => array(
							'main_content' 					=> esc_html__( 'Content', 'et_builder' ),
							'elements' 						=> esc_html__( 'Elements', 'et_builder' ),
							'carousel_settings'				=> esc_html__('Carousel Settings', 'et_builder'),
					),
			),
			'advanced'  =>  array(
					'toggles'   =>  array(
							'image_settings'				=> esc_html__('Image Style', 'et_builder'),
							'overlay_styles'				=> esc_html__('Overlay Styles', 'et_builder'),
							'title_text'					=> esc_html__('Title', 'et_builder'),
							'meta_text'						=> array(
								'title'		=> esc_html__('Meta', 'et_builder'),
								'tabbed_subtoggles' => true,
								// 'priority' => 50,
								'sub_toggles' => array(
									'm'     => array(
										'name' => 'Meta',
									),
									'a'     => array(
										'name' => 'Author',
									),
									'd'     => array(
										'name' => 'Date',
									),
								),
							),
							'content_text'					=> esc_html__('Content', 'et_builder'),
							'button_style'					=> esc_html__('Read More', 'et_builder'),
							'arrow_style'					=> esc_html__('Next & Prev Button', 'et_builder'),
							'dots_style'					=> esc_html__('Dots', 'et_builder'),
							'border'						=> esc_html__('Border', 'et_builder'),
							'custom_spacing'				=> array (
								'title'				=> esc_html__('Custom Spacing', 'et_builder'),
								'tabbed_subtoggles' => true,
								// 'priority' => 50,
								'sub_toggles' => array(
									'container'     => array(
										'name' => 'Container',
									),
									'content'     => array(
										'name' => 'Content',
									),
									'button'     => array(
										'name' => 'Button',
									),
								),
							)
					)
			),
			
			// Advance tab's slug is "custom_css"
			// 'custom_css' => array(
			// 	'toggles' => array(
			// 		'limitation' => esc_html__( 'Limitation', 'et_builder' ), // totally made up
			// 	),
			// ),
		);
	}

	public function get_fields() {
		$_ex = 'DGBC_Extends';
		$fields =  array(
			'posts_number' => array(
				'default'           => '12',
				'label'             => esc_html__( 'Blog Posts Count', 'et_builder' ),
				'type'              => 'text',
				'option_category'   => 'configuration',
				'description'       => esc_html__( 'Define the number of blog posts to show on the slider.', 'et_builder' ),
				'toggle_slug'       => 'main_content',
			),
			'type' => array(
				'label'             => esc_html__( 'Posts by type', 'et_builder' ),
				'type'              => 'select',
				'option_category'   => 'configuration',
				'options'           => array(
					'1' => esc_html__( 'default', 'et_builder' ),
					'1' => esc_html__( 'Recent Posts', 'et_builder' ),
					'2' => esc_html__( 'Popular Posts', 'et_builder' ),
					'3' => esc_html__( 'Posts by category', 'et_builder' ),
				),
				'default'			=> '1',
				'toggle_slug'       => 'main_content',
			),		
			'include_categories'   => array(
				'label'            => esc_html__( 'Include Categories', 'et_builder' ),
				'type'             => 'categories',
				'renderer_options' => array(
					'use_terms'    => true,
					'term_name'    => 'category',
				),
				'taxonomy_name'    => 'category',
				'toggle_slug'      => 'main_content',
				'show_if'         => array(
					'type' => '3',
				),
			),
			'orderby' => array(
				'label'             => esc_html__( 'Orderby', 'et_builder' ),
				'type'              => 'select',
				'option_category'   => 'configuration',
				'options'           => array(
					'1' => esc_html__( 'default', 'et_builder' ),
					'1' => esc_html__( 'Newest to oldest', 'et_builder' ),
					'2' => esc_html__( 'Oldest to newest', 'et_builder' ),
					'3' => esc_html__( 'Random', 'et_builder' ),
				),
				'default'			=> '1',
				'toggle_slug'       => 'main_content',
				'show_if_not'         => array(
					'type' => '2',
				),
			),	
			'offset_number' => array(
				'default'           => '0',
				'label'             => esc_html__( 'Posts Offset Number', 'et_builder' ),
				'type'              => 'text',
				'option_category'   => 'configuration',
				'toggle_slug'       => 'main_content',
			),

			'show_thumbnail' => array(
				'label'             => esc_html__( 'Show Featured Image', 'et_builder' ),
				'type'              => 'yes_no_button',
				'option_category'   => 'configuration',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'description'       => esc_html__( 'This will turn thumbnails on and off.', 'et_builder' ),
				'toggle_slug'       => 'elements',
				'default_on_front'  => 'on',
			),
			'show_excerpt' => array(
				'label'             => esc_html__( 'Show Excerpt', 'et_builder' ),
				'type'              => 'yes_no_button',
				'option_category'   => 'configuration',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'description'       => esc_html__( 'This will turn Excerpt on and off.', 'et_builder' ),
				'toggle_slug'       => 'elements',
				'default_on_front'  => 'on',
			),
			'show_excerpt_length' => array(
				'label'             => esc_html__( 'Excerpt Length', 'et_builder' ),
				'type'              => 'number',
				'option_category'   => 'configuration',
				'toggle_slug'       => 'elements',
				'default'			=> '120',
				'show_if_not'         => array(
					'show_excerpt' => 'off',
				),
			),
			'show_categories' => array(
				'label'             => esc_html__( 'Show Categories', 'et_builder' ),
				'type'              => 'yes_no_button',
				'option_category'   => 'configuration',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'description'        => esc_html__( 'Turn the category links on or off.', 'et_builder' ),
				'toggle_slug'        => 'elements',
				'default_on_front'   => 'on',
			),
			'show_author' => array(
				'label'             => esc_html__( 'Show Author', 'et_builder' ),
				'type'              => 'yes_no_button',
				'option_category'   => 'configuration',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'description'        => esc_html__( 'Turn on or off the author link.', 'et_builder' ),
				'toggle_slug'        => 'elements',
				'default_on_front'   => 'on',
			),
			'show_date' => array(
				'label'             => esc_html__( 'Show Date', 'et_builder' ),
				'type'              => 'yes_no_button',
				'option_category'   => 'configuration',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'description'        => esc_html__( 'Turn the date on or off.', 'et_builder' ),
				'toggle_slug'        => 'elements',
				'default_on_front'   => 'on',
			),
			'meta_date' => array(
				'label'             => esc_html__( 'Meta Date Format', 'et_builder' ),
				'type'              => 'text',
				'option_category'   => 'configuration',
				'description'       => esc_html__( 'If you would like to adjust the date format, input the appropriate PHP date format here. The date format will work if the date position is not on top.', 'et_builder' ),
				'toggle_slug'       => 'elements',
				'computed_affects'  => array(
					'__posts',
				),
				'show_if'			=> array (
					'show_date'		=> 'on'
				),
				'default'           => 'M j, Y',
			),
			'show_comments' => array(
				'label'             => esc_html__( 'Show Comment Count', 'et_builder' ),
				'type'              => 'yes_no_button',
				'option_category'   => 'configuration',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'description'        => esc_html__( 'Turn comment count on and off.', 'et_builder' ),
				'toggle_slug'        => 'elements',
				'default_on_front'   => 'off',
			),
			'show_more' => array(
				'label'             => esc_html__( 'Read More Button', 'et_builder' ),
				'type'              => 'yes_no_button',
				'option_category'   => 'configuration',
				'options'           => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'description'       => esc_html__( 'Here you can define whether to show "read more" link after the excerpts or not.', 'et_builder' ),
				'toggle_slug'       => 'elements',
				'default_on_front'  => 'off',
			),
			'read_more_text' => array(
				'label'             => esc_html__( 'Read More Button Text', 'et_builder' ),
				'type'              => 'text',
				'option_category'   => 'configuration',
				'toggle_slug'       => 'elements',
				'default_on_front'  => 'Read More',
				'show_if'         => array(
					'show_more' => 'on',
				),
			),

			// Carousel Settings
			'show_items_xlarge'	=> array(
				'label'				=> 	esc_html__('Show items xLarge', 'et_builder'),
				'type'				=>	'select',
				'description'       => esc_html__( 'Show items in extra large device.', 'et_builder' ),
				'options'           => array(
					'4' => esc_html__( 'default', 'et_builder' ),
					'6' => sprintf( esc_html__( '%1$s Columns', 'et_builder' ), esc_html( '6' ) ),
					'5' => sprintf( esc_html__( '%1$s Columns', 'et_builder' ), esc_html( '5' ) ),
					'4' => sprintf( esc_html__( '%1$s Columns', 'et_builder' ), esc_html( '4' ) ),
					'3' => sprintf( esc_html__( '%1$s Columns', 'et_builder' ), esc_html( '3' ) ),
					'2' => sprintf( esc_html__( '%1$s Columns', 'et_builder' ), esc_html( '2' ) ),
					'1' => esc_html__( '1 Column', 'et_builder' ),
				),
				'default'  => '4',
				'toggle_slug'		=> 'carousel_settings'
			),
			'show_items_desktop'	=> array(
				'label'				=> 	esc_html__('Show items Desktop', 'et_builder'),
				'type'				=>	'select',
				'description'       => esc_html__( 'Show items in regular desktop device.', 'et_builder' ),
				'options'           => array(
					'4' => esc_html__( 'default', 'et_builder' ),
					'6' => sprintf( esc_html__( '%1$s Columns', 'et_builder' ), esc_html( '6' ) ),
					'5' => sprintf( esc_html__( '%1$s Columns', 'et_builder' ), esc_html( '5' ) ),
					'4' => sprintf( esc_html__( '%1$s Columns', 'et_builder' ), esc_html( '4' ) ),
					'3' => sprintf( esc_html__( '%1$s Columns', 'et_builder' ), esc_html( '3' ) ),
					'2' => sprintf( esc_html__( '%1$s Columns', 'et_builder' ), esc_html( '2' ) ),
					'1' => esc_html__( '1 Column', 'et_builder' ),
				),
				'default'  => '3',
				'toggle_slug'		=> 'carousel_settings'
			),
			'show_items_tablet'	=> array(
				'label'				=> 	esc_html__('Show items Tablet', 'et_builder'),
				'type'				=>	'select',
				'description'       => esc_html__( 'Show items in tablet device.', 'et_builder' ),
				'options'           => array(
					'4' => esc_html__( 'default', 'et_builder' ),
					'6' => sprintf( esc_html__( '%1$s Columns', 'et_builder' ), esc_html( '6' ) ),
					'5' => sprintf( esc_html__( '%1$s Columns', 'et_builder' ), esc_html( '5' ) ),
					'4' => sprintf( esc_html__( '%1$s Columns', 'et_builder' ), esc_html( '4' ) ),
					'3' => sprintf( esc_html__( '%1$s Columns', 'et_builder' ), esc_html( '3' ) ),
					'2' => sprintf( esc_html__( '%1$s Columns', 'et_builder' ), esc_html( '2' ) ),
					'1' => esc_html__( '1 Column', 'et_builder' ),
				),
				'default'  => '2',
				'toggle_slug'		=> 'carousel_settings'
			),
			'show_items_mobile'	=> array(
				'label'				=> 	esc_html__('Show item Mobile', 'et_builder'),
				'type'				=>	'select',
				'description'       => esc_html__( 'Show items in mobile device.', 'et_builder' ),
				'options'           => array(
					'4' => esc_html__( 'default', 'et_builder' ),
					'6' => sprintf( esc_html__( '%1$s Columns', 'et_builder' ), esc_html( '6' ) ),
					'5' => sprintf( esc_html__( '%1$s Columns', 'et_builder' ), esc_html( '5' ) ),
					'4' => sprintf( esc_html__( '%1$s Columns', 'et_builder' ), esc_html( '4' ) ),
					'3' => sprintf( esc_html__( '%1$s Columns', 'et_builder' ), esc_html( '3' ) ),
					'2' => sprintf( esc_html__( '%1$s Columns', 'et_builder' ), esc_html( '2' ) ),
					'1' => esc_html__( '1 Column', 'et_builder' ),
				),
				'default'  => '1',
				'toggle_slug'		=> 'carousel_settings'
			),
			'multislide'	=> array(
				'label'				=> 	esc_html__('Multislide', 'et_builder'),
				'type'				=>	'yes_no_button',
				'description'       => esc_html__( 'Multiple items will slide per transition.', 'et_builder' ),
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'toggle_slug'		=>	'carousel_settings',
				'default'			=> 'off'
			),
			'item_spacing'     => array(
                'label'             => esc_html('Item Spacing', 'et_builder'),
                'type'              => 'range',
                'toggle_slug'       => 'carousel_settings',
                'range_settings '   => array(
                    'min'       => '5',
                    'max'       => '50',
                    'step'      => '1',
                ),
				'default'  			=> '30',
				'mobile_options'    => true,
			),
			'transition_duration'	=> array(
				'label'				=> 	esc_html__('Transition Duration', 'et_builder'),
				'type'              => 'text',
				'toggle_slug'		=>	'carousel_settings',
                'default'  => '500',
			),
			'arrow_nav'	=> array(
				'label'				=> 	esc_html__('Arrow Navigtion', 'et_builder'),
				'type'				=>	'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'toggle_slug'		=>	'carousel_settings',
				'default'			=> 'off'
			),
			'dot_nav'	=> array(
				'label'				=> 	esc_html__('Dot Navigtion', 'et_builder'),
				'type'				=>	'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'toggle_slug'		=>	'carousel_settings',
				'default'			=> 'off'
			),
			'centermode'	=> array(
				'label'				=> 	esc_html__('Center Slide', 'et_builder'),
				'type'				=>	'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'toggle_slug'		=>	'carousel_settings',
				'default'			=> 'off'
			),
			'loop'	=> array(
				'label'				=> 	esc_html__('Loop', 'et_builder'),
				'type'				=>	'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'toggle_slug'		=>	'carousel_settings',
				'default'			=> 'off'
			),
			'autoplay'	=> array(
				'label'				=> 	esc_html__('Autoplay', 'et_builder'),
				'type'				=>	'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'toggle_slug'		=>	'carousel_settings',
				'default'			=> 'off'
			),
			'hoverpause'	=> array(
				'label'				=> 	esc_html__('Pause on hover', 'et_builder'),
				'type'				=>	'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'toggle_slug'		=>	'carousel_settings',
				'default'			=> 'off',
				'show_if'         => array(
					'autoplay' => 'on',
				),
			),
			'autoplay_speed'		=> array(
				'label'				=> 	esc_html__('Autoplay Delay', 'et_builder'),
				'type'				=>	'text',
				'default'			=>	'1500',
				'toggle_slug'		=> 'carousel_settings',
				'show_if'         => array(
					'autoplay' => 'on',
				),
			),
			'equal_height'	=> array(
				'label'				=> 	esc_html__('Equal Height', 'et_builder'),
				'type'				=>	'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'toggle_slug'		=>	'carousel_settings',
				'default'			=> 'off'
			),
			'item_vertical_align'	=> array(
				'label'				=> 	esc_html__('Vertical Align', 'et_builder'),
				'type'				=>	'select',
				'options'         => array(
					'flex-start' 	=> esc_html__( 'Top', 'et_builder' ),
					'center'  		=> esc_html__( 'Center', 'et_builder' ),
					'flex-end'  	=> esc_html__( 'Bottom', 'et_builder' ),
				),
				'toggle_slug'		=>	'carousel_settings',
				'show_if_not'      => array(
					'equal_height' => 'on',
				),
			),
			'effect' => array(
				'label'             => esc_html__( 'Slide Effect', 'et_builder' ),
				'type'              => 'select',
				'options'           => array(
					'slide'  => esc_html__( 'Slide', 'et_builder' ),
					'coverflow' => esc_html__( 'Coverflow', 'et_builder' ),
				),
				'default' => 'slide',
				'toggle_slug'       => 'carousel_settings',
			),
			'coverflow_rotate'     => array(
                'label'             => esc_html('Rotate', 'et_builder'),
                'type'              => 'range',
                'toggle_slug'       => 'carousel_settings',
                'range_settings '   => array(
                    'min'       => '0',
                    'max'       => '100',
                    'step'      => '1',
                ),
				'default'          => '50',
				'show_if'         => array(
					'effect' => 'coverflow',
				),
			),
			'slide_shadow'	=> array(
				'label'				=> 	esc_html__('Slide Shadow', 'et_builder'),
				'type'				=>	'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'toggle_slug'		=>	'carousel_settings',
				'default'			=> 'on',
				'show_if'         => array(
					'effect' => 'coverflow',
				),
			),

			// advanced field options ( image style )
			'image_size'	=> array(
				'label'				=> 	esc_html__('Select Image Size', 'et_builder'),
				'type'				=>	'select',
				'options'           => array(
					'mid' 	=> esc_html__( 'default', 'et_builder' ),
					'large' => esc_html__( 'Large ( 1080 x 675 )', 'et_builder' ),
					'mid' 	=> esc_html__( 'Medium ( 400 x 250 )', 'et_builder' ),
					'default_image' 	=> esc_html__( 'Default Image', 'et_builder' ),
				),
				'default'  			=> '3',
				'tab_slug'			=> 'advanced',
				'toggle_slug'		=> 'image_settings',
			),
			// advanced field options ( Read more button )
			'button_alignment'	=> array(
				'label'				=> 	esc_html__('Alignment', 'et_builder'),
				'type'				=>	'text_align',
				'options'         	=> et_builder_get_text_orientation_options( array( 'justified' ) ),
				'tab_slug'        	=>  'advanced',
				'toggle_slug'		=>	'button_style',
				'default'			=> 'left',
				'default_on_front'	=> 'left',
			),
			'button_fullwidth'	=> array(
				'label'				=> 	esc_html__('Fullwidth Button', 'et_builder'),
				'type'				=>	'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'tab_slug'        	=> 'advanced',
				'toggle_slug'		=>	'button_style',
				'default'			=> 'off',
			),
			'button_at_bottom'	=> array(
				'label'				=> 	esc_html__('Button at the bottom', 'et_builder'),
				'type'				=>	'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'tab_slug'        	=> 'advanced',
				'toggle_slug'		=>	'button_style',
				'default'			=> 'off',
			),
			'use_button_icon'	=> array(
				'label'				=> 	esc_html__('Use Icon', 'et_builder'),
				'type'				=>	'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'tab_slug'        	=> 'advanced',
				'toggle_slug'		=>	'button_style',
				'default'			=> 'off',
			),
			'button_icon' => array(
				'label'               => esc_html__( 'Select Button Icon', 'et_builder' ),
				'type'                => 'et_font_icon_select',
				'renderer'            => 'select_icon',
				'renderer_with_field' => true,
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'button_style',
				'show_if'         	=> array(
					'use_button_icon' => 'on',
				),
			),
			'button_bg_color' => array(
				'label'           	=> esc_html__( 'Background', 'et_builder' ),
				'type'            	=> 'color-alpha',
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'button_style',
				'default'		  	=> 'rgba(255,255,255,0)',
				'hover'			  	=> 'tabs'
			),
			// advanced field options ( Arrow )
			'use_prev_icon'	=> array(
				'label'				=> 	esc_html__('Use Custom Prev Icon', 'et_builder'),
				'type'				=>	'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'tab_slug'        => 'advanced',
				'toggle_slug'		=>	'arrow_style',
				'default'			=> 'off',
			),
			'arrow_prev_icon' => array(
				'label'               => esc_html__( 'Select Prev Icon', 'et_builder' ),
				'type'                => 'et_font_icon_select',
				'renderer'            => 'select_icon',
				'renderer_with_field' => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'arrow_style',
				'show_if'         => array(
					'use_prev_icon' => 'on',
				),
			),
			'use_next_icon'	=> array(
				'label'				=> 	esc_html__('Use Custom Next Icon', 'et_builder'),
				'type'				=>	'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'tab_slug'        => 'advanced',
				'toggle_slug'		=>	'arrow_style',
				'default'			=> 'off',
			),
			'arrow_next_icon' => array(
				'label'               => esc_html__( 'Select Next Icon', 'et_builder' ),
				'type'                => 'et_font_icon_select',
				'renderer'            => 'select_icon',
				'renderer_with_field' => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'arrow_style',
				'show_if'         => array(
					'use_next_icon' => 'on',
				),
			),
			'arrow_color' => array(
				'label'           => esc_html__( 'Next & Previous Color', 'et_builder' ),
				'type'            => 'color-alpha',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'arrow_style',
				'default'		  => '#0c71c3',
				'hover'			  => 'tabs',
			),
			'arrow_background_color' => array(
				'label'           => esc_html__( 'Next & Previous Background Color', 'et_builder' ),
				'type'            => 'color-alpha',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'arrow_style',
				'default'		  => '#ffffff',
				'hover'			  => 'tabs',
			),
			'arrow_show_hover'	=> array(
				'label'				=> 	esc_html__('Show on hover', 'et_builder'),
				'type'				=>	'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'tab_slug'        	=>  'advanced',
				'toggle_slug'		=>	'arrow_style',
				'default'			=>  'off',
			),
			'arrow_position'	=> array(
				'label'				=> 	esc_html__('Position', 'et_builder'),
				'type'				=>	'select',
				'options'           => array(
					'1' => esc_html__( 'default', 'et_builder' ),
					'1' => esc_html__( 'Middle & Inside the container', 'et_builder' ),
					'2' => esc_html__( 'Middle & Outside the container', 'et_builder' ),
					'3' => esc_html__( 'Top', 'et_builder' ),
					'4' => esc_html__( 'Bottom', 'et_builder' ),
				),
				'tab_slug'        	=>  'advanced',
				'toggle_slug'		=>  'arrow_style',
				'default'			=>  'off',
			),
			'arrow_alignment'	=> array(
				'label'				=> 	esc_html__('Alignment', 'et_builder'),
				'type'				=>	'text_align',
				'options'         	=> et_builder_get_text_orientation_options( ),
				'tab_slug'        	=>  'advanced',
				'toggle_slug'		=>	'arrow_style',
				'default'			=> 'left',
				'show_if'         => array(
					'arrow_position' => array( '3', '4' ),
				),
			),
			'arrow_spacebetweent' => array(
				'label'           => esc_html__( 'Space Between', 'et_builder' ),
				'type'            => 'range',
				'mobile_options'    => true,
                'responsive'        => true,
                'default'           => '10px',
                'default_unit'      => 'px',
				'range_settings '   => array(
                    'min'       => '0',
                    'max'       => '100',
                    'step'      => '1',
				),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'arrow_style',
				'show_if'         => array(
					'arrow_position' => array( '3', '4' ),
				),
			),
			'arrow_font_size' => array(
				'label'             => esc_html__( 'Font Size', 'et_builder' ),
				'type'              => 'range',
				'mobile_options'    => true,
                'responsive'        => true,
                'default'           => '53px',
                'default_unit'      => 'px',
				'range_settings '   => array(
                    'min'       => '0',
                    'max'       => '100',
                    'step'      => '1',
				),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'arrow_style',
			),

			// advanced field options ( meta settings )
			'use_meta_icon'	=> array(
				'label'				=> 	esc_html__('Use meta icon', 'et_builder'),
				'type'				=>	'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'tab_slug'        	=> 'advanced',
				'toggle_slug'		=> 'meta_text',
				'sub_toggle'  		=> 'm',
				'default'			=>  'off',
			),
			'meta_position_bottom'	=> array(
				'label'				=> 	esc_html__('Meta position at bottom', 'et_builder'),
				'type'				=>	'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'tab_slug'        	=> 'advanced',
				'toggle_slug'		=> 'meta_text',
				'sub_toggle'  		=> 'm',
				'default'			=>  'off',
			),
			'metabottom_divider_color' => array(
				'label'           => esc_html__( 'Divider Color', 'et_builder' ),
				'type'            => 'color-alpha',
				'tab_slug'        => 'advanced',
				'toggle_slug'	  => 'meta_text',
				'sub_toggle'  	  => 'm',
				'default'		  => 'transparent',
				'hover'			  => 'tabs',
				'show_if'         => array(
					'meta_position_bottom' => 'on',
				),
			),
			// advanced field options ( meta settings author and date )
			'author_on_top'	=> array(
				'label'				=> 	esc_html__('Author On top', 'et_builder'),
				'type'				=>	'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'tab_slug'        	=> 'advanced',
				'toggle_slug'		=> 'meta_text',
				'sub_toggle'  		=> 'a',
				'default'			=> 'off',
			),
			'author_bg_color' => array(
				'label'           => esc_html__( 'Author Background Color', 'et_builder' ),
				'type'            => 'color-alpha',
				'tab_slug'        => 'advanced',
				'toggle_slug'	  => 'meta_text',
				'sub_toggle'  	  => 'a',
				'default'		  => '#ffffff',
				'hover'			  => 'tabs',
			),
			'date_on_top'	=> array(
				'label'				=> 	esc_html__('Date On top', 'et_builder'),
				'description'       => esc_html__( 'If the button is on, custom date format will not work.', 'et_builder' ),
				'type'				=>	'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'tab_slug'        	=> 'advanced',
				'toggle_slug'		=> 'meta_text',
				'sub_toggle'  		=> 'd',
				'default'			=> 'off',
			),
			'date_bg_color' => array(
				'label'           => esc_html__( 'Date Background Color', 'et_builder' ),
				'type'            => 'color-alpha',
				'tab_slug'        => 'advanced',
				'toggle_slug'		=> 'meta_text',
				'sub_toggle'  		=> 'd',
				'default'		  => '#ffffff',
				'hover'			  => 'tabs',
			),
			'date_separator_color' => array(
				'label'           => esc_html__( 'Date Separator Color', 'et_builder' ),
				'type'            => 'color-alpha',
				'tab_slug'        => 'advanced',
				'toggle_slug'		=> 'meta_text',
				'sub_toggle'  		=> 'd',
				'default'		  => '#333333',
				'hover'			  => 'tabs',
			),
			
			// advanced field options ( Dots style )
			'dot_alignment'	=> array(
				'label'				=> 	esc_html__('Dots Alignment', 'et_builder'),
				'type'				=>	'text_align',
				'options'         	=> et_builder_get_text_orientation_options( array( 'justified' ) ),
				'tab_slug'        	=>  'advanced',
				'toggle_slug'		=>	'dots_style',
				'default'			=> 'center',
				'default_on_front'	=> 'center',
			),
			'dots_size' => array(
				'label'           => esc_html__( 'Size', 'et_builder' ),
				'type'            => 'range',
				// 'mobile_options'    => true,
                // 'responsive'        => true,
                'default'           => '8px',
                'default_unit'      => 'px',
				'range_settings '   => array(
                    'min'       => '5',
                    'max'       => '15',
                    'step'      => '1',
				),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dots_style',
			),
			'dots_color'	=> array(
				'label'				=> 	esc_html__('Color', 'et_builder'),
				'type'				=>	'color-alpha',
				'default'			=> '#e2e2e2',
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'dots_style',
			),
			'dots_active_color'	=> array(
				'label'				=> 	esc_html__('Active Color', 'et_builder'),
				'type'				=>	'color-alpha',
				'default'			=> '#0c71c3',
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'dots_style',
			),
		);

		$overlay_styles = array(
			'overlay' => array(
				'label'             => esc_html__( 'Image Overlay', 'et_builder' ),
				'type'              => 'yes_no_button',
				'option_category'   => 'configuration',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'toggle_slug'       => 'overlay_styles',
				'tab_slug'        	=> 'advanced',
				'default_on_front'  => 'off',
			),
			'overlay_color'	=> array(
				'label'				=> 	esc_html__('Color', 'et_builder'),
				'type'				=>	'color-alpha',
				'default'			=> '#e2e2e2',
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'overlay_styles',
				'show_if'			=> array(
					'overlay'		=> 'on'
				)
			),
			'use_overlay_icon'	=> array(
				'label'				=> 	esc_html__('Use Custom Icon', 'et_builder'),
				'type'				=>	'yes_no_button',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'tab_slug'        	=> 'advanced',
				'toggle_slug'		=>	'overlay_styles',
				'default'			=> 'off',
				'show_if'			=> array(
					'overlay'		=> 'on'
				)
			),
			'overlay_icon' => array(
				'label'               => esc_html__( 'Select Overlay Icon', 'et_builder' ),
				'type'                => 'et_font_icon_select',
				'renderer'            => 'select_icon',
				'renderer_with_field' => true,
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'overlay_styles',
				'show_if'         	=> array(
					'use_overlay_icon' => 'on',
				),
			),
			'overlay_icon_color' => array(
				'label'           	=> esc_html__( 'Overlay Icon Color', 'et_builder' ),
				'type'            	=> 'color-alpha',
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'overlay_styles',
				'default'		  	=> 'rgba(255,255,255,0)',
				// 'hover'			  	=> 'tabs',
				'show_if'			=> array(
					'overlay'		=> 'on'
				)
			),
		);

		$inner_container_padding = $_ex::add_margin_padding_field(
			'inner_container_padding',
			'Inner Container Padding',
			'custom_spacing',
			'container'
		);
		$content_margin = $_ex::add_margin_padding_field(
			'content_margin',
			'Content Margin',
			'custom_spacing',
			'content'
		);
		$content_padding = $_ex::add_margin_padding_field(
			'content_padding',
			'Content Padding',
			'custom_spacing',
			'content'
		);
		$post_content = $_ex::add_margin_padding_field(
			'post_content_padding',
			'Post excerpt padding',
			'custom_spacing',
			'content'
		);
		$title_margin = $_ex::add_margin_padding_field(
			'title_margin',
			'Title Margin',
			'custom_spacing',
			'content'
		);
		$meta_margin = $_ex::add_margin_padding_field(
			'meta_margin', 
			'Meta Margin', 
			'custom_spacing', 
			'content' 
		);
		$meta_padding = $_ex::add_margin_padding_field(
			'meta_padding', 
			'Meta Padding', 
			'custom_spacing', 
			'content' 
		);
		$button_wrapper_margin = $_ex::add_margin_padding_field(
			'button_wrp_margin',
			'Button Wrapper Margin',
			'custom_spacing',
			'button'
		);
		$button_margin = $_ex::add_margin_padding_field(
			'button_margin',
			'Button Margin',
			'custom_spacing',
			'button'
		);
		$button_padding = $_ex::add_margin_padding_field(
			'button_padding',
			'Button Padding',
			'custom_spacing',
			'button'
		);

		// merge and returning the field options
		return array_merge(
			$fields, 
			$inner_container_padding,
			$content_margin,
			$content_padding,
			$post_content,
			$title_margin,
			$meta_margin,
			$meta_padding,
			$button_wrapper_margin,
			$button_margin,
			$button_padding,
			$overlay_styles
		);
	}

	public function get_advanced_fields_config() {
		$advanced_fields = array();

		$advanced_fields['text'] = false;

		$advanced_fields['borders']['image'] = array(
			'css'             => array(
				'main' => array(
					'border_radii' => "{$this->main_css_element}.dgbc_blog_carousel .dgbc_post_item .dg-post-thumb img, #et-boc {$this->main_css_element}.dgbc_blog_carousel .dgbc_post_item .dg-post-thumb img",
					'border_styles' => "{$this->main_css_element}.dgbc_blog_carousel .dgbc_post_item .dg-post-thumb img, #et-boc {$this->main_css_element}.dgbc_blog_carousel .dgbc_post_item .dg-post-thumb img",
					'border_styles_hover' => "{$this->main_css_element}.dgbc_blog_carousel .dgbc_post_item:hover .dg-post-thumb img",
				),
			),
			'defaults'		  => array (
				'border_styles'		=> array(
					'width'		=> '0px',
					'color'		=> '#ffffff',
					'style'		=> 'solid'
				),
				'border_radii'		=> 'on|0px|0px|0px|0px',
			),
			'tab_slug'        => 'advanced',
			'toggle_slug'     => 'image_settings',
		);

		$advanced_fields['fonts']['header'] = array(
			'label'         => esc_html__( 'Title', 'et_builder' ),
			'toggle_slug'   => 'title_text',
			'tab_slug'		=> 'advanced',
			'hide_text_shadow'  => true,
			'line_height' => array (
				'default' => '1em',
			),
			'font_size' => array(
				'default' => '20px',
			),
			'css'      => array(
				'main' => "{$this->main_css_element} .dgbc_post_item .content-wrapper h1.dg_bc_title,
						{$this->main_css_element} .dgbc_post_item .content-wrapper h2.dg_bc_title, 
						{$this->main_css_element} .dgbc_post_item .content-wrapper h3.dg_bc_title, 
						{$this->main_css_element} .dgbc_post_item .content-wrapper h4.dg_bc_title, 
						{$this->main_css_element} .dgbc_post_item .content-wrapper h5.dg_bc_title, 
						{$this->main_css_element} .dgbc_post_item .content-wrapper h6.dg_bc_title, 
						{$this->main_css_element} .dgbc_post_item .content-wrapper h1.dg_bc_title a,
						{$this->main_css_element} .dgbc_post_item .content-wrapper h2.dg_bc_title a,
						{$this->main_css_element} .dgbc_post_item .content-wrapper h3.dg_bc_title a,
						{$this->main_css_element} .dgbc_post_item .content-wrapper h4.dg_bc_title a,
						{$this->main_css_element} .dgbc_post_item .content-wrapper h5.dg_bc_title a,
						{$this->main_css_element} .dgbc_post_item .content-wrapper h6.dg_bc_title a",
				'hover' => "{$this->main_css_element} .dgbc_post_item:hover .content-wrapper h1.dg_bc_title,
						{$this->main_css_element} .dgbc_post_item:hover .content-wrapper h2.dg_bc_title,
						{$this->main_css_element} .dgbc_post_item:hover .content-wrapper h3.dg_bc_title,
						{$this->main_css_element} .dgbc_post_item:hover .content-wrapper h4.dg_bc_title,
						{$this->main_css_element} .dgbc_post_item:hover .content-wrapper h5.dg_bc_title,
						{$this->main_css_element} .dgbc_post_item:hover .content-wrapper h6.dg_bc_title, 
						{$this->main_css_element} .dgbc_post_item:hover .content-wrapper h1.dg_bc_title a,
						{$this->main_css_element} .dgbc_post_item:hover .content-wrapper h2.dg_bc_title a,
						{$this->main_css_element} .dgbc_post_item:hover .content-wrapper h3.dg_bc_title a,
						{$this->main_css_element} .dgbc_post_item:hover .content-wrapper h4.dg_bc_title a,
						{$this->main_css_element} .dgbc_post_item:hover .content-wrapper h5.dg_bc_title a,
						{$this->main_css_element} .dgbc_post_item:hover .content-wrapper h6.dg_bc_title a",
				'important'	=> 'all'
			),
			'header_level' => array(
				'default' => 'h2',
			),
		);

		$advanced_fields['fonts']['meta'] = array(
			'label'         => esc_html__( 'Meta', 'et_builder' ),
			'toggle_slug'   => 'meta_text',
			'tab_slug'		=> 'advanced',
			'hide_text_shadow'  => true,
			'line_height' => array (
				'default' => '1em',
			),
			'font_size' => array(
				'default' => '14px',
			),
			'css'      => array(
				'main' => "%%order_class%% .dgbc_post_item .content-wrapper .post-meta, %%order_class%% .dgbc_post_item .content-wrapper .post-meta a",
				'hover'	=> "%%order_class%% .dgbc_post_item:hover .content-wrapper .post-meta span, %%order_class%% .dgbc_post_item:hover .content-wrapper .post-meta a",
				'important'	=> 'all'
			),
			'sub_toggle'  		=> 'm',
		);
		
		$advanced_fields['fonts']['author'] = array(
			'label'         => esc_html__( 'Author Top', 'et_builder' ),
			'toggle_slug'   => 'meta_text',
			'tab_slug'		=> 'advanced',
			'hide_text_shadow'  => true,
			'line_height' => array (
				'default' => '1em',
			),
			'font_size' => array(
				'default' => '14px',
			),
			'css'      => array(
				'main' => "%%order_class%% .dgbc_post_item .dg-post-thumb span.author a",
				'hover'	=> "%%order_class%% .dgbc_post_item:hover .dg-post-thumb span.author a",
				'important'	=> 'all'
			),
			'sub_toggle'  		  => 'a',
		);
		$advanced_fields['fonts']['date'] = array(
			'label'         => esc_html__( 'Date', 'et_builder' ),
			'toggle_slug'   => 'meta_text',
			'tab_slug'		=> 'advanced',
			'hide_text_shadow'  => true,
			'line_height' => array (
				'default' => '1em',
			),
			'font_size' => array(
				'default' => '14px',
			),
			'css'      => array(
				'main' => "%%order_class%% .dgbc_post_item .dg-post-thumb span.published",
				'hover'	=> "%%order_class%% .dgbc_post_item:hover .dg-post-thumb span.published",
				'important'	=> 'all'
			),
			'sub_toggle'  		=> 'd',
		);
		
		$advanced_fields['fonts']['content']   = array(
			'label'         => esc_html__( 'Content', 'et_builder' ),
			'toggle_slug'   => 'content_text',
			'tab_slug'		=> 'advanced',
			'hide_text_shadow'  => true,
			'line_height' => array (
				'default' => '1em',
			),
			'font_size' => array(
				'default' => '14px',
			),
			'css'      => array(
				'main' => "%%order_class%% .dgbc_post_item .content-wrapper .post-content",
				'hover' => "%%order_class%% .dgbc_post_item:hover .content-wrapper .post-content",
				'important'	=> 'all'
			),
		);
		
		$advanced_fields['fonts']['read_more']   = array(
			'label'         => esc_html__( 'Read More', 'et_builder' ),
			'toggle_slug'   => 'button_style',
			'tab_slug'		=> 'advanced',
			'hide_text_shadow'  => true,
			'line_height' => array (
				'default' => '1em',
			),
			'font_size' => array(
				'default' => '14px',
			),
			'css'      => array(
				'main' => "%%order_class%% .dgbc_post_item .dg_read_more_wrapper a",
				'hover' => "%%order_class%% .dgbc_post_item:hover .dg_read_more_wrapper a",
				'important'	=> 'all'
			),
		);
		$advanced_fields['fonts']['nav_icon']   = array(
			// 'label'         => esc_html__( 'Nav', 'et_builder' ),
			'toggle_slug'   => 'arrow_style',
			'tab_slug'		=> 'advanced',
			'hide_text_shadow'  => true,
			'hide_font'	=> true,
			'hide_font_size'	=> true,
			'hide_letter_spacing'	=> true,
			'hide_text_color'	=> true,
			'hide_text_align'	=> true,
			'line_height' => array(
				'default' => '0.96em',
			),
			'font_size' => array(
				'default' => '53px',
			),
			'css'      => array(
				'main' => "%%order_class%% .dgbc_carousel_wrapper .swiper-button-next,
				%%order_class%% .dgbc_carousel_wrapper .swiper-button-prev",
				'important'	=> 'all'
			),
		);
		$advanced_fields['borders']['read_more'] = array(
			'css'             => array(
				'main' => array(
					'border_radii' => "%%order_class%% .dgbc_post_item .dg_read_more_wrapper a, #et-boc %%order_class%% .dgbc_post_item .dg_read_more_wrapper a",
					'border_styles' => "%%order_class%% .dgbc_post_item .dg_read_more_wrapper a, #et-boc %%order_class%% .dgbc_post_item .dg_read_more_wrapper a",
					'border_styles_hover' => "%%order_class%% .dgbc_post_item:hover .dg_read_more_wrapper a, #et-boc %%order_class%% .dgbc_post_item:hover .dg_read_more_wrapper a",
				)
			),
			'label_prefix'    => esc_html__( 'Read More', 'et_builder' ),
			'tab_slug'        => 'advanced',
			'toggle_slug'     => 'button_style',
			
		);
		$advanced_fields['borders']['article'] = array(
			'css'             => array(
				'main' => array(
					'border_radii' => "%%order_class%%.dgbc_blog_carousel .dgbc_post_inner_wrapper, #et-boc %%order_class%%.dgbc_blog_carousel .dgbc_post_inner_wrapper",
					'border_styles' => "%%order_class%%.dgbc_blog_carousel .dgbc_post_inner_wrapper, #et-boc %%order_class%%.dgbc_blog_carousel .dgbc_post_inner_wrapper",
					'border_styles_hover' => "%%order_class%%.dgbc_blog_carousel .dgbc_post_inner_wrapper:hover, #et-boc %%order_class%%.dgbc_blog_carousel .dgbc_post_inner_wrapper:hover",
				)
			),
			'tab_slug'        => 'advanced',
			'toggle_slug'     => 'border',
			
		);
		$advanced_fields['background'] = array(
			'css'      => array(
				'important'	=> 'all',
				'main' => '%%order_class%% .dgbc_post_item .content-wrapper',
				'hover' => '%%order_class%% .dgbc_post_item:hover .content-wrapper',
			),
			'use_background_color'          => true, // default
			'use_background_color_gradient' => true, // default
			'use_background_image'          => true, // default
			'use_background_video'          => false, // default
		);

		$advanced_fields['box_shadow'] = array (
			'default'		=> array(
				'css' => array(
					'main' => "%%order_class%% .dgbc_post_inner_wrapper",
					'hover' => "%%order_class%% .dgbc_post_inner_wrapper:hover",
					'important' => true
				),
			)
		);

		$advanced_fields['margin_padding'] = array(
			'css' => array ( 'important' => 'all' )
		);
		$advanced_fields['transform'] = false;
		$advanced_fields['filters'] = false;
		$advanced_fields['link_options'] = false;
		$advanced_fields['animation'] = false;
		return $advanced_fields;
	}

	// custom css
	public function get_custom_css_fields_config() {
		return array(
			'blog_item' => array(
				'label'    => esc_html__( 'Blog Item', 'et_builder' ),
				'selector' => '%%order_class%%.dgbc_blog_carousel .swiper-container .dgbc_post_item',
			),
			'content_container' => array(
				'label'    => esc_html__( 'Content container', 'et_builder' ),
				'selector' => '%%order_class%%.dgbc_blog_carousel .dgbc_post_item .content-wrapper',
			),
			'title' => array(
				'label'    => esc_html__( 'Title', 'et_builder' ),
				'selector' => '%%order_class%%.dgbc_blog_carousel .dgbc_post_item .content-wrapper .dg_bc_title',
			),
			'content' => array(
				'label'    => esc_html__( 'Content', 'et_builder' ),
				'selector' => '%%order_class%%.dgbc_blog_carousel .dgbc_post_item .content-wrapper .post-content',
			),
			'image' => array(
				'label'    => esc_html__( 'Image', 'et_builder' ),
				'selector' => '%%order_class%%.dgbc_blog_carousel .dgbc_post_item .content-wrapper .post-meta',
			),
			'button' => array(
				'label'    => esc_html__( 'Button', 'et_builder' ),
				'selector' => '%%order_class%%.dgbc_blog_carousel .dgbc_post_item .content-wrapper .read-more',
			),
		);
	}
	// get posts
	function get_posts( $args = array(), $conditional_tags = array(), $current_page = array() ){
		$args = array(
			'posts_number'                  => $this->props['posts_number'],
			'meta_date'						=> '',
			'include_categories'            => $this->props['include_categories'],
			'show_thumbnail'                => $this->props['show_thumbnail'],
			'show_excerpt'                  => $this->props['show_excerpt'],
			'show_author'                   => $this->props['show_author'],
			'show_date'                     => $this->props['show_date'],
			'show_categories'               => $this->props['show_categories'],
			'show_comments'                 => $this->props['show_comments'],
			'show_more'                     => $this->props['show_more'],
			'read_more_text'				=> $this->props['read_more_text'],
			'use_button_icon'				=> $this->props['use_button_icon'],
			'button_icon'					=> $this->props['button_icon'],
			'image_size'					=> $this->props['image_size'],
			'show_excerpt_length'			=> $this->props['show_excerpt_length'],
			'type'							=> $this->props['type'],
			'orderby'						=> $this->props['orderby'],
			'author_on_top'					=> $this->props['author_on_top'],
			'date_on_top'					=> $this->props['date_on_top'],
			'button_at_bottom'				=> $this->props['button_at_bottom'],
			'use_meta_icon'					=> $this->props['use_meta_icon'],
			'meta_position_bottom'			=> $this->props['meta_position_bottom'],
			'offset_number'					=> $this->props['offset_number'],
			'header_level'					=> $this->props['header_level'],
			'overlay_icon'					=> $this->props['overlay_icon'],
			'use_overlay_icon'				=> $this->props['use_overlay_icon'],
			'meta_date'						=> $this->props['meta_date']
		);

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
				$post_format    = et_pb_post_format();
				
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
					et_pb_process_header_level( $this->props['header_level'], 'h4' ) );
				
				?>
				
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'dgbc_post_item' ) ?>>
					<div class="dgbc_post_inner_wrapper">
						<?php 

						et_divi_post_format_content();
						if ( 'video' === $post_format && false !== ( $first_video = et_get_first_video() ) ) :
							$video_overlay = has_post_thumbnail() ? sprintf(
								'<div class="et_pb_video_overlay" style="background-image: url(%1$s); background-size: cover;">
									<div class="et_pb_video_overlay_hover">
										<a href="#" class="et_pb_video_play"></a>
									</div>
								</div>',
								$thumb
							) : '';
							
							if(empty($first_video)) return;
							echo sprintf(
								'<div class="dg-post-thumb">
									<div class="et_main_video_container">
										%1$s
										%2$s
									</div>
								</div>',
								et_core_esc_previously( $video_overlay ),
								et_core_esc_previously( $first_video )
							);
						else:
							if ( '' !== $thumb && 'on' === $args['show_thumbnail']) {
								echo '<div class="dg-post-thumb">'.dg_render_post_meta_markup($args , 'top').'<a href="'.get_the_permalink().'" '.$overlay_data_icon.'>';
									if($image_size !== 'default_image') {
										print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height );
									} else {
										dg_print_default_image($thumb, $titletext );
									}
									
								echo '</a></div>';
							}
						endif;

						
						?>
						<div class="content-wrapper">
							<?php
							// Background Pattern and Mask style for Frontend
							echo isset($this->props['background_enable_pattern_style']) ? $this->dgbc_render_pattern_or_mask_html($this->props['background_enable_pattern_style'], 'pattern') : '';
							echo isset($this->props['background_enable_mask_style']) ? $this->dgbc_render_pattern_or_mask_html($this->props['background_enable_mask_style'], 'mask') : '';
						
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
		
		return $posts;
	}
	/**
	 * Additional Css Styles
	 */
	public function additional_css_styles($render_slug){
		$order_class 	= 	self::get_module_order_class( $render_slug );
		$_ex 			= 'DGBC_Extends';
		$alignment = array (
			'left' => 'flex-start',
      		'center' => 'center',
			'right' => 'flex-end',
			'justified' => 'space-between'
		);

		// add transition values to items
		ET_Builder_Element::set_style($render_slug, array(
			'selector' => '%%order_class%% .dgbc_carousel_wrapper .dgbc_post_inner_wrapper, 
				%%order_class%% .dgbc_carousel_wrapper .dgbc_post_inner_wrapper *, 
				%%order_class%% .dgbc_carousel_wrapper .dgbc_post_inner_wrapper .dg-post-thumb > a:before,
				%%order_class%% .dgbc_carousel_wrapper .dgbc_post_inner_wrapper .dg-post-thumb > a:after',
			'declaration' => sprintf('transition: all %1$s %2$s %3$s !important;', 
				$this->props['hover_transition_duration'],
				$this->props['hover_transition_speed_curve'],
				$this->props['hover_transition_delay']
			),
		));
		// overlay color
		$_ex::apply_element_color(
			$this,
			$render_slug,
			'overlay_color',
			'background-color',
			'%%order_class%% .dgbc_carousel_wrapper.has_overlay .dgbc_post_item .dg-post-thumb > a:before',
			'%%order_class%% .dgbc_carousel_wrapper.has_overlay .dgbc_post_item .dg-post-thumb > a:before',
			true
		);
		// overlay icon color
		$_ex::apply_element_color(
			$this,
			$render_slug,
			'overlay_icon_color',
			'color',
			'%%order_class%% .dgbc_carousel_wrapper.has_overlay .dgbc_post_item .dg-post-thumb > a:after',
			'%%order_class%% .dgbc_carousel_wrapper.has_overlay .dgbc_post_item .dg-post-thumb > a:after',
			true
		);
		// meta bottom divider color
		$_ex::apply_element_color(
			$this,
			$render_slug,
			'metabottom_divider_color',
			'border-color',
			'%%order_class%% .dgbc_post_item .content-wrapper .post-meta.meta-position-bottom',
			'%%order_class%% .dgbc_post_item:hover .content-wrapper .post-meta.meta-position-bottom',
			true
		);
		// Author color on top
		$_ex::apply_element_color(
			$this,
			$render_slug,
			'author_bg_color',
			'background-color',
			'%%order_class%% .dgbc_post_item .dg-post-thumb span.author',
			'%%order_class%% .dgbc_post_item:hover .dg-post-thumb span.author',
			true
		);
		// Date color on top
		$_ex::apply_element_color(
			$this,
			$render_slug,
			'date_bg_color',
			'background-color',
			'%%order_class%% .dgbc_post_item .dg-post-thumb span.published',
			'%%order_class%% .dgbc_post_item:hover .dg-post-thumb span.published',
			true
		);
		$_ex::apply_element_color(
			$this,
			$render_slug,
			'date_separator_color',
			'background-color',
			'%%order_class%% .dgbc_post_item .dg-post-thumb span.published span.month:after, 
			%%order_class%% .dgbc_post_item .dg-post-thumb span.published span.day:after',
			'%%order_class%% .dgbc_post_item:hover .dg-post-thumb span.published span.month:after, 
			%%order_class%% .dgbc_post_item:hover .dg-post-thumb span.published span.day:after',
			true
		);

		// Apply title margin
		$_ex::apply_margin_padding(
			$this,
			$render_slug, 
			'title_margin', 
			'margin', 
			'%%order_class%% .dgbc_post_item .content-wrapper .dg_bc_title',
			'%%order_class%% .dgbc_post_item:hover .content-wrapper .dg_bc_title'
		);
		// Apply meta margin
		$_ex::apply_margin_padding(
			$this,
			$render_slug, 
			'meta_margin', 
			'margin', 
			'%%order_class%% .dgbc_post_item .content-wrapper .post-meta',
			'%%order_class%% .dgbc_post_item:hover .content-wrapper .post-meta'
		);
		// Apply meta padding
		$_ex::apply_margin_padding(
			$this,
			$render_slug, 
			'meta_padding', 
			'padding', 
			'%%order_class%% .dgbc_post_item .content-wrapper .post-meta',
			'%%order_class%% .dgbc_post_item:hover .content-wrapper .post-meta'
		);
		// Apply content padding
		$_ex::apply_margin_padding(
			$this,
			$render_slug, 
			'content_padding', 
			'padding', 
			'%%order_class%% .dgbc_post_item .content-wrapper',
			'%%order_class%% .dgbc_post_item:hover .content-wrapper'
		);
		// Apply content margin
		$_ex::apply_margin_padding(
			$this,
			$render_slug, 
			'content_margin', 
			'margin', 
			'%%order_class%% .dgbc_post_item .content-wrapper',
			'%%order_class%% .dgbc_post_item:hover .content-wrapper'
		);
		// Apply button padding
		$_ex::apply_margin_padding(
			$this,
			$render_slug, 
			'button_padding', 
			'padding', 
			'%%order_class%% .dgbc_post_item .dg_read_more_wrapper .read-more',
			'%%order_class%% .dgbc_post_item:hover .dg_read_more_wrapper .read-more'
		);
		// Apply button margin
		$_ex::apply_margin_padding(
			$this,
			$render_slug, 
			'button_margin', 
			'margin', 
			'%%order_class%% .dgbc_post_item .dg_read_more_wrapper .read-more',
			'%%order_class%% .dgbc_post_item:hover .dg_read_more_wrapper .read-more'
		);
		// Apply button wrapper margin
		$_ex::apply_margin_padding(
			$this,
			$render_slug, 
			'button_wrp_margin', 
			'margin', 
			'%%order_class%% .dgbc_post_item .dg_read_more_wrapper',
			'%%order_class%% .dgbc_post_item:hover .dg_read_more_wrapper'
		);
		// Apply inner container padding
		$_ex::apply_margin_padding(
			$this,
			$render_slug, 
			'inner_container_padding', 
			'padding', 
			'%%order_class%% .swiper-container',
			'%%order_class%% .swiper-container:hover'
		);
		// Apply inner container padding
		$_ex::apply_margin_padding(
			$this,
			$render_slug, 
			'post_content_padding', 
			'padding', 
			'%%order_class%% .dgbc_post_item .post-content',
			'%%order_class%% .dgbc_post_item:hover .post-content'
		);
		
		// Equal height
		if( 'off' !== $this->props['equal_height']) {
            ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%%.dgbc_blog_carousel .dgbc_carousel_wrapper .swiper-wrapper .dgbc_post_item, 
					%%order_class%%.dgbc_blog_carousel .dgbc_carousel_wrapper .swiper-wrapper .dgbc_post_inner_wrapper',
                'declaration' => 'height:100%;',
            ) );
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '%%order_class%%.dgbc_blog_carousel .dgbc_carousel_wrapper .swiper-wrapper .dgbc_post_item .content-wrapper',
                'declaration' => 'flex-grow: 1;',
            ) );
		}
		if( 'on' !== $this->props['equal_height'] && '' !== $this->props['item_vertical_align']) {
            ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => '%%order_class%%.dgbc_blog_carousel .dgbc_carousel_wrapper .swiper-wrapper .dgbc_post_item,
					%%order_class%%.dgbc_blog_carousel .dgbc_carousel_wrapper .swiper-wrapper .dgbc_post_inner_wrapper',
                'declaration' => sprintf('align-self:%1$s;', $this->props['item_vertical_align']),
            ) );
		}
		// button background
		$_ex::apply_element_color(
			$this,
			$render_slug,
			'button_bg_color',
			'background-color',
			'%%order_class%% .dgbc_post_item .dg_read_more_wrapper .read-more',
			'%%order_class%% .dgbc_post_item:hover .dg_read_more_wrapper .read-more',
			true
		);
		// button alignment
		if ('' !== $this->props['button_alignment']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => '%%order_class%% .dgbc_post_item .dg_read_more_wrapper',
				'declaration' => sprintf('text-align: %1$s;', $this->props['button_alignment']),
			));
		}
		// button fullwidth
		if ('on' === $this->props['button_fullwidth']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => '%%order_class%% .dgbc_post_item .dg_read_more_wrapper .read-more',
				'declaration' => 'display: block;',
			));
		}

		// arrow font size
		if(isset($this->props['arrow_font_size']) && '' !== $this->props['arrow_font_size']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => '%%order_class%% .dgbc_carousel_wrapper .swiper-button-next, 
				%%order_class%% .dgbc_carousel_wrapper .swiper-button-prev',
				'declaration' => sprintf('font-size:%1$s;width:%1$s; height:%1$s;', 
				$this->props['arrow_font_size']),
			));
		}
		if(isset($this->props['arrow_font_size_tablet']) && '' !== $this->props['arrow_font_size_tablet']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => '%%order_class%% .dgbc_carousel_wrapper .swiper-button-next, 
				%%order_class%% .dgbc_carousel_wrapper .swiper-button-prev',
				'declaration' => sprintf('font-size:%1$s;width:%1$s; height:%1$s;', 
				$this->props['arrow_font_size_tablet']),
				'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
			));
		}
		if(isset($this->props['arrow_font_size_phone']) && '' !== $this->props['arrow_font_size_phone']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => '%%order_class%% .dgbc_carousel_wrapper .swiper-button-next, 
				%%order_class%% .dgbc_carousel_wrapper .swiper-button-prev',
				'declaration' => sprintf('font-size:%1$s;width:%1$s; height:%1$s;', 
				$this->props['arrow_font_size_phone']),
				'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
			));
		}
		// arrow color settings
		$_ex::apply_element_color(
			$this,
			$render_slug,
			'arrow_color',
			'color',
			'%%order_class%% .dgbc_carousel_wrapper .swiper-button-next:after,%%order_class%% .dgbc_carousel_wrapper .swiper-button-prev:after',
			'%%order_class%% .dgbc_carousel_wrapper .swiper-button-next:hover:after,%%order_class%% .dgbc_carousel_wrapper .swiper-button-prev:hover:after',
			true
		);
		$_ex::apply_element_color(
			$this,
			$render_slug,
			'arrow_background_color',
			'background-color',
			'%%order_class%% .dgbc_carousel_wrapper .swiper-button-next,%%order_class%% .dgbc_carousel_wrapper .swiper-button-prev',
			'%%order_class%% .dgbc_carousel_wrapper .swiper-button-next:hover,%%order_class%% .dgbc_carousel_wrapper .swiper-button-prev:hover',
			true
		);
		// arrow alignment
		if ('' !== $this->props['arrow_alignment']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => '%%order_class%% .dgbc_carousel_wrapper .swiper-buttton-container',
				'declaration' => sprintf('justify-content: %1$s;', $alignment[$this->props['arrow_alignment']]),
			));
		}
		if ('' !== $this->props['arrow_spacebetweent']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => '%%order_class%% .dgbc_carousel_wrapper .swiper-button-prev',
				'declaration' => sprintf('margin-right: %1$s;', $this->props['arrow_spacebetweent']),
			));
		}
		// dot navigation
		if ('' !== $this->props['dot_alignment']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => '%%order_class%% .dgbc_carousel_wrapper .swiper-pagination',
				'declaration' => sprintf('text-align: %1$s !important;', $this->props['dot_alignment']),
			));
		}
		if ('' !== $this->props['dots_size']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => '%%order_class%% .dgbc_carousel_wrapper .swiper-pagination .swiper-pagination-bullet',
				'declaration' => sprintf('width: %1$s !important; height:%1$s !important;', $this->props['dots_size']),
			));
		}
		if ('' !== $this->props['dots_color']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => '%%order_class%% .dgbc_carousel_wrapper .swiper-pagination .swiper-pagination-bullet',
				'declaration' => sprintf('background: %1$s !important;', $this->props['dots_color']),
			));
		}
		if ('' !== $this->props['dots_active_color']) {
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => '%%order_class%% .dgbc_carousel_wrapper .swiper-pagination .swiper-pagination-bullet-active.swiper-pagination-bullet',
				'declaration' => sprintf('background: %1$s !important;', $this->props['dots_active_color']),
			));
		}

		// Meta position bottom css
		if( 'on' == $this->props['meta_position_bottom'] ) {
			if($this->props['show_more'] !== 'on' || 'on' !== $this->props['button_at_bottom']){
				ET_Builder_Element::set_style($render_slug, array(
					'selector' => '%%order_class%%.dgbc_blog_carousel .dgbc_post_item .post-meta.meta-position-bottom',
					'declaration' => 'margin-top: auto; margin-bottom:0;',
				));
			}
		}

		// border style 
		if($this->props['border_style_all_image'] === '' ){
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => '%%order_class%%.dgbc_blog_carousel .dgbc_post_item .dg-post-thumb img',
				'declaration' => 'border-style:solid;',
			));
		}
		if($this->props['border_style_all_article'] === '' ){
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => '%%order_class%%.dgbc_blog_carousel .dgbc_post_inner_wrapper',
				'declaration' => 'border-style:solid;',
			));
		}
		if($this->props['border_style_all_read_more'] === '' ){
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => '%%order_class%% .dgbc_post_item .dg_read_more_wrapper a',
				'declaration' => 'border-style:solid; bor',
			));
		}
		// overflow styles
		if($this->props['overflow-x'] !== '' ){
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => '%%order_class%%.dgbc_blog_carousel .dgbc_post_inner_wrapper',
				'declaration' => sprintf('overflow-x:%1$s;', $this->props['overflow-x']),
			));
		}
		if($this->props['overflow-y'] !== '' ){
			ET_Builder_Element::set_style($render_slug, array(
				'selector' => '%%order_class%%.dgbc_blog_carousel .dgbc_post_inner_wrapper',
				'declaration' => sprintf('overflow-y:%1$s;', $this->props['overflow-y']),
			));
		}
		
	}

	public function render( $attrs, $content, $render_slug ) {

		$order_class 				= self::get_module_order_class( $render_slug );
		$order_number				= str_replace('_','',str_replace($this->slug,'', $order_class));
		$arrow_classes				= '';
		$overlay_classes    		= '';
		$tablet_spacing 			= $this->props['item_spacing'];
		$mobile_spacing 			= $this->props['item_spacing'];
		$this->additional_css_styles($render_slug);

		wp_enqueue_style( 'wp-mediaelement' );
		wp_enqueue_script( 'wp-mediaelement' );

		$arrow_classes .= 'on' === $this->props['arrow_show_hover'] ? ' arrow-on-hover' : '';
		$arrow_classes .= '2' === $this->props['arrow_position'] ? ' arrow-outside' : '';

		if (isset($this->props['item_spacing_tablet']) && !empty($this->props['item_spacing_tablet'])) {
			$tablet_spacing = $this->props['item_spacing_tablet'];
		}
		if (isset($this->props['item_spacing_mobile']) || !empty($this->props['item_spacing_mobile'])) {
			$mobile_spacing = $this->props['item_spacing_mobile'];
		}

		$data_attr = array(
			'desktop' 			=> $this->props['show_items_desktop'],
			'tablet' 			=> $this->props['show_items_tablet'],
			'mobile' 			=> $this->props['show_items_mobile'],
			'multislide' 		=> $this->props['multislide'],
			'spacing' 			=> $this->props['item_spacing'],
			'speed' 			=> $this->props['transition_duration'],
			'order' 			=> $order_number,
			'arrow' 			=> $this->props['arrow_nav'],
			'dots' 				=> $this->props['dot_nav'],
			'centermode' 		=> $this->props['centermode'],
			'loop' 				=> $this->props['loop'],
			'autoplay' 			=> $this->props['autoplay'],
			'hoverpause' 		=> $this->props['hoverpause'],
			'autoplay_speed' 	=> $this->props['autoplay_speed'],
			'effect' 			=> $this->props['effect'],
			'coverflow' 		=> $this->props['coverflow_rotate'],
			'shadow' 			=> $this->props['slide_shadow'],
			'xlarge' 			=> $this->props['show_items_xlarge'],
			'tablet_spacing'	=> $tablet_spacing,
			'mobile_spacing'	=> $mobile_spacing
		);

		if ($this->props['overlay'] == 'on') {
			$overlay_classes = ' has_overlay';
		}
		
		$data_next_icon = 'on' === $this->props['use_next_icon'] ? 
		sprintf( 'data-icon="%1$s"', esc_attr( et_pb_process_font_icon($this->props['arrow_next_icon']) ) ) : 'data-icon="5"';

		$data_prev_icon = 'on' === $this->props['use_prev_icon'] ? 
		sprintf( 'data-icon="%1$s"', esc_attr( et_pb_process_font_icon($this->props['arrow_prev_icon']) ) ) : 'data-icon="4"';

		$dg_bc_arrows = ($this->props['arrow_nav'] == 'on') ? sprintf('<div class="swiper-button-prev dg-bc-arrow-prev-%1$s" %3$s></div>
		<div class="swiper-button-next dg-bc-arrow-next-%1$s" %2$s></div>', $order_number, $data_next_icon, $data_prev_icon) : '';

		$swiper_button_top = '3' === $this->props['arrow_position']  && ($this->props['arrow_nav'] == 'on') ?
		sprintf('<div class="swiper-buttton-container">%1$s</div>', $dg_bc_arrows) : '';

		$swiper_button_bottom = '';
		$swiper_button_bottom = '3' !== $this->props['arrow_position'] && $this->props['arrow_nav'] == 'on' ? $dg_bc_arrows : '';
		$swiper_button_bottom = '4' === $this->props['arrow_position'] && $this->props['arrow_nav'] == 'on' ? 
		sprintf('<div class="swiper-buttton-container">%1$s</div>', $dg_bc_arrows) : $swiper_button_bottom;

		$dg_bc_dots = ($this->props['dot_nav'] == 'on') ? sprintf('<div class="swiper-pagination dg-bc-dots-%1$s"></div>', $order_number) : '' ;
		
		return sprintf( '<div class="dgbc_carousel_wrapper%6$s%8$s" data-props=\'%3$s\'>
							%7$s
							<div class="swiper-container">
								<div class="swiper-wrapper">%2$s</div>
							</div>%4$s%5$s
						</div>', 
						$this->props['posts_number'],
						$this->get_posts(),
						json_encode($data_attr),
						$swiper_button_bottom,
						$dg_bc_dots,
						$arrow_classes,
						$swiper_button_top,
						$overlay_classes
					);
	}

	/**
     * render pattern or mask markup
     * 
     */
    public function dgbc_render_pattern_or_mask_html( $props, $type ) {
        $html = array(
            'pattern' => '<span class="et_pb_background_pattern"></span>',
            'mask' => '<span class="et_pb_background_mask"></span>'
        );
        return $props == 'on' ? $html[$type] : '';
    }


}

new DGbc_BlogCarousel;
