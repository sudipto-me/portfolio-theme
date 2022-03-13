<?php
$theme_options = get_option( 'portfolio' );
$footer_bg     = ( ! empty( get_theme_mod( 'footer-background-img' ) ) ) ? wp_get_attachment_url( get_theme_mod( 'footer-background-img' ) ) : get_template_directory_uri() . '/assets/img/footer-background.jpg';
?>
</main>

<footer class="site_footer background" style="background-image: url(<?php echo $footer_bg; ?>);">
    <div class="container section">
        <div class="row">
            <div class="col-md-12">
                <p id="contacts_header" class="section__title"><?php echo esc_html__( 'Get in touch_', 'portfolio' ); ?></p>
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
	        <?php
		        echo do_shortcode( '<p>' . "&copy; [display_year] Sudipto Shakhari All Rights Reserved." . '</p>' );
	         ?>
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