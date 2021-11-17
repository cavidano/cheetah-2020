<?php
/**
 * Give Gift Aid Donations Report Table Class.
 *
 * @package     Give_Gift_Aid
 * @subpackage  Give_Gift_Aid/admin
 * @since       1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load WP_List_Table if not loaded.
if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * Give_Gift_Aid_Reports_Table Class
 *
 * Renders the Gift Aid Donations Report table.
 *
 * @since 1.0
 */
class Give_Gift_Aid_Reports_Table extends WP_List_Table {

	/**
	 * Number of items per page.
	 *
	 * @var int
	 * @since 1.0.0
	 */
	public $per_page = 30;

	/**
	 * URL of this page
	 *
	 * @var string
	 * @since 1.0.0
	 */
	public $base_url;

	/**
	 * Number of items found.
	 *
	 * @var int
	 * @since 1.0.0
	 */
	public $count = 0;

	/**
	 * Total items.
	 *
	 * @var int
	 * @since 1.0.0
	 */
	public $total = 0;

	/**
	 * Get things started.
	 *
	 * @since 1.0.0
	 * @see   WP_List_Table::__construct()
	 */
	public function __construct() {

		// Set parent defaults.
		parent::__construct( array(
			'singular' => __( 'Gift Aid Donation', 'give-gift-aid' ),     // Singular name of the listed records.
			'plural'   => __( 'Gift Aid Donations', 'give-gift-aid' ),    // Plural name of the listed records.
			'ajax'     => false,// Does this table support ajax?
		) );

		$this->process_bulk_action();
		$this->base_url = admin_url( 'edit.php?post_type=give_forms&page=give-reports&tab=gift-aid' );

	}

	/**
	 * Remove default search field in favor for repositioned location.
	 *
	 * Reposition the search field.
	 *
	 * @since       1.0.0
	 * @access      public
	 *
	 * @param string $text     Label for the search box.
	 * @param string $input_id ID of the search box.
	 *
	 * @return false
	 */
	public function search_box( $text, $input_id ) {

		return false;
	}

	/**
	 * Show the search field.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param string $text     Label for the search box.
	 * @param string $input_id ID of the search box.
	 *
	 * @return void
	 */
	public function give_search_box( $text, $input_id ) {
		$input_id = $input_id . '-search-input';

		if ( ! empty( $_REQUEST['orderby'] ) ) {
			echo '<input type="hidden" name="orderby" value="' . esc_attr( $_REQUEST['orderby'] ) . '" />';
		}
		if ( ! empty( $_REQUEST['order'] ) ) {
			echo '<input type="hidden" name="order" value="' . esc_attr( $_REQUEST['order'] ) . '" />';
		}
		?>
		<p class="search-box donor-search" role="search">
			<label class="screen-reader-text" for="<?php echo $input_id ?>"><?php echo $text; ?>:</label>
			<input type="search" id="<?php echo $input_id ?>" name="s" value="<?php _admin_search_query(); ?>" />
			<?php submit_button( $text, 'button', false, false, array(
				'ID' => 'search-submit',
			) ); ?>
		</p>
		<?php
	}

	/**
	 * Generate the table navigation above or below the table.
	 *
	 * @since  1.0.0
	 * @access protected
	 *
	 * @param string $which Position.
	 */
	protected function display_tablenav( $which ) {

		if ( 'top' === $which ) {
			wp_nonce_field( 'bulk-' . $this->_args['plural'] );
		}
		?>
		<div class="tablenav give-clearfix <?php echo esc_attr( $which ); ?> give-gift-aid-donations">

			<?php if ( 'top' === $which ) { ?>

				<h3 class="reports-gift-aid-title">
					<span><?php esc_html_e( 'Gift Aid Donations', 'give-gift-aid' ); ?></span>
				</h3>
					<div class="alignleft">
						<?php $this->bulk_actions( $which ); ?>
					</div>

					<div class="alignleft">
						<a class="button-primary"
						   href="<?php echo esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-tools&tab=export' ) ); ?>"><?php echo __( 'Export to CSV', 'give-gift-aid' ); ?></a>
					</div>

			<?php } ?>

			<div class="alignright tablenav-right">
				<?php
				if ( 'top' === $which ) {
					$this->give_search_box( __( 'Search', 'give-gift-aid' ), 'give-gift-aid' );
				}
				?>
				<?php
				$this->pagination( $which );
				?>
			</div>
			<br class="clear" />
		</div>
		<?php
	}

