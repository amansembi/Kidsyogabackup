<?php

//require_once("../../../wp-load.php");
//require_once('stripe/vendor/autoload.php');
	
	
/* Template Name: Payment Details */
get_header();

require_once('wp-config.php');
session_start();
	$monthpriceID =  MONTH_PRODUCT;
	$yearpriceID = YEAR_PRODUCT;
global $wpdb;

?>

<div id="mainsite">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
 
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
		the_content();
		endwhile; else: ?>
		<p>Sorry, no posts matched your criteria.</p>
	<?php endif; ?>
</div>
<?php

//print_r($_SESSION["to_email"]);
	if($_SESSION["type"] == "Gift_Card")
	{   
        $todaydate = date("Y-m-d");
		$type = $_SESSION["type"];
        $amount = $_SESSION["amount"]; 
        $price = $_SESSION["amount"]; 
		$user_id = $_SESSION["user_id"]; 
		$card_id = $_SESSION["card_id"];  
		$last_insert_id = $_SESSION["lastid"]; 
		$to_email =  $_SESSION["to_email"];  
	}elseif($_GET['type'] == 'BuyPlan'){
		$type = $_GET['type'];
		//$change_type = $_GET['change_type'];
        $userID = $_GET['userID'];
        $selling_price = $_SESSION["selling_price"]; 
        $price = $_SESSION["selling_price"]; 
        $todaydate = date("Y-m-d");
        $status =  $_SESSION["status"];
		$cart_id = $_SESSION["cart_id"];;  	
		//print_r($status);
	}elseif($_GET['type'] == 'change_subscription_plan'){
		$type = $_GET['type'];
		//$change_type = $_GET['change_type'];
        $userID = $_GET['userID'];
        $selling_price = $_SESSION["selling_price"]; 
        $price = $_SESSION["selling_price"]; 
        $todaydate = date("Y-m-d");
        $status =  $_SESSION["status"];
		$cart_id = $_SESSION["cart_id"];;  	
		//print_r($status);
	}

?>

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-5">
			<div class="pymntform pt40 pb60">
				<div class="discount_price">
					<p><small>You have to pay: <?php echo '$'.$price; ?></small></p>
				</div>
				<form>
					<div class="formfield">
						<label>Enter card details</label>
						<input type="text" placeholder="Card Info xxxx-xxxx-xxxx-xxxx" class="formcontrol cart_num" name="cart_num" maxlength="16">					
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="formfield">							
								<input type="text" placeholder="MM/YY" class="formcontrol card_mnth" name="card_mnth" maxlength="5">	
							</div>
						</div>
						<div class="col-md-6">
							<div class="formfield">
								<input type="text" placeholder="CVC" class="formcontrol" class="formcontrol card_cvv" name="card_cvv"  maxlength="3">	
							</div>
						</div>
					</div>
					<div class="formfield">
						<input type="text" placeholder="Name of card" class="formcontrol card_name" name="card_name" >					
					</div>
					<div class="formfield">
						<label>Your address details</label>
						<input type="text" placeholder="Address Lane 1" class="formcontrol card_adrs" name="card_adrs" >					
					</div>
					<div class="formfield">						
						<input type="text" placeholder="City" class="formcontrol card_city" name="card_city" >					
					</div>
					<div class="formfield">						
						<input type="text" placeholder="State" class="formcontrol card_state" name="card_state" >					
					</div>
					<div class="formfield">						
						<input type="text" placeholder="Zip code" class="formcontrol card_zip" name="card_zip" >					
					</div>
					<!--<div class="formfield">						
						<input type="text" placeholder="Country" class="formcontrol card_country" name="card_country" value="india">					
					</div>--->
					<div class="formfield">
					 
					  <?php 
						  $countries = $wpdb->get_results("SELECT * FROM wp_country");
						  ?>
					  <select id="multiple" class="js-states form-control card_country" name="card_country" >
					  <option value="">Select Country</option>
					   <?php foreach($countries as $country){ ?>
						<option value="<?php echo $country->name; ?>"><?php echo $country->name; ?></option>
						 <?php } ?>
					  </select>
					  <p><small class="country_id errorfield"></small></p>
					</div>
					<div class="formfield">
						<input type="hidden" name="childUrl" class="childUrl" value="<?php echo get_theme_file_uri();  ?>">
						<input type="hidden" name="addprofileurl" class="addprofileurl" value="<?php echo get_home_url().'/add-profile-1/'; ?>">	
						<input type="hidden" name="gifturlredirect" class="gifturlredirect" value="<?php echo get_home_url().'/gift-cards/'; ?>">	
						<input type="button" value="Start Trial" class="formcontrol sbmtbtn <?php echo $type; ?>" id=" ">
						<input type="hidden" value="<?php echo $status; ?>" class="formcontrol" id="subscribe_type">
						<input type="hidden" value="<?php echo $price; ?>" class="formcontrol" id="cr_price">
						<input type="hidden" class="changeplanredirection" value="<?php echo get_home_url().'/my-classes/'; ?>">
						<div class="payment-success" style="color:green;"><small></small></div>
						<div class="payment-fail" style="color:red;"><small></small></div>

					</div>
				</form>
				<div class="pymntbtmtxt pt20">
					<p>If you don’t cancel your trial, you will be charged <?php echo '$'.$price; ?>, starting from <?php echo $todaydate; ?></p>  
				</div>
			</div>	
		</div>		
	</div>	
