<?php
/**
 * Template Name: Home Page
 *
 **/
get_header();
$hero_section = get_field( 'hero_section' );

$hero_title    = ( $hero_section['hero_section_title'] != '' ) ? $hero_section['hero_section_title'] : 'We Develop Wordpress <br> Plugin That Amaze You!';
$hero_subtitle = ( $hero_section['hero_section_subtitle'] != '' ) ? $hero_section['hero_section_subtitle'] : 'With rich faq and amazing customer support, we guarantee you the best experience with all of our plugins!';
$hero_bg       = ( $hero_section['hero_section_bg_image']['url'] ) ? $hero_section['hero_section_bg_image']['url'] : get_template_directory_uri() . '/assets/img/banner.svg';
$hero_bg_alt   = ( $hero_section['hero_section_bg_image']['alt'] ) ? $hero_section['hero_section_bg_image']['alt'] : 'Hero img';
if ( have_posts() ):
    while ( have_posts() ) :
        the_post();
        ?>
        <section class="default-page-with-sidebar area">
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <div class="hero_section area">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 wow slideInLeft" data-wow-delay="0.8s" style="visibility: hidden">
                                <div class="hero_content">
                                    <h1><?php echo $hero_title; ?></h1>
                                    <?php echo $hero_subtitle; ?>
                                    <a href="<?php echo get_post_type_archive_link( 'download' ) ?>" class="site_cta"><?php echo __( 'See Plugins', 'abcd' ); ?> </a>
                                </div>
                                <!-- /.hero_content -->
                            </div>
                            <!-- /.col-md-6 -->
                            <div class="col-md-6 wow slideInRight" data-wow-delay="0.9s" style="visibility: hidden">
                                <div class="hero_img">
                                    <img src="<?php echo $hero_bg; ?>" alt="<?php echo $hero_bg_alt; ?>">
                                </div>
                                <!-- /.hero_img -->
                            </div>
                            <!-- /.col-md-6 -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container -->
                </div>
                <!-- /.hero_section -->
                <section class="counter_section area">
                    <div class="container">
                        <div class="counter_wrapper">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="counter_box">
                                        <div class="counter_icon">
                                            <img src="<?php echo get_template_directory_uri() . "/assets/img/download.svg" ?>" alt="counter one">
                                        </div>
                                        <div class="counter_content">
                                            <h2><span class="counter"><?php echo __( '500', 'abcd' ); ?></span><?php _e( 'K+', 'abcd' ); ?></h2>
                                            <p><?php echo __( 'Downloads', 'abcd' ); ?></p>
                                        </div>
                                    </div>
                                    <!-- /.counter_box -->
                                </div>
                                <!-- /.col-md-4 -->
                                <div class="col-md-4">
                                    <div class="counter_box">
                                        <div class="counter_icon">
                                            <img src="<?php echo get_template_directory_uri() . "/assets/img/search.svg" ?>" alt="counter two">
                                        </div>
                                        <div class="counter_content">
                                            <h2><span class="counter"><?php _e('24','abcd');?></span><?php _e( 'K+', 'abcd' ); ?></h2>
                                            <p><?php echo __( 'Happy Customers', 'abcd' ); ?></p>
                                        </div>
                                    </div>
                                    <!-- /.counter_box -->
                                </div>
                                <!-- /.col-md-4 -->
                                <div class="col-md-4">
                                    <div class="counter_box">
                                        <div class="counter_icon">
                                            <img src="<?php echo get_template_directory_uri() . "/assets/img/member.svg" ?>" alt="counter three">
                                        </div>
                                        <div class="counter_content">
                                            <h2><span class="counter"><?php _e('30','abcd');?></span><?php _e( 'K+', 'abcd' ); ?></h2>
                                            <p><?php echo __( 'Team Member', 'abcd' ); ?></p>
                                        </div>
                                    </div>
                                    <!-- /.counter_box -->
                                </div>
                                <!-- /.col-md-4 -->
                            </div>
                            <!-- /.row -->
                        </div>
                    </div>
                    <!-- /.container -->
                </section>
                <!-- /.counter_section area -->
                <section class="why_us_section area">
                    <img src="<?php echo get_template_directory_uri() . '/assets/img/why_us_bg_new.png'; ?>" alt="why us bg" class="why_us_bg">
                    <div class="container">
                        <h2 class="section_title"><?php echo __( 'Why buy from us?', 'abcd' ); ?></h2>
                        <div class="row">
                            <?php
                            if ( have_rows( 'buy_from_us' ) ):
                                while ( have_rows( 'buy_from_us' ) ):
                                    the_row();
                                    ?>
                                    <div class="wow slideInLeft col-md-4">
                                        <div class="why_us_wrapper">
                                            <div class="why_us_img">
                                                <img src="<?php echo get_sub_field( 'image' )['url']; ?>" alt="why us">
                                            </div>
                                            <!-- /.why_us_img -->
                                            <h3 class="why_us_title"><?php echo get_sub_field( 'title' ); ?></h3>
                                            <p><?php echo get_sub_field( 'description' ); ?></p>
                                        </div>
                                        <!-- /.why_us_wrapper -->
                                    </div>
                                    <!-- /.col-md-4 -->
                                <?php endwhile;endif; ?>
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container -->
                </section>
                <!-- /.why_us_section area -->
                <section class="plugin_section area">
                    <div class="container">
                        <h2 class="section_title"><?php echo __( 'Our Plugins', 'abcd' ); ?></h2>
                        <p class="section_subtitle"><?php echo ( get_field( 'plugin_sections_subtitle' ) != '' ) ? get_field( 'plugin_sections_subtitle' ) : __( 'NEW FEATURES! Upsell on Product Pages | Auto pilot mode |', 'abcd' ); ?></p>
                        <div class="plugin_wrapper">
                            <div class="row">
                                <?php
                                $plugins = get_posts( array(
                                    'post_type'      => 'download',
                                    'posts_per_page' => 2,
                                    'post_status'    => 'publish',
                                    'meta_key'       => '_edd_download_sales',
                                    'order'          => 'DESC',
                                    'orderby'        => 'meta_value_num'
                                ) );
                                if ( is_array( $plugins ) && count( $plugins ) ) {
                                    ?>
                                    <?php
                                    $i = 0;
                                    foreach ( $plugins as $plugin ) {
                                        ?>
                                        <div class="wow col-md-6 <?php echo ( $i == 0 ) ? 'slideInLeft' : 'slideInRight' ?>">
                                            <div class="plugin_box">
                                                <div class="plugin_img">
                                                    <a href="<?php echo get_the_permalink( $plugin->ID ); ?>"><img src="<?php echo ( get_field( 'icons', $plugin->ID )['url'] != '' ) ? get_field( 'icons', $plugin->ID )['url'] : get_template_directory_uri() . '/assets/img/plugin_thumbnail.svg' ?>" alt="<?php echo strtolower( get_the_title( $plugin->ID ) ); ?>" class="plugin_icon"></a>
                                                </div>
                                                <!-- /.plugin_img -->
                                                <h3 class="plugin_name"><a href="<?php echo get_the_permalink( $plugin->ID ); ?>"><?php echo get_the_title( $plugin->ID ); ?></a></h3>
                                                <p><?php echo get_field( 'product_subtitle', $plugin->ID ); ?></p>
                                                <a href="<?php echo get_the_permalink( $plugin->ID ); ?>"><?php echo __( 'Buy now', 'abcd' ); ?> <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                                            </div>
                                            <!-- /.plugin_box -->
                                        </div>
                                        <!-- /.col-md-6 -->
                                        <?php
                                        $i ++;
                                    }
                                }
                                ?>
                            </div>
                            <!-- /.row -->
                            <div class="text-center">
                                <a href="<?php echo get_post_type_archive_link( 'download' ) ?>" class="site_cta"><img src="<?php echo get_template_directory_uri() . '/assets/img/package.svg'; ?>" alt="package" class="package_icon"><span><?php echo __( 'Explore Our All plugins', 'abcd' ); ?></span></a>
                            </div>
                        </div>
                        <!-- /.plugin_wrapper -->
                    </div>
                    <!-- /.container -->
                </section>
                <!-- /.plugin_section area -->
                <section class="wow bounceInBottom testimonial_section area">
                    <div class="container">
                        <?php
                        $testimonials = get_posts( array(
                            'post_type'      => 'theme-testimonials',
                            'orderby'        => 'rand',
                            'posts_per_page' => 3,
                        ) );
                        if ( is_array( $testimonials ) && count( $testimonials ) ) { ?>
                            <div class="testimonial_carousel owl-carousel">
                                <?php foreach ( $testimonials as $testimonial ) { ?>
                                    <div class="testimonial_slides">
                                        <div class="author_img">
                                            <img src="<?php echo get_the_post_thumbnail_url( $testimonial->ID ) ? get_the_post_thumbnail_url( $testimonial->ID, array( 149, 96 ) ) : get_template_directory_uri() . '/assets/img/testimonial-thumbnail.png'; ?>" alt="<?php echo strtolower( get_the_title( $testimonial->ID ) ); ?>">
                                        </div>
                                        <div class="author_ratings">
                                            <ul>
                                                <li>
                                                    <div class="starts-outer">
                                                        <div class="starts-inner" style="width: <?php echo get_field( 'testimonial_review_count', $testimonial->ID ) * 20 ?>%"></div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <p><img src="<?php echo get_template_directory_uri() . '/assets/img/start_quote.svg'; ?>" alt="start quote" class="quote_img"><?php echo $testimonial->post_content; ?><img src="<?php echo get_template_directory_uri() . '/assets/img/end_quote.svg'; ?>" alt="start quote" class="quote_img"></p>
                                        <h4 class="author_name"><?php echo get_the_title( $testimonial->ID ); ?></h4>
                                        <h6 class="author_desig"> <?php echo get_field( 'testimonial_designation', $testimonial->ID ); ?></h6>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                    <!-- /.container -->
                </section>
                <!-- /.testimonial_section -->
                <section class="clients_section area">
                    <div class="container">
                        <?php
                        $clients = get_posts( array(
                            'post_type'      => 'client-logos',
                            'orderby'        => 'rand',
                            'posts_per_page' => 5,
                        ) );
                        if ( is_array( $clients ) && count( $clients ) ) { ?>
                            <div class="wow pulse client_logo_wrapper">
                                <?php foreach ( $clients as $client ) {
                                    $get_url = get_field( 'url', $client->ID ); ?>
                                    <div class="clients_logo">
                                        <a href="<?php echo ! empty( $get_url ) ? $get_url : '#' ?>"><img src="<?php echo get_the_post_thumbnail_url( $client->ID ); ?>" alt="<?php echo strtolower( get_the_title( $client->ID ) ); ?>"></a>
                                    </div>
                                <?php } ?>
                            </div>
                            <!-- /.client_logo_wrapper -->
                        <?php } ?>
                    </div>
                    <!-- /.container -->
                </section>
                <!-- /.clients_section area -->
                <section class="faq_section area">
                    <img src="<?php echo get_template_directory_uri() . '/assets/img/faq_bg.png'; ?>" alt="faq bg" class="faq_bg">
                    <div class="container">
                        <div class="faq_content_wrapper">
                            <div class="faq_icon">
                                <img src="<?php echo get_template_directory_uri() . "/assets/img/faq_icon.svg"; ?>" alt="faq icon">
                            </div>
                            <h2 class="section_title wow fadeIn"><?php echo __( 'Fequently Asked Questions', 'abcd' ); ?></h2>
                            <div class="faq_accordion_wrapper accordion wow fadeIn" id="accordionExample">
                                <?php
                                $faqs = get_posts( array(
                                    'post_type'      => 'faq-item',
                                    'post_status'    => 'publish',
                                    'posts_per_page' => -1,
                                    'order' => 'asc'
                                ) );
                                if ( is_array( $faqs ) && count( $faqs ) ) {
                                    foreach ( $faqs as $single_faq ) {
                                        ?>
                                        <div class="faq_accordion">
                                            <div class="faq_accordion_header collapsed" id="heading<?php echo $single_faq->ID ?>" data-toggle="collapse" data-target="#collapse<?php echo $single_faq->ID ?>" aria-expanded="true" aria-controls="collapse<?php echo $single_faq->ID ?>">
                                                <h4><?php echo $single_faq->post_title; ?></h4>
                                                <div class="acc_arrow">
                                                    <img src="<?php echo get_template_directory_uri() . '/assets/img/plus.svg'; ?>" alt="plus" class="plus_icon">
                                                    <img src="<?php echo get_template_directory_uri() . '/assets/img/minus.svg'; ?>" alt="plus" class="minus_icon">
                                                </div>
                                            </div>

                                            <div id="collapse<?php echo $single_faq->ID ?>" class="faq_accordion_content collapse" aria-labelledby="heading<?php echo $single_faq->ID ?>" data-parent="#accordionExample">
                                                <p><?php echo $single_faq->post_content; ?></p>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <!-- /.faq_content_wrapper -->
                    </div>
                    <!-- /.container -->
                </section>
                <!-- /.faq_section area -->

                <section class="blog_section area">
                    <div class="container">
                        <h2 class="section_title wow fadeIn"><?php echo __( 'Latest Articles', 'abcd' ); ?></h2>
                        <div class="row">
                            <?php
                            $posts = get_posts( array(
                                'post_type'      => 'post',
                                'posts_per_page' => 3,
                                'post_status'    => 'publish',
                                'orderby'        => 'date',
                                'order'          => 'DESC'
                            
                            ) );
                            if ( is_array( $posts ) && count( $posts ) ) {
                                $i = 0;
                                foreach ( $posts as $single_post ) {
                                    $animation_class = '';
                                    if ( $i == 0 ) {
                                        $animation_class = 'slideInLeft';
                                    } elseif ( $i == 1 ) {
                                        $animation_class = 'fadeInDown ';
                                    } else {
                                        $animation_class = 'slideInRight';
                                    }
                                    ?>
                                    <div class="col-md-4 wow <?php echo $animation_class; ?>">
                                        <div class="blog_posts">
                                            <div class="post_img">
                                                <a href="<?php echo get_the_permalink( $single_post->ID ); ?>">
                                                    <img src="<?php echo get_the_post_thumbnail_url( $single_post->ID ) ? get_the_post_thumbnail_url( $single_post->ID ) : get_template_directory_uri() . '/assets/img/post.jpg' ?>" alt="<?php echo strtolower( get_the_title( $single_post->ID ) ); ?>">
                                                </a>
                                            </div>
                                            <div class="post_content">
                                                <?php
                                                $post_category = get_the_category( $single_post->ID );
                                                if ( is_array( $post_category ) && count( $post_category ) ) {
                                                    ?>
                                                    <a href="<?php echo esc_url( get_category_link( $post_category[0]->term_id ) ); ?>"><span class="post_cat"><?php echo $post_category[0]->name; ?></span></a>
                                                    <?php
                                                }
                                                ?>
                                                <h2 class="post_title"><a href="<?php echo get_the_permalink( $single_post->ID ); ?>"><?php echo get_the_title( $single_post->ID ); ?></a></h2>
                                            </div>
                                        </div>
                                        <!-- /.blog_posts -->
                                    </div>
                                    <!-- /.col-md-4 -->
                                    <?php
                                    $i ++;
                                }
                            }
                            ?>
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container -->
                </section>
                <!-- /.blog_section area -->
                <section class="guarantee_section area">
                    <div class="container">
                        <div class="guarantee_wrapper wow slideInTop">
                            <div class="moneyback_content">
                                <div class="award_img">
                                    <img src="<?php echo get_template_directory_uri() . '/assets/img/award.svg' ?>" alt="award-img">
                                </div>
                                <?php
                                $money_back_options          = get_field( 'money_back_section' );
                                $money_back_section_title    = ( $money_back_options['section_title'] != '' ) ? $money_back_options['section_title'] : __( '7 Days Money Back Guarantee', 'abcd' );
                                $money_back_section_subtitle = $money_back_options['section_subtitle'];
                                $money_back_list             = $money_back_options['list_items'];
                                
                                ?>
                                <div class="award_content">
                                    <h2><?php echo $money_back_section_title; ?></h2>
                                    <p><?php echo $money_back_section_subtitle; ?></p>
                                </div>

                            </div>
                            <div class="moneyback_list">
                                <ul>
                                    <?php
                                    if ( is_array( $money_back_list ) && count( $money_back_list ) ) {
                                        foreach ( $money_back_list as $single ) {
                                            ?>
                                            <li><img src="<?php echo get_template_directory_uri() . '/assets/img/fill_tick.svg' ?>" alt="tick"><p><?php echo $single['single_item']; ?></p></li>
                                            <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <!-- /.guarantee_wrapper -->
                    </div>
                    <!-- /.container -->
                </section>
                <!-- /.guarantee_section area -->
            </article>
        </section>
    <?php
    endwhile;
endif;
get_footer();
