<?php
/**
 * Give Display Donors
 *
 * @package     Give
 * @copyright   Copyright (c) 2016, WordImpress
 * @license     https://opensource.org/licenses/gpl-license GNU Public License
 * @since       1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Give Display Donors Activation Banner
 *
 * Includes and initializes Give activation banner class.
 *
 * @since 1.0
 */
function givedd_activation_banner() {

	// Check for if give plugin activate or not.
	$is_give_active = defined( 'GIVE_PLUGIN_BASENAME' ) ? is_plugin_active( GIVE_PLUGIN_BASENAME ) : false;

	// Check to see if Give is activated, if it isn't deactivate and show a banner.
	if ( is_admin() && current_user_can( 'activate_plugins' ) && ! $is_give_active ) {

		add_action( 'admin_notices', 'givedd_give_inactive_notice' );

		// Don't let this plugin activate.
		deactivate_plugins( GIVEDD_BASENAME );

		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		return false;
	}

	// Minimum Give version required for this plugin to work.
	if ( version_compare( GIVE_VERSION, GIVEDD_MIN_GIVE_VER, '<' ) ) {

		add_action( 'admin_notices', 'givedd_give_version_notice' );

		// Don't let this plugin activate.
		deactivate_plugins( GIVEDD_BASENAME );

		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		return false;
	}

	// Check for activation banner inclusion.
	if ( ! class_exists( 'Give_Addon_Activation_Banner' )
		&& file_exists( GIVE_PLUGIN_DIR . 'includes/admin/class-addon-activation-banner.php' ) ) {

		include GIVE_PLUGIN_DIR . 'includes/admin/class-addon-activation-banner.php';

		// Only runs on admin.
		$args = array(
			'file'              => __FILE__,
			'name'              => esc_html__( 'Display Donors', 'givedd' ),
			'version'           => GIVEDD_VERSION,
			'settings_url'      => admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=addons' ),
			'documentation_url' => 'https://givewp.com/documentation/add-ons/display-donors/',
			'support_url'       => 'https://givewp.com/support/',
			'testing'           => false, // Never leave true.
		);

		new Give_Addon_Activation_Banner( $args );

	}

	return false;
}

add_action( 'admin_init', 'givedd_activation_banner' );

/**
 * Notice for No Core Activation
 *
 * @since 1.3.3
 */
function givedd_give_inactive_notice() {
	echo '<div class="error"><p>' . __( '<strong>Activation Error:</strong> You must have the <a href="https://givewp.com/" target="_blank">Give</a> plugin installed and activated for the MailChimp add-on to activate.', 'give-mailchimp' ) . '</p></div>';
}

/**
 * Notice for min. version violation.
 *
 * @since 1.3.3
 */
function givedd_give_version_notice() {
	echo '<div class="error"><p>' . sprintf( __( '<strong>Activation Error:</strong> You must have <a href="%1$s" target="_blank">Give</a> version %2$s+ for the Display Donors Add-on to activate.', 'givedd' ), 'https://givewp.com', GIVEDD_MIN_GIVE_VER ) . '</p></div>';
}


/**
 * Plugins row action links
 *
 * @since 1.3.3
 *
 * @param array $actions An array of plugin action links.
 *
 * @return array An array of updated action links.
 */
function givedd_plugin_action_links( $actions ) {
	$new_actions = array(
		'settings' => sprintf(
			'<a href="%1$s">%2$s</a>',
			admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=addons' ),
			esc_html__( 'Settings', 'givedd' )
		),
	);

	return array_merge( $new_actions, $actions );
}

add_filter( 'plugin_action_links_' . GIVEDD_BASENAME, 'givedd_plugin_action_links' );


/**
 * Plugin row meta links.
 *
 * @since 1.3.3
 *
 * @param array  $plugin_meta An array of the plugin's metadata.
 * @param string $plugin_file Path to the plugin file, relative to the plugins directory.
 *
 * @return array
 */
function givedd_plugin_row_meta( $plugin_meta, $plugin_file ) {
	if ( GIVEDD_BASENAME !== $plugin_file ) {
		return $plugin_meta;
	}

	$new_meta_links = array(
		sprintf(
			'<a href="%1$s" target="_blank">%2$s</a>',
			esc_url(
				add_query_arg(
					array(
						'utm_source'   => 'plugins-page',
						'utm_medium'   => 'plugin-row',
						'utm_campaign' => 'admin',
					), 'https://givewp.com/documentation/add-ons/display-donors/'
				)
			),
			esc_html__( 'Documentation', 'givedd' )
		),
		sprintf(
			'<a href="%1$s" target="_blank">%2$s</a>',
			esc_url(
				add_query_arg(
					array(
						'utm_source'   => 'plugins-page',
						'utm_medium'   => 'plugin-row',
						'utm_campaign' => 'admin',
					), 'https://givewp.com/addons/'
				)
			),
			esc_html__( 'Add-ons', 'givedd' )
		),
	);

	return array_merge( $plugin_meta, $new_meta_links );
}

add_filter( 'plugin_row_meta', 'givedd_plugin_row_meta', 10, 2 );
