<?php

namespace threewp_broadcast\premium_pack\classes\shortcode_items\actions;

/**
	@brief		The parse (actually preparse) when a shortcode item is found.
	@details	Should be called preparse, but it's too late for that.
	@since		2018-11-14 15:00:20
**/
class parse_find
	extends \threewp_broadcast\actions\action
{
	/**
		@brief		IN: The broadcasting data.
		@since		2018-11-14 14:59:56
	**/
	public $broadcasting_data;

	/**
		@brief		IN: The find array.
		@since		2018-11-14 15:00:07
	**/
	public $find;

	public function get_prefix()
	{
		return 'broadcast_shortcode_items_';
	}
}