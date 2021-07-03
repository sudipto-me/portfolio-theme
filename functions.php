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
require_once dirname(__FILE__).'/classes/class-twentytwenty-walker-comment.php';
//edd custom files
require_once dirname( __FILE__ ) . '/classes/class-review.php';
require_once dirname( __FILE__ ) . '/includes/custom_edd_functions.php';

// Define path and URL to the ACF plugin.
define( 'THEME_ACF_PATH', get_stylesheet_directory() . '/includes/acf/' );
define( 'THEME_ACF_URL', get_stylesheet_directory_uri() . '/includes/acf/' );
include_once( THEME_ACF_PATH . 'acf.php' );

//define theme verions
define( 'PORTFOLIO_THEME_VERSION', '1.0.0' );

/**
 * Custom logout page
 */
function abcd_redirect_after_logout() {
	//$url = get_home_url() . '/login';
	$url = get_post_type_archive_link( 'download' );
	wp_redirect( $url );
	exit();
}

add_action( 'wp_logout', 'abcd_redirect_after_logout' );

/**
 *  Post types for search
 */
function custom_search_posttype( $query ) {
	if ( $query->is_search && ! is_admin() ) {
		$query->set( 'post_type', array( 'post', 'download', 'theme_documentation' ) );
	}
	if ( isset( $_GET['s'] ) && empty( $_GET['s'] ) && $query->is_main_query() ) {
		$query->is_search = true;
		$query->is_home   = false;
	}
//    if ( is_archive('download') && ! is_admin() && !$query->is_main_query() ) {
//        $query->set( 'posts_per_page', - 1 );
//    }
	if ( is_category() || is_tag() || is_archive() || is_search() ):
		$limit = - 1;
	else :
		$limit = get_option( 'posts_per_page' );
	endif;
	set_query_var( 'posts_per_archive_page', $limit );

	return $query;
}

add_filter( 'pre_get_posts', 'custom_search_posttype' );

/**
 * Add subtitle support to downloads
 *
 */
function edd_add_subtitles_support() {
	add_post_type_support( 'download', 'wps_subtitle' );
}

add_action( 'init', 'edd_add_subtitles_support' );

/**
 * ajax functions for load more logs
 */
function load_more_logs() {
	$post_data      = $_REQUEST;
	$current_page   = $_REQUEST['current_page'];
	$logs_per_click = $_REQUEST['logs_per_click'];
	$download_id    = $_REQUEST['download_id'];

	$logs           = get_field( 'logs', $download_id );
	$logs           = array_reverse( $logs );
	$array_last     = end( array_keys( $logs ) );
	$starting_point = $current_page * $logs_per_click;
	$counter        = 1;
	if ( $logs ) {
		for ( $i = $starting_point; $i < ( $starting_point + $logs_per_click ); $i ++ ) {
			if ( $logs[ $i ] ) {
				?>
                <div class="changelog_timeline_box">
                    <div class="version_no">
                        <p><?php echo $logs[ $i ]['version']; ?></p>
                    </div>
                    <span class="date"><?php echo $logs[ $i ]['release_date']; ?></span>
					<?php echo $logs[ $i ]['log_details']; ?>
                </div>
                <!-- /.changelog_timeline_box -->
				<?php
			}
		}
	}
	die();
}

add_action( 'wp_ajax_load_more_logs', 'load_more_logs' );
add_action( 'wp_ajax_nopriv_load_more_logs', 'load_more_logs' );

//reviews load more
function load_more_reviews() {
	$current_page        = $_REQUEST['current_page'];
	$comments_per_page   = $_REQUEST['comments_per_page'];
	$parent_post_id      = $_REQUEST['parent_post_id'];
	$current_page_number = $_REQUEST['current_page'];

	$reviews = edd_reviews()->query_reviews();
	wp_list_comments( array(
		'walker'   => new Custom_EDD_Review(),
		'page'     => $current_page,
		'per_page' => $comments_per_page,
	), $reviews );
	die();
}

add_action( 'wp_ajax_load_more_reviews', 'load_more_reviews' );
add_action( 'wp_ajax_nopriv_load_more_reviews', 'load_more_reviews' );

//add popup html in the footer
function custom_popup_html() {
	?>
    <div class="modal ss_modal" id="">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <img src="" class="ss_modal_img" alt="">
                </div>
            </div>
        </div>
    </div>
	<?php
}

add_action( 'wp_footer', 'custom_popup_html' );

/**
 * Change custom login url to new url
 */
function custom_login_page( $login_url, $redirect ) {
	$login_page = home_url( '/login/' );
	$login_url  = add_query_arg( 'redirect_to', $redirect, $login_page );

	return $login_url;
}

