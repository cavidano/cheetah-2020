<?php
/**
 * Give - Gift Aid Helper functions.
 *
 * @package    Give_Gift_Aid
 * @subpackage Give_Gift_Aid/includes
 * @author     GiveWP <info@givewp.com>
 */

/**
 * Give Gift - Aid settings.
 *
 * @since 1.0.0
 *
 * @param bool $is_global Check if Global/Per-Form settings.
 *
 * @return array $settings Give Gift Aid Settings array.
 */
function give_gift_aid_settings( $is_global ) {

	$all_settings = array(
		'give_gift_aid_settings',
		'give_gift_aid_enable_disable',
		'give_gift_aid_fieldset_title',
		'give_gift_aid_explanation_content',
		'give_gift_aid_checkbox_label',
		'give_gift_aid_agreement',
		'give_gift_aid_long_explanation_enable_disable',
		'give_gift_aid_long_explanation_content',
		'give_gift_aid_declaration_form',
		'give_gift_aid_settings_docs_link',
		'give_gift_aid_settings_section_end',
	);

	$settings = array();

	if ( in_array( 'give_gift_aid_settings', $all_settings, true ) ) {

		if ( $is_global ) {
			$settings[] = array(
				'type' => 'title',
				'id'   => 'give_gift_aid_settings',
			);
		}
	}// End if().

	if ( in_array( 'give_gift_aid_enable_disable', $all_settings, true ) ) {

		$options        = array();
		$default_option = 'global'; // Set default option as a global.

		if ( $is_global ) {
			$options['enabled']  = __( 'Enabled', 'give-gift-aid' );
			$options['disabled'] = __( 'Disabled', 'give-gift-aid' );
			$default_option      = 'disabled';
		} else {
			$options['global']   = __( 'Global Option', 'give-gift-aid' );
			$options['enabled']  = __( 'Customize', 'give-gift-aid' );
			$options['disabled'] = __( 'Disabled', 'give-gift-aid' );
		}

		$settings[] = array(
			'name'          => __( 'Gift Aid', 'give-gift-aid' ),
			'desc'          => $is_global ? __( 'This enables the Gift Aid feature for all your website\'s donation forms. Note: You can disable the global options and enable and customize options per form as well.', 'give-gift-aid' ) : __( 'This allows you to customize the Gift Aid settings for just this donation form. You can disable Gift Aid for just this form as well or simply use the global settings.', 'give-gift-aid' ),
			'id'            => 'give_gift_aid_enable_disable',
			'wrapper_class' => 'give_gift_aid_enable_disable',
			'type'          => 'radio_inline',
			'default'       => $default_option,
			'options'       => $options,
		);

	}// End if().

	if ( in_array( 'give_gift_aid_fieldset_title', $all_settings, true ) ) {
		$settings[] = array(
			'name'          => __( 'Gift Aid Fieldset Title', 'give-gift-aid' ),
			'id'            => 'give_gift_aid_fieldset_title',
			'wrapper_class' => 'give_gift_aid_fields give-hidden',
			'desc'          => __( 'This is the title that appears above the Gift Aid fieldset within the donation form.', 'give-gift-aid' ),
			'default'       => give_gift_aid_fieldset_default_title(),
			'placeholder'   => give_gift_aid_fieldset_default_title(),
			'type'          => 'text',
		);
	}// End if().

	if ( in_array( 'give_gift_aid_explanation_content', $all_settings, true ) ) {
		$settings[] = array(
			'name'          => __( 'Gift Aid Explanation', 'give-gift-aid' ),
			'id'            => 'give_gift_aid_explanation_content',
			'wrapper_class' => 'give_gift_aid_fields give-hidden',
			'desc'          => give_gift_aid_explanation_description(),
			'type'          => 'wysiwyg',
			'default'       => give_gift_aid_explanation_default_content(),
		);
	}// End if().

	if ( in_array( 'give_gift_aid_long_explanation_enable_disable', $all_settings, true ) ) {
		$settings[] = array(
			'name'          => __( 'Long Explanation', 'give-gift-aid' ),
			'desc'          => __( 'This allows you to provide a more in depth explanation of Gift Aid for your donors. The content will appear within a modal window.', 'give-gift-aid' ),
			'id'            => 'give_gift_aid_long_explanation_enable_disable',
			'wrapper_class' => 'give_gift_aid_fields give-hidden',
			'type'          => 'radio_inline',
			'default'       => 'enabled',
			'options'       => array(
				'enabled'  => __( 'Enabled', 'give-gift-aid' ),
				'disabled' => __( 'Disabled', 'give-gift-aid' ),
			),
		);
	}// End if().

	if ( in_array( 'give_gift_aid_long_explanation_content', $all_settings, true ) ) {
		$settings[] = array(
			'name'          => __( 'Gift Aid Long Explanation', 'give-gift-aid' ),
			'id'            => 'give_gift_aid_long_explanation_content',
			'wrapper_class' => 'give_gift_aid_fields give_gift_aid_long_explanation_fields give-hidden',
			'desc'          => give_gift_aid_long_explanation_description(),
			'type'          => 'wysiwyg',
			'default'       => give_gift_aid_long_explanation_default_content(),
		);
	}// End if().

	if ( in_array( 'give_gift_aid_checkbox_label', $all_settings, true ) ) {
		$settings[] = array(
			'name'          => __( 'Gift Aid Checkbox Label', 'give-gift-aid' ),
			'id'            => 'give_gift_aid_checkbox_label',
			'wrapper_class' => 'give_gift_aid_fields give-hidden',
			'desc'          => __( 'This is the agreement text that appears next to the checkbox optin to Gift Aid.', 'give-gift-aid' ),
			'default'       => give_gift_aid_checkbox_default_label(),
			'placeholder'   => give_gift_aid_checkbox_default_label(),
			'type'          => 'text',
		);
	}// End if().

	if ( in_array( 'give_gift_aid_agreement', $all_settings, true ) ) {
		$settings[] = array(
			'name'          => __( 'Gift Aid Agreement', 'give-gift-aid' ),
			'id'            => 'give_gift_aid_agreement',
			'wrapper_class' => 'give_gift_aid_fields give-hidden',
			'desc'          => give_gift_aid_agreement_description(),
			'default'       => give_gift_aid_agreement_default_content(),
			'placeholder'   => give_gift_aid_agreement_default_content(),
			'type'          => 'textarea',
			'css'           => 'width:100%;',
		);
	}// End if().

	if ( in_array( 'give_gift_aid_declaration_form', $all_settings, true ) ) {
		$settings[] = array(
			'name'          => __( 'Declaration Form', 'give-gift-aid' ),
			'id'            => 'give_gift_aid_declaration_form',
			'wrapper_class' => 'give_gift_aid_fields give-hidden',
			'desc'          => give_gift_aid_declaration_description(),
			'type'          => 'wysiwyg',
			'default'       => give_gift_aid_declaration_form_default_content(),
		);
	}// End if().

	if ( in_array( 'give_gift_aid_settings_docs_link', $all_settings, true ) ) {

		$docs_link_type = 'docs_link'; // Set doc type for per form.
		if ( $is_global ) {
			$docs_link_type = 'give_docs_link';
		}

		$settings[] = array(
			'name'  => __( 'Give - Gift Aid Settings Docs Link', 'give-gift-aid' ),
			'id'    => 'give_gift_aid_settings_docs_link',
			'url'   => esc_url( 'http://docs.givewp.com/addon-gift-aid' ),
			'title' => __( 'Give - Gift Aid Settings', 'give-gift-aid' ),
			'type'  => $docs_link_type,
		);
	}// End if().

	if ( in_array( 'give_gift_aid_settings_section_end', $all_settings, true ) ) {
		if ( $is_global ) {
			$settings[] = array(
				'type' => 'sectionend',
				'id'   => 'give_gift_aid_settings_section_end',
			);
		}
	}// End if().

	return $settings;
}

