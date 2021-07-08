<?php

namespace Bera\BeraCarousel\Admin;

use Bera\BeraCarousel\BeraCarousel;

class FormHanlder {

    private $plugin;

    public function  __construct( $plugin ) {
        $this->plugin = $plugin;
    }

    /**
     * Init hooks
     */
    public function init() {
        add_action( 'admin_post_handle_bera_carousel_crud', array( $this, 'handle_bera_carousel_crud' ) );
    }

    public function handle_bera_carousel_crud() {
        
        $carousel = BeraCarousel::get_instance(
            array(
                'id' => ( isset( $_POST['post_id'] ) ) ?  $_POST['post_id'] : '',
                'title' => ( isset( $_POST['bera_carousel_title'] ) ) ?  $_POST['bera_carousel_title'] : '',
                'meta_data' => ( isset( $_POST['bera_carousel_cat'] ) ) ?  $_POST['bera_carousel_cat'] : []
            )
        );

        if( isset( $_REQUEST['add'] ) ) {
            $this->add( $carousel );
        } else if( isset( $_REQUEST['update'] ) ) {
            $this->update( $carousel );
        } else if( isset( $_REQUEST['delete'] ) ) {
            $this->delete( $carousel );
        }
    }

    /**
     * Add carousel
     * 
     * @param BeraCarousel $carousel
     */
    private function add( BeraCarousel $carousel ) {

        do_action( 'bera_carousel_before_add' );

        $carousel->validate();
        if( !$carousel->has_error() ) {
            $post_id = $carousel->save();
            return $this->bera_redirect( [
                'page' => $this->plugin->get_plugin_sub_menu_slug(),
                'post_id' => $post_id,
                'message' => 'added',
            ] );
        }

        $this->bera_redirect( [
            'page' => $this->plugin->get_plugin_sub_menu_slug(),
            'message' => 'error',
        ] );
    }

    /**
     * Update carousel
     * 
     * @param BeraCarousel $carousel
     */
    private function update( BeraCarousel $carousel  ) {

        do_action( 'bera_carousel_before_update' );

        $carousel->validate();

        if( !$carousel->has_error() ) {
            $post_id = $carousel->save();

            return $this->bera_redirect( [
                'page' => $this->plugin->get_plugin_sub_menu_slug(),
                'post_id' => $post_id,
                'message' => 'updated'
            ] );
        } 
        
        $this->bera_redirect( [
            'page' => $this->plugin->get_plugin_sub_menu_slug(),
            'post_id' => $_POST['post_id'],
            'message' => 'error'
        ] );
    }

    /**
     * Delete carousel
     * 
     * @param BeraCarousel $carousel
     */
    private function delete( BeraCarousel $carousel ) {
        $post_id = $carousel->delete();
        if( $post_id ) {
            $this->bera_redirect( [
                'page' => $this->plugin->get_plugin_menu_slug(),
                'message' => 'deleted'
            ] );
        }
    }

    /**
     * Custom redirect
     * 
     * @param array $query_params
     */
    private function bera_redirect( $query_params ) {
        wp_redirect( 
            add_query_arg(
                $query_params,
                admin_url() . 'admin.php'
            )
        );
    }
}