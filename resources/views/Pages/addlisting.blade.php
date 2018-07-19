@extends('layout')
@section('content')

<div class="bodybg">
    
    
    
<form id="msform">
    <ul id="progressbar">
    <div class="wrapper">
    <li class="active">Name Your Business</li>
    <li>Add listing</li>
    <li>Get Paid</li>
    <li>Open Shop</li>
    </div>
    </ul>
    <div class="wrapper">
        <!--<fieldset>
            <div class="body_area">
    <div class="body_heading">
    <h3>Business Name</h3>
    Your business name appears with your items in the Workilo marketplace. Pick a name that has personal significance or helps identify what's in your business.
    
    </div>
    
    <div class="form_area">
    <div class="form_headind">Name Your Business</div>
    
    <div class="input_area">
    <input type="text" />
    <span> You can change your business name, later.</span>
    
    
    </div>
    
    </div>
    </div>
            <input type="button" name="next" class="next action-button" value="Next" />
        </fieldset>-->
        <!--<fieldset>
            <div class="body_area">
    <div class="body_heading">
    <h3>Add a new listing</h3>
    </div>
    
    <div class="form_area">
    <div class="form_headind">Photos
    <span> Add at least one photo. Use all five photos to show off your item's finest features.  </span>
    
    </div>   
    
    
    <div class="cta_area cta_area_nome">
    	<div class="row">
        	<div class="for_cols">
            	<div class="add_photo_cols">
                    <div class="uploader" onclick="$('#filePhoto').click()">        
                        <img src="../public/img/front/add_a_photo.png" alt="img"/>
                        <input type="file" name="userprofile_picture"  id="filePhoto" />
                    </div>
                </div>
            </div>
            <div class="for_cols">
            	<div class="add_photo_cols">
                	<input type="file" class="cla_input_esi" id="image_upload1" />
                	<label class="add_photo_cols_ro" for="image_upload1" />
                </div>
            </div>
            <div class="for_cols">
            	<div class="add_photo_cols">
                	<input type="file" class="cla_input_esi" id="image_upload2" />
                	<label class="add_photo_cols_ro" for="image_upload2" />
                </div>
            </div>
            <div class="for_cols">
            	<div class="add_photo_cols">
                	<input type="file" class="cla_input_esi" id="image_upload3" />
                	<label class="add_photo_cols_ro" for="image_upload3" />
                </div>
            </div>
        </div>
        
        <script>
            var imageLoader = document.getElementById('filePhoto');
                imageLoader.addEventListener('change', handleImage, false);

                function handleImage(e) {
                    var reader = new FileReader();
                    reader.onload = function (event) {
                        $('.uploader img').attr('src',event.target.result);
                    }
                    reader.readAsDataURL(e.target.files[0]);
                }
        </script>
        <div class="clear"></div>
        
       <span class="data_clide_in">Use high quality JPG, PNG or GIF files that are at least 570px wide (we recommend 1000px). Photo tip: don’t use a flash.</span>
    </div>
    
    </div>
    
    <div class="form_area">
    <div class="form_headind">Listing details
    <span> Tell the world all about your item and why they'll love it. </span>
    
    </div>
    
    <div class="formarea_inner">
    <ul>
    <li>
    <label>Who made it</label>
    <div class="customselect_area2">
         <span>
    <select>
    <option>1</option>
    <option>2</option>
    <option>3</option>
    </select> 
    </span>
    </div>
    </li>
    
    <li>
    <label>What is it</label>
    <div class="customselect_area2">
         <span>
    <select>
    <option>1</option>
    <option>2</option>
    <option>3</option>
    </select> 
    </span>
    </div>
    </li>
    
    <li>
    <label>About this Listing</label>
    <div class="customselect_area2 selectsamll_area selectsamll_area_rght">
         <span>
    <select>
    <option>Where are you located?</option>
    <option>xyz</option>
    <option>xyz</option>
    </select> 
    </span>
    </div>
    
    <div class="customselect_area2 selectsamll_area">
         <span>
    <select>
    <option>Miles willing to travel?</option>
    <option>xyz</option>
    <option>xyz</option>
    </select> 
    </span>
    </div>
    
    </li>
    
    
    <li>
    <label>Category</label>
    <div class="customselect_area2 selectsamll_area" style="margin-left:0px;">
         <span>
    <select>
    <option>1</option>
    <option>2</option>
    <option>3</option>
    </select> 
    </span>
    </div>  
    </li>
    
    <li>
    <label>Price</label>
    <div class="custominput_area selectsamll_area" style="margin-left:0px;">
        
    <input type="text" placeholder="USD" />
    
    
    
    </div>  
    </li>
    
    <li>
    <label>Quantity</label>
    <div class="selectsamll_area" style="margin-left:0px;">
       
    <input style="text-align:left;" type="text" placeholder="1" />
    </div>  
    </li>
    <li>
    <label>Description</label>
    <div class="customselect_area2">
    <textarea></textarea>
    </div>
    
    
    </li>
    </ul>
    
    
    
    
    </div>
    
    </div>
    	
    
    
    </div>
            <input type="button" name="previous" class="previous action-button" value="Previous" />
            <input type="button" name="next" class="next action-button" value="Next" />
        </fieldset>-->
        <!--<fieldset>
            <div class="body_area">
    <div class="body_heading">
    <h3>Now stock your shop.</h3>
    Add as many listings as you can right now—10 or more would be awesome. More listings = more chances to get discovered!
    </div>
    
    <div class="stock_data_box">
    	<div class="row">
            <div class="for_cols">
                <div class="stock_box_cols">
                    <div class="add_lisint_sec">
                    	<div class="stock_box_blank">
	                    	<img src="../public/img/front/add_lisint_img.png" alt="img"/>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="for_cols">
                <div class="stock_box_cols">
                    <div class="add_lisint_sec">
	                    <img src="../public/img/front/add_img_sec.png" alt="img"/>
                    </div>
                    <div class="add_lisint_sec_bottom">
                    	<div class="add_lisint_sec_title"><a href="#">Gallery</a></div>
                        
                        <div class="add_lisint_sec_sgop">AlokShop</div>
                        <div class="add_lisint_sec_price">$5.00 USD</div>
                        
                        <div class="action_bottom_box">
                        	<ul>
                            	<li><a href="#">Copy</a></li>
                                <li><a href="#">Delete</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="for_cols">
                <div class="stock_box_cols">
                    <div class="add_lisint_sec">
	                    <img src="../public/img/front/add_img_sec.png" alt="img"/>
                    </div>
                    <div class="add_lisint_sec_bottom">
                    	<div class="add_lisint_sec_title"><a href="#">Gallery</a></div>
                        
                        <div class="add_lisint_sec_sgop">AlokShop</div>
                        <div class="add_lisint_sec_price">$5.00 USD</div>
                        
                        <div class="action_bottom_box">
                        	<ul>
                            	<li><a href="#">Copy</a></li>
                                <li><a href="#">Delete</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="for_cols">
                <div class="stock_box_cols">
                    <div class="add_lisint_sec">
	                    <img src="../public/img/front/add_img_sec.png" alt="img"/>
                    </div>
                    <div class="add_lisint_sec_bottom">
                    	<div class="add_lisint_sec_title"><a href="#">Gallery</a></div>
                        
                        <div class="add_lisint_sec_sgop">AlokShop</div>
                        <div class="add_lisint_sec_price">$5.00 USD</div>
                        
                        <div class="action_bottom_box">
                        	<ul>
                            	<li><a href="#">Copy</a></li>
                                <li><a href="#">Delete</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="for_cols">
                <div class="stock_box_cols">
                    <div class="add_lisint_sec">
                    	<div class="stock_box_blank">
	                    	<img src="../public/img/front/add_lisint_img.png" alt="img"/>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="for_cols">
                <div class="stock_box_cols">
                    <div class="add_lisint_sec">
	                    <img src="../public/img/front/add_img_sec.png" alt="img"/>
                    </div>
                    <div class="add_lisint_sec_bottom">
                    	<div class="add_lisint_sec_title"><a href="#">Gallery</a></div>
                        
                        <div class="add_lisint_sec_sgop">AlokShop</div>
                        <div class="add_lisint_sec_price">$5.00 USD</div>
                        
                        <div class="action_bottom_box">
                        	<ul>
                            	<li><a href="#">Copy</a></li>
                                <li><a href="#">Delete</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="for_cols">
                <div class="stock_box_cols">
                    <div class="add_lisint_sec">
	                    <img src="../public/img/front/add_img_sec.png" alt="img"/>
                    </div>
                    <div class="add_lisint_sec_bottom">
                    	<div class="add_lisint_sec_title"><a href="#">Gallery</a></div>
                        
                        <div class="add_lisint_sec_sgop">AlokShop</div>
                        <div class="add_lisint_sec_price">$5.00 USD</div>
                        
                        <div class="action_bottom_box">
                        	<ul>
                            	<li><a href="#">Copy</a></li>
                                <li><a href="#">Delete</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="for_cols">
                <div class="stock_box_cols">
                    <div class="add_lisint_sec">
	                    <img src="../public/img/front/add_img_sec.png" alt="img"/>
                    </div>
                    <div class="add_lisint_sec_bottom">
                    	<div class="add_lisint_sec_title"><a href="#">Gallery</a></div>
                        
                        <div class="add_lisint_sec_sgop">AlokShop</div>
                        <div class="add_lisint_sec_price">$5.00 USD</div>
                        
                        <div class="action_bottom_box">
                        	<ul>
                            	<li><a href="#">Copy</a></li>
                                <li><a href="#">Delete</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    </div>
            <input type="button" name="previous" class="previous action-button" value="Previous" />
            <input type="button" name="next" class="next action-button" value="Next" />
        </fieldset>
        
        <fieldset>
            <div class="body_area">
    <div class="body_heading">
    <h3>Shop Name</h3>
    Your shop name appears with your items in the Workilo marketplace. Pick a name that has personal significance or helps identify what's in your shop.
    
    </div>
    
    <div class="form_area">
    <div class="form_headind">You need to confirm your account to open your shop.</div>
    
    <div class="input_area">
    <input type="text" />
    <input type="button" name="resend" value="Resend Confirmation Email" class="coinfie_utton_ema" />
    
    
    </div>
    
    </div>
    </div>
    <input type="button" name="previous" class="previous action-button" value="Previous" />
            <input type="button" name="next" class="next action-button" value="Next" />
        </fieldset>-->
        
        
        <fieldset>
            <div class="body_area">   
            	<div class="body_heading">
                <h3>Choose how you want to pay your bill.</h3>
                The items you've listed will be added to your Etsy bill. At the end of each month, we add up your fees from publishing listings and transaction fees.
                </div> 
                <div class="form_area">
                    <div class="form_headind">
                        Enter the credit card you want to use to pay your bill.               
                    </div>                      
                    <div class="cta_area cta_area_nome">
                        <div class="card_left_col">
                        	<div class="cadr_infop_tilte">Credit Card Information</div>
                            <div class="formarea_inner formarea_inner_wide">
                                <ul>                                
                                    <li>
                                        <label>Card Number</label>
                                        <div class="customselect_area2">
                                        	<input type="text" name="title" class="required input_ful_wid">    
                                        </div>  
                                    </li>
                                    <li>
                                        <label>Expiration Date</label>
                                        <div class="customselect_area2 selectsamll_area" style="margin-left:0px;">
                                        	<input type="text" name="title" class="required input_ful_wid">    
                                        </div>
                                        <div class="customselect_area2 selectsamll_area selectsamll_area_rght">
                                        	<input type="text" name="title" class="required input_ful_wid">    
                                        </div>  
                                    </li>
                                    <li>
                                        <label>CCV</label>
                                        <div class="customselect_area2 selectsamll_area" style="margin-left:0px;">
                                        	<input type="text" name="title" class="required input_ful_wid">    
                                        </div>                                          
                                    </li> 
                                    <li>
                                        <label>Name on Card</label>
                                        <div class="customselect_area2">
                                        	<input type="text" name="title" class="required input_ful_wid">    
                                        </div>  
                                    </li>                                                             
                                </ul>
                            </div>
                            
                            <div class="cadr_infop_tilte">Billing Address</div>
                            <div class="formarea_inner formarea_inner_wide">
                                <ul>                                
                                    <li>
                                        <label>Country</label>
                                        <div class="customselect_area2">   
                                        	<span>                                     	
                                                <select class="input_ful_wid">
                                                    <option value="1">Select Country</option>
                                                    <option value="1">India</option>
                                                </select> 
                                            </span>
                                        </div>  
                                    </li>
                                    <li>
                                        <label>Street</label>
                                        <div class="customselect_area2">
                                        	<input type="text" name="title" class="required input_ful_wid">    
                                        </div>  
                                    </li>
                                    <li>
                                        <label>Apt / Suite / Other </label>
                                        <div class="customselect_area2">
                                        	<input type="text" name="title" class="required input_ful_wid">    
                                        </div>  
                                    </li>
                                    <li>
                                        <label>City</label>
                                        <div class="customselect_area2">
                                        	<input type="text" name="title" class="required input_ful_wid">    
                                        </div>  
                                    </li>
                                    <li>
                                        <label>State / Province / Region</label>
                                        <div class="customselect_area2">
                                        	<input type="text" name="title" class="required input_ful_wid">    
                                        </div>  
                                    </li>
                                    <li>
                                        <label>Zip / Postal code</label>
                                        <div class="customselect_area2">
                                        	<input type="text" name="title" class="required input_ful_wid">    
                                        </div>  
                                    </li>                                                          
                                </ul>
                            </div>
                        </div>
                        <div class="card_right_col card_right_col_border">
                        	<div class="left_sec_old">
                            	<span class="dolor_value_in">$0.20</span>
                                <span class="dolousd">USD</span>
                            </div>
                            <div class="shop_now_bt">
                            	<a href="#">Shop Vehicles</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="body_area body_area_botom">               	
                <div class="form_area">
                    <div class="form_headind">
                        Or use PayPal for billing.
                        <span>You authorize your PayPal account to pay your Etsy bill and confirm that you accept our <a href="#">Terms of Use.</a>         </span>
                    </div>
                    
                    <div class="cta_area cta_area_nome">
                        <div class="catr_link catr_link_left">
                            <a href="#">Authorize PayPal Account </a>
                        </div>             
                    </div>
                    
                </div>
            </div>
            <input type="button" name="previous" class="previous action-button" value="Previous" />
            <input type="button" name="next" class="next action-button" value="Next" />
        </fieldset>
    </div>        
