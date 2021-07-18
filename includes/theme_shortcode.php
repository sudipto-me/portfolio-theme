<?php
/**
 * Footer Social Shortcode
 */
function footer_social_shortcode_callback( $atts, $content = null ) {
    ob_start();
    $theme_options = get_option( 'portfolio' );
    $social_links  = $theme_options['theme-social-repeater'];
    $contact_phone           = ! empty( $theme_options['contact-phone'] ) ? $theme_options['contact-phone'] : '+880-1921378547';
    $contact_email           = ! empty( $theme_options['contact-email'] ) ? $theme_options['contact-email'] : 'shakhari.sudipto@gmail.com';
    $contact_skype         = ! empty( $theme_options['contact-skype'] ) ? $theme_options['contact-skype'] : 'sudipto.ruet';
    ?>
    <div class="contacts__list">
        <dl class="contact-list">
            <dt><?php echo esc_attr__("Phone:","portfolio");?></dt>
            <dd><a href="<?php echo 'tel:' . esc_attr( $contact_phone ); ?>"><?php echo esc_attr( $contact_phone ); ?></a></dd>
            <dt><?php echo esc_attr__("Skype:","portfolio");?></dt>
            <dd><a href="<?php echo 'skype:' . esc_attr( $contact_skype ); ?>"><?php echo esc_attr( $contact_skype ); ?></a></dd>
            <dt><?php echo esc_attr__("Email:","portfolio");?></dt>
            <dd><a href="<?php echo 'mailto:' . sanitize_email( $contact_email ); ?>"><?php echo sanitize_email( $contact_email ); ?></a></dd>
        </dl>
    </div>
<?php
    if ( is_array( $social_links ) && ! empty( $social_links ) ) { ?>
            <div class="contacts__social">
                <ul>
                <?php
                foreach ( $social_links as $social ) {
                    if ( isset( $social['social-link'] ) && ! empty( $social['social-link'] ) ) {
                        ?>
                        <li><a href="<?php echo $social['social-link']; ?>" target="_blank"><?php echo esc_attr__( $social['social-media-name'],'portfolio');?></a></li>
                        <?php
                    }
                }
                ?>
                </ul>
            </div>
        <?php
    }
    return ob_get_clean();
}

add_shortcode( 'social_links', 'footer_social_shortcode_callback' );

/*
* display year shortcode
*/
add_shortcode( 'display_year', 'display_year_shortcode_callback' );
function display_year_shortcode_callback() {
    return date( 'Y' );
}

/**
 * Review shortcode
 */
// add_shortcode( 'show_review', 'show_review_shortcode_callback' );
function show_review_shortcode_callback() {
    global $post;
    ob_start();
    if ( $post && $post->post_type == 'download' && is_singular( 'download' ) && is_main_query() && ! post_password_required() ) {
        edd_get_template_part( 'reviews' );
        if ( get_option( 'thread_comments' ) ) {
            edd_get_template_part( 'reviews-reply' );
        }
    }
    
    return ob_get_clean();
}

/**
 * Thank you shortcode
 */
// add_shortcode( 'custom_edd_thank_you', 'custom_edd_thank_you_shortcode_callback' );
function custom_edd_thank_you_shortcode_callback() {
    ob_start();
    ?>
    <div class="thank_you_wrapper">
        <div class="thanks_img">
            <img src="<?php echo get_template_directory_uri() . "/assets/img/thank.png"; ?>" alt=" thank-you-image">
        </div>
        <p><?php echo __( 'Thank you for choosing us. We have received your payment.', 'abcd' ); ?></p>
        <ul class="cus_lis_item">
            <li><img src="<?php echo get_template_directory_uri() . "/assets/img/tick.png"; ?>" alt="tick-image">
                <p><?php echo __( 'Check your email for more details. Please check your Spam/Junk folder or Promotions tab also.', 'abcd' ); ?></p></li>
            <li><img src="<?php echo get_template_directory_uri() . "/assets/img/tick.png"; ?>" alt="tick-image">
                <p><?php echo __( 'Don\'t forget to deactivate and delete the free version first.', 'abcd' ); ?></p></li>
        </ul>
        <p><?php echo __( 'Feel free to contact us for any reason whatsoever - just send us an email via our support page. We hope you will enjoy using our plugins.', 'abcd' ); ?></p>
        <p><?php echo __( '-- The ABC Team', 'abcd' ); ?></p>
    </div>
    <!-- /.thank_you_wrapper -->
    <?php
    return ob_get_clean();
}

/**
 * Our Plugins short code
 */
