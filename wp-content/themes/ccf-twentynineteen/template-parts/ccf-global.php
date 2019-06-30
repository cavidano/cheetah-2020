<div class="my-5 mx-n2">

    <figure class="w-100">

        <div class="figure-info">
            <div id="map-affiliates"></div>
        </div>

        <div class="container py-1">
            <div class="narrow">
                <figcaption>

                    <ul class="extensible-list horizontal responsive-sm mb-0">
                        <li>
                            <span class="fas fas fa-circle office"></span>
                            <span class="mx-1">Headquarters</span> 
                        </li>
                        <li>
                            <span class="fas fas fa-circle affiliate"></span>
                            <span class="mx-1">Affiliates</span> 
                        </li>
                        <li class="d-none">
                            <span class="fas fas fa-circle chapter"></span>
                            <span class="mx-1">Chapters</span> 
                        </li>
                        <li>
                            <span class="fas fas fa-circle partner-organization"></span>
                            <span class="mx-1">Partner Organisations</span> 
                        </li>
                    </ul>
   
                    <span class="d-block fs-sm">
                        <em>
                        Map tiles by
                        <a href="http://stamen.com/" target="_blank">Stamen Design</a>, under
                        <a href="http://creativecommons.org/licenses/by/3.0" target="_blank">CC BY 3.0</a>.
                        Data by
                        <a href="http://openstreetmap.org" target="_blank">OpenStreetMap</a>, under
                        <a href="http://www.openstreetmap.org/copyright" target="_blank">ODbL</a>
                        </em>
                    </span>

                </figcaption>
            </div>
        </div>

    </figure>
</div>
<!-- .mx-n2 -->

<?php if( have_rows('ccf_global_list') ):

    $map_locations = array();

    while ( have_rows('ccf_global_list') ) : the_row();
    
    $headline = get_sub_field('headline');
    
    ?>

    <section class="narrow mb-5 mb-xl-6 bg-dangere">

        <h1 class="display-4 font-weight-light text-muted mb-4"><?php echo $headline; ?></h2>

        <?php if( have_rows('section') ): while( have_rows('section') ): the_row();

        $title = get_sub_field('title');
        $city = get_sub_field('city');
        $description = get_sub_field('description');

        $map_icon = get_sub_field('map_icon');
        $popup_info = get_sub_field('popup_info');

        $latitude = get_sub_field('latitude');
        $longitude = get_sub_field('longitude');

        $id = strtolower($title);
        $id = preg_replace("/[^a-z0-9_\s-]/", "", $id);
        $id = preg_replace("/[\s-]+/", " ", $id);
        $id = preg_replace("/[\s_]/", "-", $id);

        $map_location = array();
        $map_location['id'] = $id;
        $map_location['title'] = $title;
        $map_location['icon'] = $map_icon;

        $map_location['city'] = $city;

        $map_location['popupText'] = $popup_info;
        $map_location['latitude'] = $latitude;
        $map_location['longitude'] = $longitude;
        array_push($map_locations, $map_location);
        
        ?>

        <section class="mb-5 mb-xl-6" <?php if($id !== '') echo 'id="' . $id . '"' ?>>

            <h2><?php echo $title; ?></h2>

            <?php if($city) : ?>
            <p class="f-sans-serif text-muted"><?php echo $city; ?></p>
            <?php endif; ?>
            
            <p><?php echo $description; ?></p>

            <?php if( have_rows('details') ): ?>

            <div class="my-4 border-bottom">
                    
            <?php while( have_rows('details') ): the_row();

            $type = get_sub_field('type');
            $title = get_sub_field('title');
            $text = get_sub_field('text');
            $link = get_sub_field('link');

            ?>
        
                <dl class="row no-gutters justify-content-between border-top py-2 mb-0 fs-md">

                    <dt class="col-sm-auto">
                        <?php echo $title; ?>
                    </dt>

                    <?php if ( $type == 'Static Text' ) : ?>
                    
                    <dd class="col-sm-auto">
                        <?php echo $text; ?>
                    </dd>

                    <?php elseif ( $type == 'Link' ) : ?>

                    <dd class="col-sm-auto">
                        <a href="<?php echo $link['url']; ?>" <?php if($link['target']) : ?>target="<?php echo $link['target'] ?>"<?php endif; ?>><?php echo $link['title']; ?></a>
                    </dd>

                    <?php endif; ?>
                </dl>

            <?php endwhile; ?>

            </div>
            <!-- .my-5 -->

            <?php endif; /* details */ ?>

        </section>
        <!-- affiliate -->

        <?php endwhile; endif; /* section */ ?>

    </section>
    <!-- .narrow -->

<?php endwhile; endif; /* ccf_global_content */ ?>

<?php wp_localize_script('ccf-global-map', 'map_locations', $map_locations); ?>