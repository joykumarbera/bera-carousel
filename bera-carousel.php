<?php
/**
 * Bera Carousel
 *
 * Plugin Name: Bera Carousel
 * Plugin URI:  https://wordpress.org/plugins/bera-carousel/
 * Description: Make beautiful image carousel
 * Version:     1.0.0
 * Author:      Joy Kumar Bera
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Requires at least: 4.9
 * Requires PHP: 7.0.0
 */

if( !defined('ABSPATH') ) {
    die;
}

require_once __DIR__ . '/vendor/autoload.php';

use Bera\BeraCarousel\Plugin;
use Bera\BeraCarousel\BeraCarousel;

define( 'BERA_CAROUSEL_PLUGIN_URL',  plugin_dir_url( __FILE__ ) );
define( 'BERA_CAROUSEL_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

add_action('admin_init', 'bera_check_woo');
function bera_check_woo() {
    if ( ! bera_is_woo_active() ) {
        deactivate_plugins(  plugin_basename( __FILE__ ) );
        wp_die('Woocommerce is not active. For Bera Carousel need to work please install woocommerce.');
    }
}

if( bera_is_woo_active() ) {

    add_action('init', 'register_bera_car_post_type');
    function register_bera_car_post_type() {
        BeraCarousel::register_post_type();
    }

    add_shortcode( 'bera-carousel', 'bera_carousel_handler' );
    function bera_carousel_handler( $atts ) {

        $post = get_post( $atts['id'] );

        if( is_null( $post ) ) {
            return;
        }

        $cat_terms = get_post_meta( $post->ID, BeraCarousel::CAROUSEL_META_KEY, true );
        
        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => 11,
            'tax_query' => array(
                'relation' => 'OR',
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id',
                    'terms' =>  $cat_terms
                ),
            ),
        );
        $products = new WP_Query( $args );

        if( $products->have_posts() ) {

            ob_start();
            echo '<div class="owl-carousel">';
            while( $products->have_posts() ) {
                $products->the_post();
                ?>  
                    <div class="bera-carousel-img">
                        <a href="<?php echo get_the_permalink() ?>">
                            <img src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id($products->post), 'woocommerce_thumbnail' )[0]; ?>">
                        </a>
                        <p class="bera-carousel-text"><?php echo get_the_title() ?></p>
                    </div>
                <?php
            }
            wp_reset_postdata();
            echo '</div>';
            
            return ob_get_clean();
        }
    }

    add_action('admin_notices', 'bera_notices');
    function bera_notices() {

        if( isset( $_GET['message'] ) ) {
            if(  $_GET['message'] == 'updated' ) {
                ?>
                    <div class="notice notice-success is-dismissible">
                        <p><?php _e( 'Carousel updated!', 'bera-carousel' ); ?></p>
                    </div>
                <?php
        
            } else if( $_GET['message'] == 'deleted' ) {
                ?>
                    <div class="notice notice-success is-dismissible">
                        <p><?php _e( 'Carousel deleted!', 'bera-carousel' ); ?></p>
                    </div>
                <?php
            } else if( $_GET['message'] == 'added' ) {
                ?>
                    <div class="notice notice-success is-dismissible">
                        <p><?php _e( 'Carousel added!', 'bera-carousel' ); ?></p>
                    </div>
                <?php
            } else if( $_GET['message'] == 'error' ) {
                $errors =  BeraCarousel::get_all_errors();
                if( $errors ) {
                    foreach( $errors as $error ) {
                        ?>
                            <div class="notice notice-success is-dismissible">
                                <p><?php _e( $error, 'bera-carousel' ); ?></p>
                            </div>
                        <?php
                    }
                }
            }
        }
    }

    function bera_carousel_core() {
        return Plugin::getInstance();
    }

    bera_carousel_core()->run();
}

add_action( 'bera_carousel_before_add', 'bera_remove_all_error' );
add_action( 'bera_carousel_before_update', 'bera_remove_all_error' );
function bera_remove_all_error() {
    BeraCarousel::remove_all_error();
}

function bera_is_woo_active() {
    return in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
}

function w_l( $data ) {
    file_put_contents( __DIR__ . '/log.txt', var_export( $data, true ) );
}