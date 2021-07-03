<h1 class="wp-heading-inline">Add New Carousel</h1>

<div id="poststuff">
    <div id="post-body">
        <div id="post-body-content">

        <div id="titlediv">
            <div id="titlewrap">
                <input type="text" name="bera_carousel_title" size="30" value="" autocomplete="off">
            </div>
        </div>

        <div class="c-b-fiels">
            <?php if( !empty( $product_categoires ) ) : ?>
                <label>Choose category</label>
                <select class="bera-woo-multiple-cat" name="bera_carousel_cat[]" multiple="multiple">
                    <?php foreach( $product_categoires as $cat ) : ?>
                        <option value="<?php echo $cat->term_id ?>"><?php echo $cat->name ?></option>
                    <?php endforeach ?>
                </select>
            <?php else : ?>
            <?php endif ?>
        </div>

        </div>
        <div id="postbox-container-1" class="postbox-container">    
            <?php submit_button('Add', 'danger', 'add') ?>
        </div>
    </div>
</div>