	/**
	 * This function renders most of the columns in the list table.
	 *
	 * @access public
	 * @since  1.0
	 *
	 * @param array  $gift_aid_data Contains all the data of the Gift aid data.
	 * @param string $column_name   The name of the column.
	 *
	 * @return string Column Name
	 */
	public function column_default( $gift_aid_data, $column_name ) {

		$payment_id = $gift_aid_data['id'];

		$single_donation_url = esc_url( add_query_arg( 'id', $payment_id, admin_url( 'edit.php?post_type=give_forms&page=give-payment-history&view=view-payment-details' ) ) );
		switch ( $column_name ) {
			case 'donations' :
				$value = sprintf(  /* translators: %s: Donation id */
				'<a href="%1$s" data-tooltip="%2$s">#%3$s</a>&nbsp;%4$s&nbsp;%5$s<br>', $single_donation_url, sprintf( esc_attr__( 'View Donation #%s', 'give-gift-aid' ), $payment_id ), $gift_aid_data['id'], __( 'by', 'give-gift-aid' ), $this->get_donor( $gift_aid_data ) );
				$value .= $this->get_donor_email( $gift_aid_data );
				break;
			case 'gift_aid_address' :
				$value = $gift_aid_data['gift_gift_aid_address'];
				break;
			case 'gift_aid_date_time' :
				$value = $gift_aid_data['gift_gift_aid_date_time'];
				break;
			case 'gift_aid_declaration' :
				$value = give_gift_aid_get_declaration_form_link( $gift_aid_data['id'] );
				break;
			default:
				$value = isset( $item[ $column_name ] ) ? $item[ $column_name ] : '';
				break;
		}// End switch().

		return apply_filters( "give_gift_aid_report_column_{$column_name}", $value, $payment_id );
	}

	/**
	 * Get checkbox html.
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @param  Give_Payment $payment Contains all the data for the checkbox column.
	 *
	 * @return string Displays a checkbox.
	 */
	public function column_cb( $payment ) {
		return sprintf( '<input type="checkbox" name="%1$s[]" value="%2$s" />', 'gift_aid_payment', $payment['id'] );
	}

	/**
	 * Retrieve the table columns.
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @return array $columns Array of all the list table columns.
	 */
	public function get_columns() {
		$columns = array(
			'cb'                   => '<input type="checkbox" />', // Render a checkbox instead of text.
			'donations'            => __( 'Donation', 'give-gift-aid' ),
			'gift_aid_address'     => __( 'Gift Aid Address', 'give-gift-aid' ),
			'gift_aid_date_time'   => __( 'Donation Date and Time', 'give-gift-aid' ),
			'gift_aid_declaration' => __( 'Declaration Form', 'give-gift-aid' ),
		);

		return apply_filters( 'give_gift_aid_donations_report_columns', $columns );

	}

	/**
	 * Get the sortable columns.
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @return array Array of all the sortable columns.
	 */
	public function get_sortable_columns() {
		return array(
			'donations'          => array( 'ID', true ),
			'gift_aid_date_time' => array( 'date', false ),
		);
	}

	/**
	 * Retrieve the bulk actions.
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @return array $actions Array of the bulk actions
	 */
	public function get_bulk_actions() {
		$actions = array(
			'delete-entries'             => __( 'Delete Entries', 'give-gift-aid' ),
			'download-declaration-forms' => __( 'Download Declaration Forms', 'give-gift-aid' ),
		);

		return apply_filters( 'give_gift_aid_table_bulk_actions', $actions );
	}

