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
                    //                    $('#formloader').show();
                    this.submit();
                } else {
                    return false;
                }
            }
        });
        $(document).on("click", ".counter_number", function() {
            var type = $(this).attr("alt");
            var value = $('#preparation_time').val();
            value = value?parseInt(value):0;
            if(type == 'minus') {
                $('#preparation_time').val((value-1 <0)?0:(value-1));
            } else {
                if(value >= 100)
                    $('#preparation_time').val(value);
                else
                    $('#preparation_time').val(value+1);
            }
        })
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
                        <div class="tatils">Add Menu </div>
                        <div class="pery">
                            <div id="formloader" class="formloader" style="display: none;">
                                {{ HTML::image('public/img/loader_large_blue.gif','', array()) }}
                            </div>
                            {{ View::make('elements.frontEndActionMessage')->render() }}
                            {{ Form::open(array('url' => '/user/addmenu', 'method' => 'post', 'id' => 'myform', 'files' => true,'class'=>"cmxform form-horizontal tasi-form form")) }}
                            <span class="require" style="float: left;width: 100%;">* Please note that all fields that have an asterisk (*) are required. </span>

                            <div class="form_group">
                                {{ HTML::decode(Form::label('cuisine', "Cuisine <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                                <div class="in_upt">
                                    <?php
                                    $cuisine_array = array(
                                        '' => 'Please Select'
                                    );
                                    $cuisine = Cuisine::lists('name', 'id');
                                    if (!empty($cuisine)) {
                                        foreach ($cuisine as $key => $val)
                                            $cuisine_array[$key] = $val;
                                    }
                                    ?>
                                    {{ Form::select('cuisine', $cuisine_array, Input::old("cuisine"), array('class' => 'form-control required', 'id'=>'cuisine')) }}
                                </div>
                            </div>


                            <div class="form_group">
                                {{ HTML::decode(Form::label('item_name', "Item Name <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                                <div class="in_upt">
                                    {{  Form::text('item_name', Input::old("item_name"),  array('class' => 'required form-control','id'=>"item_name"))}}
                                </div>
                            </div>

                            <div class="form_group">
                                {{ HTML::decode(Form::label('price', "Price(EGP) <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                                <div class="in_upt">
                                    {{  Form::text('price', Input::old("price"),  array('class' => 'required positiveNumber number form-control','id'=>"price"))}}
                                </div>
                            </div>

                            <div class="form_group">
                                {{ HTML::decode(Form::label('preparation_time', "Preparation Time (Hours) <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                                <div class="in_upt in_fot">
                                    {{  Form::text('preparation_time', Input::old("preparation_time"),  array('maxlength'=>4, 'class' => 'required positiveNumber preparation_time number form-control','id'=>"preparation_time"))}}
                                    <div class="counter-buttons">
                                        <div class="inner-button counter_number" alt="minus">
                                            <i class="fa  fa-minus-square "></i>
                                        </div> 
                                        <div class="inner-buttonright counter_number" alt="plus">
                                            <i class="fa fa-plus-square "></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form_group">
                                {{ HTML::decode(Form::label('description', "Menu Description",array('class'=>"control-label col-lg-2"))) }}
                                <div class="in_upt">
                                    {{  Form::textarea('description', Input::old("description"),  array('class' => 'form-control','id'=>"description"))}}
                                </div>
                            </div>

                            <div class="form_group">
                                {{ HTML::decode(Form::label('submenu', "Sub Menu",array('class'=>"control-label col-lg-2"))) }}
                                <div class="in_upt">
                                    {{  Form::textarea('submenu',  Input::old("submenu"),  array('class' => 'form-control','id'=>"submenu"))}}
                                    <p class="help-block">Please use comma(,) to separate submenu items.</p>
                                </div>
                            </div>




                            <div class="form_group">
                                {{ HTML::decode(Form::label('image', "Item Image",array('class'=>"control-label col-lg-2"))) }}
                                <div class="in_upt">
                                    {{ Form::file('image', array('class'=>"",'id'=>"image")); }}
                                    <p class="help-block">Supported File Types: gif, jpg, jpeg, png. Max size 2MB.</p>
                                </div>
                            </div>

                            <div class="form_group">
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


