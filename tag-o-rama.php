<?php
/*
Plugin Name: Tag-o-rama
Description: Add random posts, apply random tags, show results and have fun!
Version:     1.0.0
Author:      Leonardo Rossi
Author URI:  http://leorossi.it
License:     MIT
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

define( 'TAGORAMA_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'TAGORAMA_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

// Activation/deactivation hooks
register_activation_hook( __FILE__, array( 'Tagorama', 'plugin_activate' ) );
register_deactivation_hook( __FILE__, array( 'Tagorama', 'plugin_deactivate' ) );

require_once( TAGORAMA_PLUGIN_DIR . 'class.tagorama.php' );

// Init PLugin
add_action('init', array('Tagorama', 'init'));


// Handle form button
if (isset($_POST['generate_posts'])) {
    add_action('wp_loaded', array('Tagorama', 'generate_new_posts'));
}

// Handle Ajax Calls from the Chart
add_action('wp_ajax_nopriv_do_ajax', array('Tagorama', 'get_stats_ajax'));
add_action('wp_ajax_do_ajax', array('Tagorama', 'get_stats_ajax'));
