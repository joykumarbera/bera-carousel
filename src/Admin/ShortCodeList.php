<?php

namespace Bera\BeraCarousel\Admin;

use Bera\BeraCarousel\BeraCarousel;

class ShortCodeList extends Bera_WP_List_Table
{
    public function __construct()
    {
        parent::__construct( array(
            'singular' => 'bera-carousel',
            'plural'   => 'bera-carousels',
            'ajax'     => false
        ) );
        $this->prepare_items();
        $this->display();
    }

    protected function handle_row_actions( $item, $column_name, $primary ) {
        
        if ( $column_name !== $primary ) {
			return '';
		}   

        $link = add_query_arg(
            array(
                'post_id' => $item->get_id(),
            ),
            menu_page_url( 'bera-carousel-add-new', false )
        );
        $edit_link = sprintf('<a href="%s">%s</a>', $link, 'Edit');

        $actions = array(
            'edit' => $edit_link
        );

        return $this->row_actions( $actions );
	}

    public function get_columns(){
        $columns = array(
            'cb'        => '<input type="checkbox" />',
            'name' => 'Name',
            'shortcode'    => 'Shortcode',
            'date_published'      => 'Date Published',
        );
        return $columns;
    }

    public function column_cb( $item ) {
        return sprintf( 
            '<input type="checkbox" name="%s[]" value="%s">',
            $this->_args['singular'],
            $item->get_id() 
        );
    }

    public function column_name( $item ) {
        $edit_link =  add_query_arg(
            array(
                'post_id' => $item->get_id(),
            ),
            menu_page_url( 'bera-carousel-add-new', false )
        );
        $name = sprintf(
            '<a class="row-title" href="%s" >%s</a>',
            $edit_link,
            $item->get_title()
        );

        return $name;
    }

    public function column_shortcode( $item ) {
        return $item->get_shortcode();
    }

    public function column_date_published( $item ) {
        return $item->get_date_published();
    }

    public function column_default( $item, $column_name ) {
        return '';
    }

    protected function get_bulk_actions() {
		$actions = array(
			'delete' => 'Delete',
		);

		return $actions;
	}

    public function prepare_items() {
        
        $args = array(
            'post_type' => 'bera_carousel',
            'posts_per_page' => 5,
            'offset' => ( $this->get_pagenum() - 1 ) * 5
        );
        $this->items = BeraCarousel::find_by( $args );

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);
       
        $this->set_pagination_args( array(
			'total_items' => BeraCarousel::get_total_set(),
			'per_page' => 5
		) );
    }
}