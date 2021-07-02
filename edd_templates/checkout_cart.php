<?php
/**
 *  This template is used to display the Checkout page when items are in the cart
 */

global $post; ?>
<div class="table-responsive tab_table_content checkout_table">
    <table id="edd_checkout_cart" <?php if ( ! edd_is_ajax_disabled() ) {echo 'class="ajaxed"';} ?>>
        <thead>
        <tr class="edd_cart_header_row">
            <?php do_action( 'edd_checkout_table_header_first' ); ?>
            <th class="edd_cart_item_name"><?php _e( 'Item Name', 'easy-digital-downloads' ); ?></th>
            <th class="edd_cart_item_price"><?php _e( 'Item Price', 'easy-digital-downloads' ); ?></th>
            <th class="edd_cart_actions"><?php _e( 'Actions', 'easy-digital-downloads' ); ?></th>
            <?php do_action( 'edd_checkout_table_header_last' ); ?>
        </tr>
        </thead>
        <tbody>
        <?php $cart_items = edd_get_cart_contents(); ?>
        <?php do_action( 'edd_cart_items_before' ); ?>
        <?php if ( $cart_items ): ?>
            <?php foreach ( $cart_items as $key => $item ) : ?>
                <tr class="edd_cart_item" id="edd_cart_item_<?php echo esc_attr( $key ) . '_' . esc_attr( $item['id'] ); ?>" data-download-id="<?php echo esc_attr( $item['id'] ); ?>">
                    <?php do_action( 'edd_checkout_table_body_first', $item ); ?>
                    <td class="edd_cart_item_name">
                        <div class="plugin_info">
                            <div class="edd_cart_item_image plugin_img">
                                <?php
                                $icons    = get_field( 'icons',$item['id'] );
                                $icon_url = $icons['url'];
                                ?>
                                <a href="<?php echo get_the_permalink($item['id'])?>"><img src="<?php echo $icon_url ? $icon_url : get_template_directory_uri() . '/assets/img/plugin.png' ?>" alt="plugin thumbnail" class="plugin_small_icon"></a>
                            </div>
                            <div class="edd_checkout_cart_item_title plugin_details">
                                <a href="<?php echo get_the_permalink($item['id'])?>"><?php echo esc_html( edd_get_cart_item_name( $item ) ); ?></a>
                                <?php if ( edd_software_licensing()->get_price_is_lifetime( $item['id'], $item['options']['price_id'] ) ) {
                                    echo '<p class="billing_title">' . __( 'No more billing. One time payment' ) . '</p>';
                                } else {
                                    echo '<p class="billing_title">' . __( 'Billed yearly until canceled' ) . '</p>';
                                } ?>
                                <?php do_action( 'edd_checkout_cart_item_title_after', $item, $key ); ?>
                            </div>
                            
                        </div>
                    </td>
                    <td class="edd_cart_item_price">
                        <?php
                        echo '<span class="edd-currency-code">'.edd_currency_symbol().'</span>'.edd_format_amount(edd_get_cart_item_price($item['id'],$item['options']));
                        //echo edd_cart_item_price( $item['id'], $item['options'] );
                        do_action( 'edd_checkout_cart_item_price_after', $item );
                        ?>
                    </td>
                    <td class="edd_cart_actions">
                        <div class="table_action">
                            <?php if ( edd_item_quantities_enabled() && ! edd_download_quantities_disabled( $item['id'] ) ) : ?>
                                <input type="number" min="1" step="1" name="edd-cart-download-<?php echo $key; ?>-quantity" data-key="<?php echo $key; ?>" class="edd-input edd-item-quantity" value="<?php echo edd_get_cart_item_quantity( $item['id'], $item['options'] ); ?>"/>
                                <input type="hidden" name="edd-cart-downloads[]" value="<?php echo $item['id']; ?>"/>
                                <input type="hidden" name="edd-cart-download-<?php echo $key; ?>-options" value="<?php echo esc_attr( json_encode( $item['options'] ) ); ?>"/>
                            <?php endif; ?>
                            <?php do_action( 'edd_cart_actions', $item, $key ); ?>
                            <ul>
                                <li><a class="edd_cart_remove_item_btn" href="<?php echo esc_url( wp_nonce_url( edd_remove_item_url( $key ), 'edd-remove-from-cart-' . $key, 'edd_remove_from_cart_nonce' ) ); ?>"><img src="<?php echo get_template_directory_uri() . "/assets/img/delete_icon.svg"; ?>" alt="delete icon"></a></li>
                            </ul>
                        </div>
                    </td>
                    <?php do_action( 'edd_checkout_table_body_last', $item ); ?>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php do_action( 'edd_cart_items_middle' ); ?>
        <?php if( edd_cart_has_fees() ) : ?>
            <?php foreach( edd_get_cart_fees() as $fee_id => $fee ) : ?>
                <tr class="edd_cart_fee" id="edd_cart_fee_<?php echo $fee_id; ?>">
            
                    <?php do_action( 'edd_cart_fee_rows_before', $fee_id, $fee ); ?>
            
                    <td class="edd_cart_fee_label"><?php echo esc_html( $fee['label'] ); ?></td>
                    <td class="edd_cart_fee_amount"><?php echo esc_html( edd_currency_filter( edd_format_amount( $fee['amount'] ) ) ); ?></td>
                    <td>
                        <?php if( ! empty( $fee['type'] ) && 'item' == $fee['type'] ) : ?>
                            <a href="<?php echo esc_url( edd_remove_cart_fee_url( $fee_id ) ); ?>"><?php _e( 'Remove', 'easy-digital-downloads' ); ?></a>
                        <?php endif; ?>
            
                    </td>
            
                    <?php do_action( 'edd_cart_fee_rows_after', $fee_id, $fee ); ?>
        
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php do_action( 'edd_cart_items_after' ); ?>
        </tbody>
        <tfoot>
        <?php if( has_action( 'edd_cart_footer_buttons' ) ) : ?>
            <tr class="edd_cart_footer_row<?php if ( edd_is_cart_saving_disabled() ) { echo ' edd-no-js'; } ?>">
                <th colspan="<?php echo edd_checkout_cart_columns(); ?>">
                    <?php do_action( 'edd_cart_footer_buttons' ); ?>
                </th>
            </tr>
        <?php endif; ?>
        <?php if( edd_use_taxes() && ! edd_prices_include_tax() ) : ?>
            <tr class="edd_cart_footer_row edd_cart_subtotal_row"<?php if ( ! edd_is_cart_taxed() ) echo ' style="display:none;"'; ?>>
                <?php do_action( 'edd_checkout_table_subtotal_first' ); ?>
                <th colspan="<?php echo edd_checkout_cart_columns(); ?>" class="edd_cart_subtotal">
                    <?php _e( 'Subtotal', 'easy-digital-downloads' ); ?>:&nbsp;<span class="edd_cart_subtotal_amount"><?php echo edd_cart_subtotal(); ?></span>
                </th>
                <?php do_action( 'edd_checkout_table_subtotal_last' ); ?>
            </tr>
        <?php endif; ?>
        <tr class="edd_cart_footer_row edd_cart_discount_row" <?php if( ! edd_cart_has_discounts() )  echo ' style="display:none;"'; ?>>
            <?php do_action( 'edd_checkout_table_discount_first' ); ?>
            <th colspan="<?php echo edd_checkout_cart_columns(); ?>" class="edd_cart_discount">
                <?php edd_cart_discounts_html(); ?>
            </th>
            <?php do_action( 'edd_checkout_table_discount_last' ); ?>
        </tr>
        <?php if( edd_use_taxes() ) : ?>
            <tr class="edd_cart_footer_row edd_cart_tax_row"<?php if( ! edd_is_cart_taxed() ) echo ' style="display:none;"'; ?>>
                <?php do_action( 'edd_checkout_table_tax_first' ); ?>
                <th colspan="<?php echo edd_checkout_cart_columns(); ?>" class="edd_cart_tax">
                    <?php _e( 'Tax', 'easy-digital-downloads' ); ?>:&nbsp;<span class="edd_cart_tax_amount" data-tax="<?php echo edd_get_cart_tax( false ); ?>"><?php echo esc_html( edd_cart_tax() ); ?></span>
                </th>
                <?php do_action( 'edd_checkout_table_tax_last' ); ?>
            </tr>

        <?php endif; ?>
        <tr class="edd_cart_footer_row">
            <?php do_action( 'edd_checkout_table_footer_first' ); ?>
            <th colspan="<?php echo edd_checkout_cart_columns(); ?>" class="edd_cart_total"><?php _e( 'Total', 'easy-digital-downloads' ); ?>: <span class="edd_cart_amount" data-subtotal="<?php echo edd_get_cart_subtotal(); ?>" data-total="<?php echo edd_get_cart_total(); ?>"><span class="edd-currency-code"><?php echo edd_currency_symbol();?></span><?php echo edd_get_cart_total(); ?></span></th>
            <?php do_action( 'edd_checkout_table_footer_last' ); ?>
        </tr>
        </tfoot>
    </table>
</div>
