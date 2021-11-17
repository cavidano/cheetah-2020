<?php

namespace threewp_broadcast\premium_pack\duplicate_post;

use \threewp_broadcast\posts\actions\bulk\wp_ajax;

/**
	@brief			Create a duplicate of a post.
	@plugin_group	Utilities
	@since			2021-05-13 22:28:48
**/
class Duplicate_Post
	extends \threewp_broadcast\premium_pack\base
{
	public function _construct()
	{
		$this->add_action( 'threewp_broadcast_get_post_bulk_actions' );
		$this->add_action( 'threewp_broadcast_post_action' );
		add_action( 'admin_init', function()
		{
			if ( ! isset( $_GET[ 'ed123' ] ) )
				return;
			$new_post_id = Duplicate_Post::instance()->duplicate_post( 307 );
			ddd( 'new post %s', $new_post_id );
			exit;
		} );
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
		if( $action->action != 'duplicate_post' )
			return;

		$post_id = $action->post_id;
		static::duplicate_post( $post_id );
	}

	public function threewp_broadcast_get_post_bulk_actions( $action )
	{
		$a = new wp_ajax;
		$a->set_ajax_action( 'broadcast_post_bulk_action' );
		$a->set_data( 'subaction', 'duplicate_post' );
		$a->set_id( 'bulk_duplicate_post' );
		// Post bulk action name.
		$a->set_name( __( 'Duplicate Post', 'threewp_broadcast' ) );
		$a->set_nonce( 'broadcast_post_bulk_actionduplicate_post' );
		$action->add( $a );
	}

	/**
		@brief		The function that duplicates posts.
		@since		2021-05-25 17:50:02
	**/
	public static function duplicate_post( $post_id )
	{
		$t = static::instance();
		$old_post = get_post( $post_id );
		$new_post = clone( $old_post );
		unset( $new_post->ID );
		unset( $new_post->guid );
		$meta = get_post_meta( $post_id );

		$taxonomies = get_object_taxonomies( [ 'object_type' => $old_post->post_type ], 'array' );
		foreach( $taxonomies as $taxonomy => $ignore )
		{
			$terms = wp_get_object_terms( $post_id, $taxonomy );
			$term_ids = [];
			foreach( $terms as $term )
				$term_ids []= $term->term_id;
			$taxonomies[ $taxonomy ] = $term_ids;
		}

		$new_post_id = wp_insert_post( $new_post );

		$t->debug( 'Adding meta: %s', $meta );
		foreach( $meta as $meta_key => $meta_values )
			foreach( $meta_values as $meta_value_index => $meta_value )
				update_post_meta( $new_post_id, $meta_key, $meta_value );

		$t->debug( 'Adding taxonomies: %s', $taxonomies );
		foreach( $taxonomies as $taxonomy => $term_ids )
			wp_set_object_terms( $new_post_id, $term_ids, $taxonomy );

		// Call an action here to allow others to modify things.

		return $new_post_id;
	}
}
