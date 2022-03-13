<?php
/**
 * All customizer functions goes here
 *
 * @since 1.0.1
 */

function register_customizer_options( $wp_customize ) {
	$wp_customize->add_section(
		'theme_options',
		array(
			'title'    => __( 'Theme Options', 'portfolio' ),
			'priority' => 70
		)
	);
	$wp_customize->add_setting( 'portfolio-name' );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'portfolio_name',
		array(
			'label'      => __( 'Name', 'portfolio' ),
			'section'    => 'theme_options',
			'settings'   => 'portfolio-name',
			'capability' => 'manage_options'
		)
	) );
	$wp_customize->add_setting( 'portfolio-designation' );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'portfolio_designation',
		array(
			'label'      => __( 'Designation', 'portfolio' ),
			'section'    => 'theme_options',
			'settings'   => 'portfolio-designation',
			'capability' => 'manage_options'
		)
	) );
	$wp_customize->add_setting( 'portfolio-age' );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'portfolio_age',
		array(
			'label'      => __( 'Age', 'portfolio' ),
			'section'    => 'theme_options',
			'settings'   => 'portfolio-age',
			'capability' => 'manage_options'
		)
	) );
	
	$wp_customize->add_setting( 'home-avatar' );
	$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'home_avatar',
		array(
			'label'      => __( 'Home Avatar', 'portfolio' ),
			'section'    => 'theme_options',
			'settings'   => 'home-avatar',
			'capability' => 'manage_options'
		)
	) );
	
	$wp_customize->add_setting( 'home-banner-img' );
	$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'home_banner_img',
		array(
			'label'      => __( 'Home Banner Image', 'portfolio' ),
			'section'    => 'theme_options',
			'settings'   => 'home-banner-img',
			'capability' => 'manage_options'
		)
	) );
	
	$wp_customize->add_setting( 'blog-banner-img' );
	$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'blog_banner_img',
		array(
			'label'      => __( 'Blog Banner Image', 'portfolio' ),
			'section'    => 'theme_options',
			'settings'   => 'blog-banner-img',
			'capability' => 'manage_options'
		)
	) );
	
	$wp_customize->add_setting( 'footer-background-img' );
	$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'footer_background_img',
		array(
			'label'      => __( 'Footer Background Image', 'portfolio' ),
			'section'    => 'theme_options',
			'settings'   => 'footer-background-img',
			'capability' => 'manage_options'
		)
	) );
	
	$wp_customize->add_section(
		'contact_options',
		array(
			'title'    => __( 'Contact Information', 'portfolio' ),
			'priority' => 70
		)
	);
	$wp_customize->add_setting( 'contact-phn' );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'contact_phn',
		array(
			'label'      => __( 'Contact Phone Number', 'portfolio' ),
			'section'    => 'contact_options',
			'settings'   => 'contact-phn',
			'capability' => 'manage_options',
		)
	) );
	$wp_customize->add_setting( 'contact-email' );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'contact_email',
		array(
			'label'      => __( 'Contact Email', 'portfolio' ),
			'section'    => 'contact_options',
			'settings'   => 'contact-email',
			'capability' => 'manage_options',
		)
	) );
	$wp_customize->add_setting( 'contact-skype' );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'contact_skype',
		array(
			'label'      => __( 'Contact Skype', 'portfolio' ),
			'section'    => 'contact_options',
			'settings'   => 'contact-skype',
			'capability' => 'manage_options',
		)
	) );
	
	$wp_customize->add_setting( 'contact-address' );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'contact_address',
		array(
			'label'      => __( 'Contact Address', 'portfolio' ),
			'section'    => 'contact_options',
			'settings'   => 'contact-address',
			'type'       => 'textarea',
			'capability' => 'manage_options',
		)
	) );
	
	$wp_customize->add_setting( 'contact-github' );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'contact_github',
		array(
			'label'      => __( 'Contact Github', 'portfolio' ),
			'section'    => 'contact_options',
			'settings'   => 'contact-github',
			'capability' => 'manage_options',
		)
	) );
	$wp_customize->add_setting( 'contact-linkedin' );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'contact_linkedin',
		array(
			'label'      => __( 'Contact Linkedin', 'portfolio' ),
			'section'    => 'contact_options',
			'settings'   => 'contact-linkedin',
			'capability' => 'manage_options',
		)
	) );
	
	$wp_customize->add_setting( 'contact-facebook' );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'contact_facebook',
		array(
			'label'      => __( 'Contact Facebook', 'portfolio' ),
			'section'    => 'contact_options',
			'settings'   => 'contact-facebook',
			'capability' => 'manage_options',
		)
	) );
	
}

add_action( 'customize_register', 'register_customizer_options' );