<?php
/*
Plugin Name: Contact Form Plugin
Plugin URI: http://example.com
Description: WordPress Contact Form
Version: 1.0.0
Author: Sayangdipto Chakraborty
Author URI: http://github.com/sayangdiptochakraborty
*/
function html_form_code() {
	echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
	echo '<p>';
	echo 'Your Email <br/>';
	echo '<input type="email" name="cf-email" value="' . ( isset( $_POST["cf-email"] ) ? esc_attr( $_POST["cf-email"] ) : '' ) . '" size="40" />';
	echo '</p>';
	echo '<p>';
	echo 'Phone Number<br/>';
	echo '<input type="number" name="cf-number" pattern="[0-9]{10}" value="' . ( isset( $_POST["cf-number"] ) ? esc_attr( $_POST["cf-number"] ) : '' ) . '" size="40" />';
	echo '</p>';
	echo '<p>';
	echo 'Group Size<br/>';
	echo '<input type="number" name="cf-size" pattern="[0-9]{2}" value="' . ( isset( $_POST["cf-size"] ) ? esc_attr( $_POST["cf-size"] ) : '' ) . '" size="40" />';
	echo '</p>';
	echo '<p>';
	echo 'Tour Date<br/>';
	echo '<input type="date" name="cf-date" value="' . ( isset( $_POST["cf-date"] ) ? esc_attr( $_POST["cf-date"] ) : '' ) . '" size="40" />';
	echo '</p>';
	echo '<p><input type="submit" name="cf-submitted" id="button" value="Send"></p>';
	echo '</form>';
}

function deliver_mail() {

	// if the submit button is clicked, send the email
	if ( isset( $_POST['cf-submitted'] ) ) {

		// sanitize form values
		$email   = sanitize_email( $_POST["cf-email"] );
		$phone = sanitize_text_field( $_POST["cf-number"] );
		$group_size = sanitize_text_field( $_POST["cf-size"] );
		$tour_date = sanitize_text_field( $_POST["cf-date"] );
		$ch=curl_init();
		curl_setopt($ch,CURLOPT_URL,"https://www.trippyigloo.com/lead_intern/");
		curl_setopt($ch,CURLOPT_POST,true);
		curl_setopt($ch,CURLOPT_POSTFIELDS,array("email","phone","group_size","tour_date"));
	}
}

function cf_shortcode() {
	
	ob_start();
	echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
	echo '<p><input type="submit" name="cf-submit"  value="Request Details"></p>';
	echo '</form>';
	if(isset($_POST['cf-submit']))
	{ 
		deliver_mail();
		html_form_code();
	}
	return ob_get_clean();
}
add_shortcode( 'contact_form_plugin', 'cf_shortcode' );

?>
