<?php get_header(); ?>
    <section class="inner_page_wrapper section_padding area">
        <?php
        if ( have_posts() ) : ?>
        <div class="container">
            <?php the_archive_title( '<h2 class="page_title">', '</h2>' ); ?>
            <div class="blog_page_wrapper">
                <div class="row">
                    <div class="col-lg-8 col-md-12">
                        <div class="row">
                            <?php
                            while ( have_posts() ) : the_post();
                                $image_alt        = get_post_meta( get_post_thumbnail_id( $post->ID ), '_wp_attachment_image_alt', true );
                                $image_alt        = ( empty( $image_alt ) ) ? get_the_title( $post->ID ) : $image_alt;
                                $attachment_title = get_the_title( get_post_thumbnail_id( $post->ID ) );
                                ?>
                                <div class="col-md-6">
                                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                        <div class="blog_featured_post blog_regular_post">
                                            <?php
                                            if ( has_post_thumbnail() ) {
                                                $thumbImage = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
                                            } else {
                                                $thumbImage = get_template_directory_uri() . '/assets/img/post_thumbnail.svg';
                                            }
                                            ?>
                                            <div class="featured_post_img">
                                                <a href="<?php the_permalink(); ?>">
                                                    <img src="<?php echo $thumbImage; ?>" alt="<?php echo $image_alt; ?>" title="<?php echo $attachment_title; ?>">
                                                </a>
                                            </div>
                                            <!-- /.featured_post_img -->
                                            <div class="post_options">
                                                <?php
                                                $categories = get_the_terms( $post->ID, 'category' );
                                                echo '<ul class="post_cat">';
                                                if ( is_array( $categories ) && count( $categories ) > 0 ) {
                                                    //foreach ( $categories as $single_cat ) {
                                                    ?>
                                                    <li>
                                                        <a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>"><?php echo esc_html( $categories[0]->name ); ?></a>
                                                    </li>
                                                    <?php
                                                    // }
                                                    
                                                } else {
                                                    ?>
                                                    <li><?php echo __( 'No Category Found', 'abcd' ); ?></li>
                                                    <?php
                                                }
                                                echo '</ul>';
                                                echo '<ul class="post_time">';
                                                ?>
                                                <li>
                                                    <p><?php echo date( 'j F Y', strtotime( $post->post_date ) ); ?></p>
                                                </li>
                                                <?php
                                                echo '</ul>';
                                                ?>
                                            </div>
                                            <!-- /.post_options -->
                                            <h2 class="blog_post_title">
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </h2>
                                            <?php
                                            $excerpt = get_the_excerpt( $post->ID );
                                            $excerpt = substr( $excerpt, 0, 150 );
                                            ?>
                                            <!--                                            <p>--><?php //echo wp_trim_words( $post->post_content, 25, '...' ); ?><!--</p>-->
                                            <p><?php echo $excerpt . '...'; ?></p>
                                            <div class="blog_btn">
                                                <a href="<?php the_permalink(); ?>"><?php echo __( 'Read More', 'abcd' ) ?> <img src="<?php echo get_template_directory_uri() . '/assets/img/right_long_arrow.svg' ?>" alt="right long arrow"></a>
                                            </div>
                                            <!-- /.blog_btn -->

                                        </div>
                                        <!-- /.blog_regular_post -->
                                    </article>
                                </div>
                            <?php endwhile;
                            wp_reset_postdata();
                            endif;
                            ?>
                        </div>
                        <?php
                        echo '<div class="blog-pagination text-center">';
                        the_posts_pagination( array(
                            'prev_text'          => __( ' << Previous ', 'abcd' ),
                            'next_text'          => __( 'Next >>', 'abcd' ),
                            'before_page_number' => '',
                            'screen_reader_text' => ' '
                        ) );
                        echo '</div>';
                        ?>
                    </div>
                <!-- End of col -->
                <div class="col-lg-4 col-md-12">
                    <div class="blog_sidebar_wrapper">
                        <?php
                        if ( is_active_sidebar( 'blog-sidebar' ) ) {
                            dynamic_sidebar( 'blog-sidebar' );
                        }
                        ?>
                    </div>
                </div>
                <!-- End of col -->
            </div>
            <!-- End of row -->
        </div>
        </div>
        <!-- End of container -->
    </section>
<?php get_footer();
