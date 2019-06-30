<main>

    <article id="post-<?php the_id();?>" class="container-fluid">

    <div class="row">
        <div class="col-xl-3 bg-dark">

        </div>
        <!-- .col -->

        <div class="col-xl-9">
            
            <div class="pt-4 pt-xl-6">

                <header class="container narrow mb-5">
                    <p class="f-sans-serif fs-lg text-muted mb-0">CCF Blog</p>
                    <h1 class="display-3">
                        <?php the_title(); ?>
                    </h1>
                    <p>
                        <?php echo get_the_date(); ?>
                    </p>
                </header>

                <section>
                    <div class="mx-n2 bg-danger">

                    <figure class="mb-5 container px-0">
                        <?php if ( has_post_thumbnail() ) {
                            the_post_thumbnail( 'hero' );
                        } ?>
                    </figure>

                    </div>
                    <section class="entry-content">
                        <?php the_content(); ?>
                    </section>

                </section>

            </div>

        </div>
        <!-- .col -->

    </div>
    <!-- .row -->



    </article>

</main>