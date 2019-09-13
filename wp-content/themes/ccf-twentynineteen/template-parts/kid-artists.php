<?php
    $currentPage = (int)$currentPage;
    $totalPages = (int)$totalPages;

    if ($totalPages > $currentPage && $currentPage !== 1):
      $nextPage = true;
    else :
      $nextPage = false;
    endif;

    if ($currentPage == $totalPages) :
      $previousPage = false;
      $nextPage = true;
    else :
      $previousPage = true;
    endif;
?>

<div class="container-fluid wide my-5 bg-light py-5">

    <h2 class="f-cheetah-tracks display-3 mb-2 text-tertiary text-center">Artists of the Month</h2>

    <ul class="extensible-list horizontal justify-content-center" id="artist-pagination">
        
        <?php if ($previousPage == true) : ?>
        
        <li>
            <a class="no-btn-style text-secondary" data-page="<?php echo $currentPage + 1; ?>" href="#" title="Previous">
                <span class="fas fa-angle-double-left" title="Previous"></span>
            </a>
        </li>
        
        <?php else: ?>

        <li>
            <a class="no-btn-style text-secondary disabled opacity-40" data-page="<?php echo $currentPage + 1; ?>" href="#1" title="Previous">
                <span class="fas fa-angle-double-left" title="Previous"></span>
            </a>
        </li>
        
        <?php endif; ?>
        
        <li>
            <strong class="f-cheetah-tracks text-secondary h2"><?php the_time('F, Y'); ?></strong>
        </li>
        
        <?php if ($nextPage == true) : ?>
        
        <li>
            <a class="no-btn-style text-secondary" data-page="<?php echo $currentPage - 1; ?>" href="#" title="Next">
                <span class="fas fa-angle-double-right" title="Next"></span>
            </a>
        </li>

        <?php else: ?>

        <li>
            <a class="no-btn-style text-secondary disabled opacity-40" data-page="<?php echo $currentPage - 1; ?>" href="#1" title="Next">
                <span class="fas fa-angle-double-right" title="Next"></span>
            </a>
        </li>
        
        <?php endif; ?>
        
    </ul>

    <?php
      
      $featured_image_id = get_post_thumbnail_id($post->ID);
      $featured_image = wp_get_attachment_image_src($featured_image_id, 'full', false, '');
      $featured_image_alt = get_post_meta($featured_image_id, '_wp_attachment_image_alt', true);
      
      if ($featured_image):
        $featured_image = $featured_image[0];
      else :
        $featured_image = 'http://via.placeholder.com/1500x1166.jpg';
        $featured_image_alt = 'Placeholder';
      endif;
    
    ?>

    <div class="figure-block medium my-3">

        <figure class="figure my-0">

            <div class="figure-img shadow-lg">

                <a class="enlarge" class="stretched-link" href="<?php echo $featured_image; ?>" title="<?php echo $featured_image_alt; ?>"
                    data-toggle="lightbox" data-footer="<?php echo $featured_image_alt; ?>">
                    <span>
                        <span class="fas fa-expand"></span>
                    </span>
                </a>

                <img src="<?php echo $featured_image; ?>" alt="<?php echo $featured_image_alt; ?>">

            </div>
            <!-- .figure-img -->

            <figcaption class="figure-caption mt-1 text-center"><?php echo $featured_image_alt; ?></figcaption>

        </figure>

    </div>
    <!-- .figure-block -->

    <div class="narrow gallery-thumbnails my-5">

        <div class="artist-bio my-3 text-center">
            <h3 class="text-tertiary"><?php the_title(); ?></h3>
            <p><?php the_field('description'); ?></p>
    
        </div>
        <!-- .artist-bio -->

        <?php 

        $images = get_field('gallery');
        
        if ($images) : 

        ?>

            <div class="row matrix-gutter" id="example-gallery">

                <?php foreach( $images as $image ): ?>

                    <div class="col-sm-4">

                        <div class="position-relative">

                            <a class="enlarge" class="stretched-link" href="<?php echo $image['url']; ?>"
                                title="<?php echo $image['alt']; ?>" data-toggle="lightbox"
                                data-gallery="example-gallery" data-footer="<?php echo $image['alt']; ?>">
                                <span>
                                    <span class="fas fa-expand"></span>
                                </span>
                            </a>

                            <img class="w-100" src="<?php echo $image['sizes']['thumbnail']; ?>" alt="<?php echo $image['alt']; ?>">
                        </div>

                    </div>
                    <!-- .col -->

                <?php endforeach; ?>

            </div>
            <!-- .row -->

        <?php endif; ?>

    </div>
    <!-- .gallery-thumbnails -->

</div>

<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('[data-toggle="lightbox"]').on('click', function(event) {
            
            event.preventDefault();
            
            var data_title = $(this).data('title');

            function update_modal() {

                var target =  $('.ekko-lightbox');
                var close_button = target.find('button[data-dismiss="modal"]');
                var modal_header = target.find('.modal-header h4');

                target.removeClass('fade in');
                close_button.removeClass('close').addClass('ml-auto no-btn-style');
                close_button.html('<span class="fas fa-times fa-lg"></span>');

                if (data_title) {
                    return;
                } else {
                    modal_header.remove();
                }
            }
            
            $(this).ekkoLightbox({
                alwaysShowClose: true,
                onShow: function() {
                    update_modal(data_title);
                } 
            });
        });
    });
</script>