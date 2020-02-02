<?php

get_header();

?>

<?php

$image = get_field('news_header_image', 'option');
$current_category = get_query_var('cat');

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

            <div class="text-white text-shadow text-center">
                <h1 class="display-3 text-white">
                    News
                </h1>
                <?php if (!is_home()) : ?>
                    <h2 class="h5 text-uppercase text-primary"><?php the_archive_title(); ?></h2>
                <?php endif; ?>
            </div>
            <!-- .narrow -->
        
        </div>
        <!-- .container -->

    </div>
    <!-- .banner-with-background -->

    <div class="btn-toggle d-lg-none">
        <button class="btn btn-block btn-lg btn-primary" data-toggle="collapse" data-target="#toggle-target"
            aria-expanded="false" aria-controls="toggle-target">
            <span class="title">Topics</span>
        </button>
    </div>

    <div class="container">

        <div class="row">

            <div class="col-lg-3 mt-5 border-lg-left mt-lg-0 order-lg-last">

               
                <div class="sticky-top">

                    <nav class="collapse d-lg-block px-2 py-lg-4" id="toggle-target" role="navigation">

                        <ul class="extensible-list fs-md">

                            <li><a class="<?php echo($current_category == $category->cat_ID ? 'text-body font-weight-bold' : 'text-muted') ?>" href="<?php  echo get_post_type_archive_link('post'); ?>">All Topics</a></li>
                            
                            <?php

                            $categories = get_categories();

                            foreach ($categories as $category): ?>

                            <?php if($category->slug !== 'ccf-blog'): ?> 

                            <li><a class="<?php echo($current_category == $category->cat_ID ? 'text-body font-weight-bold' : 'text-muted') ?>" href="<?php echo get_category_link($category->cat_ID); ?>"><?php echo $category->name; ?></a></li>
                            
                            <?php endif; ?>
                            
                            <?php endforeach; ?>

                        </ul>
                    
                    </nav>
                    <!-- .bg-light -->

                </div>
                <!-- .bg-light -->

            </div>
            <!-- .col -->

            <div class="col-lg-9 overflow-hidden" id="primary-content">

                <div class="my-5">

                    <?php 

                    if ( have_posts() ) :

                    while ( have_posts() ) : the_post(); ?>

                    <div class="row align-items-center my-3">

                        <div class="col-lg-6">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">

                            <?php if( has_post_thumbnail() ):
                                $featured_image_url = get_the_post_thumbnail_url( get_the_ID(),'full' );
                            ?>

                            <img class="w-100" src="<?php echo $featured_image_url; ?>" alt="<?php the_title(); ?>">

                            <?php else : ?>
                    
                            <img class="w-100" src="https://via.placeholder.com/1000x563" alt="Placeholder">
                    
                            <?php endif; /* featured_image */ ?>

                            </a>

                        </div>
                        <!-- .col-6 -->

                        <div class="col-lg-6">
                            <p class="text-muted f-sans-serif mb-0 fs-md"><?php echo get_the_date(); ?></p>
                            <h5 class="mb-0"><?php the_title(); ?></h5>
                            <a class="link text-secondary stretched-link fs-md" href="<?php the_permalink(); ?>">Read More</a>
                        </div>
                        <!-- .col-6 -->
                    
                    </div>
                    <!-- .row -->

                    <?php endwhile; endif; /* have_posts */?>

                    <div class="pagination justify-content-center">

                        <?php echo custom_pagination(); ?>
                        
                    </div>

                </div>
                <!-- .medium -->

            </div>
            <!-- .col -->
            
        </div>
        <!-- .row -->
    
    </div>
    <!-- .container -->

</main>
<!-- #content -->

<?php get_template_part('template-parts/donate-panel'); ?>

<?php get_footer(); ?>