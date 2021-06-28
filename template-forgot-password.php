<?php
/* Template Name: Forgot Password */
get_header(); ?>
<div class="acntpageback font14">
	<div class="container">
		<a href="<?php echo get_home_url().'/account/'; ?>"><i class="fa fa-long-arrow-left"></i><strong>Back to Account Settings</strong></a>	
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
			<div class="frgtpswrdform pt40 pb60">
			
				<form method="post">
					<div class="formfield">
						<input type="text" placeholder="Enter your mail" class="formcontrol" name="email" value="">					
					</div>										
					<div class="formfield">
						<input type="submit" value="Send Password Reset Link" name="sendMail" class="formcontrol sbmtbtn">
							<div class="mailsend_msg"><small style='color:green;'></small></div>
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
   if (isset($_POST['sendMail'])) {
        $email = $_POST['email'];
        $user = get_user_by('email',$email);
        if(!$user){
			echo "Email not existing";
		}
		$username = $user->user_login;
		$reset_key = get_password_reset_key( $user );
		$userID = $user->data->ID;
		update_user_meta($userID,'password_reset_key',$reset_key);
		
		$body .= "<p> Hi ".$username."</p>";
		$body .= "<p>There was recently a request to change the password for your Wonder Kids Yoga account. Its ok, we are forgetful too.</p>
			<p> If you requested this password change, please click on the following link to reset your password: <a href='".site_url()."/change-password/?key=". $reset_key."&id=".$user->data->ID."'>Click here to reset your password</a></p>";
		$body .= "<p>If the link does not work, please copy and paste the URL into your browser instead.</p>";
		$body .= "<p>If you did not make this request, please ignore this message and carry on having a wonderful day!</p>";
		$body .= "<p>Wonder Kids Yoga Team</p>";

		$to = $email;
		$subject = 'Reset your password for Wonder Kids Yoga';

        $from = 'wordpress@kidsyoga.securework.co';
		// $headers = 'From: '. $from . "\r\n" . 'Reply-To: ' . $from . "\r\n";

		 $headers = array(
     	"MIME-Version: 1.0\r\n",
     	'Content-Type: text/html',
     	'from: '.get_option('blogname').' <'.$from.'>',
     	
     );

		$sent = wp_mail($to, $subject,$body, $headers); 
		if($sent){
			echo '<script> $(".mailsend_msg small").text("Please check your previous email Associated with this website.");
						 </script>';	
		}						 
		//echo "<pre>"; print_r($sent);
   }
?>

<?php get_footer();