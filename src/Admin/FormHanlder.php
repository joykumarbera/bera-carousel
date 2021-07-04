<?php

namespace Bera\BeraCarousel\Admin;

use Bera\BeraCarousel\BeraCarousel;

class FormHanlder {

    /**
     * Init hooks
     */
    public function init() {
        add_action( 'admin_post_handle_bera_carousel_crud', array( $this, 'handle_bera_carousel_crud' ) );
    }

    public function handle_bera_carousel_crud() {

        $bera_carousel =BeraCarousel::get_instance(
            array(
                'id' => ( isset( $_POST['post_id'] ) ) ?  $_POST['post_id'] : '',
                'title' => $_POST['bera_carousel_title'],
                'meta_data' => $_POST['bera_carousel_cat']
            )
        );

        if( isset( $_REQUEST['add'] ) ) {
            $post_id = $bera_carousel->save();
            wp_redirect( 
                add_query_arg(
                    array(
                        'page' => 'bera-carousel-add-new',
                        'post_id' => $post_id,
                        'message' => 'added',
                    ),
                    admin_url() . 'admin.php'
                )
            );
        } else if( isset( $_REQUEST['update'] ) ) {
            $post_id = $bera_carousel->save();
            wp_redirect( 
                add_query_arg(
                    array(
                        'page' => 'bera-carousel-add-new',
                        'post_id' => $post_id,
                        'message' => 'updated',
                    ),
                    admin_url() . 'admin.php'
                )
            );

        } else if( isset( $_REQUEST['delete'] ) ) {
            $post_id = $bera_carousel->delete();
            if( $post_id ) {
                wp_redirect( 
                    add_query_arg(
                        array(
                            'page' => 'bera-carousel',
                            'message' => 'deleted'
                        ),
                        admin_url() . 'admin.php'
                    )
                );
            }
        }
    }
}