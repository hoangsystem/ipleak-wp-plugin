<?php
/**
 * Plugin Name:       IP Leak WP Plugin
 * Plugin URI:        https://yourwebsite.com/plugins/ipleak-wp-plugin
 * Description:       Display user IP, WebRTC, DNS, device, and browser info for privacy check.
 * Version:           1.0.0
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            Your Name
 * Author URI:        https://yourwebsite.com
 * Text Domain:       ipleak-wp-plugin
 * Domain Path:       /languages
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Define constants
define( 'IPLEAK_WP_VERSION', '1.0.0' );
define( 'IPLEAK_WP_DIR', plugin_dir_path( __FILE__ ) );
define( 'IPLEAK_WP_URL', plugin_dir_url( __FILE__ ) );

// Load text domain for translations
function ipleak_wp_load_textdomain() {
	load_plugin_textdomain( 'ipleak-wp-plugin', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'init', 'ipleak_wp_load_textdomain' );

// Enqueue scripts and styles
function ipleak_wp_enqueue_assets() {
	wp_enqueue_style( 'ipleak-style', IPLEAK_WP_URL . 'assets/style.css', [], IPLEAK_WP_VERSION );
	wp_enqueue_script( 'ipleak-script', IPLEAK_WP_URL . 'assets/script.js', [], IPLEAK_WP_VERSION, true );

	// Localize script for translations and config
	wp_localize_script( 'ipleak-script', 'ipleakWPData', [
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'locale' => get_locale(),
		'labels' => [
			'checking' => __( 'Checking...', 'ipleak-wp-plugin' ),
			'check_again' => __( 'Check Again', 'ipleak-wp-plugin' ),
			'ip_address' => __( 'Public IP Address', 'ipleak-wp-plugin' ),
			'webrtc_ip' => __( 'WebRTC IP', 'ipleak-wp-plugin' ),
			'dns' => __( 'DNS Resolver', 'ipleak-wp-plugin' ),
			'timezone' => __( 'Timezone', 'ipleak-wp-plugin' ),
			'connection' => __( 'Connection Info', 'ipleak-wp-plugin' ),
			'location' => __( 'Location', 'ipleak-wp-plugin' ),
			'os' => __( 'Operating System', 'ipleak-wp-plugin' ),
			'browser' => __( 'Browser', 'ipleak-wp-plugin' ),
			'device' => __( 'Device Type', 'ipleak-wp-plugin' ),
			'safe' => __( 'Safe', 'ipleak-wp-plugin' ),
			'leak_detected' => __( 'Leak Detected!', 'ipleak-wp-plugin' ),
		],
	]);
}
add_action( 'wp_enqueue_scripts', 'ipleak_wp_enqueue_assets' );

// Include shortcode logic
require_once IPLEAK_WP_DIR . 'includes/shortcode.php';

// Clean uninstall
register_uninstall_hook( __FILE__, 'ipleak_wp_uninstall' );
function ipleak_wp_uninstall() {
	// Nothing to clean up: plugin stores no data
}
