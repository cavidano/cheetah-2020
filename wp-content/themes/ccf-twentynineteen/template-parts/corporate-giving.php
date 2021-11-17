
<?php if (have_rows('top_tier1')): 

    while (have_rows('top_tier1')): the_row();
        
    $headline = get_sub_field('headline');
    $description = get_sub_field('description');
    
    ?>

    <section class="my-4">

        <header class="narrow">
            <h2><?php echo $headline; ?></h2>
            <p><?php echo $description; ?></p>
        </header>
        
        <?php if (have_rows('donor')): ?>

        <div class="medium my-3">
        
            <div class="row matrix-gutter my-3">
            
            <?php while (have_rows('donor')): the_row();

            $logo = get_sub_field('logo');
            $name = get_sub_field('name');
            $link = get_sub_field('link');

            ?>

            <div class="col-6">

                <div class="card partner h-100 bg-white border text-white">

                    <?php if ($logo): ?>
                        <img class="card-img" src="<?php echo $logo['url']; ?>" alt="<?php echo $logo['alt']; ?>">
                    <?php else : ?>
                        <img class="card-img" src="https://via.placeholder.com/500x500" alt="Placeholder">
                    <?php endif; ?>

                    <div class="card-img-overlay bg-opacity-black-75 d-flex">

                        <div class="align-self-center w-100 fs-md text-center text-white text-shadow">
                            <p class="card-title font-weight-bold f-sans-serif"><?php echo $name; ?></p>
                            
                            <?php if ($link) : ?>
                            <a class="stretched-link link text-primary" href="<?php echo $link['url']; ?>" <?php if($link['target']) : ?>target="<?php echo $link['target'] ?>"<?php endif; ?>><?php echo $link['title']; ?></a>
                            <?php endif; ?>
                        
                        </div>
                        <!-- .align-self-center -->

                    </div>

                </div>
                <!-- .card -->

            </div>
            <!-- .col -->

            <?php endwhile; ?>

        </div>
        <!-- .my-4 -->

        <?php endif; ?>

    </section>

    <hr class="narrow my-4">
    
<?php endwhile; endif; /* top_tier1 */ ?>

<?php if (have_rows('top_tier')): 

    while (have_rows('top_tier')): the_row();
        
    $headline = get_sub_field('headline');
    $description = get_sub_field('description');
    
    ?>

    <section class="my-4">

        <header class="narrow">
            <h2><?php echo $headline; ?></h2>
            <p><?php echo $description; ?></p>
        </header>
        
        <?php if (have_rows('donor')): ?>

        <div class="medium my-3">
        
            <div class="row matrix-gutter my-3">
            
            <?php while (have_rows('donor')): the_row();

            $logo = get_sub_field('logo');
            $name = get_sub_field('name');
            $link = get_sub_field('link');

            ?>

            <div class="col-4">

                <div class="card partner h-100 bg-white border text-white">

                    <?php if ($logo): ?>
                        <img class="card-img" src="<?php echo $logo['url']; ?>" alt="<?php echo $logo['alt']; ?>">
                    <?php else : ?>
                        <img class="card-img" src="https://via.placeholder.com/250x250" alt="Placeholder">
                    <?php endif; ?>

                    <div class="card-img-overlay bg-opacity-black-75 d-flex">

                        <div class="align-self-center w-100 fs-md text-center text-white text-shadow">
                            <p class="card-title font-weight-bold f-sans-serif"><?php echo $name; ?></p>
                            
                            <?php if ($link) : ?>
                            <a class="stretched-link link text-primary" href="<?php echo $link['url']; ?>" <?php if($link['target']) : ?>target="<?php echo $link['target'] ?>"<?php endif; ?>><?php echo $link['title']; ?></a>
                            <?php endif; ?>
                        
                        </div>
                        <!-- .align-self-center -->

                    </div>

                </div>
                <!-- .card -->

            </div>
            <!-- .col -->

            <?php endwhile; ?>

        </div>
        <!-- .my-4 -->

        <?php endif; ?>

    </section>

    <hr class="narrow my-4">
    
<?php endwhile; endif; /* top_tier */ ?>

<?php if (have_rows('middle_tier')):

    while (have_rows('middle_tier')): the_row();
        
    $headline = get_sub_field('headline');
    $description = get_sub_field('description');
    
    ?>

    <section class="my-4">

        <header class="narrow">
            <h2><?php echo $headline; ?></h2>
            <p><?php echo $description; ?></p>
        </header>
        
        <?php if (have_rows('donor')): ?>

        <div class="narrow my-3">
        
            <?php while (have_rows('donor')): the_row();

            $name = get_sub_field('name');
            $link = get_sub_field('link');

            ?>

            <dl class="row justify-content-between border-top py-2 mb-0 fs-md">

                <dt class="col-md">
                    <?php echo $name; ?>
                </dt>

                <dd class="col-md-auto">
                    <a href="<?php echo $link['url']; ?>" <?php if($link['target']) : ?>target="<?php echo $link['target'] ?>"<?php endif; ?>><?php echo $link['title']; ?></a>
                </dd>

            </dl>

            <?php endwhile; ?>

        <?php endif; ?>

    </section>

    <hr class="narrow my-4">
    
<?php endwhile; endif; /* middle_tier */ ?>

<?php if (have_rows('lower_tier')):

    while (have_rows('lower_tier')): the_row();
        
    $headline = get_sub_field('headline');
    $description = get_sub_field('description');
    
    ?>

    <section class="my-4">

        <header class="narrow">
            <h2><?php echo $headline; ?></h2>
            <p><?php echo $description; ?></p>
        </header>
        
        <?php if (have_rows('donor')): ?>

        <div class="narrow my-3">
        
            <?php while (have_rows('donor')): the_row();

            $name = get_sub_field('name');

            ?>

            <dl class="row justify-content-between border-top py-2 mb-0 fs-md">

                <dt class="col-md">
                    <?php echo $name; ?>
                </dt>

            </dl>

            <?php endwhile; ?>

        <?php endif; ?>

    </section>
    
<?php endwhile; endif; /* lower_tier */ ?>