<?php

/*
Template Name: Donate
*/

get_header();

$donate_url = $_SERVER[REQUEST_URI];

if (strpos($donate_url, '/donate/sponsor') !== false) :
    $form = '42099271-19f3-4544-b7b9-97ab9196c0fe';    
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

    <?php if (have_rows('banner_on_page', 'options')): while (have_rows('banner_on_page', 'options')): the_row();
        
    $headline = get_sub_field('headline');
    $text = get_sub_field('text');
    $image = get_sub_field('image');
    $disclaimer = get_sub_field('disclaimer');

    ?>

    <style>

        .banner-with-background.featured-image::before{
            background-image: url(<?php echo $image['url']; ?>);
            opacity : .4;
        }

    </style>

    <div class="bg-dark banner-with-background featured-image d-flex flex-column">

        <div class="container-fluid my-auto">
            <div class="medium text-white text-center text-shadow my-3">
                <h1 class="display-4 text-primary">
                    <?php echo $headline; ?>
                </h1>

                <p class="fs-lg">
                    <?php echo $text; ?>
                </p>
                
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
        <div class="medium text-center fs-md">
            <p>
                <em>
                    <?php echo $disclaimer; ?>
                </em>
            </p>
        </div>

    </div>
    <!-- .container-fluid -->

	<?php endwhile; endif; /* banner */ ?>

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

                <?php if (have_rows('international_donors', 'options')): while (have_rows('international_donors', 'options')): the_row();
            
                $headline = get_sub_field('headline');
                $text = get_sub_field('text');

                ?>

                <div class="card border my-5">
                    <div class="card-header border-bottom text-center">
                        <?php echo $headline; ?>
                    </div>
                    
                    <div class="card-body">

                        <div class="fs-md">
                            
                            <?php echo $text; ?>

                            <?php if( have_rows('affiliate_donations') ): ?>

                            <ul class="extensible-list">

                                <?php while ( have_rows('affiliate_donations') ) : the_row();

                                $link = get_sub_field('link');

                                ?>
                            
                                <li>
                                    <a href="<?php echo $link['url']; ?>" <?php if ($link['target']) : ?>target="<?php echo $link['target'] ?>"<?php endif; ?> title="<?php echo $link['title']; ?>"><?php echo $link['title']; ?></a>
                                </li>

                                <?php endwhile; ?>
                            
                            </ul>

                            <?php endif; /* affiliate_donations */ ?>

                        </div>

                    </div>
                    <!-- .card-body -->

                </div>
                <!-- .card -->

                <?php endwhile;  endif;/* international_donors */ ?>

                <?php if (have_rows('helpful_information', 'options')): while (have_rows('helpful_information', 'options')): the_row();
            
                $headline = get_sub_field('headline');
                $text = get_sub_field('text');

                ?>

                <div class="card border my-5">
                    <div class="card-header border-bottom text-center">
                        <?php echo $headline; ?>
                    </div>

                    <div class="card-body">

                        <div class="fs-md">
                                <?php echo $text; ?>
                        </div>


                        <div class="fs-md d-none">
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

                <?php endwhile;  endif;/* helpful_information */ ?>

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
