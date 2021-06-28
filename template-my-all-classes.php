<?php


	
	
/* Template Name: My Classes */
get_header(); 


$bnrimg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );  

global $wp;
$current_url = home_url();
$current_user = get_current_user_id();
$user_liked_vedios = get_user_meta( $current_user, 'user_liked_vedio' , true );
//var_dump();
//$current_user = get_current_user_id();
			$watchedVideoIds = get_user_meta($current_user,'watched_video',true);
			// print_r($watchedVideoIds);
			// print_r(count($watchedVideoIds));
			$viewedVideoCount = 0;
			$vdcount = count($watchedVideoIds);
			if(!is_array($watchedVideoIds) || $watchedVideoIds == ''){
				$watchedVideoIdsarray = 0;	
			}else{
				$watchedVideoIdsarray = 1;
			}	
			foreach($watchedVideoIds as $watchedVideoId){ 
			$viewedVideoCount = $viewedVideoCount+1;
			}
			//print_r($current_user);
?>

<?php
global $current_user_X;
$userid = $current_user_X->data->ID;

?>
<div id="mainsite ">	
	
	<!-- Start Banner 
	<div class="inrbnr d-flex align-items-center justify-content-center text-center bgcentr" style="background-image: url('<?php// echo $bnrimg[0]; ?>')">
			
	</div>
	<!-- End Banner -->
	
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
		the_content();
		endwhile; else: ?>
		<p>Sorry, no posts matched your criteria.</p>
	<?php endif; ?>
	

	<div class="secplanted">
		<div class="container">
			<div class="planted">
				<div class="favVideo_title">
					<h4 class="secmaintitl">my classes</h4>
				</div>
				<div class="banplanted <?php if( $watchedVideoIdsarray != 0 ){ ?>VideosWatched<?php } ?>">
					<div class="plantleft">
						<div class="plntmanimg">
							<img src="<?php echo get_bloginfo('stylesheet_directory'); ?>/images/plantimg.png">
						</div>
						<?php if($watchedVideoIdsarray != 0 ){ ?>
						<div class="plantcomment">
							
							<p>we have planted <?php echo $viewedVideoCount; ?> trees for you</p>
							
						</div>
						<?php } ?>
					</div>
					<div class="allplants">
					
					<?php 
					
						$count = 1;
				 if($watchedVideoIdsarray != 0){ 
					foreach($watchedVideoIds as $watchedVideoId){ ?>
						<div class="comnplant plant<?php echo $count; ?>">
							<img src="<?php echo get_bloginfo('stylesheet_directory'); ?>/images/<?php echo $count; ?>.png">
						</div>
					<?php 
					$count = $count + 1;
				 } }else{
					 ?>
					 <p>You haven't started any classes Yet</p>
					 <p> Take a yoga class and watch your forest grow</p>
					 
					 <?php
				 }?>
						
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="favourite_video" class="explrclasses pt60 <?php if(empty($userid)){ echo 'openpoup'; }else{ echo ''; }  ?>">
		<div class="container">	
			<div class="favVideo_title"><h4  class="secmaintitl">Favourite Videos</h4><a class="secviewall" href="<?php echo $current_url; ?>/favourite/?video=<?php echo array_shift(array_slice($user_liked_vedios, 0, 1)); ?>"" alt="">Play All <i class="fa fa-caret-right" aria-hidden="true"></i></a></div>
			<div class="row">
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
				<?php 
				
								
				foreach($user_liked_vedios as $user_liked_vedio){
					$videoDetail = getVimeoStats($user_liked_vedio);
					$thumbnail_large = $videoDetail['thumbnail_large'];
					$stats_number_of_plays = $videoDetail['stats_number_of_plays'];
					$duration = $videoDetail['duration'];
					$description = $videoDetail['description'];
					$title = $videoDetail['title'];
					$videoType = get_option( 'dgv_response_type_'.$user_liked_vedio );						
					$term = get_term_by('slug', $videoType, 'classes_category'); 
					$className = $term->name;
					$teacherId = get_option('teacher_id_'.$user_liked_vedio) ;
					$exploreimg = wp_get_attachment_image_src( get_post_thumbnail_id($teacherId), 'full' );
					$teachername = get_the_title( $teacherId );
						
				?>
				
				
				<div class="col-md-3">
						<div class="classbox">
						<a href="<?php echo $current_url; ?>/favourite/?video=<?php echo $user_liked_vedio; ?>">
							<div class="classimg bgtopcentr" style="background-image: url('<?php echo $thumbnail_large; ?>')">
								<span><?php echo $className; ?></span>
							</div></a>
							<div class="classtitle">
								<h5><a href="<?php echo get_permalink($teacherId); ?>"><?php echo $teachername; ?></a></h5>					
							</div>
							<div class="classmeta">
								<ul class="d-flex">
									<li class="d-flex align-items-center"><i class="fa fa-eye"></i> <?php echo $stats_number_of_plays; ?></li>									
								</ul>						
							</div>
							<div class="classsubtitle">
								<h5><a href="<?php echo $current_url; ?>/favourite/?video=<?php echo $user_liked_vedio; ?>"><?php echo $title;?></a></h5>
							</div>
							<div class="classsdesc">
								<?php echo wp_trim_words( $description, 15, '...' ); ?> <a class="morelink viewlink" href="<?php echo $current_url; ?>/favourite/?video=<?php echo $user_liked_vedio; ?>">Read more</a>
							</div>	
						</div>                                                          
					</div>
				
				
				<?php
				
				
				}
				
				?>
			</div>		
		</div>
	</div>
	
	<div id="top_video" class="explrclasses vimeo_top_videos pt60 <?php if(empty($userid)){ echo 'openpoup'; }else{ echo ''; }  ?>">
		<div class="container">	
			<div class="favVideo_title"><h4  class="secmaintitl">Top Videos</h4><a class="secviewall" href="<?php echo $current_url; ?>/top-videos/" alt="top-videos">Play All <i class="fa fa-caret-right" aria-hidden="true"></i></a></div>
			<div class="row">
			
				<?php 
				
				//$current_user = get_current_user_id();
				//$user_liked_vedios = get_user_meta( $current_user, 'user_liked_vedio' , true );
			
				
					$args = array( 'post_type' => 'dgv-upload', 'posts_per_page' => -1);
					$the_query = new WP_Query( $args ); 
					?>                          
				<?php if ( $the_query->have_posts() ) : ?>                          
					<?php while ( $the_query->have_posts() ) : $the_query->the_post(); 				
						$exploreimg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); 
						$video_id = get_post_meta( get_the_ID(), 'dgv_response', true );
						
						
						$vd_id = preg_replace( '/\D/', '', html_entity_decode($video_id) );
						
						$videoDetail = getVimeoStats($vd_id);
						$stats_number_of_plays = $videoDetail['stats_number_of_plays'];
						$topviewsVideos[$vd_id] = $stats_number_of_plays;						
						
						
						?>
						<?php endwhile; ?>
					<?php wp_reset_postdata(); ?>
					<?php else:  ?>
					<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
			   <?php endif;
				arsort($topviewsVideos);
					$count = 1;
				foreach($topviewsVideos as $key=>$topviewsVideo){
					$getVideoDetail = getVimeoStats($key);					
					$thumbnail_large = $getVideoDetail['thumbnail_large'];
					$stats_number_of_plays = $getVideoDetail['stats_number_of_plays'];
					$duration = $getVideoDetail['duration'];
					$description = $getVideoDetail['description'];
					$title = $getVideoDetail['title'];
					$videoType = get_option( 'dgv_response_type_'.$key);						
					$term = get_term_by('slug', $videoType, 'classes_category'); 
					$className = $term->name;
					$teacherId = get_option('teacher_id_'.$key) ;
					$exploreimg = wp_get_attachment_image_src( get_post_thumbnail_id($teacherId), 'full' );
					$teachername = get_the_title( $teacherId );					
						if($count <= 4){
					?>
					
					<div class="col-md-3">
						<div class="classbox">
						<a href="<?php echo $current_url; ?>/top-videos/?video=<?php echo $key; ?>">
							<div class="classimg bgtopcentr" style="background-image: url('<?php echo $thumbnail_large; ?>')">
								<span><?php echo $className; ?></span>
							</div></a>
							<div class="classtitle">
								<h5><a href="<?php echo get_permalink($teacherId); ?>"><?php echo $teachername; ?></a></h5>					
							</div>
							<div class="classmeta">
								<ul class="d-flex">
									<li class="d-flex align-items-center"><i class="fa fa-eye"></i> <?php echo $stats_number_of_plays; ?></li>									
								</ul>						
							</div>
							<div class="classsubtitle">
								<h5><a href="<?php echo $current_url; ?>/top-videos/?video=<?php echo $key; ?>"><?php echo $title;?></a></h5>
							</div>
							<div class="classsdesc">
								<?php echo wp_trim_words( $description, 15, '...' ); ?> <a class="morelink viewlink" href="<?php echo $current_url; ?>/top-videos/?video=<?php echo $key; ?>">Read more</a>
							</div>	
						</div>                                                          
					</div>
					
					<?php
						}
						$count = $count +1; 
				}
				
			   ?>
				
				
			</div>		
		</div>
	</div>
	
	<div id="arrivals_video" class="explrclasses new_arrivals_videos pt60 <?php if(empty($userid)){ echo 'openpoup'; }else{ echo ''; }  ?>">
		<div class="container">	
			<div class="favVideo_title"><h4  class="secmaintitl">New arrivals</h4><a class="secviewall" href="<?php echo $current_url; ?>/new-arrivals/" alt="">Play All <i class="fa fa-caret-right" aria-hidden="true"></i></a></div>
			<div class="row">
			
				<?php 
				
				//$current_user = get_current_user_id();
				//$user_liked_vedios = get_user_meta( $current_user, 'user_liked_vedio' , true );
			
				
					$args = array( 'post_type' => 'dgv-upload', 'posts_per_page' => 4, 'orderby' => 'publish_date', 'order' => 'DESC',);
					$the_query = new WP_Query( $args ); 
					?>                          
				<?php if ( $the_query->have_posts() ) : ?>                          
					<?php while ( $the_query->have_posts() ) : $the_query->the_post(); 				
						$exploreimg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); 
						$video_id = get_post_meta( get_the_ID(), 'dgv_response', true );
						
						$vd_id = preg_replace( '/\D/', '', html_entity_decode($video_id) );
						
						$videoDetail = getVimeoStats($vd_id);
						$stats_number_of_plays = $videoDetail['stats_number_of_plays'];										
						$thumbnail_large = $videoDetail['thumbnail_large'];						
						$duration = $videoDetail['duration'];
						$description = $videoDetail['description'];
						$title = $videoDetail['title'];
						$videoType = get_option( 'dgv_response_type_'.$vd_id);						
						$term = get_term_by('slug', $videoType, 'classes_category'); 
						$className = $term->name;
						$teacherId = get_option('teacher_id_'.$vd_id) ;
						$exploreimg = wp_get_attachment_image_src( get_post_thumbnail_id($teacherId), 'full' );
						$teachername = get_the_title( $teacherId );		
						
						?>
						<div class="col-md-3">
						<div class="classbox">
						<a href="<?php echo $current_url; ?>/new-arrivals/?video=<?php echo $vd_id; ?>">
							<div class="classimg bgtopcentr" style="background-image: url('<?php echo $thumbnail_large; ?>')">
								<span><?php echo $className; ?></span>
							</div>
							</a>
							<div class="classtitle">
								<h5><a href="<?php echo get_permalink($teacherId); ?>"><?php echo $teachername;?></a></h5>					
							</div>
							<div class="classmeta">
								<ul class="d-flex">
									<li class="d-flex align-items-center"><i class="fa fa-eye"></i> <?php echo $stats_number_of_plays; ?></li>									
								</ul>						
							</div>
							<div class="classsubtitle">
								<h5><a href="<?php echo $current_url; ?>/new-arrivals/?video=<?php echo $vd_id; ?>"><?php echo $title;?></a></h5>
							</div>
							<div class="classsdesc">
								<?php echo wp_trim_words( $description, 15, '...' ); ?> <a class="morelink viewlink" href="<?php echo $current_url; ?>/new-arrivals/?video=<?php echo $vd_id; ?>">Read more</a>
							</div>	
						</div>                                                          
					</div>
						<?php endwhile; ?>
					<?php wp_reset_postdata(); ?>
					<?php else:  ?>
					<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
			   <?php endif;
			   ?>
				
				
			</div>		
		</div>
	</div>
	
	<div id="all_video" class="explrclasses all_videos pt60 <?php if(empty($userid)){ echo 'openpoup'; }else{ echo ''; }  ?>">
		<div class="container">	
			<div class="favVideo_title"><h4  class="secmaintitl">All videos</h4><a class="secviewall" href="<?php echo $current_url; ?>/all-videos/" alt="">Play All <i class="fa fa-caret-right" aria-hidden="true"></i></a></div>
			<div class="row">
			
				<?php 
				
				//$current_user = get_current_user_id();
				//$user_liked_vedios = get_user_meta( $current_user, 'user_liked_vedio' , true );
			
				
					$args = array( 'post_type' => 'dgv-upload', 'posts_per_page' => -1, 'orderby' => 'publish_date', 'order' => 'DESC',);
					$the_query = new WP_Query( $args ); 
					?>                          
				<?php if ( $the_query->have_posts() ) : ?>                          
					<?php while ( $the_query->have_posts() ) : $the_query->the_post(); 				
						$exploreimg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); 
						$video_id = get_post_meta( get_the_ID(), 'dgv_response', true );
						
						$vd_id = preg_replace( '/\D/', '', html_entity_decode($video_id) );
						
						$videoDetail = getVimeoStats($vd_id);
						$stats_number_of_plays = $videoDetail['stats_number_of_plays'];										
						$thumbnail_large = $videoDetail['thumbnail_large'];						
						$duration = $videoDetail['duration'];
						$description = $videoDetail['description'];
						$title = $videoDetail['title'];
						$videoType = get_option( 'dgv_response_type_'.$vd_id);						
						$term = get_term_by('slug', $videoType, 'classes_category'); 
						$className = $term->name;
						$teacherId = get_option('teacher_id_'.$vd_id) ;
						$exploreimg = wp_get_attachment_image_src( get_post_thumbnail_id($teacherId), 'full' );
						$teachername = get_the_title( $teacherId );	
						
						?>
						<div class="col-md-3">
						<div class="classbox">
						<a href="<?php echo $current_url; ?>/all-videos/?video=<?php echo $vd_id; ?>">
							<div class="classimg bgtopcentr" style="background-image: url('<?php echo $thumbnail_large; ?>')">
								<span><?php echo $className; ?></span>
							</div>
							</a>
							<div class="classtitle">
								<h5><a href="<?php echo get_permalink($teacherId); ?>"><?php echo $teachername;?></a></h5>					
							</div>
							<div class="classmeta">
								<ul class="d-flex">
									<li class="d-flex align-items-center"><i class="fa fa-eye"></i> <?php echo $stats_number_of_plays; ?></li>									
								</ul>						
							</div>
							<div class="classsubtitle">
								<h5><a href="<?php echo $current_url; ?>/all-videos/?video=<?php echo $vd_id; ?>"><?php echo $title;?></a></h5>
							</div>
							<div class="classsdesc">
								<?php echo wp_trim_words( $description, 15, '...' ); ?> <a class="morelink viewlink" href="<?php echo $current_url; ?>/all-videos/?video=<?php echo $vd_id; ?>">Read more</a>
							</div>	
						</div>                                                          
					</div>
						<?php endwhile; ?>
					<?php wp_reset_postdata(); ?>
					<?php else:  ?>
					<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
			   <?php endif;
			   ?>
				
				
			</div>		
		</div>
	</div>
</div>
<script>
var favourite_video = $( "#favourite_video" ).hasClass( "openpoup" );
var top_video = $( "#top_video" ).hasClass( "openpoup" );
var arrivals_video = $( "#arrivals_video" ).hasClass( "openpoup" );
var all_video = $( "#all_video" ).hasClass( "openpoup" );

if(favourite_video === true){
	
	//$('#mainsite a').bind("click.myDisable", function() { return false; });
	$('#favourite_video a').attr("href", 'javascript:void(0)');
	
}
if(top_video === true){
	
	//$('#mainsite a').bind("click.myDisable", function() { return false; });
	$('#top_video a').attr("href", 'javascript:void(0)');
	
}if(arrivals_video === true){
	
	//$('#mainsite a').bind("click.myDisable", function() { return false; });
	$('#arrivals_video a').attr("href", 'javascript:void(0)');
	
}if(all_video === true){
	
	//$('#mainsite a').bind("click.myDisable", function() { return false; });
	$('#all_video a').attr("href", 'javascript:void(0)');
	
}
</script>


<?php get_footer();