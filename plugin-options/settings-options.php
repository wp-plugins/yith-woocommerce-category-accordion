<?php
if( !defined( 'ABSPATH' ) )
    exit;

$setting    =    array(

    'settings' => array(

           'section_general_settings'     => array(
            'name' => __( 'General settings', 'ywcca' ),
            'type' => 'title',
            'id'   => 'ywcca_section_general'
        ),

        'show_woocommerce_category' => array(
            'name'    => __( 'Show WooCommerce categories in the accordion', 'ywcca' ),
            'desc'    => '',
            'id'      => 'ywcca_show_wc_category',
            'default' => 'yes',
            'std'     => 'yes',
            'type'    => 'checkbox'
        ),
        'show_wordpress_category' => array(
            'name'    => __( 'Show WordPress categories in accordion', 'ywcca' ),
            'desc'    => '',
            'id'      => 'ywcca_show_wp_category',
            'default' => 'yes',
            'std'     => 'yes',
            'type'    => 'checkbox'
        ),

        'highlight_category' =>  array(
            'name'  =>  __('Highlight the current category', 'ywcca'),
            'desc'  =>  '',
            'id'    =>  'ywcca_highlight_category',
            'type'  =>  'checkbox',
            'default'   =>  'no',
            'std'   =>  'no'
        ),

        'show_wc_sub_category' =>  array(
            'name'  =>  __('Show WooCommerce Subcategories', 'ywcca'),
            'desc'  =>  '',
            'id'    =>  'ywcca_show_wc_sub_category',
            'type'  =>  'checkbox',
            'default'   =>  'no',
            'std'   =>  'no'
        ),
        'show_wp_sub_category' =>  array(
            'name'  =>  __('Show WordPress Subcategories', 'ywcca'),
            'desc'  =>  '',
            'id'    =>  'ywcca_show_wp_sub_category',
            'type'  =>  'checkbox',
            'default'   =>  'no',
            'std'   =>  'no'
        ),


        'section_general_settings_end' => array(
            'type' => 'sectionend',
            'id'   => 'ywtm_section_general_end'
        )
    )
);

return apply_filters( 'yith_wc_category_accordion_options', $setting );