/**
 * Give gift aid fieldset default title.
 *
 * @since    1.0.0
 *
 * @return string
 */
function give_gift_aid_fieldset_default_title() {
	return __( 'Reclaim Gift Aid', 'give-gift-aid' );
}

/**
 *  Give gift aid explanation default content.
 *
 * @since    1.0.0
 *
 * @return string
 */
function give_gift_aid_explanation_default_content() {

	$explanation_content = sprintf(
	/* translators: 1. Safe Asset URL, 2. Alt Text, 3. Bold Text, 4. Normal Text */
		'<img style="%1$s" src="%2$s" alt="%3$s" /><strong>%4$s</strong> %5$s',
		'max-width: 200px; width: 30%; float: right; text-align: center;',
		give_get_safe_asset_url( GIVE_GIFT_AID_PLUGIN_URL . 'assets/images/gift-aid-logo.png' ),
		__( 'Gift Aid It!', 'give-gift-aid' ),
		__( 'Add 25% more to your donation at no cost to you.', 'give-gift-aid' ),
		__( 'A Gift Aid declaration allows {sitename} to claim tax back on eligible donations. It means that for every £1 you donate to {sitename} we can claim back 25p, at no extra cost to you.', 'give-gift-aid' )
	);

	return apply_filters( 'give_gift_aid_explanation_default_content', $explanation_content );
}

/**
 * Give gift aid checkbox default label.
 *
 * @since    1.0.0
 *
 * @return string
 */
function give_gift_aid_checkbox_default_label() {
	return __( 'Yes, I would like to claim Gift Aid', 'give-gift-aid' );
}

/**
 *  Give gift aid agreement default content.
 *
 * @since    1.0.0
 *
 * @return string
 */
function give_gift_aid_agreement_default_content() {
	return __( 'By ticking the "Yes" box, I agree I would like {sitename} to reclaim the tax on all qualifying donations I have made, as well as any future donations, until I notify them otherwise. I understand that if I pay less Income Tax and/or Capital Gains Tax than the amount of Gift Aid claimed on all my donations in that tax year I may be asked to pay any difference. I understand that {sitename} will reclaim 25p of tax on every £1 that I give.', 'give-gift-aid' );
}

/**
 * Give gift aid long explanation default content.
 *
 * @since    1.0.0
 * @return string
 */
function give_gift_aid_long_explanation_default_content() {

	$long_explanation_content = '';
	$long_explanation_content .= '<h1><strong>' . __( 'What is Gift Aid?', 'give-gift-aid' ) . '</strong></h1>';
	$long_explanation_content .= '<p>' . __( 'Gift Aid does not cost you a penny more, but can add an additional 25p to every £1 you donate. When {sitename} receives a donation from a UK taxpayer, we\'re entitled to claim an amount of tax (calculated at the basic rate of income tax in that year) paid on that donation. Once you have given your permission for us to do this on your behalf, there is no need for you to do anything else.', 'give-gift-aid' ) . '</p>';
	$long_explanation_content .= '<p>' . __( 'All that is required is that you must be a taxpayer and that would have paid or will pay sufficient Income and/or Capital Gains Tax to cover all the Gift Aid claimed on all your donations in that tax year. Please note that it is your responsibility to pay any difference.', 'give-gift-aid' ) . '</p>';
	$long_explanation_content .= '<p>' . __( 'The amount of tax we claim will be 25% of the total value of your donations in that tax year. Furthermore, if you are a higher taxpayer, you are also entitled to claim the difference between the basic rate which we will claim and the amount of tax you have actually paid. For further details on how you can do this, please contact your tax office. If your tax situation changes and your gifts will no longer be eligible for the Gift Aid scheme please contact us and we will amend your record accordingly.', 'give-gift-aid' ) . '</p>';

	return $long_explanation_content;
}

