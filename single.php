<?php get_header(); ?>
    <section class="inner_page_wrapper section_padding area">
        <div class="container">
            <div class="blog_page_wrapper">
                <div class="row">
                    <div class="col-lg-8 col-md-12">
                        <?php
                        if ( have_posts() ) {
                            while ( have_posts() ) {
                                the_post();
                                ?>
                                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                    <div class="blog_featured_post">
                                        <div class="featured_post_img">
                                            <?php
                                            if ( has_post_thumbnail() ) {
                                                $thumbImage = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
                                            } else {
                                                $thumbImage = get_template_directory_uri() . '/assets/img/featured_post.svg';
                                            }
                                            $image_alt        = get_post_meta( get_post_thumbnail_id( $post->ID ), '_wp_attachment_image_alt', true );
                                            $image_alt        = ( empty( $image_alt ) ) ? get_the_title( $post->ID ) : $image_alt;
                                            $attachment_title = get_the_title( get_post_thumbnail_id( $post->ID ) );
                                            $image_alt        = get_post_meta( get_post_thumbnail_id( $post->ID ), '_wp_attachment_image_alt', true );
                                            $image_alt        = ( empty( $image_alt ) ) ? get_the_title( $post->ID ) : $image_alt;
                                            $attachment_title = get_the_title( get_post_thumbnail_id( $post->ID ) ); ?>
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
                                                $count = 1;
                                                foreach ( $categories as $single_cat ) { ?>
                                                    <li>
                                                        <a href="<?php echo esc_url( get_category_link( $single_cat->term_id ) ); ?>"><?php echo esc_html( $single_cat->name ); ?></a><?php echo ( $count !== count( $categories ) ) ? ', ' : '' ?>
                                                    </li>
                                                    <?php
                                                    $count ++;
                                                }
                                                
                                            } else {
                                                echo "<li>" . "" . "</li>";
                                            }
                                            echo '</ul>';
                                            echo '<ul class="post_time">';
                                            ?>
                                            <li><img src="<?php echo get_template_directory_uri() . '/assets/img/comment.svg' ?>" alt="comments">
                                                <p><?php echo get_comments_number( $post->ID ); ?></p></li>
                                            <li>
                                                <img src="<?php echo get_template_directory_uri() . '/assets/img/time.svg' ?>" alt="time">
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
                                        $facebook_share_url  = 'https://www.facebook.com/sharer.php?u=' . esc_url( get_the_permalink( $post->ID ) );
                                        $twitter_share_url   = 'https://twitter.com/intent/tweet?url=' . esc_url( get_the_permalink( $post->ID ) ) . '&text=' . esc_attr( get_the_title( $post->ID ) );
                                        $linkedin_share_url  = 'https://www.linkedin.com/shareArticle?mini=true&url=' . esc_url( get_the_permalink( $post->ID ) ) . '&title=' . get_the_title( $post->ID );
                                        $pinterest_share_url = 'https://www.pinterest.com/pin/create/button/?url=' . esc_url( get_the_permalink( $post->ID ) ) . '&media=' . wp_get_attachment_url( get_post_thumbnail_id() ) . '&description=' . get_the_title( $post->ID );
                                        ?>
                                        <div class="social_share_options">
                                            <ul>
                                                <li><a href="<?php echo $facebook_share_url; ?>" class="social_share_btn" rel="nofollow" target="_blank"><img src="<?php echo get_template_directory_uri() . '/assets/img/fb.svg'; ?>"> <?php echo __( ' Share ', 'abcd' ); ?></a></li>
                                                <li><a href="<?php echo $linkedin_share_url; ?>" class="social_share_btn" rel="nofollow" target="_blank"><img src="<?php echo get_template_directory_uri() . '/assets/img/linkedin.svg'; ?>"></a></li>
                                                <li><a href="<?php echo $twitter_share_url; ?>" class="social_share_btn" rel="nofollow" target="_blank"><img src="<?php echo get_template_directory_uri() . '/assets/img/twitter.svg'; ?>"></a></li>
                                                <li><a href="<?php echo $pinterest_share_url; ?>" data-pin-shape="round" class="social_share_btn" rel="nofollow" target="_blank"><img src="<?php echo get_template_directory_uri() . '/assets/img/pinterest.svg'; ?>">
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- /.social_share_options -->
                                        <div class="blog_post_content">
                                            <?php the_content(); ?>
                                        </div>
                                        <!-- /.blog_post_content -->
                                        <div class="social_share_options blog_social_bottom">
                                            <ul>
                                                <li><a href="<?php echo $facebook_share_url; ?>" class="social_share_btn" rel="nofollow" target="_blank"><img src="<?php echo get_template_directory_uri() . '/assets/img/fb.svg'; ?>"> <?php echo __( ' Share ', 'abcd' ); ?></a></li>
                                                <li><a href="<?php echo $linkedin_share_url; ?>" class="social_share_btn" rel="nofollow" target="_blank"><img src="<?php echo get_template_directory_uri() . '/assets/img/linkedin.svg'; ?>"></a></li>
                                                <li><a href="<?php echo $twitter_share_url; ?>" class="social_share_btn" rel="nofollow" target="_blank"><img src="<?php echo get_template_directory_uri() . '/assets/img/twitter.svg'; ?>"></a></li>
                                                <li><a href="<?php echo $pinterest_share_url; ?>" data-pin-shape="round" class="social_share_btn" rel="nofollow" target="_blank"><img src="<?php echo get_template_directory_uri() . '/assets/img/twitter.svg'; ?>">
                                                    </a>
                                                </li>
                                            </ul>

                                        </div>
                                        <!-- /.social_share_options -->
                                    </div>
                                    <!-- /.blog_featured_post -->
                                </article>
                            <?php }
                            wp_reset_query();
                        } ?>
                        <div class="cla-comments">
                            <?php
                            if ( comments_open() || get_comments_number() ) {
                                comments_template();
                            }
                            ?>
                        </div>
                    </div>
                    <!-- /.col-lg-8 -->
                    <div class="col-lg-4 col-md-12">
                        <div class="blog_sidebar_wrapper">
                            <?php
                            if ( is_active_sidebar( 'blog-sidebar' ) ) {
                                dynamic_sidebar( 'blog-sidebar' );
                            }
                            ?>
                        </div>
                        <!-- /.blog_sidebar_wrapper -->
                    </div>
                    <!-- /.col-lg-4 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.blog_page_wrapper -->
        </div>
        <!-- /.container -->
    </section>
<?php get_footer();
