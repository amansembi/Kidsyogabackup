<?php
/* Template Name: Add Profile 3 */
get_header();
session_start(); 
?>


<div id="mainsite">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
		the_content();
		endwhile; else: ?>
		<p>Sorry, no posts matched your criteria.</p>
	<?php endif; ?>
</div>

<?php
global $post; 
global $current_user_X;
$userid = $current_user_X->data->ID;
    $postID = $post->ID;
    $kidsID =  $_SESSION["kidsID"]; 
    $kidsName =  $_SESSION["kidsName"]; 
	$kidsNamerspace = str_replace(' ', '',strtolower($kidsName));
    $url =  home_url().'/my-classes';
 if($_POST){
	 
 	if (!function_exists('wp_generate_attachment_metadata')){
				require_once(ABSPATH . "wp-admin" . '/includes/image.php');
				require_once(ABSPATH . "wp-admin" . '/includes/file.php');
				require_once(ABSPATH . "wp-admin" . '/includes/media.php');
		    }

           $type = $_FILES['image']['type'];
           if($type == 'image/jpeg' || $type == 'image/png' || $type == 'image/jpg'){
           if ($_FILES['image']['name'] != '' ) {
           //	echo "<pre>"; print_r($_FILES); die;
		            foreach ($_FILES as $file => $array) {
		                if ($_FILES[$file]['error'] !== UPLOAD_ERR_OK) {
		                    return "upload error : " . $_FILES[$file]['error'];
		                }
		                $attach_id = media_handle_upload( $file, $postID );
		                 if ( is_numeric( $attach_id ) ) {
		                     update_user_meta( $userid, 'kids_'.$userid.'_'.$kidsNamerspace, $attach_id );
		                     header("Location:".$url);
		                 }
		            } 
		         } 
                }elseif ($_POST['radiobtn']) {
                	//echo "<pre>"; print_r($_POST); die;
             		update_user_meta( $userid, 'kids_'.$userid.'_'.$kidsNamerspace, $_POST['radiobtn']);
             		header("Location:".$url);
             	}                     
    }   
?>
<div class="bgcolor">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="profilebox profile3_box">
					<div class="prof2titles">
						<div class="profileboxtitle">
							<h2><span>Add Profile</span></h2>
						</div>
						<div class="profileboxsubtitle">
							<h4>Add a profile for another kid taking yoga classes</h4>
						</div>
					</div>
					<form method="post" enctype="multipart/form-data" id="myfrm">
						<div class="selectanimalbox d-flex align-items-center">
							<div class="cmnslctanmlcol">
								<div class="animalimg"><img src="http://kidsyoga.securework.co/wp-content/uploads/2021/03/animal-1.png" alt="Animal Image"></div>
								<input type="radio" name="radiobtn" value="1156">								
							</div>
							<div class="cmnslctanmlcol">
								<div class="animalimg"><img src="http://kidsyoga.securework.co/wp-content/uploads/2021/03/animal-2.png" alt="Animal Image"></div>
								<input type="radio" name="radiobtn" value="1157">								
							</div>
							<div class="cmnslctanmlcol">
								<div class="animalimg"><img src="http://kidsyoga.securework.co/wp-content/uploads/2021/03/animal-3.png" alt="Animal Image"></div>
								<input type="radio" name="radiobtn" value="1158">								
							</div>
							<div class="cmnslctanmlcol">
								<div class="animalimg"><img src="http://kidsyoga.securework.co/wp-content/uploads/2021/03/animal-4.png" alt="Animal Image"></div>
								<input type="radio" name="radiobtn" value="1159">								
							</div>
							<div class="cmnslctanmlcol">
								<div class="animalimg"><img src="http://kidsyoga.securework.co/wp-content/uploads/2021/03/animal-5.png" alt="Animal Image"></div>
								<input type="radio" name="radiobtn" value="1160">		
								<input type="hidden" name="addprofileurl" class="addprofileurl" value="<?php echo get_home_url().'/explore-classes/'; ?>">	

								<input type="hidden" name="childUrl" class="childUrl" value="<?php echo get_theme_file_uri();  ?>">		
								<input type="hidden" name="uploaded_image" class="uploaded_image" value="">				
							</div>
						</div>
						<div class="userboxbtn kidprof2btns">
							<ul class="d-flex flex-wrap flex-column">
								<li><input type="file" name="image" class="image" value=""></li>
								<li><input type="submit" name="submit" class="kidcnclbtn saveimage" value="Submit"></li>
							</ul>	
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>
<script type="text/javascript">
	jQuery(document).ready(function($){
		$('input[type=radio][name=radiobtn]').change(function() {
        $('.kidprof2btns .image').val('');
      });

		$(".image").change(function(){
           $("input:radio").removeAttr("checked");
        });

  });


		// $('.saveimage').click(function(){
		//  var addprofileurl = $('.addprofileurl').val();	
		//  var childUrl = $('.childUrl').val();
	 //     var imageSrc = $('input[name="radio"]:checked').val();
	 //     var kidID = '<?php //echo $_SESSION["kidsID"];  ?>';
	 //     var controllerPath = childUrl+'/ajaxController.php';

	//     	$.ajax({
	//         type:"post",
	  //         url:controllerPath,
	  //         data:{type:'AddkidsProfileImage',kidID:kidID,imageSrc:imageSrc},
	  //         success:function(res){
	  //         	//window.location.href = addprofileurl;
	  //         }
	  //       });
  


  	// $('.saveimage').click(function(){
  	// 	 var childUrl = $('.image').val();

  	// 	 alert(childUrl); return false;

		 // var addprofileurl = $('.addprofileurl').val();	
		 // var childUrl = $('.childUrl').val();
	   
	  //    var controllerPath = childUrl+'/ajaxController.php';

   //    	$.ajax({
   //        type:"post",
   //        url:controllerPath,
   //        data:{type:'AddkidsProfileImage',kidID:kidID,imageSrc:imageSrc},
   //        success:function(res){
   //        	window.location.href = addprofileurl;
   //        }
   //      });
   //  });


    // $('.upload').click(function(e) {
    //       var upload_id = $(this).attr('id');
    //         e.preventDefault();
    //         var image = wp.media({ 
    //             title: 'Upload Image',
    //             multiple: false
    //         }).open()

    //         .on('select', function(e){
    //             var uploaded_image = image.state().get('selection').first();
    //             var image_url = uploaded_image.toJSON().url;
    //             var attachment_id = uploaded_image.toJSON().id;
            
    //             $('.change_img img').attr('src', image_url);
    //         });
    //     });
</script>