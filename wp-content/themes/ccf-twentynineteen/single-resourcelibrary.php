<?php

get_header();

$resourceCategories = get_the_terms( $post->ID, 'resource-category' ) ;
$resourceCategory = $resourceCategories[0];

?>

<main id="content" role="main">

    <div class="container-fluid bg-info cheetah-spots py-3">

        <div class="narrow">

            <ul class="extensible-list horizontal fs-md text-white text-shadow">
                <li>
                    <a class="text-white" href="<?php echo home_url() . '/learn/resource-library'; ?>">Resource Library</a>
                </li>
                <li><span class="fa fa-caret-right" role="img"></span></li>
                <li>
                    <a class="text-primary font-weight-bold" href="<?php echo home_url() . '/resource-category/' . $resourceCategory->slug; ?>"><?php echo $resourceCategory->name; ?></a>
                </li>
            </ul>

        </div>

    </div>
    <!-- .container-fluid -->

    <?php if (have_posts()) : while ( have_posts() ) : the_post();

        if (get_field('scientific_paper_authors')) :
            $authors = get_field('scientific_paper_authors');
            $author_names = array();
            foreach ($authors as $author) :
              array_push($author_names, $author->name);
            endforeach;
            $author_names = implode(', ', $author_names);
        else :
            $author_names = get_the_author_meta('display_name');          
        endif;
            
    ?>

    <article class="container-fluid blog overflow-hidden" id="primary-content">

        <div class="my-6">

            <header class="narrow my-5">

                <?php $postcat = get_the_category( $post->ID ); ?>
                <?php foreach ($postcat as $cat): if ($cat->parent != 0 ): ?>

                <p class="mb-0"><a class="no-link-style text-body" href="#"><em><?php echo $cat->name; ?></em></a></p>

                <?php endif; endforeach; ?> 

                <h1 class="display-4 mb-2"><?php the_title(); ?></h1>

                <ul class="list-unstyled fs-md">

                    <li>
                        <span class="text-muted"><?php the_date(); ?></span> 
                    </li>

                    <?php if ($authors) : ?>

                    <li class="fs-md">
                        <strong class="d-block">by&nbsp;<?php echo $author_names; ?></strong>
                    </li>

                    <?php endif; ?>
                    
                </ul>
        
            </header>

            <?php if( has_post_thumbnail() ):
                $featured_image_url = get_the_post_thumbnail_url( get_the_ID(),'full' );
            ?>

            <div class="medium mb-5">

            <figure class="figure">
                <img class="figure-img" src="<?php echo $featured_image_url; ?>" alt="<?php the_title(); ?>" />
                <?php if( $featured_image_caption ): ?>
                    <figcaption class="figure-caption"><?php echo $featured_image_caption ?></figcaption>
                <?php endif; ?>
            </figure>

            </div>
            <!-- .medium -->

            <?php endif; /* has_post_thumbnail */ ?>

            <?php $featured_image = get_field('featured_image');  
        
            if( $featured_image ): ?>

            <div class="medium mb-5">

                <figure class="figure">
                    <img class="figure-img" src="<?php echo $featured_image['image']; ?>" alt="<?php the_title(); ?>" />
                    <?php if( $featured_image['caption'] ): ?>
                    <figcaption class="figure-caption"><?php echo $featured_image['caption'] ?></figcaption>
                    <?php endif; ?>
                </figure>

            </div>
            <!-- .medium -->

            <?php endif; /* featured_image */ ?>

            <?php

            $video_url = get_field('video_url');
            $video_id = substr( strrchr( $video_url, '/' ), 1 );

            if ( get_field('video_url') ): 
            
            ?>

            <div class="video-block medium my-5">

                <div class="embed-responsive embed-responsive-16by9">
                    <?php if (strpos($video_url,'vimeo') !== false) : ?>
                        <iframe src="https://player.vimeo.com/video/<?php echo $video_id; ?>" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
                    <?php else : ?>
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo $video_id; ?>" frameborder="0" allowTransparency="true" allowfullscreen="true"></iframe>
                    <?php endif; ?>
                </div>

            </div>
            <!-- .video-block -->

            <?php endif; ?>   

            <?php get_template_part('template-parts/flexible-content-article'); ?>

            <?php get_template_part('template-parts/article-footer'); ?>

        </div>
        <!-- .my-6 -->

    </article>
    <!-- #primary-content -->

    <?php endwhile; endif; /* have_posts */ ?>

    <?php get_template_part('template-parts/donate-panel'); ?>

</main>
<!-- #content -->

<?php get_footer(); ?>