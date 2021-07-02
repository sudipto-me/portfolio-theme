<?php
$theme_options         = get_option( 'abcd' );
$logo                  = ( ! empty( $theme_options['theme-header-logo']['url'] ) ) ? $theme_options['theme-header-logo']['url'] : get_template_directory_uri() . '/assets/img/header_logo.svg';
$logo_alt              = ( ! empty( $theme_options['theme-header-logo']['alt'] ) ) ? $theme_options['theme-header-logo']['alt'] : esc_html__( 'Site Logo', 'abcd' );
$header_topbar_content = ( ! empty( $theme_options['theme-topbar-content'] ) ) ? $theme_options['theme-topbar-content'][0] : '';
$header_script         = ( ! empty( $theme_options['theme-header-script'] ) ) ? $theme_options['theme-header-script'] : '';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <!-- Meta Data -->
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
    <?php if ( ! empty( $header_script ) ) {
        echo $header_script;
    } ?>
	
	<link rel="icon" type="image/png" sizes="512x512" href="//eddtheme.shakahri.cc/wp-content/uploads/2020/12/android-chrome-512x512-2.png">
</head>

<body <?php body_class(); ?>>

<header class="site_header area">
    <section class="header_top-section area">
        <div class="container">
            <div class="header_top-content">
                <?php
                if ( is_array( $header_topbar_content ) && count( $header_topbar_content ) ) {
                    echo '<ul>';
                    foreach ( $header_topbar_content as $key => $value ) {
                        if ( $key == 'refund-text' ) {
                            ?>
                            <li><span><img src="<?php echo get_template_directory_uri() . '/assets/img/smile.svg' ?>" alt="smile"></span>
                                <p><?php echo $value; ?></p></li>
                            <?php
                        } else if ( $key == 'payment-text' ) {
                            ?>
                            <li><span><img src="<?php echo get_template_directory_uri() . '/assets/img/credit-card.svg' ?>" alt="smile"></span>
                                <p><?php echo $value; ?></p></li>
                            <?php
                        } else if ( $key == 'support-text' ) {
                            ?>
                            <li><span><img src="<?php echo get_template_directory_uri() . '/assets/img/support.svg' ?>" alt="smile"></span>
                                <p><?php echo $value; ?></p></li>
                            <?php
                        }
                    }
                    echo '</ul>';
                }
                ?>
            </div>
            <!-- /.header_top-content -->
        </div>
        <!-- /.container -->
    </section>
    <!-- /.header_top-section -->
    <section class="main_header area">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <div class="header_logo">
                    <a href="<?php echo site_url( '/' ); ?>"><img src="<?php echo $logo; ?>" alt="<?php echo $logo_alt; ?>"></a>
                </div>
                <div class="mobile_navbar">
                    <div class="menu_icons">
                        <ul>
<!--                            <li><a href="--><?php //echo edd_get_checkout_uri(); ?><!--"><img src="--><?php //echo get_template_directory_uri() . '/assets/img/cart_icon.svg' ?><!--" alt="cart icon"><span class="header-cart edd-cart-quantity cart_count">--><?php //echo edd_get_cart_quantity(); ?><!--</span></a></li>-->
                            <li class="search_trigger">
                                <img src="<?php echo get_template_directory_uri() . '/assets/img/search_icon.svg'; ?>" alt="...">
                                <div class="search_bar">
                                    <form action="<?php echo home_url( '/' ); ?>" id="searchform" class="abcd_sidebar-searchbar" method="get">
                                        <input type="text" class="form-control" id="s" placeholder="<?php _e( 'Search...', 'abcd' ); ?>" name="s" value="<?php echo get_search_query(); ?>">
                                        <button type="submit" class="search_submit"><img src="<?php echo get_template_directory_uri() . '/assets/img/search_icon.svg'; ?>" alt="search icon"></button>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- /.menu_icons -->
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                
                    <div class="collapse navbar-collapse header_nav">
                        <?php
                        $menu_arguments = array(
                            'theme_location' => 'primary_navigation',
                            'container'      => '',
                            'menu_class'     => 'navbar-nav header_menu',
                            'echo'           => true,
                            'fallback_cb'    => 'wp_bootstrap_navwalker::fallback',
                            'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                            'depth'          => 5,
                            'walker'         => new wp_bootstrap_navwalker()
                        );
                        wp_nav_menu( $menu_arguments );
                        ?>
                    </div>
                    <!-- /.header menu -->
                    <div class="desktop_menu menu_icons">
                        <ul>
<!--                            <li><a href="--><?php //echo edd_get_checkout_uri(); ?><!--"><img src="--><?php //echo get_template_directory_uri() . '/assets/img/cart_icon.svg' ?><!--" alt="cart icon"><span class="header-cart edd-cart-quantity cart_count">--><?php //echo edd_get_cart_quantity(); ?><!--</span></a></li>-->
                            <li class="search_trigger">
                                <img src="<?php echo get_template_directory_uri() . '/assets/img/search_icon.svg'; ?>" alt="...">
                                <div class="search_bar">
                                    <form action="<?php echo home_url( '/' ); ?>" class="abcd_sidebar-searchbar" id="searchform" method="get">
                                        <input type="text" class="form-control" id="s" placeholder="<?php _e( 'Search...', 'abcd' ); ?>" name="s" value="<?php echo get_search_query(); ?>">
                                        <button type="submit" class="search_submit"><img src="<?php echo get_template_directory_uri() . '/assets/img/search_icon.svg'; ?>" alt="search icon"></button>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
            </nav>
            <!-- /.nav -->
        </div>
        <!-- /.container -->
    </section>
    <!-- /.main_header -->
</header>

<main class="area" style="">