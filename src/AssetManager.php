<?php

namespace Bera\BeraCarousel;

/**
 * class AssetManager
 */
class AssetManager 
{
    private $_plugin;

    public function __construct( $plugin ) {
        $this->_plugin = $plugin;
    }

    /**
     * Init hooks
     */
    public function init() {
        add_action('wp_enqueue_scripts', array( $this, 'register_assets' ) );
        add_action('admin_enqueue_scripts', array( $this, 'register_assets' ) );
    }

    /**
     * Register plugin assets
     */
    public function register_assets() {
        if( is_admin() ) {
            $this->load_admin_assets();
        } else {
            $this->load_frontend_assets();
        }
    }

    /**
     * load admin assets
     */
    public function load_admin_assets() {

        if( isset( $_GET['page'] ) ) {
            if( $_GET['page'] ==  $this->_plugin->get_plugin_sub_menu_slug() ) {
                wp_enqueue_script( 'select2-min-js', BERA_CAROUSEL_PLUGIN_URL . 'assets/select2/select2.min.js', [ 'jquery' ], false, true);
                wp_enqueue_style( 'select2-min-css', BERA_CAROUSEL_PLUGIN_URL . 'assets/select2/select2.min.css', [], false );
                wp_enqueue_style( 'bera', BERA_CAROUSEL_PLUGIN_URL . 'assets/css/bera.css', [], false );
                wp_enqueue_script( 'bera-admin', BERA_CAROUSEL_PLUGIN_URL . 'assets/js/bera-admin.js', [ 'jquery' ], false, true);
            }
        }
    }

    /**
     * Load frontend assets
     */
    public function load_frontend_assets() {
        wp_enqueue_style( 'bera-owl-carousel-min-css', BERA_CAROUSEL_PLUGIN_URL . 'assets/owl-carousel/owl.carousel.min.css', [], false );
        wp_enqueue_script( 'bera-owl-carousel-min-js', BERA_CAROUSEL_PLUGIN_URL . 'assets/owl-carousel/owl.carousel.min.js', [ 'jquery' ], false, true);
        wp_enqueue_style( 'bera-main', BERA_CAROUSEL_PLUGIN_URL . 'assets/css/bera-main.css', [], false );
        wp_enqueue_script( 'bera-frontend', BERA_CAROUSEL_PLUGIN_URL . 'assets/js/bera-frontend.js', [ 'jquery' ], false, true);
    }
}