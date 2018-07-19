@extends('layout')
@section('content')

<script src="{{ URL::asset('public/js/jquery.validate.js') }}"></script>

<script type="text/javascript">
//    $(document).ready(function() {
//        $("#addshop").validate({
//            submitHandler: function(form) {
//                this.checkForm();
//
//                if (this.valid()) { // checks form for validity
//                    $('#formloader').show();
//                    this.submit();
//                } else {
//                    return false;
//                }
//            }
//        });
//    });
</script>

<div class="bodybg">
    @include('elements/shop_menu')
    <div class="wrapper">
    <div class="body_area">
        <div class="body_heading">
        <h3>Create services you are going to offer.</h3>
        Add as many listings as you can right now—10 or more would be awesome. More listings = more chances to get discovered!
        </div>

        {{ View::make('elements.actionMessage')->render() }}

        <div class="stock_data_box stock_data_box_for_co">
            <div class="row">
                <div class="for_cols">
                    <div class="stock_box_cols">
                        <div class="add_lisint_sec">
                            <div class="stock_box_blank">
                                {{ html_entity_decode(Html::link("user/createlist",Html::image("public/img/front/add_lisint_img.png", "img"),array())) }}
                            </div>

                        </div>
                    </div>
                </div>

                <?php
                $user_id = Session::get('user_id');
                $shopData = DB::table('shops')
                        ->where('user_id', $user_id)
                        ->first();

                    foreach ($listings as $listing) {
                ?>
                <div class="for_cols">
                    <div class="stock_box_cols">
                        <div class="add_lisint_sec">
                            <?php
                            if (file_exists(UPLOAD_FULL_ITEM_IMAGE_PATH . '/' . $listing->primary_image) && $listing->primary_image != "") {
                                echo Html::image(DISPLAY_FULL_ITEM_IMAGE_PATH . $listing->primary_image, 'lising_img', array());
                            } else {
                                echo Html::image('public/img/front/add_img_sec.png', 'usrimg', array());
                            }
                            ?>
                        </div>
                        <div class="add_lisint_sec_bottom">
                            <div class="add_lisint_sec_title">
                                {{ Html::link("#",$listing->title,array('class'=>'')) }}
                            </div>

                            <div class="add_lisint_sec_sgop">{{ $shopData->name_shop }}</div>
                            <div class="add_lisint_sec_price">${{ $listing->price }} USD</div>

                            <div class="action_bottom_box">
                                    <ul>
                                    <li>
                                        {{ Html::link("listing/editlisting/".$listing->slug."/shop",'Edit',array('class'=>'')) }}
                                    </li>
                                    <li>
                                        {{ Html::link("listing/deletelisting/".$listing->slug."/shop",'Delete',array('class'=>'','onclick'=>'return checkDelete();')) }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    }
                ?>
            </div>
        </div>


    </div>
   {{ Html::link("listing/getPaid/".$shopData->slug,"Continue",array('class'=>'next action-button')) }}
    
    </div>
</div>
<script>
    function checkDelete() {
        var result = confirm("Are you sure want to delete?");
        
        if (result===true) {
            return true;
        } else {
            return false;
        }
    }
</script>

<?php
/*
<section>
    <div class="top_menus">
        <div class="wrapper">
            <div class="acc_bar">
                <div class="acc_setting">
                    @include('elements/shop_menu')
                </div> 

                <div class="informetion">
                    <div id="formloader" class="formloader" style="display: none;">
                        {{ Html::image('public/img/loader_large_blue.gif','', array()) }}
                    </div>
                    {{ View::make('elements.actionMessage')->render() }}
                    <div class="informetion_top">
                        
                    <div class="bg-white bt-xs-1 bb-xs-1 pt-xs-6 pb-xs-6">

                        <div class="col-group body-fixed-width">

                            <div class="col-xs-12">
                                <div class="flag">
                                    <div class="flag-body">
                                        <div class="prose">
                                            <h2 class="h1">Now stock your shop.</h2>
                                            <p>Add as many listings as you can now&mdash;10 or more would be awesome. More listings = more chances to get discovered!</p>
                                        </div>
                                    </div>

                                    <div class="flag-img flag-img-right text-right">
                                                        </div>
                                </div>
                            </div>

                            

                            <div class="col-xs-12 mt-xs-4 mb-xs-4">
                                <div class="block-grid-xs-2 block-grid-sm-2 block-grid-md-3 block-grid-lg-4 block-grid-xl-6">
                                    <br/>
                                    {{ html_entity_decode(Html::link('user/createlist','Add New Listing',array('id'=>'addlist', 'class'=>''))) }}

                                    <div class="block-grid-item">
                                            <div class="card">
                                                <div class="card-img-wrap">
                                                    <div class="placeholder placeholder-landscape">
                                                        <div class="placeholder-content placeholder-listing-card-image">
                                                            <div class="placeholder placeholder-landscape width-full"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-actions pt-xs-2 pb-xs-2 card-actions-2">
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <br>
                                                </div>
                                            </div>
                                    </div>
                                                                
                                                                    </div>
                            </div>
                            <?php
                                foreach ($listings as $listing) {
                                    echo $listing->user_id;
                                }
                            ?>

                            <div class="col-md-6 float-right text-right">
                                <a href="" class="btn btn-primary">
                                    Continue
                                </a>
                            </div>
                        </div>
                    </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
*/
?>
@stop