<?php

/*
Plugin Name: Starter Menu
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
    $reverse_menuitems = array_reverse($menuitems);
    $queried_object = get_queried_object();
    
    $current_post_type = $queried_object->post_type;
    $current_term = $queried_object->term_id;

    $current_section = explode("/", substr($_SERVER['REQUEST_URI'], 1));

    if (!is_child_theme()) :

        if ($current_section[1] == 'get-involved') :

          $current_section = $current_section[1];
        
        elseif ($current_section[0] == 'resource-library' || $current_section[0] == 'ccf-videos' || $current_section[0] == 'resource-category') :

          $current_section = 'learn';
        
        elseif ($current_section[0] == 'events') :
          
          $current_section = 'get-involved';
        
        else :

          $current_section = $current_section[0];

        endif;

    else :

        if ($current_section[2] == 'events') :

            $current_section = 'get-involved';

        else :

            $current_section = $current_section[1];

        endif;

    endif;

    $count = 0;
    $submenu = false;
    $child = false;
    $parent = false;

    // This loop adds some helpful flags to the menu object

    foreach( $reverse_menuitems as $menuitem ):

      // Check to see if this is a parent

      if ($child == true && $menuitem->menu_item_parent && $previous_parent != $menuitem->menu_item_parent) {

        $menuitem->item_type = 'parent';

        // Indicate a parent has been found

        $parent = true;

        // Reset the child variable

        $child = false;

      }

      // Check to see if this is a child

      elseif ($menuitem->menu_item_parent) {

        $menuitem->item_type = 'child';

        // Set a flag that we just picked up a child

        $child = true;

        // Take note of this child's parent

        $previous_parent = $menuitem->menu_item_parent;

      }

      // Check to see if this is an orphaned parent

      elseif ($parent == false && $child == true) {

        $menuitem->item_type = 'orphaned_parent';

        // Reset the child variable

        $child = false;

      }

      // Check to see if this is a grandparent

      elseif ($parent == true) {

        $menuitem->item_type = 'grandparent';

        // Reset the child variable

        $child = false;

        // Reset the parent flag

        $parent = false;

      }

      // Check to see if this is a childless parent

      else {

        $menuitem->item_type = 'childless_parent';

      }

    endforeach;

    $closing_tags = '';

    if ($menu_name == 'Header') : 

        echo '<nav class="nav mt-auto justify-content-end" role="navigation">';

        foreach( $menuitems as $menuitem ):

            $attr_title = $menuitem->attr_title;          
            $classes = implode(' ',$menuitem->classes);
            $current = '';
            $label = $menuitem->title;
            $id = preg_replace("/[\s_]/", "-", preg_replace("/[\s-]+/", " ", preg_replace("/[^a-z0-9_\s-]/", "", strtolower($label))));
            $parent = $menuitem->menu_item_parent;
            $url = $menuitem->url;
            $xfn = $menuitem->xfn;

            // Compare current menu item with the current section

            if ($xfn == $current_section) {
              $current = 'active';
            }

            // If we've picked up the news menu item and are on a post

            elseif ($xfn == 'news' && $current_post_type == 'post') {
              $current = 'active';
            }

            // If we've picked up the News menu item and are on a taxonomy page

            elseif ($xfn == 'news' && $current_term && $current_section != 'learn') {
              $current = 'active';
            }

            if ($menuitem->item_type == 'childless_parent') :
                echo '<div class="nav-item '.$classes.'"><a class="nav-link '.$current.' " href="'.$url.'" title="'.$attr_title.'">'.$label.'</a></div>';
                $count++;
                continue;
            endif;

            if ($menuitem->item_type == 'grandparent') {
              echo '<div class="nav-item dropdown '.$classes.'"><a class="nav-link dropdown-toggle '.$current.'" href="#" id="nav-'.$id.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="'.$attr_title.'" role="button">'.$label.'</a><div class="dropdown-menu" aria-labelledby="nav-'.$id.'"><div class="d-lg-flex">';
              $grandparent_closing_tags = '</div></div></div>';
              $count++;
              continue;
            }

            if ($menuitem->item_type == 'parent') {
              echo '<ul class="extensible-list"><li class="leader">'.$label.'</li>';
              $open_parent = $menuitems[$count];
              $closing_tags = '</ul>';
              $count++;
              continue;
            }

            if ($menuitem->item_type == 'orphaned_parent') :
                echo '<div class="nav-item dropdown '.$classes.'"><a class="nav-link dropdown-toggle '.$current.'" href="'.$url.'" id="nav-'.$id.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="'.$attr_title.'" role="button">'.$label.'</a><div class="dropdown-menu" aria-labelledby="nav-'.$id.'"><ul class="extensible-list">';
                $closing_tags = '</ul></div></div>';
                $count++;
                continue;
            endif;

            if ($menuitem->item_type == 'child') :
                echo '<li><a href="'.$url.'" title="'.$attr_title.'">'.$label.'</a></li>';

                // Does this child item 1) have menu items that come after it? and 2) have siblings?

                if (array_key_exists($count + 1, $menuitems) && $menuitems[ $count + 1 ]->menu_item_parent == $parent) :
                    $count++;
                    continue;
                

                // If not, output the closing tags of this child item's parent.

                else :
                    echo $closing_tags;
                    $closing_tags = '';            
                endif;

                // Check to see if this item's parent has siblings 

                if (array_key_exists($count + 1, $menuitems) && $open_parent && $menuitems[$count + 1]->menu_item_parent !== $open_parent->menu_item_parent) {

                  // Output grandparent closing tags

                  echo $grandparent_closing_tags;

                  $open_parent = null;

                }

                $count++;

            endif;

        endforeach;

        echo '</nav>';

    endif;

    if ($menu_name == 'Footer') :

      foreach($menuitems as $menuitem) :

        $label = $menuitem->title;
        $attr_title = $menuitem->attr_title;
        $id = $menuitem->ID;
        $xfn = $menuitem->xfn;
        $url = $menuitem->url;
        $classes = implode(' ',$menuitem->classes);
        $parent = $menuitem->menu_item_parent;

        if ($menuitem->item_type == 'orphaned_parent') :
          echo '<div class="col-lg-4 col-xl-2 mb-3 mb-xl-0 mx-auto"><ul class="extensible-list"><li><span class="font-weight-bold mb-2">'.$label.'</span></li>';
          $closing_tags = '</ul></div>';
          $count++;
          continue;
        endif;

        if ($menuitem->item_type == 'child') :
          echo '<li><a href="'.$url.'" title="'.$attr_title.'">'.$label.'</a></li>';

          // Does this child item 1) have menu items that come after it? 2) have siblings?

          if (array_key_exists($count + 1, $menuitems) && $menuitems[ $count + 1 ]->menu_item_parent == $parent) :
            $count++;
            continue;

          // If not, output the closing tags of this child item's parent.

          else :
            echo $closing_tags;
            $closing_tags = '';            
          endif; // array_key_exists($count + 1, $menuitems)

          // Check to see if this item's parent has siblings 

          if (array_key_exists($count + 1, $menuitems) && $open_parent && $menuitems[$count + 1]->menu_item_parent !== $open_parent->menu_item_parent) :

            // Output grandparent closing tags

            echo $grandparent_closing_tags;

            $open_parent = null;

          endif; // array_key_exists($count + 1, $menuitems)

          $count++;

        endif; // $menuitem->item_type == 'child'

      endforeach; // $menuitems as $menuitem

    endif; // $menu_name == 'Footer'

    if ($menu_name == 'What We Do' || $menu_name == 'Who We Are' || $menu_name == 'Learn'  || $menu_name == 'Get Involved' ) :

      global $post;

      echo '<nav class="collapse d-xl-block mb-xl-4" id="aside-nav"><ul class="extensible-list text-white py-3 py-xl-0">';

      foreach($menuitems as $menuitem) :

        $label = $menuitem->title;
        $attr_title = $menuitem->attr_title;
        $url = $menuitem->url;
        $classes = implode(' ',$menuitem->classes);

        if (is_tax('resource-category')) :
            $resource_library = get_posts(array('name' => 'resource-library', 'post_type' => 'page', 'post_status' => 'publish', 'numberposts' => 1));
        endif;
        
        echo '<li class="page_item '.($post->ID == $menuitem->object_id || $resource_library[0]->ID == $menuitem->object_id ? 'current_page_item': '').'"><a href="'.$url.'" title="'.$attr_title.'">'.$label.'</a>';

      endforeach; // $menuitems as $menuitem

      echo '</ul></nav>';

    endif; // $menu_name == 'What We Do'

  }

?>