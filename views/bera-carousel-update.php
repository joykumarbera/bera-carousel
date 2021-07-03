<input type="hidden" name="post_id" value="<?php echo $carousel->get_id() ?>">
<div class="c-b-fiels">
    <label>Enter Name</label>
    <input type="text" name="bera_carousel_title" value="<?php echo $carousel->get_title() ?>">
</div>

<div class="c-b-fiels">
    <?php if( !empty( $product_categoires ) ) : ?>
        <label>Choose category</label>
        <select class="bera-woo-multiple-cat" name="bera_carousel_cat[]" multiple="multiple">
            <?php foreach( $product_categoires as $cat ) : ?>
                <option value="<?php echo $cat->term_id ?>" <?php echo ( in_array( $cat->term_id, $categorires ) ) ? 'selected': '' ?>><?php echo $cat->name ?></option>
            <?php endforeach ?>
        </select>
    <?php else : ?>
    <?php endif ?>
</div>
<?php submit_button('Update', 'primary', 'update') ?>
<?php submit_button('Delete', 'danger', 'delete') ?>