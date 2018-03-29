    /*
 * Learning Google Maps Geocoding by example
 * Miguel Marnoto
 * 2015 - en.marnoto.com
 *
 */

    var map;
    var marker;
    

    function initialize() {

    var val =  document.getElementById('address-input');
      if(val)
      {
       var add = document.getElementById('address-input').value; 
       map = new google.maps.Map(document.getElementById("map-canvas"));
       console.log(add)

      
        localStorage.setItem("address", add);

        var addressInput =localStorage.getItem("address");

        var geocoder = new google.maps.Geocoder();

        geocoder.geocode({address: addressInput}, function(results, status) {

            if (status == google.maps.GeocoderStatus.OK) {

          var myResult = results[0].geometry.location;

          createMarker(myResult);

          map.setCenter(myResult);

          map.setZoom(15);
            }
        });
      }

    }

    google.maps.event.addDomListener(window, 'load', initialize);


        
    

    function createMarker(latlng) {

      if(marker != undefined && marker != ''){
        marker.setMap(null);
        marker = '';
      }

      marker = new google.maps.Marker({
        map: map,
        position: latlng
      });
    }

   