<?php
$theme_options = get_option( 'abcd' );
$footer_bg     = ( ! empty( $theme_options['theme-footer-bg']['url'] ) ) ? $theme_options['theme-footer-bg']['url'] : get_template_directory_uri() . '/assets/img/footer-background.jpg';
$copyright     = ( ! empty( $theme_options['theme-copyright-content'] ) ) ? $theme_options['theme-copyright-content'] : '';
$footer_script = ( ! empty( $theme_options['footer-script'] ) ) ? $theme_options['footer-script'] : '';
?>
</main>

<footer class="site_footer background" style="background-image: url(<?php echo $footer_bg; ?>);">
    <div class="container section">
        <div class="row">
            <div class="col-md-12">
                <p id="contacts_header" class="section__title"><?php echo esc_html__( 'Get in touch_', '' ); ?></p>
            </div>
        </div>
        <div class="row contacts">
			<?php if ( is_active_sidebar( 'footer-widget-area-1' ) ): ?>
                <div class="col-md-5 col-lg-4">
	                <?php dynamic_sidebar( 'footer-widget-area-1' ); ?>
                </div>
			<?php endif; ?>
	        <?php if ( is_active_sidebar( 'footer-widget-area-2' ) ): ?>
                <div class="col-md-7 col-lg-5">
			        <?php dynamic_sidebar( 'footer-widget-area-2' ); ?>
                </div>
	        <?php endif; ?>
        </div>
        <div class="footer">
	        <?php if ( ! empty( $copyright ) ) {
		        echo '<div class="copyright-text">';
		        echo '<p>' . do_shortcode( $copyright );
		        echo '</p></div>';
	        } else {
		        echo do_shortcode( '<p>' . "&copy; [display_year] Sudipto Shakhari All Rights Reserved." . '</p>' );
	        } ?>
        </div>
    </div>
</footer>
<?php wp_footer();
if ( ! empty( $footer_script ) ) {
	echo $footer_script;
}
?>
</body>

</html>