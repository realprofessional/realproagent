@section('title', 'Administrator :: '.TITLE_FOR_PAGES.'Edit City')
@extends('layouts/adminlayout')
@section('content')


<script src="{{ URL::asset('public/js/jquery.validate.js') }}"></script>  

<script type="text/javascript">
    $(document).ready(function() {
        $.validator.addMethod("pass", function(value, element) {
            return  this.optional(element) || (/.{8,}/.test(value) && /([0-9].*[a-z])|([a-z].*[0-9])/.test(value));
        }, "Password minimum length must be 8 characters and contain atleast 1 number.");
        $.validator.addMethod("contact", function(value, element) {
            return  this.optional(element) || (/^[0-9-]+$/.test(value));
        }, "Contact Number is not valid.");
        $.validator.addMethod("noSpace", function(value, element) { 
            return value.indexOf(" ") < 0 && value != ""; 
        }, "No space please and don't leave it empty");
        $.validator.addMethod("url", function(value, element) {
            var regExp = /^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i;
            return this.optional(element) || regExp.test(value);
        }, "Please enter a url . Ex:- http://demo.com"); 
        
        $("#adminAdd").validate();
    });
</script>

<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <ul id="breadcrumb" class="breadcrumb">
                    <li>
                        {{ html_entity_decode(Html::link(HTTP_PATH.'admin/admindashboard', '<i class="fa fa-dashboard"></i> Dashboard', array('id' => ''), true)) }}
                    </li>
                    <li>
                        <i class="fa fa-compass"></i> 
                        {{ html_entity_decode(Html::link(HTTP_PATH.'admin/cityList/', "City", array('id' => ''), true)) }}
                    </li>
                    <li class="active">Edit City</li>
                </ul>

                <section class="panel">

                    <header class="panel-heading">
                        Edit City
                    </header>

                    <div class="panel-body">
                        {{ View::make('elements.actionMessage')->render() }}
                        <span class="require_sign">Please note that all fields that have an asterisk (*) are required. </span>
                        {{ Form::model($detail,array('url' => 'admin/cityList/edit/'.$detail->slug, 'method' => 'post', 'id' => 'adminAdd', 'files' => true,'class'=>"cmxform form-horizontal tasi-form form")) }}

                        <div class="form-group">
                            {{ Html::decode(Form::label('title', "City Name<span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::text('city', Input::old('city'), array('class' => 'required form-control')) }}
                            </div>
                        </div>

                        
                        


<div class="form-group">
                            {{  Form::label('upload_image', 'Upload Image',array('class'=>"control-label col-lg-2")) }}
                            <div class="col-lg-10">
                                {{ Form::file('upload_image',array('class'=>'','onchange' => 'return imageValidation();')); }}
                                <p class="help-block">Supported File Types: gif, jpg, jpeg, png. Max size 2MB.</p>
                            </div>
                        </div>
                        
                        <?php if (file_exists(UPLOAD_FULL_CITY_IMAGE_PATH . '/' . $detail->upload_image) && $detail->upload_image != "") { ?>
                            <div class="form-group">
                                {{  Form::label('old_image', 'Current Image',array('class'=>"control-label col-lg-2")) }}
                                <div class="col-lg-10">
                                    {{ Html::image(UPLOAD_FULL_CITY_IMAGE_PATH.$detail->upload_image, '', array('width' => '100px')) }}
                                </div>
                            </div>
                        <?php } ?>


                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                {{ Form::submit('Save', array('class' => "btn btn-danger",'onclick' => 'return validates(this);')) }}
                                {{ Form::reset('Reset', array('class'=>"btn btn-default")) }}
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </section>
            </div>

        </div>
    </section>
</section>
<script>
    function in_array(needle, haystack) {
        for (var i = 0, j = haystack.length; i < j; i++) {
            if (needle == haystack[i])
                return true;
        }
        return false;
    }

    function getExt(filename) {
        var dot_pos = filename.lastIndexOf(".");
        if (dot_pos == -1)
            return "";
        return filename.substr(dot_pos + 1).toLowerCase();
    }



    function imageValidation() {

        var filename = document.getElementById("upload_image").value;

        var filetype = ['jpeg', 'png', 'jpg', 'gif'];
        if (filename != '') {
            var ext = getExt(filename);
            ext = ext.toLowerCase();
            var checktype = in_array(ext, filetype);
            if (!checktype) {
                alert(ext + " file not allowed for Profile Image.");
                document.getElementById("upload_image").value = "";
                return false;
            } else {
                var fi = document.getElementById('upload_image');
                var filesize = fi.files[0].size;
                if (filesize > 2097152) {
                    alert('Maximum 2MB file size allowed for Profile Image.');
                    document.getElementById("upload_image").value = "";
                    return false;
                }
            }
            
        }
        return true;
    }
function validates(res){
    imageValidation();
     var _URL = window.URL || window.webkitURL;   
       var file, img;
    var pathusrl = '<?php echo HTTP_PATH;?>';
    if ((file = res.files[0])) {
        
        img = new Image();
        
        img.onload = function () {
       //   var fi = document.getElementById('img_up_4');
         //  alert(this.width + " " + this.height);
         
            if(img.width<585 || img.height<283){
            
               
            alert('Please upload a image with min 585X283 size.');
             $(res).val('');
           $(res).next('img').attr('src', pathusrl+'public/img/front/add_a_photo2.png');
               
            }
            else if(img.width>1200 || img.height>1000){
                alert('Please upload a image with max 1200X1000 size.');
             $(res).val('');
           $(res).next('img').attr('src', pathusrl+'public/img/front/add_a_photo2.png');
            }
            else{
            
              
       
        if (res.files && res.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
           
            $(res).next('img').attr('src', e.target.result);
        }

        reader.readAsDataURL(res.files[0]);
    }
             
            }
           
             var filesize = res.files[0].size;
             
                if (filesize > 2097152) {
                 alert('Please upload a image maximum 2MB.');
                 $(res).val('');
                 $(res).next('img').attr('src', pathusrl+'public/img/front/add_a_photo2.png');
                }
                
                
          
        };
        img.src = _URL.createObjectURL(file);
           var filename =  $(res).val();
                var filetype = ['jpeg', 'png', 'jpg'];
                
        var ext = getExt(filename);
        
            ext = ext.toLowerCase();
            var checktype = in_array(ext, filetype);
            if (!checktype) {
                
                alert(ext + " file not allowed for city Image.");
                 $(res).val('');
                 $(res).next('img').attr('src', pathusrl+'public/img/front/add_a_photo2.png');
            }
        
    } 
    }

</script>


@stop