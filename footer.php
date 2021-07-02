<?php
$theme_options = get_option( 'abcd' );
$footer_bg     = ( ! empty( $theme_options['theme-footer-bg']['url'] ) ) ? $theme_options['theme-footer-bg']['url'] : get_template_directory_uri() . '/assets/img/footer_bg.png';
$copyright     = ( ! empty( $theme_options['theme-copyright-content'] ) ) ? $theme_options['theme-copyright-content'] : '';
$footer_script = ( ! empty( $theme_options['footer-script'] ) ) ? $theme_options['footer-script'] : '';
?>
</main>

<footer class="site_footer area" style="background: url(<?php echo $footer_bg; ?>); background-size: contain; background-repeat: no-repeat; background-position: center bottom">
    <section class="footer_section area">
        <div class="container">
            <div class="footer_content_wrapper">
                <div class="row">
                    <?php if ( is_active_sidebar( 'footer-widget-area-1' ) ) : ?>
                        <div class="col-lg-4 col-md-12">
                            <?php dynamic_sidebar( 'footer-widget-area-1' ); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ( is_active_sidebar( 'footer-widget-area-2' ) ) : ?>
                        <div class="offset-lg-1 col-lg-3 col-md-12">
                            <?php dynamic_sidebar( 'footer-widget-area-2' ); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ( is_active_sidebar( 'footer-widget-area-3' ) ) : ?>
                        <div class="col-lg-4 col-md-12">
                            <?php dynamic_sidebar( 'footer-widget-area-3' ); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.footer_content_wrapper -->
        </div>
        <!-- /.container -->
    </section>
    <!-- /.footer_widget_section area -->

    <section class="copyright_section area">
        <div class="container">
            <?php if ( ! empty( $copyright ) ) {
                echo '<div class="copyright-text">';
                echo '<p>'.do_shortcode( $copyright );
                echo '</p></div>';
            } else {
                echo do_shortcode( '<p>' . "&copy; [display_year] abcd All Rights Reserved." . '</p>' );
            } ?>
        </div>
        <!-- /.container -->
    </section>
    <!-- /.copyright_section area -->
</footer>
<?php wp_footer();
if ( ! empty( $footer_script ) ) {
    echo $footer_script;
}
?>
</body>

</html>