<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://givewp.com
 * @since      1.0.0
 *
 * @package    Give_Gift_Aid
 * @subpackage Give_Gift_Aid/includes/frontend
 * @author     GiveWP <info@givewp.com>
 */

use Give\Receipt\DonationReceipt;
use GiveGiftAid\Receipts\UpdateDonationReceipt;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Give_Gift_Aid
 * @subpackage Give_Gift_Aid/includes/frontend
 * @author     GiveWP <info@givewp.com>
 */
class Give_Gift_Aid_Frontend {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) ); // Enqueue Script for Front-end.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );  // Enqueue Style  for Front-end.
		add_action( 'give_pre_form_output', array( $this, 'section_output' ), 10, 1 ); // Call Hook based on Settings.
		add_action( 'wp_ajax_give_load_gateway', array( $this, 'load_gateway_callback' ), 0 ); // Call Output function after gateway load.
		add_action( 'wp_ajax_nopriv_give_load_gateway', array( $this, 'load_gateway_callback' ), 0 );
		add_action( 'give_checkout_error_checks', array( $this, 'checkout_error_checks' ), 10, 1 ); // Pre-process donation check validation.
		add_action( 'give_insert_payment', array( $this, 'insert_gift_aid_data' ), 10, 1 ); // Store Gift Aid data into the payment meta/User meta.
		add_action( 'give_payment_receipt_after', array( $this, 'donation_receipt_after' ), 10, 2 ); // Show Give Gift Aid Declaration Form Download link.
		add_action( 'give_new_receipt', array( $this, 'addGiftAidDetailItem' ), 10, 1 );
		add_action( 'give_add_email_tags', array( $this, 'add_email_tags' ), 999999 ); // Add email tag in email.
		add_action( 'give_email_preview_template_tags', array( $this, 'email_preview_download_declaration_tag' ), 10, 1 ); // Preview Default Download Declaration tag.
		add_action( 'give_manual_insert_payment', array( $this, 'insert_gift_aid_data' ), 10, 1 );
		add_action( 'give_recurring_record_payment', array( $this, 'insert_data_for_renewal_donation' ), 10, 2 );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function enqueue_styles() {
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		wp_register_style( GIVE_GIFT_AID_SLUG, GIVE_GIFT_AID_PLUGIN_URL . 'assets/css/give-gift-aid-frontend' . $suffix . '.css', array(), GIVE_GIFT_AID_VERSION, 'all' );
		wp_enqueue_style( GIVE_GIFT_AID_SLUG );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function enqueue_scripts() {
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		wp_register_script( GIVE_GIFT_AID_SLUG, GIVE_GIFT_AID_PLUGIN_URL . 'assets/js/give-gift-aid-frontend' . $suffix . '.js', array( 'jquery' ), GIVE_GIFT_AID_VERSION, false );
		wp_enqueue_script( GIVE_GIFT_AID_SLUG );
		wp_localize_script( 'give-gift-aid', 'give_gift_aid_vars', array(
			'gift_aid_site_url'     => site_url(),
			'gift_aid_base_country' => give_get_country(),
		) );

	}

	/**
	 * Call hook for feature dynamic hook placement.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param integer $form_id form id.
	 */
	public function section_output( $form_id ) {
		// Get Gift Aid Location hook.
		$location_hook = give_gift_aid_get_section_location_hook( $form_id );

		// Dynamic hook based on Global/Per-Form settings.
		add_action( $location_hook, array(
			$this,
			'gift_aid_section',
		), 1, 1 );

	}

	/**
	 * Call Gift Aid Section after load gateway ajax callback.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function load_gateway_callback() {
		// Get Form id from the ajax callback.
		$form_id = ! empty( $_POST['give_form_id'] ) ? absint( $_POST['give_form_id'] ) : 0;

		if ( ! empty( $form_id ) ) {

			// Get Gift Aid Section Location hook.
			$location_hook = give_gift_aid_get_section_location_hook( $form_id );

			// Dynamic hook based on Global/Per-Form settings.
			add_action( $location_hook, array(
				$this,
				'gift_aid_section',
			), 0, 1 );

		}// End if().
	}

	/**
	 * Display Gift Aid section.
	 *
	 * @since    1.0.0
	 *
	 * @param int $form_id Donation form id.
	 *
	 * @return mixed|void
	 */
	public function gift_aid_section( $form_id ) {
		remove_action( current_action(), array(
			$this,
			'gift_aid_section',
		), 0 );

		do_action( 'give_gift_aid_section_before', $form_id );

		// Get the value of gift aid form enable or not.
		$is_gift_aid = give_get_meta( $form_id, 'give_gift_aid_enable_disable', true );
		$is_gift_aid = ! empty( $is_gift_aid ) ? $is_gift_aid : 'global';

		if ( give_is_setting_enabled( $is_gift_aid, 'global' ) && give_is_setting_enabled( give_get_option( 'give_gift_aid_enable_disable' ) ) ) {

			// Get the value of gift fieldset title.
			$fieldset_title = give_get_option( 'give_gift_aid_fieldset_title', give_gift_aid_fieldset_default_title() );

			// Get the value of gift explanation content.
			$explanation_content = give_get_option( 'give_gift_aid_explanation_content', give_gift_aid_explanation_default_content() );

			// Get the value of gift checkbox label.
			$checkbox_label = give_get_option( 'give_gift_aid_checkbox_label', give_gift_aid_checkbox_default_label() );

			// Get the value of gift agreement.
			$agreement = give_get_option( 'give_gift_aid_agreement', give_gift_aid_agreement_default_content() );

			// Get the value of gift long explanation enable disable.
			$is_long_explanation = give_get_option( 'give_gift_aid_long_explanation_enable_disable', 'enabled' );

			// Get the value of gift long explanation content.
			$long_explanation_content = give_get_option( 'give_gift_aid_long_explanation_content', give_gift_aid_long_explanation_default_content() );

		} elseif ( give_is_setting_enabled( $is_gift_aid ) ) {

			// Get the value of gift fieldset title.
			$fieldset_title = give_get_meta( $form_id, 'give_gift_aid_fieldset_title', true );
			$fieldset_title = ! empty( $fieldset_title ) ? $fieldset_title : give_gift_aid_fieldset_default_title();

			// Get the value of gift explanation content.
			$explanation_content = give_get_meta( $form_id, 'give_gift_aid_explanation_content', true );
			$explanation_content = ! empty( $explanation_content ) ? $explanation_content : give_gift_aid_explanation_default_content();

			// Get the value of gift checkbox label.
			$checkbox_label = give_get_meta( $form_id, 'give_gift_aid_checkbox_label', true );
			$checkbox_label = ! empty( $checkbox_label ) ? $checkbox_label : give_gift_aid_checkbox_default_label();

			// Get the value of gift agreement.
			$agreement = give_get_meta( $form_id, 'give_gift_aid_agreement', true );
			$agreement = ! empty( $agreement ) ? $agreement : give_gift_aid_agreement_default_content();

			// Get the value of gift long explanation enable disable.
			$is_long_explanation = give_get_meta( $form_id, 'give_gift_aid_long_explanation_enable_disable', true );
			$is_long_explanation = ! empty( $is_long_explanation ) ? $is_long_explanation : 'enabled';

			// Get the value of gift long explanation content.
			$long_explanation_content = give_get_meta( $form_id, 'give_gift_aid_long_explanation_content', true );
			$long_explanation_content = ! empty( $long_explanation_content ) ? $long_explanation_content : give_gift_aid_long_explanation_default_content();

		} else {
			return '';
		}// End if().

		ob_start();

		// Show gift aid fields if we are on manual donation page in backend.
		if ( give_gift_aid_is_manual_donation_page() ) { ?>
			<tr id="<?php echo esc_attr( 'give-gift-aid-dedicate-donation-' . $form_id ); ?>" class="form-field give-gift-aid-row give-gift-aid-dedicate-donation">
				<!-- Give - Gift Aid Start -->

				<th scope="row" valign="top">
					<label><?php echo esc_html( $fieldset_title ); ?></label>
				</th>

				<td style="display: inline-block; float: left; clear: both; width: 50%" id="<?php echo esc_attr( 'give-gift-aid-explanation-content-wrap-' . $form_id ); ?>"
				    class="form-row form-row-responsive">
					<input
							type="hidden"
							name="give_gift_check_is_billing_address"
							value=""
							id="<?php echo esc_attr( 'give-gift-check-is-billing-address-' . $form_id ); ?>"
							class="give-gift-check-is-billing-address"
					/>

					<?php echo give_gift_aid_preview_template_tags( $payment_id = 0, $explanation_content ); ?>

					<?php if ( give_is_setting_enabled( $is_long_explanation ) ) : ?>
						<p class="description"><a href="javascript:void(0);" class="give-gift-aid-explanation-content-more"><?php esc_html_e( 'Tell me more &raquo;', 'give-gift-aid' ); ?></a></p>
					<?php endif; ?>
				</td>


				<td style="display: inline-block; float: left; clear: both;">
					<label for="<?php echo esc_attr( 'give-gift-aid-accept-term-condition-' . $form_id ); ?>"
					       style="cursor: pointer; display: inline; width: calc(100% - 24px); vertical-align: top;" class="give-gift-aid-accept-term-condition">
						<input
								type="checkbox"
								id="<?php echo esc_attr( 'give-gift-aid-accept-term-condition-' . $form_id ); ?>"
								name="give_gift_aid_accept_term_condition"
								class="give_gift_aid_accept_term_condition"
								style="width: 13px; vertical-align: middle; cursor: pointer;"
						/>
						<?php echo $checkbox_label; ?>
					</label>
					<p style="font-size: 12px; margin-top: 5px; color: #9a9a9a; font-style: italic;">
						<?php
						$agreement = str_replace( '{sitename}', get_bloginfo( 'name' ), $agreement );
						echo $agreement;
						?>
					</p>
					<?php if ( give_is_setting_enabled( $is_long_explanation ) ) : ?>
						<div id="give-gift-aid-long-explanation-wrap" class="give-gift-aid-long-explanation-wrap mfp-hide give-gift-aid-white-popup"
						     data-id="<?php echo esc_attr( $form_id ); ?>">
							<div id="give-gift-aid-long-explanation-content" class="give-gift-aid-long-explanation-content">
								<?php echo give_gift_aid_preview_template_tags( $payment_id = 0, $long_explanation_content ); ?>
							</div>
						</div>
					<?php endif; ?>
				</td>

				<td style="width: 100%; display: inline-block; float: left; clear: both;" id="give-gift-aid-address-wrap" class="give-gift-aid-address-wrap">
					<strong><?php esc_html_e( 'Gift Aid Address', 'give-gift-aid' ); ?></strong>

					<ul id="give-gift-aid-address-radio-list" class="give-gift-aid-address-radio-list">
						<li>
							<input
									checked
									type="radio"
									id="give-gift-aid-address-manual"
									class="give_gift_aid_address_option"
									name="give_gift_aid_address_option"
									value="billing_address"
							/>
							<label for="give-gift-aid-address-manual" class="give-gift-aid-address-option"
							       id="give-gift-aid-address">
								<?php esc_html_e( 'Please use the billing details address', 'give-gift-aid' ); ?>
							</label>
						</li>
						<li>
							<input
									type="radio"
									id="give-gift-aid-another-address"
									class="give_gift_aid_address_option"
									name="give_gift_aid_address_option"
									value="another_address"
							/>
							<label for="give-gift-aid-another-address" class="give-gift-aid-address-option"
							       id="give-gift-aid-another-address">
								<?php esc_html_e( 'I\'d like to use another address', 'give-gift-aid' ); ?>
							</label>
						</li>
					</ul>

					<?php give_gift_aid_billing_address_fields( $form_id ); ?>
				</td>
			</tr>

			<?php
		} else { ?>
			<fieldset id="<?php echo esc_attr( 'give-gift-aid-dedicate-donation-' . $form_id ); ?>" class="give-gift-aid-dedicate-donation"> <!-- Give - Gift Aid Start -->
				<input
						type="hidden"
						name="give_gift_check_is_billing_address"
						value=""
						id="<?php echo esc_attr( 'give-gift-check-is-billing-address-' . $form_id ); ?>"
						class="give-gift-check-is-billing-address"
				/>
				<legend><?php echo $fieldset_title; ?></legend>
				<div id="<?php echo esc_attr( 'give-gift-aid-explanation-content-wrap-' . $form_id ); ?>" class="form-row form-row-responsive">
					<?php echo give_gift_aid_preview_template_tags( $payment_id = 0, $explanation_content ); ?>
					<?php if ( give_is_setting_enabled( $is_long_explanation ) ) : ?>
						<div style="display: block; float: left; clear: both;" class="give-gift-aid-explanation-content-more-wrap">
							<a href="javascript:void(0);" class="give-gift-aid-explanation-content-more"><?php esc_html_e( 'Tell me more &raquo;', 'give-gift-aid' ); ?></a>
						</div>
					<?php endif; ?>
				</div>
				<div id="<?php echo esc_attr( 'give-gift-aid-checkbox-label-wrap-' . $form_id ); ?>" class="form-row form-row-responsive">
					<input
							type="checkbox"
							id="<?php echo esc_attr( 'give-gift-aid-accept-term-condition-' . $form_id ); ?>"
							name="give_gift_aid_accept_term_condition"
							class="give_gift_aid_accept_term_condition"
							style="display: inline; width: 13px; vertical-align: middle; cursor: pointer;"
					/>
					<label for="<?php echo esc_attr( 'give-gift-aid-accept-term-condition-' . $form_id ); ?>"
					       style="cursor: pointer; display: inline; width: calc(100% - 24px); vertical-align: top;" class="give-gift-aid-accept-term-condition">
						<?php echo $checkbox_label; ?>
					</label>
					<p style="font-size: 12px; margin-top: 5px; color: #9a9a9a; font-style: italic;">
						<?php
						$agreement = str_replace( '{sitename}', get_bloginfo( 'name' ), $agreement );
						echo $agreement;
						?>
					</p>
				</div>
				<?php if ( give_is_setting_enabled( $is_long_explanation ) ) : ?>
					<div id="<?php echo esc_attr( 'give-gift-aid-long-explanation-wrap-' . $form_id ); ?>" class="give-gift-aid-long-explanation-wrap mfp-hide"
					     data-id="<?php echo esc_attr( $form_id ); ?>">
						<div id="<?php echo esc_attr( 'give-gift-aid-long-explanation-content-' . $form_id ); ?>" class="give-gift-aid-long-explanation-content">
							<?php echo give_gift_aid_preview_template_tags( $payment_id = 0, $long_explanation_content ); ?>
							<a href="javascript:void(0);" class="give_gift_aid_take_to_my_donation"><?php esc_html_e( 'Take me to my donation &raquo;', 'give-gift-aid' ); ?></a>
						</div>
					</div>
				<?php endif; ?>
				<div id="<?php echo esc_attr( 'give-gift-aid-address-wrap-' . $form_id ); ?>" class="give-gift-aid-address-wrap form-row">
					<div id="<?php echo esc_attr( 'give-gift-aid-address-button-' . $form_id ); ?>">
						<label>
							<?php esc_html_e( 'Gift Aid Address', 'give-gift-aid' ); ?>
						</label>
						<ul id="<?php echo esc_attr( 'give-gift-aid-address-radio-list-' . $form_id ); ?>" class="give-gift-aid-address-radio-list">
							<li>
								<input
										checked
										type="radio"
										id="<?php echo esc_attr( 'give-gift-aid-address-manual-' . $form_id ); ?>"
										class="give_gift_aid_address_option"
										name="give_gift_aid_address_option"
										value="billing_address"
								/>
								<label for="<?php echo esc_attr( 'give-gift-aid-address-manual-' . $form_id ); ?>" class="give-gift-aid-address-option"
								       id="<?php echo esc_attr( 'give-gift-aid-address-' . $form_id ); ?>">
									<?php esc_html_e( 'Please use the billing details address', 'give-gift-aid' ); ?>
								</label>
							</li>
							<li>
								<input
										type="radio"
										id="<?php echo esc_attr( 'give-gift-aid-another-address-' . $form_id ); ?>"
										class="give_gift_aid_address_option"
										name="give_gift_aid_address_option"
										value="another_address"
								/>
								<label for="<?php echo esc_attr( 'give-gift-aid-another-address-' . $form_id ); ?>" class="give-gift-aid-address-option"
								       id="<?php echo esc_attr( 'give-gift-aid-address-' . $form_id ); ?>">
									<?php esc_html_e( 'I\'d like to use another address', 'give-gift-aid' ); ?>
								</label>
							</li>
						</ul>
					</div>
					<?php give_gift_aid_billing_address_fields( $form_id ); ?>
				</div>
			</fieldset> <!-- Give - Gift Aid End -->
			<?php
		}
		?>
		<?php
		$gift_aid_fieldset = ob_get_clean();
		echo $gift_aid_fieldset = apply_filters( 'give_gift_aid_front_fields', $gift_aid_fieldset, $form_id );

		do_action( 'give_gift_aid_section_after', $form_id );

	}

	/**
	 * Fires after validating donation form fields.
	 *
	 * Allow you to hook to donation form errors.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param bool|array $valid_data Validate fields.
	 *
	 * @return void
	 */
	public function checkout_error_checks( $valid_data ) {
		$is_billing_address = ! empty( $_POST['give_gift_check_is_billing_address'] ) ? give_clean( $_POST['give_gift_check_is_billing_address'] ) : 'no';
		$term_condition     = ! empty( $_POST['give_gift_aid_accept_term_condition'] ) ? give_clean( $_POST['give_gift_aid_accept_term_condition'] ) : '';

		if ( 'no' === $is_billing_address && give_is_setting_enabled( $term_condition ) ) {

			// Gift aid address 1.
			$address_one = ! empty( $_POST['give_gift_aid_card_address'] ) ? give_clean( $_POST['give_gift_aid_card_address'] ) : '';

			// Gift aid address 1.
			if ( empty( $address_one ) ) {
				give_set_error( 'give_gift_aid_card_address_invalid', __( 'Please enter your address 1.', 'give-gift-aid' ) );
			}

			// Gift aid city.
			$gift_aid_city = ! empty( $_POST['give_gift_aid_card_city'] ) ? give_clean( $_POST['give_gift_aid_card_city'] ) : '';

			// Gift aid city.
			if ( empty( $gift_aid_city ) ) {
				give_set_error( 'give_gift_aid_card_city_invalid', __( 'Please enter your city.', 'give-gift-aid' ) );
			}

			// Gift aid state.
			$gift_aid_state = ! empty( $_POST['give_gift_aid_card_state'] ) ? give_clean( $_POST['give_gift_aid_card_state'] ) : '';

			// Gift aid state.
			if ( empty( $gift_aid_state ) ) {
				give_set_error( 'give_gift_aid_card_state_invalid', __( 'Please enter your state.', 'give-gift-aid' ) );
			}

			// Gift aid Zip/Postal Code.
			$gift_aid_zip = ! empty( $_POST['give_gift_aid_card_zip'] ) ? give_clean( $_POST['give_gift_aid_card_zip'] ) : '';

			// Gift aid Zip/Postal Code.
			if ( empty( $gift_aid_zip ) ) {
				give_set_error( 'give_gift_aid_card_zip_invalid', __( 'Please enter your zip/postal code.', 'give-gift-aid' ) );
			}

			// Gift aid country.
			$gift_aid_country = ! empty( $_POST['give_gift_aid_billing_country'] ) ? give_clean( $_POST['give_gift_aid_billing_country'] ) : 'GB';

			// Validate, if Zip code is valid or not.
			$is_valid = give_donation_form_validate_cc_zip( $gift_aid_zip, $gift_aid_country );

			if ( false === $is_valid ) {
				give_set_error( 'give_gift_aid_card_zip_format_invalid', __( 'Please enter correct zip code.', 'give-gift-aid' ) );
			}
		}// End if().

	}

	/**
	 * Fires while inserting payments.
	 *
	 * Save Gift Aid data into the Payment meta or User meta.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param int $payment_id The payment ID.
	 */
	public function insert_gift_aid_data( $payment_id ) {
		$payment_data = new Give_Payment( $payment_id );
		$form_id      = $payment_data->form_id; // Form ID.
		$donor_id     = $payment_data->customer_id; // Donor ID.
		$donor_object = new Give_Donor( $donor_id );
		$opt_in_date  = $payment_data->date; // Donation date.

		// Get the value of Gift Aid form enable or not.
		$is_gift_aid = give_get_meta( $form_id, 'give_gift_aid_enable_disable', true );
		$is_gift_aid = ! empty( $is_gift_aid ) ? $is_gift_aid : 'global';
		$term_condition = ! empty( $_POST['give_gift_aid_accept_term_condition'] ) ? give_clean( $_POST['give_gift_aid_accept_term_condition'] ) : '';

		$disable_gift_aid = false;

		$billing_country  = '';
		if ( isset( $_POST['billing_country'] ) ) {
			$billing_country = give_clean( $_POST['billing_country'] );
		} elseif ( isset( $_POST['give_gift_aid_billing_country'] ) ) {
			$billing_country = give_clean( $_POST['give_gift_aid_billing_country'] );
		}

		if ( isset( $_POST['give-cs-currency'] )
		     && ( 'GBP' !== give_clean( $_POST['give-cs-currency'] ) || 'GB' !== $billing_country )
		) {
			$disable_gift_aid = true;
		} else if ( 'GB' !== $billing_country ) {
			$disable_gift_aid = true;
		}

		if ( $disable_gift_aid ) {
			$is_gift_aid = 'disabled';
			$term_condition = '';
		}

		give_update_payment_meta( $payment_id, '_give_gift_aid_accept_term_condition', $term_condition );
		give_update_payment_meta( $payment_id, '_give_gift_aid_enable_disable', $is_gift_aid );

		if ( give_is_setting_enabled( $term_condition ) ) {

			// Get the value of Gift Aid billing details or Gift Aid address.
			$is_billing_address = ! empty( $_POST['give_gift_check_is_billing_address'] ) ? give_clean( $_POST['give_gift_check_is_billing_address'] ) : 'no';

			// Check if Billing details disable then use Gift aid address else use Billing details.
			if ( 'no' === $is_billing_address ) {

				$address_one      = ! empty( $_POST['give_gift_aid_card_address'] ) ? give_clean( $_POST['give_gift_aid_card_address'] ) : '';
				$address_two      = ! empty( $_POST['give_gift_aid_card_address_2'] ) ? give_clean( $_POST['give_gift_aid_card_address_2'] ) : '';
				$gift_aid_city    = ! empty( $_POST['give_gift_aid_card_city'] ) ? give_clean( $_POST['give_gift_aid_card_city'] ) : '';
				$gift_aid_country = ! empty( $_POST['give_gift_aid_billing_country'] ) ? give_clean( $_POST['give_gift_aid_billing_country'] ) : '';
				$gift_aid_state   = ! empty( $_POST['give_gift_aid_card_state'] ) ? give_clean( $_POST['give_gift_aid_card_state'] ) : '';
				$gift_aid_zip     = ! empty( $_POST['give_gift_aid_card_zip'] ) ? give_clean( $_POST['give_gift_aid_card_zip'] ) : '';

			} else {

				$address_one      = ! empty( $_POST['card_address'] ) ? give_clean( $_POST['card_address'] ) : '';
				$address_two      = ! empty( $_POST['card_address_2'] ) ? give_clean( $_POST['card_address_2'] ) : '';
				$gift_aid_city    = ! empty( $_POST['card_city'] ) ? give_clean( $_POST['card_city'] ) : '';
				$gift_aid_country = ! empty( $_POST['billing_country'] ) ? give_clean( $_POST['billing_country'] ) : '';
				$gift_aid_state   = ! empty( $_POST['card_state'] ) ? give_clean( $_POST['card_state'] ) : '';
				$gift_aid_zip     = ! empty( $_POST['card_zip'] ) ? give_clean( $_POST['card_zip'] ) : '';

			}// End if().

			$donor_object->update_meta( '_give_gift_aid_card_address', $address_one );
			$donor_object->update_meta( '_give_gift_aid_card_address_2', $address_two );
			$donor_object->update_meta( '_give_gift_aid_card_city', $gift_aid_city );
			$donor_object->update_meta( '_give_gift_aid_country', $gift_aid_country );
			$donor_object->update_meta( '_give_gift_aid_card_state', $gift_aid_state );
			$donor_object->update_meta( '_give_gift_aid_card_zip', $gift_aid_zip );
			$donor_object->update_meta( '_give_gift_aid_opt_in_date', $opt_in_date );

		}
	}

	/**
	 *  Save Gift Aid data into the Payment meta for Renewal donation.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param int|Give_Payment $payment            Donation Object or Donation ID.
	 * @param int              $parent_donation_id Parent Donation ID.
	 */
	public function insert_data_for_renewal_donation( $payment, $parent_donation_id ) {

		if ( $payment instanceof Give_Payment ) {
			$donation_id = $payment->ID;
		} else {
			$donation_id = $payment;
		}

		// Save Gift Aid accept term condition.
		$is_gift_aid = give_get_meta( $parent_donation_id, '_give_gift_aid_enable_disable', true );

		if ( $is_gift_aid ) {

			$term_condition = give_get_meta( $parent_donation_id, '_give_gift_aid_accept_term_condition', true );
			Give()->payment_meta->update_meta( $donation_id, '_give_gift_aid_accept_term_condition', $term_condition );
			Give()->payment_meta->update_meta( $donation_id, '_give_gift_aid_enable_disable', $is_gift_aid );
		}

	}

	/**
	 * Fires in the Donation receipt shortcode, after the receipt last item.
	 *
	 * Allows you to add new <td> elements after the receipt last item.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param object $payment           The payment object.
	 * @param array  $give_receipt_args Receipt_argument.
	 */
	public function donation_receipt_after( $payment, $give_receipt_args ) {
		$payment_id     = $payment->ID;
		$term_condition = give_get_meta( $payment_id, '_give_gift_aid_accept_term_condition', true );

		// Bail out, if Gift aid term and condition not accepted.
		if ( ! give_is_setting_enabled( $term_condition ) ) {
			return;
		}

		ob_start();
		?>
		<tr>
			<td scope="row"><strong><?php esc_html_e( 'Gift Aid', 'give-gift-aid' ); ?></strong></td>
			<td>
				<p><?php esc_html_e( 'Yes, opted in.', 'give-gift-aid' ); ?></p>
				<?php echo give_gift_aid_get_declaration_form_link( $payment_id ); ?>
			</td>
		</tr>
		<?php
		$donation_receipt_html = ob_get_clean();
		echo $donation_receipt_html = apply_filters( 'give_gift_aid_donation_receipt_html', $donation_receipt_html, $payment_id );
	}

	/**
	 * Register gift aid detail item.
	 *
	 * @param DonationReceipt $receipt
	 *
	 * @since 1.2.4
	 */
	public function addGiftAidDetailItem( DonationReceipt $receipt ){
		$updateReceipt = new UpdateDonationReceipt( $receipt );
		$updateReceipt->apply();
	}

	/**
	 * Add tags in email.
	 *
	 * @since  1.2.0
	 * @access public
	 */
	public function add_email_tags() {
		give_add_email_tag( 'download_declaration_form', __( 'Download Declaration Form link', 'give-gift-aid' ), array(
			$this,
			'download_declaration_form_email_tag',
		) );

		give_add_email_tag( 'gift_aid_address', __( "Donor's Address Specified for Gift Aid redemption.", 'give-gift-aid' ), array(
			$this,
			'gift_aid_address_form_tag',
		) );

		give_add_email_tag( 'gift_aid_status', __( "Donor's Donation Gift Aid Status.", 'give-gift-aid' ), array(
			$this,
			'gift_aid_status_form_tag',
		) );
	}


	/**
	 * Add Custom call back function for {download_declaration_form} tag.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param array $payment_data Give payment data.
	 *
	 * @return string $download_declaration_link Declaration link.
	 */
	public function download_declaration_form_email_tag( $payment_data ) {
		$payment_id                = $payment_data['payment_id'];
		$term_condition            = give_get_meta( $payment_data['payment_id'], '_give_gift_aid_accept_term_condition', true );
		$download_declaration_link = '';

		if ( give_is_setting_enabled( $term_condition ) ) {

			$download_declaration_link = give_gift_aid_get_declaration_form_link( $payment_id );
		}

		$download_declaration_link = apply_filters( 'give_gift_aid_download_declaration_link', $download_declaration_link );

		return $download_declaration_link;
	}

	/**
	 * Add custom call back function for {gift_aid_address} tag.
	 *
	 * @since  1.2.0
	 * @access public
	 *
	 * @param array $payment_data Give payment data.
	 *
	 * @return string $full_address full address of donor's gift aid address.
	 */

	public function gift_aid_address_form_tag( $payment_data ) {
		$payment_id     = $payment_data['payment_id'];
		$term_condition = give_get_meta( $payment_data['payment_id'], '_give_gift_aid_accept_term_condition', true );
		$full_address   = '';
		if ( give_is_setting_enabled( $term_condition ) ) {
			$donor_id     = give_get_payment_donor_id( $payment_id );
			$full_address .= give_gift_aid_full_address( $donor_id );
		}

		/**
		 *  Filter to apply changes to donor's gift aid address
		 *
		 * @since 1.2.0
		 *
		 * @param string $full_address full address of Donor's gift aid address.
		 * @param array $payment_data email tag arguments.
		 */

		return apply_filters( 'give_gift_aid_email_tag_address', $full_address, $payment_data );
	}

	/**
	 * Add custom call back function for {gift_aid_status} tag.
	 *
	 * @since  1.2.0
	 * @access public
	 *
	 * @param array $payment_data Give payment data.
	 *
	 * @return string $gift_aid_status Donor's gift aid status.
	 */
	public function gift_aid_status_form_tag( $payment_data ) {
		$payment_id     = $payment_data['payment_id'];

		// Get gift aid donation status
		$gift_aid_status = give_gift_aid_donation_status( $payment_id );

		/**
		 *  Filter to apply changes to donor's gift aid status
		 *
		 * @since 1.2.0
		 *
		 * @param string $gift_aid_status Donor's gift aid status.
		 * @param array $payment_data email tag arguments.
		 */

		return apply_filters( 'give_gift_aid_email_tag_status', $gift_aid_status, $payment_data );
	}

	/**
	 * Preview default Download Declaration link.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param string $message
	 *
	 * @return string $message
	 */
	public function email_preview_download_declaration_tag( $message ) {
		$message = str_replace( '{download_declaration_form}', '<a href="#">Download Declaration Form</a>', $message );
		$message = apply_filters( 'give_gift_aid_default_preview_download_declaration_tag', $message );

		return $message;
	}

}
