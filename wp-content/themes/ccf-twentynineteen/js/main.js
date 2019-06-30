jQuery(document).ready(function ($) {

    ////////////////////////////////////////
    // Primary Navigation Dropdowns
    ////////////////////////////////////////

    var header_drop_downs = $('#primary-navigation-desktop ul > li');

    function sub_nav_hover_on() {
        if ($(this).find('ul.sub').length) {
            $(this).addClass('active');
            $(this).find('ul.sub').addClass('active');
        } else {
            return;
        }
    }

    function sub_nav_hover_off() {
        if ($(this).find('ul.sub').length) {
            $(this).removeClass('active');
            $(this).find('ul.sub').removeClass('active');
        } else {
            return;
        }
    }

    ////////////////////////////////////////
    // Lightbox
    ////////////////////////////////////////
    
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

    ////////////////////////////////////////
    // Mutation observer - watch for RTL
    ////////////////////////////////////////

    var target = document.querySelector('html');

    var observer = new MutationObserver( function(mutations) {
        mutations.forEach( function() {
            var classes = target.getAttribute('class');
            var single_class = 'translated-rtl';
            if (classes.includes(single_class)) {
                target.setAttribute('dir', 'rtl');
            } else {
                target.setAttribute('dir', 'ltr');
            }
        });
    });

    var config = {
        attributes: true,
        attributeFilter: ['class']
    };

    observer.observe(target, config);

    ////////////////////////////////////////
    // News filter selects
    ////////////////////////////////////////

    $('.news-filter').change(function() {

        var categoryID = $('#topics').find(':selected').data('category-id'),
            year = $('#years').find(':selected').data('year'),
            yearCategoryID = $('#years').data('category-id'),
            authorID = $('#authors').find(':selected').data('author-id'),
            allCategoryIDs = [];

        $('#topics option').each(function(){
            id = $(this).data('category-id');
            if (id) {
                allCategoryIDs.push(id);
            }
        });

        if (yearCategoryID) {
            allCategoryIDs.push(yearCategoryID);            
        }

        allCategoryIDs.join(',');

        url = '/wp-json/wp/v2/posts/?_embed&categories=' + allCategoryIDs;

        if (categoryID) {
            url = '/wp-json/wp/v2/posts/?_embed&categories=' + categoryID;
        }
        if (year) {
            url = '/wp-json/wp/v2/posts/?_embed&after=' + year +'-01-01T00:00:00Z&before=' + year + '-12-31T23:59:59Z&categories=' + yearCategoryID;
        }
        if (authorID) {
            url = url + '&author=' + authorID;
        }

        $.ajax({
            type: 'GET',
            url: url,
            success: function(data){
                $('.posts').fadeOut('fast',function(){

                    $('.posts').html('');
                    $('.featured').html('');
                    $('.pagination').html('');

                    const monthNames = ["January", "February", "March", "April", "May", "June",
                      "July", "August", "September", "October", "November", "December"
                    ];

                    if (!$.isEmptyObject(data)) {
                        $(data).each(function(){
                            title = this.title.rendered;
                            link = this.link;
                            image = '';
                            alt = '';
                            const date = new Date(this.date);
                            month = monthNames[date.getMonth()];
                            day = date.getDate();
                            year = date.getFullYear();
                            completeDate = month + ' ' + day + ', ' + year;
                            if (this._embedded['wp:featuredmedia']) {
                                image = this._embedded['wp:featuredmedia'][0].media_details.sizes.full.source_url;                                
                                alt = this._embedded['wp:featuredmedia'][0].alt_text;
                            }
                            category = this._embedded['wp:term'][0][0].name;
                            string = '<div class="col-lg-4 mb-3"><a class="featured-article" href="' + link + '" title="' + title + '"><div><span>' + completeDate + '</span><img class="w-100" src="' + image + '" alt="' + alt + '>"></div><p class="h5">' + title + '</p></a></div>';
                            $('.posts').append(string);
                        });
                    }
                    
                    else {
                        string = '<div class="row align-items-center mb-3"><div class="col-lg-12 mb-3 mb-lg-0">Sorry, there are no news items that match your criteria.<!-- .col --></div></div>';
                        $('.posts').append(string);
                    }
                });

                $('.posts').fadeIn('fast');
            }
        });
    });

    ////////////////////////////////////////
    // Modals
    ////////////////////////////////////////

    $('div[role="dialog"]').each(function () {

        var currentModal = $(this);

        // Next
        currentModal.find('.btn-next').click(function () {
            currentModal.modal('hide');
            currentModal.closest('div[role="dialog"]').nextAll('div[role="dialog"]').first().modal('show');
        });

        // Previous
        currentModal.find('.btn-prev').click(function () {
            currentModal.modal('hide');
            currentModal.closest('div[role="dialog"]').prevAll('div[role="dialog"]').first().modal('show');
        });

    });

    ////////////////////////////////////////
    // Topic and Author Toggles
    ////////////////////////////////////////

    $('#all-topics').on('show.bs.collapse', function () {
        $('#all-authors').collapse('hide');
    });

    $('#all-authors').on('show.bs.collapse', function () {
        $('#all-topics').collapse('hide');
    });


    ////////////////////////////////////////
    // Accordion Scroll to Top
    ////////////////////////////////////////

    $('.collapse[role="tabpanel"]').on('shown.bs.collapse', function () {

        var $panel = $(this).closest('.card');

        $('html, body').animate({
            scrollTop: $panel.offset().top
        }, 500);
    })

}); // end document ready