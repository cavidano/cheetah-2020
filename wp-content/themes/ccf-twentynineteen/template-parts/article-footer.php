<footer>

    <div class="container-fluid my-5">

        <div class="narrow text-center">

            <p class="f-sans-serif fs-md">
                <em>Share with friends</em>
            </p>

            <ul class="extensible-list horizontal justify-content-center">

              <?php global $wp; ?>

                <li>
                    <a href="http://www.facebook.com/sharer.php?u=<?php echo home_url($wp->request) ?>&t=Cheetah Conservation Fund" target="_blank" title="Share on Facebook">
                        <img class="rounded-circle" src="<?php echo get_template_directory_uri(); ?>/images/share-facebook.svg" alt="Share">
                    </a>
                </li>

                <li>
                    <a href="http://twitter.com/share?text=Cheetah Conservation Fund&url=<?php echo home_url($wp->request) ?>" target="_blank" title="Share on Twitter">
                        <img class="rounded-circle" src="<?php echo get_template_directory_uri(); ?>/images/share-twitter.svg" alt="Share">
                    </a>
                </li>
                <li>
                    <a href="mailto:?subject=Cheetah Conservation Fund&body=Check out <?php echo home_url($wp->request) ?>" target="_blank" title="Email a friend">
                        <img class="rounded-circle" src="<?php echo get_template_directory_uri(); ?>/images/share-email.svg" alt="Share">
                        </span>
                    </a>                
                </li>
            
            
            </ul>

        </div>

    </div>

</footer>