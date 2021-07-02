<?php
/**
 * EDD Reviews custom structure
 * Change the default review template according to design
 */
function edd_custom_review() {
    return array( 'walker' => new Custom_EDD_Review() );
}

add_filter( 'edd_reviews_render_reviews_args', 'edd_custom_review' );

/**
 * Custom Purchase form for EDD
 */
function custom_edd_purchase_form( $purchase_form, $args = array() ) {
    global $post, $edd_displayed_form_ids;
    $purchase_page = edd_get_option( 'purchase_page', false );
    if ( ! $purchase_page || $purchase_page == 0 ) {
        global $no_checkout_error_displayed;
        if ( ! is_null( $no_checkout_error_displayed ) ) {
            return false;
        }
        edd_set_error( 'set_checkout', sprintf( __( 'No checkout page has been configured. Visit <a href="%s">Settings</a> to set one.', 'abcd' ), admin_url( 'edit.php?post_type=download&page=edd-settings' ) ) );
        edd_print_errors();
        $no_checkout_error_displayed = true;
        
        return false;
    }
    $post_id         = is_object( $post ) ? $post->ID : 0;
    $button_behavior = edd_get_download_button_behavior( $post_id );
    $defaults        = apply_filters( 'edd_purchase_link_defaults', array(
        'download_id' => $post_id,
        'price'       => (bool) true,
        'price_id'    => isset( $args['price_id'] ) ? $args['price_id'] : false,
        'direct'      => $button_behavior == 'direct' ? true : false,
        'text'        => $button_behavior == 'direct' ? edd_get_option( 'buy_now_text', __( 'Buy Now', 'abcd' ) ) : edd_get_option( 'add_to_cart_text', __( 'Buy Now', 'abcd' ) ),
        'checkout'    => edd_get_option( 'checkout_button_text', _x( 'Checkout', 'text shown on the Add to Cart Button when the product is already in the cart', 'abcd' ) ),
        'style'       => edd_get_option( 'button_style', 'button' ),
        'color'       => edd_get_option( 'checkout_color', 'blue' ),
        'class'       => 'edd-submit'
    ) );
    $args            = wp_parse_args( $args, $defaults );
    // Override the straight_to_gateway if the shop doesn't support it
    if ( ! edd_shop_supports_buy_now() ) {
        $args['direct'] = false;
    }
    $download = new EDD_Download( $args['download_id'] );
    if ( empty( $download->ID ) ) {
        return false;
    }
    if ( 'publish' !== $download->post_status && ! current_user_can( 'edit_product', $download->ID ) ) {
        return false; // Product not published or user doesn't have permission to view drafts
    }
    
    // Override color if color == inherit
    $args['color']    = ( $args['color'] == 'inherit' ) ? '' : $args['color'];
    $options          = array();
    $variable_pricing = $download->has_variable_prices();
    $data_variable    = $variable_pricing ? ' data-variable-price="yes"' : 'data-variable-price="no"';
    $type             = $download->is_single_price_mode() ? 'data-price-mode=multi' : 'data-price-mode=single';
    $show_price       = $args['price'] && $args['price'] !== 'no';
    $data_price_value = 0;
    $price            = false;
    
    if ( $variable_pricing && false !== $args['price_id'] ) {
        $price_id            = $args['price_id'];
        $prices              = $download->prices;
        $options['price_id'] = $args['price_id'];
        $found_price         = isset( $prices[ $price_id ] ) ? $prices[ $price_id ]['amount'] : false;
        $data_price_value    = $found_price;
        if ( $show_price ) {
            $price = $found_price;
        }
        
    } elseif ( ! $variable_pricing ) {
        $data_price_value = $download->price;
        if ( $show_price ) {
            $price = $download->price;
        }
    }
    
    $data_price  = 'data-price="' . $data_price_value . '"';
    $button_text = ! empty( $args['text'] ) ? '&nbsp;&ndash;&nbsp;' . $args['text'] : '';
    if ( false !== $price ) {
        if ( 0 == $price ) {
            $args['text'] = __( 'Free', 'abcd' ) . $button_text;
        } else {
            $args['text'] = edd_currency_filter( edd_format_amount( $price ) ) . $button_text;
        }
    }
    
    if ( edd_item_in_cart( $download->ID, $options ) && ( ! $variable_pricing || ! $download->is_single_price_mode() ) ) {
        $button_display   = '';
        $checkout_display = 'style="display:none;"';
    } else {
        $button_display   = '';
        $checkout_display = 'style="display:none;"';
    }
    // Collect any form IDs we've displayed already so we can avoid duplicate IDs
    if ( isset( $edd_displayed_form_ids[ $download->ID ] ) ) {
        $edd_displayed_form_ids[ $download->ID ] ++;
    } else {
        $edd_displayed_form_ids[ $download->ID ] = 1;
    }
    $form_id = ! empty( $args['form_id'] ) ? $args['form_id'] : 'edd_purchase_' . $download->ID;
    // If we've already generated a form ID for this download ID, append -#
    if ( $edd_displayed_form_ids[ $download->ID ] > 1 ) {
        $form_id .= '-' . $edd_displayed_form_ids[ $download->ID ];
    }
    $args = apply_filters( 'edd_purchase_link_args', $args );
    ob_start();
    ?>

    <div class="product_subscription_tab_wrapper">
        <ul class="nav nav-tabs" id="product_subscription_tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="yearly-tab" data-toggle="tab" href="#yearly" role="tab" aria-controls="yearly" aria-selected="true"><?php _e( 'Yearly', 'abcd' ); ?>
                    <div class="offer_icon">
                        <img src="<?php echo get_template_directory_uri() . '/assets/img/year_batch.svg'; ?>" alt="icon">
                    </div>
                    <!-- /.offer_icon   -->
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="lifetime-tab" data-toggle="tab" href="#lifetime" role="tab" aria-controls="lifetime" aria-selected="false"><?php _e( 'Life Time', 'abcd' ); ?>
                    <div class="offer_icon">
                        <img src="<?php echo get_template_directory_uri() . '/assets/img/lifetime_batch.svg'; ?>" alt="icon">
                    </div>
                    <!-- /.offer_icon   -->
                </a>
            </li>
        </ul>

        <form id="<?php echo $form_id; ?>" class="edd_download_purchase_form edd_purchase_<?php echo absint( $download->ID ); ?>" method="post">
            <?php do_action( 'edd_purchase_link_top', $download->ID, $args ); ?>
            <div class="edd_purchase_submit_wrapper input_grp btn_grp">
                <?php
                $class = implode( ' ', array( $args['style'], $args['color'], trim( $args['class'] ) ) );
                if ( ! edd_is_ajax_disabled() ) {
                    echo '<a href="#" class="edd-add-to-cart ' . esc_attr( $class ) . '" data-nonce="' . wp_create_nonce( 'edd-add-to-cart-' . $download->ID ) . '" data-action="edd_add_to_cart" data-download-id="' . esc_attr( $download->ID ) . '" ' . $data_variable . ' ' . $type . ' ' . $data_price . ' ' . $button_display . '><span class="edd-add-to-cart-label">' . $args['text'] . '</span> <span class="edd-loading" aria-label="' . esc_attr__( 'Loading', 'abcd' ) . '"></span></a>';
                }
                echo '<input type="submit" class="edd-add-to-cart edd-no-js ' . esc_attr( $class ) . '" name="edd_purchase_download" value="' . esc_attr( $args['text'] ) . '" data-action="edd_add_to_cart" data-download-id="' . esc_attr( $download->ID ) . '" ' . $data_variable . ' ' . $type . ' ' . $button_display . '/>';
                echo '<a href="' . esc_url( edd_get_checkout_uri() ) . '" class="edd_go_to_checkout ' . esc_attr( $class ) . '" ' . $checkout_display . '>' . $args['checkout'] . '</a>';
                ?>
                <?php if ( ! edd_is_ajax_disabled() ) : ?>
                    <span class="edd-cart-ajax-alert" aria-live="assertive">
					<span class="edd-cart-added-alert" style="display: none;">
						<svg class="edd-icon edd-icon-check" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" aria-hidden="true">
							<path d="M26.11 8.844c0 .39-.157.78-.44 1.062L12.234 23.344c-.28.28-.672.438-1.062.438s-.78-.156-1.06-.438l-7.782-7.78c-.28-.282-.438-.673-.438-1.063s.156-.78.438-1.06l2.125-2.126c.28-.28.672-.438 1.062-.438s.78.156 1.062.438l4.594 4.61L21.42 5.656c.282-.28.673-.438 1.063-.438s.78.155 1.062.437l2.125 2.125c.28.28.438.672.438 1.062z"/>
						</svg>
						<?php echo __( 'Added to cart', 'abcd' ); ?>
					</span>
				</span>
                
                <?php endif; ?>
                <?php if ( ! $download->is_free( $args['price_id'] ) && ! edd_download_is_tax_exclusive( $download->ID ) ): ?>
                    <?php if ( edd_display_tax_rate() && edd_prices_include_tax() ) {
                        echo '<span class="edd_purchase_tax_rate">' . sprintf( __( 'Includes %1$s&#37; tax', 'abcd' ), edd_get_tax_rate() * 100 ) . '</span>';
                    } elseif ( edd_display_tax_rate() && ! edd_prices_include_tax() ) {
                        echo '<span class="edd_purchase_tax_rate">' . sprintf( __( 'Excluding %1$s&#37; tax', 'abcd' ), edd_get_tax_rate() * 100 ) . '</span>';
                    } ?>
                <?php endif; ?>
            </div><!--end .edd_purchase_submit_wrapper-->

            <input type="hidden" name="download_id" value="<?php echo esc_attr( $download->ID ); ?>">
            <?php if ( $variable_pricing && isset( $price_id ) && isset( $prices[ $price_id ] ) ): ?>
                <input type="hidden" name="edd_options[price_id][]" id="edd_price_option_<?php echo esc_attr( $download->ID ); ?>_<?php echo esc_attr( $price_id ); ?>" class="edd_price_option_<?php echo esc_attr( $download->ID ); ?>" value="<?php echo esc_attr( $price_id ); ?>">
            <?php endif; ?>
            
            <?php if ( ! empty( $args['direct'] ) && ! $download->is_free( $args['price_id'] ) ) { ?>
                <input type="hidden" name="edd_action" class="edd_action_input" value="straight_to_gateway">
            <?php } else { ?>
                <input type="hidden" name="edd_action" class="edd_action_input" value="add_to_cart">
            <?php } ?>
            
            <input type="hidden" name="edd_redirect_to_checkout" id="edd_redirect_to_checkout" value="1">
            
            <?php do_action( 'edd_purchase_link_end', $download->ID, $args ); ?>
        </form>
    </div>
    <?php
    $purchase_form = ob_get_clean();
    
    return $purchase_form;
}

