<?php
/**
 * This template will load all projects
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

get_header(); ?>
    <section id="archive" class="container section">
		<?php
		if ( have_posts() ) : ?>
        <div class="row">
            <div class="col-md-12">
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
									$project_categories = get_terms( array( 'taxonomy' => 'project_cat', 'hide_empty' => false ) );
									?>
                                    <p class="single-blog-item-cat">
										<?php if ( ! empty( $project_categories ) && count( $project_categories ) ):
											$i = 0;
											$len = count( $project_categories );
											?>
											<?php foreach ( $project_categories as $category ): ?>
                                            <a href="<?php echo get_term_link( $category ); ?>"><?php echo $category->name; ?><?php echo ( $i != $len - 1 ) ? ',' : '';?></a>
										<?php endforeach;endif ?>
                                    </p>
                                    <a href="<?php echo esc_url( get_the_permalink( $post ) ); ?>"><h2 class="single-blog-item-title"><?php echo get_the_title( $post ); ?></h2></a>
                                    <p class="single-blog-item-desc"><?php echo get_the_excerpt( $post ); ?></p>
                                    <div class="single-blog-item-used_stacks">
                                        <a href="<?php echo esc_url( get_field( 'project_live_link', get_the_ID() ) ) ?>" class="article_live__link" target="_blank"><?php echo esc_url( get_field( 'project_live_link', get_the_ID() ) ) ?></a>
                                        <p class="project-card__stack"><?php echo esc_html__( 'Used stack:', 'portfolio' ) ?></p>
	                                    <?php
	                                    $used_stacks = get_field( 'used_stacks', get_the_ID() ); ?>
	                                    <?php if ( ! empty( $used_stacks ) ): ?>
                                            <ul class="tags">
			                                    <?php foreach ( $used_stacks as $stack ): ?>
                                                    <li><?php echo $stack['stack_name']; ?></li>
			                                    <?php endforeach; ?>
                                            </ul>
	                                    <?php endif; ?>
                                    </div>

                                    <a href="<?php echo esc_url( get_the_permalink( $post ) ); ?>" class="site-btn read-more"><?php echo esc_html__( 'View More', 'portfolio' ); ?></a>
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
					'prev_text'          => __( ' << Previous ', 'abcd' ),
					'next_text'          => __( 'Next >>', 'abcd' ),
					'before_page_number' => '',
					'screen_reader_text' => ' '
				) );
				echo '</div>';
				?>
            </div>
            <!-- End of col -->
        </div>
        <!-- End of row -->
    </section>
<?php get_footer();
