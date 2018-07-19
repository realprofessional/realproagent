@section('title', 'Administrator :: '.TITLE_FOR_PAGES.'Add Caterer')
@section('content')
<div class="clear"></div>
<link rel="stylesheet" href="../public/css/front/jquery.jqzoom.css" type="text/css">
<script src="../public/js/jquery-1.6.js" type="text/javascript"></script>
<script src="../public/js/jquery.jqzoom-core.js" type="text/javascript"></script>
<div class="stade">
    <div class="bodybg bodybg_mar">
    	<div class="wrapper">
        	<div class="overview_left_sec">
            	<div class="overview_user_top_box">
                	<div class="overview_user_top_box_user_img">
                    	<img src="../public/img/front/fav_user_imf.png" alt="img" />
                    </div>
                    <div class="overview_user_top_box_name_box">
                    	<div class="overview_user_top_box_name">AlokShop</div>
                        <div class="overview_user_top_box_favourite">Favorite Shop</div>
                    </div>
                </div>
                <div class="clear"></div>
                
                <a href="../public/img/front/stock-photo.jpg" class="jqzoom" rel='gal1'  title="triumph" >
            <img src="../public/img/front/stock-photo.jpg"  title="triumph"  style="border: 4px solid #666;">
        </a>
                <ul id="thumblist" class="zoom_overview_box" >
                <li><a class="zoomThumbActive" href='javascript:void(0);' rel="{gallery: 'gal1', smallimage: '../public/img/front/stock-photo.jpg',largeimage: '../public/img/front/stock-photo.jpg'}"><img src='../public/img/front/stock-photo.jpg'></a></li>
                <li><a class="" href='javascript:void(0);' rel="{gallery: 'gal1', smallimage: '../public/img/front/add_img_sec.png',largeimage: '../public/img/front/image_zoom_thumg.png'}"><img src='../public/img/front/add_img_sec.png'></a></li>
                <li><a class="" href='javascript:void(0);' rel="{gallery: 'gal1', smallimage: '../public/img/front/add_img_sec.png',largeimage: '../public/img/front/image_zoom_thumg.png'}"><img src='../public/img/front/add_img_sec.png'></a></li>
            </ul>
                
            </div>
            
            <div class="overview_right_sec">
            	<div class="form_area form_area_topp ">
                    <div class="form_headind">Name of Item
                    	<span class="title_dor_rate">$5.00 USD</span>
                    </div>
                    <div class="cta_area cta_area_nome">
                        <div class="data_intdfsdf">Only 1 available</div>         
                        <div class="data_intdfsdf_title">Overview:</div>  
                        
                        <div class="bullet_div_show_faya">
                        	<ul>
                            	<li>Handmade item</li>
                                <li>Ships worldwide from India</li>
                                <li>Pure Leather</li>
                                <li>Original Material</li>
                                <li>Good Quality</li>
                            </ul>
                        </div>  
                        <div class="cart_link_bnox">
                        	<div class="catr_link">
	                        	<a href="#">Add to Cart</a>
                            </div>
                        </div>                    
                    </div>
                </div>
                <div class="spacerr"></div>
                <div class="form_area form_area_topp ">
                	<div class="top_desc_menuss">
                        	<ul>
                            	<li id="descrip_link" class="active">description</li>
                                <li id="shipping_link">Shipping &amp; Policies</li>
                            </ul>
                        </div>
                    <div class="cta_area cta_area_nome">
                    	<div class="content_fomr_showe active" id="description">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.  
                        </div>  
                        <div class="content_fomr_showe" id="shipping">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled i
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clear"></div>

<!--
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->
<script>
$(document).ready(function(){
    $("#descrip_link").click(function(){
        $("#description").show();
		$("#shipping").hide();
		
		$("#descrip_link").addClass("active");
		$("#shipping_link").removeClass("active");
    });
    $("#shipping_link").click(function(){
        $("#description").hide();
		$("#shipping").show();
		
		$("#shipping_link").addClass("active");
		$("#descrip_link").removeClass("active");
    });
});
</script>


<script type="text/javascript">

$(document).ready(function() {
	$('.jqzoom').jqzoom({
            zoomType: 'standard',
            lens:true,
            preloadImages: false,
            alwaysOn:false
        });
	
});


</script>

@stop