/**
 * Give gift aid declaration form default content.
 *
 * @since    1.0.0
 *
 * @return string
 */
function give_gift_aid_declaration_form_default_content() {

	$declaration_form_content = '';
	$declaration_form_content .= '<table style="text-align: center;" cellspacing="0" width="100%">';
	$declaration_form_content .= '<tbody>';
	$declaration_form_content .= '<tr><td height="20"> </td></tr>';
	$declaration_form_content .= '<tr><td ><img style="text-align: center;" src="' . GIVE_GIFT_AID_PLUGIN_URL . 'assets/images/place_holder.png" alt="placeholder-image-for-logo"/></td></tr>';
	$declaration_form_content .= '<tr><td height="20"> </td></tr>';
	$declaration_form_content .= '</tbody>';
	$declaration_form_content .= '</table>';

	$declaration_form_content .= '<table style="text-align: left;" cellspacing="20" width="100%">';
	$declaration_form_content .= '<tbody>';
	$declaration_form_content .= '<tr><td><h1 style="text-align: center; color: #000;"><strong>' . __( 'Charity Gift Aid Declaration', 'give-gift-aid' ) . '</strong></h1></td></tr>';
	$declaration_form_content .= '</tbody>';
	$declaration_form_content .= '</tbody>';
	$declaration_form_content .= '</table>';

	$declaration_form_content .= '<table style="text-align: left;" cellspacing="20" width="100%">';
	$declaration_form_content .= '<tbody>';
	$declaration_form_content .= '<tr><td style="text-align: left;"><img src="' . GIVE_GIFT_AID_PLUGIN_URL . 'assets/images/check-arrow.png" width="16px" height="16px"/> ' . __( ' I want to Gift Aid my donation of {amount} and any donations I make in the future or have made in the past 4 years to {sitename}.', 'give-gift-aid' ) . '</td></tr>';
	$declaration_form_content .= '<tr><td><strong>' . __( 'Name of Charity', 'give-gift-aid' ) . '</strong>: {sitename}</td></tr>';
	$declaration_form_content .= '<tr><td style="font-style: italic;">' . __( 'I am a UK taxpayer and understand that if I pay less Income Tax and/or Capital Gains tax than the amount of Gift Aid claimed on all my donations in that tax year it is my responsibility to pay any difference.', 'give-gift-aid' ) . '</td></tr>';
	$declaration_form_content .= '</tbody>';
	$declaration_form_content .= '</table>';

	$declaration_form_content .= '<table style="text-align: left;" cellspacing="20" width="100%">';
	$declaration_form_content .= '<tbody>';
	$declaration_form_content .= '<tbody>';
	$declaration_form_content .= '<tr><td><h3><strong>' . __( 'Donor Details', 'give-gift-aid' ) . '</strong></h3></td></tr>';
	$declaration_form_content .= '<tr><td><strong>' . __( 'First Name', 'give-gift-aid' ) . '</strong>: {first_name}</td></tr>';
	$declaration_form_content .= '<tr><td><strong>' . __( 'Last Name', 'give-gift-aid' ) . '</strong>: {last_name}</td></tr>';
	$declaration_form_content .= '<tr><td><strong>' . __( 'Address', 'give-gift-aid' ) . '</strong>: {gift_aid_address}</td></tr>';
	$declaration_form_content .= '<tr><td><strong>' . __( 'Gift Aid Status', 'give-gift-aid' ) . '</strong>: {gift_aid_status}</td></tr>';
	$declaration_form_content .= '<tr><td><strong>' . __( 'Date', 'give-gift-aid' ) . '</strong>: {donation_date}</td></tr>';
	$declaration_form_content .= '</tbody>';
	$declaration_form_content .= '</table>';

	$declaration_form_content .= '<table style="text-align: center;" cellspacing="50" width="100%">';
	$declaration_form_content .= '<tbody>';
	$declaration_form_content .= '<tr><td><strong>{sitename}</strong> <a href="' . site_url() . '">{siteurl}</a></td></tr>';
	$declaration_form_content .= '</tbody>';
	$declaration_form_content .= '</table>';

	return $declaration_form_content;
}

/**
 * Give gift aid preview template tags formatted message.
 * Provides sample content for the preview content functionality within global and per form settings.
 *
 * @since    1.0.0
 *
 * @param int    $payment_id Payment ID.
 * @param string $message    with content tags.
 *
 * @return string $message Fully formatted message
 */
