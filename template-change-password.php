<?php
/* Template Name: Change Password */
get_header(); ?>
<div class="acntpageback font14">
			<a href="<?php echo get_home_url().'/account/'; ?>"><i class="fa fa-long-arrow-left"></i><strong>Back to Account Settings</strong></a>	
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
			<div class="frgtpswrdform pt40 pb60">
			
				<form method="post">
					<div class="formfield">
						<input type="Password" placeholder="Password" name="new_pass" class="formcontrol" value="">					
					</div>	
					<div class="formfield">
						<input type="Password" placeholder="Confirm Password" name="confrm_pass" class="formcontrol" value="">

						<input type="hidden" placeholder="key" class="autKey" name="autKey" class="formcontrol" value="">		
						<input type="hidden" placeholder="userID" id="userID" name="userID" class="formcontrol" value="">
					</div>									
					<div class="formfield">
						<input type="submit" value="Reset Password" name="Resetpass" class="formcontrol sbmtbtn">
						<div class="mailsend_msg"><small style='color:red;'></small></div>
						<div class="smailsend_msg"><small style='color:green;'></small></div>
					</div>
				</form>
				<div class="formbtmnav text-uppercase pt20">
					<ul class="d-flex justify-content-between">
						<li><a href="<?php echo get_home_url().'/sign-in/'; ?>">Sign In</a></li>
						<li><a href="<?php echo get_home_url().'/sign-up/'; ?>">Sign Up</a></li>
					</ul>
				</div>				 
			</div>				
		</div>		
	</div>	
</div>

<?php
	
	
			 
    if (isset($_POST['Resetpass'])) {
		
		
     	if ($_POST["new_pass"] === $_POST["confrm_pass"] ) {
             $new_pass = $_POST['new_pass'];
             $authKey = $_GET['key'];
             $userids =  $_GET['id'];
             
			 $userID = preg_replace( '/[\W]/', '', $userids);
			 $user = get_user_by('ID',$userID);
			
             //echo $username = $user->data->display_name;
             $user = check_password_reset_key($authKey,$user);
			$password_reset_key = get_user_meta($userID,'password_reset_key',true);
				
				if($password_reset_key == $authKey){
					update_user_meta($userID,'password_reset_key','');
			
				wp_set_password($new_pass,$userID);
				//echo "Password change successfully";
				echo '<script> $(".smailsend_msg small").text("Password change successfully");
						 </script>';
				}else{
					echo '<script> $(".mailsend_msg small").text("Something Wrong");
						 </script>';
				}
                
     	}else{
     		//echo "Password not match please try again !";
			echo '<script> $(".mailsend_msg small").text("Password not match please try again !");
						 </script>';
     	}
    }
?>
<script type="text/javascript">
	// jQuery(document).ready(function($){
		// var authKey = '<?php echo $_GET['key'];  ?>';
		// var userID = '<?php echo $_GET['id'];  ?>';
         // $('#userID').val(userID);
         // $('.autKey').val(authKey);
	// });
</script>

<?php get_footer();