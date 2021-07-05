<?php

namespace Bera\BeraCarousel;

/**
 * class Helper
 */
class Helper
{
    /**
     * Load ui for the admin menu
     * 
     * @param string $file_name
     * @param array $data
     */
    public static function load_ui( $file_name, $data = [] ) {

        $file = BERA_CAROUSEL_PLUGIN_PATH . 'views/' . $file_name;

        if( file_exists( $file ) ) {
            extract( $data );
            ob_start();
            include $file;
            echo ob_get_clean();
        }
    }
}