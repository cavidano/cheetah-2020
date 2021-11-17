<?php
namespace GiveRecurring\Logs\Migrations;

use Give\Framework\Database\DB;
use Give\Framework\Migrations\Contracts\Migration;

/**
 * Class DeleteLogs
 * @package GiveRecurring\Logs\Migrations
 *
 * Delete old logs after migration to the new logging system is completed
 *
 * @since 1.12.3
 */
class DeleteLogs extends Migration {
	/**
	 * @inheritdoc
	 */
	public static function id() {
		return 'give-recurring-delete-old-logs';
	}

	/**
	 * @inheritdoc
	 */
	public static function title() {
		return 'Delete old synchronizer logs';
	}

	/**
	 * @inheritdoc
	 */
	public static function source() {
		return GIVE_RECURRING_ADDON_NAME;
	}

	/**
	 * @inheritdoc
	 */
	public static function timestamp() {
		return strtotime( '2021-02-18' );
	}

	/**
	 * @inheritdoc
	 */
	public function run() {
		global $wpdb;

		DB::get_var( "DELETE FROM {$wpdb->posts} WHERE post_type = 'give_recur_sync_log'" );
	}
}
