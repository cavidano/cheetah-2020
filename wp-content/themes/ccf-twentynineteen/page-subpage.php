<?php

/*
Template Name: Subpage
*/

get_header();

$grandparent_title = get_the_title(intval(get_post($post->post_parent)->post_parent));
$parent_title = get_the_title($post->post_parent);

?>

<main id="content" role="main">

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <div class="container-fluid">

        <div class="row">

            <?php

                if ($parent_title == "Who We Are" || $grandparent_title == "Who We Are"):
                    get_template_part('template-parts/sidebar-who-we-are');
                elseif ($parent_title == "What We Do" || $grandparent_title == "What We Do"):
                    get_template_part('template-parts/sidebar-what-we-do');
                elseif ($parent_title == "Get Involved" || $grandparent_title == "Get Involved"):
                    get_template_part('template-parts/sidebar-get-involved');
                elseif ($parent_title == "Learn" || $grandparent_title == "Learn"):
                    get_template_part('template-parts/sidebar-learn');
                endif;
            
            ?>

            <div class="col-xl-9 overflow-hidden">

                <article class="my-6" id="primary-content">

                    <header class="medium my-3">
                        <h1 class="display-4 text-center">
                            <?php the_title(); ?>
                        </h1>
                    </header>

                    <?php
                    
                    get_template_part('template-parts/flexible-content-article');
                    get_template_part('template-parts/article-footer');
                    get_template_part('template-parts/related-reading');

                    ?>

                </article>
                <!-- #primary-content -->

            </div>
            <!-- .col -->

        </div>
        <!-- .row -->

    </div>

    <?php endwhile; endif; /* have_posts */ ?>

</main>
<!-- #content -->

<?php get_footer();
