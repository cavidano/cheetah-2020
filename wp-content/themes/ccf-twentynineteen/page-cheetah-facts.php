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
            
            <div class="container-fluid my-5 bg-danger">

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

                    <?php if ($text): ?>
                        <?php echo $text; ?>
                    <?php endif; ?>

                </div>
                <!-- .narrow -->

            </div>
            <!-- .container -->

            <?php endif; /* video_with_two_paragraphs_block | illustration_with_image_and_text_block | banner_block | figure_block | two_figure_block | gallery_carousel_block | thumnail_links_block | gallery_thumbnail_block */ ?>
                    
            <?php endwhile; endif; /* cheetah_facts_content */ ?>

            <?php get_template_part('template-parts/article-footer'); ?>

        </div>
        <!-- #primary-content -->
    
    </div>
    <!-- .container-fluid -->

</main>
<!-- #content -->

<?php get_footer(); ?>