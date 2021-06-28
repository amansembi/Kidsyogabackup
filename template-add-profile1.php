<?php
/* Template Name: Add Profile 1 */
  session_start();

if (isset($_SESSION['username']) && $_SESSION['username'] == true) {
   get_header('login'); 
} else {
   get_header(); 
}
session_start(); ?>


<div id="mainsite">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
		the_content();
		endwhile; else: ?>
		<p>Sorry, no posts matched your criteria.</p>
	<?php endif; ?>
</div>
<?php  
  $_SESSION["username"];
  $_SESSION["userID"];
?>

<div class="bgcolor">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-5">
				<div class="profilebox text-center">
					<div class="profileboxtitle">
						<h2>
							Welcome to
							<span>Wonder Kids</span>
						</h2>
					</div>
					<div class="profileboxsubtitle">
						<h4>
							Add up to three family members
						</h4>
					</div>
					<div class="row">
						<div class="col-md-6">
								<div class="userpicbox usercmnbox d-flex justify-content-center align-items-center">
									 <img src="http://kidsyoga.securework.co/wp-content/uploads/2021/03/icon-profile-big.png">
							</div>
									<div class="userboxtitle">
										<?php  echo $_SESSION["username"]; ?>
									</div>
							
							</div>
								<div class="col-md-6">
								   <div class="useraddbox usercmnbox d-flex justify-content-center align-items-center addchild">
									  <img src="http://kidsyoga.securework.co/wp-content/uploads/2021/03/icon-add-memeber.png">
									 <input type="hidden" name="profile2Url" class="profile2Url" value="<?php echo get_home_url().'/add-profile-2'; ?>">
								   </div>
									<div class="userboxtitle">
										  Add Member
						 			</div>
					         	</div>					
				      </div>
					<div class="userboxbtn">
						<a href="#">Done</a>
					</div>
				
			</div>
			
		</div>
		
	</div>
	
</div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function($){	
	  var profile2url = $('.profile2Url').val();
      $('.addchild').click(function(){
         window.location = profile2url;
      });
	}); 
</script>


<?php get_footer();


///TESTINGSS@GAMIL.COM