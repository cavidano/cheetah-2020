<?php

get_header(); ?>

<main id="content" role="main">

    <div class="bg-dark banner-with-background banner-news d-flex">

        <div class="container-fluid my-auto">

            <div class="narrow text-white text-center text-shadow my-3">
            
                <h1 class="display-3 text-white mb-2">
                    Cheetah News
                </h1>

                <ul class="extensible-list horizontal justify-content-center responsive-md fs-lg" id="news-menu">
                    <?php listParentCategoriesMenu(); ?>
                </ul>
                
            </div>
            <!-- .narrow -->
        </div>
        <!-- .container -->

    </div>
    <!-- .banner-with-background -->

    <div class="container-fluid posts-filter bg-info cheetah-spots py-3">

        <div class="narrow">

            <div class="row matrix-gutter justify-content-center">

                <?php
                
                    $current_category = get_category(get_query_var('cat'));
                    $current_category_name = $current_category->name;

                    if ( $current_category_name !== 'Cheetah Strides' && $current_category_name !== 'Press Releases'){
                         $in_blog = true;

                    }

                ?>

                <div class="col-sm-6">
                    <div class="btn-toggle">
                        <button class="btn btn-block btn-primary" data-toggle="collapse" data-target="#all-topics"
                            aria-expanded="false" aria-controls="all-topics">
                            <span class="Topics"><?php echo ($current_category_name == 'Press Releases' || $current_category_name == 'Cheetah Strides') ? "Years" : "Topics"; ?></span>
                        </button>
                    </div>
                </div>
                <!-- .col -->

                <?php if ($in_blog) : ?>

                    <div class="col-sm-6">
                        <div class="btn-toggle">
                            <button class="btn btn-block btn-primary" data-toggle="collapse" data-target="#all-authors"
                                aria-expanded="false" aria-controls="all-authors">
                                <span class="Authors">Authors</span>
                            </button>
                        </div>
                    </div>
                    <!-- .col -->

                <?php endif; ?>

            </div>
            <!-- .row -->

        </div>
        <!-- .narrow -->

    </div>
    <!-- .posts-filter -->

    <div class="container-fluid collapse bg-light" id="all-topics">

        <nav class="narrow py-3" role="navigation">

            <?php showPrimaryFilters(); ?>

        </nav>

    </div>
    <!-- .container-fluid -->

    <div class="container-fluid collapse bg-light" id="all-authors">

        <nav class="narrow py-3" role="navigation">

            <?php showAuthorFilters(); ?>

        </nav>

    </div>
    <!-- .container-fluid -->

    <div class="container overflow-hidden">

        <div class="my-5">

            <?php if ($current_category_name != 'CCF Blog' && $current_category_name != 'Press Releases' && $current_category_name != 'Cheetah Strides') : ?>

            <h1 class="text-center font-weight-light my-2"><?php echo $current_category_name; ?></h1>
            
            <?php endif; ?>

            <?php if ( have_posts() ) : ?>

            <div class="row matrix-gutter justify-content-center posts my-2">

                <?php while ( have_posts() ) : the_post(); ?>

                    <?php if ( $current_category_name == 'Press Releases' ): ?>

                    <div class="col-lg-4 mb-3">

                        <div class="card border h-100">
                            <div class="card-body">
                                <p class="fs-md text-muted"><?php echo get_the_date(); ?></h5>
                                <p class="card-text h5"><?php the_title(); ?></p>
                            </div>
                            <div class="card-footer fs-md pt-0">
                                <a class="link text-secondary stretched-link" href="<?php the_permalink(); ?>">Read More</a>
                            </div>
                        </div>
                    
                    </div>
                    <!-- .col -->

                    <?php else : ?>                
                
                    <div class="col-lg-4 mb-3">
                        
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

                <?php endif; ?>

                <?php endwhile; /* have_posts */ ?>

            </div>
            <!-- .posts -->

        <?php endif; /* have_posts */ ?>

        <div class="pagination justify-content-center">

            <?php echo custom_pagination(); ?>
            
        </div>
        
        </div>
        <!-- .my-5 -->

    </div>
    <!-- .container -->

</main>
<!-- #content -->

<?php get_footer(); ?>