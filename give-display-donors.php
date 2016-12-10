<?php
/**
 * Plugin Name: 	Give - Display Donors
 * Plugin URI: 		https://givewp.com
 * Description: 	Display recent donors on your site. Donors can opt-out of being displayed.
 * Version: 		1.0
 * Author: 			WordImpress, LLC
 * Author URI: 		https://wordimpress.com
 * License:      	GNU General Public License v2 or later
 * License URI:  	http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:		givedd
 *
 */

// Defines Plugin directory for easy reference
if ( ! defined( 'GIVEDD_DIR' ) ) {
    define('GIVEDD_DIR', dirname(__FILE__));
}

if ( ! defined( 'GIVEDD_BASENAME' ) ) {
    define( 'GIVEDD_BASENAME', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'GIVEDD_VERSION' ) ) {
    define( 'GIVEDD_VERSION', '1.0' );
}

if ( ! defined( 'GIVEDD_MIN_GIVE_VER' ) ) {
    define( 'GIVEDD_MIN_GIVE_VER', '1.7' );
}

include( GIVEDD_DIR . '/admin/givedd-activation.php' );
include( GIVEDD_DIR . '/inc/givedd-metabox.php' );
include( GIVEDD_DIR . '/inc/shortcodes.php' );

if ( ! class_exists( 'Give' ) ) {
    return false;
}