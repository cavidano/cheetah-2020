<?php

get_header();

?>

<?php

$image = get_field('events_header_image', 'option');

if ($image): ?>

<style>
    .banner-with-background.featured-image::before{
        background-image: url(<?php echo $image['url']; ?>);
        opacity : .3;
    }
</style>

<?php endif; ?>

<main id="content" role="main">

    <div class="bg-dark banner-with-background featured-image d-flex flex-column">

        <div class="container my-auto">

            <div class="text-white text-shadow">
                <h1 class="display-3 text-center">
                    Events
                </h1>
            </div>
            <!-- .narrow -->
        
        </div>
        <!-- .container -->

    </div>
    <!-- .banner-with-background -->

    <div class="container">

        <div class="row">

            <div class="col-lg-9 overflow-hidden" id="primary-content">

                <div class="my-5">

                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

                        <?php
                        
                        $featured_image_id = get_post_thumbnail_id($post->ID);
                        $featured_image = wp_get_attachment_image_src($featured_image_id, 'full', false, '');
                        $featured_image_alt = get_post_meta($featured_image_id, '_wp_attachment_image_alt', true);

                        ?>

                        <div class="row align-items-center my-3">

                            <div class="col-lg-6">
                                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">

                                <?php if ($featured_image) : ?>
                                    <img class="w-100" src="<?php echo $featured_image[0]; ?>" alt="<?php echo $featured_image_alt; ?>">
                                <?php else : ?>
                                    <img class="w-100" src="https://via.placeholder.com/1000x563" alt="Placeholder">
                                <?php endif; ?>
                                
                                </a>
                            </div>
                            <!-- .col-6 -->

                            <div class="col-lg-6">

                                <p class="has-icon f-sans-serif fs-md mb-1">
                                    <span class="fas fa-map-marker-alt"></span>    
                                    <span class="title"><?php the_field('location') ?></span>    
                                </p>
                                
                                <h2 class="h5"><?php the_title(); ?></h2>
                                
                                <p class="f-sans-serif fs-md mb-0">

                                    <strong class="d-block"><?php the_field('start_date') ?></strong>

                                    <?php if ($time) : ?>
                                    <span class="text-muted"><?php echo $time; ?></span>
                                    <?php endif; ?>
                                </p>
                                
                                <a class="link text-secondary stretched-link fs-md" href="<?php the_permalink(); ?>">Event Details</a>

                            </div>
                            <!-- .col-6 -->
                        
                        </div>
                        <!-- .row -->

                    <?php endwhile; endif; ?>

                    <div class="pagination justify-content-center">

                        <?php echo custom_pagination(); ?>
                        
                    </div>

                </div>
                <!-- .medium -->

            </div>
            <!-- .col -->
            
            <div class="col-lg-3 mt-5 border-lg-left mt-lg-0">

                <div class="px-2 py-4">

                    <p>
                        Check this page often for updates and new events added to our tours.
                    </p>

                </div>
                <!-- .bg-light -->

            </div>
            <!-- .col -->
            
        </div>
        <!-- .row -->

    </div>
    <!-- .container-fluid -->

  <?php get_template_part('template-parts/donate-panel'); ?>

</main>
<!-- #content -->

<?php get_footer(); ?>