add_filter( 'edd_purchase_download_form', 'custom_edd_purchase_form' );

//remove the default pricing and change it for the one year and lifetime pricing
remove_action( 'edd_purchase_link_top', 'edd_purchase_variable_pricing', 10 );

/**
 * One Year and life time pricing options
 */
function custom_edd_variable_pricing( $download_id = 0, $args = array() ) {
    global $edd_displayed_form_ids;
    // If we've already generated a form ID for this download ID, append -#
    $form_id = '';
    if ( $edd_displayed_form_ids[ $download_id ] > 1 ) {
        $form_id .= '-' . $edd_displayed_form_ids[ $download_id ];
    }
    $variable_pricing = edd_has_variable_prices( $download_id );
    if ( ! $variable_pricing ) {
        return;
    }
    
    $prices = apply_filters( 'edd_purchase_variable_prices', edd_get_variable_prices( $download_id ), $download_id );
    // If the price_id passed is found in the variable prices, do not display all variable prices.
    if ( false !== $args['price_id'] && isset( $prices[ $args['price_id'] ] ) ) {
        return;
    }
    
    $type   = edd_single_price_option_mode( $download_id ) ? 'checkbox' : 'radio';
    $mode   = edd_single_price_option_mode( $download_id ) ? 'multi' : 'single';
    $schema = edd_add_schema_microdata() ? ' itemprop="offers" itemscope itemtype="http://schema.org/Offer"' : '';
    // Filter the class names for the edd_price_options div
    $css_classes_array = apply_filters( 'edd_price_options_classes', array(
        'edd_price_options',
        'edd_' . esc_attr( $mode ) . '_mode'
    
    ), $download_id );
    
    // Sanitize those class names and form them into a string
    $css_classes_string = implode( ' ', array_map( 'sanitize_html_class', $css_classes_array ) );
    do_action( 'edd_before_price_options', $download_id );
    ?>
    <div class="tab-content" id="product_subscription_tab_content">
        <div class="tab-pane fade active show" id="yearly" role="tabpanel" aria-labelledby="yearly-tab">
            <?php
            if ( $prices ) {
                echo '<div class="tabbed-prices">';
                $checked_key = isset( $_GET['price_option'] ) ? absint( $_GET['price_option'] ) : edd_get_default_variable_price( $download_id );
                foreach ( $prices as $key => $price ) {
                    if ( ! edd_software_licensing()->get_price_is_lifetime( $download_id, $price['index'] ) ) {
                        $class = ( $key == $checked_key ) ? 'active' : '';
                        echo '<div id="edd_price_option_' . $download_id . '_' . sanitize_key( $price['name'] ) . $form_id . '" class="input_grp ' . $class . '"' . $schema . '>';
                        echo '<input type="' . $type . '" ' . checked( apply_filters( 'edd_price_option_checked', $checked_key, $download_id, $key ), $key, false ) . ' name="edd_options[price_id][]" id="' . esc_attr( 'edd_price_option_' . $download_id . '_' . $key . $form_id ) . '" class="' . esc_attr( 'edd_price_option_' . $download_id ) . '" value="' . esc_attr( $key ) . '" data-price="' . edd_get_price_option_amount( $download_id, $key ) . '"/>&nbsp;';
                        echo '<label for="' . esc_attr( 'edd_price_option_' . $download_id . '_' . $key . $form_id ) . '">';
                        $item_prop = edd_add_schema_microdata() ? ' itemprop="description"' : '';
                        // Construct the default price output.
                        $price_output = '<span class="edd_price_option_name"' . $item_prop . '>' . esc_html( $price['name'] ) . '</span><br><span class="edd_price_option_price"><span class="edd-currency-code">' . edd_currency_symbol() . '</span>' . edd_format_amount( $price['amount'] ) . '</span>';
                        // Filter the default price output
                        $price_output = apply_filters( 'edd_price_option_output', $price_output, $download_id, $key, $price, $form_id, $item_prop );
                        // Output the filtered price output
                        echo $price_output;
                        if ( edd_add_schema_microdata() ) {
                            echo '<meta itemprop="price" content="' . esc_attr( $price['amount'] ) . '" />';
                            echo '<meta itemprop="priceCurrency" content="' . esc_attr( edd_get_currency() ) . '" />';
                        }
                        echo '</label>';
                        echo '</div>';
                    }
                }
                echo '</div>';
            }
            ?>
        </div>
        <div class="tab-pane fade" id="lifetime" role="tabpanel" aria-labelledby="lifetime-tab">
            <?php
            if ( $prices ) {
                echo '<div class="tabbed-prices">';
                $checked_key = isset( $_GET['price_option'] ) ? absint( $_GET['price_option'] ) : edd_get_default_variable_price( $download_id );
                foreach ( $prices as $key => $price ) {
                    if ( edd_software_licensing()->get_price_is_lifetime( $download_id, $price['index'] ) ) {
                        echo '<div id="edd_price_option_' . $download_id . '_' . sanitize_key( $price['name'] ) . $form_id . '" class="input_grp"' . $schema . '>';
                        echo '<input type="' . $type . '" ' . checked( apply_filters( 'edd_price_option_checked', $checked_key, $download_id, $key ), $key, false ) . ' name="edd_options[price_id][]" id="' . esc_attr( 'edd_price_option_' . $download_id . '_' . $key . $form_id ) . '" class="' . esc_attr( 'edd_price_option_' . $download_id ) . '" value="' . esc_attr( $key ) . '" data-price="' . edd_get_price_option_amount( $download_id, $key ) . '"/>&nbsp;';
                        echo '<label for="' . esc_attr( 'edd_price_option_' . $download_id . '_' . $key . $form_id ) . '">';
                        $item_prop = edd_add_schema_microdata() ? ' itemprop="description"' : '';
                        // Construct the default price output.
                        $price_output = '<span class="edd_price_option_name"' . $item_prop . '>' . esc_html( $price['name'] ) . '</span><br><span class="edd_price_option_price"><span class="edd-currency-code">' . edd_currency_symbol() . '</span>' . edd_format_amount( $price['amount'] ) . '</span>';
                        // Filter the default price output
                        $price_output = apply_filters( 'edd_price_option_output', $price_output, $download_id, $key, $price, $form_id, $item_prop );
                        // Output the filtered price output
                        echo $price_output;
                        if ( edd_add_schema_microdata() ) {
                            echo '<meta itemprop="price" content="' . esc_attr( $price['amount'] ) . '" />';
                            echo '<meta itemprop="priceCurrency" content="' . esc_attr( edd_get_currency() ) . '" />';
                        }
                        echo '</label>';
                        echo '</div>';
                    }
                }
                echo '</div>';
            }
            ?>
        </div>
    </div>
    <?php
}
add_action( 'edd_purchase_link_top', 'custom_edd_variable_pricing', 20, 2 );

