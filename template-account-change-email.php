<?php
/* Template Name: Account Change Email */
get_header();
session_start();
global $current_user;  
$update_parent_user_id = $_SESSION["update_parent_user_id"];
$oldEmail = $current_user->data->user_email;
$userid = $current_user->data->ID;
$new_user = wp_get_current_user();
$userid1 = $new_user->data->ID;

//echo "<pre>"; print_r($current_user->data->user_email); die;
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
			<div class="signupform pt40 pb60">
				<div class="crntemail d-flex justify-content-between align-items-center pb50 fontlato font16">
					<div class="crntemaillt">
						Current Email
					</div>
					<div class="crntemailrt aman">
						<?php  echo $oldEmail; ?>
					</div>
				</div>
				<form method="post">					
					<div class="formfield">
						<input type="text"  name="email" placeholder="Enter your new mail" class="formcontrol new_email" value="">
						<input type="hidden"  name="update_parent_user_id " placeholder="Enter your new mail" class="formcontrol update_parent_user_id" value="<?php echo $update_parent_user_id;  ?>">	
						<input type="hidden" name="update_parent_user_id" class="update_parent_user_id" value="<?php echo $update_parent_user_id; ?>">
						<input type="hidden" name="addprofileurl" class="addprofileurl" value="<?php echo get_home_url().'/account-change-email/'; ?>">
						<input type="hidden" name="childUrl" class="childUrl" value="<?php echo get_theme_file_uri();  ?>">

					<!--	<input type="text"  name="email" placeholder="past her confirmation code" class="formcontrol new_email" value="" style="margin-top: 15px;">-->

					</div>					
					<div class="formfield">
						<input type="button" name="signIn" value="Send Email Verification Code" class="formcontrol sbmtbtn change_mail">	
						<div class="mailsend_msg"></div>				
					</div>
				</form>				
			</div>	
		</div>		
	</div>	
</div>
<script type="text/javascript">
	jQuery(document).ready(function($){	
       $('.change_mail').click('body', function(){
       	var childUrl = $('.childUrl').val();
       		var controllerPath = childUrl+'/ajaxController.php';
       	    var parent_user_id = $('.update_parent_user_id').val();
       	    var addprofileurl = $('.addprofileurl').val();
       	    var new_email = $('.new_email').val();
       	     $.ajax({
	          type:"post",
	          url:controllerPath,
	          data:{type:'change_mail',parent_user_id:parent_user_id,new_email:new_email},
	          success:function(res){
				  if(res == 1){
					 $(".mailsend_msg").html("<small style='color:green;'>Please check your previous email Associated with this website.</small>"); 
				  }
	         	console.log(res);
	          }
	        });
       });
	});
</script>
<?php get_footer();