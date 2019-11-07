<?php 

get_header(); 

$start_date = new DateTime(get_field('start_date_time'));
$end_date = new DateTime(get_field('end_date_time'));

$featured_image_id = get_post_thumbnail_id($post->ID);
$featured_image = wp_get_attachment_image_src($featured_image_id,'full', false, '');
$featured_image_alt = get_post_meta($featured_image_id,'_wp_attachment_image_alt', true);
$featured_image_post = get_post($featured_image_id);
$featured_image_caption = $featured_image_post->post_excerpt;

?>

<main id="content" role="main">

    <div class="container-fluid bg-info cheetah-spots py-3">

      <div class="narrow">

        <ul class="extensible-list horizontal fs-md text-white text-shadow">
          <li>
            <a class="text-white" href="/get-involved/ccf-events">
              Events
            </a>
          </li>
          <li><span class="fa fa-caret-right"></span></li>
          <li class="text-primary font-weight-bold">
            <?php echo $start_date->format("F Y"); ?>
          </li>
        </ul>

      </div>
      <!-- .narrow -->

    </div>
    <!-- .container-fluid -->

    <?php if (have_posts()) : while ( have_posts() ) : the_post(); ?>

    <article class="container-fluid blog py-6" id="primary-content">

        <header class="narrow mb-5">

            <h1 class="display-4 mb-3"><?php the_title(); ?></h1>

            <div class="details">

              <?php 

              // get raw date
              
              $start_date = get_field('start_date', false, false);
              $end_date = get_field('end_date', false, false);
              $start_time = get_field('start_time');
              $end_time = get_field('end_time');

              // make date object

              $start_date = new DateTime($start_date);
              
              if ($end_date) {
                $end_date = new DateTime($end_date);
              } else {
                $end_date = null;
              }

              ?>

              <p class="f-sans-serif mb-0">

                  <strong>
                  
                    <?php 
                    
                    if (($start_date) && ($end_date == null)) : 
                    
                        echo $start_date->format('M j, Y'); 

                    else : 

                        echo $start_date->format('M j') . ' - ' . ($start_date->format('M') != $end_date->format('M') ? $end_date->format('M j, Y') : $end_date->format('j, Y')); 
  
                    endif;
                    
                    ?>

                  </strong>

              </p>

              <p class="f-sans-serif fs-md">

                <?php 
                
                  echo $start_time;

                  if ($end_time) : 

                  echo ' - ' . $end_time; 
                  
                  endif;
                  
                ?> 
              
              </p>

              <ul class="list-unstyled f-sans-serif fs-md">

                <li class="mb-0 side-by-side">
                  <span style="width:80px;"><strong>Location:</strong></span>
                  <span><?php the_field('location'); ?></span>
                  </li>
                
                <li class="side-by-side">
                  <span style="width:80px;"><strong>Venue:</strong></span>
                  <span>
                    <?php the_field('venue'); if (get_field('google_map_link')) : ?><br>
                    <a class="fs-sm" href="<?php the_field('google_map_link'); ?>" target="_blank">Google Maps</a>
                  <?php endif; ?>
                  </span>
                </li>

              </ul>
            
            </div>
            <!-- details -->

        </header>

        <?php if ( get_field('hide_feature_on_post') === false ): ?>

        <div class="medium mb-5">

            <figure class="figure my-0">

                <?php if ($featured_image) : ?>
                    <img class="figure-img" src="<?php echo $featured_image[0]; ?>" alt="<?php echo $featured_image_alt; ?>">
                    <?php if ($featured_image_caption): ?>
                    <figcaption class="figure-caption"><?php echo $featured_image_caption; ?></figcaption>
                    <?php endif; ?>
                <?php else : ?>
                    <img class="figure-img" src="https://via.placeholder.com/1000x563" alt="Placeholder">
                <?php endif; ?>

            </figure>

        </div>

        <?php endif; ?>

        <?php get_template_part('template-parts/flexible-content-article'); ?>

        <?php get_template_part('template-parts/article-footer'); ?>

    </article>
    <!-- #primary-content -->

    <?php endwhile; endif; /* have_posts */ ?>

    <?php get_template_part('template-parts/donate-panel'); ?>

</main>
<!-- #content -->

<?php get_footer(); ?>