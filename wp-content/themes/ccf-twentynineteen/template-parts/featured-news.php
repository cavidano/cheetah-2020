<div class="row matrix-gutter">

    <?php

    global $post;
    
    $args = array( 'category_name' => 'ccf-blog', 'posts_per_page' => 3, 'orderby' => 'date' );
    $postslist = get_posts( $args );
    
    foreach ( $postslist as $post ) :
    setup_postdata( $post );
    
    ?>

    <div class="col-lg-4 mb-3 mb-lg-0">
    
        <div class="featured-article">
        
            <div>

                <span><?php echo get_the_date(); ?></span>

                <?php if( has_post_thumbnail() ):
                    $featured_image_url = get_the_post_thumbnail_url( get_the_ID(),'full' );
                ?>
                                
                <img class="w-100" src="<?php echo $featured_image_url; ?>" alt="<?php the_title(); ?>">
                
                <?php else : ?>
                
                <img class="w-100" src="https://via.placeholder.com/1000x563" alt="Placeholder">
                
                <?php endif; /* featured_image */ ?>

            </div>

            <a class="stretched-link text-body" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
               <span class=""><?php the_title(); ?></span> 
            </a>

        </div>
        <!-- .featured-article -->

    </div>
    <!-- .col -->

    <?php endforeach; wp_reset_postdata(); ?>

</div>
<!-- .row -->
