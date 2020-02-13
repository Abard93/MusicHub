<?php

namespace GoldAddons;

use GoldAddons\License as License;

// Exit if accessed directly.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * GoldAddons "Settings" page in WordPress Dashboard.
 *
 * GoldAddons settings page handler class responsible for creating and displaying
 * GoldAddons "Settings" page in WordPress dashboard.
 *
 * @since 1.0.4
 */
class Settings {
    
    /**
	 * Settings page ID for GoldAddons settings.
	 */
	const PAGE_ID = 'goldaddons';
    
    /**
	 * Go Pro menu priority.
	 */
	const MENU_PRIORITY_GO_PRO = 502;
    
    /**
	 * Settings page general tab slug.
	 */
	const TAB_GENERAL = 'general';
    
    /**
	 * Register admin menu.
	 *
	 * Add new GoldAddons Settings admin menu.
	 *
	 * Fired by `admin_menu` action.
	 *
	 * @since 1.0.4
	 * @access public
	 */
	public function register_admin_menu() {
		add_menu_page(
			esc_html__( 'GoldAddons', 'gold-addons-for-elementor' ),
			esc_html__( 'GoldAddons', 'gold-addons-for-elementor' ),
			'manage_options',
			self::PAGE_ID,
			[ $this, 'display_settings_page' ],
			'dashicons-welcome-widgets-menus',
			99
		);
	}
    
    /**
	 * Register GoldAddons Pro sub-menu.
	 *
	 * Add new GoldAddons Pro sub-menu under the main GoldAddons menu.
	 *
	 * Fired by `admin_menu` action.
	 *
	 * @since 1.0.4
	 * @access public
	 */
	public function register_pro_menu() {
		add_submenu_page(
			self::PAGE_ID,
			'',
			'<span class="dashicons dashicons-star-filled" style="font-size: 17px"></span> ' . esc_html__( 'Go Pro', 'gold-addons-for-elementor' ),
			'manage_options',
			'go_goldaddons_pro',
			[ $this, 'handle_external_redirects' ]
		);
	}
    
    /**
	 * Go GoldAddons Pro.
	 *
	 * Redirect the GoldAddons Pro page the clicking the GoldAddons Pro menu link.
	 *
	 * Fired by `admin_init` action.
	 *
	 * @since 1.0.4
	 * @access public
	 */
	public function handle_external_redirects() {
		if ( empty( $_GET['page'] ) ) {
			return;
		}

		if ( 'go_goldaddons_pro' === $_GET['page'] ) {
			wp_redirect( 'https://goldaddons.com/pricing/?utm_source=wp-menu&utm_campaign=gopro&utm_medium=wp-dash' );
			die;
		}
        
	}
    
    /**
	 * On admin init.
	 *
	 * Preform actions on WordPress admin initialization.
	 *
	 * Fired by `admin_init` action.
	 *
	 * @since 1.0.4
	 * @access public
	 */
	public function on_admin_init() {
		$this->handle_external_redirects();
	}
    
    /**
	 * Get settings page title.
	 *
	 * Retrieve the title for the settings page.
	 *
	 * @since 1.0.4
	 * @access protected
	 *
	 * @return string Settings page title.
	 */
	protected function get_page_title() {
		return esc_html__( 'GoldAddons', 'gold-addons-for-elementor' );
	}
    
