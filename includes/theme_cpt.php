<?php
/**
 * Register custom post type
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
defined( 'ABSPATH' ) || exit();

/**
 * Function to register custom post types
 *
 * @since 1.0.0
 */
function portfolio_register_cpt() {
	// Projects
	$labels = array(
		'name'               => _x( 'Projects', 'post type general name', 'portfolio' ),
		'singular_name'      => _x( 'Project', 'post type singular name', 'portfolio' ),
		'menu_name'          => _x( 'Projects', 'admin menu', 'portfolio' ),
		'name_admin_bar'     => _x( 'Project', 'add new on admin bar', 'portfolio' ),
		'add_new'            => _x( 'Add New', 'Project', 'portfolio' ),
		'add_new_item'       => __( 'Add New Project', 'portfolio' ),
		'new_item'           => __( 'New Project', 'portfolio' ),
		'edit_item'          => __( 'Edit Project', 'portfolio' ),
		'view_item'          => __( 'View Project', 'portfolio' ),
		'all_items'          => __( 'All Projects', 'portfolio' ),
		'search_items'       => __( 'Search Projects', 'portfolio' ),
		'parent_item_colon'  => __( 'Parent Projects:', 'portfolio' ),
		'not_found'          => __( 'No projects found.', 'portfolio' ),
		'not_found_in_trash' => __( 'No projects found in Trash.', 'portfolio' )
	);

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'Project Items for Portfolio Theme', 'portfolio' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'portfolio-project' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'          => 'dashicons-portfolio',
		'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail', 'feature-image' )
	);
	register_post_type( 'portfolio-projects', $args );

	$labels = array(
		'name'              => _x( 'Categories', 'taxonomy general name', 'portfolio' ),
		'singular_name'     => _x( 'Category', 'taxonomy singular name', 'portfolio' ),
		'search_items'      => __( 'Search Categories', 'portfolio' ),
		'all_items'         => __( 'All Categories', 'portfolio' ),
		'parent_item'       => __( 'Parent Category', 'portfolio' ),
		'parent_item_colon' => __( 'Parent Category:', 'portfolio' ),
		'edit_item'         => __( 'Edit Category', 'portfolio' ),
		'update_item'       => __( 'Update Category', 'portfolio' ),
		'add_new_item'      => __( 'Add New Category', 'portfolio' ),
		'new_item_name'     => __( 'New Category Name', 'portfolio' ),
		'menu_name'         => __( 'Categories', 'portfolio' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'project-category' ),
	);
	register_taxonomy( 'project_cat', array( 'portfolio-projects' ), $args );

	// Review
	$labels = array(
		'name'               => _x( 'Testimonials', 'post type general name', 'portfolio' ),
		'singular_name'      => _x( 'Testimonial', 'post type singular name', 'portfolio' ),
		'menu_name'          => _x( 'Testimonials', 'admin menu', 'portfolio' ),
		'name_admin_bar'     => _x( 'Testimonial', 'add new on admin bar', 'portfolio' ),
		'add_new'            => _x( 'Add New', 'Testimonial', 'portfolio' ),
		'add_new_item'       => __( 'Add New Testimonial', 'portfolio' ),
		'new_item'           => __( 'New Testimonial', 'portfolio' ),
		'edit_item'          => __( 'Edit Testimonial', 'portfolio' ),
		'view_item'          => __( 'View Testimonial', 'portfolio' ),
		'all_items'          => __( 'All Testimonials', 'portfolio' ),
		'search_items'       => __( 'Search Testimonials', 'portfolio' ),
		'parent_item_colon'  => __( 'Parent Testimonials:', 'portfolio' ),
		'not_found'          => __( 'No testimonials found.', 'portfolio' ),
		'not_found_in_trash' => __( 'No testimonials found in Trash.', 'portfolio' )
	);

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'Testimonial Items for Portfolio Site', 'portfolio' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'portfolio-testimonial' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'          => 'dashicons-format-status',
		'supports'           => array( 'title', 'editor' )
	);
	register_post_type( 'testimonials', $args );
}

add_action( 'init', 'portfolio_register_cpt' );
