<?php $featured_videos = get_field('featured_videos');	

$headline = $featured_videos['headline'];
$videos = $featured_videos['videos'];

$post_objects = $videos;

if( $featured_videos ): ?>

<div class="container my-5" id="videos">

    <header class="row align-items-end justify-content-between mb-3">
        <div class="col-md-auto">
            <h2 class="display-4"><?php echo $headline; ?></h2>
        </div>
        <div class="col-md-auto">
            <a class="link text-body" href="<?php echo home_url(); ?>/learn/ccf-videos">All Videos</a>
        </div>
    </header>

    <div class="row matrix-gutter">

        <?php

        if( $post_objects ) :
        foreach($post_objects as $post) :
        setup_postdata( $post ); 

        $video_url = get_field('video_url');
        $video_id = substr( strrchr( $video_url, '/' ), 1 );
        ?>

        <div class="col-lg-6">
            <div class="embed-responsive embed-responsive-16by9">
                <?php if (strpos($video_url,'vimeo') !== false) : ?>
                    <iframe src="https://player.vimeo.com/video/<?php echo $video_id; ?>" title="Cheetah Conservation Fund Featured Video" allowfullscreen></iframe>
                <?php else : ?>
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo $video_id; ?>" title="Cheetah Conservation Fund Featured Video" allowfullscreen></iframe>
                <?php endif; ?>
            </div>
        </div>
        <!-- .col -->

        <?php endforeach; endif; wp_reset_postdata(); /* post_objects */?>

    </div>
    <!-- .matrix-border -->

</div>
<!-- #videos -->

<?php endif; /* featured_videos */ ?>