// add_shortcode( 'custom_plugin_list', 'custom_plugin_list_shortcode_callback' );
function custom_plugin_list_shortcode_callback( $attrs, $content = null ) {
    ob_start();
    $posts_per_page = ! empty( $attrs['count'] ) ? $attrs['count'] : 3;
    $plugins        = get_posts( array(
        'post_type'      => 'download',
        'posts_per_page' => $posts_per_page,
        'post_status'    => 'publish',
        'meta_key'       => '_edd_download_sales',
        'order'     => 'DESC',
		'orderby' => 'meta_value_num'
    ) );
    if ( $plugins ) {
        ?>
        <div class="blog_widget_wrapper">
        <div class="blog_widget_header">
            <h2 class="blog_widget_title"><?php echo __( 'Our plugins', 'abcd' ); ?></h2>
            <img src="<?php echo get_template_directory_uri() . '/assets/img/plugin_widget_icon.svg'; ?>" alt="plugin widget icon">
        </div>
        <!--        blog_widget_header-->
        <?php foreach ( $plugins as $plugin ) {
            $icons    = get_field( 'icons', $plugin->ID );
            $icon_url = $icons['url'];
            ?>
            <div class="plugin_widget_card">
                <div class="plugin_widget_img">
                    <a href="<?php echo get_the_permalink( $plugin->ID ); ?>"><img src="<?php echo $icon_url ? $icon_url : get_template_directory_uri() . '/assets/img/plugin.png' ?>" alt="plugin icon"></a>
                </div>
                <div class="plugin_widget_content">
                    <h2><a href="<?php echo get_the_permalink( $plugin->ID ); ?>"><?php echo get_the_title( $plugin->ID ); ?></a></h2>
                    <div class="product_ratings">
                        <?php $total_reviews = edd_reviews()->average_rating( false, $plugin->ID ); ?>
                        <ul>
                            <li>
                                <div class="starts-outer">
                                    <div class="starts-inner" style="width: <?php echo $total_reviews * 20 ?>%"></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="widget_more_btn">
                        <a href="<?php echo get_the_permalink( $plugin->ID ); ?>"><?php echo __( 'Buy Now', 'abcd' ); ?> <img src="<?php echo get_template_directory_uri() . '/assets/img/right_long_arrow.svg' ?>" alt="right arrow"></a>
                    </div>
                </div>
            </div>
            <?php
        }
        echo '</div>';
    }
    
    return ob_get_clean();
}

/**
 * recent posts shortcode
 */
// add_shortcode( 'custom_recent_post', 'custom_recent_post_shortcode_callback' );
function custom_recent_post_shortcode_callback( $attrs, $content = null ) {
    ob_start();
    $posts_per_page = ! empty( $attrs['count'] ) ? $attrs['count'] : 5;
    $posts          = get_posts( array(
        'post_type'      => 'post',
        'posts_per_page' => $posts_per_page,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC'
    ) );
    if ( $posts ) { ?>
        <div class="blog_widget_wrapper">
            <div class="blog_widget_header">
                <h2 class="blog_widget_title"><?php echo __('Recent Posts','abcd');?></h2>
                <img src="<?php echo get_template_directory_uri() . '/assets/img/post_widget_icon.svg'; ?>" alt="post widget icon">
            </div>
            <?php
                foreach ($posts as $post){
                    ?>
                    <div class="recent_post_card">
                       <div class="recent_post_card_option">
                          <?php $categories = get_the_terms( $post->ID, 'category' );
                          if($categories): ?>
                            <p><a href="<?php echo get_category_link( $categories[0]->term_id);?>"><?php echo $categories[0]->name;?></a></p>
                             <?php else:
                                echo '<p></p>';
                             endif;?>
                             <p><a href="<?php echo get_day_link(get_post_time('Y'), get_post_time('m'), get_post_time('j'));  ?>" class="entry-date"><?php echo date( 'j M Y', strtotime( $post->post_date ) ); ?></a></p>
                       </div>
                        <h2><a href="<?php echo get_the_permalink($post->ID);?>"><?php echo get_the_title($post->ID);?></a></h2>
                    </div>
                 <?php
                }
        echo '</div>';
    }
    
    return ob_get_clean();
}

/**
 * Add shortcode for categories
*/
// add_shortcode('custom_category','custom_category_shortcode_callback');
function custom_category_shortcode_callback($attrs,$content=null) {
    ob_start();
    $count = ! empty( $attrs['count'] ) ? $attrs['count'] : 5;
    $categories = get_terms(array(
        'taxonomy'=> 'category',
        'hide_empty' => false,
        'number' => $count
    ));
    if($categories){
        echo '<div class="blog_widget_wrapper">';
        echo '<div class="blog_widget_header">';
        echo '<h2 class="blog_widget_title">'.__('Categories','abcd').'</h2>';
        echo '</div>';
        echo '<ul class="categories_widget_list">';
        foreach ($categories as $category){
            echo '<li><a href="'.get_category_link($category->term_id).'">'.$category->name. ' ('.$category->count.')</a></li>';
        }
        echo '</ul>';
        echo '</div>';
    }
    return ob_get_clean();
    
}