</div>
<div class="modal fade logsuccs" id="giftcartsend" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
		<span><i class="fa fa-check" aria-hidden="true"></i></span>
        <p>Sent gift card successfully</p> 
      </div>
      
    </div>
  </div>
</div>


<script type="text/javascript">

$("#multiple").select2({
         placeholder: "Select a Country",
          allowClear: true
      });


jQuery(document).ready(function($){	
   var childUrl = $('.childUrl').val();
   var controllerPath = childUrl+'/ajaxController.php';
   var gifturlredirect = $('.gifturlredirect').val();
   var changeplanredirection = $('.changeplanredirection').val();
 $('.Gift_Card').click('body', function(){
 
   var cart_num =  $('.cart_num').val();
   var card_mnth =  $('.card_mnth').val();
   var card_cvv = $('.card_cvv').val();
   var card_name = $('.card_name').val();
   var card_adrs = $('.card_adrs').val();
   var card_city = $('.card_city').val();
   var card_state = $('.card_state').val();
   var card_zip = $('.card_zip').val();
   var card_state = $('.card_state').val();
   var card_country = $('.card_country').val();
   var userID = '<?php echo $user_id;  ?>';
   var lastid = '<?php echo $last_insert_id;  ?>';
   var amount = '<?php echo $amount;  ?>';
   var to_email = '<?php echo $to_email;  ?>';
   
   $('.sbmtbtn').prop('disabled', true);

    $.ajax({
          type:"post",
          url:controllerPath,
          data:{type:'Buy_Card',user_id:userID,lastid:lastid,amount:amount,to_email:to_email,cart_num:cart_num,card_mnth:card_mnth,card_cvv:card_cvv,card_name:card_name,card_adrs:card_adrs,card_city:card_city,card_state:card_state,card_zip:card_zip,card_country:card_country},
          success:function(res){
			  $('#giftcartsend').modal();
			  console.log(res);
			setTimeout( function(){ 
			
          	window.location.href = gifturlredirect;
			}  , 2000 );
            
          }
        });
 });

  $('.BuyPlan').click('body', function(){
	  var type = '<?php echo $type;  ?>';
	  var userID = '<?php echo $userID;  ?>';	 
	 var cart_num =  $('.cart_num').val();
	 var card_mnth =  $('.card_mnth').val();
	 var card_cvv = $('.card_cvv').val();
	 var card_name = $('.card_name').val();
	 var card_adrs = $('.card_adrs').val();
	 var card_city = $('.card_city').val();
	 var card_state = $('.card_state').val();
	 var card_zip = $('.card_zip').val();
	 var card_state = $('.card_state').val();
	 var card_country = $('.card_country').val();
	 var addprofileurl = $('.addprofileurl').val();
	  
	$('.sbmtbtn').prop('disabled', true);
	 
     var amount = '<?php echo $selling_price;  ?>';
	 
	
	$('.payment-success small').text('');
	$('.payment-fail small').text('');
     var subscribe_type =  $('#subscribe_type').val();
      $.ajax({
          type:"post",
          url:controllerPath,
          data:{type:'BuyPlan',user_id:userID,subscribe_type:subscribe_type,amount:amount,cart_num:cart_num,card_mnth:card_mnth,card_cvv:card_cvv,card_name:card_name,card_adrs:card_adrs,card_city:card_city,card_state:card_state,card_zip:card_zip,card_country:card_country,},
          success:function(res){
			 if($.trim(res)=='true'){
				 $('.payment-success small').text('Payment Successed');
	
			 }else if(res=='false'){
				 $('.payment-fail small').text('Payment Failed');
			 }else if(res=='somthing_wrong'){
				 $('.payment-fail small').text('Somthing Wrong');
			 }
         	window.location.href = addprofileurl;
            console.log(res);
          }
        });

  });
  
  $('.change_subscription_plan').click('body', function(){
	  
		var type = '<?php echo $type;  ?>';
		var userID = '<?php echo $userID;  ?>';	 
		var cart_num =  $('.cart_num').val();
		var card_mnth =  $('.card_mnth').val();
		var card_cvv = $('.card_cvv').val();
		var card_name = $('.card_name').val();
		var card_adrs = $('.card_adrs').val();
		var card_city = $('.card_city').val();
		var card_state = $('.card_state').val();
		var card_zip = $('.card_zip').val();
		var card_state = $('.card_state').val();
		var card_country = $('.card_country').val();
	  
	
	 
     var amount = $('.cr_price').val();
	 
	$('.sbmtbtn').prop('disabled', true);
	$('.payment-success small').text('');
	$('.payment-fail small').text('');
     var subscribe_type =  $('#subscribe_type').val();
      $.ajax({
          type:"post",
          url:controllerPath,
          data:{type:'change_subscription_plan',user_id:userID,subscribe_type:subscribe_type,amount:amount,cart_num:cart_num,card_mnth:card_mnth,card_cvv:card_cvv,card_name:card_name,card_adrs:card_adrs,card_city:card_city,card_state:card_state,card_zip:card_zip,card_country:card_country,},
          success:function(res){
			 if($.trim(res)=='true'){
				 $('.payment-success small').text('Plan change successfully');
	
			 }else if(res=='false'){
				 $('.payment-fail small').text('Payment Failed');
			 }
			setTimeout( function(){ 
         	window.location.href = changeplanredirection;
			 }  , 2000 );
            //console.log(res);
          }
        });

  });
});






