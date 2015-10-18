/**
 * Created by Vincent Racine on 12/09/15.
 */
window.LocationEngine = (function(window,$){

    /** Converts numeric degrees to radians */
    if (typeof(Number.prototype.toRad) === "undefined") {
        Number.prototype.toRad = function() {
            return this * Math.PI / 180;
        }
    }

    return {
        getBrowserLocation: function(params){
            if(navigator.geolocation){
                navigator.geolocation.getCurrentPosition(params.success,params.error);
            }else{
                console.warn("Geolocation is not supported by this browser.");
                params.error.call(this,'Geolocation is not supported by this browser.')
            }
        },
        getDistance: function(lng1, lat1, lng2, lat2) {

            var R = 6371; // Radius of the earth in km
            var dLat = (lat2-lat1).toRad();  // Javascript functions in radians
            var dLon = (lng2-lng1).toRad();
            var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.cos(lat1.toRad()) * Math.cos(lat2.toRad()) *
                Math.sin(dLon/2) * Math.sin(dLon/2);
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            var d = R * c; // Distance in km
            return d.toFixed(2);
        },
        getLatLng: function(params){

            var endpoint = 'http://maps.google.com/maps/api/geocode/json';
            var coords = null;
            var onSuccess = function(data){
                // Get coords from response
                coords = data.results[0].geometry.location;

                // Callback
                if($.isFunction(params.success)){
                    params.success.call(this,coords);
                }
            };
            var onError = function(e){};

            $.ajax({
                method: 'GET',
                url: endpoint,
                data: {
                    region: params.region || 'GB',
                    address: params.address
                },
                dataType: "json",
                async: params.hasOwnProperty('async') ? params.async : true,
                success: onSuccess,
                error: onError
            });
            return coords;
        },
        getRaw: function(params){
            var endpoint = 'http://maps.google.com/maps/api/geocode/json';
            var data = null;
            var onSuccess = function(e){
                // Get coords from response
                data = e;

                if(data.status == "ZERO_RESULTS"){
                    // Callback
                    if($.isFunction(params.error)){
                        params.error.call(this,data);
                    }
                }else{
                    // Callback
                    if($.isFunction(params.success)){
                        params.success.call(this,data);
                    }
                }
            };
            var onError = function(e){};

            $.ajax({
                method: 'GET',
                url: endpoint,
                data: {
                    region: params.region || 'GB',
                    address: params.address
                },
                dataType: "json",
                async: params.hasOwnProperty('async') ? params.async : true,
                success: onSuccess,
                error: onError
            });
            return data;
        },
        getLocationName: function(params){
            var endpoint = 'https://maps.googleapis.com/maps/api/geocode/json';
            var name = null;
            var onSuccess = function(data){
                // Get coords from response
                var arr = data.results[0]['address_components'];

                for(var i = 0; i < arr.length; i++){
                    if(arr[i].types[0] == "postal_town"){
                        name = arr[i].long_name;
                    }
                }

                if(!name){
                    name = 'Unknown';
                }

                // Callback
                if($.isFunction(params.success)){
                    params.success.call(this,name);
                }
            };
            var onError = function(e){};

            $.ajax({
                method: 'GET',
                url: endpoint,
                data: {
                    region: params.region || 'GB',
                    latlng: params.coords.latitude + ',' + params.coords.longitude
                },
                dataType: "json",
                async: params.hasOwnProperty('async') ? params.async : true,
                success: onSuccess,
                error: onError
            });
            return name;
        }
    };

})(window,jQuery);