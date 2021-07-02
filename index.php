<?php get_header();
$postspage_id = get_option( 'page_for_posts' );
?>
    <section class="inner_page_wrapper section_padding area">
        <div class="container">
            <h2 class="page_title"><?php echo get_the_title( $postspage_id ); ?></h2>
            <div class="blog_page_wrapper">
                <div class="row">
                    <div class="col-lg-8 col-sm-12">
                        <?php
                        if ( get_query_var( 'paged' ) ) {
                            $paged = get_query_var( 'paged' );
                        } elseif ( get_query_var( 'page' ) ) {
                            $paged = get_query_var( 'page' );
                        } else {
                            $paged = 1;
                        }
                        $args  = array(
                            'post_type'      => 'post',
                            'post_status'    => 'publish',
                            'posts_per_page' => get_option( 'posts_per_page' ),
                            'paged'          => $paged,
                            'orderby'        => 'date',
                            'order'          => 'DESC'
                        );
                        $posts = get_posts( $args );
                        $count = 0;
                        if ( is_array( $posts ) && count( $posts ) > 0 ) {
                        echo '<div class="row">';
                        foreach ( $posts
                        
                        as $post ) {
                        if ( $count == 0 ) {
                            echo '<div class="col-md-12">';
                        } else {
                            echo '<div class="col-md-6">';
                        }
                        ?>
                        <article id="post-<?php echo $post->ID; ?>" <?php post_class( '', $post->ID ); ?>>
                            <?php
                            if ( $count == 0 ) {
                                echo '<div class="blog_featured_post">';
                            } else {
                                echo '<div class="blog_featured_post blog_regular_post">';
                            }
                            $image_alt        = get_post_meta( get_post_thumbnail_id( $post->ID ), '_wp_attachment_image_alt', true );
                            $image_alt        = ( empty( $image_alt ) ) ? get_the_title( $post->ID ) : $image_alt;
                            $attachment_title = get_the_title( get_post_thumbnail_id( $post->ID ) );
                            if ( has_post_thumbnail( $post->ID ) ) {
                                $thumbImage = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
                            } else {
                                if ( $count == 0 ) {
                                    $thumbImage = get_template_directory_uri() . '/assets/img/featured_post.svg';
                                } else {
                                    $thumbImage = get_template_directory_uri() . '/assets/img/post_thumbnail.svg';
                                }
                            }
                            ?>
                            <div class="featured_post_img">
                                <a href="<?php echo get_the_permalink( $post->ID ); ?>">
                                    <img src="<?php echo $thumbImage; ?>" alt="<?php echo $image_alt; ?>" title="<?php echo $attachment_title; ?>">
                                </a>
                            </div>
                            <!-- /.featured_post_img -->
                            <div class="post_options">
                                <?php
                                $categories = get_the_terms( $post->ID, 'category' );
                                echo '<ul class="post_cat">';
                                if ( is_array( $categories ) && count( $categories ) > 0 ) { ?>
                                    <li>
                                        <a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>"><?php echo esc_html( $categories[0]->name ); ?></a>
                                    </li>
                                    <?php
                                } else {
                                    ?>
                                    <li><?php echo ''; ?></li>
                                    <?php
                                }
                                echo '</ul>';
                                echo '<ul class="post_time">';
                                if ( $count == 0 ) {
                                    ?>
                                    <li><img src="<?php echo get_template_directory_uri() . '/assets/img/comment.svg' ?>" alt="comments">
                                        <p><?php echo get_comments_number( $post->ID ); ?></p></li>
                                    <?php
                                }
                                ?>
                                <li>
                                    <p><a href="<?php echo get_day_link(get_post_time('Y'), get_post_time('m'), get_post_time('j'));  ?>" class="entry-date"><?php echo date( 'j F Y', strtotime( $post->post_date ) ); ?></a></p>
                                </li>
                                <?php
                                echo '</ul>';
                                ?>
                            </div>
                            <!-- /.post_options -->
                            <h2 class="blog_post_title">
                                <a href="<?php echo get_the_permalink( $post->ID ); ?>"><?php echo get_the_title( $post->ID ); ?></a>
                            </h2>
                            <?php
                            $excerpt = get_the_excerpt( $post->ID );
                            $excerpt = substr( $excerpt, 0, 150 );
                            ?>
                            <p><?php echo $excerpt . '...'; ?></p>
                            <?php
                            if ( $count != 0 ) {
                                ?>
                                <div class="blog_btn">
                                    <a href="<?php echo get_the_permalink( $post->ID ); ?>"><?php echo __( 'Read More', 'abcd' ) ?> <img src="<?php echo get_template_directory_uri() . '/assets/img/right_long_arrow.svg' ?>" alt="right long arrow"></a>
                                </div>
                                <!-- /.blog_btn -->
                                <?php
                            }
                            echo '</div></article></div>';
                            $count ++;
                            }
                            echo '</div>';
                            }
                            wp_reset_postdata();
                            global $wp_query;
                            $total_pages = $wp_query->max_num_pages;
                            if ( $total_pages > 1 ) {
                                $current_page = max( 1, get_query_var( 'paged' ) );
                                echo '<div class="blog-pagination text-center"><ul class="pagination"> <li>';
                                echo paginate_links(
                                    array(
                                        'base'      => get_pagenum_link( 1 ) . '%_%',
                                        'format'    => 'page/%#%/',
                                        'current'   => $current_page,
                                        'total'     => $total_pages,
                                        'prev_text' => '« Prev',
                                        'next_text' => 'Next »'
                                    )
                                );
                                echo '</li> </ul></div>';
                            }
                            ?>
                    </div>
                    <!-- /.col-lg-8 -->
                    <div class="col-lg-4 col-sm-12">
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
