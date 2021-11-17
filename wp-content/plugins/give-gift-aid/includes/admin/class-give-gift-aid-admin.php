<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://givewp.com
 * @since      1.0.0
 *
 * @package    Give_Gift_Aid
 * @subpackage Give_Gift_Aid/includes/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Give_Gift_Aid
 * @subpackage Give_Gift_Aid/includes/admin
 * @author     GiveWP <info@givewp.com>
 */
class Give_Gift_Aid_Admin {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) ); // Enqueue Styles for Admin.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) ); // Enqueue Script.
		add_filter( 'give-settings_get_settings_pages', array( $this, 'global_settings' ), 10, 1 ); // Add Give - Gift Aid settings.
		add_filter( 'give_metabox_form_data_settings', array( $this, 'per_form_settings' ), 10, 2 ); // Register Give - Gift Aid Section and Settings on Per-Form.
		add_filter( 'give_gift_aid_per_form_fields', array( $this, 'per_form_settings_callback' ), 10 );
		add_action( 'give_donor_before_tables', array( $this, 'metabox_callback' ), 10, 1 ); // Add Gift Aid meta box on Donor profile.
		add_filter( 'give-reports_get_settings_pages', array( $this, 'add_report_page' ) ); // Register report page.
		add_action( 'give_gift_aid_reports', array( $this, 'show_report' ) ); // Gift Aid report view.
		add_action( 'give_payments_table_columns', array( $this, 'report_column' ), 10, 1 ); // Gift Aid column on donation listing page.
		add_action( 'give_payments_table_column', array( $this, 'column_data' ), 9, 3 ); // Gift Aid Term and Condition column show data.
		add_action( 'give_edit-give-gift-aid', array( $this, 'update_gift_aid' ), 10, 1 ); // Update Gift Aid Information from Donor meta.
		add_action( 'give_tools_tab_export_table_bottom', array( $this, 'gift_aid_export' ) ); // Add Give Gift Aid export.
		add_action( 'give_batch_export_class_include', array( $this, 'include_batch_processor' ), 10, 1 ); // Loads the Give Gift Aid batch process if needed.
		add_action( 'give_download_declaration_form', array( $this, 'download_declaration_form' ) ); // Download Declaration Form.
		add_action( 'init', array( $this, 'download_bulk_declaration_form' ) ); // Download Bulk Declaration Form.
		add_action( 'give_view_donation_details_billing_after', array( $this, 'gift_aid_meta_box' ), 10, 1 ); // Show Gift Aid meta box on donation detail.
		add_action( 'admin_notices', array( $this, 'show_admin_notice' ), 10 ); // Call Admin notice.
		add_filter( 'give_md_check_form_setup_response', array( $this, 'give_gift_aid_include_response' ), 10, 2 ); // Include the response when change the form.
		add_filter( 'save_post_give_payment', array( $this, 'update_claimed_status' ), 10, 1 ); // Include the response when change the form.

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function enqueue_styles() {
		global $post_type;

		if ( ( isset( $_GET['page'] ) && 'give-settings' === $_GET['page'] )
		     || ( isset( $_GET['post_type'] )
		          && 'give_forms' === $_GET['post_type'] )
		     || ( 'give_forms' === $post_type ) ) {

			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

			wp_register_style( GIVE_GIFT_AID_SLUG, GIVE_GIFT_AID_PLUGIN_URL . 'assets/css/give-gift-aid-admin' . $suffix . '.css', array(), GIVE_GIFT_AID_VERSION, 'all' );
			wp_enqueue_style( GIVE_GIFT_AID_SLUG );

		}

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function enqueue_scripts() {
		global $post_type;

		if ( ( isset( $_GET['page'] )
		       && 'give-settings' === $_GET['page'] )
		     || ( isset( $_GET['post_type'] )
		          && 'give_forms' === $_GET['post_type'] )
		     || ( 'give_forms' === $post_type ) ) {

			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

			wp_register_script( GIVE_GIFT_AID_SLUG, GIVE_GIFT_AID_PLUGIN_URL . 'assets/js/give-gift-aid-admin' . $suffix . '.js', array( 'jquery' ), GIVE_GIFT_AID_VERSION, false );
			wp_enqueue_script( GIVE_GIFT_AID_SLUG );

			// Localize strings & variables for JS.
			wp_localize_script( 'give-gift-aid', 'give_gift_aid_vars', array(
				'bulk_action' => array(
					'delete_gift_aid_donation'           => array(
						'zero_donation_selected' => __( 'You must choose at least one or more gift aid donations to delete.', 'give-gift-aid' ),
						'delete_donation'        => __( 'Are you sure you want to delete this gift aid donation?', 'give-gift-aid' ),
						'delete_donations'       => __( 'Are you sure you want to delete the selected {gift_aid_donation_count} gift aid donations?', 'give-gift-aid' ),
					),
					'download_gift_aid_declaration_form' => array(
						'zero_declaration_form_selected' => __( 'You must choose at least one or more gift aid donations to download declaration form.', 'give-gift-aid' ),
						'declaration_form'               => __( 'Are you sure you want to download the gift aid declaration form?', 'give-gift-aid' ),
						'declaration_forms'              => __( 'Are you sure you want to download {gift_aid_donation_count} gift aid declaration forms?', 'give-gift-aid' ),
					),
				),
				'gift_aid_base_country' => give_get_country(),
			) );

		}// End if().
	}

	/**
	 * Add custom core plugin setting.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param array $settings Give Settings.
	 *
	 * @return array $settings Give Settings.
	 */
	public function global_settings( $settings ) {

		$settings[] = include( GIVE_GIFT_AID_PLUGIN_DIR . '/includes/admin/class-give-gift-aid-settings.php' );

		return $settings;
	}

	/**
	 * Register 'Gift Aid' menu on edit donation form.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param array $setting section array.
	 * @param int   $post_id donation form id.
	 *
	 * @return array $settings return the Gift Aid sections array.
	 */
	public function per_form_settings( $setting, $post_id ) {
		// Appending the Git Aid option section.
		$setting['gift_aid_per_form_options'] = apply_filters( 'gift_aid_per_form_options', array(
			'id'        => 'give_gift_aid_options',
			'title'     => __( 'Gift Aid', 'give-gift-aid' ),
			'icon-html' => '<span class="gift-aid-icon-coin-pound"></span>',
			'fields'    => apply_filters( 'give_gift_aid_per_form_fields', array() ),
		) );

		return $setting;
	}

	/**
	 * Register Setting fields for 'Gift Aid' section in donation form edit page.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return array Settings array.
	 */
	public function per_form_settings_callback() {
		$is_global = false; // Set Global flag.

		$settings = give_gift_aid_settings( $is_global );

		return $settings;
	}

	/**
	 * Include Gift Aid report on admin settings.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param array $settings Settings array.
	 *
	 * @return array Settings.
	 */
	public function add_report_page( $settings ) {
		// Gift AId.
		$settings[] = include( GIVE_GIFT_AID_PLUGIN_DIR . '/includes/admin/class-give-gift-aid-reports.php' );

		// Output.
		return $settings;
	}

	/**
	 * Give gift aid added donor gift aid address.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param \Give_Donor $donor_object Donor Object.
	 */
	public function metabox_callback( $donor_object ) {
		$donor_id           = $donor_object->id;
		$donor_donation_ids = $donor_object->payment_ids;
		$donor_donation_ids = explode( ',', $donor_donation_ids );
		rsort( $donor_donation_ids );

		$donor_donation_id = $donor_donation_ids[0];
		$payment_data = new Give_Payment( $donor_donation_id );
		$form_title   = $payment_data->form_title; // Form title.
		$form_id      = $payment_data->form_id; // Form ID.
		$payment_id   = $payment_data->ID;

		$address_one      = $donor_object->get_meta( '_give_gift_aid_card_address', true );
		$address_two      = $donor_object->get_meta( '_give_gift_aid_card_address_2', true );
		$gift_aid_city    = $donor_object->get_meta( '_give_gift_aid_card_city', true );
		$gift_aid_zip     = $donor_object->get_meta( '_give_gift_aid_card_zip', true );
		$gift_aid_country = $donor_object->get_meta( '_give_gift_aid_country', true );
		$gift_aid_state   = $donor_object->get_meta( '_give_gift_aid_card_state', true );
		$opt_in_date      = $donor_object->get_meta( '_give_gift_aid_opt_in_date', true );
		$opt_in_date      = ! empty( $opt_in_date ) ? $opt_in_date : $payment_data->post_date;
		$opt_in_date      = strtotime( $opt_in_date );
		$term_condition   = give_get_meta( $payment_id, '_give_gift_aid_accept_term_condition', true );

		// Bail out, if Gift aid term and condition not accepted.
		if ( ! give_is_setting_enabled( $term_condition ) ) {
			return;
		}

		do_action( 'give_gift_aid_address_metabox_before' );

		ob_start();
		?>
		<h3 class="gift-aid-donor-meta-heading"><?php esc_html_e( 'Gift Aid', 'give-gift-aid' ); ?></h3>

		<div id="give-gift-aid-address-details" class="postbox">
			<form id="edit-give-aid-info" method="post"
			      action="<?php echo esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-donors&view=overview&id=' . $donor_id ) ); ?>">
				<div class="inside give-gift-aid-donor-meta-inside">
						<div id="give-gift-aid-declaration-details" class="give-clearfix">

							<div class="column give-gift-aid-optin-donation">
								<p>
									<strong><?php esc_html_e( 'Opt-in Donation', 'give-gift-aid' ); ?></strong><br>
									<?php
									// Donation ID
									printf( '<a href="%1$s" aria-label="%2$s">%3$s</a> - ', esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-payment-history&view=view-payment-details&id=' . $donor_donation_id ) ), "#{$donor_donation_id}", "#{$donor_donation_id}" );
									// Donation Form Link
									printf( '<a href="%1$s" aria-label="%2$s">%3$s</a>', esc_url( admin_url( 'post.php?action=edit&post=' . $form_id ) ), $form_title, $form_title );
									// Donation amount.
									echo ' ' . give_donation_amount( $donor_donation_id ); ?>
								</p>
							</div>
							<div class="column give-gift-aid-declaration-form">
									<p>
										<strong><?php esc_html_e( 'Declaration', 'give-gift-aid' ); ?></strong><br>
										<?php echo give_gift_aid_get_declaration_form_link( $donor_donation_id ); ?>
									</p>
							</div>
							<div class="column give-gift-aid-declaration-opt-date">
									<p>
										<strong><?php esc_html_e( 'Opt-in Date', 'give-gift-aid' ); ?></strong><br>
										<input
												type="text"
												class="give_datepicker give-gift-aid-declaration-opt-date"
												value="<?php echo date( 'm/d/y', $opt_in_date ); ?>"
												id="give_gift_aid_declaration_opt_date"
												name="give_gift_aid_declaration_opt_date"
										/>
										<span class="dashicons dashicons-calendar-alt"></span>
									</p>
							</div>

							<div class="column give-gift-aid-declaration-time-hour">
								<p>
									<strong for="give-gift-aid-declaration-time-hour" class="strong"><?php esc_html_e( 'Opt-in Time', 'give-gift-aid' ); ?></strong><br>
									<input
											type="number"
											step="1"
											max="24"
											id="give_gift_aid_time_hour"
											name="give_gift_aid_time_hour"
											value="<?php echo esc_attr( date_i18n( 'H', $opt_in_date ) ); ?>"
											class="small-text give_gift_aid_time_hour"
									/>&nbsp;:&nbsp;<input
											type="number"
											step="1"
											max="59"
											id="give_gift_aid_time_min"
											name="give_gift_aid_time_min"
											value="<?php echo esc_attr( date( 'i', $opt_in_date ) ); ?>"
											class="small-text give_gift_aid_time_min"
									/>
								</p>
							</div>
						</div>
					<div id="give-gift-aid-address-details-form">
						<div class="give-gift-aid-address-details-form give-clearfix">
							<h3><?php esc_html_e( 'Gift Aid Address', 'give-gift-aid' ); ?></h3>
							<div class="column">
								<div class="give-gift-aid-address-form-country">
									<p>
										<strong><?php esc_html_e( 'Country', 'give-gift-aid' ); ?></strong><br>
										<select
											name="give_gift_aid_country"
											id="give_gift_aid_country"
											class="give-gift-aid-country billing_country give-select required"
											required
											aria-required="true"
										>
											<?php $selected_country = ! empty( $gift_aid_country ) ? $gift_aid_country : give_get_country();
											$countries              = give_gift_aid_get_country_list();
											foreach ( $countries as $country_code => $country ) {
												echo '<option value="' . $country_code . '"' . selected( $country_code, $selected_country, false ) . '>' . $country . '</option>';
											}// End foreach(). ?>
										</select>
									</p>
								</div>
							</div>
							<div class="column">
								<div class="give-gift-aid-address-form-address-line1">
									<p>
										<strong><?php esc_html_e( 'Address Line 1', 'give-gift-aid' ); ?></strong><br>
										<input
												type="text"
												id="give_gift_aid_address_line_1"
												class="give-gift-aid-address-line-1"
												name="give_gift_aid_address_line_1"
												value="<?php echo ! empty( $address_one ) ? $address_one : ''; ?>"
												placeholder="<?php esc_html_e( 'Address Line 1', 'give-gift-aid' ); ?>"
										/>
									</p>
								</div>
							</div>
							<div class="column">
								<div class="give-gift-aid-address-form-address-line2">
									<p>
										<strong><?php esc_html_e( 'Address Line 2', 'give-gift-aid' ); ?></strong><br>
										<input
												type="text"
												id="give_gift_aid_address_line_2"
												class="give-gift-aid-address-line-2"
												name="give_gift_aid_address_line_2"
												value="<?php echo ! empty( $address_two ) ? $address_two : ''; ?>"
												placeholder="<?php esc_html_e( 'Address Line 2', 'give-gift-aid' ); ?>"
										/>
									</p>
								</div>
							</div>
							<div class="column">
								<div class="give-gift-aid-address-form-city">
									<p>
										<strong><?php esc_html_e( 'City', 'give-gift-aid' ); ?></strong><br>
										<input
												type="text"
												id="give_gift_aid_address_city"
												class="give-gift-aid-city"
												name="give_gift_aid_city"
												value="<?php echo ! empty( $gift_aid_city ) ? $gift_aid_city : ''; ?>"
												placeholder="<?php esc_html_e( 'City', 'give-gift-aid' ); ?>"
										/>
									</p>
								</div>
							</div>
							<div class="column">
								<div class="give-gift-aid-address-form-state">
									<p>
										<strong><?php esc_html_e( 'County', 'give-gift-aid' ); ?></strong><br>
										<input
											type="text"
											size="6"
											name="give_gift_aid_state"
											id="give_gift_aid_state"
											class="give-gift-aid-state"
											value="<?php echo ! empty( $gift_aid_state ) ? esc_attr( $gift_aid_state ) : ''; ?>"
											placeholder="<?php esc_html_e( 'County', 'give-gift-aid' ); ?>"
										/>
									</p>
								</div>
							</div>
							<div class="column">
								<div class="give-gift-aid-address-form-zip-code">
									<p>
										<strong><?php esc_html_e( 'Postal Code', 'give-gift-aid' ); ?></strong><br>
										<input
												type="text"
												id="give_gift_aid_zip_code"
												class="give-gift-aid-zip-code"
												name="give_gift_aid_zip_code"
												value="<?php echo ! empty( $gift_aid_zip ) ? $gift_aid_zip : ''; ?>"
												placeholder="<?php esc_html_e( 'Postal Code', 'give-gift-aid' ); ?>"
										/>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>

				<span id="give-gift-aid-edit-actions">
					<input type="hidden" data-key="id" name="give_gift_aid_donor_id" value="<?php echo esc_attr( $donor_id ); ?>" />
					<input type="hidden" name="give_action" value="edit-give-gift-aid" />
					<input type="submit" id="give-gift-aid-edit-save" class="button-secondary" value="<?php esc_attr_e( 'Update Gift Aid', 'give-gift-aid' ); ?>" />
					<a id="give-gift-aid-edit-cancel" href="" class="delete"><?php esc_html_e( 'Cancel', 'give-gift-aid' ); ?></a>
				</span>
				<?php wp_nonce_field( 'edit-give-gift-aid', '_wpnonce', false, true ); ?>
			</form>
		</div>
		<?php
		$gift_aid_metabox = ob_get_clean();
		echo $gift_aid_metabox;
		do_action( 'give_gift_aid_address_metabox_after' );
	}

	/**
	 * Renders the Reports Gift Aid.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @uses   Give_Donor_Reports_Table::prepare_items()
	 * @uses   Give_Donor_Reports_Table::display()
	 *
	 * @return void
	 */
	public function show_report() {
		include( GIVE_GIFT_AID_PLUGIN_DIR . '/includes/admin/class-give-gift-aid-reports-table.php' );

		$give_table = new Give_Gift_Aid_Reports_Table();
		$give_table->prepare_items();
		?>
		<div class="wrap give-gift-aid-wrap">
			<?php
			/**
			 * Fires before the Gift Aid Report.
			 *
			 * @since 1.0.0
			 */
			do_action( 'give_gift_aid_report_table_top' );
			?>

			<form id="give-gift-aid-filter" method="get">
				<?php
				$give_table->display();
				?>
				<input type="hidden" name="post_type" value="give_forms" />
				<input type="hidden" name="page" value="give-reports" />
				<input type="hidden" name="tab" value="gift-aid" />
			</form>
			<?php
			/**
			 * Fires after the Gift Aid Report.
			 *
			 * @since 1.0.0
			 */
			do_action( 'give_gift_aid_report_table_bottom' );
			?>
		</div>
		<?php
	}

	/**
	 * Add new Gift Aid Column.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param array $columns Retrieve all columns.
	 *
	 * @return array Column array.
	 */
	public function report_column( $columns ) {
		unset( $columns['details'] );

		$columns['gift_aid'] = __( 'Gift Aid', 'give-gift-aid' );
		$columns['details']  = __( 'Details', 'give-gift-aid' );

		return $columns;
	}

	/**
	 * Show Gift Aid information.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param string $value       Value of Gift Aid.
	 * @param int    $donation_id Donation ID.
	 * @param string $column_name Column name.
	 *
	 * @return string Column value.
	 */
	public function column_data( $value, $donation_id, $column_name ) {

		if ( 'gift_aid' === $column_name ) {

			// Get gift aid donation status
			$value = give_gift_aid_donation_status( $donation_id );

		}

		return $value;
	}

	/**
	 * Processes a Gift Aid Information.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param  array $args The $_POST array being passed.
	 *
	 * @return bool
	 */
	public function update_gift_aid( $args ) {

		$donor_edit_role = apply_filters( 'give_edit_donors_role', 'edit_give_payments' );
		$nonce           = $args['_wpnonce'];
		$donor_id        = $args['give_gift_aid_donor_id'];

		$donor_object = new Give_Donor( $donor_id );

		if ( ! is_admin() || ! current_user_can( $donor_edit_role ) ) {
			wp_die( __( 'You do not have permission to edit this donor.', 'give-gift-aid' ), __( 'Error', 'give-gift-aid' ), array(
				'response' => 403,
			) );
		}

		if ( empty( $args ) ) {
			return false;
		}

		if ( ! wp_verify_nonce( $nonce, 'edit-give-gift-aid' ) ) {
			wp_die( __( 'Cheatin&#8217; uh?', 'give-gift-aid' ), __( 'Error', 'give-gift-aid' ), array(
				'response' => 400,
			) );
		}

		$address_one      = ! empty( $args['give_gift_aid_address_line_1'] ) ? sanitize_text_field( $args['give_gift_aid_address_line_1'] ) : '';
		$address_two      = ! empty( $args['give_gift_aid_address_line_2'] ) ? sanitize_text_field( $args['give_gift_aid_address_line_2'] ) : '';
		$gift_aid_city    = ! empty( $args['give_gift_aid_city'] ) ? sanitize_text_field( $args['give_gift_aid_city'] ) : '';
		$gift_aid_country = ! empty( $args['give_gift_aid_country'] ) ? sanitize_text_field( $args['give_gift_aid_country'] ) : '';
		$gift_aid_zip     = ! empty( $args['give_gift_aid_zip_code'] ) ? sanitize_text_field( $args['give_gift_aid_zip_code'] ) : '';
		$gift_aid_state   = ! empty( $args['give_gift_aid_state'] ) ? sanitize_text_field( $args['give_gift_aid_state'] ) : '';
		$opt_in_date      = ! empty( $args['give_gift_aid_declaration_opt_date'] ) ? sanitize_text_field( $args['give_gift_aid_declaration_opt_date'] ) : '';
		$opt_in_hour      = ! empty( $args['give_gift_aid_time_hour'] ) ? sanitize_text_field( $args['give_gift_aid_time_hour'] ) : '';
		$opt_in_min       = ! empty( $args['give_gift_aid_time_min'] ) ? sanitize_text_field( $args['give_gift_aid_time_min'] ) : '';

		// Restrict to our high and low.
		if ( $opt_in_hour > 23 ) {
			$opt_in_hour = 23;
		} elseif ( $opt_in_hour < 0 ) {
			$opt_in_hour = 00;
		}

		// Restrict to our high and low.
		if ( $opt_in_min > 59 ) {
			$opt_in_min = 59;
		} elseif ( $opt_in_min < 0 ) {
			$opt_in_min = 00;
		}

		$opt_in_date = date( 'Y-m-d', strtotime( $opt_in_date ) ) . ' ' . $opt_in_hour . ':' . $opt_in_min . ':00';

		$donor_object->update_meta( '_give_gift_aid_card_address', $address_one );
		$donor_object->update_meta( '_give_gift_aid_card_address_2', $address_two );
		$donor_object->update_meta( '_give_gift_aid_card_city', $gift_aid_city );
		$donor_object->update_meta( '_give_gift_aid_country', $gift_aid_country );
		$donor_object->update_meta( '_give_gift_aid_card_state', $gift_aid_state );
		$donor_object->update_meta( '_give_gift_aid_card_zip', $gift_aid_zip );
		$donor_object->update_meta( '_give_gift_aid_opt_in_date', $opt_in_date );

		return true;
	}

	/**
	 * Give gift aid Export.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function gift_aid_export() {
		?>
		<tr class="give-gift-aid-export-history">
			<td scope="row" class="row-title">
				<h3>
					<span><?php esc_html_e( 'Gift Aid Donations', 'give-gift-aid' ); ?></span>
				</h3>
				<p><?php esc_html_e( 'Download a CSV file containing information that you can use for bulk submitting Gift Aid declarations to the HMRC online using you account.', 'give-gift-aid' ); ?></p>
			</td>
			<td>
				<form id="give_gift_aid_export" class="give-export-form" method="post">
					<?php
					// Start Date form field for gift aid.
					echo Give()->html->date_field( array(
						'id'          => 'give_gift_aid_export_start_date',
						'name'        => 'give_gift_aid_export_start_date',
						'placeholder' => esc_attr__( 'Start date', 'give-gift-aid' ),
						'autocomplete' => 'off'
					) );

					// End Date form field for gift aid.
					echo Give()->html->date_field( array(
						'id'          => 'give_gift_aid_export_end_date',
						'name'        => 'give_gift_aid_export_end_date',
						'placeholder' => esc_attr__( 'End date', 'give-gift-aid' ),
						'autocomplete' => 'off'
					) );

					// Give-Gift Aid forms drop-down for export.
					echo Give()->html->forms_dropdown( array(
						'name'   => 'forms',
						'id'     => 'give_gift_aid_export_form',
						'chosen' => true,
					) );
					?>
					<select name="status" id="give-gift-aid-export-donations-status">
						<option value="any"><?php _e( 'All Statuses', 'give-gift-aid' ); ?></option>
						<?php
						$statuses = give_get_payment_statuses();
						foreach ( $statuses as $status => $label ) {
							echo '<option value="' . $status . '">' . $label . '</option>';
						}
						?>
					</select>

					<?php wp_nonce_field( 'give_ajax_export', 'give_ajax_export' ); ?>
					<input type="hidden" name="give-export-class" value="Give_Gift_Aid_Export" />
					<span>
					<input type="submit" value="<?php esc_attr_e( 'Generate CSV', 'give-gift-aid' ); ?>" class="button-secondary" />
					<span class="spinner"></span>
					</span>
				</form>
			</td>
		</tr>
		<?php
	}

	/**
	 * Loads the Give Gift Aid batch process if needed.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param  string $class The class being requested to run for the batch export.
	 *
	 * @return void
	 */
	public function include_batch_processor( $class ) {

		if ( 'Give_Gift_Aid_Export' === $class ) {
			require_once( GIVE_GIFT_AID_PLUGIN_DIR . '/includes/admin/class-give-gift-aid-export.php' );
		}

	}

	/**
	 * Download declaration form.
	 *
     * @param array $args Query String Arguments.
     *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function download_declaration_form( $args ) {

		// Get Donation ID.
		$donation_id    = ! empty( $args['donation_id'] ) ? absint( $args['donation_id'] ) : 0;
		$term_condition = give_get_meta( $donation_id, '_give_gift_aid_accept_term_condition', true );

		// Bail out, if Gift aid term and condition not accepted.
		if ( ! give_is_setting_enabled( $term_condition ) ) {
			return;
		}

		// Provide access to download the declaration form only if user has access to view receipts.
		if ( give_can_view_receipt( $donation_id ) ) {

			// Download Gift Aid Declaration Form.
			give_gift_aid_declaration_form_download( array( $donation_id ) );
		}
	}

	/**
	 * Download bulk declaration form.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function download_bulk_declaration_form() {

		if ( ! current_user_can( 'manage_give_settings' ) ) {
			return;
		}

		// Bail out, if action empty.
		if ( empty( $_GET['action'] ) ) {
			return;
		}

		// Bail out, if bulk action is not 'download-declaration-forms'.
		if ( 'download-declaration-forms' !== $_GET['action'] ) {
			return;
		}

		// Get Bulk Donation IDs.
		$payment_ids = isset( $_GET['gift_aid_payment'] ) ? $_GET['gift_aid_payment'] : false;

		if ( ! is_array( $payment_ids ) ) {
			$payment_ids = array( $payment_ids );
		}

		// Download Gift Aid Declaration Form.
		give_gift_aid_declaration_form_download( $payment_ids );

		exit;
	}

	/**
	 * Show Gift Aid Metabox on Donation detail.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param int $payment_id Payment ID.
	 *
	 * @return void
	 */
	public function gift_aid_meta_box( $payment_id ) {
		$payment  = new Give_Payment( $payment_id );
		$donor_id = $payment->customer_id;

		$term_condition      = give_get_meta( $payment_id, '_give_gift_aid_accept_term_condition', true );
		$full_address        = give_gift_aid_full_address( $donor_id );
		$full_address        = ! empty( $full_address ) ? $full_address : 'GiftAidAddress';
        $is_gift_aid_claimed = give_is_setting_enabled( $term_condition ) ? 'checked="checked"' : '';
		?>

		<div id="give-gift-aid-details-wrap" class="postbox">
			<h3 class="hndle"><?php esc_html_e( 'Gift Aid', 'give-gift-aid' ); ?></h3>

			<div class="inside" style="margin-top:0;">
				<div id="give-gift-aid-details">
					<div class="give-gift-aid-details">
						<div class="data column-container">
                            <div class="column">
                                <div class="give-gift-aid-wrap-address">
                                    <p>
                                        <strong><?php esc_html_e( 'Gift Aid Status', 'give-gift-aid' ); ?></strong><br/>
                                        <input style="display: inline-block;" type="checkbox" id="give_gift_aid_is_claimed" name="give_gift_aid_is_claimed" <?php echo $is_gift_aid_claimed; ?>>
	                                    <label for="give_gift_aid_is_claimed"><?php esc_html_e( 'Yes, I would like to claim Gift Aid', 'give-gift-aid' ); ?></label>
                                    </p>
                                </div>
                            </div>
							<div class="column">
								<div class="give-gift-aid-wrap-address">
									<p>
										<strong><?php esc_html_e( 'Gift Aid Address', 'give-gift-aid' ); ?></strong><br>
										<?php echo $full_address; ?>
									</p>
								</div>
							</div>
							<div class="column">
								<div class="give-gift-aid-edit-donation-link">
									<p>
										<strong><?php esc_html_e( 'Edit Details', 'give-gift-aid' ); ?></strong><br>
										<?php
										if ( ! empty( $donor_id ) ) {
											printf(
												'<a href="%1$s" target="_blank">' . __( 'Edit Gift Aid Details', 'give-gift-aid' ) . '</a>',
												admin_url( 'edit.php?post_type=give_forms&page=give-donors&view=overview&id=' . $donor_id )
											);
										} // End if().
										?>
									</p>
								</div>
                                <div class="give-gift-aid-download-declaration-form">
                                    <p>
                                        <strong><?php esc_html_e( 'Declaration Form', 'give-gift-aid' ); ?></strong><br>
										<?php
										if ( ! empty( $payment_id ) ) {
											echo give_gift_aid_get_declaration_form_link( $payment_id );
										}// End if().
										?>
                                    </p>
                                </div>
							</div>
						</div>
					</div>
				</div>
			</div> <!-- /.inside -->

		</div> <!-- /#give-gift-aid-details -->
		<?php
	}

	/**
	 * Register Give Gift Aid admin notices.
	 *
	 * @access public
	 * @since  1.0.0
	 */
	public function show_admin_notice() {
		// Bailout.
		if ( ! is_admin() ) {
			return;
		}

		// Delete Gift Aid donation message.
		if ( current_user_can( 'view_give_reports' ) && isset( $_GET['action'] ) ) {
			$donation_count = isset( $_GET['gift_aid_payment'] ) ? count( $_GET['gift_aid_payment'] ) : 0;

			switch ( $_GET['action'] ) {
				case 'delete-entries' :
					Give()->notices->register_notice( array(
						'id'          => 'bulk_action_delete',
						'type'        => 'updated',
						'description' => sprintf(
							_n(
								'Successfully deleted one Gift Aid donation entry.',
								'Successfully deleted %d Gift Aid donations entries.',
								$donation_count,
								'give-gift-aid'
							),
							$donation_count ),
						'show'        => true,
					) );
					break;
			}// End Switch().
		}// End if().

		// Show Gift Aid notice, if base country not set as United Kingdom.
		if ( current_user_can( 'manage_give_settings' )
		     && 'GB' !== give_get_country()
		) {
			Give()->notices->register_notice( array(
				'id'               => 'gift-aid-country-notice',
				'type'             => 'error',
				'dismissible'      => false,
				'description'      => sprintf(
					__( 'The United Kingdom must be set as the base country within Give\'s <a href="%s">General Settings</a> in order to collect Gift Aid.', 'give-gift-aid' ),
					admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=general' )
				),
				'show'             => true,
				'dismissible_type' => 'user'
			) );
		}

		// Show Gift Aid notice, if currency is not set as "Pounds Sterling (£)".
		if ( current_user_can( 'manage_give_settings' )
		     && 'GBP' !== give_get_currency()
		) {
			Give()->notices->register_notice( array(
				'id'          => 'gift-aid-currency-notice',
				'type'        => 'error',
				'dismissible' => false,
				'description' => sprintf( __( 'The currency must be set as "Pounds Sterling (£)" within Give\'s <a href="%s">Currency Settings</a> in order to collect Gift Aid.',
					'give-gift-aid' ),
					admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=general&section=currency-settings' ) ),
				'show'        => true,
			) );
		}

	}

	/**
	 * Include the gift aid html withing the form.
	 *
	 * @since 1.1.3
	 *
	 * @param array   $response Response
	 * @param integer $form_id  Donation Form ID.
	 *
	 * @return array $response
	 */
	public function give_gift_aid_include_response( $response, $form_id ) {
		if ( isset( $form_id ) && ! empty( $form_id ) ) {

			$gift_aid_admin = new Give_Gift_Aid_Frontend();
			ob_start();
			echo $gift_aid_admin->gift_aid_section( $form_id );
			$response['gift_aid_html'] = ob_get_clean();
		}

		return $response;
	}

	/**
	 * This function is used to update the claimed status for Gift Aid.
	 *
	 * @param int $donation_id Donation ID.
	 *
	 * @since 1.2.1
	 */
	public function update_claimed_status( $donation_id ) {

		// Bailout, if accessed from frontend.
		if ( ! is_admin() ) {
			return;
		}

		$is_gift_aid_claimed = give_clean( filter_input( INPUT_POST, 'give_gift_aid_is_claimed' ) );

		if ( ! empty( $is_gift_aid_claimed ) ) {
			Give()->payment_meta->update_meta( $donation_id, '_give_gift_aid_accept_term_condition', 'on' );
		} else {
			Give()->payment_meta->delete_meta( $donation_id, '_give_gift_aid_accept_term_condition' );
		}
	}
}
