<?php
/**
 * Theme options files goes here
 *
 * @since 1.0.0
 */

// don't call the file directly
defined( 'ABSPATH' ) || exit();

// Control core classes for avoid errors
if ( class_exists( 'CSF' ) ) {
	// Set a unique slug-like ID
	$prefix = 'portfolio';
	// Create options
	CSF::createOptions( $prefix, array(
		'framework_title' => esc_html__( 'Theme Options', 'portfolio' ),
		'menu_title'      => esc_html__( 'Theme Options', 'portfolio' ),
		'menu_slug'       => 'theme-options',
		'theme'           => 'light'
	) );

	// Create home section
	CSF::createSection( $prefix, array(
		'title'  => esc_attr__( 'Header', 'portfolio' ),
		'fields' => array(
			// favicon
			array(
				'type'    => 'content',
				/* translators: Appearance->Customize->Site Identity->Site Icon */
				'content' => sprintf( __( 'To upload favicon go to <strong>%s</strong>', 'portfolio' ), 'Appearance->Customize->Site Identity->Site Icon' ),
				'title'   => 'Favicon',
			),
			// header logo
			array(
				'id'    => 'theme-header-logo',
				'type'  => 'media',
				'title' => esc_html__( 'Site Logo', 'portfolio' ),
			),
			array(
				'id'    => 'theme-header-script',
				'type'  => 'code_editor',
				'title' => esc_html__( 'Header Script', 'portfolio' ),
			)
		)
	) );
	// contact and address section
	CSF::createSection( $prefix, array(
		'title'  => esc_attr__( 'Contact', 'portfolio' ),
		'fields' => array(
			// phone
			array(
				'id'    => 'contact-phone',
				'type'  => 'text',
				'title' => esc_html__( 'Contact Phone Number', 'portfolio' )
			),
			// email
			array(
				'id'    => 'contact-email',
				'type'  => 'text',
				'title' => esc_html__( 'Contact Email Address', 'portfolio' )
			),
			// skype
			array(
				'id'    => 'contact-skype',
				'type'  => 'text',
				'title' => esc_html__( 'Contact Skype', 'portfolio' )
			),
			// address
			array(
				'id'    => 'contact-address',
				'type'  => 'wp_editor',
				'title' => esc_html__( 'Contact Address', 'portfolio' )
			)
		)
	) );
	// footer
	CSF::createSection( $prefix, array(
		'title'  => esc_attr__( 'Footer', 'portfolio' ),
		'fields' => array(
			// footer bg image
			array(
				'id'    => 'theme-footer-bg',
				'type'  => 'media',
				'title' => esc_html__( 'Footer Background Image', 'portfolio' ),
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
		'title'  => esc_attr__( 'Social', 'portfolio' ),
		'fields' => array(
			array(
				'id'     => 'theme-social-repeater',
				'type'   => 'repeater',
				'title'  => esc_html__( 'Social Links', 'portfolio' ),
				'fields' => array(
					array(
						'id'    => 'social-icon',
						'type'  => 'text',
						'title' => esc_html__( 'Icon', 'portfolio' ),
					),
					array(
						'id'    => 'social-link',
						'type'  => 'text',
						'title' => esc_html__( 'Link', 'portfolio' ),
					),
				),
			),
		)
	) );
	// Create Color section
	CSF::createSection( $prefix, array(
		'title'  => esc_attr__( 'Color', 'portfolio' ),
		'fields' => array(
			array(
				'id'    => 'theme-primary-color',
				'type'  => 'color',
				'title' => esc_html__( 'Theme Primary Color', 'portfolio' ),
			),
			array(
				'id'    => 'theme-secondary-color',
				'type'  => 'color',
				'title' => esc_html__( 'Theme Secondary Color', 'portfolio' ),
			),
			array(
				'id'    => 'banner-overlay-color',
				'type'  => 'color',
				'title' => esc_html__( 'Hero Section Overlay Color', 'portfolio' ),
			)
		)
	) );
}
