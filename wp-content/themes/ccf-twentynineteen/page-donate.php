<?php

/*
Template Name: Donate
*/

get_header();

$donate_url = $_SERVER[REQUEST_URI];

if (strpos($donate_url, '/donate/sponsor') !== false) :
    $form = '6fb04bf9-dd82-4dff-ad14-ee935828dd70';
    $type = 'sponsor';
elseif (strpos($donate_url, '/donate/recurring') !== false) :
    $form = 'b9cdbd87-026a-4f39-b5f4-a3aed39adfab';
    $type = 'recurring';
else :
    $form = 'ce3cb3d7-d112-40a1-bf4e-c9dd10a518f2';
    $type = 'once';
endif;

?>

<main id="content" role="main">

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <?php
    
    $featured_image_id = get_post_thumbnail_id($post->ID);
    $featured_image = wp_get_attachment_image_src($featured_image_id, 'full', false, '');
    $featured_image_alt = get_post_meta($featured_image_id, '_wp_attachment_image_alt', true);
    
    ?>

    <style>

        .banner-with-background.featured-image::before{
            background-image: url(<?php echo $featured_image[0]; ?>);
            opacity : .4;
        }

    </style>

    <div class="bg-dark banner-with-background featured-image d-flex flex-column">

        <div class="container-fluid my-auto">
            <div class="narrow text-white text-center text-shadow my-3">
                <h1 class="display-4 text-primary">
                    Donate with Confidence
                </h1>
                <p class="fs-lg">Support the best in scientific research, educational programming, and conservation.</p>
                <a class="shadow-lg my-2 d-inline-block" href="https://www.charitynavigator.org/index.cfm?bay=search.summary&orgid=6617" target="_blank">
                    <img class="rounded" src="<?php echo get_template_directory_uri(); ?>/images/charity-navigator-four-star-badge.svg" alt="Charity Navigator Four Star Rating">
                </a>
            </div>
            <!-- .narrow -->
        </div>
        <!-- .container -->

    </div>
    <!-- .banner-with-background -->

    <div class="container-fluid bg-light py-2">
        <div class="narrow text-center fs-md">
            <p>
                <em>
                    Donations made on this page will be processed by the Cheetah Conservation Fund USA. CCF USA is a Registered Non Profit 501(c) 3: #31-1726923.
                </em>
            </p>
        </div>

    </div>
    <!--  -->

    <div class="container">

        <div class="row">

            <div class="col-lg-8 overflow-hidden" id="primary-content">

                <div class="my-5">

                    <div class="medium my-4">
                        <div class="list-group list-group-horizontal-md text-center">
                            <a class="list-group-item list-group-item-action flex-fill <?php echo($type == 'once' ? 'active' : ''); ?>" href="<?php echo home_url(); ?>/donate" title="Donate Once">
                                Donate Once
                            </a>
                            <a class="list-group-item list-group-item-action flex-fill <?php echo($type == 'recurring' ? 'active' : ''); ?>" href="<?php echo home_url(); ?>/donate/recurring" title="Donate Once">Recurring Gift</a>
                            <a class="list-group-item list-group-item-action flex-fill <?php echo($type == 'sponsor' ? 'active' : ''); ?>" href="<?php echo home_url(); ?>/donate/sponsor" title="Sponsor">Sponsor</a>
                        </div>
                    </div>
                    <!-- .narrow -->

                    <div class="narrow my-4">
                    
                        <div id="bbox-root"></div>

                    </div>

                    <?php get_template_part('template-parts/article-footer'); ?>

                </div>
                <!-- .my-5 -->

            </div>
            <!-- .col -->

            <div class="col-lg-4">

                <div class="card border my-5">
                    <div class="card-header border-bottom text-center">
                        International Donors
                    </div>
                    
                    <div class="card-body">
                        <div class="fs-md">
                            <p>
                                To donate in another country and receive all eligible benefits, please visit your country's affiliated page:
                            </p>
                            <ul class="extensible-list">
                                <li><a href="https://cheetahconservationfund.ca/donate/" target="_blank">Canada</a></li>
                                <li><a href="http://cheetah.org.uk/donate" target="_blank">United Kingdom</a></li>
                                <li><a href="http://www.aga-artenschutz.de/spenden.html?fb_item_id_fix=909" target="_blank">Germany</a></li>
                                <li><a href="https://cheetah.org.au/" target="_blank">Australia</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- .card -->

            <div class="card border my-5">
                <div class="card-header border-bottom text-center">
                    Helpful Information
                </div>
                <div class="card-body">
                    <div class="fs-md">
                        <p>
                            If you are having difficulty completing your donation, please call <strong class="no-wrap">1-866-909-3399</strong>.
                        </p>

                        <p>
                            CCF is a registered Trust in Namibia (Incorporated Association Not For Gain, with
                            Registration Number 21/20002/341).
                        </p>
                    </div>
                </div>
            </div>
            <!-- .card -->

            </div>
            <!-- .col -->

        </div>
        <!-- .row -->

    </div>
    <!-- .container-fluid -->


































    <?php endwhile; endif; /* have_posts */ ?>

</main>
<!-- #content -->

<!-- Heather, you can replace the <script> tag for Donate below -->

<script type="text/javascript">
    window.bboxInit = function () {
        bbox.showForm('<?php echo $form; ?>');
    };
    (function () {
        var e = document.createElement('script'); e.async = true;
        e.src = 'https://bbox.blackbaudhosting.com/webforms/bbox-min.js';
        document.getElementsByTagName('head')[0].appendChild(e);
    } ());
</script>

<?php get_footer();
