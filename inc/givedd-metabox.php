<?php
/**
 * The GIVEDD Metabox
 *
 * @copyright   Copyright (c) 2015, WordImpress
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


// Because Give already requires CMB2
// And GIVEDD requires Give, there's no need to require CMB2
// We can just jump right into metabox creation with the CMB2 action.
add_action( 'cmb2_admin_init', 'givedd_metabox' );

function givedd_metabox() {

	$prefix = '_givedd_';

	$givedd = new_cmb2_box(
		array(
			'id'           => $prefix . 'give_gift',
			'title'        => __( 'Display Donors', 'givedd' ),
			'object_types' => array( 'give_forms' ),
			'context'      => 'side',
			'priority'     => 'high',
		)
	);

	$givedd->add_field(
		array(
			'name'    => __( 'Should Donors to this form be included in the front-end display?', 'givedd' ),
			'id'      => $prefix . 'enable_donor_display',
			'type'    => 'radio',
			'default' => 'yes',
			'options' => array(
				'yes' => __( 'Yes', 'givedd' ),
				'no'  => __( 'No', 'givedd' ),
			),
		)
	);
}
