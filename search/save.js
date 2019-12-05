$(document).on('click','.save', function(e){ 
    alert("Item Saved");
    var id = e.currentTarget.id;
    $.ajax({
        async:false,
        url:'saves.php',
        type: 'get',
        data:{'rest_id':id},
        dataType: 'text',
        success: function(data){

            console.log(data);
        }
    
    
    });


})


$(document).on('click','.showmap', function(e){ 
    
    var id = e.currentTarget.id;

        function haversine_distance(mk1, mk2) {
            var R = 3958.8; // Radius of the Earth in miles
            var rlat1 = mk1.position.lat() * (Math.PI / 180); // Convert degrees to radians
            var rlat2 = mk2.position.lat() * (Math.PI / 180); // Convert degrees to radians
            var difflat = rlat2 - rlat1; // Radian difference (latitudes)
            var difflon = (mk2.position.lng() - mk1.position.lng()) * (Math.PI / 180); // Radian difference (longitudes)

            var d = 2 * R * Math.asin(Math.sqrt(Math.sin(difflat / 2) * Math.sin(difflat / 2) + Math.cos(rlat1) * Math.cos(rlat2) * Math.sin(difflon / 2) * Math.sin(difflon / 2)));
            return d;
        }
        function initMap() {
            var map;
            // The map, centered on Central Park
            const center = { lat: 36.8954387, lng: -76.3058324 };
            const options = { zoom: 10, scaleControl: true, center: center };
            map = new google.maps.Map(
                document.getElementById('map'), options);
            // Locations of landmarks

            const to = { lat: 36.7953409, lng: -76.2928175 };
            const from = { lat: 36.7953409 , lng:  -76.2928175};

            // The markers for The Dakota and The Frick Collection
            var mk1 = new google.maps.Marker({ position: to, map: map });
            var mk2 = new google.maps.Marker({ position: from, map: map });

            var line = new google.maps.Polyline({ path: [to, from], map: map });
            var distance = haversine_distance(mk1, mk2);
            document.getElementById('msg').innerHTML = "Distance between markers: " + distance.toFixed(2) + " mi.";
            var address = 'Norfolk';
            var geo = new google.maps.Geocoder;
            geo.geocode({ 'address': address }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    var myLatLng = results[0].geometry.location;

                    var long = document.getElementById('msg2'), myLatLng;

                } else {
                    alert("Geocode was not successful for the following reason: " + status);
                }
            });

        }
        initMap();

})