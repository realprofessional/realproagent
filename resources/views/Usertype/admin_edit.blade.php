@section('title', 'Administrator :: '.TITLE_FOR_PAGES.'Edit User Type')
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
        }, "No space allowed.");
        $("#adminAdd").validate(
        {
            rules: {
                account_type: {
                    required: true
                },
                contact: {
                    required: true,
                    maxlength: 16
                    
                }
            }
        }
    );
    });
</script>

<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <ul id="breadcrumb" class="breadcrumb">
                    <li>
                        {{ html_entity_decode(Html::link(HTTP_PATH.'admin/admindashboard', "<i class='fa fa-dashboard'></i> Dashboard", array('id' => ''), true)) }}
                    </li>
                    <li>
                        <i class="fa fa-credit-card"></i> 
                        {{ html_entity_decode(Html::link(HTTP_PATH.'admin/usertype/list', "User Type Listing", array('id' => ''), true)) }}
                    </li>
                    <li class="active">Edit User Type</li>
                </ul>
                <section class="panel">
                    <header class="panel-heading">
                        Edit User Type
                    </header>

                    <div class="panel-body">
                        {{ View::make('elements.actionMessage')->render() }}
                        <span class="require_sign">Please note that all fields that have an asterisk (*) are required. </span>
                        {{ Form::model($detail, array('url' => '/admin/usertype/editType/'.$detail->slug, 'method' => 'post', 'id' => 'adminAdd', 'files' => true,'class'=>"cmxform form-horizontal tasi-form form")) }}

                        <div class="form-group">
                            {{ Html::decode(Form::label('type', "User Type <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                            <div class="col-lg-10">
                                {{ Form::text('type', Input::old('type'), array('class' => 'required form-control',"placeholder"=>"User Type")) }}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                {{ Form::submit('Update', array('class' => "btn btn-success")) }}
                                {{ html_entity_decode(Html::link(HTTP_PATH.'admin/usertype/list', "Cancel", array('class' => 'btn btn-default'), true)) }}
                            </div>
                        </div>

                        {{ Form::close() }}

                    </div>
                </section>
            </div>

        </div>
    </section>
</section>
@stop