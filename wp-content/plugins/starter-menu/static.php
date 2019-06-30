                        <nav class="nav mt-auto justify-content-end" role="navigation">


                            <!-- Sean, example of a nav-item with more than one sub menu -->

                            <!-- Notes: 1.) All '.nav-links' with '.dropdown' class need a role="button" attribute for screen reader accessibilty
                                        2.) We need to generate an id based on the title with 'nav-' prepended - this is how 'aria-labelledby' works
                                        3.) If 'dropdown-menu' has two children (can we limit the user to not being able to add more than two?) 
                                            we need a child <div> with a '.d-lg-flex' class to wrap the cibling <ul> tags. 
                            -->

                            <div class="nav-item dropdown">

                                <a class="nav-link dropdown-toggle" href="#" id="nav-about-us" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="About Us" role="button">
                                    About Us
                                </a>

                                <div class="dropdown-menu" aria-labelledby="nav-about-us">

                                    <div class="d-lg-flex">
                                    
                                        <ul class="extensible-list">
                                            <li class="leader">What We Do</li>
                                            <li><a href="#" title="Conservation">Conservation</a></li>
                                            <li><a href="#" title="Research">Research</a></li>
                                            <li><a href="#" title="Education">Education</a></li>
                                            <li><a href="#" title="International Cheetah Day">International Cheetah Day</a></li>
                                        </ul>

                                        <ul class="extensible-list">
                                            <li class="leader">Who We Are</li>
                                            <li><a href="#" title="Mission and Vision">Mission and Vision</a></li>
                                            <li><a href="#" title="Dr. Laurie Marker">Dr. Laurie Marker</a></li>
                                            <li><a href="#" title="Our Centre">Our Centre</a></li>
                                            <li><a href="#" title="Staff and Board">Staff and Board</a></li>
                                        </ul>

                                    </div>
                                    <!-- .d-lg-flex -->

                                </div>

                            </div>
                            <!-- .nav-item -->

                            <!-- Sean, example of a nav-item with one sub menu -->

                            <div class="nav-item dropdown">

                                <a class="nav-link dropdown-toggle" href="#" id="nav-get-involved" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Nav Item" role="button">
                                    Get Involved
                                </a>

                                <div class="dropdown-menu" aria-labelledby="nav-get-involved">

                                    <ul class="extensible-list">
                                        <li><a href="#" title="Ways to Give">Ways to Give</a></li>
                                        <li><a href="#" title="CCF Events">CCF Events</a></li>
                                        <li><a href="#" title="Volunteer">Volunteer</a></li>
                                        <li><a href="#" title="Visit CCF">Visit CCF</a></li>
                                    </ul>

                                </div>

                            </div>
                            <!-- .nav-item -->
                            
                            <div class="nav-item dropdown">

                                <a class="nav-link dropdown-toggle" href="#" id="nav-learn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Nav Item" role="button">
                                    Learn
                                </a>

                                <div class="dropdown-menu" aria-labelledby="nav-learn">

                                    <ul class="extensible-list">
                                        <li><a href="#" title="Resource Library">Resource Library</a></li>
                                        <li><a href="#" title="About Cheetahs">About Cheetahs</a></li>
                                        <li><a href="#" title="Human Wildlife Conflict">Human Wildlife Conflict</a></li>
                                        <li><a href="#" title="Illegal Pet Trade">Illegal Pet Trade</a></li>
                                        <li><a href="#" title="Habitat Loss">Habitat Loss</a></li>
                                        <li><a href="#" title="CCF Videos">CCF Videos</a></li>
                                    </ul>

                                </div>

                            </div>
                            <!-- .nav-item -->

                            <div class="nav-item dropdown">

                                <a class="nav-link dropdown-toggle" href="#" id="nav-news" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Nav Item" role="button">
                                    News
                                </a>

                                <div class="dropdown-menu" aria-labelledby="nav-news">

                                    <ul class="extensible-list">
                                        <li><a href="#" title="CCF Blog">CCF Blog</a></li>
                                        <li><a href="#" title="Cheetah Strides">Cheetah Strides</a></li>
                                        <li><a href="#" title="Press Releases">Press Releases</a></li>
                                    </ul>

                                </div>

                            </div>
                            <!-- .nav-item -->

                            <!-- Sean, example of a nav-item without a sub menu -->

                            <div class="nav-item">

                                <a class="nav-link" href="#" id="nav-news" title="Nav Item">
                                    No Dropdown
                                </a>

                            </div>
                            <!-- .nav-item -->

                            <div class="nav-item d-none d-lg-block">
                                <a class="nav-link bg-primary" href="/donate" title="Nav Item">
                                    Donate
                                </a>
                            </div>

                        </nav>