<?php
// Control core classes for avoid errors
if ( class_exists( 'CSF' ) ) {
    // Set a unique slug-like ID
    $prefix = 'portfolio';
    // Create options
    CSF::createOptions( $prefix, array(
        'framework_title' => esc_html__( 'Theme Options', 'portfolio' ),
        'menu_title'      => esc_html__( 'Theme Options', 'portfolio' ),
        'menu_slug'       => 'portfolio-options',
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
            array(
                'id' => 'theme-cta',
                'type' => 'text',
                'title' => __('My Account Page URL','portfolio')
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
                'title' => esc_html__( 'Copyright content', 'portfolio' ),
            ),
            //footer javascript
            array(
                'id'    => 'theme-footer-script',
                'type'  => 'code_editor',
                'title' => esc_html__( 'Footer Script', 'portfolio' ),
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
