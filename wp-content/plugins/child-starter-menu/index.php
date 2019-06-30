<?php

/*
Plugin Name: Child Starter Menu
Plugin URI: http://fullwindsor.co/
Description: A simple WordPress menu
Author: Sean Dennis
Version: 1.0
Author URI: http://fullwindsor.co
*/

  function starterMenu($menu_name) {

    $locations = get_nav_menu_locations();
    $menu = wp_get_nav_menu_object($locations[$menu_name]);
    $menuitems = wp_get_nav_menu_items($menu->term_id, array());

    $current_page = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $closing_tags = '';

    if ($menu_name == 'Header') : 

        echo '<nav class="nav mt-auto justify-content-end" role="navigation">';

        foreach( $menuitems as $menuitem ):

            $attr_title = $menuitem->attr_title;
            $current = '';
            $label = $menuitem->title;
            $url = $menuitem->url;

            // Compare current menu item with the current section

            if ($url == $current_page) :
              $current = 'active';
            elseif (is_singular('events') && $label == 'Events') :
              $current = 'active';
            elseif (is_singular('post') && $label == 'News') :
              $current = 'active';
            endif;

            // Output the menu item

            echo '<div class="nav-item '. ($label == 'Donate' ? 'donate' : '') .'"><a class="nav-link '.$current.' " href="'.$url.'" title="'.$attr_title.'">'.$label.'</a></div>';

        endforeach;

        echo '</nav>';

    endif;

  }

?>