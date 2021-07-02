<?php
/**
 * Reviews Template
 *
 * This template is used for displaying the reviews. It can be overriden by placing this
 * file in the edd_templates folder in your theme root
 */
global $post;
$user    = wp_get_current_user();
$user_id = ( isset( $user->ID ) ? (int) $user->ID : 0 );

if ( edd_reviews()->is_review_status( 'disabled' ) ) {
    return;
}
?>
<div id="edd-reviews" class="edd-reviews-area">
    <?php if ( edd_reviews()->have_reviews() ) { ?>
        <div class="edd-reviews-list">
            <?php
            //		edd_reviews()->reviews_title();
            //		edd_reviews()->maybe_show_review_breakdown();
            ?>
            <p><b><?php echo __( 'Only customers who have purchased this product may leave a review.', 'abcd' ); ?></b></p>
            <p><b><?php echo edd_reviews()->count_reviews() . __( ' reviews for ', 'abcd' ) . get_the_title( $post->ID ); ?></b></p>
            <div class="review-breakdown">
                <?php
                $total_reviews = edd_reviews()->average_rating( false, $post->ID ); ?>
                <div class="starts-outer">
                    <div class="starts-inner" style="width: <?php echo $total_reviews * 20 ?>%"></div>
                </div>
                <?php
                edd_reviews()->maybe_show_review_breakdown();
                ?>
            </div>
            <?php
            edd_reviews()->render_reviews();
            $reviews           = edd_reviews()->query_reviews();
            $num_reviews       = count( $reviews );
            $comments_per_page = get_option( 'comments_per_page' );
            $total_page_count  = ceil( $num_reviews / $comments_per_page );
            if ( $num_reviews > $comments_per_page ) {
                ?>
                <div class="reviews_loadmore">
                    <img src="<?php echo get_template_directory_uri() . '/assets/img/loading.gif' ?>" alt="loading" class="loading hide">
                    <input type="hidden" class="review-load-more" name="review-load-more" data-parent-post_id="<?php echo get_the_id(); ?>" data-comments-per-page="<?php echo $comments_per_page; ?>" data-total-items="<?php echo $num_reviews; ?>" data-total-pages="<?php echo $total_page_count; ?>" data-current-page="1">
                    <a href="#" class="review_load_more site_cta"><?php _e( 'Load More', 'abcd' ); ?></a>
                </div>
                <?php
            }
            ?>
        </div>
    <?php } ?>
    
    <?php if ( ! edd_reviews()->is_review_status( 'closed' ) ) { ?>
        <div class="edd-reviews-form" id="edd-reviews-respond">
            <?php if ( ! edd_reviews()->maybe_restrict_form() ) { ?>
                <?php if ( is_user_logged_in() || ( ! is_user_logged_in() && edd_reviews()->is_guest_reviews_enabled() ) ) { ?>
                    <h3 id="edd-reviews-heading" class="edd-reviews-heading"><?php echo edd_reviews()->review_form_args( 'title_review' ) ?></h3>
                    <?php echo edd_reviews()->review_form_args( 'logged_in_as' ); ?>
                    <form method="post" name="<?php echo edd_reviews()->review_form_args( 'name_form' ) ?>" id="<?php echo edd_reviews()->review_form_args( 'id_form' ) ?>" class="<?php echo edd_reviews()->review_form_args( 'class_form' ) ?>">
                        <div class="edd-reviews-form-inner">
                            <?php echo edd_reviews()->review_form_args( 'guest_form_fields' ); ?>
                            <div class="review_form">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="inp_grp">
                                            <label for="edd-reviews-review-title"><?php _e( 'Review Title', 'abcd' ) ?> <span class="required">*</span></label>
                                            <input type="text" id="edd-reviews-review-title" class="edd-reviews-review-title inp_field" name="edd-reviews-review-title" value="" size="30" aria-required="true" required="required"/>
                                        </div>
                                        <!-- /.inp_grp -->
                                    </div>
                                    <!-- /.col-md-6 -->
                                    <div class="col-md-12">
                                        <div class="inp_grp">
                                            <label for="edd-reviews-review"><?php _e( 'Rating', 'abcd' ) ?> <span class="required">*</span></label>
                                            <?php edd_reviews()->render_star_rating_html(); ?>
                                        </div>
                                        <!-- /.ing_grp -->
                                    </div>
                                    <!-- /.col-md-6 -->
                                    <div class="col-md-12">
                                        <div class="inp_grp">
                                            <label for="edd-reviews-review"><?php _e( 'Review', 'abcd' ); ?> <span class="required">*</span></label>
                                            <textarea id="edd-reviews-review" name="edd-reviews-review" class="inp_field" cols="45" rows="8" aria-required="true" required="required"></textarea>
                                        </div>
                                        <!-- /.inp_grp -->
                                    </div>
                                    <!-- /.col-md-12 -->
                                    <div class="col-md-12">
                                        <?php do_action( 'edd_reviews_form_before_submit' ); ?>
                                    </div>
                                    <!-- /.col-md-12 -->
                                    <div class="col-md-12">
                                        <div class="submit_wrapper">
                                            <input type="submit" class="edd-reviews-review-form-submit site_cta" id="edd-reviews-review-form-submit" name="edd-reviews-review-form-submit" value="<?php _e( 'Post Review', 'abcd' ) ?>"/>
                                        </div>
                                        <!-- /.submit_wrapper -->
                                    </div>
                                    <!-- /.col-md-12 -->
                                    <?php do_action( 'edd_reviews_form_after' ); ?>
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.review_form -->
                        </div><!-- /.edd-reviews-form-inner -->
                    </form><!-- /#edd-reviews-form -->
                
                <?php } else { ?>
                    <p class="edd-reviews-not-allowed"><?php echo apply_filters( 'edd_reviews_user_logged_out_message', __( 'You must log in to submit a review.', 'edd-reviews' ) ); ?></p>
                    <?php wp_login_form( array( 'echo' => true ) ); ?>
                <?php } // end if ?>
            
            <?php } else { ?>
                <?php if ( ! is_user_logged_in() ) { ?>
                    <p class="edd-reviews-not-allowed"><?php echo apply_filters( 'edd_reviews_user_logged_out_message', sprintf( __( 'You must log in and be a buyer of this %s to submit a review.', 'edd-reviews' ), strtolower( edd_get_label_singular() ) ) ); ?></p><!-- /.edd-reviews-not-allowed -->
                <?php } elseif ( ! edd_has_user_purchased( $user_id, $post->ID ) ) { ?>
                    <p class="edd-reviews-not-allowed"><?php echo apply_filters( 'edd_reviews_user_non_buyer_message', sprintf( __( 'You must be a buyer of this %s to submit a review.', 'edd-reviews' ), strtolower( edd_get_label_singular() ) ) ); ?></p><!-- /.edd-reviews-not-allowed -->
                <?php } // end if ?>
                
                <?php
                if ( ! is_user_logged_in() ) {
                    $output = wp_login_form( array( 'echo' => true ) );
                    echo apply_filters( 'edd_reviews_user_not_buyer', $output );
                } // end if
                ?>
            
            <?php } // end if ?>
        </div><!-- /.edd-reviews-form -->
    
    <?php } // end if ?>
</div><!-- /#edd-reviews -->
