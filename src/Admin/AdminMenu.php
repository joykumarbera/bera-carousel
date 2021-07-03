<?php

namespace Bera\BeraCarousel\Admin;

use Bera\BeraCarousel\BeraCarousel;

/**
 * class AdminMenu
 */
class AdminMenu
{
    private $_plugin;

    public function __construct( $plugin ) {
        $this->_plugin = $plugin;
    }

    /**
     * Init hooks
     */
    public function init() {
        add_action('admin_menu', array( $this, 'add_menu' ) );
    }

    public function add_menu() {
        add_menu_page(
            $this->_plugin->get_plugin_name(),
            $this->_plugin->get_plugin_name(),
            'manage_options',
            $this->_plugin->get_plugin_menu_slug(),
            array($this, 'main_menu_ui')
        );

        add_submenu_page(
            $this->_plugin->get_plugin_menu_slug(),
            $this->_plugin->get_plugin_name() . ' add new',
            'Add new',
            'manage_options',
            $this->_plugin->get_plugin_menu_slug() . '-add-new',
            array($this, 'sub_menu_ui')
        );
    }

    public function sub_menu_ui() {

        $product_categoires = get_terms( 
                array(
                'taxonomy' => 'product_cat',
                'hide_empty' => false,
            )
        );

        if( isset( $_GET['post_id'] ) ) {
            $carousel = BeraCarousel::find( absint(  $_GET['post_id'] ) );

            if( !$carousel ) {
                return;
            }

            self::load_ui( 'bera-carousel-form.php', [
                'mode' => 'update',
                'carousel' => $carousel,
                'categorires' => $carousel->get_product_category_ids(),
                'product_categoires' => $product_categoires
            ] );
        } else {
            self::load_ui( 'bera-carousel-form.php', [
                'mode' => 'add',
                'product_categoires' => $product_categoires,
            ] );
        }
    }

    public function main_menu_ui() {
        self::load_ui( 'bera-carousel.php');
    }

    /**
     * Load ui for the admin menu
     * 
     * @param string $file_name
     * @param array $data
     */
    private static function load_ui( $file_name, $data = [] ) {

        $file = BERA_CAROUSEL_PLUGIN_PATH . 'views/' . $file_name;

        if( file_exists( $file ) ) {
            extract( $data );
            ob_start();
            include $file;
            echo ob_get_clean();
        }
    }
}