/*
 jQuery('body').on('click','#card_using',function(){

    	if(typeof jQuery('input[name="term_condation"]:checked').val() === 'undefined'){ 
				jQuery('.termandcon').html('Term and condations is reqired');
    		return false;
    	}

		jQuery('.loaderpayment').show();
		jQuery('body').addClass('loader1');

    	var paymentmode = jQuery('input[name="paymentmode"]:checked').val();    	
    	var total_price = jQuery('input[name="total_price"]').val();    	
    	var handler = StripeCheckout.configure({
			key: 'pk_test_kPDsfnD4bJSOVlsveTvSUTXO', 
			locale: 'auto',
			token: function (token) {
					jQuery('#strip_paymet_token').html(JSON.stringify(token));
					var formdata = jQuery( "form#servicesBookingForm" ).serialize();  
					jQuery.ajax({
			            type:"POST",
			            url:"<?php //echo plugins_url(); ?>/services-booking/ajax/stripe-payment.php",
			            data:{tokenId:token.id,formdata:formdata},
			            success:function(res){     
			            	console.log(res);
			            	var response = JSON.parse(res);	
			            	if(response.msg == 'success'){
			            		jQuery('.loaderpayment').hide();
								jQuery('body').removeClass('loader1');
			            		Swal.fire(
								  'Booking is success',
								  'Booking id:'+response.bookid,
								).then(function() { location.reload(true); });
			            	}		            	
			            }
			        });
				}
		});
		handler.open({
			name: 'Stripe Payment',		
			amount: total_price * 100,
			closed: function () {
                  jQuery('.loaderpayment').hide();
				  jQuery('body').removeClass('loader1');
                }
           
         });       
    });*/

</script>
<?php get_footer();