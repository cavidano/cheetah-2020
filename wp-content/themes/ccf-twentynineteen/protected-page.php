<?php

/*
Template Name: Protected Page
*/

get_header();

$grandparent_title = get_the_title(intval(get_post($post->post_parent)->post_parent));
$parent_title = get_the_title($post->post_parent);

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
        <!-- .container-fluid -->

    </div>
    <!-- .container -->

    <div class="container-fluid overflow-auto">

        <div class="my-5">

            <div class="narrow my-4">
                <?php 

                if (post_password_required($post)) :

                    echo get_the_password_form();

                else :

                    // Protected content goes here

                    get_template_part('template-parts/flexible-content-article');

                endif;

                get_template_part('template-parts/article-footer');
                get_template_part('template-parts/related-reading');

                ?>
            </div>

        </div>
        <!-- .my-5 -->

    </div>
    <!-- .container-fluid -->

    <?php endwhile; endif; /* have_posts */ ?>

</main>
<!-- #content -->

<?php get_footer();
