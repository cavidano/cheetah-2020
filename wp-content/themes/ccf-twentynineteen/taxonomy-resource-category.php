<?php 

  get_header();
  $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); 

  $parent_title = 'Learn';

?>

<main id="content" role="main">

    <?php
        $args = array(
        'name'        => 'resource-library',
        'post_type'   => 'page',
        'post_status' => 'publish',
        'numberposts' => 1
        );

        $resource_library = get_posts($args);

        if ($resource_library) :

            $featured_image_id = get_post_thumbnail_id($resource_library[0]->ID);
            $featured_image = wp_get_attachment_image_src($featured_image_id, 'full', false, '');
            $featured_image_alt = get_post_meta($featured_image_id, '_wp_attachment_image_alt', true);

        endif;

        $image = get_field('featured_image', 'term_' . $term->term_id);

    ?>

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

            <div class="col-xl-9 py-6">

                <header class="medium">
                    <h1 class="display-4 text-center"><?php echo $term->name; ?></h1>
                </header>

                <div class="text-block narrow my-5">
                    <?php if ($image) : ?>
                        <img class="mb-5" src="<?php echo $image['url'] ?>" alt="<?php echo $image['alt'] ?>">
                    <?php endif; ?>
                    <p>
                        <?php echo $term->description; ?>
                    </p>
                </div>

                <div class="narrow my-5">

                    <?php if ( have_posts() ) : ?>

                        <ul class="list-group list-group-flush mb-3">

                            <?php while ( have_posts() ) : the_post();
                            
                            $categories = get_the_category();
                            $category_first = $categories[0]->cat_name;
                            
                            ?>

                                <li class="list-group-item">
                                    <a class="text-body" href="<?php the_permalink(); ?>">
                                        <p class="f-sans-serif fs-md mb-0"><?php echo get_the_date(); ?></p>
                                        <strong class="h5">
                                            <?php the_title(); ?>
                                        </strong>

                                        <?php if (get_field('authors')) : ?>                                            
                                            <p class="f-sans-serif text-muted fs-md">
                                                By <?php the_field('authors'); ?>
                                            </p>
                                        <?php endif; ?>                                                                                
                                    </a>
                                </li>

                            <?php endwhile; ?>

                        </ul>

                    <?php endif; ?>

                </div>
                <!-- .narrow -->

                <div class="pagination justify-content-center">

                    <?php echo custom_pagination(); ?>
                    
                </div>
                <!-- .pagination -->
                  
            </div>
            <!-- .col -->

        </div>
        <!-- .row -->

    </article>

</main>
<!-- #content -->

<?php get_footer(); ?>