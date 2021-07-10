<?php get_header(); ?>
    <section id="page" class="container section">
        <div class="container">
            <article id="post-<?php the_ID(); ?>" <?php post_class('page'); ?>>
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
