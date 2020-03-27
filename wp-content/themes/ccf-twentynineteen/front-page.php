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

 get_header(); ?>

  <main class="overflow-hidden" id="content" role="main">

    <section id="introduction">

      <?php

      $primary_feature = get_field('primary_feature'); 
      $image = $primary_feature['image'];
      $headline = $primary_feature['headline'];
      $text = $primary_feature['text'];
      $link = $primary_feature['link'];
      
      if( $primary_feature ): ?>
      
      <div class="featured-panel responsive-lg">

        <div class="card bg-white">

          <div class="gradient-overlay-y-black">
            
            <?php if( $image ): ?>
              <img class="card-img" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
            <?php else : ?>
              <img class="card-img" src="https://via.placeholder.com/1500x750" alt="Placeholder">
            <?php endif; ?>

          </div>
          <!-- .gradient-overlay-y-black -->

            <div class="card-img-overlay d-flex">
                <div class="align-self-end medium-max-width my-lg-3">
                    <div class="text-white">
                        <h1><?php echo $headline; ?></h1>
                        <p class="fs-lg mb-2"><?php echo $text; ?></p>
                        <a class="link text-primary" href="<?php echo $link['url']; ?>" <?php if($link['target']) : ?>target="<?php echo $link['target'] ?>"<?php endif; ?> title="<?php echo $link['title']; ?>"><?php echo $link['title']; ?></a>
                    </div>
                </div>
                <!-- .align-self-center -->
            </div>

          </div>
          <!-- .card -->

        </div>
        <!-- .featured-panel -->

      <?php endif; /* Primary Feature */ ?>

      <div class="row no-gutters">

        <div class="col-xl-8 d-none d-sm-block">

          <?php

          $secondary_feature = get_field('secondary_feature'); 
          $image = $secondary_feature['image'];
          $headline = $secondary_feature['headline'];
          $text = $secondary_feature['text'];
          $link = $secondary_feature['link'];

          if( $secondary_feature ): ?>

          <div class="featured-panel responsive-lg">

            <div class="card bg-white">

              <div class="gradient-overlay-y-black">

                <?php if ($image) : ?>
                  <img class="card-img" src="<?php echo $image['url']; ?>" alt="<?php echo $image_alt; ?>">
                <?php else : ?>
                  <img class="card-img" src="https://via.placeholder.com/1000x500" alt="Placeholder">
                <?php endif; ?>

              </div>

              <div class="card-img-overlay d-flex">

                <div class="align-self-end medium-max-width my-lg-3">
                  
                  <div class="text-white">

                    <?php if( $headline): ?>
                    <h1>
                      <?php echo $headline; ?>
                    </h1>
                    <?php endif; ?>

                    <?php if( $text): ?>
                    <p class="fs-lg mb-2">
                      <?php echo $text; ?>
                    </p>
                    <?php endif; ?>

                    <?php if( $link): ?>
                    <a class="link text-primary" href="<?php echo $link['url']; ?>" <?php if($link['target']) : ?>target="<?php echo $link['target'] ?>"<?php endif; ?> title="<?php echo $link['title']; ?>"><?php echo $link['title']; ?></a>
                    <?php endif; ?>

                  </div>
                  <!-- .text-white -->

                </div>
                <!-- .align-self-center -->
              </div>

            </div>
            <!-- .card -->

          </div>
          <!-- .featured-panel -->

        </div>
        <!-- .col-* -->

        <div class="col-xl-4">

          <div class="row no-gutters">

            <div class="featured-block d-sm-none">

              <div class="card">

                <div class="gradient-overlay-y-black">

                  <?php if( $image ): ?>
                    <img class="card-img" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
                  <?php else : ?>
                    <img class="card-img" src="https://via.placeholder.com/1000x500" alt="Placeholder">
                  <?php endif; ?>

                </div>
                <!-- .gradient-overlay-y-black -->

                <div class="card-img-overlay d-flex">
                  <div class="align-self-end">

                    <?php if( $link): ?>
                    <a class="btn btn-block btn-primary" href="<?php echo $link['url']; ?>" <?php if($link['target']) : ?>target="<?php echo $link['target'] ?>"<?php endif; ?> title="<?php echo $link['title']; ?>"><?php echo $link['title']; ?></a>
                    <?php endif; ?>

                  </div>
                </div>

              </div>
              <!-- .card -->

            </div>
            <!-- .col-* -->

            <?php endif; /* Secondary Feature */ ?>

            <?php if( have_rows('tertiary_features') ) : while( have_rows('tertiary_features') ): the_row();     

            $image = get_sub_field('image');
            $link = get_sub_field('link');

            ?>

            <div class="featured-block col-md-6 col-xl-12">
            
              <div class="card">

                <?php if( $image ): ?>
                  <div class="gradient-overlay-y-black">
                    <img class="card-img" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
                  </div>
                <?php else : ?>
                  <div class="gradient-overlay-y-black">
                    <img class="card-img" src="https://via.placeholder.com/500x250" alt="Placeholder">
                  </div>
                <?php endif; ?>

                <div class="card-img-overlay d-flex">
                  <div class="align-self-end">
                    <?php if( $link ): ?>
                      <a class="btn btn-block btn-primary stretched-link" href="<?php echo $link['url']; ?>" <?php if($link['target']) : ?>target="<?php echo $link['target'] ?>"<?php endif; ?> title="<?php echo $link['title']; ?>"><?php echo $link['title']; ?></a>
                    <?php endif; ?>
                  </div>
                </div>

              </div>
              <!-- .card -->

            </div>
            <!-- .col-* -->

            <?php endwhile; endif; /* Tertiary feature */ ?>

          </div>
          <!-- .row -->

        </div>
        <!-- .col-* -->

      </div>
      <!-- .row -->

    </section>
    <!-- #introduction -->

    <section class="my-6">
      
      <div class="container my-5" id="latest-news">

        <header class="row align-items-end justify-content-between mb-3">
          <div class="col-md-auto">
            <h2 class="display-4">Latest News</h2>
          </div>
          <!-- .col -->
          <div class="col-md-auto">
            <a class="link text-body" href="<?php echo get_site_url(); ?>/ccf-blog" title="All News">All News</a>
          </div>
          <!-- .col -->
        </header>
        <!-- .row -->

        <?php get_template_part('template-parts/featured-news'); ?>

      </div>
      <!-- #latest-news -->

      <?php get_template_part('template-parts/featured-video-group'); ?>

    </section>

    <section class="container-fluid p-0">

      <h2 class="sr-only">What's New At CCF</h2>

      <div class="row no-gutters">

        <?php while( have_rows('quaternary_features') ): the_row(); 
        
        $image = get_sub_field('image');
        $headline = get_sub_field('headline');
        $link = get_sub_field('link');

        ?>

        <div class="col-md-6">
          <div class="featured-panel responsive-md">

            <div class="card bg-white">

              <?php if( $image ): ?>
                <div class="gradient-overlay-y-black">
                  <img class="card-img" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
                </div>
              <?php else : ?>
                <div class="gradient-overlay-y-black">
                  <img class="card-img" src="https://via.placeholder.com/800x400" alt="Placeholder">
                </div>
              <?php endif; ?>

              <div class="card-img-overlay d-flex">
                <div class="align-self-end">
                  <div class="text-white">
                    <h3><?php echo $headline; ?></h3>
                    <a class="link text-primary" href="<?php echo $link['url']; ?>" <?php if($link['target']) : ?>target="<?php echo $link['target'] ?>"<?php endif; ?>><?php echo $link['title']; ?></a>
                  </div>
                </div>
                <!-- .align-self-center -->
              </div>
            </div>
            <!-- .card -->

          </div>
          <!-- .featured-panel -->
        </div>
        
        <?php endwhile; /* Tertiary feature */ ?>

      </div>
      <!-- .row -->

    </section>

    <?php if( have_rows('cheetah_facts') ): ?>

    <section class="bg-light text-center py-6 pattern-border-top-bottom">

      <?php while( have_rows('cheetah_facts') ): the_row(); 
  
      $cheetah_facts = get_field('cheetah_facts'); 
      $headline = $cheetah_facts['headline'];
      $link = $cheetah_facts['link'];

      ?>

      <div class="container">

        <?php if( $headline): ?>
        <h3 class="display-4 mb-5">
          <?php echo $headline; ?>
        </h3>
        <?php endif; ?>

        <div class="row mb-5">

          <?php if( have_rows('facts') ):

          while ( have_rows('facts') ) : the_row(); 

          $image = get_sub_field('image');
          $headline = get_sub_field('headline');
          $text = get_sub_field('text');
            
          ?>

          <div class="col-sm-9 col-lg-4 mx-auto px-3 mb-4 mb-lg-0">
            <img class="rounded-circle mx-auto mb-4" src="<?php echo $image['url']; ?>"
              alt="<?php echo $image['alt']; ?>">
            <h4 class="text-info"><?php echo $headline; ?></h4>
            <?php echo $text; ?>
          </div>

          <?php endwhile;  ?>

          <?php endif; ?>

        </div>
        <!-- .container-fluid -->

        <?php if( $link ): ?>
        <a class="btn btn-lg btn-primary" href="<?php echo $link['url']; ?>"
          title="<?php echo $link['title']; ?>" <?php if($link['target']) : ?>target="<?php echo $link['target'] ?>"<?php endif; ?>><?php echo $link['title']; ?></a>
        <?php endif; ?>

      </div>
      <!-- .wide -->

      <?php endwhile; /* Facts */ ?>

    </section>

    <?php endif; /* Facts */ ?>

    <section id="cheetah-range" class="featured-panel responsive-xl" dir="ltr">

      <div class="card bg-info">
        <img class="card-img d-xl-none" src="<?php echo get_template_directory_uri(); ?>/images/cheetah-range-sm.svg" alt="Placeholder">
        <img class="card-img d-none d-xl-block" src="<?php echo get_template_directory_uri(); ?>/images/cheetah-range-lg.svg"
          alt="Placeholder">

        <div class="card-img-overlay d-flex p-0">

          <div class="container-fluid align-self-center">
          
            <div class="wide px-lg-2">

                <div class="row">
                  <div class="col-xl-5">

                    <div class="narrow text-white mb-5 mb-xl-0">

                      <h2 class="h1 text-primary">Shrinking habitat</h2>

                      <p class="mb-3">
                        In the last 100 years, the world has lost 90% of the wild cheetah population. Today, one-third of
                        wild cheetahs live in southern Africa. CCF is working across Africa to save the species throughout its range.
                      </p>

                      <ul class="list-unstyled fs-md mb-5">
                        <li>
                          <span class="fas fa-circle fa-fw" style="color:#896258;"></span>
                          <span class="mx-1">Cheetah range pre-1900</span>
                        <li>
                          <span class="fas fa-circle fa-fw text-primary"></span>
                          <span class="mx-1">Cheetah range today</span>
                        <li>
                          <span class="fas fa-star fa-fw text-white"></span>
                          <span class="mx-1">CCF Headquarters</span>
                      </ul>

                      <div class="row matrix-border d-md-none">
                        <div class="col-sm">
                          <a class="btn btn-block btn-primary d-md-none" href="/about/what-we-do/conservation" title="Conservation">Conservation</a>
                        </div>
                        <!-- .col -->
                        <div class="col-sm">
                          <a class="btn btn-block btn-primary d-md-none" href="/about/what-we-do/research" title="Research">Research</a>
                        </div>
                        <!-- .col -->
                        <div class="col-sm">
                          <a class="btn btn-block btn-primary d-md-none" href="/about/what-we-do/education" title="Education">Education</a>
                        </div>
                        <!-- .col -->
                      </div>
                      <!-- .row -->

                      <div class="d-none d-md-block">

                        <ul class="extensible-list horizontal text-center">
                            <li class="position-relative">
                                <img class="h5 rounded-circle mb-2 shadow" src="<?php echo get_template_directory_uri(); ?>/images/ccf-conservation.jpg" alt="Placeholder">
                                <a class="text-primary stretched-link d-block" href="/about/what-we-do/conservation" title="Conservation">
                                    <strong>Conservation</strong>
                                </a>
                            </li>
                            <li class="position-relative">
                                <img class="h5 rounded-circle mb-2 shadow" src="<?php echo get_template_directory_uri(); ?>/images/ccf-research.jpg" alt="Placeholder">
                                <a class="text-primary stretched-link d-block" href="/about/what-we-do/research" title="Research">
                                    <strong>Research</strong> 
                                </a>
                            </li>
                            <li class="position-relative">
                                <img class="h5 rounded-circle mb-2 shadow" src="<?php echo get_template_directory_uri(); ?>/images/ccf-education.jpg" alt="Placeholder">
                                <a class="text-primary stretched-link d-block" href="/about/what-we-do/education" title="Education">
                                    <strong>Education</strong> 
                                </a>
                            </li>
                        </ul>
                      </div>

                    </div>
                    <!-- .narrow -->

                  </div>
                  <!-- .col -->
                </div>
                <!-- .row -->

              </div>
              <!-- .row -->
            </div>
            <!-- .container-fluid -->

        </div>
        <!-- .card-img-overlay -->

      </div>
      <!-- .card -->

    </section>

    <?php get_template_part('template-parts/donate-panel'); ?>

  </main>
  <!-- #content -->

  <?php get_footer(); ?>