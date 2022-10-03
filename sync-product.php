<?php
/**
 * Plugin Name:       Sync product
 * Description:       To sync product from wordpress to shopify.
 * Version:           0.0.0.1
 * Author:            Codup
 * Author URI:        https://codup.co
 * Text Domain:       Sync-Product
 *
 * @package Sync-Product
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'SP_PLUGIN_DIR' ) ) {
	define( 'SP_PLUGIN_DIR', __DIR__ );
}

if ( ! defined( 'SP_PLUGIN_DIR_URL' ) ) {
	define( 'SP_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'SP_ABSPATH' ) ) {
	define( 'SP_ABSPATH', dirname( __FILE__ ) );
}
	require_once SP_ABSPATH . '/includes/class-sp-loader.php';

