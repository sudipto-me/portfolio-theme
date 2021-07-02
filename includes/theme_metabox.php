<?php
// metaboxes for documentaitons and downloads
add_action( 'add_meta_boxes', 'documentation_metabox_function' );
add_action( 'save_post', 'related_downloads_metabox_save' );

function documentation_metabox_function() {
    add_meta_box( 'documentaion-download', __( 'Related Downloads', 'abcd' ), 'related_downloads_metabox_callback', 'theme_documentation', 'side' );
}

/**
 * Related Download Metabox Callback
 */
function related_downloads_metabox_callback( $post ) {
    wp_nonce_field( 'related_downloads_nonce_action', 'related_downloads_nonce' );
    $related_downloads = get_post_meta( $post->ID, 'documentaion-download', true );
    $downloads         = get_posts( array(
        'post_type'      => 'download',
        'posts_per_page' => - 1
    ) );
    //$i                 = 0;
    $checked = '';
    foreach ( $downloads as $single ) {
        if ( is_array( $related_downloads ) && count( $related_downloads ) ) {
            $checked = in_array( $single->ID, $related_downloads ) ? 'checked' : '';
        }
        ?>
        <input type="checkbox" name="downloads[]" value="<?php echo $single->ID ?>" <?php echo $checked; ?>><?php echo $single->post_title; ?><br>
        <?php
        //$i ++;
    }
}

/**
 * Related Downloads Metabox Save
 */
function related_downloads_metabox_save( $post_id ) {
    if ( ! isset( $_POST['related_downloads_nonce'] ) ) {
        return;
    }
    if ( ! wp_verify_nonce( $_POST['related_downloads_nonce'], 'related_downloads_nonce_action' ) ) {
        return;
    }
    if ( ! current_user_can( 'edit_post' ) ) {
        return;
    }
    if ( ! isset( $_POST['downloads'] ) ) {
        return;
    }
    $related_downloads = $_POST['downloads'];
    update_post_meta( $post_id, 'documentaion-download', $related_downloads );
    
}
