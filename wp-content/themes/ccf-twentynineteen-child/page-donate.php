<?php

/*
Template Name: Donate
*/

get_header();

?>

<main id="content" role="main">

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <div class="bg-info cheetah-spots">

        <div class="container py-4">

            <div class="narrow text-white">

                <h1 class="display-4 text-primary text-shadow"><?php the_title(); ?></h1>

            </div>
            <!-- .narrow -->

        </div>
        <!-- .container -->

    </div>
    <!-- .bg-info -->

    <div class="overflow-hidden">

        <div class="container-fluid wide my-5">
            
            <?php get_template_part('template-parts/flexible-content-article'); ?> 
        
        </div>
        <!-- .container -->
    
    </div>
    <!-- .overflow-hidden -->
    
    <?php endwhile; endif; /* have_posts */ ?>
   
</main>
<!-- #content -->

<?php get_footer(); ?>
