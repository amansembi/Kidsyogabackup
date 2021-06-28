<?php
/* Template Name: Change Payment Method */
get_header();
 global $current_user;
 global $wpdb; 
  $current_userID = $current_user->data->ID;
  $userLoginId = get_current_user_id();
 $user_name =  $first_name . ' ' .  $last_name;
 //$plan_details = $wpdb->get_results("SELECT * FROM wp_user_plan_details WHERE user_id = '$current_userID'");
 $plan_details = $wpdb->get_results("SELECT * FROM wp_card_details WHERE user_id = '$userLoginId'");
 //print_r($planDetails);
 //$data = $plan_details[0]->plan_details;
 //$paymentDetails = json_decode($data);
 $catMont = $plan_details[0]->card_expiry_month;
 
 $catYear = $plan_details[0]->card_expiry_year;
// echo "<pre>"; print_r($paymentDetails->card_mnth);

 $cartNum = $plan_details[0]->card_last_four;
// $cartNum =$plan_details[0]->cart_num;
 //$card_cvv = $plan_details[0]->card_cvv;
 $card_last_digit =  str_pad(substr($cartNum, -4), strlen($cartNum), '*', STR_PAD_LEFT);
 $card_name = $plan_details[0]->card_name;
 //$amount = $plan_details[0]->amount;
 //$subscribe_type = $plan_details[0]->subscribe_type;
?>

<div class="container">
	<div class="acntpagetitlehead d-flex justify-content-between pt60">
		<div class="acntpagetitle">
			<h1><?php the_title();?></h1>		
		</div>
		<div class="acntpageback font14">
			<a href="<?php echo get_home_url(); ?>/account/"><i class="fa fa-long-arrow-left"></i><strong>Back to Account Settings</strong></a>	
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

<div class="container pb100">
	<div class="paymentcardinfo d-flex flex-wrap justify-content-between align-items-center">
    	<div class="lftcardinfo">
			<ul class="d-flex flex-wrap align-items-center">
				<li><?php echo $card_last_digit; ?></li>
				<li><?php echo $card_name; ?></li>
				<li>Name on Card</li>
			</ul>
		</div>
		<div class="editcrdinfobtn">
			<a href="#">Edit Card Info</a>
		</div>
	</div>
	<div class="row justify-content-center">
		<div class="col-md-5">
			<div class="updcrdform pt20">
				<form method="post">					
					<div class="formfield">
						<label>Enter Card Details</label>	
						<input type="text"  name="cardnumber" placeholder="Card Info    xxxx-xxxx-xxxx-xxxx" class="formcontrol cardnumber" value="<?php echo $cartNum; ?>" maxlength="16">					
						<input type="hidden" name="childUrl" class="childUrl" value="<?php echo get_theme_file_uri();  ?>">
					</div>	
					<div class="row">
						<div class="col-md-6">
							<div class="formfield">
								<input type="text"  name="carddate" placeholder="MM/YY" class="formcontrol carddate" value="<?php echo $catMont .'/' . $catYear;?>" maxlength="5" onkeyup="this.value=this.value.replace(/^(\d\d)(\d)$/g,'$1/$2').replace(/^(\d\d\/\d\d)(\d+)$/g,'$1/$2').replace(/[^\d\/]/g,'')">					
							</div>	
						</div>
						<div class="col-md-6">
							<div class="formfield">
								<input type="text"  name="cardcvc" placeholder="CVC" class="formcontrol cardcvc" value="<?php  echo $card_cvv; ?>" maxlength="3">					
							</div>	
						</div>
					</div>
					<div class="formfield">
						<input type="text"  name="nameoncard" placeholder="Name On Card" class="formcontrol nameoncard" value="<?php echo  $card_name; ?>">					
					</div>	
					<div class="formfield">
						<input type="button" name="savecrd" value="Save" class="formcontrol sbmtbtn updatedetails">					
					</div>
				</form>				
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function($){	
       $('.updatedetails').click('body', function(){
       	var childUrl = $('.childUrl').val();
       	    var controllerPath = childUrl+'/ajaxController.php';
       	    var cardnumber = $('.cardnumber').val(); 
       	    var carddate = $('.carddate').val();  
       	    var cardcvc = $('.cardcvc').val();  
       	    var nameoncard = $('.nameoncard').val();
       	    var addprofileurl = $('.addprofileurl').val();
       	     $.ajax({
	          type:"post",
	          url:controllerPath,
	           data:{type:'updatePaymentMethod',cardnumber:cardnumber,carddate:carddate,cardcvc:cardcvc,nameoncard:nameoncard},
	          success:function(res){
	         	window.location.href = addprofileurl;
	            console.log(res)
	          }
	        });
       });
});
</script>
<?php get_footer();