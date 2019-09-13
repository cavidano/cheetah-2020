<?php

/*
The template for displaying 404 pages (Not Found)
*/

get_header(); ?>

<main id="content" role="main">

    <section class="featured-panel device-md">

        <div class="card bg-dark">
            
            <img class="card-img opacity-60 full-opacity-on-device" src="<?php echo get_template_directory_uri(); ?>/images/404-feature.jpg" alt="Card image">
            
            <div class="card-img-overlay d-flex">
                <div class="container align-self-center">
                    <div class="narrow text-white">

                        <strong class="fs-lg text-primary text-shadow">
                            <span class="fas fa-paw fa-lg"></span> <span class="mx-1">Page not found</span>
                        </strong>
                    
                        <h1 class="card-title display-4 font-weight-bold my-2 text-shadow">
                            Can't find what you're looking for?
                        </h1>

                        <ul class="extensible-list horizontal">
                            <li class="shadow-sm">
                                <a href="<?php echo home_url(); ?>" class="btn btn-lg btn-light" title="Home">Home</a>
                            </li>
                            <li class="shadow-sm">
                                <a href="/donate" class="btn btn-lg btn-light" title="Donate">Donate</a>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>

    </section>

</main>

<?php get_footer(); ?>