</form>
    
        
    
    
</div>



<script src="public/js/jquery.easing.min.js" type="text/javascript"></script> 
<script>
$(function() {

//jQuery time
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches

$(".next").click(function(){
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	next_fs = $(this).parent().next();
	
	//activate next step on progressbar using the index of next_fs
	$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
	
	//show the next fieldset
	next_fs.show(); 
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale current_fs down to 80%
			scale = 1 - (1 - now) * 0.2;
			//2. bring next_fs from the right(50%)
			left = (now * 50)+"%";
			//3. increase opacity of next_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'transform': 'scale('+scale+')'});
			next_fs.css({'left': left, 'opacity': opacity});
		}, 
		duration: 800, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeInOutBack'
	});
});

$(".previous").click(function(){
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	previous_fs = $(this).parent().prev();
	
	//de-activate current step on progressbar
	$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
	
	//show the previous fieldset
	previous_fs.show(); 
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale previous_fs from 80% to 100%
			scale = 0.8 + (1 - now) * 0.2;
			//2. take current_fs to the right(50%) - from 0%
			left = ((1-now) * 50)+"%";
			//3. increase opacity of previous_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'left': left});
			previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
		}, 
		duration: 800, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeInOutBack'
	});
});

$(".submit").click(function(){
	return false;
})

});
</script>


