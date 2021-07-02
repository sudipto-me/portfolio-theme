<?php
/**
 * Log-in the User
 *
 * This function accepts various parameters that are used for checking whether the user exists or not.
 *
 * @param int     $user_id       The ID of the user.
 * @param string  $user_login    The users username/email.
 * @param string  $user_pass     Password of the user.
 * @param boolean $user_remember Whether to remember the user credentials or not.
 *
 * @return void Return early if the user doesn't exist.
 * @since  1.0.0
 *
 * @author WebsiteGuider
 **/

function custom_log_userin( $user_id, $user_login, $user_pass, $user_remember = false ) {
    if ( ! absint( $user_id ) || $user_id < 1 ) {
        return;
    }
    
    wp_set_auth_cookie( $user_id, $user_remember );
    wp_set_current_user( $user_id, $user_login );
    do_action( 'wp_login', $user_login, get_userdata( $user_id ) );
}

/**
 * Custom Error Set
 */
function custom_error_set( $id, $value ) {
    global $error_json;
    
    if ( is_null( $value ) ) {
        unset( $error_json );
        
        return;
    }
    
    $id = sanitize_key( $id );
    
    if ( is_array( $value ) ) {
        $error_json[ $id ] = wp_json_encode( $value );
    } else {
        $error_json[ $id ] = esc_attr( $value );
    }
    
    return $error_json;
}

/**
 * Custom error get
 */
function custom_error_get( $id ) {
    global $error_json;
    
    $maybe_decode_json = json_decode( $error_json[ $id ] );
    
    if ( ! is_null( $maybe_decode_json ) && ! is_array( $maybe_decode_json ) ) {
        $maybe_decode_json = json_decode( $error_json[ $id ], true );
    } else {
        $maybe_decode_json = false;
    }
    
    return $maybe_decode_json;
}

function custom_get_errors() {
    return custom_error_get( 'custom-errors' );
}

function custom_output_error( $id, $value ) {
    $errors = custom_get_errors();
    if ( ! $errors ) {
        $errors = array();
    }
    $errors[ $id ] = $value;
    custom_error_set( 'custom-errors', $errors );
}

function custom_print_errors() {
    $errors = custom_get_errors();
    if ( ! empty( $errors ) ) {
        ?>
        <div class="custom-error">
            <?php
            foreach ( $errors as $error_id => $error ) {
                echo '<p class="error_' . $error_id . '"><strong>Error:</strong> ' . $error . '</p>';
            }
            ?>
        </div>
        <?php
    }
}

function custom_html_login_form( $custom_redirect ) {
    if ( ! is_user_logged_in() ) {
        ?>
        <div class="login_wrapper">
            <h2><?php echo __( 'Log in to your account', 'abcd' ); ?></h2>
            <div class="login_form">
                <style type="text/css">
                    .custom-error {
                        margin-bottom: 10px;
                        padding: 10px;
                        background-color: #d64646;
                        color: white;
                        border-radius: 5px;
                    }

                    .custom-error p {
                        margin: 0;
                    }
                </style>
                <?php custom_print_errors(); ?>
                <form method="POST" class="custom-login-form">
                    <div class="inp_grp">
                        <label for="custom-user"><?php _e( 'User Name *', 'abcd' ); ?></label>
                        <input type="text" name="custom_user" id="custom-user" placeholder="<?php _e( 'Your email or username', 'abcd' ); ?>" class="inp_field">
                    </div>
                    <div class="inp_grp">
                        <label for="custom-pass"><?php _e( 'Password *', 'abcd' ); ?></label>
                            <input type="password" name="custom_pass" id="custom-pass" placeholder="Your password" class="inp_field">
                    </div>
                    <div class="form_opt">
                        <div class="inp_grp inp_check">
                            <input type="checkbox" class="inp_field" name="remember_me" id="remember_me">
                            <label for="remember_me"><?php _e( 'Remember me', 'abcd' ); ?></label>
                        </div>
                        <a href="<?php echo wp_lostpassword_url(); ?>" class="forget_pass"><?php _e( 'Lost your password', 'abcd' ); ?></a>
                    </div>
                    <p>
                        <input type="hidden" name="custom_login_nonce" value="<?php echo wp_create_nonce( 'custom-login-nonce' ); ?>"/>
                        <input type="hidden" name="custom_redirection" value="<?php echo esc_url( $custom_redirect ); ?>"/>
                    </p>
                    <button type="submit" name="submit_custom_login" class="site_cta"><?php _e('Log in','abcd');?></button>
                </form>
            </div>
            <!-- /.login_form -->
        </div>
        <!-- /.login_wrapper -->
        <?php
    } else {
        _e( "You are logged in", 'abcd' );
    }
}

add_action( 'init', 'process_custom_login_form' );

/**
 * Process the Log-In form
 *
 * This callback function is called before any headers are sent.
 * With this function you can validate the user details submitted by him using our log-in form.
 *
 * @return void
 * @since  1.0.0
 *
 * @author WebsiteGuider
 **/

function process_custom_login_form() {
    // Validate the username or email field before submitting
    if ( isset( $_POST['custom_user'] ) ) {
        $custom_user = trim( $_POST['custom_user'] );
    }
    
    // Validate password field before submitting
    if ( isset( $_POST['custom_pass'] ) ) {
        $custom_pass = trim( $_POST['custom_pass'] );
    }
    
    if ( wp_verify_nonce( ( isset( $_POST['custom_login_nonce'] ) ? $_POST['custom_login_nonce'] : '' ), 'custom-login-nonce' ) ) {
        $user_info = get_user_by( 'login', $custom_user );
        
        if ( ! $user_info ) {
            $user_info = get_user_by( 'email', $custom_user );
        }
        
        if ( $user_info ) {
            $user_id = $user_info->ID;
            if ( wp_check_password( $custom_pass, $user_info->user_pass, $user_id ) ) {
                if ( isset( $_POST['remember_me'] ) ) {
                    $_POST['remember_me'] = true;
                } else {
                    $_POST['remember_me'] = false;
                }
                
                custom_log_userin( $user_id, $custom_user, $custom_pass, $_POST['remember_me'] );
                wp_redirect( $_POST['custom_redirection'] );
                die;
            } else {
                custom_output_error( 'wrong_password', 'The password you entered is incorrect.' );
            }
        } else {
            custom_output_error( 'wrong_username', 'The username you entered is incorrect.' );
        }
    }
}

/**
 * Shortcode for showing Sign In form.
 *
 * Use [custom_login] shortcode in page, post, or widget to display the log-in form.
 *
 * @param array $atts The list of attributes passed when calling the shortcode.
 *
 * @since  1.0.0
 *
 * @author WebsiteGuider
 **/

function shortcode_custom_login( $atts ) {
    if ( isset( $atts['redirect'] ) ) {
        $custom_redirect = $atts['redirect'];
    }
    
    if ( empty( $atts['redirect'] ) ) {
        $custom_redirect = home_url().'/wp-admin';
    }
    
    
    // Start Output buffering
    ob_start();
    // Output the HTML form here
    custom_html_login_form( $custom_redirect );
    
    // End Output buffering by returning it
    return ob_get_clean();
}

add_shortcode( 'custom_login', 'shortcode_custom_login' );