function give_gift_aid_preview_template_tags( $payment_id, $message ) {

	$amount = give_currency_filter( give_format_amount( 10.50 ) );
	$user   = wp_get_current_user();

	// Set default address.
	$full_address    = '';
	$full_address    .= '123 Test Street, Unit 222' . "\n";
	$full_address    .= 'Somewhere Town, London, S19 2BD, GB';
	$first_name      = ! empty( $user->first_name ) ? $user->first_name : 'Firstname';
	$last_name       = ! empty( $user->last_name ) ? $user->first_name : 'Lastname';
	$donation_date   = date( 'd/m/Y', current_time( 'timestamp' ) );
	$gift_aid_status = '';

	if ( ! empty( $payment_id ) ) {
		$payment_data  = new Give_Payment( $payment_id );
		$donor_id      = $payment_data->customer_id; // Donor ID.
		$donor_object  = new Give_Donor( $donor_id );
		$opt_in_date   = $donor_object->get_meta( '_give_gift_aid_opt_in_date', true );
		$opt_in_date   = ! empty( $opt_in_date ) ? $opt_in_date : $payment_data->date;
		$donation_date = date( 'd/m/Y', strtotime( $opt_in_date ) ); // Donation date.
		$full_address  = '<br/>' . give_gift_aid_full_address( $donor_id );
		$amount        = $payment_data->total;
		$first_name    = $payment_data->first_name;
		$last_name     = $payment_data->last_name;

		// Get gift aid donation status
		$gift_aid_status = give_gift_aid_donation_status( $payment_id );

	}// End if().

	$message = str_replace( '{first_name}', $first_name, $message );
	$message = str_replace( '{last_name}', $last_name, $message );
	$message = str_replace( '{gift_aid_address}', $full_address, $message );
	$message = str_replace( '{gift_aid_status}', $gift_aid_status, $message );
	$message = str_replace( '{charity_name}', get_bloginfo( 'name' ), $message );
	$message = str_replace( '{donation_date}', $donation_date, $message );
	$message = str_replace( '{sitename}', get_bloginfo( 'name' ), $message );
	$message = str_replace( '{siteurl}', preg_replace( '(https?://)', '', site_url() ), $message );
	$message = str_replace( '{amount}', give_currency_filter( $amount, array(
		'currency_code' => give_get_payment_currency_code( $payment_id ),
	) ), $message );

	return wpautop( apply_filters( 'give_gift_aid_preview_template_tags', $message, $payment_id ) );
}

/**
 * Get Gift Aid Country List.
 *
 * @since 1.0.0
 *
 * @return array $countries A list of the available countries for Gift Aid.
 */
function give_gift_aid_get_country_list() {
	$countries = array(
		'GB' => __( 'United Kingdom', 'give-gift-aid' ),
	);

	return apply_filters( 'give_gift_aid_countries', $countries );
}

/**
 * Get a formatted HTML list of all gift aid tags.
 *
 * @since 1.0.0
 *
 * @return string
 */
function give_gift_aid_get_tag_list() {

	$tags = array(
		array(
			'tag'         => 'first_name',
			'description' => __( 'Donor First name.', 'give-gift-aid' ),
		),
		array(
			'tag'         => 'last_name',
			'description' => __( 'Donor Last name.', 'give-gift-aid' ),
		),
		array(
			'tag'         => 'gift_aid_address',
			'description' => __( 'Donor\'s Address Specified for Gift Aid redemption.', 'give-gift-aid' ),
		),
		array(
			'tag'         => 'gift_aid_status',
			'description' => __( 'Donor\'s Donation Gift Aid Status.', 'give-gift-aid' ),
		),
		array(
			'tag'         => 'donation_date',
			'description' => __( 'Date of the donor\'s last Gift Aid donation', 'give-gift-aid' ),
		),
	);

	ob_start();
	if ( count( $tags ) > 0 ) : ?>
		<div class="give-gift-aid-tag-wrap">
			<?php foreach ( $tags as $key => $tag ) : ?>
				<span class="<?php echo esc_attr( 'give_' . $tag['tag'] . '_tag' ); ?>">
					<code>{<?php echo $tag['tag']; ?>}</code>
					- <?php echo $tag['description']; ?>
				</span>
			<?php endforeach; ?>
		</div>
	<?php endif;

	// Return the list.
	return ob_get_clean();
}

/**
 * Give gift aid billing address fields.
 *
 * @since    1.0.0
 *
 * @param int $form_id Donation form ID.
 *
 * @return void
 */
function give_gift_aid_billing_address_fields( $form_id ) {

	do_action( 'give_gift_aid_billing_fields_before' );

	give_gift_aid_get_address_fields( $form_id );

	do_action( 'give_gift_aid_billing_fields_after' );
}

/**
 * Get Give Gift Aid Section Location hook.
 *
 * @since  1.0.0
 *
 * @param int $form_id Form ID.
 *
 * @return string $hook
 */
function give_gift_aid_get_section_location_hook( $form_id ) {
	return apply_filters( 'give_gift_aid_get_section_location_hook', 'give_donation_form_after_cc_form' );
}

/**
 *  Gift Aid Full address.
 *
 * @param int $donor_id Donor ID.
 *
 * @since 1.0.0
 *
 * @return string $give_gift_aid_full_address
 */
function give_gift_aid_full_address( $donor_id ) {

	$donor_object = new Give_Donor( $donor_id );

	$address_one      = $donor_object->get_meta( '_give_gift_aid_card_address', true );
	$address_one      = ! empty( $address_one ) ? $address_one : '';
	$address_two      = $donor_object->get_meta( '_give_gift_aid_card_address_2', true );
	$address_two      = ! empty( $address_two ) ? $address_two : '';
	$gift_aid_city    = $donor_object->get_meta( '_give_gift_aid_card_city', true );
	$gift_aid_city    = ! empty( $gift_aid_city ) ? $gift_aid_city : '';
	$gift_aid_zip     = $donor_object->get_meta( '_give_gift_aid_card_zip', true );
	$gift_aid_zip     = ! empty( $gift_aid_zip ) ? $gift_aid_zip : '';
	$gift_aid_country = $donor_object->get_meta( '_give_gift_aid_country', true );
	$gift_aid_country = ! empty( $gift_aid_country ) ? $gift_aid_country : '';
	$gift_aid_state   = $donor_object->get_meta( '_give_gift_aid_card_state', true );
	$gift_aid_state   = ! empty( $gift_aid_state ) ? $gift_aid_state : '';

	// Build Gift Aid Full address.
	$full_address = '';
	if ( ! empty( $address_one ) ) {
		$full_address .= $address_one . ', ';

		if ( ! empty( $address_two ) ) {
			$full_address .= $address_two;
		}
	}

	if ( ! empty( $gift_aid_city ) ) {
		$full_address .= '<br>' . $gift_aid_city . ', ';
	}

	if ( ! empty( $gift_aid_state ) ) {
		$full_address .= $gift_aid_state . ' ';
	}

	if ( ! empty( $gift_aid_zip ) ) {
		$full_address .= $gift_aid_zip . '<br> ';
	}

	if ( ! empty( $gift_aid_country ) ) {
		$full_address .= give_get_country_name_by_key( $gift_aid_country );
	}

	return $full_address;
}