//add_filter( 'login_url', 'custom_login_page', 10, 2 );

/**
 * Change comment per page
 */
function custom_comment_number( $comments_per_page, $comment_status ) {
	$comments_per_page = 10;

	return $comments_per_page;
}

add_filter( 'comments_per_page', 'custom_comment_number', 10, 2 );

/**
 * Redirect to login page if my-account page is typed when logged out
 */
function my_account_redirect() {
	if ( ! is_user_logged_in() && is_page_template( 'page-my-account.php' ) ) {
		wp_safe_redirect( wp_login_url() );
		die;
	}
}

add_action( 'template_redirect', 'my_account_redirect' );

/**
 *
 */
function edd_comment_by_post_author( $comment = null ) {

	if ( is_object( $comment ) && $comment->user_id > 0 ) {

		$user = get_userdata( $comment->user_id );
		$post = get_post( $comment->comment_post_ID );

		if ( ! empty( $user ) && ! empty( $post ) ) {

			return $comment->user_id === $post->post_author;

		}
	}

	return false;

}

/**
 * Comment form fields update
 */
function custom_comment_form_defaults( $fields ) {
	$commenter     = wp_get_current_commenter();
	$user          = wp_get_current_user();
	$user_identity = $user->exists() ? $user->display_name : '';


	if ( ! isset( $args['format'] ) ) {
		$args['format'] = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';
	}

	$req      = get_option( 'require_name_email' );
	$html_req = ( $req ? " required='required'" : '' );
	$html5    = 'html5' === $args['format'];

	$fields['author'] = sprintf(
		'<div class="form_author_wrapper"><p class="comment-form-author">%s %s</p>',
		sprintf(
			'<label for="author">%s%s</label>',
			__( 'Name', 'abcd' ),
			( $req ? ' <span class="required">*</span>' : '' )
		),
		sprintf(
			'<input id="author" name="author" type="text" value="%s" size="30" maxlength="245"%s />',
			esc_attr( $commenter['comment_author'] ),
			$html_req
		) );

	$fields['email'] = sprintf(
		'<p class="comment-form-email">%s %s</p></div>',
		sprintf(
			'<label for="email">%s%s</label>',
			__( 'Email', 'abcd' ),
			( $req ? ' <span class="required">*</span>' : '' )
		),
		sprintf(
			'<input id="email" name="email" %s value="%s" size="30" maxlength="100" aria-describedby="email-notes"%s />',
			( $html5 ? 'type="email"' : 'type="text"' ),
			esc_attr( $commenter['comment_author_email'] ),
			$html_req
		)
	);
	$fields['url']   = sprintf(
		'<p class="comment-form-url">%s %s</p>',
		sprintf(
			'<label for="url">%s%s</label>',
			__( 'Website', 'abcd' ),
			__( ' (Optional) ', 'abcd' )
		),
		sprintf(
			'<input id="url" name="url" %s value="%s" size="30" maxlength="200" />',
			( $html5 ? 'type="url"' : 'type="text"' ),
			esc_attr( $commenter['comment_author_url'] )
		)

	);

	return $fields;
}

add_filter( 'comment_form_default_fields', 'custom_comment_form_defaults' );

/**
 * Change comment author name
 */
function change_comment_author_name( $author = '', $comment_ID, $comment ) {
	$comment = get_comment( $comment_ID );
	if ( ! empty( $comment->comment_author ) ) {
		if ( ! empty( $comment->user_id ) ) {
			$user   = get_userdata( $comment->user_id );
			$author = $user->first_name . ' ' . $user->last_name; // this is the actual line you want to change
		} else {
			$author = $comment->comment_author;
		}
	}

	return $author;
}

add_filter( 'get_comment_author', 'change_comment_author_name', 10, 3 );

/*
 *
 * Comment form validation
 *
 */
function custom_comment_validation_init() {
	if ( is_single() && comments_open() ) { ?>
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $('#commentform').validate({
                    rules: {
                        author: {
                            required: true,
                            minlength: 2
                        },
                        email: {
                            required: true,
                            email: true
                        },
                        comment: {
                            required: true,
                            minlength: 20
                        }
                    },
                    messages: {
                        author: "The field is required",
                        email: "The field is required",
                        comment: "The field is required"
                    },
                    errorElement: "span",
                    errorPlacement: function (error, element) {
                        element.after(error);
                    }

                });
            });
        </script>
		<?php
	}
}

add_action( 'wp_footer', 'custom_comment_validation_init' );

