<?php
/**
 * Template Name: New arrivals
 */

get_header(); ?>

<div class="container">
	<div class="singlpstttl">
		<p> <i class="fa fa-long-arrow-left" aria-hidden="true"></i> <a href="<?php echo home_url(); ?>/my-classes">Back </a> </p>
		<?php
					function getVimeoStats($id) {
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, "http://vimeo.com/api/v2/video/$id.php");
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_TIMEOUT, 30);
						$output = unserialize(curl_exec($ch));
						$output = $output[0];
						curl_close($ch);
						return $output;
					}
				?>		
		<?php global $post;
		$topviewsVideos = array();
			global $wpdb;
			$args = array( 'post_type' => 'dgv-upload', 'posts_per_page' => -1, 'orderby' => 'publish_date', 'order' => 'DESC');
					$the_query = new WP_Query( $args ); 
					?>                          
				<?php if ( $the_query->have_posts() ) : ?>                          
					<?php while ( $the_query->have_posts() ) : $the_query->the_post(); 				
						$exploreimg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); 
						$video_id = get_post_meta( get_the_ID(), 'dgv_response', true );
						
						
						$vd_idval = preg_replace( '/\D/', '', html_entity_decode($video_id) );
						array_push($topviewsVideos,$vd_idval);								
						
						
						?>
						<?php endwhile; ?>
					<?php wp_reset_postdata(); ?>
					<?php else:  ?>
					<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
			   <?php endif;
			   
			   
			   $videotop = array_shift(array_slice($topviewsVideos, 0, 1));
			   
			   $vd_id = $videotop;
			   
			   
				$posts = $wpdb->get_results("SELECT * FROM $wpdb->postmeta
					WHERE meta_key = 'dgv_response' AND  meta_value = '/videos/".$videotop."' LIMIT 1", ARRAY_A);
				$vimeoVdID = $posts[0]['post_id'];
				$postsID = $wpdb->get_results("SELECT * FROM $wpdb->postmeta
					WHERE meta_key = 'vimeo_videos_id' AND  meta_value = '".$vimeoVdID."'", ARRAY_A);
				$post_id = $postsID[0]['post_id'];
			//print_r($posts);
    		$getProductCat = get_the_terms( $post_id, 'classes_category' );
			$age = get_post_meta( $post_id, 'age_', true );
			$type = get_post_meta( $post_id, 'type', true );
			$content_post = get_post($post_id);
			$content = $content_post->post_content;
			$content = apply_filters('the_content', $content);
			$content = str_replace(']]>', ']]&gt;', $content);	
			
				if(isset($_GET['video'])){
					$vd_id = $_GET['video'];
			$posts = $wpdb->get_results("SELECT * FROM $wpdb->postmeta
					WHERE meta_key = 'dgv_response' AND  meta_value = '/videos/".$vd_id."' LIMIT 1", ARRAY_A);
				$vimeoVdID = $posts[0]['post_id'];
				$postsID = $wpdb->get_results("SELECT * FROM $wpdb->postmeta
					WHERE meta_key = 'vimeo_videos_id' AND  meta_value = '".$vimeoVdID."'", ARRAY_A);
					$post_id = $postsID[0]['post_id'];
					$getProductCat = get_the_terms( $postIdData, 'classes_category' );
					$age = get_post_meta( $post_id, 'age_', true );
					$type = get_post_meta( $post_id, 'type', true );
					$content_post = get_post($post_id);
					$content = $content_post->post_content;
					$content = apply_filters('the_content', $content);
					$content = str_replace(']]>', ']]&gt;', $content);
				}
			$teacherId = get_option('teacher_id_'.$vd_id) ;
			$exploreimg = wp_get_attachment_image_src( get_post_thumbnail_id($teacherId), 'full' );
			$teachername = get_the_title( $teacherId );
			$current_user = get_current_user_id();
			$user_liked_vedio = get_user_meta( $current_user, 'user_liked_vedio' , true );
			//var_dump($user_liked_vedio);
			if($vd_id){							
				$VimeoStats = getVimeoStats($vd_id);							
				$plays = $VimeoStats['stats_number_of_plays'];
				$duration = $VimeoStats['duration'];
				$hours = floor($duration / 3600);
				$mins = floor($duration / 60 % 60);
				$secs = floor($duration);
				$timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
				//$likes = $VimeoStats['stats_number_of_likes'];
				//$comments = $VimeoStats['stats_number_of_comments'];
			}else{
				$plays = 0;
			}			
			$count = 0;				
			echo "<div class='clspstdtls'>";
			echo"<h4>"; echo  get_the_title( $post_id ); echo "</h4>";
			foreach ( $getProductCat as $productInfo ) {
				echo"<span>"; echo $productInfo->name; echo "</span>";
                }
			echo "</div>";
			$liked_by_user = get_post_meta( $post_id, 'liked_by_user', true );			
			$userId = $current_user;
			if(in_array($user_liked_vedio[$vd_id],$user_liked_vedio)){
				$fevtext = 'Remove to Favorites';
			}else{
				$fevtext = 'Add to Favorites';
			}
		?>
	</div>
</div>



<div class="sglclsvid">
	<div class="container-fluid p-0">
		<div class="videofullsec">
			<div class="showvideo">
				<input type="hidden" name="childUrl" class="childUrl" value="<?php echo get_theme_file_uri();  ?>">
				<input type="hidden" name="videoId" class="videoId" value="<?php echo $vd_id;  ?>">		
				<input type="hidden" name="autoplaystatus" class="autoplaystatus" value="">
				<iframe id="PLAYER1" class="embed_video" src="https://player.vimeo.com/video/<?php echo $vd_id; ?>?autoplay=1&loop=0&autopause=0&badge=0&controls=0" width="100%" height="100%" frameborder="0" allowfullscreen></iframe>



				
				 
				
				
				
			</div>
			<div class="sglvidfavlistcol">
				<div class="sglvidfavlist">
				<?php
				$all_video_array = array();
				$count = 1; 
				foreach($topviewsVideos as $video){
				array_push($all_video_array,$video);					
				//var_dump($video);
				$VimeoVidStats = getVimeoStats($video);
				$title = $VimeoVidStats['title'];
				$durationfev = $VimeoVidStats['duration'];
				$hours = floor($durationfev / 3600);
				$mins = floor($durationfev / 60 % 60);
				$secs = floor($durationfev);
				$timeFormatfev = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
				global $wp;
				$current_url = home_url( $wp->request );			
				 
					$url_vd_id = $_GET['video'];
					
					if($vd_id == $video){ ?>
					<div class="sglvidfavlistitem d-flex align-items-center active">					
						
						<div class="sglvidfavlistnum"><?php echo $count; ?>.</div>
						<a href="<?php echo $current_url; ?>/?video=<?php echo $video; ?>">
						<div class="sglvidfavlisttitle"><?php echo $title; ?></div></a>
						<div class="sglvidfavlisdur"><?php echo $timeFormatfev; ?></div>
						
					</div>
					<?php 
					
					} else{ ?>
					<div class="sglvidfavlistitem d-flex align-items-center">					
						
						<div class="sglvidfavlistnum"><?php echo $count; ?>.</div>
						<a href="<?php echo $current_url; ?>/?video=<?php echo $video; ?>">
						<div class="sglvidfavlisttitle"><?php echo $title; ?></div></a>
						<div class="sglvidfavlisdur"><?php echo $timeFormatfev; ?></div>
						
					</div>
					<?php 
					
					} 
				$count = $count + 1;
					} 
				
				 ?>
				<input type="hidden" name="all_video_array" class="all_video_array" value='<?php echo json_encode($all_video_array);  ?>'>
				</div>				
			</div>			
		</div>
		
	</div>
</div>





<div id="mainsite">
	<div class="container">		   
		<div class="row">
			<div class="col-md-8">
			<div class="checkbox switcher">
				  <label for="test3">
					<input type="checkbox" id="test3" class="switch-autoplay">
					<span><small></small></span>
					<small>AutoPlay</small>
				  </label>
				</div>
				<h4> DESCRIPTION </h4>
				<?php echo $content; ?>
			</div>
			<div class="col-md-4">
				<div class="sglclssidebar">
					<div class="slgclsfavbtn">
						<a href="#" class="btn btnorange"> </a>						
					</div>
					<div class="sglclssidbaritems">
					<div class="loginFirst_popup"></div>
					   <div class="sglclssidbaritem d-flex">
						    <div class="sglclssidbaritemlabel favbtn"> 
							<input type="hidden" value="<?php echo $post_id; ?>" class="post_video_id">
							<input type="hidden" value="<?php echo $vd_id; ?>" class="video_id">							
							<input type="hidden" value="<?php echo $userId; ?>" class="loged_in">
							
								<a href="javascript:void(0);" class="favourite_status"><?echo $fevtext; ?></a>
							</div>
						</div>
						<div class="sglclssidbaritem d-flex align-items-center">
							<div class="sglclssidbaritemlabel prflsec">
							<a href="<?php echo get_permalink($teacherId); ?>"><img src="<?php echo $exploreimg[0]; ?>" alt="" height="50px; width:50px;"></a>
							</div>
							<div class="sglclssidbaritemvaluenm prflsectxt">
                               	<a href="<?php echo get_permalink($teacherId); ?>"><?php echo $teachername; ?></a>
							</div>
						</div>						
						<div class="sglclssidbaritem">
							<div class="row">
								<div class="col-md-4">
									<div class="sglclssidbaritemlabel d-flex">
										DURATION <span>:</span>
									</div>
								</div>
								<div class="col-md-8">
									<div class="sglclssidbaritemvalue durationval"><?php echo $timeFormat; ?></div>									
								</div>								
							</div>
						</div>						
						<div class="sglclssidbaritem">
							<div class="row">
								<div class="col-md-4">
									<div class="sglclssidbaritemlabel d-flex">
										Age <span>:</span>
									</div>
								</div>
								<div class="col-md-8">
									<div class="sglclssidbaritemvalue">
										<?php echo $age; ?>
									</div>
								</div>
							</div>
						</div>						
						<div class="sglclssidbaritem">
							<div class="row">
								<div class="col-md-4">
									<div class="sglclssidbaritemlabel d-flex">
										Type <span>:</span>									
									</div>
								</div>
								<div class="col-md-8">
									<div class="sglclssidbaritemvalue">
										<?php echo $type; ?>
									</div>
								</div>
							</div>
						</div>
					</div>					
				</div>				
			</div>
		</div>
	</div>
</div>
<script>
$('.sglclssidbaritem .sglclssidbaritemlabel a').on('click',function() {
	
		$('.favourite_status').text('');	
		$('.loginFirst_popup').removeClass('login_first');
		$(this).toggleClass("active");
		var post_video_id = $('.post_video_id').val();
		var video_id = $('.video_id').val();
		var loged_in = $('.loged_in').val();
		if(loged_in > 0){
	$.ajax({
		type: "post",
		url: my_ajax_object.ajax_url,
		
		data: { 
			  action: 'my_user_vote',
			  post_video_id:post_video_id,			  
			  video_id:video_id,			  
			},
        success: function(msg){			
		if(msg == 0){
			$('.favourite_status').text('Add to Favorites');
		}else{
			$('.favourite_status').text('Remove to Favorites');
		}	 

				
	  }
    });
	 }else{
		  $('.loginFirst_popup').addClass('login_first');
	 }
	

});

function indexofval(videoId, all_video_array)
	{
		
	  for(var i = 0; i < all_video_array.length; i++) 
	  {
		if(all_video_array[i] == videoId)
		{
		  return i;
		  break;
		}
	  }

	  return false; 
	}

$(document).ready(function(){ 

	var all_video_array = $('.all_video_array').val();
	//alert(all_video_array);
	
	
	var childUrl = $('.childUrl').val();
	var videoId = $('.videoId').val();
	var comnplantcount = $(".comnplant").length;
	comnplantcount = comnplantcount + 1;
	var appendnewdiv = "<div class='comnplant plant"+comnplantcount+"'><img src='"+childUrl+"/images/"+comnplantcount+".png'></div>";
	//var autopalystatus = $('#switch-autoplay').val();
	//var videoId = $('.videoId').val();
	var value = jQuery.parseJSON(all_video_array);	
   var controllerPath = childUrl+'/ajaxController.php';
	setTimeout(function() {           
          var count = 0;
          ld_video_count = 0;
          var ld_video_players = {};
          duration = 0;
          currentTime = 0;          
          jQuery('.sglclsvid iframe').each( function(index, element) {
          ld_video_count += 1;
          var element_id = jQuery(element).prop('id');            
          if ( ( typeof element_id === 'undefined' ) || ( element_id == '' ) ) {
            jQuery(element).prop('id', 'ld-video-player-'+ld_video_count);
            element_id = 'ld-video-player-'+ld_video_count;
			}          
          if ( typeof element_id !== 'undefined' ) {
            ld_video_players[element_id] = new Vimeo.Player(element);
            if ( typeof ld_video_players[element_id] !== 'undefined' ) {
              ld_video_players[element_id].on('timeupdate', function(something) {				  
                currentTime = Math.round(something.seconds);
                percent = something.percent;
				seconds = something.seconds;
				
								
                if (percent >= 0.99) {
					//var autopalystatus = $('#switch-autoplay').val();
					var autopalystatus1 = $('.switch-autoplay').is(":checked");
					$(".allplants").append(appendnewdiv);
					$('#exampleModal12').modal();
				if(autopalystatus1 === true){
					//alert('on');
					var index = indexofval(videoId,value);
					var idExist = all_video_array.includes(videoId);
					if(idExist == true){
						index = index +1;
					setTimeout( function(){ 							
						 window.location = 'http://kidsyoga.securework.co/new-arrivals/?video='+value[index]+'';
						 }  , 2000 );
					}
				}
					 $.ajax({
						  type:"post",
						  url:controllerPath,
						  data:{type:'watchedvideoaddtree',videoId:videoId},
						  success:function(res){						
							console.log(res);
						  }
						});						
                    ++count;
                  }
              });                   
              
            }
          }
        });
            
      },1000);
	  
	  $('.switch-autoplay').change(function(e) {

	if (e.target.checked) { 
	localStorage.checked = true; 
	} else { 
	localStorage.checked = false; 
	} 

	});
	if(localStorage.checked === 'true'){
		document.querySelector('.switch-autoplay').checked = 'checked';
	}else{
		document.querySelector('.switch-autoplay').checked = '';
	}

		
});

</script>

<?php get_footer();