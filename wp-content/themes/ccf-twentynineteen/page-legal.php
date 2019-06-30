<?php

/*
Template Name: Legal
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
        <!-- .container-fluid -->

    </div>
    <!-- .container -->

    <div class="container-fluid overflow-auto">

        <div class="my-5">

            <div class="narrow my-4">
                <?php get_template_part('template-parts/flexible-content-article'); ?>
            </div>

            <?php if (is_page('newsletter')) : ?>

            <div class="narrow my-4" id="bbox-root"></div>
            
            <?php endif; ?>

        </div>
        <!-- .my-5 -->

    </div>
    <!-- .container-fluid -->

    <?php endwhile; endif; /* have_posts */ ?>

</main>
<!-- #content -->

<?php if (is_page('newsletter')) : ?>
    <script type="text/javascript">
           window.bboxInit = function () {
               bbox.showForm('97d435e6-40ec-41a7-b8e5-2a4eacf55d9c');
           };
           (function () {
               var e = document.createElement('script'); e.async = true;
               e.src = 'https://bbox.blackbaudhosting.com/webforms/bbox-min.js';
               document.getElementsByTagName('head')[0].appendChild(e);
           } ());
    </script>
<?php endif; ?>

<?php get_footer(); ?>