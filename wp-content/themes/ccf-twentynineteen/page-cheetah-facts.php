<?php

/*
Template Name: Cheetah Facts
*/

get_header();

$grandparent_title = get_the_title(intval(get_post($post->post_parent)->post_parent));
$parent_title = get_the_title($post->post_parent);

?>

<main class="for-kids" id="content">

    <section class="bg-info cheetah-spots">

        <div class="container-fluid overflow-hidden">

            <div class="narrow text-center text-white my-5">

                <img class="mb-3" src="<?php echo get_template_directory_uri(); ?>/images/ccf-kids-logo-large.svg" alt="Placeholder">

                <div class="text-shadow">
                  <?php the_content(); ?>
                </div>

            </div>
            <!-- .narrow -->

        </div>
        <!-- .container-fluid -->

        <div class="container" id="kids-tabs">

            <nav class="nav nav-pills" role="tablist">

                <a class="nav-item nav-link active" href="/kids/cheetah-facts" aria-selected="true" role="tab">
                    Cheetah Facts
                </a>

                <a class="nav-item nav-link" href="/kids/ccf-kids" aria-selected="false" role="tab">
                    CCF Kids
                </a>
            </nav>

        </div>

    </section>

    <div class="wide overflow-hidden">

        <div class="my-6" id="primary-content">

            <?php if( have_rows('cheetah_facts_content') ): while ( have_rows('cheetah_facts_content') ) : the_row(); ?>

            <?php if( get_row_layout() == 'video_with_two_paragraphs_block' ):

            $video = get_sub_field('video');
            $post_object = $video;

            $paragraph_one = get_sub_field('paragraph_one');
            $paragraph_two = get_sub_field('paragraph_two');

            ?>
            
            <div class="container-fluid my-5">

                <div class="medium">

                    <div class="rounded-lg overflow-hidden mb-4">

                        <?php

                        if ($post_object) :

                        $post = $post_object;
                        setup_postdata($post);

                        $video_url = get_field('video_url');
                        $video_id = substr(strrchr($video_url, '/'), 1);
                        
                        ?>
                        
                        <div class="embed-responsive embed-responsive-16by9">
                            <?php if (strpos($video_url, 'vimeo') !== false) : ?>
                                <iframe src="https://player.vimeo.com/video/<?php echo $video_id; ?>" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
                            <?php else : ?>
                                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo $video_id; ?>" frameborder="0" allowTransparency="true" allowfullscreen="true"></iframe>
                            <?php endif; ?>
                        </div>

                        <?php endif; wp_reset_postdata(); /* post_objects */?>

                    </div>
                    <!-- .rounded-lg -->

                    <div class="row matrix-gutter">

                        <?php if ($paragraph_one): ?>

                        <div class="col-md-6">
                            <?php echo $paragraph_one; ?>      
                        </div>
                        <!-- .col -->
                        
                        <?php endif; ?>
                        
                        <?php if ($paragraph_two): ?>

                        <div class="col-md-6">
                            <?php echo $paragraph_two; ?>
                        </div>
                        <!-- .col -->

                        <?php endif; ?>
                                            
                    </div>
                    <!-- .row -->
                
                </div>
                <!-- .medium -->

            </div>
            <!-- .container -->

            <?php elseif( get_row_layout() == 'illustration_with_image_and_text_block' ):

            $illustration = get_sub_field('illustration');
            $image = get_sub_field('image');
            $headline = get_sub_field('headline');
            
            $text_type = get_sub_field('text_type');

            $paragraph_one = get_sub_field('paragraph_one');
            $paragraph_two = get_sub_field('paragraph_two');

            ?>

            <div class="container my-5">

                <?php if ($illustration): ?>
                    <img class="w-100" src="<?php echo $illustration['url']; ?>" alt="<?php echo $illustration['alt']; ?>">
                <?php else : ?>
                    <div class="gradient-overlay-y-black">
                        <img class="w-100" src="https://via.placeholder.com/1500x1000" alt="Placeholder">
                    </div>
                <?php endif; ?>

                <div class="medium text-center mt-n3 mt-lg-n6">

                    <?php if ($image): ?>
                        <img class="rounded-circle mb-3" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>"  style="width:200px;">
                    <?php else : ?>
                        <img class="rounded-circle mb-3" src="https://via.placeholder.com/300x300" alt="Placeholder" style="width:200px;">
                    <?php endif; ?>
                    
                    <?php if ($headline): ?>
                        <h2 class="card-title f-cheetah-tracks display-3 mb-2 text-tertiary"><?php echo $headline; ?></h2>
                    <?php endif; ?>

                    <?php if ($text_type == 'One Paragraph'): ?>

                        <div class="narrow">
                            <?php echo $paragraph_one; ?>
                        </div>
                        <!-- .narrow -->
                    
                    <?php else: ?>

                        <div class="row matrix-gutter text-left">

                            <div class="col-md">
                                <?php echo $paragraph_one; ?>
                            </div>
                            <!-- .col -->

                            <div class="col-md">
                                <?php echo $paragraph_two; ?>
                            </div>
                            <!-- .col -->

                        </div>
                        <!-- .row -->

                    <?php endif; ?>

                </div>
                <!-- .narrow -->

            </div>
            <!-- .container -->

            <?php elseif( get_row_layout() == 'video_with_image_and_text_block' ):

            $image = get_sub_field('image');

            $video = get_sub_field('video');
            $post_object = $video;

            $headline = get_sub_field('headline');
            $paragraph = get_sub_field('paragraph');

            ?>

            <div class="featured-panel responsive-lg my-5">

                <div class="card bg-light">

                    <?php if ($image): ?>
                        <div class="gradient-overlay-y-white d-none d-lg-block">
                            <img class="card-img" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
                        </div>
                    <?php else : ?>
                        <div class="gradient-overlay-y-white d-none d-lg-block">
                            <img class="card-img" src="https://via.placeholder.com/1500x1000" alt="Placeholder">
                        </div>
                    <?php endif; ?>

                    <div class="card-img-overlay d-flex">

                        <div class="container align-self-center my-4">

                            <div class="narrow rounded-lg overflow-hidden mb-4">

                                <?php

                                if ($post_object) :

                                $post = $post_object;
                                setup_postdata($post);

                                $video_url = get_field('video_url');
                                $video_id = substr(strrchr($video_url, '/'), 1);
                                
                                ?>
                                
                                <div class="embed-responsive embed-responsive-16by9">
                                    <?php if (strpos($video_url, 'vimeo') !== false) : ?>
                                        <iframe src="https://player.vimeo.com/video/<?php echo $video_id; ?>" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
                                    <?php else : ?>
                                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo $video_id; ?>" frameborder="0" allowTransparency="true" allowfullscreen="true"></iframe>
                                    <?php endif; ?>
                                </div>

                                <?php endif; wp_reset_postdata(); /* post_objects */ ?>

                            </div>

                            <div class="narrow text-center">
                                
                                <?php if ($headline): ?>
                                    <h2 class="card-title display-3 mb-2 f-cheetah-tracks text-tertiary"><?php echo $headline; ?></h2>
                                <?php endif; ?>

                                <?php if ($paragraph): ?>
                                    <?php echo $paragraph; ?>
                                <?php endif; ?>

                            </div>
                                
                        </div>
                        <!-- .container -->

                    </div>

                </div>
                <!-- .card -->

            </div>
            <!-- .featured-panel -->

            <?php elseif( get_row_layout() == 'fact_repeater' ): ?>

            <?php if( have_rows('facts') ): ?>

            <div class="container my-5">

                <?php while ( have_rows('facts') ) : the_row();

                $image = get_sub_field('image');
                $headline = get_sub_field('headline');
                $paragraph = get_sub_field('paragraph');

                ?>

                <div class="row align-items-center bg-light my-3">

                    <div class="col-lg-6">
                        <div class="mx-n2">

                            <?php if ($image): ?>
                                <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
                            <?php else : ?>
                                <img src="https://via.placeholder.com/800x800" alt="Placeholder">
                            <?php endif; ?>

                        </div>
                    </div>
                    <!-- .col -->

                    <div class="col-lg-6">

                        <div class="narrow p-3">

                            <?php if ($headline): ?>
                                <h2 class="card-title display-3 mb-2 f-cheetah-tracks text-tertiary text-center"><?php echo $headline; ?></h2>
                            <?php endif; ?>

                            <?php if ($paragraph): ?>
                                <?php echo $paragraph; ?>
                            <?php endif; ?>

                        </div>

                    </div>
                    <!-- .col -->

                </div>
                <!-- .row -->

                <?php endwhile; /* facts */ ?>
            
            </div>
            <!-- .container -->

            <?php endif; /* facts */ ?>

            <?php endif; /* video_with_two_paragraphs_block | illustration_with_image_and_text_block | video_with_image_and_text_block | fact_repeater */ ?>
                    
            <?php endwhile; endif; /* cheetah_facts_content */ ?>

            <?php if (have_rows('call_to_action')):  while (have_rows('call_to_action')): the_row();
        
            $image = get_sub_field('image');
            $headline = get_sub_field('headline');
            $paragraph = get_sub_field('paragraph');

            ?>

            <div class="featured-panel responsive-lg">

                <div class="card bg-white">

                    <?php if ($image): ?>
                        <div class="gradient-overlay-y-white d-none d-lg-block">
                            <img class="card-img" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
                        </div>
                    <?php else : ?>
                        <div class="gradient-overlay-y-white d-none d-lg-block">
                            <img class="card-img" src="https://via.placeholder.com/1500x1000" alt="Placeholder">
                        </div>
                    <?php endif; ?>

                    <div class="card-img-overlay d-flex px-0">

                        <div class="container align-self-end">

                            <div class="narrow text-center my-4">

                                <?php if ($headline): ?>
                                    <h2 class="f-cheetah-tracks display-3 mb-1 text-tertiary"><?php echo $headline; ?></h2>
                                <?php endif; ?>

                                <?php if ($paragraph): ?>
                                    <?php echo $paragraph; ?>
                                <?php endif; ?>

                                <?php if (have_rows('links')):?>
                                    
                                <div class="row matrix-border mt-3">

                                    <?php while ( have_rows('links') ) : the_row();

                                    $link = get_sub_field('link');

                                    ?>

                                    <div class="col-md">
                                        <a class="btn btn-lg btn-block btn-primary" href="<?php echo $link['url']; ?>" <?php if ($link['target']) : ?>target="<?php echo $link['target'] ?>"<?php endif; ?>>
                                            <?php echo $link['title']; ?>
                                        </a>
                                    </div>

                                    <?php endwhile; /* links */ ?>
                                    
                                </div>
                                
                                <?php endif; /* links */ ?>

                            </div>
                            <!-- .narrow -->

                        </div>
                        <!-- .container -->

                    </div>
                    <!-- .card-img-overlay -->

                </div>
                <!-- .card -->

            </div>
            <!-- .featured-panel -->
            
            <?php endwhile; endif; /* call_to_action */ ?>
            
            <div class="container my-3">
                <div class="narrow text-center">
                    <p class="f-sans-serif fs-md">Illustrations on this page provided by <a href="https://www.smallappleart.com/" class="text-reset" target="_blank">Tess Sheehey</a></p>
                </div>
            </div>
            <!-- .container -->









            <?php get_template_part('template-parts/article-footer'); ?>

        </div>
        <!-- #primary-content -->
    
    </div>
    <!-- .container-fluid -->

</main>
<!-- #content -->

<?php get_footer(); ?>