<?php

namespace Bera\BeraCarousel\Admin;

class FormHanlder {

    /**
     * Init hooks
     */
    public function init() {
        add_action( 'admin_post_handle_bera_carousel_crud', array( $this, 'handle_bera_carousel_crud' ) );
    }

    public function handle_bera_carousel_crud() {

        if( isset( $_REQUEST['add'] ) ) {
            $post_id = wp_insert_post( 
                    array(
                    'post_title' => $_POST['bera_carousel_title'],
                    'post_type' => 'bera_carousel'
                )
            );

            if( $post_id ) {
                update_post_meta(
                    $post_id,
                    '_bera_carousel_cat_id',
                    $_POST['bera_carousel_cat']
                );

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
            }
        } else if( isset( $_REQUEST['update'] ) ) {
            $post_id = wp_update_post( 
                    array(
                    'ID' => $_POST['post_id'],
                    'post_title' => $_POST['bera_carousel_title'],
                    'post_type' => 'bera_carousel'
                )
            );

            if( $post_id ) {

                update_post_meta(
                    $post_id,
                    '_bera_carousel_cat_id',
                    $_POST['bera_carousel_cat']
                );
    
    
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

            }
        } else if( isset( $_REQUEST['delete'] ) ) {
            
            $post = wp_delete_post( $_POST['post_id']  );

            if( $post ) {
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