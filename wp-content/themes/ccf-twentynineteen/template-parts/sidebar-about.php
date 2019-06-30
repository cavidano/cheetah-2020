<div class="col-xl-3 bg-dark">

    <div class="sticky-top py-xl-4">

        <div class="btn-toggle d-xl-none mx-n2">

            <button class="btn btn-block btn-lg btn-primary" data-toggle="collapse" data-target="#aside-nav" aria-expanded="false" aria-controls="aside-nav">
                <span class="title"><?php echo $parent_title; ?></span>
            </button>
            
        </div>

        <nav class="collapse d-xl-block mb-xl-4" id="aside-nav">

            <?php

            global $post;

            $args = array(
              'post_parent' => $post->post_parent,
              'post_type'   => 'page', 
              'numberposts' => -1,
              'post_status' => 'any' 
            );

            $children = get_children( $args );
        
            if ($children) :

            ?>
                    <ul class="extensible-list text-white py-3 py-xl-0">
                        <?php foreach ($children as $child) : ?>
                            <!-- current_page_item -->
                            <li class="page_item <?php echo ($post->ID == $child->ID ? 'current_page_item': '') ?>">
                                <a href="<?php the_permalink($child->ID); ?>" title="<?php echo $child->post_title; ?>"><?php echo $child->post_title; ?></a>
                            </li>
                        <? endforeach; ?>
                    </ul>
                <?php endif; ?>
        </nav>

        <?php get_template_part('template-parts/aside-donate'); ?>

    </div>
    <!-- .sticky-top -->

</div>
<!-- .col -->