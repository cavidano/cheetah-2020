<?php
    
    add_action( 'wp_enqueue_scripts', 'enqueue_theme_assets' );

    function enqueue_theme_assets(){

        ////////////////////////////////////////
        // CSS
        ////////////////////////////////////////

        if (is_page('ccf-global') || is_singular('events')) {
            wp_enqueue_style(
                'leaflet-css',
                'https://unpkg.com/leaflet@1.3.4/dist/leaflet.css'
            );
        }
        
        if (is_page('cheetah-facts') || is_page('ccf-kids') || is_singular('ccf-kids')) {

            wp_enqueue_style(
                'cheetah-tracks',
                'https://cheetah.org/cheetah-2019/wp-content/themes/ccf-twentynineteen/cheetah-tracks-regular/cheetah-tracks-regular.css'
            );
            
        }

        if (is_page_template('page-donate.php') || is_page_template('page-general.php' || is_page_template('protected-page.php'))){
        
        wp_enqueue_style(
            'form-css',
            get_template_directory_uri() . '/css/forms.css'
        );
        
        }

        wp_enqueue_style( 
            'theme', 
            get_template_directory_uri() . '/css/theme.css'
        );

        wp_enqueue_style( 
            'fontAwesome', 
            'https://use.fontawesome.com/releases/v5.5.0/css/all.css'
        );
        
        wp_enqueue_style( 
            'googleFonts', 
            'https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,700,700i,900,900i' 
        );

        // ekko lightbox
        wp_enqueue_style( 
            'lightbox-css', 
            'https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css'
        );

        ////////////////////////////////////////
        // JS
        ////////////////////////////////////////

        wp_enqueue_script( 
            'popper', 
            'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js', 
            ['jquery'],
            '1.14.3', 
            true 
        );

        wp_enqueue_script( 
            'bootstrap-js', 
            'https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js',
            ['jquery'],
            '4.2.1', 
            true 
        );

        // ekko lightbox
        wp_enqueue_script( 
            'lightbox-js', 
            'https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js', 
            ['jquery'],
            '1.1.0', 
            true 
        );

        wp_enqueue_script( 
            'cookies', 
            'https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js',
            ['jquery'],
            '3.4.4', 
            true 
        );

        wp_enqueue_script( 
            'main', 
            get_template_directory_uri() . '/js/main.js',
            ['jquery'],
            '1.0.0', 
            true 
        );

        if ( is_page( 'ccf-global' ) || is_singular('events')) {

            wp_enqueue_script( 
                'leaflet-js', 
                'https://unpkg.com/leaflet@1.3.4/dist/leaflet.js',
                ['jquery'],
                '1.3.4', 
                false 
            );
            
            wp_enqueue_script( 
                'leaflet-providers', 
                get_template_directory_uri() . '/js/vendor/leaflet-providers.js',
                ['jquery', 'leaflet-js'], 
                '1.0.0', 
                false 
            );

            wp_enqueue_script( 
                'ccf-global-map', 
                get_template_directory_uri() . '/js/ccf-global-map.js',
                ['jquery', 'main', 'leaflet-js', 'leaflet-providers'], 
                '1.0.0', 
                true 
            );

            $myData = array(
                'templateUrl' => get_template_directory_uri(), 
            );

            wp_localize_script( 'ccf-global-map', 'path', $myData );
        }

    } // enqueue_theme_assets