<?php
/*
<script src="{{ URL::asset('public/js/jquery.validate.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#addshop").validate({
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
    });
</script>

<section>
    <div class="top_menus">
        <div class="wrapper">
            <div class="acc_bar">
                <div class="ad_right">
                    <h2>Welcome!</h2>
                    <h1><?php echo $userData->first_name . ' ' . $userData->last_name; ?></h1>
                </div>
                <div class="acc_setting">
                    @include('elements/shop_menu')
                </div> 

                <div class="informetion">
                    <div id="formloader" class="formloader" style="display: none;">
                        {{ HTML::image('public/img/loader_large_blue.gif','', array()) }}
                    </div>
                    {{ View::make('elements.actionMessage')->render() }}
                    <div class="informetion_top">
                        
                    <b>Shop Name </b>
                    <br>
                    <font>Your shop name appears with your items in the Etsy marketplace. 
                    Pick a name that has personal significance or helps identify what's in your shop.</font>
                    
                    {{ Form::model($shopData,array('url' => 'user/openashop/', 'method' => 'post', 'id' => 'addshop', 'files' => true,'class'=>"cmxform form-horizontal tasi-form form")) }}
                    
                    <div class="form_group">
                        {{ HTML::decode(Form::label('name_shop', "Shop Name <span class='require'>*</span>",array('class'=>"control-label col-lg-2"))) }}
                        <div class="in_upt emasce">
                            {{ Form::text('name_shop', Input::old('name_shop'), array('class' => 'required form-control')) }}
                        </div>
                    </div>
                    {{ Form::submit('Save', array('class' => "btn btn-danger")) }}
                    {{ Form::close() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
*/?>
@stop