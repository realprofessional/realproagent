@section('title', 'Administrator :: '.TITLE_FOR_PAGES.'Add News')
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
        
        $("#adminAdd").validate({
             rules: 
                {
                short_description: 
                    {
                     required: true,
      minlength: 120,
      maxlength: 500
                }
                }
        });
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
                        <i class="fa fa-newspaper-o"></i> 
                        {{ html_entity_decode(Html::link(HTTP_PATH.'admin/newsList/', "News", array('id' => ''), true)) }}
                    </li>
                    <li class="active">Add News</li>
                </ul>

                <section class="panel">

                    <header class="panel-heading">
                        Add News
                    </header>

                    <div class="panel-body">
                        {{ View::make('elements.actionMessage')->render() }}
                        <span class="require_sign">Please note that all fields that have an asterisk (*) are required. </span>
                        {{ Form::open(array('url' => 'admin/news/add', 'method' => 'post', 'id' => 'adminAdd', 'files' => true,'class'=>"cmxform form-horizontal tasi-form form")) }}
                        
                        <div class="form-group">
                            {{ Html::decode(Form::label('title', "News Title<span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::text('title', Input::old('title'), array('class' => 'required form-control')) }}
                            </div>
                        </div>
                        
                        <div class="form-group">
                            {{ Html::decode(Form::label('short_description', "Short Description<span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::textarea('short_description', Input::old('short_description'), array('class' => 'required form-control')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Html::decode(Form::label('news_link', "News Link<span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::text('news_link', Input::old('news_link'), array('class' => 'required form-control url')) }}
                            </div>
                        </div>
                        <div class="form-group">
                              {{ Html::decode(Form::label('upload_image', "Upload Image<span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                        <div class="for_cols firstfor_cols col-lg-10">
                                <div class="add_photo_cols">
                                    
<div class="single_img">
                                        
                                        <div class="upload_imgareainput"> <span class="file_input img_up_1"> 
                                           
                                                {{ Form::file('upload_image', array('class'=>"required",'id'=>"upload_image", 'onchange'=>'return imageValidation();')); }} 
                                           

                                            </span>
                                            <p class="custom_error1 custom_error"></p>
                                            <span class="data_clide_in"><b>This will be client facing picture, choose it wisely.</b><span class='require'>*</span></span> 
                                            

                                        </div>
                                        </div> 
                                    


                                </div>
                            </div>
                        </div>
                        
                        
                        
                        
                        
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                {{ Form::submit('Save', array('class' => "btn btn-danger",'onclick' => 'return imageValidation();')) }}
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

</script>


@stop