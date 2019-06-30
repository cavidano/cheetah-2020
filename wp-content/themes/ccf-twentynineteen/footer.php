<footer role="contentinfo">

    <?php if( have_rows('footer_features', 'option') ): ?>

    <div class="row no-gutters" id="touts">

        <?php while( have_rows('footer_features', 'option') ): the_row();
    
        $image = get_sub_field('image');
        $link = get_sub_field('link');

        ?>

        <div class="featured-block col-lg-4">

            <div class="card">

                <div class="gradient-overlay-y-black">

                    <?php if ( $image ) : ?>
                        <img class="card-img" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
                    <?php else : ?>
                        <img class="card-img" src="http://via.placeholder.com/500x250.jpg" alt="Placeholder">
                    <?php endif; ?>

                </div>

                <div class="card-img-overlay d-flex">
                    <div class="align-self-end">
                        <a class="btn btn-block btn-primary stretched-link" href="<?php echo $link['url']; ?>" <?php if($link['target']) : ?>target="<?php echo $link['target'] ?>"<?php endif; ?> title="Resource Library">
                            <?php echo $link['title']; ?></a>
                    </div>
                </div>

            </div>
            <!-- .card -->

        </div>

        <?php endwhile; ?>

    </div>
    <!-- #touts -->

    <?php endif; /* footer_features */ ?>

    <div class="py-5" id="global-links">

        <div class="container">

            <nav class="row">

                <?php starterMenu('Footer'); ?>

                <div class="col-lg-4 col-xl-2 mb-3 mb-xl-0 mx-auto">

                    <ul class="extensible-list">
                        <li>
                            <a href="/kids" title="For Kids">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/ccf-kids-logo.svg" alt="Placeholder">
                            </a>
                        </li>
                    </ul>

                </div>
                <!-- .col-* -->

            </nav>
            <!-- .row -->

        </div>

    </div>

    <div class="bg-light overflow-hidden">

        <?php if ( have_rows( 'footer_briefs', 'option') ): ?>
        
        <div class="container my-5">

            <div class="row my-3">

                <?php while ( have_rows('footer_briefs', 'option') ): the_row();

                $headline = get_sub_field('headline');
                $paragraph = get_sub_field('paragraph');

                ?>

                <div class="col-lg-6 col-xl-4 mb-4 mb-xl-0">

                    <?php if ($headline): ?>
                    <h2 class="h5"><?php echo $headline; ?></h2>
                    <?php endif; ?>
                    
                    <?php if ($paragraph): ?>
                    <div class="fs-md">
                        <?php echo $paragraph; ?>
                    </div>
                    <?php endif; ?>

                </div>
                <!-- .col -->

                <?php endwhile; ?>

            </div>
            <!-- .row -->

           <?php 

           $website_credits = get_field('website_credits', 'option');

           if ($website_credits): ?>

            <div class="row my-3">

                <div class="col-xl-8 offset-xl-4">
                    <?php echo $website_credits; ?>
                </div>
                <!-- .col -->

            </div>
            <!-- .row -->

            <?php endif; /* website_credits */ ?>

            <hr class="dark mb-2">

            <div class="row justify-content-between">

                <div class="col-lg-auto">

                    <ul class="extensible-list horizontal fs-lg">
                        <li>
                            <a class="no-btn-style text-body" href="<?php echo site_url(); ?>/newsletter">
                                <span class="far fa-envelope-open"></span>
                                <span class="mx-1 font-weight-bold fs-md">CCF Newsletters</span>
                            </a>
                        </li>
                    </ul>

                </div>
                <!-- .col -->

                <div class="col-lg-auto mb-2 mb-lg-0">

                    <?php if ( have_rows('social_media_links', 'option') ): ?>

                        <ul class="extensible-list horizontal fs-lg">

                        <?php while ( have_rows('social_media_links', 'option') ): the_row();

                            // vars
                            $icon = get_sub_field('icon');
                            $link = get_sub_field('link');

                            ?>

                            <li>

                                <?php if ($link): ?>

                                    <a class="text-body" href="<?php echo $link['url']; ?>" title="<?php echo $link['title']; ?>" target="_blank">
                                    
                                    <?php if ($icon): ?>
                                        <?php echo $icon; ?>
                                    <?php else: ?>
                                        <span><?php echo $link['title']; ?></span>
                                    <?php endif; ?>
                                    
                                    </a>
                                
                                <?php endif; ?>

                            </li>

                        <?php endwhile; ?>

                        </ul>

                    <?php endif; ?>

                </div>
                <!-- .col -->

            </div>
            <!-- .row -->

        </div>
        <!-- .container -->

        <?php endif; ?>

    </div>
    <!-- .bg-light -->

    <div class="bg-dark py-2">

        <div class="container">

            <p class="fs-sm text-white">
                <span class="d-block d-sm-inline-block">© 2019 Cheetah Conservation Fund</span>
                <span class="d-none d-sm-inline-block mx-1">•</span>
                <a class="text-reset" href="<?php echo home_url(); ?>/privacy-policy">Privacy Policy</a>
            </p>
        
        </div>
        <!-- .container -->
    
    </div>
    <!-- .bg-dark -->

</footer>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WC5Q9NX"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<?php wp_footer(); ?>

</body>

</html>
