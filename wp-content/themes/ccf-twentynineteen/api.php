                <script type="text/javascript">
                  jQuery(document).ready(function(){
                    var page = 1;
                    checkForMoreMonths = function(page){
                      var url = '/wp-json/wp/v2/kidartists?_embed&page=' + page;
                      jQuery.ajax({
                        type: 'GET',
                        url: url,
                        success: function(data){
                          // jQuery('.loadMore').fadeIn();
                        }
                      });
                    };
                    loadArtist = function(){
                      jQuery('.loadMore').fadeOut();
                      var url = '/wp-json/wp/v2/kidartists?_embed&per_page=1&page=' + page;
                          // count = 0;
                      jQuery.ajax({
                        type: 'GET',
                        url: url,
                        success: function(data){
                          jQuery(data).each(function(){
                            title = this.title.rendered;
                            featuredImage = this._embedded['wp:featuredmedia'][0].source_url;
                            featuredImageAlt = this._embedded['wp:featuredmedia'][0].alt_text;
                            featuredImageCaption = this._embedded['wp:featuredmedia'][0].caption.rendered;
                            jQuery('#kidartists-title').html(title);
                            jQuery('#kidartists-featured-image-link').prop('href',featuredImage);
                            jQuery('#kidartists-featured-image-link').prop('title',featuredImageAlt);
                            jQuery('#kidartists-featured-image-link').data('footer',featuredImageAlt);
                            jQuery('#kidartists-featured-image-caption').html(featuredImageCaption);
                            jQuery('#kidartists-featured-image').prop('src',featuredImage);
                            jQuery('#kidartists-featured-image').prop('alt',featuredImageAlt);
                            // jQuery('.projects .tile').fadeIn();
                            // count++
                          });
                          page++;
                          checkForMoreMonths(page);
                        }
                      });
                    }
                    loadArtist();
                    jQuery('.loadMore').click(function(){
                      loadArtist();
                    });
                  });
                </script>