/**
 * Created by vincent racine on 11/09/15.
 */
$(function(){

    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = decodeURIComponent(window.location.search.substring(1)),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : sParameterName[1];
            }
        }
    };

    $('.selectpicker').selectpicker({
        style: 'btn btn-lg btn-grey'
    });

    var $results = $('#results');
    var template = document.getElementById('partial-search-item').innerHTML;

    var range = 40;
    var location = 'Reading';
    var coords = LocationEngine.getLatLng({
        address: location,
        async: false
    });

    var onSuccess = function(data){
        try{
            $results.empty();
            $results.mixItUp('destroy');
        }catch(e){}

        // Limit number of adverts
        if(data.length == 0){
            $results.append('<div class="col-xs-12"><p>No results found.</p><br></div>');
            $results.mixItUp();
            return;
        }
        if(data.length > 20){
            data = data.slice(0,20);
        }

        $.each(data,function(key,val){
            var model = {
                id: val.id,
                title: val.title,
                excerpt: val.excerpt,
                distance: LocationEngine.getDistance(coords.lng,coords.lat,val.lng,val.lat),
                logo: val.logo
            };
            $results.append(Mustache.render(template,model));
        });
        $results.mixItUp();
    };

    $('#location').editable({
        value: location,
        type: 'text',
        url: 'api/advert',
        title: 'Enter location',
        name: 'location',
        send: 'never',
        mode: 'inline',
        success: function(obj,value){
            // Change search location

            var newLocation = LocationEngine.getLatLng({
                address: value,
                async: false
            });

            location = value;
            coords = newLocation;

            console.log(newLocation);

            $.ajax({
                method: 'GET',
                url: 'api/advert',
                data: {
                    within: $('#range').text(),
                    near: newLocation.lat +','+newLocation.lng
                },
                dataType: "json",
                success: onSuccess,
                error: function(err){
                    console.warn(err);
                }
            });
        }
    }).find('+ .icon').remove();

    $('#range').editable({
        value: range,
        type: 'text',
        title: 'Enter range',
        name: 'range',
        send: 'never',
        mode: 'inline',
        validate: function(value) {
            if(!$.isNumeric(value)) {
                return 'Please enter a number!';
            }
        },
        success: function(obj,value){
            range = value;
            $.ajax({
                method: 'GET',
                url: 'api/advert',
                data: {
                    within: value,
                    near: coords.lat +','+ coords.lng
                },
                dataType: "json",
                success: onSuccess,
                error: function(err){
                    console.warn(err);
                }
            });
        }
    }).find('+ .icon').remove();

    // Get initial search results
    $.ajax({
        method: 'GET',
        url: 'api/advert',
        data: {
            within: range,
            near: coords.lat + ',' + coords.lng,
            query: getUrlParameter('query'),
            type: getUrlParameter('type')
        },
        dataType: "json",
        success: onSuccess,
        error: function(err){
            console.warn(err);
        }
    });

});