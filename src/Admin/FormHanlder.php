<?php

namespace Bera\BeraCarousel\Admin;

use Bera\BeraCarousel\BeraCarousel;
use Bera\BeraCarousel\Helper;

class FormHanlder {

    /**
     * Init hooks
     */
    public function init() {
        add_action( 'admin_post_handle_bera_carousel_crud', array( $this, 'handle_bera_carousel_crud' ) );
    }

    public function notices(  ) {
        ?>
            <div class="notice notice-error">
                Fuck Man error.
            </div>
        <?php
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

            $carousel->validate();
            if( !$carousel->has_error() ) {
                $post_id = $carousel->save();
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
            } else {
                \add_action('admin_notices', array( $this, 'notices' ) );
                wp_redirect( 
                    add_query_arg(
                        array(
                            'page' => 'bera-carousel-add-new',
                            'message' => 'error',
                        ),
                        admin_url() . 'admin.php'
                    )
                );
            }

        } else if( isset( $_REQUEST['update'] ) ) {
            $post_id = $carousel->save();
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
            $post_id = $carousel->delete();
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