/**
 * Checkout cart options for edd
 */
function edd_custom_checkout_content() {
    echo "<h1 class=\"page_title\">" . __( 'Checkout', 'abcd' ) . "</h1>"; ?>
    <div class="cart_added_card">
        <?php
        $cart_items = edd_get_cart_contents();
        if ( is_array( $cart_items ) && count( $cart_items ) ) {
            $last_item = end( $cart_items ); ?>
            <p><img src="<?php echo get_template_directory_uri() . '/assets/img/refund-tick.svg' ?>" alt="right tick"><?php echo ' ' . get_the_title( $last_item['id'] ) . '' . __( ' has been added to your cart.', 'abcd' ); ?></p>
            <a href="<?php echo get_post_type_archive_link( 'download' ); ?>"><?php _e( 'Continue Shopping', 'abcd' ); ?><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
            <?php
        }
        ?>
    </div>
    <?php
}
add_action( 'edd_before_checkout_cart', 'edd_custom_checkout_content' );
//removed the existing discount field from the checkout
remove_action( 'edd_checkout_form_top', 'edd_discount_field', - 1 );
/**
 * Custom discount field in the checkout form in EDD
 */
function edd_custom_checkout_form_top() {
    if ( isset( $_GET['payment-mode'] ) && edd_is_ajax_disabled() ) {
        return; // Only show before a payment method has been selected if ajax is disabled
    }
    if ( ! edd_is_checkout() ) {
        return;
    }
    if ( edd_has_active_discounts() && edd_get_cart_total() ) :
        $color = edd_get_option( 'checkout_color', 'blue' );
        $color = ( $color == 'inherit' ) ? '' : $color;
        $style = edd_get_option( 'button_style', 'button' );
        ?>
        <fieldset id="edd_discount_code">
            <div class="renew_license_card discount_card">
                <h3 id="edd_show_discount">
                    <?php _e( 'Have a discount code?', 'abcd' ); ?> <a href="#" class="edd_discount_link"><?php echo _x( 'Click to enter it', 'Entering a discount code', 'abcd' ); ?></a>
                </h3>

                <div id="edd-discount-code-wrap" class="edd-cart-adjustment inp_grp">
                    <label for="edd-discount" class="edd-description"><?php _e( 'Enter a coupon code if you have one.', 'abcd' ); ?></label>
                    <input class="edd-input inp_field" type="text" id="edd-discount" name="edd-discount" placeholder="<?php _e( 'Enter discount', 'abcd' ); ?>"/>
                    <div class="btn_set">
                        <a href="#" class="edd-cancel-discount site_cta"><?php echo __( 'Cancel', 'abcd' ); ?></a>
                        <input type="submit" class="edd-apply-discount edd-submit <?php echo $color . ' ' . $style; ?> site_cta" value="<?php echo _x( 'Apply', 'Apply discount at checkout', 'abcd' ); ?>"/>
                    </div>

                </div>

                <span class="edd-discount-loader edd-loading" id="edd-discount-loader" style="display:none;"></span>
                <span id="edd-discount-error-wrap" class="edd_error edd-alert edd-alert-error" aria-hidden="true" style="display:none;"></span>
            </div>
        </fieldset>
    <?php
    endif;
}

