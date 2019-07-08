<?php if (have_rows('donate_panel', 'options')):

  while (have_rows('donate_panel', 'options')): the_row();

  $headline = get_sub_field('headline');
  $link = get_sub_field('link');

  $image_full = get_sub_field('image_full');

  ?>

  <section class="featured-panel responsive-lg">

    <div class="card bg-dark">

      <?php if ($image_full): ?>
          <img class="card-img opacity-20 show-on-mobile" src="<?php echo $image_full['url']; ?>" alt="<?php echo $image_full['alt']; ?>">
      <?php else : ?>
          <img class="card-img opacity-20 show-on-mobile" src="<?php echo get_template_directory_uri(); ?>/images/donate.jpg" alt="Placeholder">
      <?php endif; ?>

      <div class="card-img-overlay d-flex px-0">

        <div class="container-fluid align-self-center">
        
          <div class="narrow py-3 text-white text-center">

            <h2 class="h1 text-shadow mb-2">
                <?php echo $headline; ?>
                <a class="text-primary" href="<?php echo $link['url']; ?>" <?php if($link['target']) : ?>target="<?php echo $link['target'] ?>"<?php endif; ?>><?php echo $link['title']; ?></a>
            </h2>

            <div class="row matrix-border">

              <div class="col-md-6">
                <a class="btn btn-lg btn-block btn-primary" href="<?php echo home_url(); ?>/donate" title="Donate">Donate</a>
              </div>
              <!-- .col -->

              <div class="col-md-6">
                <a class="btn btn-lg btn-block btn-primary" href="<?php echo home_url(); ?>/donate/sponsor/" title="Sponsor">Sponsor</a>
              </div>
              <!-- .col -->

            </div>
            <!-- .matrix-border -->

        </div>
        <!-- .narrow -->

        </div>
        <!-- .container -->

      </div>
      <!-- .card-img-overlay -->

    </div>
    <!-- .card -->

  </section>

<?php endwhile; endif; /* donate_panel */ ?>