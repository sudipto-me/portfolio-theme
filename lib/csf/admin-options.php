<?php
// Control core classes for avoid errors
if ( class_exists( 'CSF' ) ) {
    // Set a unique slug-like ID
    $prefix = 'abcd';
    // Create options
    CSF::createOptions( $prefix, array(
        'framework_title' => esc_html__( 'Theme Options', 'abcd' ),
        'menu_title'      => esc_html__( 'Theme Options', 'abcd' ),
        'menu_slug'       => 'abcd',
        'theme'           => 'light'
    ) );
    
    // Create a section
    CSF::createSection( $prefix, array(
        'title'  => 'Header',
        'fields' => array(
            // favicon
            array(
                'type'    => 'content',
                'content' => 'To upload favicon go to <strong>Appearance->Customize->Site Identity->Site Icon</strong>',
                'title'   => 'Favicon',
            ),
            // header logo
            array(
                'id'    => 'theme-header-logo',
                'type'  => 'media',
                'title' => 'Site Logo',
            ),
            //top bar content
            array(
                'id'     => 'theme-topbar-content',
                'type'   => 'group',
                'title'  => 'Top Bar Content',
                'fields' => array(
                    array(
                        'id'    => 'refund-text',
                        'type'  => 'text',
                        'title' => __('Refund Text','abcd')
                    ),
                    array(
                        'id'    => 'payment-text',
                        'type'  => 'text',
                        'title' => __('Payment Text','abcd')
                    ),
                    array(
                        'id'    => 'support-text',
                        'type'  => 'text',
                        'title' => __('Support Text','abcd')
                    ),
                ),
                'default' => array(
                    array(
                        'refund-text' => __('7 Days Money-back Guarantee','abcd'),
                        'payment-text' => __('Safe & Secure online payment','abcd'),
                        'support-text' => __('Dedicated Support','abcd')
                    )
                ),
            ),
            array(
                'id' => 'theme-cta',
                'type' => 'text',
                'title' => __('My Account Page URL','abcd')
            ),
            array(
                'id'    => 'theme-header-script',
                'type'  => 'code_editor',
                'title' => esc_html__( 'Header Script', 'biermann' ),
            )
        )
    ) );
    // footer
    CSF::createSection( $prefix, array(
        'title'  => 'Footer',
        'fields' => array(
            // footer bg image
            array(
                'id'    => 'theme-footer-bg',
                'type'  => 'media',
                'title' => 'Footer Background Image',
            ),
            // copyright
            array(
                'id'    => 'theme-copyright-content',
                'type'  => 'wp_editor',
                'title' => esc_html__( 'Copyright content', 'abcd' ),
            ),
            //footer javascript
            array(
                'id'    => 'theme-footer-script',
                'type'  => 'code_editor',
                'title' => esc_html__( 'Footer Script', 'abcd' ),
            )
        )
    ) );
    
    // Create social section
    CSF::createSection( $prefix, array(
        'title'  => 'Social',
        'fields' => array(
            array(
                'id'     => 'theme-social-repeater',
                'type'   => 'repeater',
                'title'  => 'Social Links',
                'fields' => array(
                    array(
                        'id'    => 'social-icon',
                        'type'  => 'text',
                        'title' => 'Icon'
                    ),
                    array(
                        'id'    => 'social-link',
                        'type'  => 'text',
                        'title' => 'Link'
                    ),
                ),
            ),
        )
    ) );
    // Create Color section
    CSF::createSection( $prefix, array(
        'title'  => 'Color',
        'fields' => array(
            array(
                'id'    => 'theme-primary-color',
                'type'  => 'color',
                'title' => 'Theme Primary Color',
            ),
            array(
                'id'    => 'theme-secondary-color',
                'type'  => 'color',
                'title' => 'Theme Secondary Color',
            ),
            array(
                'id'    => 'banner-overlay-color',
                'type'  => 'color',
                'title' => 'Hero Section Overlay Color',
            )
        )
    ) );
}