add_action( 'edd_checkout_form_top', 'edd_custom_checkout_form_top' );
//remove the final total text from the checkout form
remove_action( 'edd_purchase_form_before_submit', 'edd_checkout_final_total', 999 );

/**
 * Change the checkout button text6
 */
function custom_edd_checkout_button_text( $html ) {
    ob_start();
    $enabled_gateways = edd_get_enabled_payment_gateways();
    $cart_total       = edd_get_cart_total();
    echo '<div class="purchase_card">';
    if ( ! empty( $enabled_gateways ) || empty( $cart_total ) ) {
        $color = edd_get_option( 'checkout_color', 'blue' );
        $color = ( $color == 'inherit' ) ? '' : $color;
        $style = edd_get_option( 'button_style', 'button' );
        $label = edd_get_checkout_button_purchase_label(); ?>
        <input type="submit" class="edd-submit <?php echo $color; ?> <?php echo $style; ?> site_cta" id="edd-purchase-button" name="edd-purchase" value="<?php echo $label; ?>"/>
        <?php
    }
    echo '</div>';
    
    return ob_get_clean();
}
add_filter( 'edd_checkout_button_purchase', 'custom_edd_checkout_button_text' );

//remove the default payment icons and update them using new format
remove_action( 'edd_payment_mode_top', 'edd_show_payment_icons' );
remove_action( 'edd_checkout_form_top', 'edd_show_payment_icons' );


