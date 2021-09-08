<?php
/**
 * Footer Social Shortcode
 */
function footer_social_shortcode_callback( $atts, $content = null ) {
    ob_start();
    $theme_options = get_option( 'portfolio' );
    $social_links  = $theme_options['theme-social-repeater'];
    $contact_phone           = ! empty( $theme_options['contact-phone'] ) ? $theme_options['contact-phone'] : '+880-1921378547';
    $contact_email           = ! empty( $theme_options['contact-email'] ) ? $theme_options['contact-email'] : 'shakhari.sudipto@gmail.com';
    $contact_skype         = ! empty( $theme_options['contact-skype'] ) ? $theme_options['contact-skype'] : 'sudipto.ruet';
    ?>
    <div class="contacts__list">
        <dl class="contact-list">
            <dt><?php echo esc_attr__("Phone:","portfolio");?></dt>
            <dd><a href="<?php echo 'tel:' . esc_attr( $contact_phone ); ?>"><?php echo esc_attr( $contact_phone ); ?></a></dd>
            <dt><?php echo esc_attr__("Skype:","portfolio");?></dt>
            <dd><a href="<?php echo 'skype:' . esc_attr( $contact_skype ); ?>"><?php echo esc_attr( $contact_skype ); ?></a></dd>
            <dt><?php echo esc_attr__("Email:","portfolio");?></dt>
            <dd><a href="<?php echo 'mailto:' . sanitize_email( $contact_email ); ?>"><?php echo sanitize_email( $contact_email ); ?></a></dd>
        </dl>
    </div>
<?php
    if ( is_array( $social_links ) && ! empty( $social_links ) ) { ?>
            <div class="contacts__social">
                <ul>
                <?php
                foreach ( $social_links as $social ) {
                    if ( isset( $social['social-link'] ) && ! empty( $social['social-link'] ) ) {
                        ?>
                        <li><a href="<?php echo $social['social-link']; ?>" target="_blank"><?php echo esc_attr__( $social['social-media-name'],'portfolio');?></a></li>
                        <?php
                    }
                }
                ?>
                </ul>
            </div>
        <?php
    }
    return ob_get_clean();
}

add_shortcode( 'social_links', 'footer_social_shortcode_callback' );

/*
* display year shortcode
*/
add_shortcode( 'display_year', 'display_year_shortcode_callback' );
function display_year_shortcode_callback() {
    return date( 'Y' );
}