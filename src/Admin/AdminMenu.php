<?php

namespace Bera\BeraCarousel\Admin;

use Bera\BeraCarousel\BeraCarousel;
use Bera\BeraCarousel\Helper;
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
            $this->_plugin->get_plugin_sub_menu_slug(),
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

        $carousel = BeraCarousel::get_instance([
            'id' => '',
            'title' => '',
            'meta_data' => []
        ]);

        if( isset( $_GET['post_id'] ) ) {
            $carousel = BeraCarousel::find( absint(  $_GET['post_id'] ) );

            if( !$carousel ) {
                return;
            }

            Helper::load_ui( 'bera-carousel-form.php', [
                'mode' => 'update',
                'carousel' => $carousel,
                'categorires' => $carousel->get_product_category_ids(),
                'product_categoires' => $product_categoires
            ] );
        } else {
            Helper::load_ui( 'bera-carousel-form.php', [
                'mode' => 'add',
                'product_categoires' => $product_categoires,
                'carousel' =>  $carousel
            ] );
        }
    }

    public function main_menu_ui() {
        Helper::load_ui( 'bera-carousel.php');
    }

}