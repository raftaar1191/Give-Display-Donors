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

add_shortcode( 'display_donors', 'givedd_recent_donors_function' );

function give_display_donors_function()
{

    //Get the latest 100 Give Donors
    $args = array(
        'number' => 100,
    );

    $donors = Give()->customers->get_customers($args);

    foreach ( $donors as $donor ) {

        $output = $donor->name . ", ";
        // First and Last Name
        $name = $donor->name;
        //Split up the names
        $separate = explode(" ", $name);
        //find the surname
        $last = array_pop($separate);
        //Shorten up the name so it's Jason T.  instead of Jason Tucker
        $shortenedname = implode(' ', $separate) . " " . $last[0] . ".";
        //Display the Jason T. and include a , after it.
        $output .= $shortenedname . ", ";
    }

    $output .= " and many more.";
    return $output;
}
