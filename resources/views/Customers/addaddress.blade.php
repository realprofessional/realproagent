@extends('layout')
@section('content')
<script src="{{ URL::asset('public/js/jquery.validate.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $.validator.addMethod('positiveNumber',
        function (value) { 
            return Number(value) > 0;
        }, 'Enter a positive number.');
        $.validator.addMethod("pass", function(value, element) {
            return  this.optional(element) || (/.{8,}/.test(value) && /((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,20})/.test(value));
        }, "Password minimum length must be 8 charaters and combination of 1 special character, 1 lowercase character, 1 uppercase character and 1 number.");

        $("#myform").validate({
            submitHandler: function(form) {
                this.checkForm();

                if (this.valid()) { // checks form for validity
                    $('#formloader').show();
                    this.submit();
                } else {
                    return false;
                }
            }
        });
        
        $("#city").change(function() {
            $("#area").load("<?php echo HTTP_PATH . "customer/loadarea/" ?>"+$(this).val()+"/0");
        })
        
    });
</script>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<!--
<script type="text/javascript">
    
    var centerAddress;
    window.onload = function () {
        var mapOptions = {
            center: new google.maps.LatLng(18.9300, 72.8200),
            zoom: 14,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var infoWindow = new google.maps.InfoWindow();
        var latlngbounds = new google.maps.LatLngBounds();
        var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
        google.maps.event.addListener(map, 'click', function (e) {
            var latlng = new google.maps.LatLng(e.latLng.lat(), e.latLng.lng());
            var geocoder = geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'latLng': latlng }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    
                    if (results[1]) {
                        var txt;
                        if (results[0].formatted_address.indexOf("،") != -1) {
                            txt = results[0].formatted_address.split("،")[0];
                        }
                        else {
                            txt = results[0].formatted_address.split(",")[0];

                        }
                        $("#street_name").val(txt);
                        var directionsService = new google.maps.DirectionsService();
                        var start = "Egypt,Cairo,Zamalek";
                        var end = results[0].formatted_address;
                        var request = {
                            origin: start,
                            destination: end,
                            travelMode: google.maps.TravelMode.DRIVING
                        };
                        directionsService.route(request, function (response, status) {
                            if (status == google.maps.DirectionsStatus.OK) {

                                var n = "<div>" + ' From ' + centerAddress + ' :- ';
                                var total = response.routes[0].legs[0].steps.length;
                                $.each(response.routes[0].legs[0].steps, function (index) {
                                    if (index === total - 1) {
                                        n = n + this.instructions;

                                    }
                                    else {
                                        n = n + this.instructions + ' Then ';
                                    }
                                });

                                n = n + "<div/>";
                                n = $(n).text().toString().replace("ستكون", " ستكون").replace("Destination", " Destination");
                                $("#directions").val(n);
                            }
                        });
                    }
                }
            });
        });
        function handleNoGeolocation(errorFlag) {
            if (errorFlag) {
                var content = 'Error: The Geolocation service failed.';
            } else {
                var content = 'Error: Your browser doesn\'t support geolocation.';
            }

            var options = {
                map: map,
                position: new google.maps.LatLng(60, 105),
                content: content
            };

            var infowindow = new google.maps.InfoWindow(options);
            map.setCenter(options.position);
        }
    }
</script>-->

<script>
    var geocoder;
    var map;
    var infowindow = new google.maps.InfoWindow();
    var marker;
    var centerAddress;
