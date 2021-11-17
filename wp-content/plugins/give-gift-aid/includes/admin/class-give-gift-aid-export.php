<?php
/**
 * Batch Gift Aid Export Class.
 *
 * @package     Give_Gift_Aid
 * @subpackage  Give_Gift_Aid/includes/admin
 * @since       1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Give_Gift_Aid_Export Class
 *
 * @since 1.0.0
 */
class Give_Gift_Aid_Export extends Give_Batch_Export {

	/**
	 * Our export type. Used for export-type specific filters/actions.
	 *
	 * @var string
	 * @since 1.0.0
	 */
	public $export_type = 'gift-aid';

	/**
	 * Form submission data
	 *
	 * @var array
	 * @since 1.0.0
	 */
	private $data = array();

	/**
	 * Number of the Donation.
	 *
	 * @since 1.2.2
	 * @var int
	 */
	private $per_page = 30;

	/**
	 * Set the properties specific to the donors export.
	 *
	 * @param array $request The Form Data passed into the batch processing.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 */
	public function set_properties( $request ) {

		// Set data from form submission.
		if ( isset( $_POST['form'] ) ) {
			parse_str( $_POST['form'], $this->data );
		}

		$this->form = $this->data['forms'];
	}

	/**
	 * Set the CSV columns.
	 *
	 * @access public
	 * @return array|bool $cols All the columns.
	 * @since  1.0.0
	 *
	 */
	public function csv_cols() {

		$cols = $this->get_cols();

		return $cols;
	}

	/**
	 * CSV file columns.
	 *
	 * @return array $cols columns array.
	 * @since  1.0.0
	 * @access private
	 *
	 */
	private function get_cols() {

		$cols                                = array();
		$cols['gift_aid_donation_id']        = __( 'Donation ID', 'give-gift-aid' );
		$cols['gift_aid_first_name']         = __( 'First Name', 'give-gift-aid' );
		$cols['gift_aid_last_name']          = __( 'Last Name', 'give-gift-aid' );
		$cols['gift_aid_address_1']          = __( 'Gift Aid Address 1', 'give-gift-aid' );
		$cols['gift_aid_address_2']          = __( 'Gift Aid Address 2', 'give-gift-aid' );
		$cols['gift_aid_city']               = __( 'Gift Aid City', 'give-gift-aid' );
		$cols['gift_aid_country']            = __( 'Gift Aid Country', 'give-gift-aid' );
		$cols['gift_aid_county']             = __( 'Gift Aid County', 'give-gift-aid' );
		$cols['gift_aid_postal_code']        = __( 'Gift Aid Postal Code', 'give-gift-aid' );
		$cols['gift_aid_donation_amount']    = __( 'Total Donation Amount', 'give-gift-aid' );
		$cols['gift_aid_last_donation_date'] = __( 'Last Donation Date', 'give-gift-aid' );

		return $cols;
	}

	/**
	 * Donation query
	 *
	 * @param array $args
	 *
	 * @return array
	 * @since 1.2.2
	 */
	private function get_donation_argument( $args = array() ) {
		$donation_statuses = give_get_payment_status_keys();

		$default_args = array(
			'output'  => 'payments',
			'number'  => $this->per_page,
			'page'    => $this->step,
			'orderby' => 'DESC',
			'order'   => 'id',
			'status'  => in_array( $this->data['status'], give_get_payment_status_keys() )
				? $this->data['status']
				: $donation_statuses,
		);

		if ( ! empty( $this->form ) ) {
			$default_args['meta_key']   = '_give_payment_form_id';
			$default_args['meta_value'] = absint( $this->form );
		}

		// Check for date option filter.
		$default_args['start_date'] = ! empty( $this->data['give_gift_aid_export_start_date'] )
			? date( 'Y-m-d 00:00:00', strtotime( $this->data['give_gift_aid_export_start_date'] ) )
			: date( 'Y-m-d 00:00:00', strtotime( '1970-01-01' ) );
		$default_args['end_date']   = ! empty( $this->data['give_gift_aid_export_end_date'] )
			? date( 'Y-m-d 23:59:59', strtotime( $this->data['give_gift_aid_export_end_date'] ) )
			: date( 'Y-m-d 23:59:59', current_time( 'timestamp' ) );

		// Set Gift Aid accept term and condition.
		$default_args['meta_query'] = array(
			'relation' => 'AND',
			array(
				'key'     => '_give_gift_aid_accept_term_condition',
				'value'   => 'on',
				'compare' => 'LIKE',
			),
		);


		/**
		 * Filter the export donation arguments
		 *
		 * @since 1.2.3
		 */
		return apply_filters( 'give_gift_aid_export_get_donation_argument', wp_parse_args( $args, $default_args ), $this );
	}

