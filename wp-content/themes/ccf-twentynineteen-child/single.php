<?php

/*
Template Name: News
*/

get_header(); ?>

<main id="content" role="main">

    <?php if (have_posts()) : while ( have_posts() ) : the_post(); ?>

    <article class="container-fluid wide blog overflow-hidden" id="primary-content">

      <div class="my-5">

        <header class="narrow my-5">

            <?php $postcat = get_the_category( $post->ID ); ?>
            <?php foreach ($postcat as $cat): if ($cat->parent != 0 ): ?>

            <p class="mb-0">
              <a class="no-link-style text-body" href="<?php echo get_category_link($cat->cat_ID); ?>"><em><?php echo $cat->name; ?></em></a>
            </p>

            <?php endif; endforeach; ?> 

            <h1 class="display-4 mb-2"><?php the_title(); ?></h1>
            
            <ul class="extensible-list horizontal">

                <li>

                  <?php 
                      $term = get_field('news_author');
                      $avatar = get_field('avatar', $term->taxonomy . '_' . $term->term_id);
                      $avatar_size = '96px';
                      $avatar_placeholder = '/wp-content/uploads/2019/01/avatar-default.jpg';	
                  ?>

                  <div class="rounded-circle overflow-hidden">
                    <?php if ( $avatar ) : ?>
                    <img src="<?php echo $avatar['url']; ?>" width="<?php echo $avatar_size; ?>" alt="<?php echo $avatar['alt']; ?>">
                    
                    <?php else: ?>
                    <img src="<?php echo $avatar_placeholder; ?>" width="<?php echo $avatar_size; ?>" alt="">
                    <?php endif; ?>
                  </div>

                </li>
            
                <li class="fs-md">

                  <?php 

                  if (get_field('news_author')) :
                      $article_author = get_field('news_author')->name;
                  endif;

                  ?>

                  <strong class="d-block">by&nbsp;<?php echo $article_author; ?></strong>

                  <span class="text-muted"><?php the_date(); ?></span> 
                </li>
                
            </ul>
    
        </header>

        <?php 

        if ( get_field('hide_feature_on_post') === false ): 

        if( has_post_thumbnail() ):
        
        $featured_image_url = get_the_post_thumbnail_url( get_the_ID(),'full' );
        $featured_image_caption = get_the_post_thumbnail_caption( get_the_ID() );
        
        ?>

        <div class="medium my-4">

          <figure class="figure">
            
            <img class="figure-img" src="<?php echo $featured_image_url; ?>" alt="<?php the_title(); ?>" />
            <?php if( $featured_image_caption ): ?>
            <figcaption class="figure-caption"><?php echo $featured_image_caption ?></figcaption>
            <?php endif; ?>
          </figure>

        </div>
        <!-- .medium -->

        <?php else: ?>

        <div class="medium mb-5">

          <figure class="figure">
            <img class="figure-img" src="https://via.placeholder.com/1000x563" alt="Placeholder">
            <?php if( $featured_image_caption ): ?>
            <figcaption class="figure-caption"><?php echo $featured_image_caption ?></figcaption>
            <?php endif; ?>
          </figure>

        </div>
        <!-- .medium -->

        <?php 

        endif; /* has_post_thumbnail */
        endif; /* hide_feature_on_post */ ?>

        <?php get_template_part('template-parts/flexible-content-article'); ?>

        <?php get_template_part('template-parts/article-footer'); ?>
        
        <?php get_template_part('template-parts/related-reading'); ?>

      </div>
      <!-- .my-6 -->

    </article>
    <!-- #primary-content -->

    <?php endwhile; endif; /* have_posts */ ?>

    <?php get_template_part('template-parts/donate-panel'); ?>

</main>
<!-- #content -->

<?php get_footer(); ?>