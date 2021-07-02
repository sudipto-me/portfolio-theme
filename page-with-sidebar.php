<?php
/**
* Template Name: With Sidebar
*
**/
get_header();
$meta = get_post_meta( get_the_ID(), 'biermann_page_metabox', true );
$show_title = isset($meta['show_page_title']) ? $meta['show_page_title'] : '';
$post_thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'full');
$page_custom_title = isset($meta['custom_page_title']) ? $meta['custom_page_title'] : '';
$title = !empty($page_custom_title) ? $page_custom_title : get_the_title(get_the_ID());
if ($show_title === '1' && empty($post_thumbnail) ) {
  ?>
  <section class="title-header">
    <h2 class="media-heading text-center"><?php echo $title; ?></h2>
  </section>
<?php }
if ($post_thumbnail != '') :
  ?>
  <section class="page-hero-section section_overlay" style="background: url(<?php echo $post_thumbnail; ?>);">
    <div class="container">
      <?php if ($show_title === '1') : ?>
        <h2 class="page_custom_title"><?php echo $title; ?></h2>
      <?php endif; ?>
    </div>
    <!-- /.container -->
  </section>
<?php endif; ?>
<section class="default-page-with-sidebar">
  <div class="container page-body">
    <div class="row">
      <div class="col-sm-8">
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
          <?php
          if(have_posts()):
            while ( have_posts() ) :
              the_post();
              the_content();
            endwhile;
          endif;
          ?>
        </article>
      </div>
      <div class="col-sm-4">
        <?php
        $sidebarName = isset($meta['page_sidebar']) ? $meta['page_sidebar'] : 'blog-sidebar';
        if( is_active_sidebar( $sidebarName ) ){
          dynamic_sidebar( $sidebarName );
        }
        ?>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>