    /**
	 * Display settings page.
	 *
	 * Output the content for the settings page.
	 *
	 * @since 1.0.4
	 * @access public
	 */
	public function display_settings_page() { 
        $ga = get_option( '_goldaddons_license' ) !== '' ? unserialize( get_option( '_goldaddons_license' ) ) : ''; 
        $message = isset( $ga['message'] ) ? esc_html( $ga['message'] ) : '';
        $status = isset( $ga['status'] ) ? esc_html( $ga['status'] ) : ''; 
        $status == 'active' ? $icon = 'dashicons-yes' : $icon = 'dashicons-no-alt'; ?>
        <div id="goldaddons-settings" class="wrap <?php echo $status; ?>">
            <h1>GoldAddons</h1>
            <form method="post">
                <?php wp_nonce_field( 'goldaddons-settings', 'goldaddons-settings-nonce' ); ?>
                <div id="ga-settings-license" class="postbox">
                    <h3><?php esc_html_e( 'License', 'gold-addons-for-elementor' ); ?></h3>
                    <div class="inside">
                        <table class="form-table">
                            <tbody>
                                <tr valign="top">
                                    <th scope="row">
                                        <strong><?php esc_html_e( 'License Key', 'gold-addons-for-elementor' ); ?></strong>
                                    </th>
                                    <td>
                                        <p><?php esc_html_e( 'You are using GoldAddons free version.', 'gold-addons-for-elementor' ); ?></p>
                                        <p><?php esc_html_e( 'To unlock more widgets & features consider purchasing license key.', 'gold-addons-for-elementor' ); ?></p>
                                        <p class="ga-promo"><i><?php printf( '<strong>%s</strong> %s: <strong>%s</strong>', '20%', esc_html__( 'off coupon code', 'gold-addons-for-elementor' ), 'ga20' ); ?></i> - <a href="https://goldaddons.com/pricing/" target="_blank"><?php esc_html_e( 'Order License Key', 'gold-addons-for-elementor' ); ?></a></p>
                                        <p class="license-details">
                                            <select name="goldaddons[sku]">
                                                <option value=""><?php esc_html_e( 'Select license type', 'gold-addons-for-elementor' ); ?></option>
                                                <option value="gaps" <?php selected( 'gaps', $ga['sku'], true ); ?>><?php esc_html_e( 'Personal', 'gold-addons-for-elementor' ); ?></option>
                                                <option value="gabs" <?php selected( 'gabs', $ga['sku'], true ); ?>><?php esc_html_e( 'Business', 'gold-addons-for-elementor' ); ?></option>
                                                <option value="gaul" <?php selected( 'gaul', $ga['sku'], true ); ?>><?php esc_html_e( 'Unlimited', 'gold-addons-for-elementor' ); ?></option>
                                            </select>
                                            <input id="goldaddons-license" name="goldaddons[key]" type="text" value="<?php echo $ga['key']; ?>" placeholder="<?php echo 'e.g.: A7D10N53q2IX7xfb1uS3BzUvxY-1'; ?>" class="regular-text"> <i class="dashicons <?php echo $icon; ?>"></i>
                                        </p>
                                        <p class="message"><?php echo $message; ?></p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <?php submit_button( false, 'button button-primary', 'goldaddons[submit]' ); ?> 
                    </div> 
                </div>
            </form>
        </div>
        <?php if( ! is_plugin_active( 'gold-addons-pro-for-elementor/gold-addons-pro-for-elementor.php' ) ): ?>
        <div class="wrap about-wrap full-width-layout">
            <h3 class="aligncenter">GoldAdodns PRO Widgets</h3>
            <div class="has-2-columns">
                <div class="column aligncenter">
                    <div class="dashicons dashicons-portfolio" style="font-size:32px;"></div>
                    <h4><a href="https://goldaddons.com/widgets/portfolio" target="blank">Portfolio Widget</a></h4>
                    <p>Create avesome portfolio sections with GoldAddons PRO Portfolio widget.</p>
                </div>
                <div class="column aligncenter">
                    <div class="dashicons dashicons-image-rotate-left" style="font-size:32px;"></div>
                    <h4><a href="https://goldaddons.com/widgets/3d-flip-box" target="blank">3D Flip Box Widget</a></h4>
                    <p>Create awesome 3D flip boxes with front/back area text or images. Pure CSS3 animations without jQuery code.</p>
                </div>
            </div>
        </div>
        <?php endif; ?>
    <?php
    }
    
    /**
     * Save settings page.
     *
     * Store settings page saved details into database.
     *
     * @since 1.0.4
     * @access private
     */
    private function save_license() {
        if( isset( $_POST['goldaddons']['submit'] ) ) {
            
            // Store nonce in variable.
            $nonce = esc_attr( $_POST['goldaddons-settings-nonce'] );
            
            // If nonce not verified return early.
            if( ! wp_verify_nonce( $nonce, 'goldaddons-settings' ) ) {
                return;
            }
            
            // Remove submit from array.
            unset( $_POST['goldaddons']['submit'] );
            
            // Store license details in array.
            $license = isset( $_POST['goldaddons'] ) ? $_POST['goldaddons'] : '';
            
            // Validate License
            License::activate( $license );
        }
    }
    
    /**
	 * Settings page constructor.
	 *
	 * Initializing GoldAddons "Settings" page.
	 *
	 * @since 1.0.4
	 * @access public
	 */
	public function __construct() {
        
        add_action( 'admin_init', [ $this, 'on_admin_init' ] );
		add_action( 'admin_menu', [ $this, 'register_admin_menu' ], 20 );
        
        if( ! class_exists( 'GoldAddons_PRO_for_Elementor' ) ) {
            add_action( 'admin_menu', [ $this, 'register_pro_menu' ], self::MENU_PRIORITY_GO_PRO );
        }
        
        $this->save_license();
    }
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
