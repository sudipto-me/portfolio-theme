<?php get_header(); ?>
    <section class="inner_page_wrapper section_padding area">
        <div class="container">
             <?php if ( edd_is_checkout() ) {
                $items = edd_get_cart_contents();
                if ( empty( $items ) ) {
                    ?>
                    <h1 class="page_title"><?php echo __( 'Cart', 'abcd' ); ?></h1>
                    <?php
                }
            } else { ?>
                <h1 class="page_title"><?php echo get_the_title(); ?></h1>
                <!-- /.page_title -->
            <?php } ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php
                if ( have_posts() ) :
                    while ( have_posts() ) :
                        the_post();
                        the_content();
                    endwhile;
                endif;
                ?>
            </article>
        </div>
        <!-- /.container -->
    </section>
<?php get_footer();
