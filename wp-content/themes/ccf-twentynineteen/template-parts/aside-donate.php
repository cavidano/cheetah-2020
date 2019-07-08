<?php if (have_rows('donate_panel', 'options')):

    while (have_rows('donate_panel', 'options')): the_row();

    $headline = get_sub_field('headline');
    $link = get_sub_field('link');

    $image_sidebar = get_sub_field('image_sidebar');

    ?>

    <div class="d-none d-xl-block">

        <div class="row matrix-border">

            <div class="col-12">

                <div class="card bg-dark d-block">

                    <?php if ($image_sidebar): ?>
                        <img class="card-img opacity-40" src="<?php echo $image_sidebar['url']; ?>" alt="<?php echo $image_sidebar['alt']; ?>">
                    <?php else : ?>
                        <img class="card-img opacity-40" src="<?php echo get_template_directory_uri(); ?>/images/donate-aside.jpg" alt="Placeholder">
                    <?php endif; ?>

                    
                    <div class="card-img-overlay d-flex">
                        <div class="align-self-center w-100">
                            <div class="text-white text-center text-shadow">
                                <p class="h4">
                                <span class="d-block"><?php echo $headline; ?></span>
                                
                                <a class="text-primary" href="<?php echo $link['url']; ?>" <?php if($link['target']) : ?>target="<?php echo $link['target'] ?>"<?php endif; ?>><?php echo $link['title']; ?></a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- .card-img-overlay -->
                </div>
                <!-- .card -->
            </div>
            <!-- .col -->

            <div class="col-xxl-6">
                <a class="btn btn-block btn-primary" href="<?php echo home_url(); ?>/donate" title="Donate">Donate</a>
            </div>
            <!-- .col -->
            
            <div class="col-xxl-6">
                <a class="btn btn-block btn-primary" href="<?php echo home_url(); ?>/donate/sponsor/" title="Sponsor">Sponsor</a>
            </div>
            <!-- .col -->

        </div>
        <!-- .matrix-border -->

    </div>

<?php endwhile; endif; /* donate_panel */ ?>