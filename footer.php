<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */
global $current_user_X;
//session_start();
//print_r($current_user_X);
$current_url = home_url();
$new_user = wp_get_current_user();
$userid = $current_user_X->data->ID;
//print_r($userid);
// print_r($GLOBALS['wtnerd']['loginuser']);
$user_liked_vedios = get_user_meta( $userid, 'user_liked_vedio' , true );
//var_dump();
$current_user = get_current_user_id();
			$watchedVideoIds = get_user_meta($userid,'watched_video',true);
			$watchedduplicatearray = $watchedVideoIds;
			// print_r($watchedVideoIds);
			// print_r(count($watchedVideoIds));
			$viewedVideoCount = 0;
			$vdcount = count($watchedVideoIds);
			//print_r($vdcount);
			//print_r($watchedVideoIds);
			if(!is_array($watchedVideoIds) || $watchedVideoIds == ''){
				$watchedVideoIdsarray = 0;	
			}else{
				$watchedVideoIdsarray = 1;
			}	
			//print_r($watchedVideoIdsarray);
			foreach($watchedVideoIds as $watchedVideoId){ 
			$viewedVideoCount = $viewedVideoCount+1;
			}
			//print_r($watchedVideoIds);
?>

<div class="modal fade aftvideomodl" id="exampleModal12" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  <div class="modal-body">
		  	<h3>Congrats! A tree has been planted on your behalf </h3>
		  	<p>Your Forest: Each tree will be planted on your behalf for completing a class </p>
			<div class="allplants">
						<?php 
					//print_r($watchedduplicatearray);
						$count = 1;
				 if($watchedVideoIdsarray != 0){ 
					foreach($watchedVideoIds as $watchedVideoId){ ?>
						
						<div class="comnplant plant<?php echo $count; ?>">
							<img src="<?php echo get_bloginfo('stylesheet_directory'); ?>/images/<?php echo $count; ?>.png">
						</div>
					<?php 
					$count = $count + 1;
				 } } ?>
						
											
		     </div>
		  </div>
		  
		</div>
	  </div>
	</div>


	<?php echo do_shortcode('[hfe_template id="273"]'); ?>		
				<?php					
					$args = array( 'post_type' => 'plans','post_status' => 'publish', 'posts_per_page' => -1, 'orderby' => 'date', 'order' => 'ASC');
					$loop = new WP_Query( $args );
					//$current_user = get_current_user_id();
					if($current_user){
						$userID = $current_user;
					}else{
						$userID = '';
					}
					
					
					while ( $loop->have_posts() ) : $loop->the_post();
					$price = get_post_meta( get_the_ID(), 'price', true );
						$valid = get_post_meta( get_the_ID(), 'valid', true );
						$display_offer = get_post_meta( get_the_ID(), 'display_offer', true );
						$title = get_the_title();	
						$content = get_the_content();
						$price = get_post_meta( get_the_ID(), 'price', true );
							if($display_offer == 1){
						?>
		<div class="modal align-middle cmnprofpopup offers_popup" id="offerpopup">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-body">
						<img src="http://kidsyoga.securework.co/wp-content/uploads/2021/03/home-banner-1568x654.jpg" alt="Image" />
						<h3 class="fontbold"><?php echo $title; ?></h3>
						<input type="hidden" class="price_val" value="<?php echo $price; ?>">
						<input type="hidden" name="signup" class="signup" value="<?php echo get_home_url().'/sign-up'; ?>">
						<input type="hidden" name="userID" class="userID" value="<?php echo $userID; ?>">
						<p><?php echo $content; ?></p>	
						<button class="btn joinbtn">Join Now</button>
					</div> 
					<button class="btn btn-info closepop" data-dismiss="modal">X</button>
				</div>
			</div>
		</div>
			<?php
							}
				endwhile;	

				
			?>
	<!-- Start Footer -->
	
	
	
<div class="pupupdiv">
    <div class="popmodal">
        <i class="fa fa-times closebtn" aria-hidden="true"></i>
        <h2>Create account to watch videos</h2>
        <p>Create an account free for 14 days, later buy a plan of $20/month or $180/year. </p>
        <p><a href="<?php echo home_url().'/sign-up'; ?>" class="signupbtn">CREATE NEW ACCOUNT</a></p>
	    <p class="loginbtn">Already have an account log in <a href="<?php echo home_url().'/sign-in'; ?>"> Here</a></p>
	</div>
</div>
	
	
	
	
	<footer class="mainfoot ptb30">
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					<div class="cmnfoot foot1">
						<?php dynamic_sidebar('footer-1');?>
					</div>
				</div>
				<div class="col-md-9">
					<div class="cmnfoot foot2">
						<?php dynamic_sidebar('footer-2');?>
					</div>
				</div>
			</div>
		</div>		
	</footer>
	
	
	<!-- End Footer -->
	<?php
	if(empty($userid)){ 
	//echo '<script> $("#mainsite").addClass("openpoup"); </script>'; 
	}
	
	
	?>
<script>
var userID = $('.userID').val();
/*$('.offers_popup').removeClass('active');
if(userID == ''){
	$('.modal').css('display','block'); 
}
$('.offers_popup .closepop').click(function(){
	$('.modal').css('display','none'); 
});*/
$('.offers_popup .joinbtn').click(function(){
	var price_val = $('.price_val').val();
	var signup = $('.signup').val();
	
	window.location=signup+'/?price='+price_val+'';
});
//$('body').on('click', '.openpoup', function() {
	$('.openpoup').click(function(){

	// alert('sdgjbdshj');
	$('.pupupdiv').addClass('open');

});
$('.pupupdiv .popmodal .closebtn').click(function(){
	$('.pupupdiv').removeClass('open');
});

</script>



<?php 


wp_footer(); 

?>
</body>
</html>
