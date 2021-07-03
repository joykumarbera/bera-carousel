<?php

namespace Bera\BeraCarousel;

/**
 * class BeraCarousel
 */
class BeraCarousel {
    
    const POST_TYPE = 'bera_carousel';
    const CAROUSEL_META_KEY = '_bera_carousel_cat_id';

    /**
     * @var int $id
     */
    private $id;

    /**
     * @var string $title
     */
    private $title;

    /**
     * @var array $meta_data
     */
    private $meta_data;

    /**
     * @var int $_total_data
     */
    private static $_total_data;

    /**
     * Constructor 
     * 
     * @param array $data
     */
    private function __construct( $data ) {
        $this->id = $data['id'];
        $this->title = $data['title'];
        $this->meta_data = $data['meta_data'];
    }

    /**
     * Check if model is new or not
     * 
     * @return bool
     */
    public function is_new() {

        return ( !is_null( $this->id ) && $this->id != ''  ) ? true : false;
    }

    /**
     * Register post type
     */
    public static function register_post_type() {
        $args = array(
            'public'    => false,
            'supports'  => array( 'title' ),
        
        );
        register_post_type( self::POST_TYPE, $args );
    }

    /**
     * Get shortcode id
     * 
     * @return int
     */
    public function get_id() {
        return $this->id;
    }

    /**
     * Get title
     * 
     * @param string
     */
    public function get_title() {
        return $this->title;
    }

    /**
     * Get shortcode name
     * 
     * @return string
     */
    public function get_shortcode() {
        $shortcode = sprintf( '[bera-carousel id=%d]', $this->id );

        return $shortcode;
    }

    /**
     * Get publish date
     * 
     * @return string
     */
    public function get_date_published() {
        return get_the_date( 'D M j, Y', $this->id );
    }

    /**
     * Get product category ids
     * 
     * @return array
     */
    public function get_product_category_ids() {
        return $this->meta_data;
    }

    /**
     * Get new instance of BeraCarousel
     * 
     * @param int $id
     * @return mixed
     */
    public static function find( $id ) {
        
        $post = get_post( $id );

        if( !$post ) {
            return;
        }

        $meta_data = self::get_carousel_meta_data( $post->ID );

        $data = array(
            'id' => $post->ID,
            'title' => $post->post_title,
            'meta_data' => $meta_data
        );

        return new self( $data );
    }

    public static function get_total_set() {
        return self::$_total_data;
    }

    public static function find_by( $args ) {
        
        $data_sets = [];

        $query = new \WP_Query( $args );

        self::$_total_data = $query->found_posts;
        while( $query->have_posts() ) {
            $query->the_post();
            $data_sets[] = new self(
                    array(
                    'id' => $query->post->ID,
                    'title' => $query->post->post_title,
                    'meta_data' => self::get_carousel_meta_data( get_the_ID() )
                ) 
            );
        }

        return $data_sets;
    }

    /**
     * Get metadata
     * 
     * @param int $id
     * @return array|false
     */
    public static function get_carousel_meta_data( $id ) {
        return get_post_meta( $id, self::CAROUSEL_META_KEY, true);
    }
}