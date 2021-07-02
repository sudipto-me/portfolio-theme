<?php
/**
 * This template is used to display the profile editor with [edd_profile_editor]
 */
global $current_user;
if ( is_user_logged_in() ):
    $user_id = get_current_user_id();
    $first_name = get_user_meta( $user_id, 'first_name', true );
    $last_name = get_user_meta( $user_id, 'last_name', true );
    $display_name = $current_user->display_name;
    $address = edd_get_customer_address( $user_id );
    $states = edd_get_shop_states( $address['country'] );
    $state = $address['state'];
    
    if ( edd_is_cart_saved() ): ?>
        <?php $restore_url = add_query_arg( array( 'edd_action' => 'restore_cart', 'edd_cart_token' => edd_get_cart_token() ), edd_get_checkout_uri() ); ?>
        <div class="edd_success edd-alert edd-alert-success"><strong><?php _e( 'Saved cart', 'abcd' ); ?>:</strong> <?php printf( __( 'You have a saved cart, <a href="%s">click here</a> to restore it.', 'abcd' ), esc_url( $restore_url ) ); ?></div>
    <?php endif; ?>
    
    <?php if ( isset( $_GET['updated'] ) && $_GET['updated'] == true && ! edd_get_errors() ): ?>
    <div class="edd_success edd-alert edd-alert-success"><strong><?php _e( 'Success', 'abcd' ); ?>:</strong> <?php _e( 'Your profile has been edited successfully.', 'abcd' ); ?></div>
