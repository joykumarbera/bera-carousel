<?php

namespace Bera\BeraCarousel;

use Bera\BeraCarousel\Admin\AdminMenu;
use Bera\BeraCarousel\Admin\FormHanlder;

/**
 * class Plugin
 * 
 * @author Joy Kumar Bera
 */
class Plugin 
{
    /**
     * @var string $_plugin_name
     */
    private $_plugin_name;

    /**
     * @var string $_plugin_version
     */
    private $_plugin_version;

    /**
     * @var Plugin $self
     */
    private static $self;

    public function __construct() {
        $this->_plugin_name = 'Bera Carousel';
        $this->_plugin_version = '1.0';
    }

    public static function getInstance() {

        if( is_null( self::$self ) ) {
            self::$self = new self();
        }

        return self::$self;
    }

    public function run() {
        (new AssetManager( $this ))->init();
        (new AdminMenu( $this ))->init();
        (new FormHanlder( $this ) )->init();
    }

    /**
     * Get plugin name
     * 
     * @return string
     */
    public function get_plugin_name() {
        return $this->_plugin_name;
    }

    /**
     * Get plugin version
     * 
     * @return string
     */
    public function get_plugin_version() {
        return $this->_plugin_version;
    }

    /**
     * Get menu page slug
     */
    public function get_plugin_menu_slug() {
        return str_replace(' ', '-', strtolower( $this->_plugin_name ) );
    }

    /**
     * Get sub menu page
     */
    public function get_plugin_sub_menu_slug() {
        return $this->get_plugin_menu_slug() . '-add-new';
    }
}