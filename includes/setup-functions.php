<?php
/**
 * Theme Setup function goes here
 *
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit();

/**
 * Base theme setup functions
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'portfolio_setup' ) ) :
	function portfolio_setup() {
		load_theme_textdomain( 'portfolio', get_template_directory() . '/languages' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'script',
			'style',
		) );
		add_theme_support( 'title-tag' );
		register_nav_menus( array(
			'primary_navigation' => __( 'Primary Navigation', 'portfolio' ),
		) );
		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'align-wide' );
		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'portfolio_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);
		add_filter( 'widget_text', 'do_shortcode' );
	}
endif;
add_action( 'after_setup_theme', 'portfolio_setup' );

/**
 * Custom Excerpt Length
 *
 * @return int
 * @since 1.0.0
 */
function custom_excerpt_length() {
	return 25;
}

add_filter( 'excerpt_length', 'custom_excerpt_length' );

/**
 * Custom Read more
 *
 * @return string
 * @since 1.0.0
 */
function custom_read_more() {
	return '...';
}

add_filter( 'excerpt_more', 'custom_read_more' );