<?php
// get lat long from their IP address
//$lats = $this->getlatlong();
$latitude = $lats['lat'];
$longitude = $lats['long'];
?>
    var myCenter = new google.maps.LatLng(<?php echo $latitude; ?>,<?php echo $longitude; ?>);
    //        var myCenter = new google.maps.LatLng(24.706915, 46.710205);
     
    function codeLatLng() {
        if (marker) {
            var latlng = marker.getPosition();
            geocoder.geocode({ 'latLng': latlng }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        var txt;
                        if (results[0].formatted_address.indexOf("،") != -1) {
                            txt = results[0].formatted_address.split("،")[0];
                        }
                        else {
                            txt = results[0].formatted_address.split(",")[0];
                        }
                        $("#street_name").val(txt);
                        var directionsService = new google.maps.DirectionsService();
                        var start = "Egypt,Cairo,Zamalek";
                        var end = results[0].formatted_address;
                        var request = {
                            origin: start,
                            destination: end,
                            travelMode: google.maps.TravelMode.DRIVING
                        };
                        directionsService.route(request, function (response, status) {
                            if (status == google.maps.DirectionsStatus.OK) {

                                var n = "<div>" + ' From ' + centerAddress + ' :- ';
                                var total = response.routes[0].legs[0].steps.length;
                                $.each(response.routes[0].legs[0].steps, function (index) {
                                    if (index === total - 1) {
                                        n = n + this.instructions;

                                    }
                                    else {
                                        n = n + this.instructions + ' Then ';
                                    }
                                });

                                n = n + "<div/>";
                                n = $(n).text().toString().replace("ستكون", " ستكون").replace("Destination", " Destination");
                                $("#directions").val(n);
                            }
                        });
                    }
                } else {
                    alert("Geocoder failed due to: " + status);
                }
            });

            $("#ctl00_MainContent_AddAddress_latlang").val(latlng.lat() + "," + latlng.lng());
        }
        $("#dvMap").fadeOut();

    }

    function initialize() {
        geocoder = new google.maps.Geocoder();
        var mapProp = {
            center: myCenter,
            zoom: 5,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        map = new google.maps.Map(document.getElementById("dvMap"), mapProp);
        address = "Egypt,Cairo,Zamalek";
        geocoder.geocode({ 'address': address }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                map.setZoom(13);
                geocoder.geocode({ 'latLng': results[0].geometry.location }, function (results1, status1) {
                    if (status1 == google.maps.GeocoderStatus.OK) {
                        if (results1[0].formatted_address.indexOf("،") != -1) {
                            centerAddress = results1[0].formatted_address.split("،")[0] + "،" + results1[0].formatted_address.split("،")[1];
                        }
                        else {
                            centerAddress = results1[0].formatted_address.split(",")[0] + "," + results1[0].formatted_address.split(",")[1];
                        }
                    }
                });
            }
        });
        google.maps.event.addListener(map, 'click', function (event) {
            placeMarker(event.latLng);
            codeLatLng();
        });
       
    }

    function placeMarker(location) {
        if (!marker) {
            marker = new google.maps.Marker({
                position: location,
                map: map
            });
        }
    }

</script>

<script type="text/javascript">

    $(function () {
        $(".map-link").click(function () {

            $("#dvMap").fadeIn();
            if (!map) {
                initialize();
            }
            //            google.maps.event.addDomListener(window, 'load', initialize);
        });

    });
</script>