	/**
	 * Process the bulk actions.
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function process_bulk_action() {
		$payment_ids = isset( $_GET['gift_aid_payment'] ) ? $_GET['gift_aid_payment'] : false;
		$action      = $this->current_action();

		if ( ! is_array( $payment_ids ) ) {
			$payment_ids = array( $payment_ids );
		}

		if ( empty( $action ) ) {
			return;
		}

		if ( 'delete-entries' === $this->current_action() ) {
			$this->delete_entry( $payment_ids );
		}

	}

	/**
	 * Delete Donations.
	 *
	 * @since 1.0.0
	 *
	 * @param array $payment_ids Payment IDs.
	 */
	public function delete_entry( $payment_ids ) {

		if ( ! isset( $payment_ids ) && ! is_array( $payment_ids ) ) {
			return;
		}

		foreach ( $payment_ids as $payment_id ) {

			if ( ! empty( $payment_id ) ) {
				// Remove Term and Condition accepted so it will remove from the Gift Aid Donation list.
				give_update_payment_meta( $payment_id, '_give_gift_aid_accept_term_condition', '' );
			}
		}

	}

	/**
	 * Retrieve the current page number.
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @return int Current page number.
	 */
	public function get_paged() {
		return isset( $_GET['paged'] ) ? absint( $_GET['paged'] ) : null;
	}

	/**
	 * Retrieves the search query string.
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @return mixed string If search is present, false otherwise.
	 */
	public function get_search() {
		return ! empty( $_GET['s'] ) ? urldecode( trim( $_GET['s'] ) ) : false;
	}

	/**
	 * Retrieve all the data for all the payments.
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @return array  objects in array containing all the data for the payments.
	 */
	public function payments_data() {

		$per_page = $this->per_page;
		$orderby  = isset( $_GET['orderby'] ) ? urldecode( $_GET['orderby'] ) : 'ID';
		$order    = isset( $_GET['order'] ) ? $_GET['order'] : 'DESC';
		$meta_key = isset( $_GET['meta_key'] ) ? $_GET['meta_key'] : null;
		$search   = $this->get_search();

		$args = array(
			'output'     => 'payments',
			'number'     => $per_page,
			'page'       => isset( $_GET['paged'] ) ? $_GET['paged'] : null,
			'orderby'    => $orderby,
			'order'      => $order,
			'meta_key'   => $meta_key,
			'status'     => give_get_payment_status_keys(),
			's'          => $search,
			'meta_query' => array(
				array(
					'key'     => '_give_gift_aid_accept_term_condition',
					'value'   => 'on',
					'compare' => 'LIKE',
				),
			),
		);

		if ( $search ) {
			if ( is_email( $search ) ) {
				$args['email'] = $search;
			} elseif ( is_numeric( $search ) ) {
				$args['id'] = $search;
			}
		}

		$p_query = new Give_Payments_Query( $args );

		return $p_query->get_payments();

	}

	/**
	 * Setup the final data for the table
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @uses   Give_Donor_Reports_Table::get_columns()
	 * @uses   WP_List_Table::get_sortable_columns()
	 *
	 * @return void
	 */
	public function prepare_items() {

		$columns  = $this->get_columns();
		$hidden   = array(); // No hidden columns.
		$sortable = $this->get_sortable_columns();

		$this->_column_headers = array( $columns, $hidden, $sortable );

		$this->items = $this->reports_data();

		$donations   = $this->donations_query();
		$this->total = count( $donations );

		$this->set_pagination_args( array(
			'total_items' => $this->total,
			'per_page'    => $this->per_page,
			'total_pages' => ceil( $this->total / $this->per_page ),
		) );
	}

