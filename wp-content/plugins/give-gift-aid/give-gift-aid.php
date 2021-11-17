<?php
/**
 * Plugin Name:       Give - Gift Aid
 * Plugin URI:        https://givewp.com/addons/gift-aid/
 * Description:       Allow donors to give using the UK’s Gift Aid program.
 * Version:           1.2.6
 * Author:            GiveWP
 * Author URI:        https://givewp.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       give-gift-aid
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Give_Gift_Aid' ) ) :

	/**
	 * Give_Gift_Aid Class
	 *
	 * @package Give_Gift_Aid
	 * @since   1.0.0
	 */
	final class Give_Gift_Aid {

		/**
		 * Holds the instance
		 *
		 * Ensures that only one instance of Give_Gift_Aid exists in memory at any one
		 * time and it also prevents needing to define globals all over the place.
		 *
		 * TL;DR This is a static property property that holds the singleton instance.
		 *
		 * @var object
		 * @static
		 */
		private static $instance;

		/**
		 * Give - Gift Aid Admin Object.
		 *
		 * @since  1.0.0
		 * @access public
		 *
		 * @var    Give_Gift_Aid_Admin object.
		 */
		public $plugin_admin;

		/**
		 * Give - Gift Aid Frontend Object.
		 *
		 * @since  1.0.0
		 * @access public
		 *
		 * @var    Give_Gift_Aid_Frontend object.
		 */
		public $plugin_public;

		/**
		 * Notices (array)
		 *
		 * @var array
		 */
		public $notices = array();

		/**
		 * Get the instance and store the class inside it. This plugin utilises
		 * the PHP singleton design pattern.
		 *
		 * @since     1.0.0
		 * @static
		 * @staticvar array $instance
		 * @access    public
		 *
		 * @see       Give_Gift_Aid();
		 *
		 * @uses      Give_Gift_Aid::hooks() Setup hooks and actions.
		 * @uses      Give_Gift_Aid::includes() Loads all the classes.
		 * @uses      Give_Gift_Aid::licensing() Add Give - Gift Aid License.
		 *
		 * @return object self::$instance Instance
		 */
		public static function get_instance() {

			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Give_Gift_Aid ) ) {
				self::$instance = new Give_Gift_Aid();
				self::$instance->setup();
			}

			return self::$instance;
		}

		/**
		 * Setup Gift Aid.
		 *
		 * @since  1.0.0
		 * @access private
		 */
		private function setup() {
			self::$instance->setup_constants();

			add_action( 'give_init', array( $this, 'init' ), 10 );
			add_action( 'admin_init', array( $this, 'check_environment' ), 999 );
			add_action( 'admin_notices', array( $this, 'admin_notices' ), 15 );
		}

		/**
		 * Setup constants.
		 *
		 * @since   1.0.0
		 * @access  private
		 */
		private function setup_constants() {
			if ( ! defined( 'GIVE_GIFT_AID_VERSION' ) ) {
				define( 'GIVE_GIFT_AID_VERSION', '1.2.6' );
			}
			if ( ! defined( 'GIVE_GIFT_AID_MIN_GIVE_VER' ) ) {
				define( 'GIVE_GIFT_AID_MIN_GIVE_VER', '2.6.0' );
			}
			if ( ! defined( 'GIVE_GIFT_AID_SLUG' ) ) {
				define( 'GIVE_GIFT_AID_SLUG', 'give-gift-aid' );
			}
			if ( ! defined( 'GIVE_GIFT_AID_PLUGIN_FILE' ) ) {
				define( 'GIVE_GIFT_AID_PLUGIN_FILE', __FILE__ );
			}
			if ( ! defined( 'GIVE_GIFT_AID_PLUGIN_DIR' ) ) {
				define( 'GIVE_GIFT_AID_PLUGIN_DIR', dirname( GIVE_GIFT_AID_PLUGIN_FILE ) );
			}
			if ( ! defined( 'GIVE_GIFT_AID_PLUGIN_URL' ) ) {
				define( 'GIVE_GIFT_AID_PLUGIN_URL', plugin_dir_url( GIVE_GIFT_AID_PLUGIN_FILE ) );
			}
			if ( ! defined( 'GIVE_GIFT_AID_BASENAME' ) ) {
				define( 'GIVE_GIFT_AID_BASENAME', plugin_basename( GIVE_GIFT_AID_PLUGIN_FILE ) );
			}
			if ( ! defined( 'GIVE_GIFT_AID_PLUGIN_DIR_PATH' ) ) {
				define( 'GIVE_GIFT_AID_PLUGIN_DIR_PATH', plugin_dir_path( GIVE_GIFT_AID_PLUGIN_FILE ) );
			}

		}

		/**
		 * Init Gift Aid.
		 *
		 * Sets up hooks, licensing and includes files.
		 *
		 * @since  1.0.0
		 * @access public
		 *
		 * @return void
		 */
		public function init() {

			if ( ! self::$instance->get_environment_warning() ) {
				return;
			}

			self::$instance->hooks();
			self::$instance->licensing();
			self::$instance->includes();
		}

		/**
		 * Check plugin environment.
		 *
		 * @since  1.0.0
		 * @access public
		 *
		 * @return bool
		 */
		public function check_environment() {
			// Flag to check whether plugin file is loaded or not.
			$is_working = true;

			// Load plugin helper functions.
			if ( ! function_exists( 'is_plugin_active' ) ) {
				require_once ABSPATH . '/wp-admin/includes/plugin.php';
			}

			/* Check to see if Give is activated, if it isn't deactivate and show a banner. */
			// Check for if give plugin activate or not.
			$is_give_active = defined( 'GIVE_PLUGIN_BASENAME' ) ? is_plugin_active( GIVE_PLUGIN_BASENAME ) : false;

			if ( empty( $is_give_active ) ) {
				// Show admin notice.
				$this->add_admin_notice( 'prompt_give_activate', 'error', sprintf( __( '<strong>Activation Error:</strong> You must have the <a href="%s" target="_blank">Give</a> plugin installed and activated for Give - Gift Aid to activate.', 'give-gift-aid' ), 'https://givewp.com' ) );
				$is_working = false;
			}

			return $is_working;
		}

		/**
		 * Check plugin for Give environment.
		 *
		 * @since  1.1.6
		 * @access public
		 *
		 * @return bool
		 */
		public function get_environment_warning() {
			// Flag to check whether plugin file is loaded or not.
			$is_working = true;

			// Verify dependency cases.
			if (
				defined( 'GIVE_VERSION' )
				&& version_compare( GIVE_VERSION, GIVE_GIFT_AID_MIN_GIVE_VER, '<' )
			) {

				/* Min. Give. plugin version. */
				// Show admin notice.
				$this->add_admin_notice( 'prompt_give_incompatible', 'error', sprintf( __( '<strong>Activation Error:</strong> You must have the <a href="%s" target="_blank">Give</a> core version %s for the Give - Gift Aid add-on to activate.', 'give-gift-aid' ), 'https://givewp.com', GIVE_GIFT_AID_MIN_GIVE_VER ) );

				$is_working = false;
			}

			return $is_working;
		}

		/**
		 * Throw error on object clone.
		 *
		 * The whole idea of the singleton design pattern is that there is a single
		 * object therefore, we don't want the object to be cloned.
		 *
		 * @since  1.0.0
		 * @access protected
		 *
		 * @return void
		 */
		public function __clone() {
			// Cloning instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'give-gift-aid' ), '1.0' );
		}

		/**
		 * Disable Unserialize of the class.
		 *
		 * @since  1.0.0
		 * @access protected
		 *
		 * @return void
		 */
		public function __wakeup() {
			// Unserialize instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'give-gift-aid' ), '1.0' );
		}

		/**
		 * Constructor Function.
		 *
		 * @since  1.0.0
		 * @access protected
		 */
		public function __construct() {
			self::$instance = $this;
		}

		/**
		 * Reset the instance of the class
		 *
		 * @since  1.0.0
		 * @access public
		 */
		public static function reset() {
			self::$instance = null;
		}

		/**
		 * Includes.
		 *
		 * @since  1.0.0
		 * @access private
		 */
		private function includes() {
			require_once GIVE_GIFT_AID_PLUGIN_DIR. '/vendor/autoload.php';

			/**
			 * The class responsible for defining all actions that occur in the admin area.
			 */
			require_once( GIVE_GIFT_AID_PLUGIN_DIR . '/includes/admin/class-give-gift-aid-admin.php' );

			/**
			 * The class responsible for defining all actions that occur in the public-facing
			 * side of the site.
			 */
			require_once( GIVE_GIFT_AID_PLUGIN_DIR . '/includes/frontend/class-give-gift-aid-frontend.php' );

			/**
			 * Give - Gift Aid helper functions.
			 */
			require_once( GIVE_GIFT_AID_PLUGIN_DIR . '/includes/give-gift-aid-helpers.php' );

			self::$instance->plugin_admin  = new Give_Gift_Aid_Admin();
			self::$instance->plugin_public = new Give_Gift_Aid_Frontend();

		}

		/**
		 * Hooks.
		 *
		 * @since  1.0.0
		 * @access private
		 */
		private function hooks() {
			add_action( 'init', array( $this, 'load_textdomain' ) );
			add_action( 'admin_init', array( $this, 'activation_banner' ) );
			add_filter( 'plugin_action_links_' . GIVE_GIFT_AID_BASENAME, array( $this, 'action_links' ), 10, 2 );
			add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 2 );
		}

		/**
		 * Implement Give Licensing for Give - Gift Aid Add On.
		 *
		 * @since  1.0.0
		 * @access private
		 */
		private function licensing() {
			new Give_License(
				GIVE_GIFT_AID_PLUGIN_FILE,
				'Gift Aid',
				GIVE_GIFT_AID_VERSION,
				'GiveWP'
			);
		}

		/**
		 * Load Plugin Text Domain
		 *
		 * Looks for the plugin translation files in certain directories and loads
		 * them to allow the plugin to be localised
		 *
		 * @since  1.0.0
		 * @access public
		 *
		 * @return bool True on success, false on failure.
		 */
		public function load_textdomain() {
			// Traditional WordPress plugin locale filter.
			$locale = apply_filters( 'plugin_locale', get_locale(), 'give-gift-aid' );
			$mofile = sprintf( '%1$s-%2$s.mo', 'give-gift-aid', $locale );

			// Setup paths to current locale file.
			$mofile_local = trailingslashit( GIVE_GIFT_AID_PLUGIN_DIR_PATH . 'languages' ) . $mofile;

			if ( file_exists( $mofile_local ) ) {
				// Look in the /wp-content/plugins/give-gift-aid/languages/ folder.
				load_textdomain( 'give-gift-aid', $mofile_local );
			} else {
				// Load the default language files.
				load_plugin_textdomain( 'give-gift-aid', false, trailingslashit( GIVE_GIFT_AID_PLUGIN_DIR_PATH . 'languages' ) );
			}

			return false;
		}

		/**
		 * Activation banner.
		 *
		 * Uses Give's core activation banners.
		 *
		 * @since 1.0.0
		 *
		 * @return bool
		 */
		public function activation_banner() {

			// Check for activation banner inclusion.
			if ( ! class_exists( 'Give_Addon_Activation_Banner' ) && file_exists( GIVE_PLUGIN_DIR . 'includes/admin/class-addon-activation-banner.php' ) ) {
				include GIVE_PLUGIN_DIR . 'includes/admin/class-addon-activation-banner.php';

				// Only runs on admin.
				$args = array(
					'file'              => GIVE_GIFT_AID_PLUGIN_FILE,
					'name'              => __( 'Give - Gift Aid', 'give-gift-aid' ),
					'version'           => GIVE_GIFT_AID_VERSION,
					'settings_url'      => admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=gift-aid' ),
					'documentation_url' => 'http://docs.givewp.com/addon-gift-aid',
					'support_url'       => 'https://givewp.com/support/',
					'testing'           => false,
				);
				new Give_Addon_Activation_Banner( $args );
			}

			return true;
		}

		/**
		 * Adding additional setting page link along plugin's action link.
		 *
		 * @since   1.0.0
		 * @access  public
		 *
		 * @param   array $actions get all actions.
		 *
		 * @return  array       return new action array
		 */
		public function action_links( $actions ) {

			$new_actions = array(
				'settings' => sprintf( '<a href="%1$s">%2$s</a>', admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=gift-aid' ), __( 'Settings', 'give-gift-aid' ) ),
			);

			return array_merge( $new_actions, $actions );

		}

		/**
		 * Plugin row meta links.
		 *
		 * @since   1.0.0
		 * @access  public
		 *
		 * @param   array $plugin_meta An array of the plugin's metadata.
		 * @param   string $plugin_file Path to the plugin file, relative to the plugins directory.
		 *
		 * @return  array  return meta links for plugin.
		 */
		public function plugin_row_meta( $plugin_meta, $plugin_file ) {

			// Return if not Give - Gift Aid plugin.
			if ( GIVE_GIFT_AID_BASENAME !== $plugin_file ) {
				return $plugin_meta;
			}

			$new_meta_links = array(
				sprintf( '<a href="%1$s" target="_blank">%2$s</a>', esc_url( add_query_arg( array(
					'utm_source'   => 'plugins-page',
					'utm_medium'   => 'plugin-row',
					'utm_campaign' => 'admin',
				), 'http://docs.givewp.com/addon-gift-aid' ) ), __( 'Documentation', 'give-gift-aid' ) ),
				sprintf( '<a href="%1$s" target="_blank">%2$s</a>', esc_url( add_query_arg( array(
					'utm_source'   => 'plugins-page',
					'utm_medium'   => 'plugin-row',
					'utm_campaign' => 'admin',
				), 'https://givewp.com/addons/' ) ), __( 'Add-ons', 'give-gift-aid' ) ),
			);

			return array_merge( $plugin_meta, $new_meta_links );
		}

		/**
		 * Allow this class and other classes to add notices.
		 *
		 * @param $slug
		 * @param $class
		 * @param $message
		 */
		public function add_admin_notice( $slug, $class, $message ) {
			$this->notices[ $slug ] = array(
				'class'   => $class,
				'message' => $message,
			);
		}

		/**
		 * Display admin notices.
		 */
		public function admin_notices() {


			$allowed_tags = array(
				'a'      => array(
					'href'  => array(),
					'title' => array(),
					'class' => array(),
					'id'    => array(),
				),
				'br'     => array(),
				'em'     => array(),
				'span'   => array(
					'class' => array(),
				),
				'strong' => array(),
			);

			foreach ( (array) $this->notices as $notice_key => $notice ) {
				echo "<div class='" . esc_attr( $notice['class'] ) . "'><p>";
				echo wp_kses( $notice['message'], $allowed_tags );
				echo '</p></div>';
			}

		}

	} //End Give_Gift_Aid Class.

endif;

/**
 * Loads a single instance of Give - Gift Aid.
 *
 * This follows the PHP singleton design pattern.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * @example <?php $give_gift_aid = Give_Gift_Aid(); ?>
 *
 * @since   1.0.0
 *
 * @return object Give_Gift_Aid
 */
function Give_Gift_Aid() {
	return Give_Gift_Aid::get_instance();
}

Give_Gift_Aid();