<section>
    <div class="top_menus">
        <div class="wrapper">
            @include('elements/left_menu')
            <div class="acc_bar">
                <div class="ad_right">
                    <h2>Welcome!</h2>
                    <h1><?php echo $userData->first_name . ' ' . $userData->last_name; ?></h1>
                </div>
                <div class="acc_setting">
                    @include('elements/top_menu')
                </div> 

                <div class="informetion">
                    <div class="informetion_top">
                        <div class="tatils">Add New Address</div>
                        <div class="pery">
                            <div id="formloader" class="formloader" style="display: none;">
                                {{ HTML::image('public/img/loader_large_blue.gif','', array()) }}
                            </div>
                            {{ View::make('elements.frontEndActionMessage')->render() }}
                            {{ Form::open(array('url' => '/user/addaddress', 'method' => 'post', 'id' => 'myform', 'files' => true,'class'=>"cmxform form-horizontal tasi-form form")) }}
                            <span class="require" style="float: left;width: 100%;">* Please note that all fields that have an asterisk (*) are required. </span>

                            <div class="map-link">
                                Add From Map
                            </div>
                            <div class="map">
                                <div id="dvMap" style="width:100%; height: 300px; display: none">
                                </div>
                            </div>
                            <div class="multiple-fields">
                                <div class="form_group">
                                    <div class="form_group_left">
                                        {{ HTML::decode(Form::label('address_title', "Address Title <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                                        <div class="in_upt">
                                            {{  Form::text('address_title', Input::old('address_title'),  array('class' => 'required form-control','id'=>"address_title"))}}
                                        </div>
                                    </div>
                                    <div class="form_group_left form_group_right">
                                        {{ HTML::decode(Form::label('address_type', "Address Type <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                                        <div class="in_upt">
                                            <?php
                                            $address_type = array(
                                                '' => 'Please Select',
                                                'Home' => 'Home',
                                                'Work' => 'Work',
                                                'Other' => 'Other',
                                            );
                                            ?>
                                            {{ Form::select('address_type', $address_type, Input::old('address_type'), array('class' => 'form-control required', 'id'=>'address_type')) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form_group">
                                    <div class="form_group_left">
                                        {{ HTML::decode(Form::label('city', "City <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                                        <div class="in_upt">
                                            <?php
                                            $cities_array = array(
                                                '' => 'Please Select'
                                            );
                                            $cities = City::orderBy('name', 'asc')->lists('name', 'id');
                                            if (!empty($cities)) {
                                                foreach ($cities as $key => $val)
                                                    $cities_array[$key] = ucfirst($val);
                                            }
                                            ?>
                                            {{ Form::select('city', $cities_array, Input::old('city'), array('class' => 'form-control required', 'id'=>'city')) }}
                                        </div>
                                    </div>
                                    <div class="form_group_left form_group_right">

                                        {{ HTML::decode(Form::label('area', "Area <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                                        <div class="in_upt">
                                            {{ Form::select('area', array(''=>'Please Select'), Input::old('area'), array('class' => 'form-control required', 'id'=>'area')) }}

                                        </div>
                                    </div>
                                </div>

                                <div class="form_group">
                                    <div class="form_group_left">
                                        {{ HTML::decode(Form::label('street_name', "Street Name <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                                        <div class="in_upt">
                                            {{  Form::text('street_name', Input::old('street_name'),  array('class' => 'required form-control','id'=>"street_name"))}}
                                        </div>
                                    </div>
                                    <div class="form_group_left form_group_right">

                                        {{ HTML::decode(Form::label('building', "Building ",array('class'=>"control-label col-lg-2"))) }}
                                        <div class="in_upt">
                                            {{  Form::text('building', Input::old('building'),  array('class' => 'form-control','id'=>"building"))}}
                                        </div>

                                    </div>
                                </div>



                                <div class="form_group">
                                    <div class="form_group_left">
                                        {{ HTML::decode(Form::label('floor', "Floor",array('class'=>"control-label col-lg-2"))) }}
                                        <div class="in_upt">
                                            {{  Form::text('floor', Input::old('floor'),  array('class' => 'form-control','id'=>"floor"))}}
                                        </div>
                                    </div>
                                    <div class="form_group_left form_group_right">

                                        {{ HTML::decode(Form::label('apartment', "Apartment",array('class'=>"control-label col-lg-2"))) }}
                                        <div class="in_upt">
                                            {{  Form::text('apartment', Input::old('apartment'),  array('class' => 'form-control','id'=>"apartment"))}}

                                        </div>
                                    </div>
                                </div>


                                <div class="form_group">
                                    <div class="form_group_left">
                                        {{ HTML::decode(Form::label('phone_number', "Phone Number <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                                        <div class="in_upt">
                                            {{  Form::text('phone_number', Input::old('phone_number'),  array('class' => 'required number form-control','id'=>"phone_number",'maxlength'=>"16"))}}
                                        </div>
                                    </div>

                                    <div class="form_group_left form_group_right">

                                        {{ HTML::decode(Form::label('extension', "Extension",array('class'=>"control-label col-lg-2"))) }}
                                        <div class="in_upt">
                                            {{  Form::text('extension', Input::old('extension'),  array('class' => 'form-control','id'=>"extension"))}}
                                        </div>
                                    </div>

                                </div>


                            </div>

                            <div class="form_group form_groupse">
                                {{ HTML::decode(Form::label('directions', "Directions",array('class'=>"control-label col-lg-2"))) }}
                                <div class="in_upt">
                                    {{  Form::textarea('directions',Input::old('directions'),  array('class' => 'form-control','id'=>"directions"))}}
                                </div>
                            </div>

                            <div class="form_group form_groupse">
                                <label>&nbsp;</label>
                                <div class="in_upt in_upt_res">
                                    {{ Form::submit('Submit', array('class' => "btn btn-danger")) }}
                                    {{ Form::reset('Reset', array('class' => "btn btn-danger")) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@stop


