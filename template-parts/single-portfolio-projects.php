<?php
/**
 * Template part for displaying projects
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="row">
        <div class="col-md-12">
            <a class="article__back-link" href="<?php echo esc_url( isset( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : get_site_url() ) ?>"><i class="fa fa-long-arrow-left" aria-hidden="true"></i><?php echo esc_html__( 'Back', 'portfolio' ) ?></a>
            <p class="article__title"><?php echo esc_html( get_the_title() ); ?></p>
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
            <div class="article_used_stacks">
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
        </div>
    </div>
</article>
