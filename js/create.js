/**
 * Created by Vincent Racine on 21/09/15.
 */
$(function(){

    function getImageBase64(input,successCallback) {
        if ( input.files && input.files[0] ) {
            var FR = new FileReader();
            FR.onload = function(e) {
                if ($.isFunction(successCallback)){
                    successCallback.call(this, e.target.result);
                }
            };
            FR.readAsDataURL( input.files[0] );
        }
    }
    $('#logoInput').change(function(e){
        if(e.target.files.length > 0){
            getImageBase64(this,function(data){
                $('#logo').val(data);
            });
        }else{
            $('#logo').val('');
        }
    });
    $('#category').on('change',function(){
        var $promoCode = $('#promoCode').parent();
        switch(parseInt($(this).val())){
            case 2:
                $promoCode.fadeIn();
                break;
            default:
                $promoCode.fadeOut();
                break;
        }
    });

    $('#lookup-address').on('click',function(){
        var $postcode = $('#postcode'),
            $house = $('#houseId').val(),
            $address = $('#address'),
            $fullAddress = $('#full-address'),
            $latlng = $('#latlng');

        $postcode.parent().find('~ .text-danger').empty();

        if($postcode.val() != ''){
            LocationEngine.getRaw({
                address: $postcode.val(),
                success: function(data){
                    $address.val($house + ', ' + data.results[0].formatted_address);
                    $latlng.val(data.results[0].geometry.location.lat + ', ' + data.results[0].geometry.location.lng);
                    $fullAddress.hide().removeClass('hidden').fadeIn();
                },
                error: function(){
                    $postcode.parent().find('~ .text-danger').text('Failed to get full address. Please try again.');
                }
            });
        }
    });
});