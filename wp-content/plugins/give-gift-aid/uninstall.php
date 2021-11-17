<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @link       https://givewp.com
 * @since      1.0.0
 * @author     GiveWP
 *
 * @package    Give_Gift_Aid
 */

// Exit if access directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Get Give core settings.
$give_settings = give_get_settings();

// List of plugin Global settings.
$plugin_settings = array(
	'give_gift_aid_settings',
	'give_gift_aid_enable_disable',
	'give_gift_aid_fieldset_title',
	'give_gift_aid_explanation_content',
	'give_gift_aid_agreement',
	'give_gift_aid_long_explanation_enable_disable',
	'give_gift_aid_long_explanation_content',
	'give_gift_aid_declaration_form',
);

foreach ( $give_settings as $setting_key => $setting ) {
	if ( in_array( $setting_key, $plugin_settings, true ) ) {
		unset( $give_settings[ $setting_key ] );
	}
}

// Update settings.
update_option( 'give_settings', $give_settings );

$items = get_posts( array(
	'post_type'   => 'give_forms',
	'post_status' => 'any',
	'numberposts' => - 1,
	'fields'      => 'ids',
) );

if ( $items ) {
	foreach ( $items as $item ) {

		$give_post_meta_data = give_get_meta( $item, '' );

		if ( $give_post_meta_data ) {
			foreach ( $give_post_meta_data as $key => $meta_value ) {
				if ( in_array( $key, $plugin_settings, true ) ) {
					delete_post_meta( $item, $key );
				}
			}
		}
	}
}

// List of Plugin payment meta settings.
$plugin_payment_meta_settings = array(
	'_give_gift_aid_declaration_content',
	'_give_gift_aid_accept_term_condition',
);

$payments = get_posts( array(
	'post_type'   => 'give_payment',
	'post_status' => 'any',
	'numberposts' => - 1,
	'fields'      => 'ids',
) );

if ( $payments ) {
	foreach ( $payments as $payment ) {

		$give_payment_meta_data = give_get_meta( $payment, '' );

		if ( $give_payment_meta_data ) {
			foreach ( $give_payment_meta_data as $key => $meta_value ) {
				if ( in_array( $key, $plugin_payment_meta_settings, true ) ) {
					delete_post_meta( $payment, $key );
				}
			}
		}
	}
}
