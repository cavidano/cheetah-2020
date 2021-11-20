<?php

// Child Post Types

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

        register_post_type(
            'Videos',
            array(
                'labels' => array(
                'name' => __('Videos'),
                'singular_name' => __('Video')
            ),
            'supports' => array( 'title' ),
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-video-alt3'
            )
        );


        register_post_type(
            'CCF Cheetahs',
            array(
                'labels' => array(
                'name' => __('CCF Cheetahs'),
                'singular_name' => __('Cheetah')
            ),

            'public' => true,
            'menu_icon' => get_template_directory_uri() . '/images/wp-icon-ccf-cheetahs.png'
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

      if( ( !is_admin() && is_post_type_archive('events')) && $query->is_main_query() ) { 

        $meta_query = array(
            'relation' => 'OR',
            array(
              'key'   => 'end_date',
              'value'   => date("Y-m-d"),
              'type'    => 'DATETIME',
              'compare' => '>=',
            ),
            array(
              'key'   => 'start_date',
              'value'   => date("Y-m-d"),
              'type'    => 'DATETIME',
              'compare' => '>=',
            ),
          );

          $query->query_vars['order'] = 'ASC';
          $query->query_vars['orderby'] = 'meta_value';

          $query->set('meta_query', $meta_query);

      }

    }

    // Fix wp-activate.php

    add_action( 'activate_header', 'load_site_specific_plugin' );

    function load_site_specific_plugin() {

        if (wp_installing()) {
            require_once( WP_PLUGIN_DIR . '/child-starter-menu/index.php' );
            require_once( WP_PLUGIN_DIR . '/gtranslate/gtranslate.php' );
        }

        return ;
    }
