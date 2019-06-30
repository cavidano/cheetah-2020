<?php if (have_rows('executive_staff')): while (have_rows('executive_staff')): the_row();

$header = get_sub_field('header');
$bio = get_sub_field('bio');

?>

<div class="bg-light overflow-hidden p-2 mx-n2">

    <div class="narrow my-5">

        <h2 class="display-4 font-weight-light mb-3"><?php echo $header; ?></h2>

        <?php if (have_rows('bio')): while (have_rows('bio')): the_row();

        $avatar = get_sub_field('avatar');
        $name = get_sub_field('name');
        $title = get_sub_field('title');
        $link = get_sub_field('link');
        $start_year = get_sub_field('start_year');

        ?>

        <div class="row align-items-center my-3">

            <div class="col-4">
                <img class="rounded-circle" src="<?php echo $avatar['url']; ?>" alt="<?php echo $avatar['alt']; ?>">
            </div>
            <!-- .col -->
        
            <div class="col-8">
                <h3 class="h5 mb-0"><?php echo $name; ?></h3>
                
                <?php if($title): ?>
                <p class="mb-0">
                    <?php echo $title; ?>
                </p>
                <?php endif; ?>

                <?php if ($link): ?>
                <p>
                    <a href="<?php echo $link['url'] ?>" <?php if($link['target']) : ?>target="<?php echo $link['target'] ?>"<?php endif; ?> <?php echo $link['title'] ?>><?php echo $link['title'] ?></a>
                </p>
                
                <?php endif; ?>
                
                <?php if ($start_year): ?>
                <p class="mb-0">
                    <em><?php echo $start_year; ?> - Present</em>
                </p>
                <?php endif; ?>

            </div>
            <!-- .col -->
        </div>
        <!-- .row -->

        <?php endwhile; endif; /* bio */ ?>

    </div>
    <!-- .narrow -->

</div>
<!-- .bg-light -->

<?php endwhile; endif; /* executive_staff */ ?>

<?php if ( have_rows('staff_by_country') ): ?>
    
    <div class="medium my-5">
    
        <div class="nav nav-pills border device-md" role="tablist">

        <?php while ( have_rows('staff_by_country') ): the_row();
        
		$country = get_sub_field('country');
		$append_id = str_replace(' ', '-', strtolower($country));
        
        ?>

        <a  class="nav-item nav-link flex-fill <?php if(get_row_index() == 1): ?>active<?php endif; ?>" 
            id="tab-btn-<?php echo $append_id; ?>" 
            href="#tab-<?php echo $append_id; ?>"
            data-toggle="pill" 
            aria-controls="tab-<?php echo $append_id; ?>" 

            <?php if(get_row_index() == 1): ?>
            aria-selected="true"
            <?php else: ?>
            aria-selected="false"
            <?php endif; ?>

            role="tab">
            <?php echo $country; ?>
        </a>

        <?php endwhile; /* staff_by_country */ ?>

        </div>
        <!-- .nav -->

	</div>
    <!-- .medium -->

    <div class="tab-content narrow">

        <?php while ( have_rows('staff_by_country') ): the_row(); 
        
        $country = get_sub_field('country');
        $append_id = str_replace(' ', '-', strtolower($country));

        ?>

        <div    class="tab-pane fade show <?php if (get_row_index() == 1): ?>active<?php endif; ?>"
                id="tab-<?php echo $append_id; ?>"
                aria-labelledby="tab-btn<?php echo $append_id; ?>"
                role="tabpanel">
        
            <h2 class="display-4 font-weight-light text-muted mb-3"><?php echo $country; ?> Staff</h2>

            <?php if (have_rows('staff_list_group')): ?>

            <?php while (have_rows('staff_list_group')): the_row();
            
            $header = get_sub_field('header');

            ?>

                <div class="my-3">
                
                    <?php if ($header): ?>
                    <h3 class="h2">
                        <?php echo $header; ?>
                    </h3>
                    <?php endif; ?>

                    <ul class="extensible-list staff-list my-2">

                        <?php if (have_rows('staff_person')): while (have_rows('staff_person')): the_row();

                        $name = get_sub_field('name');
                        $title = get_sub_field('title');
                        $start_year = get_sub_field('start_year');

                        ?>

                        <li class="mb-2">

                            <?php if ($name): ?>
                            <h4><?php echo $name; ?></h4>
                            <?php endif; ?>

                            <?php if ($title): ?>
                            <p><?php echo $title; ?></p>
                            <?php endif; ?>

                            <?php if ($start_year): ?>
                            <p><em><?php echo $start_year; ?> - Present</em></p>
                            <?php endif; ?>

                        </li>

                         <?php endwhile; endif; /* staff_person */ ?>

                    </ul>

                </div>
                <!-- .my-3 -->

            <?php endwhile; /* staff_list_group */ ?>
            
            <?php endif; /* staff_list_group */ ?>

        </div>
        <!-- .tab-pane -->

        <?php endwhile; /* staff_by_country */ ?>

    </div>
    <!-- .tab-content -->


<?php endif; /* staff_by_country */ ?>



