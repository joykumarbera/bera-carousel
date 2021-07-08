<div class="form-wrap">
    <form method="POST" action="<?php echo admin_url() . 'admin-post.php' ?>">
        <input type="hidden" name="action" value="handle_bera_carousel_crud">
        <?php 
            if( $mode == 'update' ) {
                include __DIR__ . '/bera-carousel-update.php';
            } else if( $mode == 'add' ) {
                include __DIR__ . '/bera-carousel-add-new.php';
            }
        ?>
    <form>
</div>