<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package portfolio
 */
?>

<?php

$header_background      = ! empty( get_theme_mod( 'home-banner-img' ) ) ? wp_get_attachment_url( get_theme_mod( 'home-banner-img' ) ) : get_template_directory_uri() . '/assets/img/header-background.jpg';
$blog_header_background = ! empty( get_theme_mod( 'blog-banner-img' ) ) ? wp_get_attachment_url( get_theme_mod( 'blog-banner-img' ) ) : get_template_directory_uri() . '/assets/img/blog-header-background.jpg';
$header_background_alt  = ! empty( get_theme_mod( 'home-banner-img' ) ) ? wp_get_attachment_caption( get_theme_mod( 'home-banner-img' ) ) : esc_html__( 'Header Background', 'portfolio' );
$header_phone           = ! empty( get_theme_mod( 'contact-phn' ) ) ? get_theme_mod( 'contact-phn' ) : '+880-1921378547';
$header_email           = ! empty( get_theme_mod( 'contact-email' ) ) ? get_theme_mod( 'contact-email' ) : 'shakhari.sudipto@gmail.com';
$header_address         = ! empty( get_theme_mod( 'contact-address' ) ) ? get_theme_mod( 'contact-address' ) : 'House: 29, Road: 12, Mirpur Pallabi, Dhaka, 1216, Bangladesh';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <!-- Meta Data -->
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<!--Switcher-->
<?php do_action( 'portfolio_before_header' ); ?>
<div class="style-switcher">
    <span class="style-switcher__control"></span>
    <div class="style-switcher__list">
        <a class="style-switcher__link style-switcher__link--color"></a>
        <a class="style-switcher__link style-switcher__link--mono"></a>
    </div>
</div>
<!--Switcher-->
<!-- Main Menu -->
<div class="menu">
    <div class="container">
        <div class="row">
            <div class="menu__wrapper d-none d-lg-block col-md-12">
				<?php
				$menu_arguments = array(
					'theme_location' => 'primary_navigation',
					'container'      => 'nav',
					'menu_class'     => 'header_menu',
					'echo'           => true,
					'fallback_cb'    => 'wp_bootstrap_navwalker::fallback',
					'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
					'depth'          => 5,
					'walker'         => new wp_bootstrap_navwalker()
				);
				wp_nav_menu( $menu_arguments );
				?>
            </div>
            <div class="menu__wrapper col-md-12 d-lg-none">
                <div class="menu__mobile-button">
                    <span><i class="fa fa-bars" aria-hidden="true"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.Main Menu -->
<div class="mobile-menu d-lg-none">
    <div class="container">
        <div class="mobile-menu__close">
            <span><i class="mdi mdi-close" aria-hidden="true"></i></span>
        </div>
		<?php
		$menu_arguments = array(
			'theme_location'  => 'primary_navigation',
			'container'       => 'nav',
			'container_class' => 'mobile-menu__wrapper',
			'menu_class'      => '',
			'echo'            => true,
			'fallback_cb'     => 'wp_bootstrap_navwalker::fallback',
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'depth'           => 5,
			'walker'          => new wp_bootstrap_navwalker()
		);
		wp_nav_menu( $menu_arguments );
		?>
    </div>