/**
 * Payment icons using the design
 */
function custom_edd_show_payment_icons() {
    if ( edd_show_gateways() && did_action( 'edd_payment_mode_top' ) ) {
        return;
    }
    $payment_methods = edd_get_option( 'accepted_cards', array() );
    if ( empty( $payment_methods ) ) {
        return;
    }
    echo '<div class="edd-payment-icons renew_license_card payment_icons">';
    echo '<h3>' . __( 'Accepted Payment Methods', 'abcd' ) . '</h3>';
    foreach ( $payment_methods as $key => $card ) {
        if ( edd_string_is_image_url( $key ) ) {
            echo '<img class="payment-icon" src="' . esc_url( $key ) . '"/>';
        } else {
            $card = strtolower( str_replace( ' ', '', $card ) );
            if ( has_filter( 'edd_accepted_payment_' . $card . '_image' ) ) {
                $image = apply_filters( 'edd_accepted_payment_' . $card . '_image', '' );
            } else {
                $image = edd_locate_template( 'images' . DIRECTORY_SEPARATOR . 'icons' . DIRECTORY_SEPARATOR . $card . '.png', false );
                // Replaces backslashes with forward slashes for Windows systems
                $plugin_dir  = wp_normalize_path( WP_PLUGIN_DIR );
                $content_dir = wp_normalize_path( WP_CONTENT_DIR );
                $image       = wp_normalize_path( $image );
                $image       = str_replace( $plugin_dir, WP_PLUGIN_URL, $image );
                $image       = str_replace( $content_dir, WP_CONTENT_URL, $image );
            }
            if ( edd_is_ssl_enforced() || is_ssl() ) {
                $image = edd_enforced_ssl_asset_filter( $image );
            }
            echo '<img class="payment-icon" src="' . esc_url( $image ) . '"/>';
        }
    }
    echo '</div>';
}

//add_action( 'edd_payment_mode_top', 'custom_edd_show_payment_icons' );
//add_action( 'edd_checkout_form_top', 'custom_edd_show_payment_icons' );

//change the default payment mode selection hhtml
remove_action( 'edd_payment_mode_select', 'edd_payment_mode_select' );
//new design for the payment mode

