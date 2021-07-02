<?php
get_header();
?>
    <section class="inner_page_wrapper section_padding area">
        <div class="container">
            <h1 class="page_title"><?php echo __( 'Plugins', 'abcd' ); ?></h1>
            <?php if ( have_posts() ) : ?>
                <div class="plugins_wrapper">
                    <div class="row">
                        <?php while ( have_posts() ):
                            the_post(); ?>
                            <div class="col-md-4">
                                <div class="plugin_box">
                                    <div class="plugin_img">
                                        <a href="<?php echo get_the_permalink( $post->ID ); ?>">
                                        <?php
                                        echo get_the_post_thumbnail( $post->ID ) ? get_the_post_thumbnail( $post->ID, array( 199, 203 ) ) : '<img src="' . get_template_directory_uri() . '/assets/img/product_hero_img.jpg' . '" class="' . __( 'img_thumbnail' ) . '">';
                                        ?>
                                        </a>
                                    </div>
                                    <!-- /.plugin_img -->
                                    <h3 class="plugin_name"><a href="<?php echo get_the_permalink( $post->ID ); ?>"><?php echo get_the_title( $post->ID ); ?></a></h3>
                                    <p class="subtitle"><?php echo get_field( 'product_subtitle', $post->ID ); ?></p>
                                    <?php
                                    $total_reviews = edd_reviews()->average_rating( false, $post->ID );
                                    ?>
                                    <div class="product_ratings">
                                        <ul>
                                            <li>
                                                <div class="starts-outer">
                                                    <div class="starts-inner" style="width: <?php echo $total_reviews * 20 ?>%"></div>
                                                </div>
                                            </li>
                                            <li>(<?php echo edd_reviews()->count_reviews() . ' reviews'; ?>)</li>
                                        </ul>
                                        <p class="product_price"><span class="edd-currency-code"><?php echo edd_currency_symbol();?></span><?php echo edd_format_amount( edd_get_download_price( $post->ID ) ); ?></p>
                                    </div>
                                    <!-- /.product_ratings -->
                                    <a href="<?php echo get_the_permalink( $post->ID ); ?>" class="site_cta"><?php echo __( 'Plugin Details', 'abcd' ); ?></a>
                                </div>
                                <!-- /.plugins_box -->
                            </div>
                            <!-- /.col-md-6 -->
                        <?php endwhile; ?>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.plugins_wrapper -->
                <div class="pagination">
                    <?php wp_reset_postdata();
                    the_posts_pagination( array(
                        'prev_text'          => __( ' << Previous ', 'abcd' ),
                        'next_text'          => __( 'Next >>', 'abcd' ),
                        'before_page_number' => '',
                        'screen_reader_text' => ' '
                    ) );
                    ?>
                </div>
                <!-- /.pagination -->
            <?php endif; ?>
        </div>
        <!-- /.container -->
    </section>

<?php get_footer();
