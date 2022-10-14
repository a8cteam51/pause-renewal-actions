<?php
/*
 * Plugin Name: Pause Renewal Actions
 * Description: Stops renewal actions for WooCommerce Subscriptions from running
 * Version: 1.0.0
 * Author: WordPress.com Special Projects
 * Author URI: https://wpspecialprojects.wordpress.com
 * Text Domain: pause-renewal-actions
 * License: GPLv3
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Protect against more than one copy of the plugin being activated
if ( defined( 'PAUSE_RENEWAL_ACTIONS_PATH' ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
	deactivate_plugins( plugin_basename( __FILE__ ) );

	function deactivation_admin_notice() {
		$class   = 'notice notice-error';
		$message = __( 'It looks like more than one copy of Pause Renewal Actions is installed, so one has been deactivated.', 'pause-renewal-actions' );
		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
	}
	add_action( 'admin_notices', 'deactivation_admin_notice' );

	return;
}

define( 'PAUSE_RENEWAL_ACTIONS_PATH', plugin_dir_path( __FILE__ ) );
define( 'PAUSE_RENEWAL_ACTIONS_URL', plugin_dir_url( __FILE__ ) );
define( 'PAUSE_RENEWAL_ACTIONS_BASENAME', plugin_basename( __FILE__ ) );

require_once __DIR__ . '/includes/admin.php';


add_action( 'action_scheduler_pre_init', function() {
	if ( 'on' === get_option( 'pause_renewal_actions_toggle' ) ) {
		require_once __DIR__ . '/includes/classes/class-actionscheduler-custom-dbstore.php';
		add_filter( 'action_scheduler_store_class', function( $class ) {
			return 'ActionScheduler_Custom_DBStore';
		}, 101, 1 );
	}
});

