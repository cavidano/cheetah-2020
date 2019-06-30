jQuery(function ($) {

    // Initialize the map 
    
    var map = L.map('map-affiliates', {
        center: [0, 0],
        zoom: 1,
        minZoom: 1,
        maxZoom: 8,
        zoomSnap: 0.25,
        zoomDelta: 0.5,
        scrollWheelZoom: false,
        zoomControl: false,
        attributionControl: false,
    });

    L.tileLayer.provider('Stamen.Watercolor').addTo(map);

    // Create custom pin
    var Icon = L.Icon.extend({
        options: {
            iconSize: [50, 50],
            iconAnchor: [25, 50],
        }
    });

    var myPath = path.templateUrl;
    
    var officeIcon = new Icon({ iconUrl: myPath + '/images/map-flag.svg'} );
    var affiliateIcon = new Icon({ iconUrl: myPath + '/images/map-flag-affiliate.svg'} ); 
    var chapterIcon = new Icon({ iconUrl: myPath + '/images/map-flag-chapter.svg'} ); 
    var partnerIcon = new Icon({ iconUrl: myPath + '/images/map-flag-partner.svg'} );    

    // Custom popup options 
    var markerOptions = {
        riseOnHover: true, 
        icon: Icon
    };

    // Custom popup options 
    var popupOptions = {
        maxWidth: 300,
        className: 'rounded-0',
        closeButton: false
    };

    L.control.zoom({
        position:'bottomleft',
        zoomInText: '<span class="fas fa-plus"></span>',
        zoomOutText: '<span class="fas fa-minus"></span>'
    }).addTo(map);

    affiliates = [];

    $(map_locations).each(function(){
      id = this.id;
      title = this.title;
      selectedIcon = this.icon;
      city = this.city;
      text = this.popupText;
      latitude = this.latitude;
      longitude = this.longitude;

      if (this.icon == 'officeIcon') {
        selectedIcon = officeIcon;
        locationType = 'Headquarters';
      }
      if (this.icon == 'affiliateIcon') {
        selectedIcon = affiliateIcon;
        locationType = 'Affiliate';
      }
      if (this.icon == 'chapterIcon') {
        selectedIcon = chapterIcon;
        locationType = 'Chapter';
      }
      if (this.icon == 'partnerIcon') {
        selectedIcon = partnerIcon;
        locationType = 'Partner';
      }

      mapLocation = {
          'type': 'Feature',
          'properties': {
              'name': title,
              'popupContent':
                  '<p class="title"><a href="#' + id + '"><strong>' + title + '</strong></a></p>' +
                  '<p class="city">' + city + '</p>' +
                  '<p class="type">' + locationType + '</p>' +
                  '<p class="info">' + text + '</p>',
              icon: selectedIcon
          },
          'geometry': {
              'type': 'Point',
              'coordinates': [latitude, longitude]
          }
      };
      
      affiliates.push(mapLocation);

    });

    var addedGeoJSON = L.geoJSON(affiliates, {

        pointToLayer: function(geoJsonPoint, latlng) {
            return L.marker(latlng, markerOptions);
        },

        onEachFeature: function (feature, layer) {

            if (feature.properties && feature.properties.popupContent) {
                layer.bindPopup(feature.properties.popupContent, popupOptions);
            }

            if (feature.properties && feature.properties.icon) {
                layer.setIcon(feature.properties.icon);
            }

        }
        
    }).addTo(map);
    
    // Set zoom and Fit to bounds

    function setMapZoom() {

        var pad = 0;
        var bounds = addedGeoJSON.getBounds();
        var mapWidth = $('#map-affiliates').width();

        if (mapWidth > 400) {
            map.options.minZoom = 1.25;
        }

        if (mapWidth > 600) {
            pad = 30;
            map.options.minZoom = 1.5;
        }

        if(mapWidth > 800){
            map.options.minZoom = 2;
        }

        if(mapWidth > 1000){
            pad = 60;
            map.options.minZoom = 2.25;
        }

        if(mapWidth > 1200){
            map.options.minZoom = 2.5;
        }

        if(mapWidth > 1400){
            map.options.minZoom = 2.75;
        }

        if(mapWidth > 1600){
            map.options.minZoom = 3;
        }

        map.fitBounds(bounds, { padding: [pad, pad] });
    }

    setMapZoom();

    map.on('resize', function () {
        setMapZoom();
    });    

    // Smooth Scroll

    map.on('popupopen', function () {

        $('.leaflet-popup-content a[href*=\\#]').click(function () {
            if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') ||
                location.hostname === this.hostname) {

                var target = $(this.hash);
                var margin = 32;
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html,body').animate({
                        scrollTop: target.offset().top - margin
                    }, 800);
                    return false;
                }
            }
        });

    });

});
