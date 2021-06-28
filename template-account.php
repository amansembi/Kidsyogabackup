<?php
/* Template Name: My Account Template */
get_header(); ?>

<?php  
  global $current_user;
  global $wpdb;
  
  if(isset($_POST['submit'])){
	
	
	$filename = $_FILES['avatarimage'];
	
	if (!function_exists('wp_generate_attachment_metadata')){
            require_once(ABSPATH . "wp-admin" . '/includes/image.php');
            require_once(ABSPATH . "wp-admin" . '/includes/file.php');
            require_once(ABSPATH . "wp-admin" . '/includes/media.php');
            }

			if ($_FILES['avatarimage']['name'] != '' ) {
            foreach ($_FILES as $file => $array) {
                if ($_FILES[$file]['error'] !== UPLOAD_ERR_OK) {
                    return "upload error : " . $_FILES[$file]['error'];
                }
                $attach_id = media_handle_upload( $file, $new_post );
				
            }   
            }
			update_user_meta(get_current_user_id(),'wp_user_avatar',$attach_id);




	
		}
		  $current_userID = $current_user->data->ID;
		  $current_userName = $current_user->data->display_name;
		  $current_user_email = $current_user->data->user_email;
		  
		 $first_name = $current_user->first_name;
		 $last_name = $current_user->last_name;

		 $user_name =  $first_name . ' ' .  $last_name;
		 $plan_details = $wpdb->get_results("SELECT * FROM wp_user_plan_details WHERE user_id = '$current_userID'");
		 $planDetails = $wpdb->get_results("SELECT * FROM wp_user_subscriptions WHERE user_id = '$current_userID'");
		 $card_details = $wpdb->get_results("SELECT * FROM wp_card_details WHERE user_id = '$current_userID'");
		 $data = $plan_details[0]->plan_details;
		 $plan_id = $planDetails[0]->plan_id;
		 //print_r($plan_id);
		 $paymentDetails = json_decode($data);

		 $cartNum = $card_details[0]->card_last_four;
		 
		 $card_last_digit =  str_pad(substr($cartNum, -4), strlen($cartNum), '*', STR_PAD_LEFT);
		 $card_name = $card_details[0]->card_name;
		 $amount = $paymentDetails->amount;
		 $subscribe_type = $plan_details[0]->subscribe_type;
		$imageid = get_user_meta($current_userID,'wp_user_avatar',true);
		$subscription_deleted = get_user_meta($current_userID,'subscription_deleted',true);
		$imagepath = wp_get_attachment_url($imageid);
		//echo get_bloginfo('stylesheet_directory');
		if($imagepath){
			$imagepathurl = $imagepath;
		}else{
			$imagepathurl = get_bloginfo('stylesheet_directory').'/images/avatarimg/dummyavatar.png';
		}
		if($plan_id == 'price_1IfIWgA5JkmCD4ai9O77pxZH'){
			$plan = 'Monthly';
			$amount = $planDetails[0]->subscription_amount;
		}elseif($plan_id == 'price_1IfIWyA5JkmCD4aiy3kFwnDY'){
			$plan = 'Yearly';
			$amount = $planDetails[0]->subscription_amount;
		}
		//dummyavatar.png

		$args = array(
				'meta_query'=>
				 array(
					array(
						'relation' => 'AND',
					array(
						'key' => 'parent_user_id',
						'value' => $current_userID,
						'compare' => "=",
						'type' => 'numeric'
					),

				  )
			   )
			);

$get_kids_details = get_users( $args ); 
$userallkids = get_user_meta($current_userID,'kids_'.$current_userID,true);
//var_dump($userallkids);

 ?>

<div class="container">
	<div class="acntpagetitlehead acnttopheadsec kidproftophead d-flex flex-wrap align-items-center justify-content-between pt60">
		<div class="acntpagetitle">
			<h1><?php the_title();?></h1>		
		</div>
		<div class="updateprofpic clrpink font14">			
			<a href="#" class="d-flex flex-wrap align-items-center" data-toggle="modal" data-target="#exampleModalCenter"><h5>Update Profile Picture</h5>
			<div class="userprofileparent">
			<div class="userprofile" style="background:url(<?php echo $imagepathurl; ?>)"> </div></div></a>
			
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


<?php  
   
 ?>

