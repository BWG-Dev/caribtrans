(function(window, $) {
    "use strict";

    function MapHandler(){
        var self = this;

        self.init();
    }

    MapHandler.prototype = {

        init: function () {
            var self = this;
            window.map = null;
            var locations = [];
            window.markers = null;


            this.initMap();


            $('.ct_accordion_header').on('click', function(){
                var id = $(this).data('id');
                $('#location--' + id + ' .data').toggle('slow');
                var $icon = $(this).find('i');

                if( $icon.hasClass('fa-angle-down') ){
                    $icon.removeClass('fa-angle-down').addClass('fa-angle-up');
                }else{
                    $icon.removeClass('fa-angle-up').addClass('fa-angle-down');
                }

            });

            $('.location-filter').on('click', function(){
                window.Mpl.MapHandler.getLocations();
            });


        },
        initMap(){

            var self = this;

            window.map = new L.map('map').setView([25.6070068, -80.6934588], 4);

            window.markers = L.layerGroup().addTo(window.map);



            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 15,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(window.map);


            this.getLocations();


        },
        getLocations(){
            //var self = this;

           // var $result_wrapper = $('#location-wrapper-result');

            if (window.xhr) { // if any previous ajaxRequest is running, abort
                window.xhr.abort();
            }


            window.xhr = $.ajax({
                type: 'POST',
                url: parameters.ajax_url,
                data: {
                    'action': 'get_locations',
                    'destination': $('#destinations-filter').is(':checked') ? 1 : 0,
                    'receiving': $('#receiving-filter').is(':checked') ? 1 : 0,
                },
                dataType: "json",
                beforeSend: function () {
                   // $result_wrapper.empty().append('<p>Loading...</p>');
                },
                complete: function () {

                },
                success: function (response) {
                    if( response.success ) {

                        let locations = response.locations;

                        window.markers.clearLayers();
                        window.map.invalidateSize();

                        if(locations.length > 0 ){

                            for(var i = 0; i< locations.length; i++){
                                var location = locations[i].info;

                                var icon_url = '/wp-content/uploads/2024/05/receiving.png';
                                if( locations[i].type === 'destination' ){
                                    icon_url = '/wp-content/uploads/2024/05/destination.png';
                                }

                                var leafletIcon = L.icon({
                                    iconUrl: icon_url,
                                    iconSize: [28,28],
                                    iconAnchor: [28,28]
                                })

                                if( location.lat != '' && location.lng != ''){
                                    var marker = L.marker([location.lat, location.lng], {icon : leafletIcon});

                                    (function(index) {
                                        marker.on('click', e => {
                                            $('html, body').animate({

                                                scrollTop: $("#location--" + locations[index].ID).offset().top - 100
                                            }, 500);
                                        });

                                    })(i);



                                    marker.addTo(window.markers);
                                    //marker.bindPopup('<strong>'+location.post_title+'</strong><br><a href="'+location.guid+'">Visit Location</a>').openPopup();
                                   // marker.addTo(window.map);
                                }

                            }
                        }


                    }else{
                        //$result_wrapper.empty();
                    }
                },
                error: function (jqXHR, exception) {
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.\n Verify Network.';
                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                    } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                    }
                }

            });
        }
    }



    window.Mpl = window.Mpl || {};
    window.Mpl.MapHandler = new MapHandler();


})(window, window.jQuery);


