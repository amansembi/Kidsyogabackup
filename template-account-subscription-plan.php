<?php
/* Template Name: Account Subscription Plan */
get_header(); 

global $wpdb; 

$current_user = wp_get_current_user();
        $userID = $current_user->ID;
        $user_login = $current_user->user_login;
//print_r($user_login);
function findDay($start_date,$end_date){
	$diff = date_diff($start_date,$end_date);
			$finaldays = $diff->format("%a");
			return $finaldays;
			//print_r($todaydate);
}
$plan_details = $wpdb->get_results("SELECT * FROM wp_user_subscriptions WHERE user_id = '$userID'");
//print_r($plan_details);
$subscription_id = $plan_details[0]->subscription_id;
$subscription_amount = $plan_details[0]->subscription_amount;
$plan_id = $plan_details[0]->plan_id;
$trail_ends_at = $plan_details[0]->trail_ends_at;
$subscription_end_at = $plan_details[0]->subscription_end_at;
$todaydate = date("Y-m-d h:i:s");
$subscription_deleted = get_user_meta($userID,'subscription_deleted',true);
$subscription_end_at = date_create($subscription_end_at); 
$start_date = date_create($trail_ends_at); 
$end_date   = date_create($todaydate);
$trilerestdays = findDay($start_date,$end_date);
$subscriptionrestdays = findDay($subscription_end_at,$end_date);
//print_r($subscriptionrestdays);
?>


<div class="container">
	<div class="acntpagetitlehead d-flex justify-content-between pt60">
		<div class="acntpagetitle">
			<h1><?php the_title();?></h1>		
		</div>
		<div class="acntpageback font14">
			<a href="<?php echo get_home_url().'/account/'; ?>"><i class="fa fa-long-arrow-left"></i><strong>Back to Account Settings</strong></a>	
		</div>
	</div>
</div>

<div id="mainsite">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
		the_content();
		endwhile; else: ?>
		<p>Sorry, no posts matched your criteria.</p>
	<?php endif; ?>
</div>

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-5">
			<div class="signupform subscrp_pln pt40 pb60">				
				<form>
				<?php
					
					$args = array( 'post_type' => 'plans','post_status' => 'publish', 'posts_per_page' => 10, 'orderby' => 'date', 'order' => 'ASC');
					$loop = new WP_Query( $args );
					while ( $loop->have_posts() ) : $loop->the_post();
					$price = get_post_meta( get_the_ID(), 'price', true );
						$valid = get_post_meta( get_the_ID(), 'valid', true );
						$title = get_the_title();						
						
						?>
				<?php 
				
				if($plan_id == 'price_1IfIWgA5JkmCD4ai9O77pxZH' || $subscription_deleted == 'canceled'){ 
				
				
				?>
					<div class="formfield radiofield posrel">
					
						<?php if($subscription_amount == $price){ ?>
						<input type="radio" id="monthly-20" name="monthly" value="<?php echo $price; ?>" data="<?php echo $valid; ?>" class="formcontrol monthly" checked>
						<?php }else{ ?>
						<input type="radio" id="monthly-20" name="monthly" value="<?php echo $price; ?>" data="<?php echo $valid; ?>" class="formcontrol monthly" >
					<?php } ?>
						<input type="hidden" value="<?php echo $userID; ?>" class="loggedin_user">
						<span class="posabs"><?php echo $title; ?></span>
					</div>
					
					<?php
					} 
						 endwhile;					
					?>
					<input type="hidden" name="username" class="username" value="<?php echo $user_login; ?>">
					<input type="hidden" name="checkoutUrl" class="checkoutUrl" value="<?php echo get_home_url().'/payment-details'; ?>">
					<input type="hidden" name="childUrl" class="childUrl" value="<?php echo get_theme_file_uri(); ?> ">					
					<input type="hidden" class="userid_in_popup" value="<?php echo $userID; ?>" id="userid_in_popup">
					<input type="hidden" class="subscription_deleted" value="<?php echo $subscription_deleted; ?>" id="subscription_deleted">
					
					<div class="formfield radiofield posrel">
					<?php if($subscription_deleted == 'canceled'){ ?>
						<input type="radio" id="monthly-15" name="monthly" value="cancelsub" data="cancelsub" class="formcontrol yearly" disabled>
						<?php }else{ ?>
						<input type="radio" id="monthly-15" name="monthly" value="cancelsub" data="cancelsub" class="formcontrol yearly">						
						<?php } ?>						
						<span class="posabs">Cancel your subscription</span>
					</div>					
					<div class="formfield">
						<input type="button" value="Change Plan" class="formcontrol sbmtbtn normalcase continue">					
					</div>
				</form>
				<div class="font14 text-center pt20">
					This new plan will begin at the end of the payment cycle of your current plan. 
				</div>
			</div>	
		</div>		
	</div>	
