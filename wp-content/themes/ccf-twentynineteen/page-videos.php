<?php

/*
Template Name: Videos
*/

get_header();

$grandparent_title = get_the_title(intval(get_post($post->post_parent)->post_parent));
$parent_title = get_the_title($post->post_parent);

?>

<main id="content" role="main">

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

    <section class="banner">

        <div class="card bg-white">

            <div class="gradient-overlay-y-black">

                <?php
                $featured_image_id = get_post_thumbnail_id($post->ID);
                $featured_image = wp_get_attachment_image_src($featured_image_id, 'full', false, '');
                $featured_image_alt = get_post_meta($featured_image_id, '_wp_attachment_image_alt', true);
                ?>

                <?php if ($featured_image): ?>
                <img class="card-img"
                    src="<?php echo $featured_image[0]; ?>"
                    alt="<?php echo $featured_image_alt; ?>">
                <?php else : ?>
                <img class="card-img" src="http://via.placeholder.com/1500x500.jpg" alt="Placeholder">
                <?php endif; ?>

            </div>

            <div class="card-img-overlay d-flex">
                <div class="container-fluid align-self-end opacity-70">
                    <h1 class="text-right text-secondary">
                        <em><?php echo $parent_title; ?></em>
                    </h1>
                </div>
                <!-- .align-self-center -->
            </div>
        </div>

    </section>
    <!-- .banner -->

    <div class="container-fluid">

        <div class="row">

            <div class="col-xl-3 bg-dark">

                <div class="sticky-top py-xl-4">

                    <div class="btn-toggle d-xl-none mx-n2">

                        <button class="btn btn-block btn-lg btn-primary" data-toggle="collapse" data-target="#aside-nav" aria-expanded="false" aria-controls="aside-nav">
                            <span class="title"><?php echo $parent_title; ?></span>
                        </button>
                        
                    </div>
                    
                    <?php 

                    if (is_nav_menu($parent_title)) :

                    starterMenu($parent_title); 

                    endif; // is_nav_menu($parent_title)

                    ?>

                    <?php get_template_part('template-parts/aside-donate'); ?>

                </div>
                <!-- .sticky-top -->

            </div>
            <!-- .col -->

            <div class="col-xl-9 py-6">

                <header class="medium mb-4">
                    <h1 class="display-4 text-center">
                        <?php the_title(); ?>
                    </h1>
                </header>

                <div class="text-block narrow mb-5">
                    <p>
                        <?php the_content(); ?>
                    </p>
                </div>

                <?php $ccf_videos = get_field('ccf_videos');

                $post_objects = $ccf_videos;

                if ($ccf_videos): ?>

                <div class="mx-n2">

                    <div class="row matrix-gutter">

                        <?php

                        if ($post_objects) :
                        foreach ($post_objects as $post) :
                        setup_postdata($post);

                        $video_url = get_field('video_url');
                        $video_id = substr(strrchr($video_url, '/'), 1);
                         
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
                        <!-- .col -->

                        <?php endforeach; endif; wp_reset_postdata(); /* post_objects */?>

                    </div>
                    <!-- .matrix-border -->

                </div>
                <!-- .mx-n2 -->

                <?php endif; /* featured_videos */ ?>

                <?php get_template_part('template-parts/article-footer'); ?>

            </div>
            <!-- .col -->

        </div>
        <!-- .row -->

    </div>

    <?php endwhile; endif; /* have_posts */ ?>

</main>
<!-- #content -->

<?php get_footer(); ?>