<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 */

/**
 * Adds custom classes to the array of post classes.
 *
 * @param array $classes Classes for the post element.
 *
 * @return array
 */
if ( ! function_exists( 'portfolio_add_custom_class' ) ) :
	function portfolio_add_custom_class( array $classes ) {
		$classes[] = 'article';

		return $classes;
	}
endif;
add_filter( 'post_class', 'portfolio_add_custom_class' );