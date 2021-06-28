<?php
/**
 * The header.
 *
 * This is the template that displays all of the <head> section and everything up until main.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */
global $current_user_X;
session_start();

//$userid =   $_SESSION["userID"];

$new_user = $current_user_X = wp_get_current_user();

//print_r($new_user);
$userid = $new_user->data->ID;
$avtarUrl = get_avatar_url($userid);
$imgUrl = get_user_meta($userid,'kids_profile_image');
$fullname = $new_user->data->user_nicename;
$imageid = get_user_meta($userid,'wp_user_avatar',true);
$imagepath = wp_get_attachment_url($imageid);
 
	 // echo "<pre>";
	 // print_r($loop);
	 // echo "</pre>";
if($imagepath){
	$imagepathurl = $imagepath;
}else{
	$imagepathurl = get_bloginfo('stylesheet_directory').'/images/avatarimg/dummyavatar.png';
}
if(empty($imgUrl)){
	$imgUrl = $avtarUrl;
}
$args = array(
        'meta_query'=>
         array(
            array(
                'relation' => 'AND',
            array(
                'key' => 'parent_user_id',
                'value' => $userid,
                'compare' => "=",
                'type' => 'numeric'
            ),

          )
       )
    );

$get_kids_details = get_users( $args );
$userallkids = get_user_meta($userid,'kids_'.$userid,true);
//var_dump($userallkids);
?>
<!doctype html>
<html <?php language_attributes(); ?> <?php twentytwentyone_the_html_classes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<script src="https://player.vimeo.com/api/player.js"></script>
	
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<header class="mainhead ptb20">
		<div class="container d-flex justify-content-between align-items-center">
			<div class="logo">
				<?php the_custom_logo(); ?>
			</div>

			<div class="main_header_menu">
				<?php if(is_page( array( 'payment-details', 'free-trial' ) )){ ?>
					<div class="notclickable"></div>
				<?php } ?>
				<div class="resmenu">
					<i class="fa fa-bars" aria-hidden="true"></i>
				</div>

				<div class="mainmenu left_after_login">
					<ul>			
					<?php if( is_user_logged_in() ){ ?>
						<li><?php wp_nav_menu( array('theme_location' =>'left-after-user-menu') ); ?></li>				
					<?php }  ?>			
					</ul>			
				</div>
				<div class="mainmenu">
					
					<ul>
					<?php if( is_user_logged_in() ){ ?>
						
						<li><?php wp_nav_menu( array('theme_location' =>'my-custom-menu') ); ?></li>
						
						<?php }  ?>
						
						<?php if( !is_user_logged_in() ){ ?>
						<li>					
						<?php wp_nav_menu( array('theme_location' => 'primary') ); ?>
						</li><?php }  ?>
						<li>
							<ul class="user-account">
								
							<?php 
							//print_r( is_page( array( 'my-classes', 'account', 'instructors', 'explore' ) ));
							
							if(is_user_logged_in()){ ?>
								
								
								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Hi <?php echo $fullname; ?></small>
									</a>
									<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
									  <a class="dropdown-item" href="<?php echo home_url(); ?>/account">Setting</a>
									  <a class="dropdown-item" href="<?php echo home_url(); ?>/gift-cards/">Send a gift</a>
									  <?php $count = 0;	foreach ($userallkids as $key => $value) { 
										  
										  //print_r($value); 
										?>
									  <a class="dropdown-item" href="<?php echo home_url(); ?>/"><?php echo $value; ?></a>
									   <?php 
										$count = $count +1;
										} ?>
									<!---  <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#myModal">Payment</a>-->
									  <a class="dropdown-item" href="<?php echo wp_logout_url( home_url() ); ?>">Logout</a>
									</div>
								  </li>
								  <li><div class="userAvatar" style="background:url(<?php echo $imagepathurl; ?>);"></div></li>
							<?php } ?>
								
							</ul>
						</li>
				</div>
			</div>	<!--main_header_menu--->
		</div>	
	<div class="modal fade cancel-subscription" id="myModal" role="dialog">
		<div class="modal-dialog">
		
		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Cancel your subscription</h4>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row">
						<input type="hidden" class="payment-type" value="cancellation" />
						<input type="hidden" class="user_id" value="<?php echo $userid; ?>" />
						<input type="hidden" name="childUrl" class="childUrl" value="<?php echo get_theme_file_uri();  ?>">
						<button type="button" class="col-xs-6 col-sm-6 col-md-6 col-lg-6 btn btn-lg btn-primary ">Go Back</button>
						<button type="button" class="col-xs-6 col-sm-6 col-md-6 col-lg-6 btn btn-lg btn-primary confirm-cancellation">Confirm Cancellation</button>
					</div>
				</div>
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		  </div>
		  
		</div>
	  </div>
<style>
.dropdown:hover>.dropdown-menu {
  display: block;
}
.cancel-subscription .modal-dialog {
    max-width: 760px;
}
</style>
<script>
$('.confirm-cancellation').click(function(){
		var type = $('.payment-type').val();
		var user_id = $('.user_id').val();
		var childUrl = $('.childUrl').val();		
		var controllerPath = childUrl+'/ajaxController.php';
		$.ajax({
	        type:"post",
	          url:controllerPath,
	          data:{type:type,user_id:user_id},
	          success:function(res){
	          	//window.location.href = addprofileurl;
				console.log(res);
	          }
	        });
});
</script>
	</header>	