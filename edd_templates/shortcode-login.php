<?php
/**
 * This template is used to display the login form with [edd_login]
 */
global $edd_login_redirect;
if ( ! is_user_logged_in() ):
    //show any error messages after form submission
    ?>
    <div class="login_wrapper">
        <h2><?php echo __( 'Log in to your account', 'abcd' ); ?></h2>
        <div class="login_form">
            <?php
            edd_print_errors(); ?>
            <form id="edd_login_form" class="edd_form custom-login-form" action="" method="post">
                <div class="inp_grp">
                    <label for="edd_user_login"><?php _e( 'Email*', 'abcd' ); ?></label>
                    <input type="text" name="edd_user_login" id="edd_user_login" placeholder="<?php _e( 'Email', 'abcd' ); ?>" class="edd-required edd-input inp_field" required>
                </div>

                <div class="inp_grp">
                    <label for="edd_user_pass"><?php _e( 'Password *', 'abcd' ); ?></label>
                    <input type="password" name="edd_user_pass" id="edd_user_pass" placeholder="Your password" class="edd-password edd-required edd-input inp_field" required>
                </div>

                <div class="form_opt">
                    <div class="inp_grp inp_check">
                        <input type="checkbox" class="inp_field" name="remember_me" id="remember_me" value="forever">
                        <label for="remember_me"><?php _e( 'Remember me', 'abcd' ); ?></label>
                    </div>
                    <a href="<?php echo wp_lostpassword_url(); ?>" class="forget_pass"><?php _e( 'Lost your password', 'abcd' ); ?></a>
                </div>
                <p>
                    <input type="hidden" name="edd_redirect" value="<?php echo $edd_login_redirect; ?>"/>
                    <input type="hidden" name="edd_login_nonce" value="<?php echo wp_create_nonce( 'edd-login-nonce' ); ?>"/>
                    <input type="hidden" name="edd_action" value="user_login"/>
                </p>

                <button type="submit" name="submit_custom_login" class="site_cta"><?php _e( 'Log in', 'abcd' ); ?></button>
                <?php do_action( 'edd_login_fields_after' ); ?>
            </form>
        </div>
        <!-- /.login_form -->
    </div>
    <!-- /.login_wrapper -->
<?php else: ?>
    <?php do_action( 'edd_login_form_logged_in' ); ?>
<?php endif; ?>

