<?php

/**
 * Adds checkbox to donate anonymously.
 *
 * @param int   $payment_id   The payment ID.
 * @param array $payment_data Arguments passed.
 */
function givedd_private_donation( $form_id ) {
?>
	<div class="anonymous-donation-wrap">
		<input id="give-anonymous-donation" name="give-anonymous-donation" type="checkbox">
		<label for="give-anonymous-donation"><?php esc_html_e( 'Make this donation anonymous', 'givedd' ); ?></label>
	</div>
<?php
}

add_action( 'give_donation_form_before_submit', 'givedd_private_donation' );

/**
 * Adds user email id to `wp_give_formmeta` if they donate anonymously.
 *
 * @param int   $payment_id   The payment ID.
 * @param array $payment_data Arguments passed.
 */
function givedd_add_anonymous_donor( $payment_id, $payment_data ) {

	if ( isset( $_POST['give-anonymous-donation'] ) ) {
		add_post_meta( $payment_id, 'give-anonymous-donor', true );
	}
}

add_action( 'give_insert_payment', 'givedd_add_anonymous_donor', 10, 2 );

/**
 * Returns list of donors whoo have donated unanimously.
 *
 * @param int $form_ids Array of form ID from which unanimous donors should be retrieved.
 *
 * @return array Donor IDs
 */
function givedd_get_nonanonymous_donors( $form_ids = array() ) {

	/**
	 * List of donor IDs of unanimous donors.
	 *
	 * @var array
	 */
	$donor_ids = array();

	/**
	 * Arguments to set up Payments Query.
	 *
	 * @var array
	 */
	$anon_payments_args = array(
		'meta_query' => array(
			array(
				'key'     => 'give-anonymous-donor',
				'compare' => 'NOT EXISTS'
			),
		)
	);

	/**
	 * The query retrieves unanimous donors from all forms
	 * unless the specific form IDs are passed to the
	 * `$form_ids` array.
	 */
	if ( is_array( $form_ids ) && ! empty( $form_ids ) ) {
		$anon_payments_args['give_forms'] = $form_ids;
	}

	/**
	 * Query to set up Payments.
	 *
	 * This query retrieves payments that are made by
	 * unanimous donors.
	 */
	$anon_payments = new Give_Payments_Query( $anon_payments_args );

	// Get the payments object array.
	$payments = $anon_payments->get_payments();

	foreach ( $payments as $payment ) {
		$payment_id = give_get_payment_donor_id( $payment->ID );
		if ( ! in_array( $payment_id, $donor_ids ) ) {
			$donor_ids[] =  $payment_id;
		}
	}

	return $donor_ids;
}
