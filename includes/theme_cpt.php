<?php
/**
 * Register custom post type
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function abcd_register_custom_post_type() {
    // Review
    $labels = array(
        'name'               => _x( 'Testimonials', 'post type general name', 'abcd' ),
        'singular_name'      => _x( 'Testimonial', 'post type singular name', 'abcd' ),
        'menu_name'          => _x( 'Testimonials', 'admin menu', 'abcd' ),
        'name_admin_bar'     => _x( 'Testimonial', 'add new on admin bar', 'abcd' ),
        'add_new'            => _x( 'Add New', 'Testimonial', 'abcd' ),
        'add_new_item'       => __( 'Add New Testimonial', 'abcd' ),
        'new_item'           => __( 'New Testimonial', 'abcd' ),
        'edit_item'          => __( 'Edit Testimonial', 'abcd' ),
        'view_item'          => __( 'View Testimonial', 'abcd' ),
        'all_items'          => __( 'All Testimonials', 'abcd' ),
        'search_items'       => __( 'Search Testimonials', 'abcd' ),
        'parent_item_colon'  => __( 'Parent Testimonials:', 'abcd' ),
        'not_found'          => __( 'No testimonials found.', 'abcd' ),
        'not_found_in_trash' => __( 'No testimonials found in Trash.', 'abcd' )
    );
    
    $args = array(
        'labels'             => $labels,
        'description'        => __( 'Testimonial Items for Easy Digital Download Theme', 'abcd' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'theme-testimonial' ),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-format-status',
        'supports'           => array( 'title', 'editor', 'thumbnail', 'feature-image' )
    );
    register_post_type( 'theme-testimonials', $args );
    
    //client image
    $labels = array(
        'name'               => _x( 'Clients', 'post type general name', 'abcd' ),
        'singular_name'      => _x( 'Client', 'post type singular name', 'abcd' ),
        'menu_name'          => _x( 'Clients', 'admin menu', 'abcd' ),
        'name_admin_bar'     => _x( 'Client', 'add new on admin bar', 'abcd' ),
        'add_new'            => _x( 'Add New', 'Client', 'abcd' ),
        'add_new_item'       => __( 'Add New Client', 'abcd' ),
        'new_item'           => __( 'New Client', 'abcd' ),
        'edit_item'          => __( 'Edit Client', 'abcd' ),
        'view_item'          => __( 'View Client', 'abcd' ),
        'all_items'          => __( 'All Clients', 'abcd' ),
        'search_items'       => __( 'Search Clients', 'abcd' ),
        'parent_item_colon'  => __( 'Parent Clients:', 'abcd' ),
        'not_found'          => __( 'No clients found.', 'abcd' ),
        'not_found_in_trash' => __( 'No clients found in Trash.', 'abcd' )
    );
    
    $args = array(
        'labels'             => $labels,
        'description'        => __( 'Client Items for Easy Digital Download Theme', 'abcd' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'client-logos' ),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-admin-customizer',
        'supports'           => array( 'title', 'thumbnail' )
    );
    register_post_type( 'client-logos', $args );
    
    //Faq
    $labels = array(
        'name'               => _x( 'Faqs', 'post type general name', 'abcd' ),
        'singular_name'      => _x( 'Faq', 'post type singular name', 'abcd' ),
        'menu_name'          => _x( 'Faqs', 'admin menu', 'abcd' ),
        'name_admin_bar'     => _x( 'Faq', 'add new on admin bar', 'abcd' ),
        'add_new'            => _x( 'Add New', 'Faq', 'abcd' ),
        'add_new_item'       => __( 'Add New Faq', 'abcd' ),
        'new_item'           => __( 'New Faq', 'abcd' ),
        'edit_item'          => __( 'Edit Faq', 'abcd' ),
        'view_item'          => __( 'View Faq', 'abcd' ),
        'all_items'          => __( 'All Faqs', 'abcd' ),
        'search_items'       => __( 'Search Faqs', 'abcd' ),
        'parent_item_colon'  => __( 'Parent Faqs:', 'abcd' ),
        'not_found'          => __( 'No faqs found.', 'abcd' ),
        'not_found_in_trash' => __( 'No faqs found in Trash.', 'abcd' )
    );
    
    $args = array(
        'labels'             => $labels,
        'description'        => __( 'Faq Items for Easy Digital Download Theme', 'abcd' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'theme-faq-item' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-block-default',
        'supports'           => array( 'title', 'editor' )
    );
    
    register_post_type( 'faq-item', $args );
    
    //Documentations
    $labels = array(
        'name'               => _x( 'Documentations', 'post type general name', 'abcd' ),
        'singular_name'      => _x( 'Documentation', 'post type singular name', 'abcd' ),
        'menu_name'          => _x( 'Documentations', 'admin menu', 'abcd' ),
        'name_admin_bar'     => _x( 'Documentation', 'add new on admin bar', 'abcd' ),
        'add_new'            => _x( 'Add New', 'Documentation', 'abcd' ),
        'add_new_item'       => __( 'Add New Documentation', 'abcd' ),
        'new_item'           => __( 'New Documentation', 'abcd' ),
        'edit_item'          => __( 'Edit Documentation', 'abcd' ),
        'view_item'          => __( 'View Documentation', 'abcd' ),
        'all_items'          => __( 'All Documentations', 'abcd' ),
        'search_items'       => __( 'Search Documentations', 'abcd' ),
        'parent_item_colon'  => __( 'Parent Documentations:', 'abcd' ),
        'not_found'          => __( 'No documentations found.', 'abcd' ),
        'not_found_in_trash' => __( 'No documentations found in Trash.', 'abcd' )
    );
    
    $args = array(
        'labels'             => $labels,
        'description'        => __( 'Documentation Items for Easy Digital Download Theme', 'abcd' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'documentations' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-media-document',
        'supports'           => array( 'title', 'editor' )
    );
    
    register_post_type( 'theme_documentation', $args );
    
    $labels = array(
        'name'              => _x( 'Types', 'taxonomy general name', 'abcd' ),
        'singular_name'     => _x( 'Type', 'taxonomy singular name', 'abcd' ),
        'search_items'      => __( 'Search Types', 'abcd' ),
        'all_items'         => __( 'All Types', 'abcd' ),
        'parent_item'       => __( 'Parent Type', 'abcd' ),
        'parent_item_colon' => __( 'Parent Type:', 'abcd' ),
        'edit_item'         => __( 'Edit Type', 'abcd' ),
        'update_item'       => __( 'Update Type', 'abcd' ),
        'add_new_item'      => __( 'Add New Type', 'abcd' ),
        'new_item_name'     => __( 'New Type Name', 'abcd' ),
        'menu_name'         => __( 'Types', 'abcd' ),
    );
    
    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'documentation_type' ),
    );
    
    //register_taxonomy( 'type', array( 'theme_documentation' ), $args );
}

add_action( 'init', 'abcd_register_custom_post_type' );
