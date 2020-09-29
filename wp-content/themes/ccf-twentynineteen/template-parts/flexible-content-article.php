<?php if( have_rows('article_content') ): while ( have_rows('article_content') ) : the_row(); ?>

<?php if( get_row_layout() == 'text_block' ):

$wysiwyg = get_sub_field('wysiwyg');

?>

<div class="text-block narrow mb-4">
    <?php echo $wysiwyg; ?>
</div>

<?php elseif( get_row_layout() == 'video_block' ):

$video = get_sub_field( 'video');
$post_object = $video;

?>

<?php if( $post_object ): 

// override $post
$post = $post_object;
setup_postdata( $post ); 

$video_url = get_field('video_url');
$video_id = substr( strrchr( $video_url, '/' ), 1 );

?>

<div class="video-block medium my-4">

    <div class="embed-responsive embed-responsive-16by9">
        <?php if (strpos($video_url,'vimeo') !== false) : ?>
            <iframe src="https://player.vimeo.com/video/<?php echo $video_id; ?>" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
        <?php else : ?>
            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo $video_id; ?>" frameborder="0" allowTransparency="true" allowfullscreen="true"></iframe>
        <?php endif; ?>
    </div>

</div>
<!-- .video_block -->

<?php endif; wp_reset_postdata(); /* post_objects */ ?>

<?php elseif( get_row_layout() == 'banner_block' ):  

$type = get_sub_field('type');
$image = get_sub_field('image');
$caption = get_sub_field('caption');

$summary = get_sub_field('summary');

$summary_headline = $summary['headline'];
$summary_text = $summary['text'];
$summary_link = $summary['link'];

$quote = get_sub_field('quote');

$quote_text = $quote['text'];
$quote_credit_name = $quote['credit_name'];
$quote_credit_title = $quote['credit_title'];

?>

<div class="banner-block my-5 mx-n2">

    <figure class="figure w-100">

        <div class="featured-panel responsive-xl figure-info">

            <div class="card bg-info">

                <?php if( $image ): ?>
                <div class="gradient-overlay-y-black-tall">
                    <img class="card-img" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>">
                </div>
                <?php else : ?>
                <div class="gradient-overlay-y-black-tall">
                    <img class="card-img" src="https://via.placeholder.com/1200x800" alt="Placeholder">
                </div>
                <?php endif; ?>

                <div class="card-img-overlay d-flex">
                    <div class="align-self-end">
                        <div class="container px-0 py-3">
                            <div class="narrow text-shadow">

                                <?php if( $type == 'Summary' ) : ?>

                                <h2 class="h3 text-primary">
                                    <?php echo $summary_headline; ?>
                                </h2>

                                <div class="text-white">

                                    <div class="fs-lg mb-2">
                                        <?php echo $summary_text; ?>
                                    </div>

                                    <?php if ( $summary_link ) : ?>
                                      
                                        <a class="link text-primary" href="<?php echo $summary_link['url']; ?>" <?php if($summary_link['target']) : ?>target="<?php echo $summary_link['target'] ?>"<?php endif; ?>>
                                            <?php echo $summary_link['title']; ?>
                                        </a>

                                    <?php endif; ?>

                                </div>

                                <?php elseif( $type == 'Quote' ) : ?>

                                <blockquote class="blockquote text-white">

                                    <span class="fs-xl text-primary mb-2"><span class="fas fa-quote-left"></span></span>

                                    <?php echo $quote_text; ?>

                                    <footer class="blockquote-footer text-white">
                                        <?php echo $quote_credit_name; ?> <cite title="Source Title">
                                            <?php echo $quote_credit_title; ?></cite>
                                    </footer>

                                </blockquote>

                                <?php endif; ?>

                            </div>
                            <!-- .narrow -->
                        </div>
                        <!-- .container -->
                    </div>
                    <!-- .align-self-center -->
                </div>
                <!-- .card-img-overlay -->
            </div>
            <!-- .card -->

        </div>
        <!-- .featured-panel -->

        <div class="container">
            <div class="narrow">
                <figcaption class="figure-caption">
                    <?php echo $caption; ?>
                </figcaption>
            </div>
        </div>

    </figure>
    <!-- figure -->

</div>
<!-- .banner-block -->

<?php elseif( get_row_layout() == 'figure_block' ):  

$figure = get_sub_field('figure');
$enlarge = $figure['enlarge'];

