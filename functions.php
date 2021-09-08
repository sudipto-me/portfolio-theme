<?php
/**
 * Functions core functions will go there
 *
 * @since 1.0.0
 */

// don't call the file directly
defined( 'ABSPATH' ) || exit();
/**
 * Theme Setup Functions
 */
require_once dirname( __FILE__ ) . '/includes/setup-functions.php';
/**
 * Codestar Framework
 */
require_once dirname( __FILE__ ) . '/lib/csf/codestar-framework/codestar-framework.php';
/**
 * Admin Options
 */
require_once dirname( __FILE__ ) . '/lib/csf/admin-options.php';
/**
 * metabox
 */
require_once dirname( __FILE__ ) . '/lib/csf/metabox.php';
/**
 * Bootstrap Nav Walker for this theme.
 */
require_once dirname( __FILE__ ) . '/includes/wp_bootstrap_navwalker.php';
/**
 * Theme Widgets Functions
 */
require_once dirname( __FILE__ ) . '/includes/widget-functions.php';
/**
 * Script Functions
 */
require_once dirname( __FILE__ ) . '/includes/script-functions.php';
/**
 * Theme shortcode
 */
require_once dirname( __FILE__ ) . '/includes/theme_shortcode.php';
/**
 * Theme metabox
 */
require_once dirname( __FILE__ ) . '/includes/theme_metabox.php';
require_once dirname( __FILE__ ) . '/includes/theme_cpt.php';
/**
 * Comment walker
 */
require_once dirname( __FILE__ ) . '/classes/class-twentytwenty-walker-comment.php';
/**
 * Template Functions
 */
require_once dirname( __FILE__ ) . '/includes/template-functions.php';

//define theme versions
define( 'PORTFOLIO_THEME_VERSION', '1.0.0' );


function printr( $value ) {
	echo '<pre>';
	print_r( $value );
	echo '</pre>';
}
