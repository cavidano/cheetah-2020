<div class="col-xl-3 bg-dark">

    <div class="sticky-top py-xl-4">

        <div class="btn-toggle d-xl-none mx-n2">

            <button class="btn btn-block btn-lg btn-primary" data-toggle="collapse" data-target="#aside-nav" aria-expanded="false" aria-controls="aside-nav">
                <span class="title">What We Do</span>
            </button>
            
        </div>

        <nav class="collapse d-xl-block mb-xl-4" id="aside-nav">

            <?php $parent_title = get_the_title($post->post_parent); ?>

            <ul class="extensible-list text-white py-3 py-xl-0">
                <li class="page_item <?php if ( is_page( 'conservation' ) || $parent_title == 'Conservation' ) : ?>current_page_item<?php endif; ?>">
                    <a href="/about-us/what-we-do/conservation/">Conservation</a>
                </li>
                <li class="page_item <?php if ( is_page( 'research' ) || $parent_title == 'Research' ) : ?>current_page_item<?php endif; ?>">
                    <a href="/about-us/what-we-do/research/">Research</a>
                </li>
                <li class="page_item <?php if ( is_page( 'education' ) || $parent_title == 'Education' ) : ?>current_page_item<?php endif; ?>">
                    <a href="/about-us/what-we-do/education/">Education</a>
                </li>
                <li class="page_item <?php if ( is_page( 'international-cheetah-day' ) || $parent_title == 'International Cheetah Day' ) : ?>current_page_item<?php endif; ?>">
                    <a href="/about-us/what-we-do/international-cheetah-day/">International Cheetah Day</a>
                </li>
            </ul>

        </nav>

        <?php get_template_part('template-parts/aside-donate'); ?>

    </div>
</div>
<!-- .col -->