//add license key popup html in the footer
function license_popup_html() {
	?>
    <div class="modal lk_modal" id="">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h3><?php _e( 'License Key Details', 'abcd' ); ?></h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="plugin_name">
                        <p><?php _e( 'Plugin Name: ', 'abcd' ); ?></p>
                        <span></span>
                    </div>
                    <!-- /.plugin_name -->
                    <div class="license_validation">
                        <p><?php _e( 'License Key Valid For: ', 'abcd' ); ?></p>
                        <span></span>
                    </div>
                    <div class="key">
                        <p><?php _e( 'License Key: ', 'abcd' ) ?></p>
                        <span></span>
                    </div>
                    <div class="renewal_date">
                        <p><?php _e( 'Expiration Date: ', 'abcd' ); ?></p>
                        <span></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php _e( 'Close', 'abcd' ); ?></button>
                </div>
            </div>
        </div>
    </div>
	<?php
}

add_action( 'wp_footer', 'license_popup_html' );

function custom_edd_subscriber_user_role( $args, $payment_id, $payment_data ) {
	$args['role'] = 'edd_subscriber';

	return $args;
}

add_filter( 'edd_auto_register_insert_user_args', 'custom_edd_subscriber_user_role', 10, 3 );
//add_filter( 'edd_auto_register_insert_user_args', function ( $args ) {
//    return array_merge( $args, array( 'role' => 'edd_subscriber' ) );
//} );

//update acf assets url
add_filter( 'acf/settings/url', 'theme_acf_settings_url' );
function theme_acf_settings_url( $url ) {
	return THEME_ACF_URL;
}

// remove cookie after logout
function remove_cookie_after_logout() {
	if ( isset( $_COOKIE['tab'] ) ) {
		setcookie( "tab", "", time() - 3600 );
	}
}

add_action( 'wp_logout', 'remove_cookie_after_logout' );

//search plugin docs
function search_plugin_docs() {
	$plugin_name = $_REQUEST['search_value'];
	$plugin_name = get_page_by_title( $plugin_name, OBJECT, 'download' );
	$plugin_id   = '';
	if ( ! is_a( $plugin_name, 'post' ) ) {
		$plugin_id = $plugin_name->ID;
	}
	if ( $plugin_id != '' ) {
		$args           = array(
			'post_type'      => 'download',
			'post_status'    => 'publish',
			'posts_per_page' => - 1,
			'orderby'        => 'title',
			'order'          => 'ASC',
			'p'              => $plugin_id
		);
		$plugins        = get_posts( $args );
		$documentations = get_posts(
			array(
				'post_type'      => 'theme_documentation',
				'posts_per_page' => - 1,
				'post_status'    => 'publish',
			)
		);
		foreach ( $plugins as $plugin ) {
			$icons    = get_field( 'icons', $plugin->ID );
			$icon_url = $icons['url'];
			?>
            <div class="single_plugin_docs">
                <h4><img src="<?php echo $icon_url ? $icon_url : get_template_directory_uri() . '/assets/img/plugin.png' ?>" alt="plugin thumbnail" class="plugin_icon"><a href="<?php echo get_the_permalink( $plugin->ID ) ?>"><?php echo get_the_title( $plugin->ID ); ?></a></h4>
                <div class="docs">
					<?php
					$docs_id = array();
					foreach ( $documentations as $single ) {
						$related_downloads = get_post_meta( $single->ID, 'documentaion-download', true );
						$related_downloads = array_values( $related_downloads );
						if ( is_array( $related_downloads ) && count( $related_downloads ) ) {
							if ( in_array( $plugin->ID, $related_downloads ) ) {
								$docs_id[] = $single->ID;
							}
						}
					}
					sort( $docs_id );
					if ( is_array( $docs_id ) && count( $docs_id ) ) {
						foreach ( $docs_id as $ids ) {
							?>
                            <div class="single_docs">
                                <a href="<?php echo get_the_permalink( $ids ); ?>" class="docs-item"><?php echo get_the_title( $ids ); ?></a>
                            </div>
							<?php
						}
					} else {
						?>
                        <div class="alert alert-secondary docs-alert"><?php _e( 'Nothing found', 'abcd' ); ?></div>
					<?php } ?>
                </div>
                <!-- /.docs -->
            </div>
            <!-- /.single_plugin_section -->
			<?php
		}
	} else {
		?>
        <div class="search_no_result">
            <img src="<?php echo get_template_directory_uri() . '/assets/img/search_error.png' ?>" alt="search-error" class="img-fluid search_error_img">
        </div>
		<?php
	}

	wp_die();
}

add_action( 'wp_ajax_search_plugin_docs', 'search_plugin_docs' );
add_action( 'wp_ajax_nopriv_search_plugin_docs', 'search_plugin_docs' );



