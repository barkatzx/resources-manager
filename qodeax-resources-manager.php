<?php
/**
 * Plugin Name: Qodeax Resources Manager
 * Description: Manage and display unlimited resources on WordPress websites.
 * Version: 1.0.0
 * Author: Barkat Ullah
 * Author URI: https://qodeax.com
 * Text Domain: qodeax-resources-manager
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package Qodeax_Resources_Manager
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'QRM_VERSION', '1.0.0' );
define( 'QRM_PLUGIN_FILE', __FILE__ );
define( 'QRM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'QRM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once QRM_PLUGIN_DIR . 'includes/class-qrm-post-type.php';
require_once QRM_PLUGIN_DIR . 'includes/class-qrm-fields.php';
require_once QRM_PLUGIN_DIR . 'includes/class-qrm-shortcode.php';

/** Register plugin features. */
function qrm_init_plugin() {
	QRM_Post_Type::init();
	QRM_Fields::init();
	QRM_Shortcode::init();
}
add_action( 'plugins_loaded', 'qrm_init_plugin' );

/** Flush rewrite rules when the post type is first registered. */
function qrm_activate_plugin() {
	QRM_Post_Type::register_post_type();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'qrm_activate_plugin' );

/** Flush rewrite rules after the post type is no longer registered. */
function qrm_deactivate_plugin() {
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'qrm_deactivate_plugin' );
