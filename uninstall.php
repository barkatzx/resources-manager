<?php
/**
 * Preserve resource content when the plugin is removed.
 *
 * Resource posts and metadata are user content and are intentionally retained.
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
