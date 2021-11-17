<?php
/**
 * Give - Gift Aid Settings Page/Tab
 *
 * @package    Give_Gift_Aid
 * @subpackage Give_Gift_Aid/includes/admin
 * @author     GiveWP <https://givewp.com>
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Give_Gift_Aid_Settings' ) ) :

	/**
	 * Give_Gift_Aid_Settings.
	 *
	 * @sine 1.0.0
	 */
	class Give_Gift_Aid_Settings extends Give_Settings_Page {

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			$this->id    = 'gift-aid';
			$this->label = __( 'Gift Aid', 'give-gift-aid' );

			parent::__construct();
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

			$is_global = true; // Set Global flag.

			$settings = give_gift_aid_settings( $is_global );

			/**
			 * Filter the Give - Gift Aid settings.
			 *
			 * @since  1.0.0
			 *
			 * @param  array $settings
			 */
			$settings = apply_filters( 'give_gift_aid_get_settings_' . $this->id, $settings );

			// Output.
			return $settings;
		}

	}

endif;

return new Give_Gift_Aid_Settings();
