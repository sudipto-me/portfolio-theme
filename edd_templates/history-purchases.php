<?php if ( ! empty( $_GET['edd-verify-success'] ) ) : ?>
    <p class="edd-account-verified edd_success">
        <?php _e( 'Your account has been successfully verified!', 'abcd' ); ?>
    </p>
<?php

endif;
/**
 * This template is used to display the purchase history of the current user.
 */
if ( is_user_logged_in() ):
    $payments = edd_get_users_purchases( get_current_user_id(), 20, true, 'any' );
    if ( $payments ) :
        do_action( 'edd_before_purchase_history', $payments ); ?>
        <div class="table-responsive tab_table_content">
            <table id="edd_user_history" class="edd-table table">
                <thead>
                <tr class="edd_purchase_row">
                    <?php do_action( 'edd_purchase_history_header_before' ); ?>
                    <!--                    <th class="edd_purchase_id">--><?php //_e( 'ID', 'abcd' );
                    ?><!--</th>-->
                    <th class="edd_purchase_name"><?php _e( 'Plugin name', 'abcd' ); ?></th>
                    <th class="edd_current_version"><?php _e( 'Current Version', 'abcd' ); ?></th>
                    <th class="edd_purchase_renewal_date"><?php _e( 'Renewal Date', 'abcd' ); ?></th>
                    <th class="edd_purchase_amount"><?php _e( 'Price', 'abcd' ); ?></th>
                    <th class="edd_purchase_actions"><?php _e( 'Actions', 'abcd' ); ?></th>
                    <?php //do_action( 'edd_purchase_history_header_after' );
                    ?>
                </tr>
                </thead>
                
                <?php
                
                foreach ( $payments as $payment ) : ?>
                    <?php $payment = new EDD_Payment( $payment->ID );
                    $payment_id    = $payment->ID;
                    $edd_sl        = edd_software_licensing();
                    $keys          = $edd_sl->get_licenses_of_purchase( $payment->ID );
                    $keys          = apply_filters( 'edd_sl_manage_template_payment_licenses', $keys, $payment_id );
                    if ( $keys ):
                        foreach ( $keys as $license ):
                            ?>
                            <tr class="edd_purchase_row">
                                <?php do_action( 'edd_purchase_history_row_start', $payment_id, $payment->payment_meta ); ?>
                                <td>
                                    <div class="plugin_info">
                                        <?php
                                        $download_id = $edd_sl->get_download_id( $license->ID );
                                        $price_id    = $edd_sl->get_price_id( $license->ID );
                                        ?>
                                        <div class="plugin_img">
                                            <?php
                                            $icons    = get_field( 'icons', $download_id );
                                            $icon_url = $icons['url'];
                                            ?>
                                            <img src="<?php echo $icon_url ? $icon_url : get_template_directory_uri() . '/assets/img/plugin.png' ?>" alt="plugin img" class="plugin_small_icon">
                                        </div>
                                        <div class="plugin_details">
                                            <?php
                                            $license_duration = edd_software_licensing()->get_price_is_lifetime( $download_id, $price_id ) ? 'Lifetime' : 'Yearly';
                                            ?>
                                            <h4><?php echo get_the_title( $download_id ); ?></h4>
                                            <p><?php echo edd_get_price_option_name( $download_id, $price_id ) . ' / ' . $license_duration; ?></p>
                                        </div>
                                    </div>
                                    <!-- /.plugin_info -->
                                </td>
                                <!--                                <td class="edd_purchase_date">--><?php //echo date_i18n( get_option( 'date_format' ), strtotime( $payment->date ) );
                                ?><!--</td>-->
                                <td class="current_version">
                                    <?php
                                        $current_version = get_field('current_version',$download_id);
                                        echo '<p>'.$current_version.'</p>';
                                    ?>
                                </td>
                                <td class="edd_renewal_date">
                                    <?php if ( method_exists( $edd_sl, 'is_lifetime_license' ) && $edd_sl->is_lifetime_license( $license->ID ) ) : ?>
                                        <?php _e( 'Lifetime', 'edd_sl' ); ?>
                                    <?php else: ?>
                                        <?php echo date_i18n( 'F j, Y', $edd_sl->get_license_expiration( $license->ID ) ); ?>
                                    <?php endif; ?>
                                </td>
                                <td class="edd_purchase_amount">
                                    <span class="edd_purchase_amount"><span class="edd-currency-code"><?php echo edd_currency_symbol() ?></span><?php echo edd_format_amount( $payment->total ); ?></span>
                                </td>
                                <td class="edd_purchase_actions">
                                    <div class="table_action">
                                        <ul>
                                            <?php
                                            $payment_key = edd_get_payment_key( $payment_id );
                                            $email       = edd_get_payment_user_email( $payment_id );
                                            $limit       = edd_get_file_download_limit( $download_id );
                                            if ( ! empty( $limit ) ) {
                                                // Increase the file download limit when generating new links
                                                edd_set_file_download_limit_override( $download_id, $payment_id );
                                            }
                                            $files = edd_get_download_files( $download_id, $price_id );
                                            if ( ! $files ) {
                                                die( '-4' );
                                            }
                                            
                                            $file_urls = '';
                                            $file_name = '';
                                            
                                            foreach ( $files as $file_key => $file ) {
                                                $file_urls .= edd_get_download_file_url( $payment_key, $email, $file_key, $download_id, $price_id );
                                                $file_urls .= "\n\n";
                                            }
                                            ?>
                                            <li><a href="<?php echo $file_urls; ?>" class="download_"><i class="fa fa-download" aria-hidden="true"></i></a></li>
                                            <?php if ( ! edd_software_licensing()->is_lifetime_license( $license->ID ) ): ?>
                                                <li><a href="<?php echo edd_software_licensing()->get_renewal_url( $license->ID ); ?>" title="<?php esc_attr_e( 'Renew license', 'abcd' ); ?>" class="edd_license_upgrade"><i class="fa fa-refresh" aria-hidden="true"></i></a></li><?php endif; ?>
                                            <li>
                                                <span class="view-key-wrapper">
                                                    <a href="#" class="edd_sl_show_key" title="<?php _e( 'Click to view license key', 'edd_sl' ); ?>" data-toggle="modal" data-target="#<?php echo 'edd_sl_show_key_' . $payment_id; ?>"><i class="fa fa-key" aria-hidden="true"></i></a>
                                                    <?php
                                                    $billing_cycle = $edd_sl->get_price_is_lifetime( $download_id, $price_id ) ? 'Lifetime' : '1 Year';
                                                    ?>
                                                    <input type="text" readonly="readonly" name="plugin_name" class="edd_plugin_name hide" value="<?php echo get_the_title( $download_id ); ?>">
                                                    <input type="text" name="validation" readonly="readonly" class="edd_plugin_validation hide" value="<?php echo edd_get_price_option_name( $download_id, $price_id ) . ' / ' . $billing_cycle; ?>">
                                                    <input type="text" name="license_keys" readonly="readonly" class="edd_sl_license_key hide" value="<?php echo esc_attr( $edd_sl->get_license_key( $license->ID ) ); ?>"/>
                                                    <input type="text" name="renewal_Date" readonly class="edd_sl_renewal_date hide" value="<?php echo ( method_exists( $edd_sl, 'is_lifetime_license' ) && $edd_sl->is_lifetime_license( $license->ID ) ) ? __( 'Lifetime', 'abcd' ) : date_i18n( 'F j, Y', $edd_sl->get_license_expiration( $license->ID ) ) ?>">
                                                </span>
                                            </li>

                                        </ul>
                                    </div>
                                    <!-- /.table_action -->
                                </td>
                                <?php do_action( 'edd_purchase_history_row_end', $payment->ID, $payment->payment_meta );
                                ?>
                            </tr>
                        <?php
                        endforeach;
                    endif;
                endforeach; ?>
            </table>
        </div>
        <?php
        echo edd_pagination(
            array(
                'type'  => 'purchase_history',
                'total' => ceil( edd_count_purchases_of_customer() / 20 ) // 20 items per page
            )
        );
        ?>
        <?php do_action( 'edd_after_purchase_history', $payments ); ?>
        <?php wp_reset_postdata(); ?>
    <?php else : ?>
        <p class="edd-no-purchases"><?php _e( 'You have not made any purchases', 'abcd' ); ?></p>
    <?php endif;
endif;
