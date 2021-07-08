<input type="hidden" name="post_id" value="<?php echo $carousel->get_id() ?>">

<h2 class="wp-heading-inline">Update Carousel - <?php echo $carousel->get_title() ?></h2>

<div class="form-field form-required term-name-wrap">
	<label for="tag-name">Name</label>
    <input type="text" name="bera_carousel_title" value="<?php echo $carousel->get_title() ?>">
</div>

<div class="form-field form-required term-name-wrap">
    <?php if( !empty( $product_categoires ) ) : ?>
        <label>Choose category</label>
        <select class="bera-woo-multiple-cat" name="bera_carousel_cat[]" multiple="multiple" style="width:45%">>
            <?php foreach( $product_categoires as $cat ) : ?>
                <option value="<?php echo $cat->term_id ?>" <?php echo ( in_array( $cat->term_id, (array)$categorires ) ) ? 'selected': '' ?>><?php echo $cat->name ?></option>
            <?php endforeach ?>
            </select>
        <?php else : ?>
    <?php endif ?>
</div>

<?php submit_button('Update', 'primary', 'update') ?>
<?php submit_button('Delete', 'danger', 'delete') ?>