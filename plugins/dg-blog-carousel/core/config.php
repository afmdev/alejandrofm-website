<?php
require_once ( __DIR__ . '/settings/settings.php');
DG_Config::set_panels(
    array(
        'dg_blog_carousel'   => __('Blog Carousel Module', "et_builder"),
    )
);
DG_Config::set_sections(array( 
    'dgbc_module_activation' => array(
        'name'  => __( "Activation", "et_builder" ),
        'panel' => 'dg_blog_carousel'
    ), 
    'dgbc_module_docs' => array(
        'name'  => __( "Documentation", "et_builder" ),
        'panel' => 'dg_blog_carousel'
    ), 
));


DG_Config::set_settings(array(
   
    // license key
    'dgbc_license_key_setting' => array(
        'name'  => __( "License Key", "et_builder" ),
        'type'  => 'license',
        'section_slug'  => 'dgbc_module_activation',
        'effected_field' => 'dgbc_license_key_status'
    ),
    'dgbc_license_key_status' => array(
        'name'  => __( "License Status", "et_builder" ),
        'type'  => 'license-status',
        'section_slug'  => 'dgbc_module_activation'
    ),
    // Documentation
    'dgbc_whay_license_key' => array(
        'name'  => __( "Why do I need the license key ?", "et_builder" ),
        'type'  => 'docs',
        'section_slug'  => 'dgbc_module_docs',
        'doc_text'  => __('If you would like to install any future plugin 
                            updates easily through the WordPress plugin page you will need to have the activated license key.<br/>
                            Though you can use the divi module without the license key.', 'et_builder'),
        // 'doc_url'   => "https://www.divigear.com/request-api-key/",
        // 'doc_url_text'   => "Request License Key",
    ),
    'dgbc_request_license' => array(
        'name'  => __( "Request License Key", "et_builder" ),
        'type'  => 'docs',
        'section_slug'  => 'dgbc_module_docs',
        'doc_text'  => __('If you have purchased the plugin from marketplaces instead of the main DiviGear.com 
                            website then you have to manually request the license key.<br/>
                            (If you have bought from DiviGear.com you already have the license key.)', 'et_builder'),
        'doc_url'   => "https://www.divigear.com/request-api-key/",
        'doc_url_text'   => "Request License Key",
    ),
    // 'dgbc_how_to_use' => array(
    //     'name'  => __( "How to use the module", "et_builder" ),
    //     'type'  => 'docs',
    //     'section_slug'  => 'dgbc_module_docs',
    //     'doc_text'  => __('You can get introduced with the plugin settings following the short video.', 'et_builder'),
    //     'doc_url'   => "https://www.youtube.com/watch?v=39LRya6Pzuo",
    //     'doc_url_text'   => "Watch the tutorial",
    // ),
    'dgbc_how_to_update' => array(
        'name'  => __( "How to update the plugin", "et_builder" ),
        'type'  => 'docs',
        'section_slug'  => 'dgbc_module_docs',
        'doc_text'  => __('When there is a new update available for plugins, You can
                            update the plugins both manually or with the WordPress plugin
                            page. You can install these updates within the plugins page only
                            if you have the activated license key.', 'et_builder'),
        // 'doc_url'   => "https://www.divigear.com/request-api-key/",
        // 'doc_url_text'   => "Request License Key",
    ),
    'dgbc_how_get_support' => array(
        'name'  => __( "How can I get support ?", "et_builder" ),
        'type'  => 'docs',
        'section_slug'  => 'dgbc_module_docs',
        'doc_text'  => __('If you are facing any trouble using the plugin please let us know
                            through the below link.', 'et_builder'),
        'doc_url'   => "https://www.divigear.com/product-support/",
        'doc_url_text'   => "Get Support",
    ),
    'dgbc_feature_request' => array(
        'name'  => __( "Feature request", "et_builder" ),
        'type'  => 'docs',
        'section_slug'  => 'dgbc_module_docs',
        'doc_text'  => __('If you have any feature suggestion which is not included within
                        the plugin please let us know. We will try to add the feature if it
                        possible.', 'et_builder'),
        'doc_url'   => "https://www.divigear.com/new-feature-request/",
        'doc_url_text'   => "Request a feature",
    ),
    'dgbc_become_an_affiliate' => array(
        'name'  => __( "Become a partner", "et_builder" ),
        'type'  => 'docs',
        'section_slug'  => 'dgbc_module_docs',
        'doc_text'  => __('Like to be a partner of DiviGear.com, you are welcome.', 'et_builder'),
        'doc_url'   => "https://www.divigear.com/affiliate-registration/",
        'doc_url_text'   => "Become a partner",
    ),
));


