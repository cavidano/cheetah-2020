<?php if (have_rows('donate_cta_settings', 'options')):
  
  while (have_rows('donate_cta_settings', 'options')): the_row();
          
    $headline = get_sub_field('headline');
    $paragraph = get_sub_field('paragraph');

    $link = get_sub_field('link');
    $image = get_sub_field('image');

    ?>

  <section class="featured-panel responsive-lg">

    <div class="card bg-dark">

      <?php if ($image) : ?>

      <img class="card-img opacity-30 show-on-mobile" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">

      <?php endif; ?>

      <div class="card-img-overlay d-flex px-0">

        <div class="container-fluid align-self-center">

          <div class="narrow py-2 text-white text-center">

            <?php if ($headline) : ?>

            <h2 class="text-shadow">
              <?php echo $headline; ?>
            </h2>

            <?php endif; ?>

            <?php if ($paragraph) : ?>

            <div class="text-shadow mb-2">
              <?php echo $paragraph; ?>
            </div>

            <?php endif; ?>


            <?php if ($link) : ?>

            <div class="row justify-content-center">

              <div class="col-md-6">
                <a class="btn btn-lg btn-block btn-primary" href="<?php echo $link['url']; ?>"><?php echo $link['title']; ?></a>
              </div>
              <!-- .col -->

            </div>
            <!-- .matrix-border -->

            <?php endif; ?>

          </div>

        </div>
        <!-- .container -->
      </div>
    </div>
  
  </section>
  
<?php endwhile; endif; /* donate_cta_settings */ ?>