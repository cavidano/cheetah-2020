<div class="col-xl-3 bg-dark">

    <div class="sticky-top py-xl-4">

        <div class="btn-toggle d-xl-none mx-n2">

            <button class="btn btn-block btn-lg btn-primary" data-toggle="collapse" data-target="#aside-nav" aria-expanded="false" aria-controls="aside-nav">
                <span class="title">Get Involved</span>
            </button>
            
        </div>

        <nav class="collapse d-xl-block mb-xl-4" id="aside-nav">

            <?php $parent_title = get_the_title($post->post_parent); ?>          

            <ul class="extensible-list text-white py-3 py-xl-0">
                <li class="page_item <?php if ( is_page( 'ways-to-give' ) || $parent_title == 'Ways To Give' ) : ?>current_page_item<?php endif; ?>">
                    <a href="/get-involved/ways-to-give/" title="Ways to Give">Ways to Give</a>
                </li>
                <li class="page_item <?php if ( is_page( 'ccf-events' ) || $parent_title == 'CCF Events' ) : ?>current_page_item<?php endif; ?>">
                    <a href="/get-involved/ccf-events/">CCF Events</a>
                </li>
                <li class="page_item <?php if ( is_page( 'volunteer' ) || $parent_title == 'Volunteer' ) : ?>current_page_item<?php endif; ?>">
                    <a href="/get-involved/volunteer/">Volunteer</a>
                </li>
                <li class="page_item <?php if ( is_page( 'visit-ccf' ) || $parent_title == 'Visit CCF' ) : ?>current_page_item<?php endif; ?>">
                    <a href="/get-involved/visit-ccf/">Visit CCF</a>
                </li>
            </ul>

        </nav>

        <?php get_template_part('template-parts/aside-donate'); ?>

    </div>
    <!-- .sticky-top -->

</div>
<!-- .col -->