<?php get_header(); ?>
    <section class="inner_page_wrapper section_padding area">
        <div class="container">            <?php if ( have_posts() ) {
                while ( have_posts() ) {
                    the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <div class="docs_wrapper"><h2 class="docs_title"><?php the_title(); ?></h2>
                            <?php
                            $facebook_share_url  = 'https://www.facebook.com/sharer.php?u=' . esc_url( get_the_permalink( $post->ID ) );
                            $twitter_share_url   = 'https://twitter.com/intent/tweet?url=' . esc_url( get_the_permalink( $post->ID ) ) . '&text=' . esc_attr( get_the_title( $post->ID ) );
                            $linkedin_share_url  = 'https://www.linkedin.com/shareArticle?mini=true&url=' . esc_url( get_the_permalink( $post->ID ) ) . '&title=' . get_the_title( $post->ID );
                            $pinterest_share_url = 'https://www.pinterest.com/pin/create/button/?url=' . esc_url( get_the_permalink( $post->ID ) ) . '&media=' . wp_get_attachment_url( get_post_thumbnail_id() ) . '&description=' . get_the_title( $post->ID );
                            ?>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="social_share_options">
                                        <ul>
                                            <li><a href="<?php echo $facebook_share_url; ?>" class="social_share_btn" rel="nofollow" target="_blank"><img src="<?php echo get_template_directory_uri() . '/assets/img/fb.svg'; ?>"> <?php echo __( ' Share ', 'abcd' ); ?></a></li>
                                            <li><a href="<?php echo $linkedin_share_url; ?>" class="social_share_btn" rel="nofollow" target="_blank"><img src="<?php echo get_template_directory_uri() . '/assets/img/linkedin.svg'; ?>"></a></li>
                                            <li><a href="<?php echo $twitter_share_url; ?>" class="social_share_btn" rel="nofollow" target="_blank"><img src="<?php echo get_template_directory_uri() . '/assets/img/twitter.svg'; ?>"></a></li>
                                            <li><a href="<?php echo $pinterest_share_url; ?>" data-pin-shape="round" class="social_share_btn" rel="nofollow" target="_blank"><img src="<?php echo get_template_directory_uri() . '/assets/img/pinterest.svg'; ?>"></a>
                                            </li>
                                            <li><a href="#" class="social_share_btn print_btn" rel="nofollow"><i class="fa fa-print" aria-hidden="true"></i></a></li>
                                        </ul>
                                    </div>
                                    <!-- /.social_share_options -->
                                </div>
                                <!-- /.col-lg-6 -->
                                <div class="col-lg-6 col-md-6 col-sm-12 clearfix">
                                    <?php
                                    $plugin_ids = get_post_meta( $post->ID, 'documentaion-download', true );
                                    $plugin_names = array();
                                    if ( is_array( $plugin_ids ) && count( $plugin_ids ) ) {
                                        foreach ( $plugin_ids as $plugin_id ) {
                                            ?>
                                            <a href="<?php echo get_the_permalink( $plugin_id ); ?>" class="plugin_names"><?php echo get_the_title( $plugin_id ); ?></a>
                                            <?php
                                            $plugin_names[] = get_the_title( $plugin_id );
                                        }
                                    }
                                    ?>
                                </div>
                                <!-- /.col-lg-6 -->
                            </div>
                            <!-- /.row -->

                            <div class="docs_content">
                                <?php the_content(); ?>
                            </div>
                            <!-- /.docs_content -->
                            <div class="docs_content_bottom">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <p class="documentation_help"><i class="fa fa-envelope-o" aria-hidden="true"></i> <?php echo __( 'Still Stuck? ', 'abcd' ); ?><a href="<?php echo home_url( '/support' ); ?>"><?php echo __( 'How can we help?', 'abcd' ); ?></a></p>
                                    </div>
                                    <!-- /.col-lg-6 -->
                                    <div class="col-lg-6 col-md-6 col-sm-12 clearfix">
                                        <p class="updated_time"><?php echo __( 'Updated on ', 'abcd' ) . get_the_modified_date( 'F j, Y' ); ?></p>
                                    </div>
                                    <!-- /.col-lg-6 -->
                                </div>
                            </div>
                            <!-- /.docs_content_bottom -->
                            <div class="docs_navigation">
                                <?php
                                $documentations         = get_posts(
                                    array(
                                        'post_type'      => 'theme_documentation',
                                        'posts_per_page' => - 1,
                                        'post_status'    => 'publish',
                                        'order'          => 'asc',
                                        'orderby'        => 'ID',
                                    )
                                );
                                $related_documentations = array();
                                if ( is_array( $documentations ) && count( $documentations ) ) {
                                    foreach ( $documentations as $single ) {
                                        $single_meta = get_post_meta( $single->ID, 'documentaion-download', true );
                                        for ( $i = 0; $i < count( $plugin_ids ); $i ++ ) {
                                            if ( is_array( $single_meta ) && count( $single_meta ) ) {
                                                if ( in_array( $plugin_ids[ $i ], $single_meta ) ) {
                                                    $related_documentations[] = $single->ID;
                                                }
                                            }
                                        }
                                    }
                                }
                                $related_documentations = array_values( array_unique( $related_documentations ) );
                                $current_documentation_index = array_keys( $related_documentations, get_the_ID() );
                                ?>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="previous_section">
                                            <?php $prev_post_index = $current_documentation_index[0] - 1;
                                            $prev_post_id          = '';
                                            if ( $prev_post_index >= 0 ) {
                                                if ( isset( $related_documentations[ $prev_post_index ] ) ) {
                                                    $prev_post_id = $related_documentations[ $prev_post_index ];
                                                }
                                            }
                                            ?>
                                            <?php if ( ! empty( $prev_post_id ) ) { ?>
                                                <a href="<?php echo get_the_permalink( $prev_post_id ); ?>" class="adjacent_post_url"><i class="fa fa-long-arrow-left" aria-hidden="true"></i><?php echo ' ' . get_the_title( $prev_post_id ); ?></a>
                                            <?php } ?>
                                        </div>
                                        <!-- /.previous_section -->
                                    </div>
                                    <!-- /.col-lg-6 -->
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="next_section">
                                            <?php $next_post_index = $current_documentation_index[0] + 1;
                                            $next_post_id          = '';
                                            if ( $next_post_index >= 0 ) {
                                                if ( isset( $related_documentations[ $next_post_index ] ) ) {
                                                    $next_post_id = $related_documentations[ $next_post_index ];
                                                }
                                            }
                                            //var_dump( $next_post_id );
                                            ?>
                                            <?php //$next_post = get_adjacent_post( false, '', false ); ?>
                                            <?php if ( ! empty( $next_post_id ) ) { ?>
                                                <a href="<?php echo get_the_permalink( $next_post_id ); ?>" class="adjacent_post_url"><?php echo get_the_title( $next_post_id ) . ' '; ?><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                                            <?php } ?>
                                        </div>
                                        <!-- /.next_section -->
                                    </div>
                                    <!-- /.col-lg-6 -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.docs_navigation -->
                        </div>
                        <!-- /.docs_wrapper -->
                    </article>
                <?php }
            } ?>
        </div>
        <!-- /.container -->
    </section>
<?php get_footer();