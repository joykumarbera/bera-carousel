<h2 class="wp-heading-inline">Add New Carousel</h2>


<div class="form-field form-required term-name-wrap">
	<label for="tag-name">Name</label>
    <input type="text" name="bera_carousel_title" size="30" value="" autocomplete="off" width="25%">
</div>

<div class="form-field form-required term-name-wrap">
    <?php if( !empty( $product_categoires ) ) : ?>
        <label>Choose category</label>
        <select class="bera-woo-multiple-cat" name="bera_carousel_cat[]" multiple="multiple" style="width:45%">>
            <?php foreach( $product_categoires as $cat ) : ?>
                <option value="<?php echo $cat->term_id ?>"><?php echo $cat->name ?></option>
            <?php endforeach ?>
            </select>
        <?php else : ?>
    <?php endif ?>
</div>

<?php submit_button('Add', 'danger', 'add') ?>