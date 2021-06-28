<?php
/* Template Name: Kid Profile Settings */
get_header(); ?>

<div class="container">
	<div class="acntpagetitlehead kidproftophead d-flex flex-wrap align-items-center justify-content-between pt60">
		<div class="acntpagetitle">
			<h1><?php the_title();?></h1>		
		</div>
		<div class="updateprofpic clrpink font14">			
			<a href="#" class="d-flex flex-wrap align-items-center"><h5>Update Profile Picture</h5> <img src="http://kidsyoga.securework.co/wp-content/uploads/2021/03/profile-pic.jpg" alt="profile"></a>
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
	<div class="kidprofstng d-flex flex-wrap align-items-center justify-content-between">
		<div class="lftprofdata d-flex flex-wrap align-items-center">
			<h3>Profile Settings</h3>
			<img src="http://kidsyoga.securework.co/wp-content/uploads/2021/03/profile-pic2.jpg" alt="Icon">
			<span>Kid one profile</span>
			<button class="btn btn-link" data-toggle="modal" data-target="#kidprofilepopup"><i class="fa fa-trash-o clrpink" aria-hidden="true"></i></button>			
		</div>
		<div class="rgtprofname">
			<a href="#" class="pinkbold20">Update Name</a>
		</div>
	</div>
<!-- 	<br/><br/>
	<button class="btn btn-info" data-toggle="modal" data-target="#cancelsubscription">Cancel Subscription Popup</button>
	<button class="btn btn-info" data-toggle="modal" data-target="#contactpopup">Contact Popup</button> -->
</div>
<div class="modal align-middle cmnprofpopup" id="kidprofilepopup">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
				<h2 class="fontbold">Delete Kid’s profile?</h2>
				<p>Are you sure, you want to delete kid one’s profile ?</p>
				<button class="btn">Delete</button>
			</div> 
            <button class="btn btn-info closepop" data-dismiss="modal">X</button>
        </div>
    </div>
</div>
<div class="modal align-middle cmnprofpopup" id="cancelsubscription">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
				<h2 class="fontbold">Cancel your subscription?</h2>
				<p>Are you sure, you want to cancel your subscription?</p>
				<ul>
					<li><a href="#" class="gobcklink">Go Back</a></li>
					<li><button class="btn normalcase">Confirm Cancellation</button></li>
				</ul>				
			</div> 
            <button class="btn btn-info closepop" data-dismiss="modal">X</button>
        </div>
    </div>
</div>
<div class="modal align-middle cmnprofpopup" id="contactpopup">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
				<h2 class="fontbold">Contact Us</h2>
				<p>Send us a message below or email us at info@wonderkidsyoga.com and we will get back to you within 48 hours.</p>
				<div class="popcontform">
					<form method="post">	
						<div class="formfield">
							<input type="text"  name="email" placeholder="Name" class="formcontrol" value="">					
						</div>
						<div class="formfield">
							<input type="text"  name="email" placeholder="Enter your new mail" class="formcontrol" value="">					
						</div>	
						<div class="formfield">
							<textarea placeholder="Message" class="formcontrol"></textarea>					
						</div>	
						<div class="formfield">
							<input type="submit" name="signIn" value="Submit" class="formcontrol sbmtbtn normalcase">					
						</div>
					</form>				
				</div>				
			</div> 
            <button class="btn btn-info closepop" data-dismiss="modal">X</button>
        </div>
    </div>
</div>


<?php get_footer();