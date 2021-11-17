<?php
/**
 * Class Give_Gift_Aid_Reports.
 *
 * Define Gift Aid Report int Give Report tab.
 *
 * @link       https://givewp.com
 * @since      1.0.0
 *
 * @package    Give_Gift_Aid_Reports
 */

if ( ! class_exists( 'Give_Gift_Aid_Reports' ) ) :

	/**
	 * Give_Gift_Aid_Reports.
	 *
	 * @since 1.0.0
	 */
	class Give_Gift_Aid_Reports {
		/**
		 * Setting page id.
		 *
		 * @since  1.0.0
		 * @access protected
		 *
		 * @var   string
		 */
		protected $id = '';

		/**
		 * Setting page label.
		 *
		 * @since  1.0.0
		 * @access protected
		 *
		 * @var   string
		 */
		protected $label = '';

		/**
		 * Constructor.
		 */
		public function __construct() {
			$this->id          = 'gift-aid';
			$this->label       = __( 'Gift Aid', 'give-gift-aid' );
			$this->default_tab = 'give-gift-aid';

			add_filter( 'give-reports_tabs_array', array( $this, 'settings_page' ), 20 );
			add_action( "give-reports_settings_{$this->id}_page", array( $this, 'output' ) );
			add_action( 'give_admin_field_gift_aid_report', array( $this, 'gift_aid_report' ), 10 );

			// Do not use main donor for this tab.
			if ( give_get_current_setting_tab() === $this->id ) {
				add_action( 'give-reports_open_form', '__return_empty_string' );
				add_action( 'give-reports_close_form', '__return_empty_string' );
			}
		}

		/**
		 * Add this page to settings.
		 *
		 * @since  1.0.0
		 * @access public
		 *
		 * @param  array $pages Lst of pages.
		 *
		 * @return array
		 */
		public function settings_page( $pages ) {
			$pages[ $this->id ] = $this->label;

			return $pages;
		}

		/**
		 * Get settings array.
		 *
		 * @since  1.0.0
		 * @access public
		 *
		 * @return array
		 */
		public function get_settings() {
			// Hide save button.
			$GLOBALS['give_hide_save_button'] = true;

			$settings = array(
				// Section 1: Gift Aid.
				array(
					'id'         => 'give_gift_aid_title',
					'type'       => 'title',
					'table_html' => false,
				),
				array(
					'id'   => 'give_gift_aid',
					'name' => __( 'Gift Aid', 'give-gift-aid' ),
					'type' => 'gift_aid_report',
				),
				array(
					'id'         => 'give_gift_aid_end',
					'type'       => 'sectionend',
					'table_html' => false,
				),
			);

			/**
			 * Filter the settings.
			 *
			 * @since  1.0.0
			 *
			 * @param  array $settings
			 */
			$settings = apply_filters( "give_gift_aid_get_settings_{$this->id}", $settings );

			// Output.
			return $settings;
		}

		/**
		 * Get sections.
		 *
		 * @since  1.0.0
		 * @access public
		 *
		 * @return array
		 */
		public function get_sections() {
			$sections = array(
				'give-gift-aid' => __( 'Gift Aid Donations', 'give-gift-aid' ),
			);

			return apply_filters( 'give_gift_aid_get_sections_' . $this->id, $sections );
		}

		/**
		 * Output the settings.
		 *
		 * @since  1.0.0
		 * @access public
		 *
		 * @return void
		 */
		public function output() {
			$settings = $this->get_settings();

			Give_Admin_Settings::output_fields( $settings, 'give_settings' );
		}

		/**
		 * Show Gift Aid Donations Report.
		 *
		 * @access      public
		 * @since       1.0.0
		 *
		 * @return      void
		 */
		public function gift_aid_report() {

			do_action( 'give_gift_aid_reports' );
		}
	}

endif;

return new Give_Gift_Aid_Reports();
