<?php get_header(); ?>
    <section class="title-header">
        <h2 class="media-heading p-v-sm text-center"><?php echo __( 'Search results for:', 'abcd' ); ?> <span><?php echo get_search_query(); ?></span></h2>
    </section>

    <section class="inner_page_wrapper section_padding area">
        <?php
        if ( have_posts() && strlen( trim( get_search_query() ) ) != 0 ) { ?>
        <article class="container">
            <div class="plugins_content area">
                <h4><img src="<?php echo get_template_directory_uri() . '/assets/img/search_result_plugin_icon.svg' ?>" alt="plugins"><?php echo __( ' Plugins ', 'abcd' ) ?></h4>
                <?php
                while ( have_posts() ) {
                    the_post();
                    if ( get_post_type() == 'download' ) {
                        ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <div class="plugin-posts area">
                                <div class="single_plugin-post area">
                                    <a href="<?php the_permalink(); ?>" class="search-item"><?php the_title(); ?></a>
                                </div>
                                <!-- /.single_plugin-post -->
                            </div>
                            <!-- /.plugin-posts -->
                        </article>
                        <?php
                    }
                }
                ?>
            </div>
            <div class="blog_posts_content area">
                <h4><img src="<?php echo get_template_directory_uri() . '/assets/img/search_result_blogpost_icon.svg' ?>" alt="blog posts"><?php echo __( ' Blog posts ', 'abcd' ) ?></h4>
                <?php
                while ( have_posts() ) {
                    the_post();
                    if ( get_post_type() == 'post' ) {
                        ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <div class="plugin-posts area">
                                <div class="single_plugin-post area">
                                    <a href="<?php the_permalink(); ?>" class="search-item"><?php the_title(); ?></a>
                                </div>
                                <!-- /.single_plugin-post -->
                            </div>
                            <!-- /.plugin-posts -->
                        </article>
                        <?php
                    }
                } ?>
            </div>
            <div class="documentations_content area">
                <h4><img src="<?php echo get_template_directory_uri() . '/assets/img/search_result_documentations_icons.svg' ?>" alt="documentations"><?php echo __( ' Documentation ', 'abcd' ) ?></h4>
                <?php
                while ( have_posts() ) {
                    the_post();
                    if ( get_post_type() == 'theme_documentation' ) {
                        ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <div class="plugin-posts area">
                                <div class="single_plugin-post area">
                                    <a href="<?php the_permalink(); ?>" class="search-item"><?php the_title(); ?>
                                    </a>
                                </div>
                                <!-- /.single_plugin-post -->
                            </div>
                            <!-- /.plugin-posts -->
                        </article>
                        <?php
                    }
                } ?>
            </div>
            <?php
            wp_reset_postdata();
            ?>
            <div class="search-pagination area">
                <?php
                the_posts_pagination( array(
                    'prev_text'          => __( ' << Previous ', 'abcd' ),
                    'next_text'          => __( 'Next >>', 'abcd' ),
                    'before_page_number' => '',
                    'screen_reader_text' => ' '
                ) );
                ?>
            </div>
            <?php
            } else { ?>
                <div id="post-0" class="post no-results not-found">
                    <div class="container">
                        <h3 class="entry-title"><?php _e( 'Nothing Found', 'abcd' ); ?></h3>
                        <div class="entry-content">
                            <p>
                                <?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'abcd' ); ?>
                            </p>
                        </div><!-- .entry-content -->
                        <?php get_search_form(); ?>
                    </div>
                </div><!-- #post-0 -->
            <?php } ?>
        </article>
        <!-- End of container -->
    </section>
    <!-- End of blog section -->
<?php get_footer();