/**
 * Download Gift Aid Declaration Form.
 *
 * @since 1.0.0
 *
 * @param array $payment_ids Payment IDs.
 */
function give_gift_aid_declaration_form_download( $payment_ids ) {
	/**
	 * Composer's autoload.php.
	 */
	if ( file_exists( GIVE_PLUGIN_DIR . 'vendor/autoload.php' ) ) {
		require_once GIVE_PLUGIN_DIR . 'vendor/autoload.php';
	} else {
		// Load autoloader.
		require_once GIVE_PLUGIN_DIR . 'includes/libraries/tcpdf/tcpdf.php';
	}

	$page_unit   = apply_filters( 'give_gift_aid_declaration_form_page_unit', 'mm' );
	$page_format = apply_filters( 'give_gift_aid_declaration_form_page_format', 'a4' );
	$form_layout = apply_filters( 'give_gift_aid_declaration_form_layout', 'p' );
	$font_size   = apply_filters( 'give_gift_aid_declaration_form_font_size', 12 );
	$form_font   = apply_filters( 'give_gift_aid_declaration_form_font', 'dejavusans' );
	$form_font   = ( in_array( give_get_currency(), array(
		'RIAL',
		'RUB',
		'IRR',
	) ) ) ? 'CODE2000' : $form_font; // Set 'CODE2000' font if Currency is Iranian rial.
	// Create new PDF document.
	$pdf = new TCPDF( $form_layout, $page_unit, $page_format, true, 'UTF-8', false );

	// Set document information.
	$pdf->SetAuthor( apply_filters( 'give_gift_aid_declaration_form_author', get_option( 'blogname' ) ) );
	$pdf->SetTitle( apply_filters( 'give_gift_aid_declaration_form_title', 'Gift Aid Declaration Form' ) );
	$pdf->SetSubject( apply_filters( 'give_gift_aid_declaration_form_subject', 'Gift Aid Declaration Form' ) );
	$pdf->SetLeftMargin( 20 ); // Set Left Margin 0.
	$pdf->SetRightMargin( 20 ); // Set Right Margin 0.
	$pdf->setPrintHeader( false ); // Remove default header.
	$pdf->setPrintFooter( false ); // Remove default footer.
	$pdf->SetFont( $form_font, '', $font_size, 'false' ); // Set Gift Aid font.
	$pdf->setImageScale( 1.5 );

	if ( ! isset( $payment_ids ) && ! is_array( $payment_ids ) ) {
		return;
	}

	foreach ( $payment_ids as $payment_id ) {

		$term_condition = give_get_meta( $payment_id, '_give_gift_aid_accept_term_condition', true );

		// Bail out, if Gift aid term and condition not accepted.
		if ( ! give_is_setting_enabled( $term_condition ) ) {
			return;
		}

		$form_content     = give_gift_aid_declaration_form_content( $payment_id );
		$declaration_html = give_gift_aid_preview_template_tags( $payment_id, $form_content );

		$pdf->AddPage( $form_layout, $page_format );
		$pdf->writeHTMLCell( '', '', '', '', $declaration_html, 0, 0, false, false, 'C', true );
		$pdf->SetAutoPageBreak( true, 0 ); // Set Auto page break.
	}// End foreach().

	$pdf->lastPage();

	$pdf->Output( apply_filters( 'give_gift_aid_declaration_form_text', 'gift_aid_declaration_form_download' ) . '.pdf', wp_is_mobile() ? 'I' : 'D' );

	exit;
}

/**
 * Get Dynamic Content of Declaration form for Donation.
 *
 * @since 1.0.0
 *
 * @param int $payment_id Donation ID.
 *
 * @return string $give_gift_aid_declaration_form_content
 */
function give_gift_aid_declaration_form_content( $payment_id ) {

	$payment_data = new Give_Payment( $payment_id );
	$form_id      = $payment_data->form_id; // Form ID.

	// Get the value of Gift Aid form enable or not.
	$is_gift_aid = give_get_meta( $form_id, 'give_gift_aid_enable_disable', true );
	$is_gift_aid = ! empty( $is_gift_aid ) ? $is_gift_aid : 'global';

	$form_content = '';
	if ( give_is_setting_enabled( $is_gift_aid, 'global' ) && give_is_setting_enabled( give_get_option( 'give_gift_aid_enable_disable' ) ) ) {

		// Get the value of Gift Aid declaration content from global.
		$form_content = give_get_option( 'give_gift_aid_declaration_form', give_gift_aid_declaration_form_default_content() );

	} elseif ( give_is_setting_enabled( $is_gift_aid ) ) {

		// Get the value of Gift Aid declaration content from per form.
		$form_content = give_get_meta( $form_id, 'give_gift_aid_declaration_form', true );
		$form_content = ! empty( $form_content ) ? $form_content : give_gift_aid_declaration_form_default_content();

	}// End if().

	return $form_content;
}

/**
 * Description string for Give gift aid explanation wysiwyg field.
 *
 * @since 1.1
 *
 * @return string
 */
function give_gift_aid_explanation_description() {

	return sprintf(
		give_gift_aid_wysiwyg_description_tags(),
		__( 'The content that appears above the Gift Aid opt-in checkbox. This text should briefly describe the benefits of claiming Gift Aid.', 'give-gift-aid' ),
		give_get_aid_available_tag_string(),
		give_get_aid_desc_for_sitename_tag()
	);
}