</div>
<div class="modal fade aftvideomodl" id="cancelPlan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      <div class="modal-body subcript">
        <h3>Cancel your subscription?</h3>
		<p>Are you sure, you want to cancel your subscription?</p>
		<div class="cancel_user_responding"></div>
		<div class="modl_btn d-flex">
			<button type="button" class="back_btn" style="background: transparent !important;color: #FF5757 !important;border: none;">Go Back</button>
			<button type="button" class="confirm_cancellation">Confirm cancellation</button>
		</div>
      </div>      
    </div>
  </div>
</div>
<script>
$('.subscrp_pln .sbmtbtn').on('click',function() {
		var rate = $('.subscrp_pln input[name=monthly]:checked').val();
		var trialtime = $('.subscrp_pln input[name=monthly]:checked').attr('data');		
		var loggedin_user = $('.loggedin_user').val();
		var checkoutUrl = $('.checkoutUrl').val();
		var childUrl = $('.childUrl').val();
		var username = $('.username').val();
		var controllerPath = childUrl+'/ajaxController.php';
			var promoCode = '';
		
		if(rate != 'cancelsub'){
			$('.subscrp_pln .sbmtbtn').prop('disabled', true);
			
			jQuery.ajax({
				type: "post",
				url: my_ajax_object.ajax_url,
				
				data: { 
					  action: 'check_promo_code',
					  trialtime:trialtime,			 	  
					  promoCode:promoCode,			  
					  loggedin_user:loggedin_user,			  
					  rate:rate,			  
					},
				success: function(msg){
					console.log(msg);
					if(msg){
						//window.location=checkoutUrl+'/?userID='+loggedin_user+'&price='+msg+'&type=BuyPlan ';				
						window.location=checkoutUrl+'/?userID='+loggedin_user+'&type=change_subscription_plan';				
					}else if(msg == 'expire'){
						$('.promo_code_expire small').text('Promo code is expire');
					}				
		  }
		});
		}else if(rate == 'cancelsub'){
			$('#cancelPlan').modal();
		}else{
			$('.promo_code_expire small').text('Please select the billing plan.');
		}
});



$('.confirm_cancellation').click(function(){		   
		    $('.confirm_cancellation').prop('disabled', true);
		  
       	  	var childUrl = $('.childUrl').val();
			var userId = $('#userid_in_popup').val();
			var subscription_deleted = $('#subscription_deleted').val();
			//alert(userId);
			
			var controllerPath = childUrl+'/ajaxController.php';
			
			if(subscription_deleted == 'canceled'){
				$('.cancel_user_responding').html('<small style="color:#FF5757">Sorry! User is already canceled</small>');
			}else{
			$.ajax({
			  type:"post",
			  url:controllerPath,
			  data:{type:'cancel_user',userId:userId},
			  success:function(res){
				 if(res){
					$('.cancel_user_responding').html('<small style="color:green">User cancel successfully</small>'); 
				 }
				console.log(res);
			  }
			});
			}
       });
</script>

<?php get_footer();