function custom_edd_payment_mode_select() {
    $gateways       = edd_get_enabled_payment_gateways( true );
    $page_URL       = edd_get_current_page_url();
    $chosen_gateway = edd_get_chosen_gateway();
    ?>
    <div id="edd_payment_mode_select_wrap" class="renew_license_card payment_method">
        <?php do_action( 'edd_payment_mode_top' ); ?>
        <?php if ( edd_is_ajax_disabled() ) { ?>
        <form id="edd_payment_mode" action="<?php echo $page_URL; ?>" method="GET">
            <?php } ?>
            <fieldset id="edd_payment_mode_select">
                <h3><?php _e( 'Select Payment Method', 'abcd' ); ?></h3>
                <?php do_action( 'edd_payment_mode_before_gateways_wrap' ); ?>
                <div id="edd-payment-mode-wrap" class="edd_payment_select_wrap">
                    <?php
                    do_action( 'edd_payment_mode_before_gateways' );
                    foreach ( $gateways as $gateway_id => $gateway ) :
                        $label         = apply_filters( 'edd_gateway_checkout_label_' . $gateway_id, $gateway['checkout_label'] );
                        $checked       = checked( $gateway_id, $chosen_gateway, false );
                        $checked_class = $checked ? ' edd-gateway-option-selected' : '';
                        $nonce         = ' data-' . esc_attr( $gateway_id ) . '-nonce="' . wp_create_nonce( 'edd-gateway-selected-' . esc_attr( $gateway_id ) ) . '"';
                        echo '<div class="input_grp">';
                        echo '<input type="radio" name="payment-mode" class="edd-gateway" id="edd-gateway-' . esc_attr( $gateway_id ) . '" value="' . esc_attr( $gateway_id ) . '"' . $checked . $nonce . '>';
                        echo '<label for="edd-gateway-' . esc_attr( $gateway_id ) . '" class="edd-gateway-option' . $checked_class . '" id="edd-gateway-option-' . esc_attr( $gateway_id ) . '">' . esc_html( $label ) . '</label>';
                        echo '</div>';
                    endforeach;
                    do_action( 'edd_payment_mode_after_gateways' );
                    ?>
                </div>
                <?php do_action( 'edd_payment_mode_after_gateways_wrap' ); ?>
            </fieldset>

            <fieldset id="edd_payment_mode_submit" class="edd-no-js">
                <p id="edd-next-submit-wrap">
                    <?php echo edd_checkout_button_next(); ?>
                </p>
            </fieldset>
            <?php if ( edd_is_ajax_disabled() ) {
                echo '</form>';
            } ?>

    </div>

    <div id="edd_purchase_form_wrap"></div><!-- the checkout fields are loaded into this-->
    <?php do_action( 'edd_payment_mode_bottom' );
}

add_action( 'edd_payment_mode_select', 'custom_edd_payment_mode_select' );

//remove the default user info fields
remove_action( 'edd_purchase_form_after_user_info', 'edd_user_info_fields' );
remove_action( 'edd_register_fields_before', 'edd_user_info_fields' );


/**
 * Shows the User Info fields in the Personal Info box, more fields can be added
 * via the hooks provided.
 *
 * @return void
 * @since 1.3.3
 */

