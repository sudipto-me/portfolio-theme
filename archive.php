<?php
/**
 * This template will load posts of the category and tags
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

get_header(); ?>
    <section id="archive" class="container section">
        <?php
        if ( have_posts() ) : ?>
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <?php
                            while ( have_posts() ) : the_post();
                                ?>
                                <article id=post-<?php the_ID(); ?>" <?php post_class( 'loop-entry' ); ?>>
                                    <div class="bg-white single-blog-item">
                                        <div class="single-blog-item-img">
				                            <?php
				                            $post_thumbnail   = ! empty( get_the_post_thumbnail_url( $post->ID, 'full' ) ) ? get_the_post_thumbnail_url( $post->ID, 'full' ) : get_template_directory_uri() . '/assets/img/post.png';
				                            $image_alt        = get_post_meta( get_post_thumbnail_id( $post->ID ), '_wp_attachment_image_alt', true );
				                            $image_alt        = ( empty( $image_alt ) ) ? get_the_title( $post->ID ) : $image_alt;
				                            $attachment_title = get_the_title( get_post_thumbnail_id( $post->ID ) );
				                            ?>
                                            <a href="<?php echo esc_url( get_the_permalink( $post ) ); ?>"><img src="<?php echo esc_url( $post_thumbnail ); ?>" alt="<?php echo $image_alt; ?>" class="img-fluid featured_post_img"></a>
                                        </div>
                                        <div class="single-blog-item-content">
				                            <?php
				                            $post_categories = get_terms( array( 'taxonomy' => 'category', 'hide_empty' => false ) );
				                            ?>
                                            <p class="single-blog-item-cat"><a href="<?php echo get_term_link( $post_categories[0] ); ?>"><?php echo $post_categories[0]->name; ?></a></p>
                                            <a href="<?php echo esc_url( get_the_permalink( $post ) ); ?>"><h2 class="single-blog-item-title"><?php echo get_the_title( $post ); ?></h2></a>
                                            <p class="single-blog-item-date"><?php echo get_the_date( "F j, Y", $post->ID ); ?></p>
                                            <p class="single-blog-item-desc"><?php echo get_the_excerpt( $post ); ?></p>
                                            <a href="<?php echo esc_url( get_the_permalink( $post ) ); ?>" class="site-btn read-more"><?php echo esc_html__( 'Read More', 'portfolio' ); ?></a>
                                        </div>
                                    </div>
                                </article>
                            <?php endwhile;
                            wp_reset_postdata();
                            endif;
                            ?>
                        </div>
                        <?php
                        echo '<div class="blog-pagination text-center">';
                        the_posts_pagination( array(
                            'prev_text'          => __( ' << Previous ', 'portfolio' ),
                            'next_text'          => __( 'Next >>', 'portfolio' ),
                            'before_page_number' => '',
                            'screen_reader_text' => ' '
                        ) );
                        echo '</div>';
                        ?>
                    </div>
                <!-- End of col -->
                <div class="col-md-4">
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
    </section>
<?php get_footer();
