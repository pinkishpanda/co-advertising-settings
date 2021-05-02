<?php
/**
 * Plugin Name: Advertising Settings Sidebar
 * Plugin URI: https://claudine.onglab.com/
 * Description: Advertising Settings sidebar for posts block editor.
 * Author: Claudine Ong
 * Author URI: https://claudine.onglab.com/
 */

if( ! defined( 'ABSPATH') ) {
    exit;
}

include_once( 'includes/enqueue.php' );
include_once( 'src/metabox.php' );
