<?php

namespace GoldAddons;

// Exit if accessed directly.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Initialize Admin Notifications
 *
 * @since 1.0.4
 */
class Notifications {
    
    /**
     * Class Constructor
     */
    function __construct() {
        
        add_action( 'admin_notices', [ $this, 'gapro_not_installed__notice' ] );
        
    }
    
    /**
     * GAPRO not Installed
     *
     * @since 1.0.4
     */
    function gapro_not_installed__notice() {
        $license = unserialize( get_option( '_goldaddons_license' ) );
        $license = isset( $license['status'] ) ? true : false;
        if( $license && ! is_plugin_active( 'gold-addons-pro-for-elementor/gold-addons-pro-for-elementor.php' ) ) {
            echo '<div class="notice notice-info is-dismissible">';
                echo '<p>'. sprintf( '%s <a href="%s" target="_blank">%s</a> %s <a href="%s" target="_blank">%s</a>', esc_html__( 'GoldAddons for Elementor license is activated successfully ! However it seems that you have not installed or activated', 'gold-addons-for-elementor' ), 'https://goldaddons.com/my-account/downloads/', 'GoldAddons PRO for Elementor', esc_html__( 'plugin so premium features are not enabled.', 'gold-addons-for-elementor' ), 'https://docs.goldaddons.com/', esc_html__( 'Documentation', 'gold-addons-for-elementor' ) ) .'</p>';
            echo '</div>';
        }
    }
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
