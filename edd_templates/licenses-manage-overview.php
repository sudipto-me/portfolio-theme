<?php
$payment_id = isset( $_GET['payment_id'] ) ? $_GET['payment_id'] : 0;
$user_id    = ! empty( $payment_id ) ? edd_get_payment_user_id( $payment_id ) : get_current_user_id();
if ( ! current_user_can( 'edit_shop_payments' ) && $user_id != get_current_user_id() ) {
    return;
}
$color = edd_get_option( 'checkout_color', 'gray' );
$color = ( $color == 'inherit' ) ? '' : $color;

// Retrieve all license keys for the specified payment
$edd_sl = edd_software_licensing();
$keys   = ! empty( $payment_id ) ? $edd_sl->get_licenses_of_purchase( $payment_id ) : $edd_sl->get_license_keys_of_user( $user_id );
if ( $keys ) : ?>
    <div class="table-responsive tab_table_content">
        <table id="edd_sl_license_keys" class="edd_sl_table table">
            <thead>
            <tr class="edd_sl_license_row">
                <?php do_action( 'edd_sl_license_header_before' ); ?>
                <th class="edd_sl_item"><?php _e( 'Plugins', 'abcd' ); ?></th>
                <th class="edd_sl_status"><?php _e( 'Status', 'abcd' ); ?></th>
                <th class="edd_sl_limit"><?php _e( 'Activations', 'abcd' ); ?></th>
                <?php if ( ! $edd_sl->force_increase() ) : ?>
                    <th class="edd_sl_sites"><?php _e( 'Sites', 'abcd' ); ?></th>
                <?php endif; ?>
                <th class="edd_sl_upgrades"><?php _e( 'Upgrades', 'abcd' ); ?></th>
                <?php do_action( 'edd_sl_license_header_after' ); ?>
            </tr>
            </thead>
            <?php foreach ( $keys as $license ) : ?>
                <tr class="edd_sl_license_row">
                    <?php do_action( 'edd_sl_license_row_start', $license->ID );
                    $download_id = $edd_sl->get_download_id( $license->ID );
                    $price_id    = $edd_sl->get_price_id( $license->ID );
                    ?>
                    <td>
                        <div class="plugin_info">
                            <div class="plugin_img">
                                <?php
                                $icons    = get_field( 'icons', $download_id );
                                $icon_url = $icons['url'];
                                ?>
                                <img src="<?php echo $icon_url ? $icon_url : get_template_directory_uri() . '/assets/img/plugin.png' ?>" alt="plugin thumbnail" class="plugin_small_icon">
                            </div>
                            <!-- /.plugin_img -->
                            <div class="plugin_details">
                                <h4><?php echo get_the_title( $download_id ); ?></h4>
                                <?php if ( '' !== $price_id ) :
                                    $license_duration = edd_software_licensing()->get_price_is_lifetime( $download_id, $price_id ) ? __( 'Lifetime', 'abcd' ) : __( 'Yearly', 'abcd' ); ?>
                                    <p class="edd_sl_license_price_option"><?php echo edd_get_price_option_name( $download_id, $price_id ) . ' / ' . $license_duration; ?></p>
                                <?php endif; ?>
                            </div>
                            <!-- /.plugin_details -->
                        </div>
                        <!-- /.plugin_info -->
                    </td>
                    <td class="edd_sl_license_status edd-sl-<?php echo $edd_sl->get_license_status( $license->ID ); ?>"><?php echo $edd_sl->license_status( $license->ID ); ?></td>
                    
                    <?php
                    $payment_id = $edd_sl->get_payment_id( $license->ID );
                    ?>
                    <td><span class="edd_sl_limit_used"><?php echo $edd_sl->get_site_count( $license->ID ); ?></span><span class="edd_sl_limit_sep">&nbsp;/&nbsp;</span><span class="edd_sl_limit_max"><?php echo $edd_sl->license_limit( $license->ID ); ?></span></td>
                    <?php if ( ! $edd_sl->force_increase() ) : ?>
                        <td><a href="<?php echo esc_url( add_query_arg( array( 'action' => 'manage_licenses', 'payment_id' => $payment_id, 'license_id' => $license->ID ) ) ); ?>" class="manage_links"><?php _e( 'Manage Sites', 'abcd' ); ?></a></td>
                    <?php endif; ?>
                    <td>
                        <?php
                        $payment_id = $edd_sl->get_payment_id( $license->ID );
                        if ( edd_sl_license_has_upgrades( $license->ID ) && 'expired' !== $edd_sl->get_license_status( $license->ID ) ) : ?>
                            <a href="<?php echo esc_url( add_query_arg( array( 'action' => 'manage_licenses', 'payment_id' => $payment_id, 'view' => 'upgrades', 'license_id' => $license->ID ) ) ); ?>" class="manage_links"><?php _e( 'View Upgrade', 'abcd' ); ?></a>
                        <?php elseif ( edd_sl_license_has_upgrades( $license->ID ) && 'expired' == $edd_sl->get_license_status( $license->ID ) ) : ?>
                            <a href="<?php echo edd_software_licensing()->get_renewal_url( $license->ID ); ?>" title="<?php esc_attr_e( 'Renew license', 'edd_sl' ); ?>" class="manage_links"><?php _e( 'Renew license', 'abcd' ); ?></a>
                        <?php else : ?>
                            <span class="edd_sl_no_upgrades"><?php _e( 'No upgrades available', 'abcd' ); ?></span>
                        <?php endif; ?>
                    </td>
                    <?php do_action( 'edd_sl_license_row_end', $license->ID ); ?>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
<?php else : ?>
    <p class="edd_sl_no_keys"><?php _e( 'There are no license keys for this purchase', 'abcd' ); ?></p>
<?php endif; ?>