	/**
	 * Retrieve all the data for Tribute Donations.
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @return array  objects in array containing all the data for the payments.
	 */
	public function donations_query() {
		$order   = isset( $_GET['order'] ) ? sanitize_text_field( $_GET['order'] ) : 'DESC';
		$orderby = isset( $_GET['orderby'] ) ? sanitize_text_field( $_GET['orderby'] ) : 'id';
		$search  = $this->get_search();

		$args = array(
			'output'     => 'payments',
			'number'     => - 1,
			'page'       => isset( $_GET['paged'] ) ? $_GET['paged'] : null,
			'orderby'    => $orderby,
			'order'      => $order,
			'status'     => give_get_payment_status_keys(),
			's'          => $search,
			'meta_query' => array(
				array(
					'key'     => '_give_gift_aid_accept_term_condition',
					'value'   => 'on',
					'compare' => 'LIKE',
				),
			),
		);

		if ( $search ) {
			if ( is_email( $search ) ) {
				$args['email'] = $search;
			} elseif ( is_numeric( $search ) ) {
				$args['id'] = $search;
			}
		}

		$p_query = new Give_Payments_Query( $args );

		return $p_query->get_payments();
	}

	/**
	 * Build all the reports data.
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @global object $wpdb Used to query the database using the WordPress
	 *                      Database API
	 * @return array $reports_data All the data for donor reports
	 */
	public function reports_data() {

		$data = array();

		$payments = $this->payments_data();

		if ( $payments ) {

			$this->count = count( $payments );

			foreach ( $payments as $payment ) {

				$user_id      = ! empty( $payment->user_id ) ? absint( $payment->user_id ) : 0;
				$donor_id     = ! empty( $payment->customer_id ) ? absint( $payment->customer_id ) : 0;
				$opt_in_date  = $payment->post_date;
				$full_address = give_gift_aid_full_address( $donor_id );

				$data[] = array(
					'id'                      => $payment->ID,
					'user_id'                 => $user_id,
					'customer_id'             => $donor_id,
					'gift_gift_aid_date_time' => date( 'F j, Y, g:i a', strtotime( $opt_in_date ) ),
					'gift_gift_aid_address'   => $full_address,
				);
			}// End foreach().
		}// End if().

		return $data;
	}

	/**
	 * Get donor html.
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @param  Give_Payment $payment Contains all the data of the payment.
	 *
	 * @return string Data shown in the User column.
	 */
	public function get_donor( $payment ) {

		$donor_id           = give_get_payment_donor_id( $payment['id'] );
		$donor_billing_name = give_get_donor_name_by( $payment['id'], 'donation' );
		$donor_name         = give_get_donor_name_by( $donor_id, 'donor' );

		$value = '';
		if ( ! empty( $donor_id ) ) {

			// Check whether the donor name and WP_User name is same or not.
			if ( sanitize_title( $donor_billing_name ) !== sanitize_title( $donor_name ) ) {
				$value .= $donor_billing_name . ' (';
			}

			$value .= '<a href="' . esc_url( admin_url( "edit.php?post_type=give_forms&page=give-donors&view=overview&id=$donor_id" ) ) . '">' . $donor_name . '</a>';

			// Check whether the donor name and WP_User name is same or not.
			if ( sanitize_title( $donor_billing_name ) !== sanitize_title( $donor_name ) ) {
				$value .= ')';
			}
		} else {
			$email = give_get_payment_user_email( $payment['id'] );
			$value .= '<a href="' . esc_url( admin_url( "edit.php?post_type=give_forms&page=give-payment-history&s=$email" ) ) . '">' . __( '(donor missing)', 'give-gift-aid' ) . '</a>';
		}

		return apply_filters( 'give_gift_aid_donor_value', $value, $payment['id'] );
	}

	/**
	 * Get donor email html.
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @param  Give_Payment $payment Contains all the data of the payment.
	 *
	 * @return string                Data shown in the Email column.
	 */
	public function get_donor_email( $payment ) {

		$email = give_get_payment_user_email( $payment['id'] );

		if ( empty( $email ) ) {
			$email = __( '(unknown)', 'give-gift-aid' );
		}

		$value = '<a href="mailto:' . $email . '" data-tooltip="' . esc_attr__( 'Email donor', 'give-gift-aid' ) . '">' . $email . '</a>';

		return apply_filters( 'give_payments_donation_table_column', $value, $payment['id'], 'email' );
	}
}
