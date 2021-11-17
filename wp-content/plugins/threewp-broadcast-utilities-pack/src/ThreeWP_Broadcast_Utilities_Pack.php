<?php

namespace threewp_broadcast\premium_pack;

class ThreeWP_Broadcast_Utilities_Pack
	extends \threewp_broadcast\premium_pack\Plugin_Pack
{
	public $plugin_version = BROADCAST_UTILITIES_PACK_VERSION;

	public function edd_get_item_name()
	{
		return 'ThreeWP Broadcast Utilities Pack';
	}

	public function get_plugin_classes()
	{
		return
		[
			__NAMESPACE__ . '\\bulk_cloner\\Bulk_Cloner',
			__NAMESPACE__ . '\\cdn_workaround\\CDN_Workaround',
			__NAMESPACE__ . '\\copy_options\\Copy_Options',
			__NAMESPACE__ . '\\custom_field_cleanup\\Custom_Field_Cleanup',
			__NAMESPACE__ . '\\duplicate_post\\Duplicate_Post',
			__NAMESPACE__ . '\\lock_post\\Lock_Post',
			__NAMESPACE__ . '\\manual_post_actions\\Manual_Post_Actions',
			__NAMESPACE__ . '\\media_cleanup\\Media_Cleanup',
			__NAMESPACE__ . '\\menus\\Menus',
			__NAMESPACE__ . '\\page_content_shortcode\\Page_Content_Shortcode',
			__NAMESPACE__ . '\\php_code\\PHP_Code',
			__NAMESPACE__ . '\\shortcodes\\Shortcodes',
			__NAMESPACE__ . '\\sitemaps\\Sitemaps',
			__NAMESPACE__ . '\\sync_taxonomies\\Sync_Taxonomies',
			__NAMESPACE__ . '\\user_role_sync\\User_Role_Sync',
			__NAMESPACE__ . '\\widgets\\Widgets',
		];
	}

	/**
		@brief		Show our license in the tabs.
		@since		2015-10-28 15:10:14
	**/
	public function threewp_broadcast_plugin_pack_tabs( $action )
	{
		$action->tabs->tab( 'utilities_pack' )
			->callback( [ $this, 'edd_admin_license_tab' ] )		// this, because the tabs object comes from plugin pack, not from here.
			->name_( 'Utilities pack license' );
	}
}
