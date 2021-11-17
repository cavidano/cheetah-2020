/**
 * Give Gift Aid Admin JS.
 */

jQuery( document ).ready( function( $ ) {

	var give_gift_aid_enable_disable = $( 'input[name="give_gift_aid_enable_disable"]:radio' ),
		give_gift_aid_fields = $( '.give_gift_aid_fields' ),
		give_gift_aid_long_explanation_enable_disable = $( 'input[name="give_gift_aid_long_explanation_enable_disable"]:radio' ),
		give_gift_aid_long_explanation_fields = $( '.give_gift_aid_long_explanation_fields' ),
		billing_country = $( '#billing_country' );

	/**
	 * Insert Gift Aid option and remove old.
	 */
	$( document ).on( 'give_md_check_form_setup', function( e ) {
		var manual_donation_form = $( '#give_md_create_payment' );

		jQuery( manual_donation_form.find( 'tr.give-gift-aid-row' ) ).each( function( i, em ) {
			$( this ).remove();
		} );

		$( e.response.gift_aid_html ).insertAfter( manual_donation_form.find( '#give-md-billing-address' ).closest( '.form-field' ) );

		jQuery( manual_donation_form.find( 'tr.give-gift-aid-row td .give-gift-aid-address-fields p' ) ).each( function( i, em ) {
			$( this ).find( '.give-required-indicator' ).remove();
		} );

		billing_country.change();
		$( '.give_gift_aid_accept_term_condition' ).change();
		$( '.give_gift_aid_address_option' ).change();
	} );

	/**
	 *  Open Magnific Popup for Long explanation.
	 */
	$( document ).on( 'click', '.give-gift-aid-explanation-content-more', function() {

		var $form = $( this ).parents( 'form' );

		var gift_aid_long_explanation_wrap = $form.find( '.give-gift-aid-long-explanation-wrap' ),
			give_gift_aid_long_explanation_wrap = $form.find( '.give-gift-aid-long-explanation-wrap'),
			give_gift_aid_long_explanation_content = $form.find( '.give-gift-aid-long-explanation-content' );

		jQuery.magnificPopup.open( {
			mainClass: 'wrap',
			closeOnBgClick: true,
			fixedContentPos: false,
			fixedBgPos: false,
			items: {
				src: gift_aid_long_explanation_wrap,
				type: 'inline'
			},
			callbacks: {
				open: function() {
					give_gift_aid_long_explanation_wrap.addClass( 'mfp-show' );
					give_gift_aid_long_explanation_wrap.removeClass( 'mfp-hide' );
					give_gift_aid_long_explanation_content.addClass( 'mfp-show' );
				},
				close: function() {
					give_gift_aid_long_explanation_wrap.removeClass( 'mfp-show' );
					give_gift_aid_long_explanation_wrap.addClass( 'mfp-hide' );
				}
			}
		} );

	} );

	/**
	 * Show/Hide Gift Aid based on Billing Country selected.
	 */
	billing_country.on( 'change', function() {
		var $form = $( this ).parents( 'form' ),
			give_gift_aid_country = $( this ).val(),
			give_gift_aid_dedicate_donation_wrap = $form.find( '.give-gift-aid-dedicate-donation' );

		if ( typeof give_gift_aid_country === 'undefined' ) {
			give_gift_aid_country = give_gift_aid_vars.gift_aid_base_country;
		}

		if ( 'GB' === give_gift_aid_country ) {
			give_gift_aid_dedicate_donation_wrap.show();
		} else {
			give_gift_aid_dedicate_donation_wrap.hide();
		}

	} ).change();

	/**
	 * Show/Hide Billing fields based on Address option selected.
	 */
	$( document ).on( 'change', '.give_gift_aid_address_option', function() {

		var $form = $( this ).parents( 'form' ),
			give_gift_aid_address_fields_wrap = $form.find( '.give-gift-aid-address-wrap' );

		give_gift_aid_address_fields_wrap.hide(); // Hide default address.

		// Get the value of Gift Aid Term Condition.
		var give_gift_aid_accept_term_condition = $form.find( '.give_gift_aid_accept_term_condition' ).is( ':checked' );

		if ( give_gift_aid_accept_term_condition ) {
			give_gift_aid_address_fields_wrap.show(); // Show address wrap.
		}

		// If enable show other fields.
		give_gift_aid_toggle_fields( $form );

	} ).change();

	/**
	 *  Show/Hide Gift Aid based on Term and Condition of Gift Aid Form.
	 */
	$( document ).on( 'change', '.give_gift_aid_accept_term_condition', function() {
		var $form = $( this ).parents( 'form' ),
			is_checked = $form.find( 'input[name="give_gift_aid_accept_term_condition"]' ).is( ':checked' ),
			give_gift_aid_address_wrap = $form.find( '.give-gift-aid-address-wrap' );

		give_gift_aid_address_wrap.hide();
		if ( is_checked ) {
			give_gift_aid_address_wrap.show();
		}

		give_gift_aid_toggle_fields( $form );

	} ).change();

	/**
	 * Toggle Gift Aid address fields.
	 *
	 * @param $form
	 */
	function give_gift_aid_toggle_fields( $form ) {
		var give_gift_aid_address_option_value = $form.find( 'input[name="give_gift_aid_address_option"]:radio:checked' ).val(),
			give_gift_aid_address_fields = $form.find( '.give-gift-aid-address-fields' );

		if ( 'another_address' === give_gift_aid_address_option_value ) {
			give_gift_aid_address_fields.show();
			$form.find( '.give-gift-check-is-billing-address' ).val( 'no' );
		} else {
			give_gift_aid_address_fields.hide();
			$form.find( '.give-gift-check-is-billing-address' ).val( 'yes' );
		}
	}

	/**
	 *  Show/Hide Gift Aid field options.
	 */
	give_gift_aid_enable_disable.on( 'change', function() {

		var value = $( 'input[name="give_gift_aid_enable_disable"]:radio:checked' ).val();

		// If enable show other fields.
		if ( value === 'enabled' ) {
			give_gift_aid_fields.show();
		} else {
			give_gift_aid_fields.hide(); // Otherwise, hide rest of fields.
		}

		give_gift_aid_long_explanation_enable_disable.change();

	} ).change();

	/**
	 *  Show/Hide Gift Aid long explanation.
	 */
	give_gift_aid_long_explanation_enable_disable.on( 'change', function() {

		var value = $( 'input[name="give_gift_aid_long_explanation_enable_disable"]:radio:checked' ).val(),
			give_gift_global_value = $( 'input[name="give_gift_aid_enable_disable"]:radio:checked' ).val();

		if ( give_gift_global_value !== 'enabled' ) {
			return false;
		}

		// If enable show other fields.
		if ( value === 'enabled' ) {
			give_gift_aid_long_explanation_fields.show();
		} else {
			give_gift_aid_long_explanation_fields.hide(); // Otherwise, hide rest of fields.
		}

	} ).change();

	/**
	 * Gift Aid Report page js.
	 */
	var Give_Gift_Aid_Report = {
		init: function() {
			this.handle_bulk_delete();
		},

		handle_bulk_delete: function() {
			var $give_gift_aid_filters = $( '#give-gift-aid-filter' );

			/**
			 * Gift Aid filters.
			 */
			$give_gift_aid_filters.on( 'submit', function() {
				var current_action = $( 'select[name="action"]', $( this ) ).val(),
					$gift_aid_payments = [],
					confirm_action_notice = '';

				$( 'input[name="gift_aid_payment[]"]:checked', $( this ) ).each( function() {
					$gift_aid_payments.push( $( this ).val() );
				} );

				// Total Gift Aid donation count.
				$gift_aid_payments = $gift_aid_payments.length.toString();

				switch ( current_action ) {
					case 'delete-entries':
						// Check if admin did not select any donation.
						if ( ! parseInt( $gift_aid_payments ) ) {
							alert( give_gift_aid_vars.bulk_action.delete_gift_aid_donation.zero_donation_selected );
							return false;
						}

						// Ask admin before delete declaration donation entries.
						confirm_action_notice = ( 1 < $gift_aid_payments ) ? give_gift_aid_vars.bulk_action.delete_gift_aid_donation.delete_donations : give_gift_aid_vars.bulk_action.delete_gift_aid_donation.delete_donation;
						if ( ! window.confirm( confirm_action_notice.replace( '{gift_aid_donation_count}', $gift_aid_payments ) ) ) {
							return false;
						}

						break;

					case 'download-declaration-forms':
						// Check if admin did not select any download declaration forms.
						if ( ! parseInt( $gift_aid_payments ) ) {
							alert( give_gift_aid_vars.bulk_action.download_gift_aid_declaration_form.zero_declaration_form_selected );
							return false;
						}

						// Ask admin before download declaration forms.
						confirm_action_notice = ( 1 < $gift_aid_payments ) ? give_gift_aid_vars.bulk_action.download_gift_aid_declaration_form.declaration_forms : give_gift_aid_vars.bulk_action.download_gift_aid_declaration_form.declaration_form;
						if ( ! window.confirm( confirm_action_notice.replace( '{gift_aid_donation_count}', $gift_aid_payments ) ) ) {
							return false;
						}

						break;
				}

				return true;
			} );
		}
	};

	Give_Gift_Aid_Report.init();

} );