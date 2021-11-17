<?php

namespace threewp_broadcast\premium_pack\custom_field_cleanup;

use \threewp_broadcast\posts\actions\bulk\wp_ajax;

/**
	@brief			Cleans up the custom fields of a post.
	@plugin_group	Utilities
	@since			2021-05-10 21:49:17
**/
class Custom_Field_Cleanup
	extends \threewp_broadcast\premium_pack\base
{
	public function _construct()
	{
		$this->add_action( 'threewp_broadcast_get_post_bulk_actions' );
		$this->add_action( 'threewp_broadcast_post_action' );
	}

	// --------------------------------------------------------------------------------------------
	// ----------------------------------------- Callbacks
	// --------------------------------------------------------------------------------------------

	/**
		@brief		Handle the post action.
		@since		2016-03-01 21:12:57
	**/
	public function threewp_broadcast_post_action( $action )
	{
		if( $action->action != 'custom_field_cleanup' )
			return;

		$post_id = $action->post_id;
		$post_meta = get_post_meta( $post_id );
		foreach( $post_meta as $post_meta_key => $post_meta_values )
		{
			if ( ! is_array( $post_meta_values ) )
				continue;
			if ( count( $post_meta_values ) < 2 )
				continue;
			// We want the first and second values.
			$first = reset( $post_meta_values );
			$second = next( $post_meta_values );

			if ( $first != $second )
				continue;

			$this->debug( 'Cleaning up duplicate values detected for post %s, key %s: %s', $post_id, $post_meta_key, $first );
			delete_post_meta( $post_id, $post_meta_key );

			// Might be serialized, so we don't double serialize.
			$first = maybe_unserialize( $first );
			update_post_meta( $post_id, $post_meta_key, $first );
		}
	}

	public function threewp_broadcast_get_post_bulk_actions( $action )
	{
		$a = new wp_ajax;
		$a->set_ajax_action( 'broadcast_post_bulk_action' );
		$a->set_data( 'subaction', 'custom_field_cleanup' );
		$a->set_id( 'bulk_custom_field_cleanup' );
		// Post bulk action name.
		$a->set_name( __( 'Custom Field Cleanup', 'threewp_broadcast' ) );
		$a->set_nonce( 'broadcast_post_bulk_actioncustom_field_cleanup' );
		$action->add( $a );
	}
}
