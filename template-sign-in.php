<?php
/* Template Name: Sign In */
get_header(); ?>


<?php 

$msg = '';
global $wpdb;
    if (isset($_POST['signIn'])) {
    	$email  = $_POST['email'];
    	$password = $_POST['Password'];

    	
    if(!empty($email) && !empty($password)){
		if(!email_exists($email)){
    		$return = array( 'userid'=> '');
    	}
    	$user_id = email_exists($email);
		$paymentSuccessUsers = $wpdb->get_results("SELECT * FROM wp_user_subscriptions WHERE user_id ='$user_id' ");
		foreach($paymentSuccessUsers as $paymentSuccessUser){
			
			// echo "<pre>";
			// print_r($paymentSuccessUser->);
			// echo "</pre>";
			if($paymentSuccessUser->subscription_end_at != null){
				$userlogin = wp_signon( 
				array(
					'user_login'    => $user->data->user_login,
					'user_password' => $password,
					'remember'      => true
					), 
				false 
			);
			 //echo "<small style='color:green;'>your subscription end at: ".$paymentSuccessUser->subscription_end_at." </small>";
			}elseif($paymentSuccessUser->subscription_end_at == null){
				$userlogin = wp_signon( 
				array(
					'user_login'    => $user->data->user_login,
					'user_password' => $password,
					'remember'      => true
					), 
				false 
			);
				$trail_ends_at = $paymentSuccessUser->trail_ends_at;
				//echo "<small style='color:green;'>your trail ends at: ".$paymentSuccessUser->trail_ends_at." </small>";
			}
		}

		
	      if(!empty($user_id)) {
	      	$user = get_user_by('ID', $user_id );
			$userCancel = get_user_meta($user_id,'subscription_deleted',true);
			//var_dump($userCancel);die;
			$user_meta=get_userdata($user_id);
			$user_roles=$user_meta->roles[0];
			//print_r($user_roles);die;
			if($userCancel == ''){				
    	     $userlogin = wp_signon( 
				array(
					'user_login'    => $user->data->user_login,
					'user_password' => $password,
					'remember'      => true
					), 
				false 
			);
			}else{
			  echo "<script>
			  $('.user_login_msg').text('User account is disabled by admin!');
			  $('.user_login_msg').css('color','red');
			  </script>";
		  }
		  if($user_roles =='freesubscriber'){
			  $userlogin = wp_signon( 
				array(
					'user_login'    => $user->data->user_login,
					'user_password' => $password,
					'remember'      => true
					), 
				false 
			);
			//echo "<small style='color:green;'>you are lucky user for free access </small>";
		  }
    	     if($userlogin->ID){
				wp_clear_auth_cookie();
				wp_set_current_user ( $userlogin->ID );
				wp_set_auth_cookie  ( $userlogin->ID );
			
				// $return = array(
				// 	'msg'=> 'success',
				// 	'userid'=> $userlogin->ID
				// );

				// if ($return['userid']){
				
					$checkcards = $wpdb->get_row("SELECT * FROM wp_card_details WHERE user_id ='$user_id' ");
					if(!empty($checkcards)){
						$redirect_utl = home_url().'/my-classes/';
					}else{
						$redirect_utl = home_url().'/free-trial/';						
					}

					echo "<script>window.location='$redirect_utl';</script>";  
      //                echo "<script>
					 
					 // $('#loginsuccessfully').modal();
						//  setTimeout( function(){ 
						// 	window.location='$redirect_utl';
						//  }  , 1000 );
					 
					 
					 // </script>";
				// }				
			}else {
	    		$return = array( 'userid'=> '' );
	    	}
    	 }
    	}else{
    		 	$msg = 'Email or Password can not be blank.';
    	}
    }
?>


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
			<div class="user_login_msg">
				<?php if(isset($return['userid']) && $return['userid'] == ''){
						echo "Invalid Login";
					}	
					echo $msg;
					 ?>
			</div>
				<form method="post">
					<div class="formfield">
						<input type="text"  name="email" placeholder="E-mail" class="formcontrol" value="">					
					</div>
					<div class="formfield">
						<input type="password" name="Password" placeholder="Password" class="formcontrol" value="">					
					</div>
					<div class="formfield">
						<input type="submit" name="signIn" value="Sign In" class="formcontrol sbmtbtn">					
					</div>
				</form>
				<div class="formbtmnav text-uppercase pt20">
					<ul class="d-flex justify-content-between">
						<li><a href="<?php echo get_home_url(); ?>/forgot-password/">Forgot Password</a></li>
						<li><a href="<?php echo get_home_url(); ?>/sign-up/">Sign Up</a></li>
					</ul>
				</div>
			</div>	
		</div>		
	</div>	
</div>
<div class="modal fade logsuccs" id="loginsuccessfully" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
		<span><i class="fa fa-check" aria-hidden="true"></i></span>
        <p>Login successfully :)</p>
      </div>
      
    </div>
  </div>
</div>

<?php get_footer();


///TESTINGSS@GAMIL.COM