/**
 * Description string for the gift aid agreement.
 *
 * @since 1.1
 *
 * @return string
 */
function give_gift_aid_agreement_description() {

	return sprintf(
		give_gift_aid_wysiwyg_description_tags(),
		__( 'The content that appears below the Gift Aid opt-in checkbox. Individual donors should be aware of unexpected tax demands if their tax is insufficient to cover their Gift Aid donations. This text is a requirement of the Gift Aid declaration required to be displayed to the donor.', 'give-gift-aid' ),
		give_get_aid_available_tag_string(),
		give_get_aid_desc_for_sitename_tag()
	);
}

/**
 * Description string for long explanation wysiwyg field.
 *
 * @since 1.1
 *
 * @return string
 */
function give_gift_aid_long_explanation_description() {

	return sprintf(
		give_gift_aid_wysiwyg_description_tags(),
		__( 'Enter content for the Gift Aid explanation that is provided to the donor. which opens in a model window. HTML is accepted.', 'give-gift-aid' ),
		give_get_aid_available_tag_string(),
		give_get_aid_desc_for_sitename_tag()
	);
}

/**
 * HTML Tags for the wysiwyg field description.
 *
 * @since 1.1
 *
 * @return string
 */
function give_gift_aid_wysiwyg_description_tags() {

	return '%1$1s <br /> %2$2s <br /><span class="give-gift-aid-tag-wrap"><span><code>{sitename}</code> %3$3s</span></span>';
}

/**
 * Description string for the gift aid declaration wysiwyg field.
 *
 * @since 1.1
 *
 * @return string
 */
function give_gift_aid_declaration_description() {

	return sprintf(
		'%1$1s <br /><a target="_blank" href="%2$2s">%3$3s</a> %4$4s <br /> %5$5s <a href="%6$6s"> %7$7s</a>. %8$8s <br /> %9$9s',
		__( 'Customize the Gift Aid Declaration form used for record and tax purposes. Please review the', 'give-gift-aid' ),
		esc_url( 'https://www.gov.uk/guidance/schedule-spreadsheet-to-claim-back-tax-on-gift-aid-donations' ),
		__( 'requirements', 'give-gift-aid' ),
		__( 'on the GOV.UK website for requirements. The content here will be available via PDF', 'give-gift-aid' ),
		__( 'download under', 'give-gift-aid' ),
		esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-reports&tab=gift-aid' ) ),
		__( 'Reports > Gift Aid', 'give-gift-aid' ),
		__( 'Images, HTML and the following template tags are supported:', 'give-gift-aid' ),
		give_gift_aid_get_tag_list()
	);
}

/**
 * Get the string available tags.
 *
 * @since 1.1
 *
 * @return string
 */
function give_get_aid_available_tag_string() {
	return __( 'Available template tags:', 'give-gift-aid' );
}

/**
 * Get the description string for the sitename tags.
 *
 * @since 1.1
 *
 * @return string
 */
function give_get_aid_desc_for_sitename_tag() {
	return __( '- The name of your website.', 'give-gift-aid' );
}

/**
 * Give Gift Aid Function to Print the HTML of Country
 *
 * @since 1.1
 *
 * @param string $form_id .
 */
function give_gift_aid_address_country( $form_id ) {
	?>
	<p id="<?php echo esc_attr( 'give-gift-aid-country-wrap-' . $form_id ); ?>" class="form-row form-row-responsive">
		<label for="<?php echo esc_attr( 'give_gift_aid_billing_country_' . $form_id ); ?>" class="give-label">
			<?php esc_html_e( 'Country', 'give-gift-aid' ); ?>
			<span class="give-required-indicator">*</span>
			<span class="give-tooltip give-icon give-icon-question"
			      data-tooltip="<?php esc_html_e( 'The country for your Gift Aid claim must be the UK.', 'give-gift-aid' ); ?>"></span>
		</label>
		<select
			name="give_gift_aid_billing_country"
			id="<?php echo esc_attr( 'give_gift_aid_billing_country_' . $form_id ); ?>"
			class="give-gift-aid-billing-country billing_country give-select required"
			required
			aria-required="true"
			autocomplete="country-name"
		>
			<?php $selected_country = give_get_country();

			$countries = give_gift_aid_get_country_list();
			foreach ( $countries as $country_code => $country ) {
				echo '<option value="' . $country_code . '"' . selected( $country_code, $selected_country, false ) . '>' . $country . '</option>';
			}// End foreach(). ?>
		</select>
	</p>
	<?php
}

/**
 * Give Gift Aid Function to Print the HTML of Address
 *
 * @since 1.1
 *
 * @param string $form_id .
 */
function give_gift_aid_address_first( $form_id ) {
	?>
	<p id="<?php echo esc_attr( 'give-gift-aid-address-wrap-' . $form_id ); ?>" class="form-row form-row-responsive">
		<label for="<?php echo esc_attr( 'give_gift_aid_card_address_' . $form_id ); ?>" class="give-label">
			<?php esc_html_e( 'Address 1', 'give-gift-aid' ); ?>
			<span class="give-required-indicator">*</span>
			<span class="give-tooltip give-icon give-icon-question"
			      data-tooltip="<?php esc_html_e( 'The primary address of your Gift Aid claim.', 'give-gift-aid' ); ?>"></span>
		</label>
		<input
			type="text"
			id="<?php echo esc_attr( 'give_gift_aid_card_address_' . $form_id ); ?>"
			name="give_gift_aid_card_address"
			class="give-gift-aid-card-address required give-input"
			placeholder="<?php esc_html_e( 'Address line 1', 'give-gift-aid' ); ?>"
			value=""
			aria-required="true"
			autocomplete="address-line1"
		/>
	</p>
	<?php
}