function custom_edd_user_info_fields() {
    $customer = EDD()->session->get( 'customer' );
    $customer = wp_parse_args( $customer, array( 'first_name' => '', 'last_name' => '', 'email' => '' ) );
    if ( is_user_logged_in() ) {
        $user_data = get_userdata( get_current_user_id() );
        foreach ( $customer as $key => $field ) {
            if ( 'email' == $key && empty( $field ) ) {
                $customer[ $key ] = $user_data->user_email;
            } elseif ( empty( $field ) ) {
                $customer[ $key ] = $user_data->$key;
            }
        }
    }
    $customer = array_map( 'sanitize_text_field', $customer );
    ?>

    <div id="edd_checkout_user_info">
        <h4><?php echo apply_filters( 'edd_checkout_personal_info_text', esc_html__( 'Personal Info', 'abcd' ) ); ?></h4>
        <?php do_action( 'edd_purchase_form_before_email' ); ?>
        <div class="row">
            <div class="col-md-4">
                <div id="edd-email-wrap" class="inp_grp">
                    <label class="edd-label" for="edd-email">
                        <?php esc_html_e( 'Email Address', 'abcd' ); ?>
                        <?php if ( edd_field_is_required( 'edd_email' ) ) { ?>
                            <span class="edd-required-indicator">*</span>
                        <?php } ?>
                    </label>

                    <span class="edd-description" id="edd-email-description"><?php esc_html_e( 'We will send the purchase receipt to this address.', 'abcd' ); ?></span>
                    <input class="edd-input inp_field required" type="email" name="edd_email" placeholder="<?php esc_html_e( 'Email address', 'abcd' ); ?>" id="edd-email" value="<?php echo esc_attr( $customer['email'] ); ?>" aria-describedby="edd-email-description"<?php if ( edd_field_is_required( 'edd_email' ) ) {
                        echo ' required ';
                    } ?>/>
                </div>
                
                <?php do_action( 'edd_purchase_form_after_email' ); ?>
            </div>
            <!-- /.col-md-4 -->

            <div class="col-md-4">
                <div id="edd-first-name-wrap" class="inp_grp">
                    <label class="edd-label" for="edd-first">
                        <?php esc_html_e( 'First Name', 'abcd' ); ?>
                        <?php if ( edd_field_is_required( 'edd_first' ) ) { ?>
                            <span class="edd-required-indicator">*</span>
                        <?php } ?>
                    </label>
                    <span class="edd-description" id="edd-first-description"><?php esc_html_e( 'We will use this to personalize your account experience.', 'abcd' ); ?></span>
                    <input class="edd-input inp_field required" type="text" name="edd_first" placeholder="<?php esc_html_e( 'First Name', 'abcd' ); ?>" id="edd-first" value="<?php echo esc_attr( $customer['first_name'] ); ?>"<?php if ( edd_field_is_required( 'edd_first' ) ) {
                        echo ' required ';
                    } ?> aria-describedby="edd-first-description"/>
                </div>
            </div>
            <!-- /.col-md-4 -->
            <div class="col-md-4">
                <div id="edd-last-name-wrap" class="inp_grp">
                    <label class="edd-label" for="edd-last">
                        <?php esc_html_e( 'Last Name', 'abcd' ); ?>
                        <?php if ( edd_field_is_required( 'edd_last' ) ) { ?>
                            <span class="edd-required-indicator">*</span>
                        <?php } ?>
                    </label>

                    <span class="edd-description" id="edd-last-description"><?php esc_html_e( 'We will use this as well to personalize your account experience.', 'abcd' ); ?></span>
                    <input class="edd-input inp_field<?php if ( edd_field_is_required( 'edd_last' ) ) {echo ' required';} ?>" type="text" name="edd_last" id="edd-last" placeholder="<?php esc_html_e( 'Last Name', 'abcd' ); ?>" value="<?php echo esc_attr( $customer['last_name'] ); ?>"<?php if ( edd_field_is_required( 'edd_last' ) ) {echo ' required ';
                    } ?> aria-describedby="edd-last-description"/>
                </div>
            </div>
            <!-- /.col-md-4 -->
        </div>
        <!-- /.row -->
        <?php do_action( 'edd_purchase_form_user_info' ); ?>
        <?php do_action( 'edd_purchase_form_user_info_fields' ); ?>
    </div>
    <?php
}

add_action( 'edd_purchase_form_after_user_info', 'custom_edd_user_info_fields' );
add_action( 'edd_register_fields_before', 'custom_edd_user_info_fields' );

/**
 * Change empty cart text
 */
function custom_edd_empty_cart_message( $message ) {
    $message = '<div class="edd_empty_cart_content">';
    $message .= "<img src=" . get_template_directory_uri() . '/assets/img/empty_cart.png' . " alt=" . 'empty-cart' . " class='empty-cart-img'>";
    $message .= "<h4 class='empty-cart-message'>" . __( 'Before Proceed to checkout, you must add some plugins to the shopping cart', 'abcd' ) . "</h4>";
    $message .= "<a href=" . get_post_type_archive_link( 'download' ) . " class='site_cta'>" . __( 'See Plugins', 'abcd' ) . "</a>";
    $message .= "</div>";
    
    return $message;
}
add_filter( 'edd_empty_cart_message', 'custom_edd_empty_cart_message' );

/**
 * Change login message
 */

function custom_edd_log_user_in( $user_id, $user_login, $user_pass ) {
    $credentials = array(
        'user_login'    => $user_login,
        'user_password' => $user_pass,
    );
    
    $user = wp_signon( $credentials );
    
    if ( ! $user instanceof WP_User ) {
        edd_set_error(
            'edd_invalid_login',
            sprintf(
            /* translators: %1$s Opening anchor tag, do not translate. %2$s Closing anchor tag, do not translate. */
                __( 'Invalid email or password. %1$sReset Password%2$s', 'abcd' ),
                '<a href="' . esc_url( wp_lostpassword_url( edd_get_checkout_uri() ) ) . '">',
                '</a>'
            )
        );
    }
}
add_action( 'edd_log_user_in', 'custom_edd_log_user_in', 10, 3 );

/**
 * Add a slider in checkout page
 */
