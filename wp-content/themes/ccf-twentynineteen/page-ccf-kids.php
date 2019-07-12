<?php

/*
Template Name: CCF Kids
*/

get_header();

$grandparent_title = get_the_title(intval(get_post($post->post_parent)->post_parent));
$parent_title = get_the_title($post->post_parent);

?>

<main class="for-kids" id="content">

    <section class="bg-info cheetah-spots">

        <div class="container-fluid overflow-hidden">

            <div class="narrow text-center text-white my-5">

                <img class="mb-3" src="<?php echo get_template_directory_uri(); ?>/images/ccf-kids-logo-large.svg" alt="Placeholder">

                <p class="text-shadow">
                    Welcome to Cheetah Conservation Fund’s Kids page—the purrfect place to start your cheetah studies! From cool cheetah facts to how kids like YOU are helping
                    CCF save the cheetah in the wild.
                </p>

            </div>
            <!-- .narrow -->

        </div>
        <!-- .container-fluid -->

        <div class="container" id="kids-tabs">

            <nav class="nav nav-pills" role="tablist">
                <a class="nav-item nav-link" href="/kids/cheetah-facts" aria-selected="false" role="tab">
                    Cheetah Facts
                </a>

                <a class="nav-item nav-link active" href="/kids/ccf-kids" aria-selected="true" role="tab">
                    CCF Kids
                </a>
            </nav>

        </div>

    </section>

    <?php get_template_part('template-parts/related-reading'); ?>

    <div class="wide overflow-hidden">

        <div class="my-6" id="primary-content">

            <div class="container my-5">

                <h2 class="f-cheetah-tracks display-3 mb-3 text-tertiary text-center">Helping cheetah stories</h2> 

                <div class="row matrix-gutter">

                    <?php

                    global $post;
   
                    $args = array(
                        'category_name' => 'for-kids', 
                        'posts_per_page' => 3, 
                        'orderby' => 'date',
                    );

                    $postslist = get_posts( $args );
                    
                    foreach ( $postslist as $post ) :
                    setup_postdata( $post );
                    
                    $the_date = get_the_date();
                    
                    ?>

                    <div class="col-lg-4 mb-5 mb-lg-0">
                    
                        <a class="featured-article" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                        
                            <div>

                                <span><?php echo $the_date; ?></span>

                                <?php if( has_post_thumbnail() ):
                                    $featured_image_url = get_the_post_thumbnail_url( get_the_ID(),'full' );
                                ?>
                                                
                                <img class="w-100" src="<?php echo $featured_image_url; ?>" alt="<?php the_title(); ?>">
                                
                                <?php endif; /* featured_image */ ?>

                            </div>

                            <p class="h5"><?php the_title(); ?></p>

                        </a>

                    </div>
                    <!-- .col -->

                    <?php endforeach; wp_reset_postdata(); ?>

                </div>
                <!-- .row -->

            </div>
            <!-- .container -->

            <script type="text/javascript">

              var page = 1;

              function loadPost(page) {
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo admin_url('admin-ajax.php');?>',
                    dataType: "html",
                    data: { 
                      action: 'get_ajax_posts',
                      page: page
                    },
                    success: function(response) {
                        jQuery('.posts-area').html(response);
                        jQuery('#artist-pagination a:not(.disabled)').click(function(e){
                          e.preventDefault();
                          page = jQuery(this).data('page');
                          loadPost(page);
                        });
                    }
                });
              };

              jQuery(document).ready(function(){
                loadPost(page);
              });

            </script>

            <div class="posts-area"></div>

            <div class="featured-panel responsive-lg">

                <div class="card bg-white">

                    <div class="gradient-overlay-y-white">
                        <img class="card-img" src="<?php echo get_template_directory_uri(); ?>/images/kids/kids-ccf-kids-contact-us.jpg" alt="Card image">
                    </div>

                    <div class="card-img-overlay d-flex px-0">

                        <div class="container align-self-end">

                            <div class="narrow text-center my-4">

                                <h2 class="f-cheetah-tracks display-3 mb-1 text-tertiary">Become a CCF Kid!</h2>

                                <p>
                                    Get help from the grown ups to share your cheetah stories from school projects to
                                    fundraisers by sending us an email. Your submissions may be published to our site,
                                    where you can spend time with the cheetahs!
                                </p>

                                <a href="<?php echo home_url(); ?>/contact-ccf/" class="btn btn-lg btn-block btn-primary">
                                    Contact Us
                                </a>
                                
                            </div>
                            <!-- .narrow -->

                        </div>
                        <!-- .container -->

                    </div>
                    <!-- .card-img-overlay -->

                </div>
                <!-- .card -->

            </div>
            <!-- .featured-panel -->

            <?php get_template_part('template-parts/article-footer'); ?>
        
        </div>
        <!-- #primary-content -->
    
    </div>
    <!-- .container-fluid -->

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php endwhile; endif; /* have_posts */ ?>

</main>
<!-- #content -->

<?php get_footer();