<div class="container pb100">
	<div class="acntcmnrow">
		<div class="row">
			<div class="col-md-3">
				<h3 class="fontbold">Profile Settings</h3>
			</div>
			<div class="col-md-9">
				<div class="cmnactrowdata">
					<ul>
						<input type="hidden" name="parent_user_id" class="parent_user_id" value="<?php echo $current_userID; ?>">
						<input type="hidden" name="addprofileurl" class="addprofileurl" value="<?php echo get_home_url().'/account-change-email/'; ?>">
						<input type="hidden" name="childUrl" class="childUrl" value="<?php echo get_theme_file_uri();  ?>">
						<li class="d-flex flex-wrap align-items-center justify-content-between">
							<div class="acntlft_txt"><span><?php echo $current_user_email; ?></span></div>
							<div class="acntrgt_link">
								<a href="<?php echo get_home_url(); ?>/account-change-email/" class="pinkbold20 change_mail" type="">Change Email</a>	
							</div>
						</li>
						<li class="d-flex flex-wrap align-items-center justify-content-between">
							<div class="acntlft_txt"><span>Password: ********</span></div>
							<div class="acntrgt_link">
								<a href="<?php echo get_home_url().'/forgot-password';  ?>" class="pinkbold20 chnage_password">Change Password</a>	
							</div>
						</li>
						<li class="d-flex flex-wrap align-items-center justify-content-between">
							<div class="acntlft_txt"><span><?php echo $user_name;  ?></span></div>
							<div class="acntrgt_link">
								<a href="<?php echo get_home_url(); ?>/account-change-name" class="pinkbold20 change_username">Change Name</a>	
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>		
	</div>
	<div class="acntcmnrow">
		<div class="row">
			<div class="col-md-3">
				<h3 class="fontbold">Payment Info</h3>
			</div>
			<div class="col-md-9">
				<div class="cmnactrowdata">
					<ul>
						<li class="d-flex flex-wrap align-items-center justify-content-between">
							<div class="acntlft_txt"><span><strong><?php echo $card_name.' '. $card_last_digit; ?></strong></span></div>
							<div class="acntrgt_link">
								<a href="<?php echo get_home_url().'/account-payment-method-change'; ?>" class="pinkbold20">Manage Payment Methods</a>	
							</div>
						</li>
						<li class="d-flex flex-wrap align-items-center justify-content-between">
							<div class="acntlft_txt"><span><?php echo $plan ?>: $  <?php echo $amount; ?></span></div>
							<div class="select_plan">
								<div class="acntrgt_link">
									<a href="<?php echo get_home_url(); ?>/account-subscription-plan" class="pinkbold20 chnage_plan">Change Plan</a>	
								</div>
						<input type="hidden" name="childUrl" class="childUrl" value="<?php echo get_theme_file_uri(); ?> ">
						<input type="hidden" class="userid_in_popup" value="<?php echo $current_userID; ?>" id="userid_in_popup">
						<input type="hidden" class="subscription_deleted" value="<?php echo $subscription_deleted; ?>" id="subscription_deleted">
								<!--<div class="acntrgt_link">
									<a href="javascript:void(0)" data-toggle="modal" data-target="#cancelPlan" class="pinkbold20 chnage_plan">Cancel Plan</a>
															
								</div>--->
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="acntcmnrow mnacntmorerow">
		<div class="row">
			<div class="col-md-3">
				<h3 class="fontbold">More</h3>
			</div>
			<div class="col-md-9">
				<div class="cmnactrowdata">
					<ul>

                <?php $count = 0;	foreach ($userallkids as $key => $value) { 
						$kidsNamerspace = str_replace(' ', '',strtolower($value));
                	  
                	  $imageID = get_user_meta($current_userID, 'kids_'.$current_userID.'_'.$kidsNamerspace);
                	 
	                	  if(is_numeric($imageID[0])){
	                	  	    $imageUrl = wp_get_attachment_image_src($imageID[0]);
	                	  	 
	                	     }else{
							    $imageUrl = $imageUrl;
	                	  } 
                	  
		            ?>
	
						<li class="d-flex flex-wrap align-items-center justify-content-between">
							<div class="acntlft_txt">
								<div class="acntmorerow d-flex flex-wrap align-items-center">
									<img src="<?php echo $imageUrl[0]; ?>" alt="Icon">
									<span><?php echo $value; ?></span>
									<button class="btn btn-link" data-toggle="modal" data-target="#kidprofilepopup"><i class="fa fa-trash-o clrpink" aria-hidden="true"></i></button>			
								</div>
							</div>
							<div class="acntrgt_link">
								<input type="hidden" name="kids_Id" class="kids_Id" value="<?php echo $value->data->ID; ?>">
								<a href="#" class="pinkbold20" id="<?php echo $value->data->ID; ?> ">Update Name</a>	
							</div>
						</li>
		        <?php 
				$count = $count +1;
				
				} 
				
				//print_r($count);
				?>
					</ul>
				</div>
			</div>
		</div>
	</div><?php if($count != 3){ ?>
	<div class="addanotheridlink text-right">
		<a href="<?php echo home_url(); ?>/add-profile-2/" class="pinkbold20">Add another kid</a>	
	</div>
	<?php } ?>
