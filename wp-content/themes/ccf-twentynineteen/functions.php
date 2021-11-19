<?php 
    
    ////////////////////////////////////////
    // Enqueue CSS and JS
    ////////////////////////////////////////

    require_once( __DIR__ . '/lib/enqueue-assets.php' );

    ////////////////////////////////////////
    // Theme Support
    ////////////////////////////////////////

    require_once( __DIR__ . '/lib/theme-support.php' );

    ////////////////////////////////////////
    // ACF Theme Options
    ////////////////////////////////////////

    require_once( __DIR__ . '/lib/acf-theme-options.php' );

    ////////////////////////////////////////
    // ACF Custom WYSIWYG
    ////////////////////////////////////////

    require_once( __DIR__ . '/lib/acf-custom-wysiwyg.php' );

    ////////////////////////////////////////
    // ACF 5 Early Access
    ////////////////////////////////////////

    define( 'ACF_EARLY_ACCESS', '5' );

    function broadcasted_from() {
        // Check that Broadcast is enabled.
        if ( ! function_exists( 'ThreeWP_Broadcast' ) )
            return;
        // Load the broadcast data for this post.
        global $post;
        $broadcast_data = ThreeWP_Broadcast()->get_post_broadcast_data( get_current_blog_id(), $post->ID );
        // This post must be a child. Check for a parent.
        $parent = $broadcast_data->get_linked_parent();
        if ( ! $parent )
            return;

        // Fetch the permalink
        switch_to_blog( $parent[ 'blog_id' ] );
        $blog_name = get_bloginfo( 'name' );
        $permalink = get_post_permalink( $parent[ 'post_id' ] );
        restore_current_blog();

        // And now assemble a text.
        $r = sprintf( 'This post was broadcasted from <a href="%s">%s</a>.', $permalink, $blog_name );
        return $r;
    }

    add_shortcode( 'broadcasted_from', 'broadcasted_from' );

?>