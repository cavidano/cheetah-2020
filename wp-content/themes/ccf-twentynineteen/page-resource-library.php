<?php

/*
Template Name: Resource Library
*/

get_header(); 

$parent_title = get_the_title($post->post_parent);

?>

<main id="content" role="main">

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

    <section class="banner">

        <div class="card bg-white">

            <div class="gradient-overlay-y-black">
        
            <?php 
                $featured_image_id = get_post_thumbnail_id($post->ID);
                $featured_image = wp_get_attachment_image_src($featured_image_id,'full', false, '');
                $featured_image_alt = get_post_meta($featured_image_id,'_wp_attachment_image_alt', true);
             ?>
  
            <?php if( $featured_image ): ?>
                <img class="card-img" src="<?php echo $featured_image[0]; ?>" alt="<?php echo $featured_image_alt; ?>">
            <?php else : ?>
                <img class="card-img" src="http://via.placeholder.com/1500x500.jpg" alt="Placeholder">
            <?php endif; ?>

            </div>

            <div class="card-img-overlay d-flex">
                <div class="container-fluid align-self-end opacity-70">
                    <h1 class="text-right text-secondary">
                        <em>Learn</em>
                    </h1>
                </div>
                <!-- .align-self-center -->
            </div>
        </div>

    </section>
    <!-- .banner -->

    <article class="container-fluid">

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

            <div class="col-xl-9 overflow-hidden" id="primary-content">

                <div class="my-5">

                    <header class="medium my-3">
                        <h1 class="display-4 text-center">
                            <?php the_title(); ?>
                        </h1>
                    </header>

                    <div class="text-block narrow mb-4">
                        <p>
                            <?php the_content(); ?>
                        </p>
                    </div>
                        
                    <div class="medium">

                        <div class="accordion-group mx-n2 border-bottom" id="acc-resource-library" role="tablist">

                            <?php

                            $args = array(
                                'meta_key'  => 'order',
                                'orderby'   => 'meta_value',
                                'order'     => 'ASC',
                                'taxonomy'  => 'resource-category'
                            );

                            $categories = get_categories($args);
                            $category_count = 0;
                            
                            foreach( $categories as $category ) :
                                $category_count++;
                                $visibility = '';
                                $expanded = 'false';
                                $description = $category->description;
                                $image = get_field('featured_image', 'term_' . $category->term_id);
                                
                                if ($category_count == 1) :
                                    $visibility = 'show';
                                    $expanded = 'true';
                                endif;
                            ?>

                            <div class="card">

                                <a class="card-header h4 collapse collapsed" id="acc-button-<?php echo $category->slug; ?>" data-toggle="collapse" href="#acc-panel-<?php echo $category->slug; ?>"
                                    role="tab" aria-expanded="<?php echo $expanded; ?>" aria-controls="acc-panel-<?php echo $category->slug; ?>">
                                    <span class="title" role="heading" aria-level="2"><?php echo $category->name; ?></span>
                                </a>

                                    <div class="collapse <?php echo $visibility; ?>" id="acc-panel-<?php echo $category->slug; ?>" role="tabpanel" aria-labelledby="acc-button-<?php echo $category->slug; ?>" data-parent="#acc-resource-library">

                                        <div class="card-body bg-light py-5">

                                            <div class="narrow">

                                                <?php if ($image) : ?>
                                                <div class="mb-4">
                                                    <img class="rounded" src="<?php echo $image['url'] ?>" alt="<?php echo $image['alt'] ?>">
                                                </div>
                                                <!-- .mb-4 -->

                                                <?php endif; ?>
                                                
                                                <?php if ($description) : ?>

                                                <p class="mb-4">
                                                    <?php echo $description; ?>
                                                </p>
                                                
                                                <?php endif; ?>                                            

                                                <ul class="list-group list-group-flush mb-3">

                                                    <?php
                                                    
                                                    $posts = get_posts(
                                                        array(
                                                            'numberposts'   => 5,
                                                            'post_type'     => 'resourcelibrary',
                                                            'tax_query'     => array(
                                                                array(
                                                                    'taxonomy' => 'resource-category',
                                                                    'terms' => $category->term_id
                                                                )
                                                            )
                                                        )
                                                    );

                                                    if ($posts) :
                                                        
                                                        foreach( $posts as $post ) :
                                                            
                                                            setup_postdata($post);
                                                            
                                                            if ( $category->slug == 'lectures-and-presentations' ) :
                                                                $video_url = get_field('video_url');
                                                                $video_id = substr( strrchr( $video_url, '/' ), 1 );
                                                            ?>
                                                            <li class="list-group-item">

                                                                <div class="row align-items-center">
                                                                    <div class="col-md-6 mb-3 mb-md-0">
                                                                        <div class="embed-responsive embed-responsive-16by9">
                                                                            <?php if (strpos($video_url,'vimeo') !== false) : ?>
                                                                                <iframe src="https://player.vimeo.com/video/<?php echo $video_id; ?>" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
                                                                            <?php else : ?>
                                                                                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo $video_id; ?>" frameborder="0" allowTransparency="true" allowfullscreen="true"></iframe>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    </div>
                                                                    <!-- .col -->

                                                                    <div class="col-md-6">
                                                                        <a class="text-body" href="<?php the_permalink(); ?>">
                                                                            <p class="f-sans-serif fs-md mb-0">
                                                                                <?php echo get_the_date(); ?></p>
                                                                            <strong>
                                                                                <?php the_title(); ?>
                                                                            </strong>
                                                                        </a>
                                                                    </div>
                                                                    <!-- .col -->

                                                                </div>
                                                                <!-- .row -->

                                                            </li>

                                                            <?php else : ?>

                                                                <li class="list-group-item">
                                                                    <a class="text-body" href="<?php the_permalink(); ?>">
                                                                        <p class="f-sans-serif fs-md mb-0"><?php echo get_the_date(); ?></p>
                                                                        <strong>
                                                                            <?php the_title(); ?>
                                                                        </strong>
                                                                    </a>
                                                                </li>                              
                                                            
                                                            <?php endif; ?>
                                                        
                                                        <?php endforeach; ?>
                                                    
                                                    <?php endif; ?>
                                                
                                                </ul>

                                                <a class="link text-secondary" href="<?php echo home_url() . '/resource-category/' . $category->slug; ?>" title="See All">
                                                    See All
                                                </a>

                                            </div>
                                            <!-- .narrow -->

                                        </div>
                                        <!-- .card-body -->

                                    </div>
                                    <!-- .collapse -->

                                </div>
                                <!-- .card -->

                            <?php endforeach; ?>

                        </div>
                        <!-- .accordion-group -->
                    
                    </div>
                    <!-- .medium -->

                    <?php get_template_part('template-parts/article-footer'); ?>

                </div>
                <!-- .my-5 -->
                  
            </div>
            <!-- .col -->

        </div>
        <!-- .row -->

    </article>

    <?php endwhile; endif; /* have_posts */ ?>

</main>
<!-- #content -->

<?php get_footer(); ?>