<?php

/* Template Name: Sign Up */
get_header();
session_start();?>

<?php
$msg = '';
   if (isset($_POST['submit'])) {
   	ob_start();	
   	
   	      $fname = $_POST['first_name'];
   	      $lname = $_POST['last_name'];
   	      $email = $_POST['email'];
   	      $password = $_POST['password'];
   	      $username = $fname .''. $lname;
		if(!email_exists($email)){
    		
		  $post_arr = array(
			'swpm_api_action' => 'create',
			'key' => '0d8025709b57f764d41711498504a7ea',
			'first_name' => $fname,
			'user_name' => $fname.''.$lname,
			'last_name' => $lname,
			'email' => $email,
			'password'=> $password,
			);

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL,"http://kidsyoga.securework.co/");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch,CURLOPT_USERAGENT,'curl');
			curl_setopt($ch, CURLOPT_POSTFIELDS,
			$post_arr);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec ($ch);
			curl_close ($ch);
			$res=json_decode($response,true);
			
			$login_data = array();
			$login_data['user_login'] = $username;
			$login_data['user_password'] = $password;

			$user = wp_signon( $login_data, false ); 

		if ( is_wp_error($user) ) {
				$msg = $user->get_error_message();            
	        } else {    
	        	$username = $user->data->display_name; 
	        	 $userID = $user->ID;  
	            if($price == '' ){
                  $_SESSION["username"] = $username;
                  $_SESSION["userID"] = $userID;
	             ?>
	            	<script> window.location='http://kidsyoga.securework.co/free-trial/'; </script>
	            <?php }   
	        }

        if($price != '' ){ ?> <script> window.location='http://kidsyoga.securework.co/free-trial/?price=<?php echo $price ;?>'; </script><?php }
			
		ob_end_flush();

    	}
    	else{
    		$msg = 'Account already exists. Please <a href="'.site_url().'/sign-in">Sign In</a>';
    	}
	}
 ?>

<div id="mainsite">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
		the_content();
		endwhile; else: ?>
		<p>Sorry, no posts matched your criteria.</p>
	<?php endif; ?>
	<?php 
	if(isset($_GET['price'])){
	$price = $_GET['price']; 
	}else{
	$price = '';
	}
	?>
</div>

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-5">
			<div class="signupform pt40 pb60">
				<p><small class="errorfield"><?php echo $msg; ?></small></p>
				<form method="post" onSubmit="return handleClick()">
					<div class="formfield">
						<input type="text" name="first_name" placeholder="First Name" class="formcontrol first_name" value="<?php if(isset($_POST['first_name'])){ echo $_POST['first_name']; } ?>">
							<p><small class="first_name errorfield"></small></p>
					</div>
					<div class="formfield">
						<input type="text" name="last_name" placeholder="Last Name" class="formcontrol last_name" value="<?php if(isset($_POST['last_name'])){ echo $_POST['last_name']; } ?>">
							<p><small class="last_name errorfield"></small></p>
					</div>
					<div class="formfield">
						<input type="text" name="email" placeholder="Email" class="formcontrol email" value="<?php if(isset($_POST['email'])){ echo $_POST['email']; } ?>">
							<p><small class="email errorfield"></small></p>
					</div>
					<div class="formfield">
						<input type="password" name="password" placeholder="Password" class="formcontrol password" value="<?php if(isset($_POST['password'])){ echo $_POST['password']; } ?>">							
					</div>
					<div class="formfield">
						<input type="password" name="confirm_password" placeholder="Re-enter Password" class="formcontrol confirm_password" value="<?php if(isset($_POST['confirm_password'])){ echo $_POST['confirm_password']; } ?>">
						<p><small class="password errorfield"></small></p>						
					</div>
					<div class="formfield">
						<input type="submit" value="Continue" name="submit" class="formcontrol sbmtbtn">					
					</div>
				</form>
			</div>	
		</div>		
	</div>	
</div>	
<script>
function handleClick() {
	$('small').text('');
		var count = 0;
		var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		var first_name = $('.first_name').val();
		var last_name = $('.last_name').val();
		var email = $('.email').val();
		var password = $('.password').val();
		var confirm_password = $('.confirm_password').val();
		if(first_name == ''){
			$('small.first_name').text('First name is required');
			count = 1;
		}
		if(last_name == ''){
			$('small.last_name').text('Last name is required');
			count = 1;
		}		 
        if(!regex.test(email)) {
			$('small.email').text('Email should be in correct format');
           count = 1;
        }		
         var pswlen = password.length;
		 if(password == ''){
			$('small.password').text('Password is required');
		 }else if (pswlen < 8) {
			 count = 1;
			 $('small.password').text('minmum  8 characters needed');
            
         }else if (password != confirm_password) {
			 $('small.password').text('Password Do not match');
               count = 1;
          }
		if(count > 0){
			return false;
		}else{
			return true;
		}
        
      }
</script>


<?php get_footer();
