<?php
/*
 Plugin Name: Gold Addons for Elementor
 Plugin URI: https://goldaddons.com/
 Description: Gold Addons plugin extends elementor widgets with many new & fresh widgets.
 Version: 1.0.7
 Author: GoldAddons
 Author URI: https://goldaddons.com/pricing/
 License: GPLv3
 Text Domain: gold-addons-for-elementor
*/

// Exit if accessed directly.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * GoldAddons_For_Elementor
 *
 * @since 1.0.0
 */
final class GoldAddons_for_Elementor {
    
    /**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.7';
    
    /**
     * Plugin Development
     *
     * @since 1.0.0
     * @var string The plugin development mode.
     */
    const DEVELOPMENT = false;
    
    /**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';
    
    /**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '5.6';
    
    /**
	 * Instance
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 * @static
	 *
	 * @var GoldAddons_For_Elementor The single instance of the class.
	 */
	private static $_instance = null;
    
    /**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 * @return GoldAddons_For_Elementor An instance of the class.
	 */
    public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}
    
    /**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
    public function __construct() {
        
        if( self::DEVELOPMENT ) {
            $this->version = esc_attr( uniqid() );
        } else {
            $this->version = self::VERSION;
        }
        
		add_action( 'init', [ $this, 'i18n' ] );
		add_action( 'plugins_loaded', [ $this, 'init' ] );

	}
    
    /**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 * @access public
	 */
    public function i18n() {

		load_plugin_textdomain( 'gold-addons-for-elementor' );

	}
    
    /**
	 * Initialize the plugin
	 *
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed load the files required to run the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 * @access public
	 */
    public function init() {
        // Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}
        
        // Define Plugin Version
        if( ! defined( 'GOLDADDONS_VERSION' ) ) {
            define( 'GOLDADDONS_VERSION', $this->version );
        }
        
        // Define Plugin Basename
        if( ! defined( 'GOLDADDONS_BASENAME' ) ) {
            define( 'GOLDADDONS_BASENAME', plugin_basename( __FILE__ ) );
        }
        
        // Define Plugin DIR
        if( ! defined( 'GOLDADDONS_DIR' ) ) {
            define( 'GOLDADDONS_DIR', plugin_dir_path( __FILE__ ) . '/' );
        }
        
        // Define Plugin URI
        if( ! defined( 'GOLDADDONS_URI' ) ) {
            define( 'GOLDADDONS_URI', plugin_dir_url( __FILE__ ) . '/' );
        }
        
        // Include admin.php file.
        if( is_admin() ) {
            require_once( __DIR__ . '/core/admin/admin.php' );
        }
        
        // Include functions.php file.
        require_once( __DIR__ . '/includes/functions.php' );
        
        // Initialize Widgets
        add_action('elementor/init', [ $this, 'init_widgets' ] );
        
        // Editor style
        add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'editor_style' ] );
        
        // Register Widget Styles
        add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'widget_styles' ] );
        
        // Register Widget Scripts
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );

		// Register Widgets
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
		// add_action( 'elementor/controls/controls_registered', [ $this, 'init_controls' ] );
    }
    
    /**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 * @access public
	 */
    public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'gold-addons-for-elementor' ),
			'<strong>' . esc_html__( 'GoldAddons Plugin', 'gold-addons-for-elementor' ) . '</strong>',
			'<a href="'. admin_url() .'plugin-install.php?tab=plugin-information&plugin=elementor&TB_iframe=true&width=772&height=624" class="thickbox open-plugin-details-modal"><strong>' . esc_html__( 'Elementor Plugin', 'gold-addons-for-elementor' ) . '</strong></a>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}
    
    /**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
    public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'gold-addons-for-elementor' ),
			'<strong>' . esc_html__( 'GoldAddons Plugin', 'gold-addons-for-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'gold-addons-for-elementor' ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

    /**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'gold-addons-for-elementor' ),
			'<strong>' . esc_html__( 'GoldAddons Plugin', 'gold-addons-for-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'gold-addons-for-elementor' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}
    
    /**
     * Register Editor Style
     *
     * Include editor styling file.
     *
     * @since 1.0.0
     * @access public
     */
    public function editor_style() {
     
        wp_enqueue_style( 'goldaddons-editor', plugins_url( 'assets/css/editor.css', __FILE__ ), array(), $this->version );
        
    }
    
    /**
     * Register Widgets Styles
     *
     * Include widgets styling files.
     *
     * @since 1.0.0
     * @access public
     */
    public function widget_styles() {
        
        wp_enqueue_style( 'goldaddons-bs', plugins_url( 'assets/css/bootstrap.css', __FILE__ ), array(), $this->version );
		wp_enqueue_style( 'goldaddons-widgets', plugins_url( 'assets/css/goldaddons.css', __FILE__ ), array(), $this->version );
        
	}
    
    /**
     * Register Widgets Scripts
     *
     * Include widgets scripts files.
     *
     * @since 1.0.0
     * @access public
     */
    public function widget_scripts() {

        wp_enqueue_script( 'goldaddons-vendor', plugins_url( 'assets/js/vendor.js', __FILE__ ), [ 'jquery' ], $this->version );
		wp_enqueue_script( 'goldaddons-widgets', plugins_url( 'assets/js/goldaddons.js', __FILE__ ), [ 'jquery' ], $this->version );
        
	}
    
    /**
	 * Init Widgets
	 *
	 * Include widgets files and register them.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function init_widgets() {

		// Include Widget files
        require_once( __DIR__ . '/widgets/blog.php' );
        require_once( __DIR__ . '/widgets/image-carousel.php' );
        require_once( __DIR__ . '/widgets/modal.php' );
        require_once( __DIR__ . '/widgets/price.php' );
        require_once( __DIR__ . '/widgets/team.php' );

		// Register widgets
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \GoldAddons\Widget_Blog() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \GoldAddons\Widget_Image_Carousel() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \GoldAddons\Widget_Modal() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \GoldAddons\Widget_Price_Box() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \GoldAddons\Widget_Team() );
        
	}
    
    /**
	 * Init Controls
	 *
	 * Include controls files and register them
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function init_controls() { }
    
}
GoldAddons_for_Elementor::instance();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
