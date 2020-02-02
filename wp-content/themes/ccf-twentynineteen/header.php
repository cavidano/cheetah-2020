<?php

$url = $_SERVER["REQUEST_URI"];

$inside_news = strpos($url, 'news');

?>

<!DOCTYPE html>

<html lang="en" dir="ltr">

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
    
    <!-- For keyboard users -->
    <a class="sr-only sr-only-focusable skip-menu" href="#content" title="Skip Header">Skip Header</a>

    <header id="global-header">

        <?php if (is_child_theme()) : ?>

        <?php $title = get_field('header_title_text', 'option'); ?>

        <div class="container-fluid bg-info py-1">

            <div class="row align-items-center justify-content-between fs-md">

                <div class="col-auto">

                    <?php if ($title): ?>
                        <p class="text-white f-sans-serif"><?php echo $title ?></p>
                    <?php else : ?>
                        <p class="text-white f-sans-serif">CCF Affiliate</p>
                    <?php endif; ?>
                
                </div>
                <!-- .col -->

                <div class="col-auto">
                    <a class="text-primary font-weight-bold" href="/">Back to Cheetah.org</a>
                </div>
                <!-- .col -->
            
            </div>
            <!-- .row -->

        </div>
        <!-- .container-fluid -->

        <?php endif; ?>

        <div class="container-fluid shadow-sm z-index-900">
        
            <div class="row justify-content-between align-items-stretch">

                <div class="col-md-auto py-2">

                    <div class="d-flex justify-content-center justify-content-md-start align-items-center h-100">
                        <?php the_custom_logo(); ?>
                    </div>
                    
                </div>
                <!-- .col -->
                
                <!-- Mobile Only Buttons -->
                
                <div class="col-md-auto d-md-flex d-xl-none align-self-center border-top border-md-0">

                    <div class="row align-items-center justify-content-between py-2">

                        <div class="col-auto order-md-last">
                            <button class="navbar-toggler no-btn-style" type="button" data-toggle="collapse" data-target="#nav-primary"
                                aria-controls="nav-primary" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="fas fa-bars fa-lg"></span>
                            </button>
                        </div>
                        <!-- .col -->

                        <div class="col-auto">
                            <ul class="extensible-list horizontal">
                                
                                <?php if (is_child_theme() === false) : ?>
                                
                                <li>
                                    <a href="/kids" title="For Kids">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/ccf-kids-logo.svg" alt="Placeholder">
                                    </a>
                                </li>
                                
                                <?php endif; ?>
                                
                                <li>
                                    <a class="btn btn-primary" href="/donate" title="Donate">Donate</a>
                                </li>

                            </ul>
                        </div>
                        <!-- .col -->

                    </div>

                </div>
                <!-- .col -->

                <div class="col-xl-auto d-xl-flex">

                    <!-- Primary Navigation -->

                    <div class="collapse d-xl-flex flex-column align-self-stretch mx-n2 mx-xl-0 border-top border-xl-0" id="nav-primary">

                        <nav class="py-2">

                            <ul class="extensible-list horizontal justify-content-center justify-content-xl-end">

                                <?php if (is_child_theme() === false) : ?>

                                <li class="d-none d-xl-block">
                                    <a href="/kids" title="For Kids">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/ccf-kids-logo.svg" alt="Placeholder">
                                    </a>
                                </li>

                                <?php elseif (get_posts(['post_type' => 'videos'])): ?>
                                
                                <li class="d-none d-xl-block fs-md">

                                    <a class="text-primary has-icon text-info" href="<?php echo get_bloginfo( 'url' )?>/videos">
                                        <span class="fas fa-video"></span>
                                        <span class="title">Videos</span>
                                    </a>
                                    
                                </li>

                                <?php endif; ?>
                                
                                <!-- Language --> 
                                <li style="width:160px" dir="ltr">
                                    <?php echo do_shortcode('[gtranslate]'); ?>
                                </li>

                                <?php if (is_child_theme() === false) : ?>

                                <!-- Search --> 
                                <li style="width:160px" dir="ltr">
                                    <?php get_search_form(); ?>
                                </li>

                                <?php endif; ?>
                                
                            </ul>

                        </nav>

                        <?php starterMenu('Header'); ?>
                        
                    </div>
                    <!-- .collapse -->
                    
                </div>
                <!-- .col -->

            </div>
            <!-- .row -->

        </div>
        <!-- .container-fluid -->

    </header>
    <!-- #global-header -->