</div>
<?php
if ( is_front_page() ):
	?>
    <header class="main-header" style="background-image: url(<?php echo esc_url( $header_background ); ?>)">
        <div class="container">
            <div class="row personal-profile">
                <div class="col-md-4 personal-profile__avatar">
                    <img class="img-fluid" src="<?php echo ! empty( get_theme_mod( 'home-avatar' ) ) ? wp_get_attachment_url( get_theme_mod( 'home-avatar' ) ) : esc_url( "//via.placeholder.com/350x400" ); ?>" alt="<?php echo esc_attr__( "avatar", "portfolio" ); ?>">
                </div>
                <div class="col-md-8">
                    <p class="personal-profile__name"><?php echo ! empty( get_theme_mod( 'portfolio-name' ) ) ? get_theme_mod( 'portfolio-name' ) : esc_html__( "Sudipto Shakhari", "portfolio" ); ?></p>
                    <p class="personal-profile__work"><?php echo ! empty( get_theme_mod( 'portfolio-designation' ) ) ? get_theme_mod( 'portfolio-designation' ) : esc_html__( "WordPress Developer, WordPress Plugin-Engineer", "portfolio" ); ?></p>
                    <div class="personal-profile__contacts">
                        <dl class="contact-list contact-list__opacity-titles">
                            <dt><?php esc_html_e( "Age", "portfolio" ); ?></dt>
                            <dd><?php echo ! empty( get_theme_mod( 'portfolio-age' ) ) ? get_theme_mod( 'portfolio-age' ) : esc_html__( "27", "portfolio" ) ?></dd>
                            <dt><?php esc_html_e( "Phone:", "portfolio" ); ?></dt>
                            <dd><a href="<?php echo 'tel:' . esc_attr( $header_phone ); ?>"><?php echo esc_attr( $header_phone ); ?></a></dd>
                            <dt><?php esc_html_e( "Email:", "portfolio" ); ?></dt>
                            <dd><a href="<?php echo 'mailto:' . sanitize_email( $header_email ); ?>"><?php echo sanitize_email( $header_email ); ?></a></dd>
                            <dt><?php esc_html_e( "Address:", "portfolio" ); ?>:</dt>
                            <dd><?php esc_html_e( $header_address ); ?></dd>
                        </dl>
                    </div>
                    <p class="personal-profile__social">
                        <a href="<?php echo ! empty( get_theme_mod( 'contact-github' ) ) ? esc_url( get_theme_mod( 'contact-github' ) ) : '#' ?>" target="_blank"><i class="fa fa-github"></i></a>
                        <a href="<?php echo ! empty( get_theme_mod( 'contact-linkedin' ) ) ? esc_url( get_theme_mod( 'contact-linkedin' ) ) : '#' ?>" target="_blank"><i class="fa fa-linkedin-square"></i></a>
                        <a href="<?php echo ! empty( get_theme_mod( 'contact-facebook' ) ) ? esc_url( get_theme_mod( 'contact-facebook' ) ) : '#' ?>" target="_blank"><i class="fa fa-facebook-square"></i></a>
                    </p>
                </div>
            </div>
        </div>
    </header>
<?php else: ?>
    <!--Header-->
    <header class="background blog-header" style="background-image: url(<?php echo esc_url( $blog_header_background ); ?>)">
		<?php
		if ( ! is_single() ) {
			?>
            <div class="header-title container">
                <div class="row">
                    <div class="col-md-12">
						<?php if ( ! is_post_type_archive( 'portfolio-projects' ) ): ?>
                            <h1 class="portfolio-page-title"><?php echo get_the_title( get_queried_object_id() ); ?></h1>
						<?php elseif ( is_post_type_archive( 'portfolio-projects' ) ): ?>
                            <h1 class="portfolio-page-title"><?php echo esc_html__( 'Projects', 'portfolio' ); ?></h1>
						<?php else: ?>
                            <h1 class="portfolio-page-title"><?php echo get_the_archive_title(); ?></h1>
						<?php endif; ?>
						<?php
						if ( is_home() ) {
							echo '<p class="portfolio-page-subtitle">' . __( 'Tips, tricks, Reviews and eCommerce inspiration', 'portfolio' ) . '</p>';
						} elseif ( is_post_type_archive( 'portfolio-projects' ) ) {
							echo '<p class="portfolio-page-subtitle">' . __( 'Completed Projects with live link', 'portfolio' ) . '</p>';
						} else {
							do_action( 'plugins/wp_subtitle/the_subtitle', array(
								'before'        => '<p class="portfolio-page-subtitle">',
								'after'         => '</p>',
								'post_id'       => get_queried_object_id(),
								'default_value' => ''
							) );
						}
						?>
                    </div>
                </div>
            </div>
			<?php
		}
		?>
    </header>
    <!--Header-->
<?php endif; ?>
<!--Header-->
<?php do_action( 'portfolio_after_header' ); ?>