/**
 * Give Gift Aid Function to Print the HTML of Address
 *
 * @since 1.1
 *
 * @param string $form_id .
 */
function give_gift_aid_address_second( $form_id ) {
	?>
	<p id="<?php echo esc_attr( 'give-gift-aid-address2-wrap-' . $form_id ); ?>" class="form-row form-row-responsive">
		<label for="<?php echo esc_attr( 'give_gift_aid_card_address_2_' . $form_id ); ?>" class="give-label">
			<?php esc_html_e( 'Address 2', 'give-gift-aid' ); ?>
			<span class="give-tooltip give-icon give-icon-question"
			      data-tooltip="<?php esc_html_e( '(optional) The secondary address for your Gift Aid claim. Typically an apartment or unit number.', 'give-gift-aid' ); ?>"></span>
		</label>
		<input
			type="text"
			id="<?php echo esc_attr( 'give_gift_aid_card_address_2_' . $form_id ); ?>"
			name="give_gift_aid_card_address_2"
			class="give-gift-aid-card-address required give-input"
			placeholder="<?php esc_html_e( 'Address line 2', 'give-gift-aid' ); ?>"
			value=""
			autocomplete="address-line2"
		/>
	</p>
	<?php
}

/**
 * Give Gift Aid Function to Print the HTML of state
 *
 * @since 1.1
 *
 * @param string $form_id .
 */
function give_gift_aid_address_state( $form_id, $class = 'form-row-first' ) {
	?>
	<p id="<?php echo esc_attr( 'give-gift-aid-state-wrap-' . $form_id ); ?>" class="form-row form-row-responsive <?php echo $class; ?>">
		<label for="<?php echo esc_attr( 'give_gift_aid_card_state_' . $form_id ); ?>"
		       class="give_gift_aid_address_state_label give-label">
			<?php esc_html_e( 'County', 'give-gift-aid' ); ?>
			<span class="give-required-indicator">*</span>
			<span class="give-tooltip give-icon give-icon-question"
			      data-tooltip="<?php esc_html_e( 'The county for your Gift Aid address.', 'give-gift-aid' ); ?>"></span>
		</label>
		<?php
		$selected_state = give_get_state();
		$states         = give_get_states( 'GB' );

		if ( ! empty( $states ) ) : ?>
			<select
				name="give_gift_aid_card_state"
				id="<?php echo esc_attr( 'give_gift_aid_card_state_' . $form_id ); ?>"
				class="give-gift-aid-card-state give-select required"
				required
				aria-required="true"
				autocomplete="address-level1"
			>
				<?php
				foreach ( $states as $state_code => $state ) {
					echo '<option value="' . $state_code . '"' . selected( $state_code, $selected_state, false ) . '>' . $state . '</option>';
				}// End foreach(). ?>
			</select>
		<?php else : ?>
			<input
				type="text"
				size="6"
				name="give_gift_aid_card_state"
				id="<?php echo esc_attr( 'give_gift_aid_card_state_' . $form_id ); ?>"
				class="give-gift-aid-card-state give-input required"
				placeholder="<?php esc_html_e( 'County', 'give-gift-aid' ); ?>"
				autocomplete="address-level1"
			/>
		<?php endif; ?>
	</p>
	<?php
}

/**
 * Give Gift Aid Function to Print the HTML of City
 *
 * @since 1.1
 *
 * @param string $form_id .
 */
function give_gift_aid_address_city( $form_id, $class = 'form-row-wide' ) {
	?>
	<p id="<?php echo esc_attr( 'give-gift-aid-city-wrap-' . $form_id ); ?>" class="form-row form-row-responsive <?php echo $class; ?>">
		<label for="<?php echo esc_attr( 'give_gift_aid_card_city_' . $form_id ); ?>" class="give-label">
			<?php esc_html_e( 'City', 'give-gift-aid' ); ?>
			<span class="give-required-indicator">*</span>
			<span class="give-tooltip give-icon give-icon-question"
			      data-tooltip="<?php esc_html_e( 'The city for your Gift Aid claim.', 'give-gift-aid' ); ?>"></span>
		</label>
		<input
			type="text"
			id="<?php echo esc_attr( 'give_gift_aid_card_city_' . $form_id ); ?>"
			name="give_gift_aid_card_city"
			class="give-gift-aid-card-city required give-input"
			placeholder="<?php esc_html_e( 'City', 'give-gift-aid' ); ?>"
			value=""
			aria-required="true"
			autocomplete="address-level2"
		/>
	</p>
	<?php
}

/**
 * Give Gift Aid Function to Print the HTML of Zipcode
 *
 * @since 1.1
 *
 * @param string $form_id .
 */
function give_gift_aid_address_zipcode( $form_id ) {
	?>
	<p id="<?php echo esc_attr( 'give-gift-aid-zip-wrap-' . $form_id ); ?>" class="form-row form-row-last form-row-responsive">
		<label for="<?php echo esc_attr( 'give_gift_aid_card_zip_' . $form_id ); ?>" class="give-label">
			<?php esc_html_e( 'Postal Code', 'give-gift-aid' ); ?>
			<span class="give-required-indicator">*</span>
			<span class="give-tooltip give-icon give-icon-question"
			      data-tooltip="<?php esc_html_e( 'The postal code for your Gift Aid claim.', 'give-gift-aid' ); ?>"></span>
		</label>
		<input
			type="text"
			size="4"
			id="<?php echo esc_attr( 'give_gift_aid_card_zip_' . $form_id ); ?>"
			name="give_gift_aid_card_zip"
			class="give-gift-aid-card-zip required give-input"
			placeholder="<?php esc_html_e( 'Postal Code', 'give-gift-aid' ); ?>"
			value=""
			aria-required="true"
			autocomplete="postal-code"
		/>
	</p>
	<?php
}

