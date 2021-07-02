<?php
class Custom_EDD_Review extends Walker_Comment {
    /**
     * What the class handles.
     *
     * @since  2.0
     * @access public
     * @var string
     *
     * @see    Walker::$tree_type
     */
    public $tree_type = 'edd_review';
    /**
     * Start the element output.
     *
     * @param string  $output  Passed by reference. Used to append additional content.
     * @param object  $comment Comment data object.
     * @param int     $depth   Depth of comment in reference to parents.
     * @param array   $args    An array of arguments.
     *
     * @global object $comment
     *
     * @since 2.0
     *
     * @see   Walker::start_el()
     * @see   wp_list_comments()
     *
     * @global int    $comment_depth
     */
    public function start_el( &$output, $comment, $depth = 0, $args = array(), $id = 0 ) {
        $depth ++;
        $GLOBALS['comment_depth'] = $depth;
        $GLOBALS['comment']       = $comment;
        
        if ( ! empty( $args['callback'] ) ) {
            ob_start();
            call_user_func( $args['callback'], $comment, $args, $depth );
            $output .= ob_get_clean();
            return;
        }
        ob_start();
        do_action( 'edd_reviews_start_el' );
        $this->html5_comment( $comment, $depth, $args );
        $output .= ob_get_clean();
    }
    
    /**
     * Output a comment in the HTML5 format.
     *
     * @access protected
     *
     * @param object $comment Comment to display.
     * @param int    $depth   Depth of comment.
     * @param array  $args    An array of arguments.
     *
     * @see    wp_list_comments()
     *
     * @since  2.0
     *
     */
    protected function html5_comment( $comment, $depth, $args ) {
        global $post;
        global $user_ID;
        
        $tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
        if ( edd_reviews()->has_user_purchased( $comment->user_id, $comment->comment_post_ID ) ) {
            $verified = ' (' . __( 'verified owner', 'edd-reviews' ) . ')';
        } else {
            $verified = ' ';
        }
        ob_start();
        do_action( 'edd_reviews_before_review' );
        ?>

        <<?php echo $tag; ?> id="edd-review-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent' : '' ); ?>>
        <div id="div-edd-review-<?php comment_ID(); ?>" class="edd-review-body single_user_review">
            <div class="user_img">
                <?php echo get_avatar( $comment->comment_author_email, 48 ) ?>
            </div>
            <!-- /.user_img -->
            <div class="user_review">
                <?php if ( 1 == $depth ) {
                    $comment_author = get_user_by( 'email', $comment->comment_author_email );
                    $first_name = get_user_meta($comment_author->ID,'first_name',true);
                    $last_name = get_user_meta($comment_author->ID,'last_name',true);
                    ?>
                    <h4 class="user_name"><?php echo $first_name.' '.$last_name; ?><?php echo $verified; ?> - <?php echo get_comment_date( 'F j, Y', $comment->comment_ID ); ?></h4>
                    <ul class="user_ratings"><?php edd_reviews()->render_star_rating( get_comment_meta( $comment->comment_ID, 'edd_rating', true ) ); ?></ul>
<!--                     <p><?php echo get_comment_meta( $comment->comment_ID, 'edd_review_title', true ); ?></p> -->
				<p><?php echo apply_filters( 'get_comment_text', $comment->comment_content ); ?></p>
                <?php } ?>
                <div class="review_links">
<!--                    <a href="--><?php //echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?><!--" class="comment-links">Comment</a>-->
<!--                    --><?php //edit_comment_link( __( 'Edit', 'edd-reviews' ), '<div class="edit-link">', '</div>' ); ?>
                    <?php
                    edd_reviews()->reviews_reply_link( array_merge( $args, array(
                        'depth'     => $depth,
                        'max_depth' => $args['max_depth'],
                    ) ) );
                    ?>
                </div>
                <!-- /.review_links -->
                <div class="comment_meta-data">
                    <?php if ( '0' == $comment->comment_approved ) : ?>
                        <p class="edd-review-awaiting-moderation"><i><?php _e( 'Your review is awaiting moderation.', 'edd-reviews' ); ?></i></p>
                    <?php endif; ?>
                    <?php echo edd_reviews()->get_comment_helpful_output( $comment ); ?>
                    <?php edd_reviews()->comment_rating( $comment ); ?>
                </div>
                <!-- /.comment_meta-data -->
            </div>
            <!-- /.user_review -->
        </div><!-- .comment-body -->
        <?php
        do_action( 'edd_reviews_after_review' );
        $output = ob_get_contents();
        ob_end_clean();
        echo apply_filters( 'edd_reviews_body', $output, $comment, $depth, $args );
    }
    
    /**
     * Ends the element output, if needed.
     *
     * @param string     $output  Used to append additional content. Passed by reference.
     * @param WP_Comment $comment The current comment object. Default current comment.
     * @param int        $depth   Optional. Depth of the current comment. Default 0.
     * @param array      $args    Optional. An array of arguments. Default empty array.
     *
     * @see    Walker::end_el()
     * @see    wp_list_comments()
     *
     * @since  2.0
     * @access public
     *
     */
    public function end_el( &$output, $comment, $depth = 0, $args = array() ) {
        if ( ! empty( $args['end-callback'] ) ) {
            ob_start();
            call_user_func( $args['end-callback'], $comment, $args, $depth );
            $output .= ob_get_clean();
            
            return;
        }
        
        $tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
        
        $output .= "</$tag><!-- #comment-## -->\n";
        $output = apply_filters( 'edd_reviews_end_el', $output, $comment, $depth, $args );
    }
}
