<?php
/**
 * Custom comment walker for this theme.
 *
 * @package    WordPress
 * @subpackage Twenty_Twenty
 * @since      1.0.0
 */

if ( ! class_exists( 'TwentyTwenty_Walker_Comment' ) ) {
	/**
	 * CUSTOM COMMENT WALKER
	 * A custom walker for comments, based on the walker in Twenty Nineteen.
	 */
	class TwentyTwenty_Walker_Comment extends Walker_Comment {

		/**
		 * Outputs a comment in the HTML5 format.
		 *
		 * @param WP_Comment $comment Comment to display.
		 * @param int        $depth   Depth of the current comment.
		 * @param array      $args    An array of arguments.
		 *
		 * @see https://developer.wordpress.org/reference/functions/get_avatar/
		 * @see https://developer.wordpress.org/reference/functions/get_comment_reply_link/
		 * @see https://developer.wordpress.org/reference/functions/get_edit_comment_link/
		 *
		 * @see wp_list_comments()
		 * @see https://developer.wordpress.org/reference/functions/get_comment_author_url/
		 * @see https://developer.wordpress.org/reference/functions/get_comment_author/
		 */
		protected function html5_comment( $comment, $depth, $args ) {

			$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';

			?>
            <<?php echo $tag; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?>>
            <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
                <div class="comment_img">
					<?php
					$comment_author_url = get_comment_author_url( $comment );
					$comment_author     = get_comment_author( $comment );
					$avatar             = get_avatar( $comment, $args['avatar_size'] );
					if ( 0 !== $args['avatar_size'] ) {
						if ( empty( $comment_author_url ) ) {
							echo wp_kses_post( $avatar );
						} else {
							//printf( '<a href="%s" rel="external nofollow" class="url">', $comment_author_url ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped --Escaped in https://developer.wordpress.org/reference/functions/get_comment_author_url/
							echo wp_kses_post( $avatar );
						}
					}
					?>
                </div>
                <!-- /.comment_img -->
                <div class="comment_content">
					<?php
					printf(
						'<h4 class="comment_user_name">%1$s</h4>',
						esc_html( $comment_author )

					);
					/* Translators: 1 = comment date, 2 = comment time */
					$comment_timestamp = sprintf( __( '%1$s at %2$s', 'portfolio' ), get_comment_date( '', $comment ), get_comment_time() );
					?>
                    <span title="<?php echo esc_attr( $comment_timestamp ); ?>">
                        <?php echo esc_html( $comment_timestamp ); ?>
                    </span>
					<?php comment_text();
					if ( '0' === $comment->comment_approved ) {
						?>
                        <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'portfolio' ); ?></p>
						<?php
					}
					$comment_reply_link = get_comment_reply_link(
						array_merge(
							$args,
							array(
								'add_below' => 'div-comment',
								'depth'     => $depth,
								'max_depth' => $args['max_depth'],
							)
						)
					);
					$by_post_author     = edd_comment_by_post_author( $comment );

					if ( $comment_reply_link || $by_post_author ) {
						if ( $comment_reply_link ) {
							echo $comment_reply_link; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped --Link is escaped in https://developer.wordpress.org/reference/functions/get_comment_reply_link/
						}
//                        if ( $by_post_author ) {
//                            echo '<span class="by-post-author">' . __( 'By Post Author', 'portfolio' ) . '</span>';
//                        }
					}
					?>
                </div>
                <!-- /.comment_content -->

            </article><!-- .comment-body -->

			<?php
		}
	}
}
