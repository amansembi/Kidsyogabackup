<?php 
/* Template Name: Account Change Name */
get_header(); 
?>
<div class="modal fade logsuccs" id="usernamechange" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <!--div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div-->
      <div class="modal-body">
		<span><i class="fa fa-check" aria-hidden="true"></i></span>
        <p>Name change successfully :)</p>
      </div>
      
    </div>
  </div>
</div>
<?php

 

$userLoginId = get_current_user_id();
$author_obj = get_user_by('ID', $userLoginId);
$userName = $author_obj->data->user_login;
$user_email = $author_obj->data->user_email;

if(isset($_POST["submit1"])){
	$userName = $_POST["name1"];
	
	$result = $wpdb->update( 
				'wp_users', 
				array( 					
					 
					//'user_login' => preg_replace('/\s+/', '', $userName),   
					'user_nicename' => preg_replace('/\s+/', '', $userName),   
					'display_name' => preg_replace('/\s+/', '', $userName),   
					  
				), 
				array( 'ID' => $userLoginId )
			);
			echo "<script>					 
						 $('#usernamechange').modal();						 
						 </script>";
}
?>


<div class="container">
	<div class="acntpagetitlehead d-flex justify-content-between pt60">
		<div class="acntpagetitle">
			<h1><?php the_title();?> </h1>		
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
						<?php echo $user_email; ?>
						
					</div>
					<div class="crntemailrt">
						<?php echo $userName; ?>
					</div>
				</div>
				<form method="post">					
					<div class="formfield">
						<input type="text"  name="name1" placeholder="Enter your new name" class="formcontrol" value="">					
					</div>					
					<div class="formfield">
						<input type="submit" name="submit1" value="update1" class="formcontrol sbmtbtn">					
					</div>
				</form>				
			</div>	
		</div>		
	</div>	
</div>


<?php get_footer();