$image = $figure['image'];
$caption = $image['caption'];

?>

<div class="figure-block medium my-4">

    <figure class="figure my-0">

        <div class="figure-img">

            <?php if( $enlarge ): ?>

            <a class="enlarge stretched-link" href="<?php echo $image['url']; ?>" class="stretched-link" title="<?php echo $caption; ?>"
                data-toggle="lightbox" data-footer="<?php echo $caption; ?>">
                <span>
                    <span class="fas fa-expand"></span>
                </span>
            </a>

            <?php endif; ?>

            <?php if( $image ): ?>
                <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>">
            <?php else : ?>
                <img src="https://placehold.it/1000x600.jpg" alt="Placeholder">
            <?php endif; ?>

        </div>
        <!-- .figure-img -->

        <?php if( $caption ): ?>
            <figcaption class="figure-caption"><?php echo $caption; ?></figcaption>
        <?php endif; ?>

    </figure>

</div>
<!-- .medium -->

<?php elseif( get_row_layout() == 'two_figure_block' ): 

$figure_a = get_sub_field('figure_a');

$image_a = $figure_a['image'];
$caption_a = $image_a['caption'];
$enlarge_a = $figure_a['enlarge'];

$figure_b = get_sub_field('figure_b');

$image_b = $figure_b['image'];
$caption_b = $image_b['caption'];
$enlarge_b = $figure_b['enlarge'];

?>

<div class="two-figure-block my-5 mx-n2">

    <div class="row matrix-gutter">

        <div class="col-sm-6">

            <figure class="figure my-0">

                <div class="figure-img">

                    <?php if( $enlarge_a ): ?>

                    <a class="enlarge stretched-link" href="<?php echo $image_a['url']; ?>" class="stretched-link"
                        title="<?php echo $caption_a; ?>" data-toggle="lightbox"
                        data-footer="<?php echo $caption_a; ?>">
                        <span>
                            <span class="fas fa-expand"></span>
                        </span>
                    </a>

                    <?php endif; ?>

                    <?php if( $image_a ): ?>
                    <img src="<?php echo $image_a['url']; ?>" alt="<?php echo $image_a['alt'] ?>">
                    <?php else : ?>
                    <img src="https://placehold.it/1000x600.jpg" alt="Placeholder">
                    <?php endif; ?>

                </div>
                <!-- .figure-img -->

                <figcaption class="figure-caption mx-2"><?php echo $caption_a; ?></figcaption>

            </figure>

        </div>
        <!-- .col -->

        <div class="col-sm-6">

            <figure class="figure my-0">

                <div class="figure-img">

                    <?php if( $enlarge_b ): ?>

                    <a class="enlarge stretched-link" href="<?php echo $image_b['url']; ?>" class="stretched-link"
                        title="<?php echo $caption_b; ?>" data-toggle="lightbox"
                        data-footer="<?php echo $caption_a; ?>">
                        <span>
                            <span class="fas fa-expand"></span>
                        </span>
                    </a>

                    <?php endif; ?>

                    <?php if( $image_a ): ?>
                    <img src="<?php echo $image_b['url']; ?>" alt="<?php echo $image_b['alt'] ?>">
                    <?php else : ?>
                    <img src="https://placehold.it/1000x600.jpg" alt="Placeholder">
                    <?php endif; ?>

                </div>
                <!-- .figure-img -->

                <figcaption class="figure-caption mx-2"><?php echo $caption_b; ?></figcaption>

            </figure>

        </div>
        <!-- .col -->

    </div>
    <!-- .row -->

</div>
<!-- .two-figure-block -->

<?php elseif( get_row_layout() == 'gallery_carousel_block' ): 
        
$images = get_sub_field('images');

$count_a = 0;
$count_b = 0;

$row_count = get_row_index();
$carousel_id = "carousel-gallery_" . $row_count;

?>

<?php if( $images ): ?>

