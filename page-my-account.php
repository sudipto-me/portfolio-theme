<?php
/**
 * Template Name: Dashboard
 * @package abcd
 */
get_header();
$cookie_found = ( isset( $_COOKIE['tab'] ) && $_COOKIE['tab'] != 'manage' ) ? true : false;

?>
    <section class="inner_page_wrapper section_padding area">
        <div class="container">
            <div class="profile_content_wrapper">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link <?php echo ( $_COOKIE['tab'] == 'profile' || !isset($_COOKIE['tab']) ) ? 'active' : ''; ?>" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true"><?php _e( 'Profile', 'abcd' ); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ( $_COOKIE['tab'] == 'plugins' ) ? 'active' : ''; ?>" id="plugins-tab" data-toggle="tab" href="#plugins" role="tab" aria-controls="plugins" aria-selected="false"><?php _e( 'Plugins', 'abcd' ); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ( $_COOKIE['tab'] == 'manage' ) ? 'active' : ''; ?>" id="manage-tab" data-toggle="tab" href="#manage" role="tab" aria-controls="manage" aria-selected="false"><?php _e( 'Manage Licenses', 'abcd' ); ?></a>
                    </li>
                </ul>

                <div class="tab-content profile_tab_content" id="myTabContent">
                    <div class="tab-pane fade <?php echo ( $_COOKIE['tab'] == 'profile' || !isset($_COOKIE['tab']) ) ? 'show active' : ''; ?> " id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <?php echo do_shortcode( '[edd_profile_editor]' ); ?>
                    </div>
                    <!-- End of profile tab -->

                    <div class="tab-pane fade <?php echo ( $_COOKIE['tab'] == 'plugins' ) ? 'show active' : ''; ?>" id="plugins" role="tabpanel" aria-labelledby="plugins-tab">

                        <?php echo do_shortcode( '[purchase_history]' ); ?>
                    </div>
                    <!-- End of plugin tab -->

                    <div class="tab-pane fade manage <?php echo ( $_COOKIE['tab'] == 'manage' ) ? 'show active' : ''; ?>" id="manage" role="tabpanel" aria-labelledby="manage-tab">
                        <?php
                        if ( isset( $_GET['license_id'] ) && isset( $_GET['view'] ) && 'upgrades' == $_GET['view'] ) {
                            edd_get_template_part( 'licenses', 'upgrades' );
                        } else {
                            $view = isset( $_GET['license_id'] ) ? 'single' : 'overview';
                            edd_get_template_part( 'licenses', 'manage-' . $view );
                        }
                        ?>
                    </div>
                </div>

            </div>
            <!-- /.profile_content_wrapper -->
        </div>
        <!-- /.container -->
    </section>
<?php get_footer();

