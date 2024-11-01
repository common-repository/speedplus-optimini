<?php
/**
 * SpeedPlus OptiMini
 * Uninstall and remove database options
 */
 
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

global $wpdb;

require_once ABSPATH . '/wp-admin/includes/plugin.php';


$plugin_way = 'speedplus-optimini/speedplus-optimini.php';

if ( is_plugin_active( $plugin_way ) ) {
	if ( is_multisite() && is_plugin_active_for_network( $plugin_way ) ) {
		deactivate_plugins( $plugin_way, false, true );
	} else {
		deactivate_plugins( $plugin_way );
	}
}

delete_plugins( array( $plugin_way ) );

function uninstall() {
	global $wpdb;
	$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name = 'speedplus_optimini_plugin_options';" );
	$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE 'speedplus_optimini_%';" );

}

if ( is_multisite() ) {
	global $wpdb, $wp_version;

	$wpdb->query( "DELETE FROM {$wpdb->sitemeta} WHERE meta_key LIKE 'speedplus_optimini_%';" );

	$blogs = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );

	if ( ! empty( $blogs ) ) {
		foreach ( $blogs as $id ) {

			switch_to_blog( $id );

			uninstall();

			restore_current_blog();
		}
	}
} else {
	uninstall();
}