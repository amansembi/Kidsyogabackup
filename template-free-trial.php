<?php
/* Template Name: Free Trial */

get_header(); 
 session_start();?>


<div id="mainsite">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
		the_content();
		endwhile; else: ?>
		<p>Sorry, no posts matched your criteria.</p>
	<?php endif; ?>
</div>
<?php 
	if ( is_user_logged_in() ) {
        $current_user = wp_get_current_user();
        $userID = $current_user->ID;
    } 
	
	if(isset($_GET['price'])){
	$homepopprice = $_GET['price']; 
	}else{
	$homepopprice = '';
	}

	$_SESSION["username"];
    $_SESSION["userID"];

	
?>
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-5">
			<div class="freetrialform pt40 pb30">
				<form>
				<?php
					
					$args = array( 'post_type' => 'plans','post_status' => 'publish', 'posts_per_page' => 10, 'orderby' => 'date', 'order' => 'ASC');
					$loop = new WP_Query( $args );
					while ( $loop->have_posts() ) : $loop->the_post();
					$price = get_post_meta( get_the_ID(), 'price', true );
						$valid = get_post_meta( get_the_ID(), 'valid', true );
						$title = get_the_title();						
						
						?>
					<div class="formfield radiofield posrel">
						<?php if($homepopprice == $price){ ?>
						<input type="radio" id="monthly-20" name="monthly" value="<?php echo $price; ?>" data="<?php echo $valid; ?>" class="formcontrol monthly" checked>
						<?php }else{ ?>
						<input type="radio" id="monthly-20" name="monthly" value="<?php echo $price; ?>" data="<?php echo $valid; ?>" class="formcontrol monthly" >
						<?php } ?>
						<input type="hidden" value="<?php echo $userID; ?>" class="loggedin_user">
						<span class="posabs"><?php echo $title; ?></span>
					</div>
					<?php
						 endwhile;					
					?>
					
					
					<div class="formfield">
						<label>Have a promo code?</label>
						<input type="text" value="" placeholder="Enter Your Promo Code" class="formcontrol promo-code">
						<input type="hidden" name="checkoutUrl" class="checkoutUrl" value="<?php echo get_home_url().'/payment-details'; ?>">
						<input type="hidden" name="username" class="username" value="<?php echo $_SESSION["username"]; ?>">
						
					</div>
					<div class="formfield">
						<input type="button" value="Continue" class="formcontrol sbmtbtn continue">	
							<div class="promo_code_expire" style="color:red;"><small></small></div>
					</div>
				</form>
			</div>
			<div class="freetrialbtmtxt">
				<p>By clicking “Continue” you agree to our <a href="#">Terms of service</a>, <a href="#">Privacy policy</a> and to receive our email updates.</p>	
			</div>			
		</div>		
	</div>	
</div>
<script>
$('.freetrialform .sbmtbtn').on('click',function() {
		var rate = $('.freetrialform input[name=monthly]:checked').val();
		var trialtime = $('.freetrialform input[name=monthly]:checked').attr('data');
		var promoCode = $('.promo-code').val();
		var loggedin_user = $('.loggedin_user').val();
		var checkoutUrl = $('.checkoutUrl').val();
		//alert(rate);
		var username = $('.username').val();		
		if(promoCode){
			var promoCode = promoCode;
		}else{
			var promoCode = '';
		}
		if(rate){
			$('.freetrialform .sbmtbtn').prop('disabled', true);
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
					window.location=checkoutUrl+'/?userID='+loggedin_user+'&type=BuyPlan ';				
				}else if(msg == 'expire'){
					$('.promo_code_expire small').text('Promo code is expire');
				}				
	  }
    });
		}else{
			$('.promo_code_expire small').text('Please select the billing plan.');
		}
});
</script>
<?php get_footer();