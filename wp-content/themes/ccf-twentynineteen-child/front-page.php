<?php

/**
 * The front page template file
 *
 * If the user has selected a static page for their homepage, this is what will
 * appear.
 * Learn more: https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

 get_header(); 

 $banner_image = get_field('image');
 $link = get_field('link');

 ?>

  <main class="overflow-auto" id="content" role="main">

    <section id="introduction">

      <div class="featured-panel responsive-lg">

        <div class="card bg-white">
            <div class="gradient-overlay-x-black">
                <?php if ($banner_image) : ?>

                <img class="card-img" src="<?php echo $banner_image['url']; ?>" alt="<?php echo $banner_image['alt']; ?>">

                <?php endif; /* banner_image */ ?>
            </div>

            <div class="card-img-overlay d-flex border-bottom border-lg-0">
                <div class="align-self-center">

                    <div class="container text-white">

                        <div class="narrow-max-width">
                            <h1 class="display-3 mb-2  text-shadow"><?php the_field('headline'); ?></h1>
                            <a href="<?php echo $link['url']; ?>" class="btn btn-lg btn-primary"><?php echo $link['title']; ?></a>
                        </div>

                    </div>
                    <!-- .comtainer -->

                </div>
                <!-- .align-self-center -->
            </div>

        </div>
        <!-- .card -->

      </div>
      <!-- .featured-panel -->

    </section>
    <!-- #introduction -->

    <section class="py-5 py-xl-7">

      <h2 class="sr-only">News and Events</h2>

      <section class="container mb-5" id="latest-news">

        <header class="text-center mb-3">
            <h3 class="display-4 mb-0">Latest News</h3>
            <a class="link text-body fs-md" href="<?php echo home_url(); ?>/news">All News</a>
        </header>

        <div class="row matrix-gutter justify-content-center">

          <?php

          global $post;
          
          $args = array( 'posts_per_page' => 3, 'orderby' => 'date' );
          $postslist = get_posts($args);
          
          foreach ($postslist as $post) :
          setup_postdata($post);
                    
          ?>

          <div class="col-lg-4 mb-5 mb-lg-0">
          
              <div class="featured-article">
        
                <div>

                    <span><?php echo get_the_date(); ?></span>

                    <?php if( has_post_thumbnail() ):
                        $featured_image_url = get_the_post_thumbnail_url( get_the_ID(),'full' );
                    ?>
                                    
                    <img class="w-100" src="<?php echo $featured_image_url; ?>" alt="<?php the_title(); ?>">
                    
                    <?php else : ?>
                    
                    <img class="w-100" src="https://via.placeholder.com/1000x563" alt="Placeholder">
                    
                    <?php endif; /* featured_image */ ?>

                </div>

                <a class="stretched-link text-body" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                  <span class=""><?php the_title(); ?></span> 
                </a>

            </div>
            <!-- .featured-article -->

          </div>
          <!-- .col -->

          <?php endforeach; wp_reset_postdata(); ?>

        </div>
        <!-- .row -->

      </section>
      <!-- #latest-news -->

      <?php

      $args = array(
          'post_type' => 'events',
          'order' => 'ASC',
          'meta_key' => 'start_date',
          'meta_type' => 'DATETIME',
          'orderby' => 'meta_value',
      );
      
      $events_header = false;
      $loop = new WP_Query($args);
      $count = 1;

      while ($loop->have_posts()) : $loop->the_post();

      $date = new DateTime(get_field('start_date'));
      $today = DateTime::createFromFormat("U", time());
      
      if ($date > $today && $count <= 3) :

        $count++;

        $show_events = true;
        $featured_image_id = get_post_thumbnail_id($post->ID);
        $featured_image = wp_get_attachment_image_src($featured_image_id, 'full', false, '');
        $featured_image_alt = get_post_meta($featured_image_id, '_wp_attachment_image_alt', true);

        if ($events_header == false) :

      ?>

      <section class="container" id="events">

          <header class="text-center mb-3">
              <h3 class="display-4 mb-0">Upcoming Events</h3>
              <a class="link text-body fs-md" href="<?php echo home_url(); ?>/events">All Events</a>
          </header>
          
          <div class="row matrix-gutter justify-content-center">

      <?php endif; /* $events_header */ ?>

              <div class="col-md-4">

                <div class="card border h-100">

                  <?php if ($featured_image) : ?>
                  <img class="card-img-top" src="<?php echo $featured_image[0]; ?>"
                    alt="<?php echo $featured_image_alt; ?>">
                  <?php else : ?>
                  <img class="card-img" src="https://via.placeholder.com/1000x563" alt="Placeholder">
                  <?php endif; /* $featured_image */ ?>

                  <div class="card-body">

                    <p class="has-icon f-sans-serif fs-md mb-1">
                      <span class="fas fa-map-marker-alt"></span>
                      <span class="title"><?php the_field('location') ?></span>
                    </p>

                    <h2 class="h5"><?php the_title(); ?></h2>

                    <p class="f-sans-serif fs-md">

                      <strong class="d-block"><?php the_field('start_date') ?></strong>

                      <?php if ($time) : ?>
                      <span class="text-muted"><?php echo $time; ?></span>
                      <?php endif; /* $time */ ?>
                    </p>
                  </div>
                  <!-- .card-body -->

                  <div class="card-footer py-2">
                    <a href="<?php the_permalink(); ?>" class="btn btn-block btn-primary stretched-link">
                      Event Details
                    </a>
                  </div>
                  <!-- .card-footer -->

                </div>
                <!-- .card -->

              </div>
              <!-- .col -->

          <?php 

          $events_header = true;

          endif; /* $date > $today */

      endwhile; /* have_posts() */
     
      if ($events_header) : ?>

            </div>

        </section>

      <?php

      endif; /* $events_header */

      ?>

  </main>
  <!-- #content -->
  
  <?php get_template_part('template-parts/donate-panel'); ?>
  
  <?php get_footer(); ?>