	/**
	 * Get the Export Data.
	 *
	 * @access public
	 * @return array $data The data for the CSV file.
	 * @since  1.0.0
	 *
	 */
	public function get_data() {
		$data = array();

		$payments_query = new Give_Payments_Query( $this->get_donation_argument() );
		$payments       = $payments_query->get_payments();

		if ( $payments ) {
			/* @var Give_Payment $payment */
			foreach ( $payments as $payment ) {

				$donor_id        = $payment->customer_id;
				$donor_object    = new Give_Donor( $donor_id );
				$donation_id     = $payment->ID;
				$donation_amount = give_donation_amount( $donation_id );

				$address_one      = $donor_object->get_meta( '_give_gift_aid_card_address' );
				$address_one      = ! empty( $address_one ) ? $address_one : '';
				$address_two      = $donor_object->get_meta( '_give_gift_aid_card_address_2' );
				$address_two      = ! empty( $address_two ) ? $address_two : '';
				$gift_aid_city    = $donor_object->get_meta( '_give_gift_aid_card_city' );
				$gift_aid_city    = ! empty( $gift_aid_city ) ? $gift_aid_city : '';
				$gift_aid_state   = $donor_object->get_meta( '_give_gift_aid_card_state' );
				$gift_aid_state   = ! empty( $gift_aid_state ) ? $gift_aid_state : '';
				$gift_aid_zip     = $donor_object->get_meta( '_give_gift_aid_card_zip' );
				$gift_aid_zip     = ! empty( $gift_aid_zip ) ? $gift_aid_zip : '';
				$gift_aid_country = $donor_object->get_meta( '_give_gift_aid_country' );
				$gift_aid_country = ! empty( $gift_aid_country ) ? $gift_aid_country : '';
				$opt_in_date      = $payment->date;

				$data[] = array(
					'gift_aid_donation_id'        => $donation_id,
					'gift_aid_first_name'         => $payment->first_name,
					'gift_aid_last_name'          => $payment->last_name,
					'gift_aid_address_1'          => $address_one,
					'gift_aid_address_2'          => $address_two,
					'gift_aid_city'               => $gift_aid_city,
					'gift_aid_country'            => $gift_aid_country,
					'gift_aid_county'             => $gift_aid_state,
					'gift_aid_postal_code'        => $gift_aid_zip,
					'gift_aid_donation_amount'    => give_format_amount( $donation_amount ),
					'gift_aid_last_donation_date' => date( 'd/m/Y', strtotime( $opt_in_date ) ),
				);
			}// End foreach().
		}// End if().

		$data = apply_filters( 'give_gift_aid_export_get_data', $data );
		$data = apply_filters( "give_gift_aid_export_get_data_{$this->export_type}", $data );

		return $data;
	}

	/**
	 * Return the calculated completion percentage.
	 *
	 * @return int
	 * @since  1.0.0
	 * @access public
	 *
	 */
	public function get_percentage_complete() {
		$args = $this->get_donation_argument( array( 'number' => - 1, 'output' => '' ) );
		if ( isset( $args['page'] ) ) {
			unset( $args['page'] );
		}
		$query      = new Give_Payments_Query( $args );
		$total      = count( $query->get_payments() );
		$percentage = 100;

		if ( $total > 0 ) {
			$percentage = ( ( $this->per_page * $this->step ) / $total ) * 100;
		}
		if ( $percentage > 100 ) {
			$percentage = 100;
		}

		return $percentage;
	}
}
