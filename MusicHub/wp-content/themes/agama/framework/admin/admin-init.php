<?php
/**
 * Admin Setup Class
 *
 * Setup Agama backend.
 *
 * @since 1.0.0
 */

namespace Agama\Admin;

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Setup {
    
    /**
     * Instance
     *
	 * Single instance of this object.
	 *
	 * @since 1.0.0
	 * @access public
	 * @var null|object
	 */
	public static $instance = null;
    
    /**
     * Get Instance
     *
	 * Access the single instance of this class.
	 *
     * @since 1.0.0
     * @access public
	 * @return object
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
    
    /**
     * Class Constructor
     */
    function __construct() {
        
        add_action( 'admin_notices', [ $this, 'admin_notices' ] );
        
        $this->get_template_parts();
        
    }
    
    /**
     * Admin Notices
     *
     * The Agama admin notices.
     *
     * @since 1.4.52
     * @access public
     * @return mixed
     */
    public function admin_notices() { 
        if( isset( $_GET['action'] ) && 'dismiss-agama-notice' == $_GET['action'] ) {
            update_option( '_AgamaNoticeDismissed', true );
        } ?>
        <?php if( ! get_option( '_AgamaNoticeDismissed' ) ) : ?>
        <div class="notice notice-success is-dismissable">
            <p><?php esc_html_e( 'Hello from Agama team :). If you are planning to upgrade the Agama theme to Agama PRO this is the best timing. You can use next coupon code', 'agama' ); ?> <strong>promo20</strong> <?php esc_html_e( 'and you will get 20% off per order.', 'agama' ); ?> <a href="https://theme-vision.com/agama-pro/" class="button button-primary" target="_blank"><?php esc_html_e( 'Order Now', 'agama' ); ?></a> <br><?php esc_html_e( 'Or if you are satisfied with the free version of Agama theme you can help us to rank theme higher by rating Agama theme', 'agama' ); ?> <a href="https://wordpress.org/support/theme/agama/reviews/?filter=5" class="button button-secondary" target="_blank"><?php esc_html_e( 'Rate Now', 'agama' ); ?></a><br><a href="?action=dismiss-agama-notice" class="button button-secondary"><?php esc_html_e( 'Do not show again !', 'agama' ); ?></a></p>
        </div>
        <?php
        endif;
    }
    
    /**
     * Get Template Part
     *
     * Include all template parts for backend.
     *
     * @since 1.0.0
     * @access private
     * @return void
     */
    private function get_template_parts() {
        get_template_part( 'framework/admin/animate' );
        get_template_part( 'framework/admin/kirki/kirki' );
        get_template_part( 'framework/admin/customizer' );
        get_template_part( 'framework/admin/about' );
    }
    
}

Setup::get_instance();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
