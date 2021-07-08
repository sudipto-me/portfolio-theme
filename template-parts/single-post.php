<?php
/**
 * Template part for displaying posts
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="row">
        <div class="col-md-12">
			<?php ?>
            <a class="article__back-link" href="<?php echo esc_url( isset( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : get_site_url() ) ?>"><i class="fa fa-long-arrow-left" aria-hidden="true"></i><?php echo esc_html__( 'Back', 'portfolio' ) ?></a>
            <p class="article__title"><?php echo esc_html( get_the_title() ); ?></p>
            <p class="article_date"><?php echo get_the_date( "F j, Y", get_the_ID() ); ?></p>
            <div class="article_img">
				<?php
				$image_id  = get_post_thumbnail_id();
				$image_alt = ! empty( get_post_meta( $image_id, '_wp_attachment_image_alt', true ) ) ? get_post_meta( $image_id, '_wp_attachment_image_alt', true ) : get_the_title( get_the_ID() );
				?>
                <img src="<?php echo esc_url( ! empty( get_the_post_thumbnail_url( get_the_ID(), 'full' ) ) ? get_the_post_thumbnail_url( get_the_ID(), 'full' ) : get_template_directory_uri() . '/assets/img/blog-header-background.jpg' ); ?>" alt="<?php echo $image_alt; ?>" class="img-fluid">
            </div>
            <div class="article_content">
				<?php the_content(); ?>
            </div>
            <p class="article__share"><?php echo esc_html__( "Share this post:", "portfolio" );
				$facebook_share_url = 'https://www.facebook.com/sharer.php?u=' . esc_url( get_the_permalink( get_the_ID() ) );
				$linkedin_share_url = 'https://www.linkedin.com/shareArticle?mini=true&url=' . esc_url( get_the_permalink( get_the_ID() ) ) . '&title=' . get_the_title( get_the_ID() );
				?>

                <a href="<?php echo esc_url( $facebook_share_url ); ?>" rel="nofollow" target="_blank"><i class="fa fa-facebook-square"></i></a>
                <a href="<?php echo esc_url( $linkedin_share_url ); ?>" rel="nofollow" target="_blank"><i class="fa fa-linkedin-square"></i></a>
            </p>
        </div>
    </div>
    <!-- /.row -->
</article>
<section id="posts" class="container section">
    <div class="row">
        <div class="col-md-12">
            <h2 id="other_posts" class="section__title"><?php echo esc_html__( 'Other Posts_', 'portfolio' ); ?></h2>
        </div>
        <!-- /.col-md-12 -->
    </div>
    <!-- /.row -->
	<?php
	$other_posts = get_posts(
		array(
			'post_type'      => 'post',
			'posts_per_page' => 4,
			'post__not_in'   => array( get_the_ID() ),
			'orderby'        => 'menu_order',
			'order'          => 'asc'
		)
	);
	if ( is_array( $other_posts ) && ! empty( $other_posts ) ) {
		echo '<div class="row posts">';
		foreach ( $other_posts as $post ) {
			?>
            <div class="col-md-5 mr-auto">
                <div class="posts__item">
                    <a href="<?php echo esc_url( get_the_permalink( $post ) ); ?>">
                        <h3 class="posts__title"><?php echo get_the_title( $post ); ?></h3>
                    </a>
                    <p class="posts__description"><?php echo get_the_excerpt( $post ); ?></p>
                </div>
            </div>
			<?php
		}
		echo '</div>';
	}
	?>
</section>