<div class="gallery-carousel-block my-5 mx-n2">

    <div class="carousel slide carousel-fade" data-ride="carousel" data-keyboard="true" data-interval="false" id="<?php echo $carousel_id; ?>" dir="ltr">

        <div class="carousel-outer">

            <div class="carousel-arrows d-none d-md-block">

                <ul>
                    <li>
                        <a class="half-circle right" href="#<?php echo $carousel_id; ?>" role="button" data-slide="prev">
                            <span class="fas fa-arrow-left m-auto" title="Previous"></span>
                        </a>
                    </li>
                    <li>
                        <a class="half-circle left text-white d-flex" href="#<?php echo $carousel_id; ?>" role="button" data-slide="next">
                            <span class="fas fa-arrow-right m-auto" title="Next"></span>
                        </a>
                    </li>
                </ul>
                <!-- .row -->

            </div>
            <!-- .carousel-arrows -->

            <div class="carousel-inner">

                <?php foreach( $images as $image ): ?>

                <div class="carousel-item <?php if($count_a == 0){ echo 'active'; } ?>">

                    <img class="w-100" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">

                    <div class="carousel-caption bg-opacity-black-60">
                        <?php if ($image['caption']) : ?>
                        <p class="f-sans-serif text-body shadow-sm rounded fs-md">
                            <?php echo $image['caption']; ?>
                        </p>
                        <?php endif; ?>
                    </div>

                </div>
                <!-- .carousel-item -->

                <?php $count_a++; endforeach; ?>

            </div>
            <!-- .carousel-inner -->

        </div>
        <!-- .carousel-outer  -->

        <div class="row no-gutters align-items-center justify-content-between py-1">

            <div class="col-auto text-left px-2 d-md-none">
                <a class="no-btn-style" href="#<?php echo $carousel_id; ?>" role="button" data-slide="prev">
                    <span class="fas fa-arrow-left" title="Previous"></span>
                    <span class="sr-only">Previous</span>
                </a>
            </div>
            <!-- .col -->

            <div class="col">

                <ol class="carousel-indicators">

                    <?php foreach( $images as $image ): ?>

                    <li class="<?php if($count_b == 0){ echo 'active'; } ?>" data-target="#<?php echo $carousel_id; ?>"
                        data-slide-to="<?php echo $count_b; ?>" role="button">
                        <button class="no-btn-style">
                            <?php echo ($count_b + 1); ?></button>
                    </li>

                    <?php $count_b++; endforeach; ?>

                </ol>

            </div>
            <!-- .col -->

            <div class="col-auto text-right px-2 d-md-none">
                <a class="no-btn-style" href="#<?php echo $carousel_id; ?>" role="button" data-slide="next">
                    <span class="fas fa-arrow-right" title="Next"></span>
                </a>
            </div>
            <!-- .col -->

        </div>
        <!-- .row -->

    </div>
    <!-- #carousel-gallery -->

</div>
<!-- .gallery-carousel-block -->

<?php endif; ?>

<?php elseif( get_row_layout() == 'thumbnail_links_block' ):
    
    $modals = get_sub_field('modals');
    
?>

<?php if( have_rows('links') ): ?>

<div class="thumbnail-links-block my-4">

    <div class="medium">

        <div class="row matrix-gutter">

        <?php while ( have_rows('links') ) : the_row(); 

        // vars
        $image = get_sub_field('image');
        $link = get_sub_field('link');

        ?>

        <div class="col-sm-6 <?php if($modals){ echo ' col-lg-4'; } ?>">
            <?php if( $image ): ?>
                <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>">
            <?php else : ?>
                <img src="https://placehold.it/600x400.jpg" alt="Placeholder">
            <?php endif; ?>
            <a class="btn btn-block btn-lg btn-info stretched-link" href="<?php echo $link['url']; ?>" <?php if($modals): ?>data-toggle="modal"<?php endif; ?> <?php if($link['target']) : ?>target="<?php echo $link['target'] ?>"<?php endif; ?> title="<?php echo $link['title']; ?>"><?php echo $link['title']; ?></a>
        </div>
        <!-- .col -->

        <?php endwhile; ?>

        </div>
        <!-- .row -->

    </div>
    <!-- .medium -->

</div>
<!-- .thumbnail-links-block -->

<?php endif; ?>

<?php elseif( get_row_layout() == 'gallery_thumbnail_block' ):

$images = get_sub_field('images');
    
?>

<?php if( $images ): ?>

<div class="gallery-thumbnails medium my-4">

    <div class="row matrix-gutter">

        <?php foreach( $images as $image ): ?>
            
        <div class="col-sm-6">

            <div class="position-relative">

                <a class="enlarge" class="stretched-link" href="<?php echo $image['url']; ?>" title="<?php echo $image['caption']; ?>"
                    data-toggle="lightbox" data-gallery="example-gallery" data-footer="<?php echo $image['caption']; ?>">
                    <span>
                        <span class="fas fa-expand"></span>
                    </span>
                </a>

                <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
            </div>

        </div>
        <!-- .col -->
        
        <?php endforeach; ?>

    </div>
    <!-- .row -->

