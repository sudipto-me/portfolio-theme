<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package pluginever
 */

get_header();
?>
<main id="main" class="site-main">
    <div class="container">
	    <?php while ( have_posts() ) : the_post(); ?>

            <!-- Load post content from format-standard.php -->
		    <?php get_template_part( 'template-parts/single', get_post_type() ); ?>

	    <?php endwhile; // end of the loop. ?>
    </div>
</main>

<?php get_footer();
