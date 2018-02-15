<?php
/**
 * The GIVE Display Donors Shortcodes
 *
 * @copyright   Copyright (c) 2015, WordImpress
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function givedd_display_nonanonymous_donors( $atts, $content ) {
	$atts = shortcode_atts( array(
		'forms' => array()
	), $atts );

	$form_ids  = ( ! empty( $atts['forms'] ) ) ? explode( ',', $atts['forms'] ) : array();
	$donor_ids = givedd_get_nonanonymous_donors( $form_ids );

	printf( '<div class="give-grid-donor-wrap">' );

	foreach ( $donor_ids as $donor_id ) {
		$donor      = new Give_Donor( $donor_id );
		$first_name = $donor->get_first_name();
		$last_name  = $donor->get_last_name();
		$email      = $donor->email;

		include GIVEDD_DIR . '/templates/render-donor-grid-item.php';
	}

	printf( '</div>' );
}

add_shortcode( 'display_donors', 'givedd_display_nonanonymous_donors' );