</div>
<!-- .gallery-thumbnails -->

<?php endif; ?>

<?php elseif( get_row_layout() == 'color_callout_block' ): ?>

<?php if( have_rows('callouts') ): ?>

<div class="color-callout-block my-5 mx-n2">

    <?php while ( have_rows('callouts') ) : the_row(); 

    // vars
    $background_color = get_sub_field('background_color');
    
    $image = get_sub_field('image');

    $headline = get_sub_field('headline');   
    $text = get_sub_field('text');   
    $link = get_sub_field('link');

    if( $background_color == 'Purple' ){
        $class_name = 'bg-info';
    } else {
        $class_name = 'bg-tertiary';
    }

    ?>

    <div class="row no-gutters">

        <div class="col-lg-6">
            <?php if ($image): ?>
                <img class="w-100" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>">
            <?php else : ?>
                <img class="w-100" src="https://placehold.it/800x600.jpg" alt="Placeholder">
            <?php endif; ?>
        </div>
        <!-- .col -->

        <div class="col-lg-6 d-flex <?php echo $class_name; ?> text-white">
            <div class="narrow align-self-center p-3">
                <h3 class="h4 text-primary"><?php echo $headline; ?></h3>
                <div class="f-sans-serif mb-2">
                    <?php echo $text; ?>
                </div>
                <?php if ($link): ?>
                    <a class="link stretched-link text-primary" href="<?php echo $link['url']; ?>" <?php if($link['target']) : ?>target="<?php echo $link['target'] ?>"<?php endif; ?> title="<?php echo $link['title']; ?>"><?php echo $link['title']; ?></a>
                <?php endif; ?>
            </div>
        </div>
        <!-- .col -->

    </div>
    <!-- .row -->

    <?php endwhile; ?>

</div>
<!-- .mx-n2 -->

<?php endif; ?>

<?php elseif( get_row_layout() == 'horizontal_button_block' ): ?>

<?php if( have_rows('buttons') ): ?>

<div class="narrow my-4">

    <div class="row matrix-border">

    <?php while ( have_rows('buttons') ) : the_row();

    $link = get_sub_field('link');

    ?>

    <div class="col-md">
        <a class="btn btn-block btn-primary btn-lg" href="<?php echo $link['url'] ?>" <?php if($link['target']) : ?>target="<?php echo $link['target'] ?>"<?php endif; ?>><?php echo $link['title'] ?></a>
    </div>

    <?php endwhile; ?>

    </div>

</div>
<!-- .narrow -->

<?php endif; ?>

<?php elseif( get_row_layout() == 'pdf_embed_block' ):

    $embed_pdf = get_sub_field('embed_pdf');

    if ($embed_pdf): ?>

    <div class="medium my-4">

        <?php echo do_shortcode('[pdf-embedder url="' . $embed_pdf['url'] .'"]'); ?>

        <a class="btn btn-block btn-primary btn-lg my-3" href="<?php echo $embed_pdf['url']; ?>" title="Download PDF" target="_blank" download>Download PDF</a>

    </div>
    <!-- .medium -->

    <?php endif; ?>

<?php elseif( get_row_layout() == 'divider_block' ):

    $color = get_sub_field('color');

    if ($color === 'Light') : ?>

    <hr class="narrow my-4">

    <?php elseif ($color === 'Dark') : ?>
    
    <hr class="narrow my-4 border-dark">
    
    <?php elseif ($color === 'Pattern') : ?>

    <hr class="african-hr mx-n2 mb-4">

    <?php endif; /* divider_block */ ?>

<?php elseif( get_row_layout() == 'embed_script_block' ):
    
    $width = strtolower(get_sub_field('width'));
    $script = get_sub_field('script');

    ?>

    <?php if ($script): ?>

    <div class="embed-script-block <?php echo $width; ?> my-4">
        <?php echo $script; ?>
    </div>

    <?php endif; /* script */ ?>

<?php endif; /* text_block | video_block | banner_block | figure_block | two_figure_block | gallery_carousel_block | thumnail_links_block | gallery_thumbnail_block */ ?>

<?php endwhile; endif; /* article_content */ ?>
