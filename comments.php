<?php
/**
 * The template for displaying Comments
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package    WordPress
 * @subpackage Twenty_Fourteen
 * @since      Twenty Fourteen 1.0
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
    return;
}

?>

<div id="comments" class="comments-area">
    <?php

    $comment_author = 'Name';
    $comment_email = 'E-Mail';

    $comment_cancel = 'Cancel Reply';
    $comment_form_args = array(
        'title_reply_before' => '<div class="reply_title_wrapper"><div class="reply_title"><h3>',
        'title_reply_after'  => '</h3></div></div>'
    );
    comment_form( $comment_form_args ); ?>
    <?php if ( have_comments() ) : ?>
        
        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
            <nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
                <h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'abcd' ); ?></h1>
                <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'abcd' ) ); ?></div>
                <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'abcd' ) ); ?></div>
            </nav><!-- #comment-nav-above -->
        <?php endif; // Check for comment navigation. ?>

        <div class="comment_wrapper">
            <div class="reply_title_wrapper">
                <div class="reply_title">
                    <h3><?php echo __( 'Leave a Reply', 'abcd' ); ?></h3>
                </div>
            </div>
            <ol class="comment-list">
                <?php
                wp_list_comments( array(
                    'walker'      => new TwentyTwenty_Walker_Comment(),
                    'style'       => 'ol',
                    'short_ping'  => true,
                    'avatar_size' => 70,
                ) );
                ?>
            </ol><!-- .comment-list -->
            <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
                <nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
                    <h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'abcd' ); ?></h1>
                    <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'abcd' ) ); ?></div>
                    <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'abcd' ) ); ?></div>
                </nav><!-- #comment-nav-below -->
            <?php endif; // Check for comment navigation. ?>
            
            <?php if ( ! comments_open() ) : ?>
                <p class="no-comments"><?php _e( 'Comments are closed.', 'abcd' ); ?></p>
            <?php endif; ?>

        </div>
    
    
    <?php endif; // have_comments() ?>

</div><!-- #comments -->