<?php

get_header(); ?>

<main id="content">

    <div class="bg-dark banner-with-background banner-news">

        <div class="container-fluid">
            <div class="narrow text-white text-center text-shadow">
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

            <div class="row matrix-gutter">

                <?php
                    $current_category = get_category(get_query_var('cat'));
                    $current_category_name = $current_category->name;
                ?>

                <div class="col-sm-6 <?php if ( $current_category_name !== 'CCF Blog' ) : ?>offset-sm-3<?php endif; ?>">
                    <div class="btn-toggle">
                        <button class="btn btn-block btn-primary" data-toggle="collapse" data-target="#all-topics"
                            aria-expanded="false" aria-controls="all-topics">
                            <span class="Topics"><?php echo ($current_category_name == 'Press Releases' || $current_category_name == 'Cheetah Strides') ? "Years" : "Topics"; ?></span>
                        </button>
                    </div>
                </div>
                <!-- .col -->

                <?php if ( $current_category_name === 'CCF Blog' ) : ?>

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

    <?php 

    $page_heading = '';

    if (get_query_var('taxonomy') == 'news-author') :

    $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
    $page_heading = $term->name;
    
    elseif (get_query_var('category_name') && get_query_var('category_name') != 'ccf-blog'):
    
        $page_heading = get_category_by_slug(get_query_var('category_name'))->cat_name;

        if ($page_heading == 'Press Releases') :

          $press_releases = true;

        endif;
        
    endif;
    
    ?>

    <div class="container py-6">

        <?php if ($page_heading) : ?>

        <h1 class="text-center mb-3 font-weight-light "><?php echo $page_heading; ?></h1>
        
        <?php endif; ?>

            <?php if ( have_posts() ) : ?>

            <div class="row matrix-gutter posts">

                <?php while ( have_posts() ) : the_post(); ?>

                    <?php if ( $press_releases ): ?>

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
                
                    <div class="col-lg-4 mb-3 <?php echo ($press_releases ? 'border border-danger' : '')?>">
                        
                        <a class="featured-article" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                        
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

                            <p class="h5"><?php the_title(); ?></p>

                        </a>

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

</main>
<!-- #content -->

<?php get_footer(); ?>