</div>


<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content profilePop">
      <div class="modal-header ">
        <h5 class="modal-title" id="exampleModalLongTitle">Profile Update</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  <form method="POST" enctype="multipart/form-data">
	  <a href="javascript:void(0);" class="imgFileUpload" id="imgFileUpload">
	  <div class="userprofile popupimagechange" style="background:url(<?php echo $imagepathurl; ?>)">
		
		<i class="fa fa-	"></i>
		</div></a>
		<input type="file" id="FileUpload1" name="avatarimage" class="avatarimage" style="display:none;"/>
		<button type="submit" name="submit" class="btn btn-primary">Save</button>
		</form>
      </div>
      
    </div>
  </div>
</div>

<div class="modal fade aftvideomodl" id="cancelPlan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      <div class="modal-body subcript">
        <h3>Cancel your subscription?</h3>
		<p>Are you sure, you want to cancel your subscription?</p>
		<div class="cancel_user_responding"></div>
		<div class="modl_btn d-flex">
			<button type="button" class="back_btn" style="background: transparent !important;color: #FF5757 !important;border: none;">Go Back</button>
			<button type="button" class="confirm_cancellation">Confirm cancellation</button>
		</div>
      </div>      
    </div>
  </div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function($){	
       $('.change_mail').click('body', function(){
       	var childUrl = $('.childUrl').val();
       		var controllerPath = childUrl+'/ajaxController.php';
       	    var parent_user_id = $('.parent_user_id').val();
       	    var addprofileurl = $('.addprofileurl').val();
       	    var addprofileurl = addprofileurl+'/account-change-email/';
       	     $.ajax({
	          type:"post",
	          url:controllerPath,
	          data:{type:'emailIDgenrater',parent_user_id:parent_user_id},
	          success:function(res){
	         	window.location.href = addprofileurl;
	            console.log()
	          }
	        });
       });


       $('.change_username').click('body', function(){
       	    	var childUrl = $('.childUrl').val();
       		var controllerPath = childUrl+'/ajaxController.php';
       	    var parent_user_id = $('.parent_user_id').val();
       	    var addprofileurl = $('.addprofileurl').val();
       	     $.ajax({
	          type:"post",
	          url:controllerPath,
	          data:{type:'usernamedIDgenrater',parent_user_id:parent_user_id},
	          success:function(res){
	         	//window.location.href = addprofileurl;
	           console.log(res);
	          }
	        });
       });


       $('.chnage_plan').click('body', function(){
       	  	var childUrl = $('.childUrl').val();
       		var controllerPath = childUrl+'/ajaxController.php';
       	    var parent_user_id = $('.parent_user_id').val();
       	    var addprofileurl = $('.addprofileurl').val();
       	     $.ajax({
	          type:"post",
	          url:controllerPath,
	          data:{type:'planIDgenrater',parent_user_id:parent_user_id},
	          success:function(res){
	         	// window.location.href = addprofileurl;
	           
	          }
	        });
       });
	});
       $('.confirm_cancellation').click(function(){		   
		    $('.confirm_cancellation').prop('disabled', true);
		  
       	  	var childUrl = $('.childUrl').val();
			var userId = $('#userid_in_popup').val();
			var subscription_deleted = $('#subscription_deleted').val();
			//alert(subscription_deleted);
			var controllerPath = childUrl+'/ajaxController.php';
			
			if(subscription_deleted == 'canceled'){
				$('.cancel_user_responding').html('<small style="color:#FF5757">Sorry! User is already canceled</small>');
			}else{
			$.ajax({
			  type:"post",
			  url:controllerPath,
			  data:{type:'cancel_user',userId:userId},
			  success:function(res){
				 if(res){
					$('.cancel_user_responding').html('<small style="color:green">User cancel successfully</small>'); 
				 }
				console.log(res);
			  }
			});
			}
       });
	
	
    window.onload = function () {
        var fileupload = document.getElementById("FileUpload1");
        var filePath = document.getElementById("spnFilePath");
        var image = document.getElementById("imgFileUpload");
		
        image.onclick = function () {
            fileupload.click();
        };
        fileupload.onchange = function () {
			
            var fileName = fileupload.value.split('\\')[fileupload.value.split('\\').length - 1];
            //filePath.innerHTML = "<b>Selected File: </b>" + fileName;			
			const file = fileupload.files[0];
			
			if (file) {
                        let reader = new FileReader();
                        reader.onload = function (event) {
                            $(".popupimagechange")
                              .css("background", 'url('+event.target.result+')');
                        };
                        reader.readAsDataURL(file);
                    }
        };
		
    };
	
	
	

</script>


<?php get_footer();