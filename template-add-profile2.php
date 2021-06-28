<?php
/* Template Name: Add Profile 2 */
//get_header('login');
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
   $_SESSION["username"];
   $_SESSION["userID"];
?>

<div class="bgcolor">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-5">
				<div class="profilebox">
					<div class="prof2titles">
						<div class="profileboxtitle">
							<h2>
								<span>Add Profile</span>
							</h2>
						</div>
						<div class="profileboxsubtitle">
							<h4>
								Add a profile for another kid taking yoga classes
							</h4>
						</div>
					</div>
					<div class="adkidnameinputbox d-flex align-items-center">
						<div class="kidimgicon">
							<div class="userpicbox usercmnbox d-flex justify-content-center align-items-center">
								<img src="http://kidsyoga.securework.co/wp-content/uploads/2021/03/icon-profile-big.png">
							</div>
						</div>
						<div class="kidaddfrm">
							<form method="post">					
								<div class="formfield">
									<input type="text"  name="kidname" placeholder="Kid’s Name" class="formcontrol kidsname" value=""><input type="hidden" name="childUrl" class="childUrl" value="<?php echo get_theme_file_uri();  ?>">	
									<input type="hidden" name="addprofileurl" class="addprofileurl" value="<?php echo get_home_url().'/add-profile-3/'; ?>">				
									<input type="hidden" name="myclassesurl" class="myclassesurl" value="<?php echo get_home_url().'/my-classes/'; ?>">
									
								</div>								
							</form>
						</div>
					</div>
					<div class="kidsaddstatus"><span style="color:red;"></span></div>
					<div class="userboxbtn kidprof2btns">
						<ul class="d-flex flex-wrap">
							<li><a href="javascript:void(0)" class="adduser">Done</a></li>
							<li><a href="#" class="kidcnclbtn">Cancel</a></li>
						</ul>	
					</div>
			</div>
		</div>
	</div>
</div>
</div>
<div id="addnomorekids" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
      </div>
      <div class="modal-body">
        <p>You are not able to add more user.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default okpopup" data-dismiss="modal">Ok</button>
      </div>
    </div>

  </div>
</div><div id="kidsexist" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
      </div>
      <div class="modal-body">
        <p>Kids name alredy exist.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
      </div>
    </div>

  </div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($){	
		var childUrl = $('.childUrl').val();
		var addprofileurl = $('.addprofileurl').val();
		var controllerPath = childUrl+'/ajaxController.php';

        var username = '<?php echo $_SESSION["username"]; ?>';
        var userID = '<?php echo $_SESSION["userID"]; ?>';

      $('.adduser').click(function(){
        var kidsname = $('.kidsname').val();
      	$.ajax({
          type:"post",
          url:controllerPath,
          data:{type:'AddSubuser',kidsname:kidsname,userID:userID,username:username,},
          success:function(res){
			  console.log(res);
          	if($.trim(res) == 'nameexist'){
				$('#kidsexist').modal();				
			}else if($.trim(res) == 'kidslengthcomplete'){             
			 $('#addnomorekids').modal();			  
          	}else if($.trim(res) == 'done'){ 
          		window.location.href = addprofileurl;
          	 }
          }
        });
      });
	  $('.okpopup').click(function(){
		  var myclassesurl = $('.myclassesurl').val();
		  window.location.href = myclassesurl;
	  });
	}); 
</script>

<?php get_footer();


///TESTINGSS@GAMIL.COM