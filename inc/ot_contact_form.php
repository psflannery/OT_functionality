<?php
/**
* Plugin Name: Very Simple Contact Form
* Description: This is a very simple contact form. Use shortcode [contact] to display form on page or use the widget. For more info please check readme file.
* Version: 2.7
* Author: Guido van der Leest
* Author URI: http://www.guidovanderleest.nl
* License: GNU General Public License v3 or later
* License URI: http://www.gnu.org/licenses/gpl-3.0.html
* Text Domain: verysimple
* Domain Path: translation
*/
// https://wordpress.org/plugins/very-simple-contact-form/

// The shortcode
function vscf_shortcode($atts) {
	extract(shortcode_atts(array(
		"subscribe_address"				=> __('http://otdac.org/lists/?p=subscribe&id=2', 'verysimple') ,
		"unsubscribe_address"			=> __('http://otdac.org/lists/?p=unsubscribe&amp;id=2', 'verysimple') ,
		"label_first_name"              => __('First Name', 'verysimple') ,
		"label_surname"                 => __('Surname', 'verysimple') ,
		"label_email"                   => __('Email Address', 'verysimple') ,
		"label_confirm_email"           => __('Confirm Email Address', 'verysimple') ,
		"label_submit"                  => __('Subscribe', 'verysimple') ,
		"label_unsubscribe"             => __('Unsubscribe', 'verysimple') ,
		"error_empty"                   => __("Please fill in all the required fields", "verysimple"),
		"error_form_name"               => __('Please enter at least 3 characters', 'verysimple') ,
		"error_form_subject"            => __('Please enter at least 3 characters', 'verysimple') ,
		"error_form_message"            => __('Please enter at least 10 characters', 'verysimple') ,
		"error_email"                   => __("Please enter a valid email", "verysimple"),
		//"success"                       => __("Thanks for your message! I will contact you as soon as I can.", "verysimple"),
	), $atts));

	if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['form_send']) ) {

		// Get posted data and sanitize them
		$post_data = array(
			'form_name'             => sanitize_text_field($_POST['form_name']),
			'email'                 => sanitize_email($_POST['email']),
			'form_subject'          => sanitize_text_field($_POST['form_subject']),
			'form_message'          => sanitize_text_field($_POST['form_message']),
			'form_sum'              => sanitize_text_field($_POST['form_sum']),
			'form_firstname'        => sanitize_text_field($_POST['form_firstname']),
			'form_lastname'         => sanitize_text_field($_POST['form_lastname'])
		);

		$error = false;
		$required_fields = array("form_name", "email", "form_subject", "form_message");
		$security_fields = array("form_firstname", "form_lastname");

		foreach ($required_fields as $required_field) {
			$value = stripslashes(trim($post_data[$required_field]));

			// Displaying error message if validation failed for each input field
			if(((($required_field == "form_name") || ($required_field == "form_subject")) && strlen($value)<3) || (($required_field == "form_message") && strlen($value)<10) || empty($value)) {
				$error_class[$required_field] = "error";
				$error_msg[$required_field] = ${"error_".$required_field};
				$error = true;
				$result = $error_empty;
			}
			$form_data[$required_field] = $value;
		}

		foreach ($security_fields as $security_field) {
			$value = stripslashes(trim($post_data[$security_field]));

			// Not sending message if validation failed for each input field
			if ((($security_field == "form_firstname") || ($security_field == "form_lastname")) && strlen($value)>0) {
				$error_class[$security_field] = "error";
				$error = true;
			}
			$form_data[$security_field] = $value;
		}

	}
	
	// The contact form with error messages
	$email_form = '
		<div class="mailing-list-inner col-sm-8 col-lg-6 col-sm-offset-1 col-lg-offset-2">
			<h2>Subscribe to our mailing list</h2>
			<form method="post" action="' . $subscribe_address . '" name="subscribeform">
				<div class="form-group">
					<label class="desc" id="ot-mail" for="email">' . $label_email . '</label>
					<div>
						<input id="field-ot-mail" class="form-control" name="email" type="email" spellcheck="false" value="" maxlength="255" tabindex="1">
					</div>
				</div>	
				<div class="form-group">
					<label class="desc" id="ot-mail-confirm" for="emailconfirm">' . $label_confirm_email . '</label>
					<div>
						<input id="field-ot-mail-confirm" class="form-control" name="emailconfirm" type="email" spellcheck="false" value="" maxlength="255" tabindex="2">
					</div>
				</div>
				<div class="form-group">
					<label class="desc" id="ot-first-name" for="first-name">' . $label_first_name . '</label>
					<div>
						<input id="field-ot-first-name" class="form-control" name="first-name" type="text" class="field text fn" value="" tabindex="3">
					</div>
				</div>
				<div class="form-group">
					<label class="desc" id="ot-last-name" for="last-name">' . $label_surname . '</label>
					<div>
						<input id="field-ot-last-name" class="form-control" name="last-name" type="text" class="field text fn" value="" tabindex="4">
					</div>
				</div>
				<div class="form-group">
					<div>
						<input name="list[5]" value="signup" type="hidden">
						<input name="listname[5]" value="Opening Times General List" type="hidden">
						<input id="ot-subscribe" name="subscribe" type="submit" value="' . $label_submit . '" class="ot-button" onclick="return checkform();" tabindex="5">
					</div>
				</div>
			</form>
			<a href="' . $unsubscribe_address . '" class="ot-mail-unsubscribe">' . $label_unsubscribe . '</a>
		</div>';

	return $email_form;
} 

add_shortcode('contact', 'vscf_shortcode');