<?php endif; ?>

    <div class="profile_form">
        <?php edd_print_errors(); ?>
        <?php do_action( 'edd_profile_editor_before' ); ?>

        <form action="<?php echo edd_get_current_page_url(); ?>" id="edd_profile_editor_form">
            <h4><?php _e( 'General Information', 'abcd' ); ?></h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="inp_grp">
                        <label for="edd_first_name"><?php _e( 'First Name', 'abcd' ); ?></label>
                        <input name="edd_first_name" id="edd_first_name" type="text" placeholder="David" class="text edd-input inp_field" value="<?php echo esc_attr( $first_name ); ?>">
                    </div>
                </div>
                <!-- /.col-md-6 -->

                <div class="col-md-6">
                    <div class="inp_grp">
                        <label for="edd_last_name"><?php _e( 'Last Name', 'abcd' ); ?></label>
                        <input type="text" id="edd_last_name" name="edd_last_name" placeholder="Kovalev" class="text edd-input inp_field" value="<?php echo esc_attr( $last_name ); ?>">
                    </div>
                </div>
                <!-- /.col-md-6 -->

                <div class="col-md-12">
                    <div class="inp_grp">
                        <label for="edd_email"><?php _e( 'Email', 'abcd' ); ?></label>
                        <?php $customer = new EDD_Customer( $user_id, true );
                        if ( $customer->id > 0 ) :
                            if ( 1 === count( $customer->emails ) ) : ?>
                                <input name="edd_email" id="edd_email" class="text edd-input inp_field required" type="email" value="<?php echo esc_attr( $customer->email ); ?>"/>
                            <?php else: ?>
                                <?php
                                $emails           = array();
                                $customer->emails = array_reverse( $customer->emails, true );
                                
                                foreach ( $customer->emails as $email ) {
                                    $emails[ $email ] = $email;
                                }
                                
                                $email_select_args = array(
                                    'options'          => $emails,
                                    'name'             => 'edd_email',
                                    'id'               => 'edd_email',
                                    'selected'         => $customer->email,
                                    'show_option_none' => false,
                                    'show_option_all'  => false,
                                );
                                echo EDD()->html->select( $email_select_args );
                            endif;
                        else: ?>
                            <input name="edd_email" id="edd_email" class="text edd-input inp_field required" type="email" value="<?php echo esc_attr( $current_user->user_email ); ?>"/>
                        <?php endif; ?>
                        <?php do_action( 'edd_profile_editor_email' ); ?>
                        <?php do_action( 'edd_profile_editor_after_email' ); ?>
                    </div>
                </div>
                <?php do_action( 'edd_profile_editor_after_personal_fields' ); ?>

                <div class="col-md-12">
                    <div class="inp_grp">
                        <label for="edd_address_line1"><?php _e( 'Address Line 1', 'abcd' ); ?></label>
                        <input type="text" name="edd_address_line1" id="edd_address_line1" placeholder="Address Line 1" class="text edd-input inp_field" value="<?php echo esc_attr( $address['line1'] ); ?>">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="inp_grp">
                        <label for="edd_address_line2"><?php _e( 'Address Line 2', 'abcd' ); ?></label>
                        <input type="text" name="edd_address_line2" id="edd_address_line2" placeholder="Address Line 2" class="text edd-input inp_field" <?php echo esc_attr( $address['line2'] ); ?>>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="inp_grp">
                        <label for="edd_address_city"><?php _e( 'City', 'abcd' ); ?></label>
                        <input type="text" name="edd_address_city" id="edd_address_city" placeholder="City" class="text edd-input inp_field" value="<?php echo esc_attr( $address['city'] ); ?>">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="inp_grp">
                        <label for="edd_address_city"><?php _e( 'Post Code', 'abcd' ); ?></label>
                        <input type="text" name="edd_address_city" id="edd_address_city" placeholder="Post Code" class="text edd-input inp_field" value="<?php echo esc_attr( $address['zip'] ); ?>">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="inp_grp">
                        <label for="edd_address_country"><?php _e( 'Country', 'abcd' ); ?></label>
                        <select name="edd_address_country" id="edd_address_country" class="select edd-select inp_field" data-nonce="<?php echo wp_create_nonce( 'edd-country-field-nonce' ); ?>">
                            <?php foreach ( edd_get_country_list() as $key => $country ) : ?>
                                <option value="<?php echo $key; ?>"<?php selected( $address['country'], $key ); ?>><?php echo esc_html( $country ); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="inp_grp">
                        <label for="edd_address_state"><?php _e( 'State / Province', 'abcd' ); ?></label>
                        <?php if ( ! empty( $states ) ) : ?>
                            <select name="edd_address_state" id="edd_address_state" class="select edd-select inp_field">
                                <?php
                                foreach ( $states as $state_code => $state_name ) {
                                    echo '<option value="' . $state_code . '"' . selected( $state_code, $state, false ) . '>' . $state_name . '</option>';
                                }
                                ?>
                            </select>
                        
                        <?php else : ?>
                            <input name="edd_address_state" id="edd_address_state" class="text edd-input inp_field" type="text" value="<?php echo esc_attr( $state ); ?>"/>
                        <?php endif; ?>
                    </div>
                </div>
                <?php do_action( 'edd_profile_editor_address' ); ?>
                <?php do_action( 'edd_profile_editor_after_address_fields' ); ?>
            </div>
            <!-- /.row -->
            <h4><?php _e( 'Reset Password', 'abcd' ); ?></h4>

            <div class="row">
                <div class="col-md-12">
                    <div class="inp_grp">
                        <label for="edd_new_user_pass1"><?php _e( 'New Password', 'abcd' ); ?></label>
                        <input name="edd_new_user_pass1" id="edd_new_user_pass1" type="password" placeholder="New Password" class="password edd-input inp_field">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="inp_grp">
                        <label for="edd_new_user_pass2"><?php _e( 'Re-enter Password', 'abcd' ); ?></label>
                        <input name="edd_new_user_pass2" id="edd_new_user_pass2" placeholder="Enter Again" class="password edd-input inp_field" type="password">
                        <?php do_action( 'edd_profile_editor_password' ); ?>
                    </div>
                </div>

                <!-- /.col-md-12 -->
                <?php do_action( 'edd_profile_editor_after_password' ); ?>
                <?php do_action( 'edd_profile_editor_after_password_fields' ); ?>

                <div class="col-md-12 text-right">
                    <input type="hidden" name="edd_profile_editor_nonce" value="<?php echo wp_create_nonce( 'edd-profile-editor-nonce' ); ?>"/>
                    <input type="hidden" name="edd_action" value="edit_user_profile"/>
                    <input type="hidden" name="edd_redirect" value="<?php echo esc_url( edd_get_current_page_url() ); ?>"/>
                    <input name="edd_profile_editor_submit" id="edd_profile_editor_submit" type="submit" class="edd_submit edd-submit site_cta" value="<?php _e( 'Save Changes', 'abcd' ); ?>"/>

                </div>
            </div>
            <!-- /.row -->
            <?php do_action( 'edd_profile_editor_fields_bottom' ); ?>
        </form>
        <?php do_action( 'edd_profile_editor_after' ); ?>
    </div>
    <!-- /.profile_form -->
<?php
else:
    do_action( 'edd_profile_editor_logged_out' );
endif;