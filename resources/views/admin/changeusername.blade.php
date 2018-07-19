@section('title', 'Administrator :: '.TITLE_FOR_PAGES.'Change Username')
@extends('layouts/adminlayout')
@section('content')

<script src="{{ URL::asset('public/js/jquery.validate.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $.validator.addMethod("contact", function(value, element) {
            return  this.optional(element) || (/^[0-9-]+$/.test(value));
        }, "Contact Number is not valid.");
        $.validator.addMethod("noSpace", function(value, element) { 
        return value.indexOf(" ") < 0 && value != ""; 
        }, "No space please and don't leave it empty");
        $("#myform").validate();
    });
</script>
<section id="main-content">
    <section class="wrapper">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                <ul id="breadcrumb" class="breadcrumb">
                    <li>
                        {{ html_entity_decode(link_to('/admin/admindashboard', '<i class="fa fa-dashboard"></i> Dashboard', array('escape' => false))) }}
                    </li>
                    <li class="active"> Change Username </li>
                </ul>
                <section class="panel">
                    <header class="panel-heading">
                        Change Administrator Username
                    </header>
                    <div class="panel-body"> 

                        {{ View::make('elements.actionMessage')->render() }}
                        <span class="require_sign">Please note that all fields that have an asterisk (*) are required. </span>
                        <div class=" form">
                            <?php echo Form::open(array('url' => 'admin/changeusername', 'method' => 'post', 'id' => 'myform', 'class' => 'cmxform form-horizontal tasi-form form')); ?>

                            <div class="form-group ">
                                <label for="ousername" class="control-label col-lg-2">Old Username  <span class="require">*</span></label>
                                <div class="col-lg-10">
                                    <?php
                                    echo Form::text('ousername',null, array('id' => 'ousername', 'autofocus' => true, 'class' => "required form-control noSpace", 'placeholder' => 'Old Username'));
                                    ?>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="username" class="control-label col-lg-2">Username <span class="require">*</span></label>
                                <div class="col-lg-10">
                                    <?php
                                    echo Form::text('username', null, array('id' => 'username', 'autofocus' => true, 'class' => "required form-control noSpace", 'placeholder' => 'Username'));
                                     
                                    ?>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="cusername" class="control-label col-lg-2">Confirm Username <span class="require">*</span></label>
                                <div class="col-lg-10">
                                    <?php
                                    echo Form::text('cusername', null, array('id' => 'cusername', 'equalTo' => '#username', 'autofocus' => true, 'class' => "required form-control noSpace", 'placeholder' => 'Confirm username'));
                                    ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <button class="btn btn-success" type="submit">Change Username</button>
                                    <a class="btn btn-default" href="<?php echo HTTP_PATH . "admin" ?>">Cancel</a>
                                </div>
                            </div>
                            <?php echo Form::close(); ?>
                        </div>

                    </div>
                </section>
            </div>
        </div>
        <!-- page end-->
    </section>
</section>
@stop
