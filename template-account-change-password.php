<?php
/* Template Name: Account Change Password */
get_header(); ?>


<div class="container">
	<div class="acntpagetitlehead d-flex justify-content-between pt60">
		<div class="acntpagetitle">
			<h1><?php the_title();?></h1>		
		</div>
		<div class="acntpageback font14">
			<a href="#"><i class="fa fa-long-arrow-left"></i><strong>Back to Account Settings</strong></a>	
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
				<form method="post">					
					<div class="formfield">
						<input type="text"  name="email" placeholder="Enter new password" class="formcontrol" value="">					
					</div>
					<div class="formfield">
						<input type="text"  name="email" placeholder="Re-enter new password" class="formcontrol" value="">					
					</div>
					<div class="formfield">
						<input type="submit" name="Resetpass" value="Reset Password" class="formcontrol sbmtbtn">					
					</div>
				</form>				
			</div>	
		</div>		
	</div>	
</div>

<?php get_footer();