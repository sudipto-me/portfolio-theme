<?php
/**
 * Template for displaying search forms in abcd
 *
 * @package WordPress
 * @since   1.0
 * @version 1.0
 */
?>
<div class="blog_widget_wrapper">
    <form action="<?php echo home_url( '/' ); ?>" class="blog_search_form" method="get">
        <input type="text" class="cla_input-filed" placeholder="<?php _e( 'Search', 'portfolio' ); ?>" name="s" value="<?php echo get_search_query(); ?>">
        <button type="submit"><img src="<?php echo get_template_directory_uri() . '/assets/img/search_icon.svg' ?>" alt="search icon"></button>
    </form>
</div>
