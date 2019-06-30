<?php

get_header(); ?>

<main id="content" role="main">

    <div class="bg-info cheetah-spots">

        <div class="container py-4">

            <div class="narrow">
                <h1 class="display-4 text-white text-center text-shadow">
                    <?php printf( __( 'Search Results for: %s', 'shape' ), '<span class="d-block text-primary"><em>' . get_search_query() . '</em></span>' ); ?>
                </h1>
            </div>

        </div>
        <!-- .container-fluid -->

    </div>
    <!-- .container -->

  <div class="container-fluid overflow-auto" id="primary-content">

    <div class="narrow my-5">

        <?php if (have_posts()) : ?>

        <ul class="list-group list-group-flush mb-3">

            <?php while (have_posts()) : the_post(); ?>

                <li class="list-group-item">
                    <?php 

                    $post_type = get_post_type();
                    
                    if ($post_type == 'post') :
                        $section = 'News';
                    elseif ($post_type == 'events') :
                        $section = 'Events';
                    elseif ($post_type == 'resourcelibrary') :
                        $section = 'Resource Library';
                    elseif ($post_type == 'videos') :
                        $section = 'Videos';
                    elseif ($post_type == 'partnerships') :
                        $section = 'Partnerships';
                    elseif ($post_type == 'page') :
                        $section = get_the_title($post->post_parent);
                    endif; 

                    ?>
                    <a class="text-body" href="<?php the_permalink(); ?>">
                        <p class="f-sans-serif fs-md mb-0"><?php echo $section . ' | ' . get_the_date(); ?></p>
                        <strong class="h5">
                            <?php the_title(); ?>
                        </strong>                                                                 
                    </a>
                </li>

            <?php endwhile; ?>

        </ul>

        <?php else : ?>

        <p>No results</p>

        <?php endif; ?>

        <div class="pagination justify-content-center my-4">

            <?php echo custom_pagination(); ?>
            
        </div>
        <!-- .pagination -->

      </div>
      <!-- .my-5 -->

    </div>
    <!-- .container-fluid -->

    <?php get_template_part('template-parts/donate-panel'); ?>

</main>
<!-- #content -->

<?php get_footer(); ?>