function custom_edd_review_slider() {
    global $post;
    global $wp_query;
    global $wpdb;
    $cart_items               = edd_get_cart_contents();
    $heighest_downloadable_id = '';
    $heighest_download_count  = 0;
    foreach ( $cart_items as $item ) {
        $download_count = get_post_meta( $item['id'], '_edd_download_sales', true );
        if ( $heighest_download_count < $download_count ) {
            $heighest_download_count  = $download_count;
            $heighest_downloadable_id = $item['id'];
        }
    }
    $comment_query    = "SELECT * FROM {$wpdb->prefix}comments as cm LEFT JOIN {$wpdb->prefix}commentmeta as cm_meta ON cm.comment_ID = cm_meta.comment_id WHERE cm.comment_post_id=$heighest_downloadable_id AND cm.comment_type='edd_review' AND cm.comment_approved=1 AND cm_meta.meta_value=5";
    $comments         = $wpdb->get_results( $comment_query );
    $showing_comments = array();
    foreach ( $comments as $comment ) {
        if ( strlen( $comment->comment_content ) >= 150 ) {
            $showing_comments[] = $comment;
        }
    }
    if ( is_array( $showing_comments ) && count( $showing_comments ) ) {
        $key           = array_rand( $showing_comments );
        $show_comments = $showing_comments[ $key ];
        ?>
        <div class="checkout-comments">
            <div class="row">
                <div class="col-lg-1 col-sm-12">
                    <div class="user_img">
                        <?php echo get_avatar( $show_comments->comment_author_email ) ?>
                    </div>
                </div>
                <!-- /.col-lg-2 -->
                <div class="col-lg-11 col-sm-12">
                    <p class="review_content"><?php echo apply_filters( 'get_comment_text', $show_comments->comment_content ); ?></p>
                    <?php
                    $comment_author = get_user_by( 'email', $show_comments->comment_author_email );
                    $first_name     = get_user_meta( $comment_author->ID, 'first_name', true );
                    $last_name      = get_user_meta( $comment_author->ID, 'last_name', true );
                    
                    ?>
                    <p class="comment-author"><?php echo ' -- ' . $first_name . ' ' . $last_name; ?></p>
                </div>
                <!-- /.col-lg-10 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- ./checkout-comments -->
        <?php
    } else {
        $testimonials = get_posts( array(
            'post_type'      => 'theme-testimonials',
            'orderby'        => 'rand',
            'posts_per_page' => 1,
        ) );
        if ( is_array( $testimonials ) && count( $testimonials ) ) { ?>
            <div class="checkout-comments">
                <div class="row">
                    <div class="col-lg-1 col-sm-12">
                        <div class="user_img">
                            <img src="<?php echo get_the_post_thumbnail_url( $testimonials[0]->ID ) ? get_the_post_thumbnail_url( $testimonials[0]->ID, array( 149, 96 ) ) : get_template_directory_uri() . '/assets/img/testimonial-thumbnail.png'; ?>" alt="<?php echo strtolower( get_the_title( $testimonials[0]->ID ) ); ?>">
                        </div>
                    </div>
                    <!-- /.col-lg-2 -->
                    <div class="col-lg-11 col-sm-12">
                        <p class="review_content"><?php echo $testimonials[0]->post_content; ?></p>
                        <p class="comment-author"><?php echo ' -- ' . get_the_title( $testimonials[0]->ID ); ?></p>
                    </div>
                    <!-- /.col-lg-10 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- ./checkout-comments -->
            <?php
        }
    }
}

add_action( 'edd_after_checkout_cart', 'custom_edd_review_slider' );

/*
 *
 * **/
function custom_edd_discounts_html( $html, $discounts, $rate, $remove_url ) {
    if ( ! $discounts ) {
        $discounts = EDD()->cart->get_discounts();
    }
    if ( empty( $discounts ) ) {
        return;
    }
    $html = '';
    foreach ( $discounts as $discount ) {
        $discount_id = edd_get_discount_id_by_code( $discount );
        $rate        = edd_get_discount_amount( $discount_id );
        $remove_url    = add_query_arg(
            array(
                'edd_action'    => 'remove_cart_discount',
                'discount_id'   => $discount_id,
                'discount_code' => $discount
            ),
            edd_get_checkout_uri()
        );
        $symbol        = edd_currency_symbol();
        $discount_html = '';
        $discount_html .= "<span class=\"edd_discount\">\n";
        $discount_html .= "<span class=\"edd_discount_rate\">$discount&nbsp;&ndash;&nbsp;<span class=\"edd-currency-code\">$symbol</span>$rate</span>\n";
        $discount_html .= "<a href=\"$remove_url\" data-code=\"$discount\" class=\"edd_discount_remove\"></a>\n";
        $discount_html .= "</span>\n";
        
        $html .= apply_filters( 'edd_get_cart_discount_html', $discount_html, $discount, $rate, $remove_url );
    }
    return $html;
}
add_filter( 'edd_get_cart_discounts_html', 'custom_edd_discounts_html', 10, 4 );

function custom_edd_ajax_discount_response( $return ) {
    $total           = htmlentities( "<span class=\"edd-currency-code\">" . edd_currency_symbol() . "</span>" );
    $return['total'] = html_entity_decode( $total, ENT_COMPAT, 'UTF-8' );
    $return['total'] .= edd_get_cart_total();
    
    return $return;
}

//add_filter( 'edd_ajax_discount_response', 'custom_edd_ajax_discount_response' );

//edd subscriber role
//add_filter('edd_auto_register_insert_user_args', function($args) {
//    return array_merge($args, array('role' => 'edd_subscriber'));
//});





