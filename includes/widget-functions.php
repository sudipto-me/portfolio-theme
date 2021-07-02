<?php
/**
 * Widgets Functions goes here
 *
 * @since 1.0.0
 */
defined( 'ABSPATH' ) || exit();

/**
 * Custom Widgets Functions
 *
 * @since 1.0.0
 */
function portfolio_custom_widgets() {
	register_sidebar(
		array(
			'name'          => __( 'General Sidebar', 'portfolio' ),
			'id'            => 'general-sidebar',
			'description'   => '',
			'class'         => 'sidebar',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
	register_sidebar(
		array(
			'name'          => __( 'Blog Sidebar', 'abcd' ),
			'id'            => 'blog-sidebar',
			'description'   => '',
			'class'         => 'sidebar',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
	register_sidebar(
		array(
			'name'          => __( 'Footer Widget Area 1', 'portfolio' ),
			'id'            => 'footer-widget-area-1',
			'description'   => '',
			'class'         => 'sidebar',
			'before_widget' => '<aside id="%1$s" class="abcd_footer-content %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget_title">',
			'after_title'   => '</h3>',
		)
	);
	register_sidebar(
		array(
			'name'          => __( 'Footer Widget Area 2', 'portfolio' ),
			'id'            => 'footer-widget-area-2',
			'description'   => '',
			'class'         => 'sidebar',
			'before_widget' => '<aside id="%1$s" class="abcd_footer-content %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget_title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'portfolio_custom_widgets' );