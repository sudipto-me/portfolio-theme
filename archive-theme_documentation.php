<?php
get_header();
?>
    <section class="inner_page_wrapper section_padding area">
        <div class="container">
            <h1 class="page_title"><?php echo __( 'Documentations', 'abcd' ); ?></h1>
            <div class="search_section">
                <form action="" class="documentation_search_form" method="get">
                    <input type="text" class="cla_input-filed" placeholder="<?php _e( 'Plugin Name', 'abcd' ); ?>" name="s">
                    <button type="submit"><img src="<?php echo get_template_directory_uri() . '/assets/img/search_icon.svg' ?>" alt="search icon"></button>
                </form>
            </div>
            <!-- /.search_section -->
            <div class="plugin_section">
                <?php
                if ( get_query_var( 'paged' ) ) {
                    $paged = get_query_var( 'paged' );
                } elseif ( get_query_var( 'page' ) ) {
                    $paged = get_query_var( 'page' );
                } else {
                    $paged = 1;
                }
                $documentations = get_posts(
                    array(
                        'post_type'      => 'theme_documentation',
                        'posts_per_page' => - 1,
                        'post_status'    => 'publish',
                    )
                );
                $args           = array(
                    'post_type'      => 'download',
                    'post_status'    => 'publish',
                    'posts_per_page' => 5,
                    'paged'          => $paged,
                    'orderby'        => 'title',
                    'order'          => 'ASC'
                );
                $plugin_query   = new WP_Query( $args );
                if ( $plugin_query->have_posts() ):
                    while ( $plugin_query->have_posts() ):
                        $plugin_query->the_post();
                        $plugin_id = get_the_ID();
                        $icons     = get_field( 'icons', $plugin_id );
                        $icon_url  = $icons['url'];
                        ?>
                        <div class="single_plugin_docs">
                            <h4><img src="<?php echo $icon_url ? $icon_url : get_template_directory_uri() . '/assets/img/plugin.png' ?>" alt="plugin thumbnail" class="plugin_icon"><a href="<?php echo get_the_permalink( $plugin_id ) ?>"><?php echo get_the_title( $plugin_id ); ?></a></h4>
                            <div class="docs">
                                <?php
                                $docs_id = array();
                                foreach ( $documentations as $single ) {
                                    $related_downloads = get_post_meta( $single->ID, 'documentaion-download', true );
                                    $related_downloads = array_values( $related_downloads );
                                    if ( is_array( $related_downloads ) && count( $related_downloads ) ) {
                                        if ( in_array( $plugin_id, $related_downloads ) ) {
                                            $docs_id[] = $single->ID;
                                        }
                                    }
                                }
                                sort( $docs_id );
                                if ( is_array( $docs_id ) && count( $docs_id ) ) {
                                    foreach ( $docs_id as $ids ) {
                                        ?>
                                        <div class="single_docs">
                                            <a href="<?php echo get_the_permalink( $ids ); ?>" class="docs-item"><?php echo get_the_title( $ids ); ?></a>
                                        </div>
                                        
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <div class="alert alert-secondary docs-alert"><?php _e( 'Nothing found', 'abcd' ); ?></div>
                                <?php } ?>
                            </div>
                            <!-- /.docs -->
                        </div>
                        <!-- /.single_plugin_section -->
                    <?php
                    endwhile;
                endif;
                wp_reset_postdata();
                ?>
            </div>
            <?php
            $plugin_query = new WP_Query( $args );
            $total_pages  = $plugin_query->max_num_pages;
            if ( $total_pages > 1 ) {
                $current_page = max( 1, get_query_var( 'paged' ) );
                echo '<div class="docs-pagination text-center"><ul class="pagination"> <li>';
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
            wp_reset_postdata();
            ?>
            <div class="plugin_search">
                <div class="load_more">
                    <img src="<?php echo get_template_directory_uri() . '/assets/img/loading.gif' ?>" alt="loading" class="loading hide">
                </div>
                <div class="search_result">
        
                </div>
                <!-- /.search_result -->
            </div>
            <!-- /.plugin_search -->
        </div>
    </section>
<?php get_footer();