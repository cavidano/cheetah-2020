<?php

/*
Template Name: Videos
*/

get_header();

?>

<?php

$image = get_field('videos_header_image', 'option');

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
                    Videos
                </h1>
            </div>
            <!-- .narrow -->
        
        </div>
        <!-- .container -->

    </div>
    <!-- .banner-with-background -->

    <div class="container py-4">

        <?php

        $args = array(
            'post_type' => 'videos',
            'order' => 'ASC'
        );

        $videos = new WP_Query( $args );

        if ( $videos->have_posts() ) : ?>

        <div class="row matrix-gutter">

            <?php while ( $videos->have_posts() ) :

            $videos->the_post();
            $video_url = get_field('video_url');
            $video_id = substr( strrchr( $video_url, '/' ), 1 );

            ?>

            <div class="col-lg-6">
                <div class="embed-responsive embed-responsive-16by9">
                    <?php if (strpos($video_url, 'vimeo') !== false) : ?>
                        <iframe src="https://player.vimeo.com/video/<?php echo $video_id; ?>" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
                    <?php else : ?>
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo $video_id; ?>" frameborder="0" allowTransparency="true" allowfullscreen="true"></iframe>
                    <?php endif; ?>
                </div>
            </div>
            <!-- .col-6 -->
                  
            <?php endwhile; /* videos */?>

        </div>
        <!-- .row -->

        <?php endif; /* videos */?>

        <div class="pagination justify-content-center mt-3">

            <?php echo custom_pagination(); ?>
            
        </div>

    </div>
    <!-- .container-fluid -->

  <?php get_template_part('template-parts/donate-panel'); ?>

</main>
<!-- #content -->

<?php get_footer(); ?>
