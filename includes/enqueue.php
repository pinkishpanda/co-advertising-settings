<?php
/**
 * Registers script and styles to be used in the block editor.
 */
add_action( 'enqueue_block_editor_assets', function() {
    wp_enqueue_script(
        'co-sidebar',
        plugins_url( '../build/index.js', __FILE__ ),
        array( 'wp-components', 'wp-compose', 'wp-data', 'wp-edit-post', 'wp-i18n', 'wp-plugins' ),
        filemtime( dirname( __FILE__ ) . '/../build/index.js' )
    );

    wp_enqueue_style(
        'co-sidebar-styles',
        plugins_url( '../build/index.css', __FILE__ ),
        array(),
        filemtime( dirname( __FILE__ ) . '/../build/index.css' )
    );
} );