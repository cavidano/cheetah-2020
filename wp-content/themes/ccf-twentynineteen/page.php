<?php

get_header();

$grandparent_title = get_the_title(intval(get_post($post->post_parent)->post_parent));
$parent_title = get_the_title($post->post_parent);

?>

<main id="content" role="main">

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <section class="banner">

        <div class="card bg-white">

            <div class="gradient-overlay-y-black">

                <?php
                $featured_image_id = get_post_thumbnail_id($post->ID);
                $featured_image = wp_get_attachment_image_src($featured_image_id, 'full', false, '');
                $featured_image_alt = get_post_meta($featured_image_id, '_wp_attachment_image_alt', true);
                ?>

                <?php if ($featured_image): ?>
                <img class="card-img"
                    src="<?php echo $featured_image[0]; ?>"
                    alt="<?php echo $featured_image_alt; ?>">
                <?php else : ?>
                <img class="card-img" src="http://via.placeholder.com/1500x500.jpg" alt="Placeholder">
                <?php endif; ?>

            </div>

            <div class="card-img-overlay d-flex">
                <div class="container-fluid align-self-end opacity-70">
                    <h1 class="text-right text-secondary">
                        <em><?php echo $parent_title; ?></em>
                    </h1>
                </div>
                <!-- .align-self-center -->
            </div>
        </div>

    </section>
    <!-- .banner -->

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

            <div class="col-xl-9 overflow-hidden" id="primary-content">

                <div class="my-5">

                    <header class="medium my-3">
                        <h1 class="display-4 text-center">
                            <?php the_title(); ?>
                        </h1>
                    </header>

                    <?php
                    
                    get_template_part('template-parts/flexible-content-article');

                    if (is_page('ccf-global')):

                    get_template_part('template-parts/ccf-global');
                    
                    endif;

                    if (is_page('dr-laurie-marker')):
                    
                    get_template_part('template-parts/dr-laurie-awards-and-activities');

                    endif;

                    if (is_page('staff')):
                    
                    get_template_part('template-parts/staff');

                    endif;

                    if (is_page('governance')):
                    
                    get_template_part('template-parts/governance');

                    endif;

                    if (is_page('corporate-giving')):
                    
                    get_template_part('template-parts/corporate-giving');

                    endif;

                    $partnership_groups = get_field('partnership_groups');
                    
                    $post_objects = $partnership_groups;

                    if ($post_objects):
                    
                    foreach($post_objects as $post) :
                    setup_postdata( $post ); 
                    $description = get_field('description');

                    ?>

                    <div class="narrow mb-5">

                        <h3>
                            <?php the_title(); ?>
                        </h3>

                        <p>
                            <?php echo $description; ?>
                        </p>

                        <?php if (have_rows('partners')): ?>

                        <div class="my-3">

                            <?php while (have_rows('partners')): the_row();

                            $name = get_sub_field('name');
                            $link = get_sub_field('link');
                            
                            ?>

                            <dl class="row justify-content-between border-top py-2 mb-0 fs-md">

                                <dt class="col-md">
                                    <?php echo $name; ?>
                                </dt>

                                <dd class="col-md-auto">
                                    <a href="<?php echo $link['url']; ?>" <?php if($link['target']) : ?>target="<?php echo $link['target'] ?>"<?php endif; ?>><?php echo $link['title']; ?></a>
                                </dd>

                            </dl>

                            <?php endwhile; ?>

                        </div>
                        <!-- .my-3 -->

                        <?php endif; ?>

                    </div>
                    <!-- .narrow -->

                    <?php endforeach; endif; wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>

                    <?php /* endif; */

                    get_template_part('template-parts/article-footer');
                    get_template_part('template-parts/related-reading');

                    ?>

                </div>
                <!-- .my-5 -->

            </div>
            <!-- .col -->

        </div>
        <!-- .row -->

    </article>
    <!-- .container-fluid -->

    <?php endwhile; endif; /* have_posts */ ?>

</main>
<!-- #content -->

<?php get_footer();
