<?php
/**
 * Footer Social Shortcode
 */
function footer_social_shortcode_callback( $attrs, $content = null ) {
    ob_start();
    $contact_phone           = ! empty( get_theme_mod( 'contact-phn' ) ) ? get_theme_mod( 'contact-phn' ) : '+880-1921378547';
    $contact_email           = ! empty( get_theme_mod( 'contact-email' ) ) ? get_theme_mod( 'contact-email' ) : 'shakhari.sudipto@gmail.com';
    $contact_skype         = ! empty( get_theme_mod( 'contact-address' ) ) ? get_theme_mod( 'contact-address' ) : 'sudipto.ruet';
    ?>
    <div class="contacts__list">
        <ul class="contact-list">
            <li><i class="fa fa-phone"></i><a href="<?php echo 'tel:' . esc_attr( $contact_phone ); ?>"><?php echo esc_attr( $contact_phone ); ?></a></li>
            <li><i class="fa fa-skype"></i><a href="<?php echo 'skype:' . esc_attr( $contact_skype ); ?>"><?php echo esc_attr( $contact_skype ); ?></a></li>
            <li><i class="fa fa-envelope"></i><a href="<?php echo 'mailto:' . sanitize_email( $contact_email ); ?>"><?php echo sanitize_email( $contact_email ); ?></a></li>
        </ul>
    </div>
            <div class="contacts__social">
                <ul>
                    <li><a href="<?php echo ! empty( get_theme_mod( 'contact-github' ) ) ? esc_url( get_theme_mod( 'contact-github' ) ) : '#' ?>" target="_blank"><i class="fa fa-github"></i></a></li>
                    <li><a href="<?php echo ! empty( get_theme_mod( 'contact-linkedin' ) ) ? esc_url( get_theme_mod( 'contact-linkedin' ) ) : '#' ?>" target="_blank"><i class="fa fa-linkedin-square"></i></a></li>
                    <li><a href="<?php echo ! empty( get_theme_mod( 'contact-facebook' ) ) ? esc_url( get_theme_mod( 'contact-facebook' ) ) : '#' ?>" target="_blank"><i class="fa fa-facebook-square"></i></a></li>
                </ul>
            </div>
        <?php
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