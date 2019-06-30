<div class="col-xl-3 bg-dark">

    <div class="sticky-top py-xl-4">

        <div class="btn-toggle d-xl-none mx-n2">

            <button class="btn btn-block btn-lg btn-primary" data-toggle="collapse" data-target="#aside-nav" aria-expanded="false" aria-controls="aside-nav">
                <span class="title">Learn</span>
            </button>
            
        </div>

        <nav class="collapse d-xl-block mb-xl-4" id="aside-nav">

            <?php $parent_title = get_the_title($post->post_parent); ?>          
            
            <ul class="extensible-list text-white py-3 py-xl-0">
                <li class="page_item <?php if ( is_page( 'resource-library' ) || $parent_title == 'Resource Library' ) : ?>current_page_item<?php endif; ?>">
                    <a href="/learn/resource-library/">Resource Library</a>
                </li>
                <li class="page_item <?php if ( is_page( 'about-cheetahs' ) || $parent_title == 'About Cheetahs' ) : ?>current_page_item<?php endif; ?>">
                    <a href="/learn/about-cheetahs/">About Cheetahs</a>
                </li>
                <li class="page_item <?php if ( is_page( 'human-wildlife-conflict' ) || $parent_title == 'Human Wildlife Conflict' ) : ?>current_page_item<?php endif; ?>">
                    <a href="/learn/human-wildlife-conflict/">Human Wildlife Conflict</a>
                </li>
                <li class="page_item <?php if ( is_page( 'illegal-pet-trade' ) || $parent_title == 'Illegal Pet Trade' ) : ?>current_page_item<?php endif; ?>">
                    <a href="/learn/illegal-pet-trade/">Illegal Pet Trade</a>
                </li>
                <li class="page_item <?php if ( is_page( 'habitat-loss' ) || $parent_title == 'Habitat Loss' ) : ?>current_page_item<?php endif; ?>">
                    <a href="/learn/habitat-loss/">Habitat Loss</a>
                </li>
                <li class="page_item <?php if ( is_page( 'ccf-videos' ) || $parent_title == 'CCF Videos' ) : ?>current_page_item<?php endif; ?>">
                    <a href="/learn/ccf-videos/">CCF Videos</a>
                </li>
            </ul>

        </nav>

        <?php get_template_part('template-parts/aside-donate'); ?>

    </div>
    <!-- .sticky-top -->

</div>
<!-- .col -->