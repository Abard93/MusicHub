<?php

namespace GoldAddons\Core\Admin;

use GoldAddons\Settings as Settings;
use GoldAddons\Notifications as Notifications;

// Exit if accessed directly.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Initialize Admin
 *
 * @since 1.0.3
 */
class Admin {
    
    /**
	 * Admin constructor.
	 *
	 * Initializing GoldAddons in WordPress admin.
	 *
	 * @since 1.0.3
	 * @access public
	 */
    public function __construct() {
        
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
        
        if( ! class_exists( 'GoldAddons_PRO_for_Elementor' ) ) {
            add_filter( 'plugin_action_links_' . GOLDADDONS_BASENAME, [ $this, 'plugin_action_links' ] );
        }
        
        // Include Admin Files
        require_once( GOLDADDONS_DIR . 'core/admin/license.php' );
        require_once( GOLDADDONS_DIR . 'core/admin/settings.php' );
        require_once( GOLDADDONS_DIR . 'core/admin/notifications.php' );
        
        // Initialize
        $this->settings         = new Settings();
        $this->notifications    = new Notifications();
    }
    
    /**
	 * Enqueue admin scripts.
	 *
	 * Registers all the admin scripts and enqueues them.
	 *
	 * Fired by `admin_enqueue_scripts` action.
	 *
	 * @since 1.0.3
	 * @access public
	 */
    public function enqueue_scripts() {
        
        wp_enqueue_style( 'goldaddons-admin', GOLDADDONS_URI . 'assets/css/admin.css', false, GOLDADDONS_VERSION );
        
    }
    
    /**
	 * Plugin action links.
	 *
	 * Adds action links to the plugin list table
	 *
	 * Fired by `plugin_action_links` filter.
	 *
	 * @since 1.0.3
	 * @access public
	 *
	 * @param array $links An array of plugin action links.
	 *
	 * @return array An array of plugin action links.
	 */
    public function plugin_action_links( $links ) {
        $links['go_pro'] = sprintf( 
            '<a href="%1$s" target="_blank" class="goldaddons-plugin-gopro">%2$s</a>', 
            esc_url( 'https://goldaddons.com/pricing/' ), 
            esc_html__( 'Go Pro', 'gold-addons-for-elementor' ) 
        );

		return $links;
    }
    
}
new Admin();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