/**
 * Give Gift add address to support new address formatting, added in give version 1.8.14.
 *
 * @since  1.0.0
 * @update 1.1
 *
 * @param string $form_id Donation Form id in which it is being called.
 */
function give_gift_aid_v100_get_address_fields( $form_id ) {
	?>
	<div id="<?php echo esc_attr( 'give-gift-aid-address-fields-' . $form_id ); ?>" class="give-gift-aid-address-fields">
		<?php
		// Print Address field Country
		give_gift_aid_address_country( $form_id );

		// Print Address field First
		give_gift_aid_address_first( $form_id );

		// Print Address field Second
		give_gift_aid_address_second( $form_id );

		// Print Address field State
		give_gift_aid_address_state( $form_id, 'form-row-wide' );

		// Print Address field City
		give_gift_aid_address_city( $form_id, 'form-row-first' );

		// Print Address field Zipcode
		give_gift_aid_address_zipcode( $form_id );
		?>
	</div>
	<?php
}

/**
 * Give Gift add address to support new address formatting, added in give version 1.8.17.
 *
 * @since 1.1
 *
 * @param string $form_id Donation Form id in which it is being called.
 */
function give_gift_aid_v101_get_address_fields( $form_id ) {
	?>
	<div id="<?php echo esc_attr( 'give-gift-aid-address-fields-' . $form_id ); ?>" class="give-gift-aid-address-fields">
		<?php
		// Print Address field Country
		give_gift_aid_address_country( $form_id );

		// Print Address field First
		give_gift_aid_address_first( $form_id );

		// Print Address field Second
		give_gift_aid_address_second( $form_id );

		// Print Address field City
		give_gift_aid_address_city( $form_id );

		// Print Address field State
		give_gift_aid_address_state( $form_id );

		// Print Address field Zipcode
		give_gift_aid_address_zipcode( $form_id );
		?>
	</div>
	<?php
}

/**
 * Add Gift Address fields in Donation Form.
 * Check for Give version and deepening on that call the address fields functions.
 *
 * @since  1.0.0
 * @update 1.1
 *
 * @param string $form_id Donation Form id in which it is being called.
 */
function give_gift_aid_get_address_fields( $form_id ) {
	// Check if GIVE_VERSION constant exists or not.
	if ( defined( 'GIVE_VERSION' ) ) {
		if ( version_compare( GIVE_VERSION, '1.8.16', '>' ) ) {
			give_gift_aid_v101_get_address_fields( $form_id );
		} else {
			give_gift_aid_v100_get_address_fields( $form_id );
		}
	}
}

/**
 * Check if current page is manual donation page.
 *
 * @since 1.1.3
 *
 * @return bool
 */
function give_gift_aid_is_manual_donation_page() {

	if ( isset( $_POST['action'] ) && 'give_md_check_form_setup' === give_clean( $_POST['action'] ) && is_admin() ) {
		return true;
	}

	return false;
}

/**
 * Give Gift Aid Donation Status.
 *
 * @since 1.2.0
 *
 * @param int $donation_id Donation id.
 *
 * @return string $gift_aid_status Gift Aid Status.
 */
function give_gift_aid_donation_status( $donation_id = 0 ) {

	// Get Gift Aid Term and Condition accept/reject.
	$term_condition = give_get_meta( $donation_id, '_give_gift_aid_accept_term_condition', true );
	$is_gift_aid    = give_get_meta( $donation_id, '_give_gift_aid_enable_disable', true );

	$gift_aid_status = __( 'Disabled', 'give-gift-aid' );
	if ( ! empty( $is_gift_aid ) && 'disabled' !== $is_gift_aid && empty( $term_condition ) ) {
		// Gift Aid Term and Condition rejected.
		$gift_aid_status = __( 'Rejected', 'give-gift-aid' );
	} elseif ( ! empty( $term_condition ) && give_is_setting_enabled( $term_condition ) ) {
		// Gift Aid Term and Condition accepted.
		$gift_aid_status = __( 'Accepted', 'give-gift-aid' );
	}

	return $gift_aid_status;

}

/**
 * This function will generate declaration form link.
 *
 * @param int $donation_id Donation ID.
 *
 * @since 1.1.7
 *
 * @return mixed
 */
function give_gift_aid_get_declaration_form_link( $donation_id ) {

	return sprintf(
		'<a id="%1$s" class="give_gift_aid_download_declaration_form" href="%2$s">%3$s</a>',
		'give-gift-aid-download-declaration-form-' . $donation_id,
		esc_url_raw( add_query_arg( array(
			'give_action' => 'download_declaration_form',
			'donation_id' => $donation_id,
		), give_get_history_page_uri() ) ),
		esc_html__( 'Download Declaration Form', 'give-gift-aid' )
	);
}

/**
 * This function will help you modify the donor mismatch text for error notice displayed
 * while downloading the Gift Aid Declaration Form.
 *
 * @since 1.1.7
 *
 * @param string $text Default error notice text for donor mismatch.
 *
 * @return string
 */
function give_gift_aid_modify_donor_mismatch_text( $text ) {

	$action = give_clean( filter_input( INPUT_GET, 'give_action' ) );

	if ( 'download_declaration_form' !== $action ) {
		return $text;
	}

	return __( 'You are trying to download invalid Gift Aid Declaration Form. Please try again.', 'give-gift-aid' );

}

add_filter( 'give_receipt_donor_mismatch_notice_text', 'give_gift_aid_modify_donor_mismatch_text' );
