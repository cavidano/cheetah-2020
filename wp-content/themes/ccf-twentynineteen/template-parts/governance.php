<?php if (have_rows('governance_list_group')):

$all_rows = count(get_field('governance_list_group'));
    $count = 1;

?>

    <div class="narrow my-5">

    <?php while ( have_rows('governance_list_group') ): the_row();
                
    $header = get_sub_field('header');

    ?>

    <div class="my-4">

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
    <!-- .my-4 -->

    <?php if ( $count < $all_rows) : ?>
    <hr class="narrow my-4">
    <?php endif; ?>
    
    <?php $count++; endwhile; /* governance_list_group */ ?>

<?php endif; /* governance_list_group */ ?>