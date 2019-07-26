<?php


// Parent Post Types

function create_child_post_types() {

    register_post_type(
        'Events',
        array(
            'labels' => array(
            'name' => __('Events'),
            'singular_name' => __('Event')
        ),
        'supports' => array( 'title', 'thumbnail' ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-calendar'
        )
    );

}

add_action( 'init', 'create_child_post_types' );

    ////////////////////////////////////////
    // Remove Parent Theme Features
    ////////////////////////////////////////

    // Parent Post Types

    function remove_actions_parent_theme() {
        remove_action( 'init', 'create_parent_post_types' );
        remove_action( 'init', 'parent_tax_init' );
    };

    add_action('after_setup_theme', 'remove_actions_parent_theme');

    // Theme Templates

    function remove_parent_page_template($page_templates){

        unset($page_templates['page-ccf-events.php']);
        unset($page_templates['page-ccf-kids.php']);
        unset($page_templates['page-cheetah-facts.php']);
        unset($page_templates['page-resource-library.php']);
        unset($page_templates['page-ccf-videos.php']);
        unset($page_templates['page-donate.php']);
        unset($page_templates['page-subpage.php']);
        unset($page_templates['page-videos.php']);
        unset($page_templates['page-events.php']);

        return $page_templates;
    }

    add_filter('theme_page_templates', 'remove_parent_page_template');

    // Remove footer nav location

    function remove_parent_theme_locations() {
        unregister_nav_menu( 'Footer' );
        unregister_nav_menu( 'What We Do' );
        unregister_nav_menu( 'Who We Are' );
        unregister_nav_menu( 'Get Involved' );
        unregister_nav_menu( 'Learn' );
    }

    add_action( 'after_setup_theme', 'remove_parent_theme_locations', 20 );

    // Change the query on Events archive

    add_action( 'pre_get_posts', 'custom_get_posts' );

    function custom_get_posts( $query ) {

      if( (is_post_type_archive('events')) && $query->is_main_query() ) {    
        $query->query_vars['order'] = 'ASC';
        $query->query_vars['meta_key'] = 'start_date';
        $query->query_vars['meta_type'] = 'DATETIME';
        $query->query_vars['meta_value'] = date("Y-m-d");
        $query->query_vars['meta_compare'] = '>';
        $query->query_vars['orderby'] = 'meta_value';
      }

    }
