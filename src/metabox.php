<?php
/**
 * Registers meta fields.
 */
add_action( 'init', function () {
    register_meta('post', '_co_advertisements', [
        'type'          => 'boolean',
        'single'        => true,
        'show_in_rest'  => true,
        'default'       => 1,
        'auth_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);

    register_meta('post', '_co_commercial_content_type', [
        'type'          => 'string',
        'single'        => true,
        'show_in_rest'  => true,
        'default'       => 'none',
        'auth_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);

    register_meta('post', '_co_advertiser_name', [
        'type'          => 'string',
        'single'        => true,
        'show_in_rest'  => true,
        'sanitize_callback' => 'sanitize_text_field',
        'auth_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
});


/**
 * Adds a meta box fallback for the classic editor.
 */
add_action( 'add_meta_boxes', function() {
    add_meta_box(
        'co_advertising_settings_metabox',
        'Advertising Settings',
        'co_advertising_settings_metabox_html',
        'post',
        'side',
        'default',
        array('__back_compat_meta_box' => true) // hide on block editor
    );
});


/**
 * Renders the meta box fallback on the classic editor.
 * 
 * @param WP_Post $post WP_Post instance
 */
function co_advertising_settings_metabox_html($post) {
    // Get current values
    $use_advertisements = get_post_meta($post->ID, '_co_advertisements', true) === "1";
    $commercial_content_type = get_post_meta($post->ID, '_co_commercial_content_type', true);;
    $advertiser_name = get_post_meta($post->ID, '_co_advertiser_name', true);

    wp_nonce_field('co_advertising_settings_update_post_metabox', 'co_advertising_settings_update_post_nonce');

    // Render form fields
    ?>
    <div class="advertising-settings-metabox">
        <h4>Advertisements</h4>
        <div>
            <input type="checkbox" id="advertisements_on" name="co_advertisements" value="1" <?php echo $use_advertisements ? 'checked' : '' ?>>
            <label for="advertisements_on">Advertisements</label>
        </div>

        <h4>Commercial content type</h4>
        <div>
            <input type="radio" id="commercial_content_none" name="co_commercial_content_type" value="none" <?php echo ($commercial_content_type === 'none') ? 'checked' : ''; ?>>
            <label for="commercial_content_none">None</label>
            <br>

            <input type="radio" id="commercial_content_sponsored" name="co_commercial_content_type" value="sponsored" <?php echo ($commercial_content_type === 'sponsored') ? 'checked' : ''; ?>>
            <label for="commercial_content_sponsored">Sponsored content</label>
            <br>

            <input type="radio" id="commercial_content_partnered" name="co_commercial_content_type" value="partnered" <?php echo ($commercial_content_type === 'partnered') ? 'checked' : ''; ?>>
            <label for="commercial_content_partnered">Partnered content</label>
            <br>

            <input type="radio" id="commercial_content_brought" name="co_commercial_content_type" value="brought-to-you-by" <?php echo ($commercial_content_type === 'brought-to-you-by') ? 'checked' : ''; ?>>
            <label for="commercial_content_brought">Brought to you by</label>
        </div>

        <div>
            <label for="advertiser_name"><h4>Advertiser name</h4></label>
            <input type="text" class="widefat" id="advertiser_name" name="co_advertiser_name" value="<?php echo esc_attr($advertiser_name); ?>">
        </div>
    </div>
    <?php
}


/**
 * Saves the meta fields when the post is saved.
 */
add_action( 'save_post', function($post_id, $post) {
    $can_edit_post = get_post_type_object( $post->post_type )->cap->edit_post;

    // Check capabilities
    if ( !current_user_can( $can_edit_post, $post_id ) ) {
        return;
    }
    if ( !isset( $_POST['co_advertising_settings_update_post_nonce'] ) || !wp_verify_nonce( $_POST['co_advertising_settings_update_post_nonce'], 'co_advertising_settings_update_post_metabox' ) ) {
        return;
    }

    // Update meta values

    if ( array_key_exists('co_advertisements', $_POST) ) {
        update_post_meta(
            $post_id,
            '_co_advertisements',
            $_POST['co_advertisements']
        );
    }

    if ( array_key_exists('co_commercial_content_type', $_POST) ) {
        update_post_meta(
            $post_id,
            '_co_commercial_content_type',
            $_POST['co_commercial_content_type']
        );
    }

    if ( array_key_exists('co_advertiser_name', $_POST) ) {
        update_post_meta(
            $post_id,
            '_co_advertiser_name',
            $_POST['co_advertiser_name']
        );
    }
}, 10, 2 );