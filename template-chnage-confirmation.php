<?php
/* Template Name: Changes Confiramtion */
get_header(); ?>
<div class="email_change">
<h1> Thankk you </h1>
<p>Your Email is suceessfully chnage</p>
</div>
<?php if(isset($_GET['key'])){
	$redirect_utl = home_url().'/account/';
	$email_varification_key = $_GET['key'];
	$user_id = $_GET['id'];
	$userEmailVarificationKey =	get_user_meta($user_id,'email_reset_key',true);
	$changeEmailRequest =	get_user_meta($user_id,'change_email_request',true);
	if($email_varification_key == $userEmailVarificationKey){
	
	$result = $wpdb->update( 
				'wp_users', 
				array( 					
					'user_email' => $changeEmailRequest, 				  
				), 
				array( 'ID' => $user_id )
			);
			
			
			echo "<script> setTimeout( function(){ 
								window.location='$redirect_utl';
							 }  , 2000 );
						 </script>";
	}
	
	}
	


?>


<?php get_footer(); ?>