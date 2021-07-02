<?php get_header(); ?>

<?php if ( have_posts() ) {
    while ( have_posts() ) {
        the_post();
        $image_alt        = get_post_meta( get_post_thumbnail_id( $post->ID ), '_wp_attachment_image_alt', true );
        $image_alt        = ( empty( $image_alt ) ) ? get_the_title( $post->ID ) : $image_alt;
        $attachment_title = get_the_title( get_post_thumbnail_id( $post->ID ) );
        $icons    = get_field( 'icons',$post->ID );
        $icon_url = $icons['url'];
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <section class="inner_page_wrapper area">
                <div class="container">
                    <div class="product_content_wrapper section_padding area">
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="product_content">
                                    <h1 class="heading_title"><?php echo get_the_title(); ?></h1>
                                    <div class="product_ratings">
                                        <p class="version"><img src="<?php echo $icon_url ? $icon_url : get_template_directory_uri() . '/assets/img/plugin.png' ?>" alt="plugin thumbnail" class="plugin_icon"> Version: <?php echo get_field( 'current_version',$post->ID ); ?> <a class="changelog" href="#changelog">Changelog</a></p>
                                        <p>
                                            <?php
                                            $total_reviews = edd_reviews()->average_rating( false, $post->ID );
                                            echo '<ul>';
                                            ?>
                                        <li>
                                            <div class="starts-outer">
                                                <div class="starts-inner" style="width: <?php echo $total_reviews * 20 ?>%"></div>
                                            </div>
                                        </li>
                                        <li>(<?php echo edd_reviews()->count_reviews() . ' reviews'; ?>)</li>
                                        <?php echo '</ul></p>'; ?>
                                    </div>
                                    <p><?php echo get_the_excerpt(); ?></p>
                                </div>
                                <?php echo edd_get_purchase_link( array( 'download_id' => $post->ID ) ); ?>
                            </div>
                            <!-- /.col-lg-6 -->
                            <div class="col-lg-6 col-md-12">
                                <div class="Product_content_image">
                                    <img src="<?php echo get_the_post_thumbnail_url( $post, 'full' ) ? get_the_post_thumbnail_url( $post, 'full' ) : get_template_directory_uri() . '/assets/img/product_hero_img.jpg' ?>" alt="...">
                                </div>
                                <!-- /.Product_content_image -->
                            </div>
                            <!-- /.col-lg-6 col-md-12 -->
                        </div>
                        <!-- /.row -->
                        <div class="product_main_tab_wrapper">
                            <ul class="nav nav-tabs" id="product_main_tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true"><img src="<?php echo get_template_directory_uri() . '/assets/img/desc_icon.svg'; ?>" alt="description"> Description</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="features-tab" data-toggle="tab" href="#features" role="tab" aria-controls="features" aria-selected="false"><img src="<?php echo get_template_directory_uri() . '/assets/img/features.svg'; ?>" alt="features"> Features</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false"><img src="<?php echo get_template_directory_uri() . '/assets/img/reviews.svg'; ?>" alt="reviews"> Reviews</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="documentations-tab" data-toggle="tab" href="#documentations" role="tab" aria-controls="documentations" aria-selected="false"><img src="<?php echo get_template_directory_uri() . '/assets/img/documentation.svg'; ?>" alt="documentation"> Documentations</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="changelog-tab" data-toggle="tab" href="#changelog" role="tab" aria-controls="changelog" aria-selected="false"><img src="<?php echo get_template_directory_uri() . '/assets/img/changelog.svg' ?>" alt="changelog"> Changelog</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="livedemo-tab" data-toggle="tab" href="#livedemo" role="tab" aria-controls="livedemo" aria-selected="false"><img src="<?php echo get_template_directory_uri() . '/assets/img/demo.svg' ?>" alt="demo"> Live demo</a>
                                </li>
                            </ul>
                            <!-- End of tab nav -->
                            <div class="tab-content product_main_tab_content" id="product_main_tab_content">
                                <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                                    <div class="product_tab_inner_content_wrapper">
                                        
                                        <?php
                                        if ( $post->post_content != '' ) {
                                            echo get_the_content();
                                        } else { ?>
                                            <div class="alert alert-secondary changelog-alert"><?php _e( 'Nothing Found', 'abcd' ); ?></div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="features" role="tabpanel" aria-labelledby="features-tab">
                                    <div class="product_tab_inner_content_wrapper">
                                        <h2 class="text-center"><?php the_field( 'feature_section_title' ); ?></h2>
                                        <p class="text-center"><?php the_field( 'feature_sub_title' ); ?></p>
                                        <?php
                                        $features = get_field( 'features' );
                                        if ( $features ) {
                                            $total_features      = count( $features );
                                            $feature_first_half  = round( $total_features / 2 );
                                            $feature_second_half = $total_features - $feature_first_half;
                                            ?>
                                            <div class="row">
                                                <div class="col-lg-6 col-sm-12">
                                                    <div class="step_card_wrapper">
                                                        <?php
                                                        for ( $i = 0; $i < $feature_first_half; $i ++ ) {
                                                            ?>
                                                            <div class="single_card_element">
                                                                <span><?php echo sprintf( "%02d", $i + 1 ); ?></span>
                                                                <p><?php echo $features[ $i ]['individual_features']; ?></p>
                                                            </div>
                                                            <!-- /.single_card_element -->
                                                        <?php } ?>
                                                    </div>
                                                    <!-- /.step_card_wrapper-->
                                                </div>
                                                <div class="col-lg-6 col-sm-12">
                                                    <div class="step_card_wrapper">
                                                        <?php
                                                        for ( $i = $feature_first_half; $i < count( $features ); $i ++ ) { ?>
                                                            <div class="single_card_element">
                                                                <span><?php echo sprintf( "%02d", $i + 1 ); ?></span>
                                                                <p><?php echo $features[ $i ]['individual_features']; ?></p>
                                                            </div>
                                                            <!-- /.single_card_element -->
                                                        <?php } ?>
                                                    </div>
                                                    <!-- /.step_card_wrapper-->
                                                </div>
                                            </div>
                                            <!-- /.row -->
                                        <?php } else { ?>
                                            <div class="alert alert-secondary changelog-alert"><?php _e( 'Nothing Found', 'abcd' ); ?></div>
                                        <?php } ?>
                                    </div>
                                    <!-- /.product_tab_inner_content_wrapper -->
                                </div>
                                <!-- End of features tab -->
                                <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                                    <div class="product_tab_inner_content_wrapper">
                                        <?php
                                        edd_get_template_part( 'reviews' );
                                        if ( get_option( 'thread_comments' ) ) {
                                            edd_get_template_part( 'reviews-reply' );
                                        }
                                        ?>
                                    </div>
                                    <!-- /.product_tab_inner_content_wrapper -->
                                </div>
                                <!-- End of reviews tab -->
                                <div class="tab-pane fade" id="documentations" role="tabpanel" aria-labelledby="documentations-tab">
                                    <div class="documentation_main_tab_wrapper">
                                        <ul class="nav nav-tabs" id="documentation_main_tab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="documentation-tab" data-toggle="tab" href="#documentation" role="tab" aria-controls="documentation" aria-selected="true">
                                                    <?php
                                                    $documentations = get_posts(
                                                        array(
                                                            'post_type'      => 'theme_documentation',
                                                            'posts_per_page' => - 1,
                                                            'post_status'    => 'publish',
                                                            'order'          => 'asc',
                                                            'orderby'        => 'ID',
                                                        )
                                                    );
                                                    $count          = 0;
                                                    if ( is_array( $documentations ) && count( $documentations ) ) {
                                                        foreach ( $documentations as $single ) {
                                                            $related_downloads = get_post_meta( $single->ID, 'documentaion-download', true );
                                                            if ( is_array( $related_downloads ) && count( $related_downloads ) ) {
                                                                if ( in_array( get_the_id(), $related_downloads ) ) {
                                                                    $count ++;
                                                                }
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                    <h2><?php _e( 'Documentations', 'abcd' ); ?></h2>
                                                    <p><?php echo $count . ' ' . __( 'Documentations', 'abcd' ); ?></p>
                                                    <div class="tab_icon">
                                                        <img src="<?php echo get_template_directory_uri() . '/assets/img/text_documentation.svg'; ?>" alt="document">
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="video-tut-tab" data-toggle="tab" href="#video-tut" role="tab" aria-controls="video-tut" aria-selected="false">
                                                    <h2>Video Tutorials</h2>
                                                    <p><?php echo ! empty( get_field( 'tutorials_count' ) ) ? get_field( 'tutorials_count' ) : 0; ?> Videos</p>
                                                    <div class="tab_icon">
                                                        <img src="<?php echo get_template_directory_uri() . '/assets/img/videos_icon.svg' ?>" alt="videos">
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                        <!-- End of tab nav -->
                                        <div class="tab-content" id="product_subscription_tab_content">
                                            <div class="tab-pane fade active show" id="documentation" role="tabpanel" aria-labelledby="documentation-tab">
                                                <div class="documentation_accordion_wrapper accordion" id="accordionExample">
                                                    <?php
                                                    $count = 0;
                                                    if ( is_array( $documentations ) && count( $documentations ) ) {
                                                        foreach ( $documentations as $single ) {
                                                            $related_downloads = get_post_meta( $single->ID, 'documentaion-download', true );
                                                            if ( is_array( $related_downloads ) && count( $related_downloads ) ) {
                                                                if ( in_array( get_the_id(), $related_downloads ) ) {
                                                                    ?>
                                                                    <div class="documentation_accordion">
                                                                        <div class="documentation_accordion_header collapsed" id="heading<?php echo $single->post_name; ?>" data-toggle="collapse" data-target="#collapse<?php echo $single->post_name ?>" aria-expanded="false" aria-controls="<?php echo $single->post_name ?>">
                                                                            <h4><?php echo get_the_title( $single->ID ); ?></h4>
                                                                            <div class="acc_arrow">
                                                                                <img src="<?php echo get_template_directory_uri() . '/assets/img/arrow-right.svg' ?>" alt="right arrow">
                                                                            </div>
                                                                        </div>
                                                                        <div id="collapse<?php echo $single->post_name ?>" class="documentation_accordion_content collapse" aria-labelledby="heading<?php echo $single->post_name; ?>" data-parent="#accordionExample" style="">
                                                                            <?php
                                                                            $read_more_url = '<a href=' . get_the_permalink( $single->ID ) . ' class="read_more">' . __( ' Continue Reading ', 'abcd' ) . '<i class="fa fa-long-arrow-right" aria-hidden="true"></i>' . '</a>';
                                                                            ?>
                                                                            <p><?php echo wp_trim_words( $single->post_content, 50, $read_more_url ); ?></p>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                    $count ++;
                                                                }
                                                            }
                                                        }
                                                    }
                                                    if ( $count == 0 ) {
                                                        ?>
                                                        <div class="text-center coming_soon">
                                                            <img src="<?php echo get_template_directory_uri() . '/assets/img/coming_soon.png' ?>" alt="coming soon">
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="video-tut" role="tabpanel" aria-labelledby="video-tut-tab">
                                                <div class="video_tut_wrapper">
                                                    <?php if ( get_field( 'youtube_playlist_url', get_the_id() ) != '' ) { ?>
                                                        <iframe width="100%" height="500" src="<?php echo get_field( 'youtube_playlist_url' ) ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen="" showinfo="1" class="video_iframe"></iframe>
                                                    <?php } else { ?>
                                                        <div class="text-center coming_soon">
                                                            <img src="<?php echo get_template_directory_uri() . '/assets/img/coming_soon.png' ?>" alt="coming soon">
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <!-- /.video_tut_wrapper -->
                                            </div>
                                        </div>
                                        <!-- End of tab nav content -->
                                    </div>
                                    <!-- /.product_main_tab -->
                                </div>
                                <!--  End of documentation tab  -->
                                <div class="tab-pane fade" id="changelog" role="tabpanel" aria-labelledby="changelog-tab">
                                    <div class="product_tab_inner_content_wrapper">
                                        <?php
                                        $logs = get_field( 'logs' );
                                        if ( $logs ) {
                                            ?>
                                            <div class="changelog_timeline_wrapper">
                                                <?php
                                                $logs          = get_field( 'logs' );
                                                $logs          = ( $logs ) ? array_reverse( $logs ) : $logs;
                                                $logs_count    = ( $logs ) ? count( get_field( 'logs' ) ) : 0;
                                                $logs_per_page = 5;
                                                $counter       = 1;
                                                if ( $logs ) {
                                                    foreach ( $logs as $log ) {
                                                        if ( $counter <= $logs_per_page ):
                                                            ?>
                                                            <div class="changelog_timeline_box">
                                                                <div class="version_no">
                                                                    <p><?php echo $log['version']; ?></p>
                                                                </div>
                                                                <span class="date"><?php echo $log['release_date']; ?></span>
                                                                <?php echo $log['log_details']; ?>
                                                            </div>
                                                            <!-- /.changelog_timeline_box -->
                                                        <?php
                                                        endif;
                                                        $counter ++;
                                                    }
                                                }
                                                ?>
                                                <div class="change_log_response">
                                                </div>
                                                <!-- /.change_log_response -->
                                                <?php
                                                if ( $logs_count > $logs_per_page ) {
                                                    ?>
                                                    <div class="changelog_timeline_loadmore">
                                                        <img src="<?php echo get_template_directory_uri() . '/assets/img/loading.gif' ?>" alt="loading" class="loading hide">
                                                        <input type="hidden" class="changelog-load-more" name="load-more" data-post_id="<?php echo get_the_id(); ?>" data-posts-per-page="<?php echo $logs_per_page; ?>" data-total-items="<?php echo $logs_count; ?>" data-current-page="1">
                                                        <a href="#" class="changelog_load_more site_cta"><?php _e( 'Load More', 'abcd' ); ?></a>
                                                    </div>
                                                    <!-- /.changelog_timeline_loadmore -->
                                                <?php } ?>
                                            </div>
                                            <!--    /.changelog_timeline_wrapper  -->
                                        <?php } else { ?>
                                            <div class="alert alert-secondary changelog-alert"><?php _e( 'Nothing Found', 'abcd' ); ?></div>
                                        <?php } ?>
                                    </div>
                                    <!--/.product_tab_inner_content_wrapper  -->
                                </div>
                                <!-- End of change log tab -->
                                <div class="tab-pane fade" id="livedemo" role="tabpanel" aria-labelledby="livedemo-tab">
                                    <div class="product_tab_inner_content_wrapper">
                                        <div class="row">
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="demo_content_box">
                                                    <div class="row">
                                                        <?php
                                                        if ( have_rows( 'demo_site_information' ) ) { ?>
                                                            <div class="col-md-5">
                                                                <?php
                                                                while ( have_rows( 'demo_site_information' ) ) {
                                                                    the_row();
                                                                    ?>
                                                                    <ul>
                                                                        <li>
                                                                            <span><img src="<?php echo get_template_directory_uri() . '/assets/img/globe.png' ?>" alt="demo img"></span>
                                                                            <p><b>Live Demo URL:</b> <a href="<?php echo get_sub_field( 'demo_site_url' ); ?>"><?php echo get_sub_field( 'demo_site_url' ); ?></a></p>
                                                                        </li>
                                                                        <li>
                                                                            <span><img src="<?php echo get_template_directory_uri() . '/assets/img/profile.png' ?>" alt="user name img"></span>
                                                                            <p><b>Username:</b> <?php echo get_sub_field( 'username' ); ?></p>
                                                                        </li>
                                                                        <li>
                                                                            <span><img src="<?php echo get_template_directory_uri() . '/assets/img/lock.png'; ?>" alt="password img"></span>
                                                                            <p><b>Password:</b> <?php echo get_sub_field( 'password' ); ?></p>
                                                                        </li>
                                                                    </ul>
                                                                    <?php
                                                                }
                                                                //}
                                                                ?>
                                                            </div>
                                                            <!-- /.col-md-5 -->
                                                        <?php } ?>
                                                        
                                                        <?php if ( get_field( 'live_demo_content' ) != '' ) { ?>
                                                            <div class="col-md-7">
                                                                <div class="live_demo_content">
                                                                    <?php echo get_field( 'live_demo_content' ); ?>
                                                                </div>
                                                            </div>
                                                            <!-- /.col-md-7 -->
                                                        <?php } ?>

                                                    </div>
                                                    <!-- /.row -->
                                                </div>
                                                <!-- /.col-lg-12 -->
                                                <?php
                                                $screenshots = get_field( 'screenshots' );
                                                if ( $screenshots ) {
                                                    $count = 1;
                                                    ?>
                                                    <div class="product_screenshots owl-carousel">
                                                        <?php
                                                        foreach ( $screenshots as $screenshot ) { ?>
                                                            <div class="single_screenshot">
                                                                <a href="<?php echo $screenshot['url']; ?>" class="popup-btn" target="_blank">
                                                                    <img src="<?php echo $screenshot['url']; ?>" alt="<?php echo $screenshot['alt'] ?>">
                                                                </a>
                                                                <p class="ss_item_title"><?php echo ! empty( $screenshot['title'] ) ? $screenshot['title'] : $screenshot['name']; ?></>
                                                            </div>
                                                            <!--                                                            /.single_screenshot-->
                                                            <?php
                                                            $count ++;
                                                        } ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <!-- /.row -->

                                        </div>
                                        <!-- /.product_tab_inner_content_wrapper -->
                                        <?php
                                        if ( ! have_rows( 'demo_site_information' ) && empty( $screenshots ) ) {
                                            ?>

                                            <div class="alert alert-secondary changelog-alert"><?php _e( 'Nothing Found', 'abcd' ); ?></div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <!-- End of live demo tab -->
                                </div>
                            </div>
                            <!-- ./product_main_tab_wrapper -->
                        </div>
                    </div>
                    <!-- /.container -->
            </section>
        </article>
        <?php
    }
    wp_reset_query();
}
get_footer();