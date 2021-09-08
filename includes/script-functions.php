<?php
/**
 * All script functions goes here
 *
 * @since 1.0.0
 */

function enqueue_style_scripts() {
	$themeTemplateDirectoryUrl = get_template_directory_uri();
	wp_enqueue_style( 'custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto|Roboto+Mono|Inconsolata', false );
	wp_enqueue_style( 'custom-material-icons', '//cdn.materialdesignicons.com/2.0.46/css/materialdesignicons.min.css', false );
	wp_enqueue_style( 'portfolio-main', $themeTemplateDirectoryUrl . '/assets/css/main.css', '', PORTFOLIO_THEME_VERSION, 'all' );
	if ( ! is_admin() && ! wp_script_is( 'jquery' ) ) {
		wp_enqueue_script( 'jquery' );
	}

	wp_enqueue_script( 'portfolio-popper-js', $themeTemplateDirectoryUrl . '/assets/js/popper.min.js', array( 'jquery' ), PORTFOLIO_THEME_VERSION, true );
	wp_enqueue_script( 'portfolio-bootstrap-js', $themeTemplateDirectoryUrl . '/assets/js/bootstrap.min.js', array( 'jquery' ), PORTFOLIO_THEME_VERSION, true );
	wp_enqueue_script( 'portfolio-jquery-waypoints-js', $themeTemplateDirectoryUrl . '/assets/js/jquery.waypoints.js', array( 'jquery' ), PORTFOLIO_THEME_VERSION, true );
	wp_enqueue_script( 'portfolio-progress-list-js', $themeTemplateDirectoryUrl . '/assets/js/progress-list.js', array( 'jquery' ), PORTFOLIO_THEME_VERSION, true );
	wp_enqueue_script( 'portfolio-section-js', $themeTemplateDirectoryUrl . '/assets/js/section.js', array( 'jquery' ), PORTFOLIO_THEME_VERSION, true );
	wp_enqueue_script( 'portfolio-style-switcher-js', $themeTemplateDirectoryUrl . '/assets/js/style-switcher.js', array( 'jquery' ), PORTFOLIO_THEME_VERSION, true );
	wp_enqueue_script( 'portfolio-menu-js', $themeTemplateDirectoryUrl . '/assets/js/menu.js', array( 'jquery' ), PORTFOLIO_THEME_VERSION, true );
	wp_enqueue_script( 'portfolio-mobile-menu-js', $themeTemplateDirectoryUrl . '/assets/js/mobile-menu.js', array( 'jquery' ), PORTFOLIO_THEME_VERSION, true );
	wp_enqueue_script( 'portfolio-filter-js', $themeTemplateDirectoryUrl . '/assets/js/portfolio-filter.js', array( 'jquery' ), PORTFOLIO_THEME_VERSION, true );

}

add_action( 'wp_enqueue_scripts', 'enqueue_style_scripts' );