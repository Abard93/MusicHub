<?php

namespace GoldAddons;

// Exit if accessed directly.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * GoldAddons Plugin License.
 *
 * GoldAddons license handler.
 *
 * @since 1.0.4
 */
class License {
    
    /**
     * API URL
     *
     * @since 1.0.4
     * @access private
     */
    private static $url = 'https://goldaddons.com/wp-admin/admin-ajax.php';
    
    /**
     * Store Code
     *
     * @since 1.0.4
     * @access private
     */
    private static $store = '4Cdj75YXAXZ38l2';
    
    /**
     * License Validate
     *
     * @since 1.0.4
     * @access public
     */
    public static function validate( $license ) {
        $aid = unserialize( get_option( '_goldaddons_license' ) );
        
        if( $aid ) {
            $aid = $aid['activation_id'];
        }
        
        $params = add_query_arg(
            array(
                'action'        => 'license_key_validate',
                'store_code'    => esc_attr( self::$store ),
                'sku'           => esc_attr( $license['sku'] ),
                'license_key'   => esc_attr( $license['key'] ),
                'activation_id' => esc_attr( $aid ),
                'domain'        => esc_url( $_SERVER['SERVER_NAME'] )
            ), self::$url
        );
        
        $response   = wp_remote_get( $params );
        $json       = json_decode( wp_remote_retrieve_body( $response ), true );
        $data       = $json['data'];
        
        return $data;
    }
    
    /**
     * License Activate
     *
     * @since 1.0.4
     * @access public
     */
    public static function activate( $license ) {
        $params = add_query_arg(
            array(
                'action'        => 'license_key_activate',
                'store_code'    => esc_attr( self::$store ),
                'sku'           => esc_attr( $license['sku'] ),
                'license_key'   => esc_attr( $license['key'] ),
                'domain'        => esc_url( $_SERVER['SERVER_NAME'] )
            ), self::$url
        );
        
        /**
         * Do not allow multiple activation 
         * instances for current domain.
         *
         * Deactivate already activated key before activating new one.
         */
        self::deactivate();
        
        /**
         * Activate license key.
         */
        self::response( $license, $params );
    }
    
    /**
     * License Deactivate
     *
     * @since 1.0.4
     */
    public static function deactivate() {
        $option = unserialize( get_option( '_goldaddons_license' ) );
        $activation_id = isset( $option['activation_id'] ) ? esc_attr( $option['activation_id'] ) : '';
        
        if( ! empty( $activation_id ) ) {
            $params = add_query_arg(
                array(
                    'action'        => 'license_key_deactivate',
                    'store_code'    => esc_attr( self::$store ),
                    'sku'           => esc_attr( $option['sku'] ),
                    'license_key'   => esc_attr( $option['key'] ),
                    'domain'        => esc_url( $_SERVER['SERVER_NAME'] ),
                    'activation_id' => esc_attr( $activation_id )
                ), self::$url
            );
            
           $response = wp_remote_get( $params );
        }
    }
    
    /**
     * API Response
     *
     * @since 1.0.4
     * @access private
     */
    private static function response( $license, $params ) {
        $response   = wp_remote_get( $params );
        $json       = json_decode( wp_remote_retrieve_body( $response ), true ); // array()
        $error      = isset( $json['error'] ) ? esc_attr( $json['error'] ) : ''; // true | false
        $data       = isset( $json['data'] ) ? $json['data'] : ''; // array()
        
        if( $error ) {
            foreach( $json['errors'] as $key => $value ) {
                $license['message'] = $value[0];
            }
        } else { // If there is not errors.
            if( ! $error ) {
                $license['activation_id']   = isset( $data['activation_id'] ) ? esc_attr( $data['activation_id'] ) : '';
                $license['message']         = isset( $json['message'] ) ? esc_html( $json['message'] ) : '';
                $license['status']          = isset( $data['status'] ) ? esc_attr( $data['status'] ) : '';
            }
        }
        
        update_option( '_goldaddons_license', serialize( $license ) );
    }
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
