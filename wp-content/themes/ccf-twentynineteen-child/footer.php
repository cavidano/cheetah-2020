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

    <div class="bg-light py-5">

        <div class="container">

            <div class="row">

                <div class="col-lg-6 col-xl-4 mb-3 mb-xl-0">

                    <h5 class="mb-0">Cheetah Conservation Fund</h5>

                    <?php if (have_rows('contact', 'options')):
  
                        while (have_rows('contact', 'options')): the_row();
                                
                        $title = get_sub_field('title');
                        $info = get_sub_field('info');

                        ?>
                
                        <div class="fs-md">

                            <p class="f-sans-serif text-muted"><strong><?php echo $title; ?></strong></p>
                        
                            <?php echo $info; ?>
                        
                        </div>

                        <?php endwhile; endif; /* contact */ ?>

                </div>
                <!-- .col -->

                <div class="col-lg-6 col-xl-4">

                 <?php if (have_rows('general_info', 'options')):
  
                    while (have_rows('general_info', 'options')): the_row();
                            
                    $headline = get_sub_field('headline');
                    $paragraph = get_sub_field('paragraph');
                    $link = get_sub_field('link');

                    ?>

                    <?php if ($headline): ?>
                        <h5><?php echo $headline; ?></h5>
                    <?php endif; ?>

                    <?php if ($paragraph): ?>

                    <div class="f-serif fs-md mb-2">
                        <?php echo $paragraph; ?>
                    </div>

                    <?php endif; ?>

                    <?php if ($link): ?>

                    <a class="btn btn-primary" href="<?php echo $link['url']; ?>"><?php echo $link['title']; ?></a>
                    
                    <?php endif; ?>

                <?php endwhile; endif; /* general_info */ ?>
                    
                </div>
                <!-- .col -->

                <div class="col-lg-6 col-xl-4">

                    <h5>Follow Us</h5>

                    <?php if (have_rows('social_media_links', 'option')): ?>

                        <ul class="extensible-list horizontal fs-lg">

                        <?php while (have_rows('social_media_links', 'option')): the_row();

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

    </div>
    <!-- .bg-light -->

    <div class="bg-dark py-2">

        <div class="container f-sans-serif text-white">

            <ul class="extensible-list horizontal f-sans-serif fs-sm">
                <li>
                    &#169; <?php echo date('Y'); ?> Cheetah Conservation Fund
                </li>
                <li>
                    <a class="text-reset" href="/privacy-policy">Privacy Policy</a>
                </li>
            </ul>

        </div>
        <!-- .container -->

    </div>
    <!-- .bg-dark -->

</footer>

<?php wp_footer(); ?>

</body>

</html>