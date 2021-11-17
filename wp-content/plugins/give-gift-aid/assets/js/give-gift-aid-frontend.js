/**
 * Give Gift Aid Frontend JS.
 */

jQuery( document ).ready( function( $ ) {

	var $body = $( 'body' );

	$(this).on('give_gateway_loaded', function() {
		setTimeout(function() {
			Give_Gift_Aid.init();
		}, 1)
	})

	/**
	 * Show/Hide Billing fields based on Address option selected.
	 */
	$body.on( 'change', '.give_gift_aid_address_option', function() {
		var $form = $( this ).closest( 'form.give-form' );
		if ( ! $form ) {
			$form = $( this ).parents( 'form' );
		}
		Give_Gift_Aid.give_gift_aid_check_address_option( $form );

	} ).change();

	/**
	 * Show/Hide Gift Aid based on Billing Country selected.
	 */
	$body.on( 'change', '#billing_country', function() {
		var $form = $( this ).closest( 'form.give-form' );

		if ( ! $form ) {
			$form = $( this ).parents( 'form' );
		}

		Give_Gift_Aid.give_gift_aid_check_billing_country( $form );

	} ).change();

	/**
	 *  Show/Hide Gift Aid based on Term and Condition of Gift Aid Form.
	 */
	$body.on( 'change', '.give_gift_aid_accept_term_condition', function() {
		var $form = $( this ).closest( 'form.give-form' );

		if ( ! $form ) {
			$form = $( this ).parents( 'form' );
		}

		var is_checked = $form.find( 'input[name="give_gift_aid_accept_term_condition"]' ).is( ':checked' ),
			give_gift_aid_form_id = $form.find( 'input[name="give-form-id"]' ).val(),
			give_gift_aid_address_option_value = $form.find( 'input[name="give_gift_aid_address_option"]:radio:checked' ).val(),
			give_gift_aid_address_wrap = $form.find( '.give-gift-aid-address-wrap' );

		give_gift_aid_address_wrap.hide();
		if ( is_checked ) {
			give_gift_aid_address_wrap.show();
		}

		if ( is_checked && ( 'another_address' === give_gift_aid_address_option_value || 0 === $form.find( '.cc-address' ).length ) ) {
			$form.find( '#give-gift-aid-address-button-' + give_gift_aid_form_id ).hide();
			$form.find( '#give-gift-aid-address-fields-' + give_gift_aid_form_id ).show();
			give_gift_aid_address_wrap.find( 'input:text,input[type=email],select, textarea' ).attr( 'required', true );
			give_gift_aid_address_wrap.find( '#give_gift_aid_card_address_2_' + give_gift_aid_form_id ).attr( 'required', false );
		} else {
			$form.find( '#give-gift-aid-address-button-' + give_gift_aid_form_id ).show();
			$form.find( '#give-gift-aid-address-fields-' + give_gift_aid_form_id ).hide();
			give_gift_aid_address_wrap.find( 'input:text,input[type=email],select, textarea' ).attr( 'required', false );
			give_gift_aid_address_wrap.find( '#give_gift_aid_card_address_2_' + give_gift_aid_form_id ).attr( 'required', false );
		}

	} ).change();

	/**
	 *  Open Magnific Popup for Long explanation.
	 */
	$body.on( 'click', '.give-gift-aid-explanation-content-more', function() {

		let gridItem = $(this).closest( '.give-donation-grid-item-form' ),
		    gridItemId = gridItem.attr( 'id' ),
		    popupLink = $( `a[href="#${gridItemId}"]` ),
		    popupId = popupLink.attr( 'id' ),
		    popupDelay = 0;

		if ( gridItem.length > 0 ) {
			popupDelay = 300;
		}

		var $form = $( this ).closest( 'form.give-form' );

		if ( ! $form ) {
			$form = $( this ).parents( 'form' );
		}

		var gift_aid_long_explanation_wrap = $form.find( '.give-gift-aid-long-explanation-wrap' ),
			give_gift_aid_form_id = $form.find( 'input[name="give-form-id"]' ).val(),
			give_gift_aid_long_explanation_wrap = $form.find( '#give-gift-aid-long-explanation-wrap' + give_gift_aid_form_id ),
			give_gift_aid_long_explanation_content = $form.find( '#give-gift-aid-long-explanation-content-' + give_gift_aid_form_id );

		if ( gridItem.length > 0 ) {
			jQuery.magnificPopup.close();
		}

		setTimeout( function() {
			jQuery.magnificPopup.open( {
				mainClass: give_global_vars.magnific_options.main_class,
				closeOnBgClick: give_global_vars.magnific_options.close_on_bg_click,
				fixedContentPos: true,
				fixedBgPos: true,
				removalDelay: 300,
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

						setTimeout( function() {
							$( `.js-give-grid-modal-launcher#${popupId}` ).click();
						}, 100);
					}
				}
			} );
			Give_Gift_Aid.give_gift_aid_check_display_option( $form );
		}, popupDelay );

	} );

	/**
	 *  Open Model Donation form on Click of Take to my donation.
	 */
	$body.on( 'click', '.give_gift_aid_take_to_my_donation', function() {

		var modal_form_id = $( '.give-gift-aid-long-explanation-wrap' ).data( 'id' ),
			$form = $( this ).parents().find( '.give-form-' + modal_form_id ),
			form_id = $form.find( 'input[name="give-form-id"]' ).val();

		if ( $( '#give-form-' + form_id + '-wrap' ).is( '.give-display-modal, .give-display-button' ) ) {
			$form.find( '.give-btn-modal' ).trigger( 'click' );
			$( '.mfp-close' ).show();
		} else {
			$( '.mfp-close' ).trigger( 'click' );
		}

	} );

	/**
	 * Show/Hide Gift Aid on changing currency using Currency Switcher.
	 */
	$body.on( 'change', 'select[name="give-cs-currency"]', function() {

		var $form = $( this ).closest( 'form.give-form' );

		if ( ! $form ) {
			$form = $( this ).parents( 'form' );
		}

		Give_Gift_Aid.give_currency_switcher_currency_update( $form, $(this).val() );
	}).change();

	$body.on(
		'click',
		'#give-payment-mode-select input',
		function() {
			Give_Gift_Aid.init();
		}
	);

	/**
	 * Show Gift Aid after gateway ajax success call.
	 */
	$( 'input.give-gateway' ).on( 'change', function() {
		var $form = $( this ).closest( 'form.give-form' ), // Get the current donation form object.
			chosen_gateway = $( this ).val(),
			gateway_ajax_url = give_gift_aid_vars.gift_aid_site_url + '/wp-admin/admin-ajax.php?payment-mode=' + chosen_gateway;

		if ( ! $form ) {
			$form = $( this ).parents( 'form' );
		}

		$( document ).ajaxComplete( function( event, XMLHttpRequest, ajaxOptions ) {

			var http_request_url = ajaxOptions.url;
			if ( http_request_url === gateway_ajax_url ) {
				Give_Gift_Aid.give_gift_aid_check_address_option( $form );
				Give_Gift_Aid.give_gift_aid_check_billing_country( $form );
				Give_Gift_Aid.give_gift_aid_check_billing_details( $form );
				give_gift_check_is_billing_address( $form, false );
			}

		} );

	} );

	/**
	 * Check Billing address is enabled/disabled.
	 *
	 * @param $form Donation Form ID.
	 * @param is_required  boolean value passed for required field validate.
	 */
	function give_gift_check_is_billing_address( $form, is_required ) {
		var form_id = $form.find( 'input[name="give-form-id"]' ).val(),
			give_gift_aid_address_option_value = $form.find( 'input[name="give_gift_aid_address_option"]:radio:checked' ).val(),
			give_gift_aid_address_fields_wrap = $form.find( '#give-gift-aid-address-wrap-' + form_id );

		if ( $form.find( '.cc-address' ).length > 0 && 'another_address' !== give_gift_aid_address_option_value ) {
			$form.find( '.give-gift-check-is-billing-address' ).val( 'yes' );
		} else {
			$form.find( '.give-gift-check-is-billing-address' ).val( 'no' );
		}

		if ( is_required ) {
			give_gift_aid_address_fields_wrap.find( 'input:text,input[type=email],select, textarea' ).attr( 'required', true );
			give_gift_aid_address_fields_wrap.find( '#give_gift_aid_card_address_2_' + form_id ).attr( 'required', false );
		} else {
			give_gift_aid_address_fields_wrap.find( 'input:text,input[type=email],select, textarea' ).attr( 'required', false );
			give_gift_aid_address_fields_wrap.find( '#give_gift_aid_card_address_2_' + form_id ).attr( 'required', false );
		}
	}

	/**
	 * Give gift aid init.
	 */
	var Give_Gift_Aid = {

		init: function() {

			$( '.give-form-wrap' ).each( function() {

				// Get the Donation form selector.
				var $form = $( this ).find( '.give-form' );
				var $currency_dropdown = $( 'select[name="give-cs-currency"]' );

				Give_Gift_Aid.give_gift_aid_check_billing_country( $form );
				Give_Gift_Aid.give_gift_aid_check_address_option( $form );
				Give_Gift_Aid.give_gift_aid_check_billing_details( $form );
				Give_Gift_Aid.give_gift_aid_check_display_option( $form );

				if ( $currency_dropdown.length > 0 ) {
					Give_Gift_Aid.give_currency_switcher_currency_update( $form, $currency_dropdown.val() );
				} else {
					Give_Gift_Aid.give_currency_switcher_currency_update( $form, give_global_vars.currency );
				}

			} );
		},

		give_gift_aid_check_address_option: function( $form ) {
			var form_id = $form.find( 'input[name="give-form-id"]' ).val(),
				value = $form.find( 'input[name="give_gift_aid_address_option"]:radio:checked' ).val(),
				give_gift_aid_address_fields = $form.find( '#give-gift-aid-address-fields-' + form_id ),
				give_gift_aid_address_fields_wrap = $form.find( '#give-gift-aid-address-wrap-' + form_id );

			give_gift_aid_address_fields_wrap.hide(); // Hide default address.

			// Get the value of Gift Aid Term Condition.
			var give_gift_aid_accept_term_condition = $form.find( '.give_gift_aid_accept_term_condition' ).is( ':checked' );

			if ( give_gift_aid_accept_term_condition ) {
				give_gift_aid_address_fields_wrap.show(); // Show address wrap.
			}

			// If enable show other fields.
			if ( 'another_address' === value ) {
				give_gift_aid_address_fields.show();
				give_gift_check_is_billing_address( $form, true );
			} else {
				give_gift_aid_address_fields.hide(); // Otherwise, hide rest of fields.
				give_gift_check_is_billing_address( $form, false );
			}
		},

		give_gift_aid_check_billing_details: function( $form ) {

			var form_id = $form.find( 'input[name="give-form-id"]' ).val();

			if ( $form.find( '.cc-address' ).length > 0 ) {
				$form.find( '#give-gift-aid-address-button-' + form_id ).show();
				$form.find( '#give-gift-aid-address-fields-' + form_id ).hide();
			} else {
				$form.find( '#give-gift-aid-address-button-' + form_id ).hide();
				$form.find( '#give-gift-aid-address-fields-' + form_id ).show();
			}
		},

		give_gift_aid_check_display_option: function( $form ) {
			var form_id = $form.find( 'input[name="give-form-id"]' ).val(),
				give_form_wrap =  $( '#give-form-' + form_id + '-wrap' );

			if ( give_form_wrap.hasClass( 'give-display-button' ) || give_form_wrap.hasClass( 'give-display-modal' ) ) {
				$( '.mfp-close' ).remove();
			}
		},

		give_gift_aid_check_billing_country: function( $form ) {
			var give_gift_aid_country = $form.find( 'select[name="billing_country"]' ).val(),
				form_id = $form.find( 'input[name="give-form-id"]' ).val(),
				give_gift_aid_address_fields_wrap = $form.find( '#give-gift-aid-address-wrap-' + form_id ),
				give_gift_aid_dedicate_donation_wrap = $form.find( '#give-gift-aid-dedicate-donation-' + form_id ),
				address_type = $( '.give_gift_aid_address_option:checked' ).val(),
				currency_dropdown = $( 'select[name="give-cs-currency"]' ),
				currency = '';

			if ( typeof give_gift_aid_country === 'undefined' ) {
				give_gift_aid_country = give_gift_aid_vars.gift_aid_base_country;
			}

			if ( currency_dropdown.length > 0 ) {
				currency = currency_dropdown.val();
			} else {
				currency = give_global_vars.currency;
			}

			if ( 'GB' === give_gift_aid_country && 'GBP' === currency ) {
				give_gift_aid_dedicate_donation_wrap.show();

				if ( 'another_address' === address_type ) {
					give_gift_aid_address_fields_wrap.find( 'input:text,input[type=email],select, textarea' ).attr( 'required', true );
					give_gift_aid_address_fields_wrap.find( '#give_gift_aid_card_address_2_' + form_id ).attr( 'required', false );
				}
			} else {
				give_gift_aid_dedicate_donation_wrap.hide();

				if ( 'another_address' === address_type ) {
					give_gift_aid_address_fields_wrap.find( 'input:text,input[type=email],select, textarea' ).attr( 'required', false );
					give_gift_aid_address_fields_wrap.find( '#give_gift_aid_card_address_2_' + form_id ).attr( 'required', false );
				}
			}
		},

		give_currency_switcher_currency_update: function( $form, $currency ) {

			var form_id = $form.find( 'input[name="give-form-id"]' ).val(),
				give_gift_aid_address_fields_wrap = $form.find( '#give-gift-aid-address-wrap-' + form_id ),
				give_gift_aid_dedicate_donation_wrap = $form.find( '#give-gift-aid-dedicate-donation-' + form_id ),
				address_type = $( '.give_gift_aid_address_option:checked' ).val(),
				billing_country = $( '#billing_country' ).val();

			if ( 'undefined' === typeof billing_country ) {
				billing_country = give_gift_aid_vars.gift_aid_base_country;
			}

			if ( 'GBP' === $currency && 'GB' === billing_country ) {
				give_gift_aid_dedicate_donation_wrap.show();

				if ( 'another_address' === address_type ) {
					give_gift_aid_address_fields_wrap.find( 'input:text,input[type=email],select, textarea' ).attr( 'required', true );
					give_gift_aid_address_fields_wrap.find( '#give_gift_aid_card_address_2_' + form_id ).attr( 'required', false );
				}
			} else {
				give_gift_aid_dedicate_donation_wrap.hide();

				if ( 'another_address' === address_type ) {
					give_gift_aid_address_fields_wrap.find( 'input:text,input[type=email],select, textarea' ).attr( 'required', false );
					give_gift_aid_address_fields_wrap.find( '#give_gift_aid_card_address_2_' + form_id ).attr( 'required', false );
				}
			}
		}
	};

	Give_Gift_Aid.init();
} );
