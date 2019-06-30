<?php

/*
Template Name: Single CCF Author
*/

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

                <div class="col-sm">
                    <div class="btn-toggle">
                        <button class="btn btn-block btn-primary" data-toggle="collapse" data-target="#all-topics"
                            aria-expanded="false" aria-controls="all-topics">
                            <span class="Topics"><?php echo ($current_category_name == 'Press Releases') ? "Years" : "Topics"; ?></span>
                        </button>
                    </div>
                </div>
                <!-- .col -->
                
                <div class="col-sm">
                    <div class="btn-toggle">
                        <button class="btn btn-block btn-primary" data-toggle="collapse" data-target="#all-authors"
                            aria-expanded="false" aria-controls="all-authors">
                            <span class="Authors">Authors</span>
                        </button>
                    </div>
                </div>
                <!-- .col -->

            </div>
            <!-- .row -->

            <div class="row matrix-gutter d-none">

                <div class="col-md">

                    <?php showPrimaryFilters(); ?>

                </div>
                <!-- .col -->

                <div class="col-md">

                    <?php showAuthorFilters(); ?>
                    
                </div>
                <!-- .col -->

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

    <div class="container py-6">

        <h1 class="text-center mb-2"><?php the_title(); ?></h1>

        <?php

        $test = get_the_title();
        the_field('author');

        ?>

            <?php

            $args = array(
              'post_type' => 'post',
              'meta_key'    => 'author',
              'meta_value'  => $test
              // 'tax_query' => array(
              //   array(
              //     'taxonomy' => 'people',
              //     'field'    => 'slug',
              //     'terms'    => 'bob',
              //   ),
              // ),
            );

            // The Query
            $the_query = new WP_Query( $args );

            // The Loop
            if ( $the_query->have_posts() ) {
              echo '<ul>';
              while ( $the_query->have_posts() ) {
                $the_query->the_post();
                echo '<li>' . get_the_title() . '</li>';
              }
              echo '</ul>';
              /* Restore original Post Data */
              wp_reset_postdata();
            } else {
              // no posts found
            }

            ?>

            <?php if ( have_posts() ) : ?>

            <div class="row matrix-border posts">

                <?php while ( have_posts() ) : the_post(); ?>

                <div class="col-lg-4 mb-3">
                    
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