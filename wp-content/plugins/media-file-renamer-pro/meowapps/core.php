<?php

class MeowAppsPro_MFRH_Core {

	private $prefix = 'mfrh';
	private $item = 'Media File Renamer Pro';
	private $admin = null;
	private $core = null;

	public function __construct( $prefix, $mainfile, $domain, $version, $core, $admin ) {
		// Pro Admin (license, update system, etc...)
		$this->prefix = $prefix;
		$this->mainfile = $mainfile;
		$this->domain = $domain;
		$this->core = $core;
		$this->admin = $admin;
		if ( is_admin() ) {
			new MeowApps_Admin_Pro( $prefix, $mainfile, $domain, $this->item, $version );
			add_filter( 'mfrh_admin_attachment_fields', array( $this, 'admin_attachment_fields' ), 10, 2 );
		}

		// Overrides for the Pro
		add_filter( 'mfrh_plugin_title', array( $this, 'plugin_title' ), 10, 1 );
		add_filter( 'mfrh_numbered', array( $this, 'numbered' ), 10, 1 );
		add_filter( 'mfrh_method', array( $this, 'method' ), 10, 1 );
		add_filter( 'mfrh_converts', array( $this, 'converts' ), 10, 1 );
		add_filter( 'mfrh_manual', array( $this, 'manual' ), 10, 1 );
		add_filter( 'mfrh_force_rename', array( $this, 'force_rename' ), 10, 1 );
		if ( get_option( "mfrh_sync_alt" ) && $this->admin->is_registered() )
			add_action( 'mfrh_media_renamed', array( $this, 'action_sync_alt' ), 10, 3 );
		if ( get_option( "mfrh_sync_media_title" ) && $this->admin->is_registered() )
			add_action( 'mfrh_media_renamed', array( $this, 'action_sync_media_title' ), 10, 3 );
	}

	function method( $default_method ) {
		if ( $this->admin->is_registered() )
			return get_option( 'mfrh_auto_rename', 'media_title' );
		else
			return 'media_title';
	}

	function action_sync_alt( $post, $old_filepath, $new_filepath ) {
		$auto_rename = get_option( 'mfrh_auto_rename', 'media_title' );
		switch ( $auto_rename ) {
		case 'media_title':
			$new_alt = apply_filters( 'mfrh_rewrite_alt', $post['post_title'] );
			update_post_meta( $post['ID'], '_wp_attachment_image_alt', $new_alt );

			$this->core->log( "Alt\t-> {$post['post_title']}" );
			break;
		case 'post_title':
		case 'product_title':
			$attachedpost = $this->core->get_post_from_media( $post['ID'] );
			if ( is_null( $attachedpost ) )
				return;
			$title = $attachedpost->post_title;
			$new_alt = apply_filters( 'mfrh_rewrite_alt', $title );
			update_post_meta( $post['ID'], '_wp_attachment_image_alt', $new_alt );
			$this->core->log( "Alt\t-> {$title}" );
			break;
		}
	}

	function action_sync_media_title( $post, $old_filepath, $new_filepath ) {
		$auto_rename = get_option( 'mfrh_auto_rename', 'media_title' );
		switch ( $auto_rename ) {
		case 'alt_text':
			$alt = get_post_meta( $post['ID'], '_wp_attachment_image_alt', true );
			if ( !empty( $alt ) ) {
				$update = array( 'ID' => $post['ID'], 'post_title' => $alt );
				wp_update_post( $update );
				$this->core->log( "Media Title set to {$alt}." );
			}
			break;
		case 'post_title':
		case 'product_title':
			$attachedpost = $this->core->get_post_from_media( $post['ID'] );
			if ( is_null( $attachedpost ) )
				return;
			$update = array( 'ID' => $post['ID'], 'post_title' => $attachedpost->post_title );
			wp_update_post( $update );
			$this->core->log( "Media Title set to {$attachedpost->post_title}." );
			break;
		}
	}

	function plugin_title( $string ) {
			return $string . " (Pro)";
	}

	function converts() {
		return get_option( 'mfrh_convert_to_ascii', false ) && $this->admin->is_registered();
	}

	function manual() {
		return get_option( 'mfrh_manual_rename', false ) && $this->admin->is_registered();
	}

	function numbered() {
		return get_option( 'mfrh_numbered_files', false ) && $this->admin->is_registered();
	}

	function force_rename() {
		return get_option( 'mfrh_force_rename', false ) && $this->admin->is_registered();
	}

	function admin_attachment_fields( $html, $post ) {
		if ( !$this->admin->is_registered() )
			return $html;
		$info = mfrh_pathinfo( get_attached_file( $post->ID ) );
		$basename = $info['basename'];
		$is_manual = get_option( 'mfrh_manual_rename' );
		$html = '<input type="text" ' . ( $is_manual && $this->admin->is_registered() ? '' : 'readonly' ) . ' class="widefat" name="mfrh_new_filename" value="' . $basename. '" />';
		if ( !$is_manual ) {
			$html .= '<p class="description">You need to enable <b>Manual Rename</b> in the plugin settings.</p>';
		}
		else {
			$html .=  '<p class="description">You can rename the file manually.</p>';
		}
		return $html;
	}

}

?>
