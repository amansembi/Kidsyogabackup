<?php
/**
 * Template Name: Classes
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */
  session_start();
get_header();
// if (isset($_SESSION['username']) && $_SESSION['username'] == true) {
   // get_header('subscriber'); 
// } else {
   // get_header(); 
// }

$bnrimg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );  ?>

<div id="mainsite">	
	
	<!-- Start Banner -->
	<div class="inrbnr d-flex align-items-center justify-content-center text-center bgcentr" style="background-image: url('<?php echo $bnrimg[0]; ?>')">
		<div class="container">
			<h1 class="text-uppercase"><?php the_title();?></h1>
			<div class="inrbnrdesc"><?php the_field('banner_sub_title');?></div>
		</div>		
	</div>
	<!-- End Banner -->
	
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
		the_content();
		endwhile; else: ?>
		<p>Sorry, no posts matched your criteria.</p>
	<?php endif; ?>
	
	<div class="explrclasses pt60">
		<div class="container">		
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
				
					$args = array( 'post_type' => 'classes', 'posts_per_page' => -1 );
					$the_query = new WP_Query( $args ); 
				?>                          
				<?php if ( $the_query->have_posts() ) : ?>                          
					<?php while ( $the_query->have_posts() ) : $the_query->the_post(); 				
						$exploreimg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); 
						$video_id = get_post_meta( get_the_ID(), 'vimeo_videos_id', true );
						$vemeo_vid = get_post_meta($video_id, 'dgv_response', true );
						$vd_id = preg_replace( '/\D/', '', html_entity_decode($vemeo_vid) );
						$videoType = get_option( 'dgv_response_type_'.$vd_id );
						$teacherId = get_option('teacher_id_'.$vd_id) ;
						$exploreimg = wp_get_attachment_image_src( get_post_thumbnail_id($teacherId), 'full' );
						$teachername = get_the_title( $teacherId );
						$term = get_term_by('slug', $videoType, 'classes_category'); 
						$className = $term->name;
						if($vd_id){
							
							$VimeoStats = getVimeoStats($vd_id);
							$plays = $VimeoStats['stats_number_of_plays'];
							//$likes = $VimeoStats['stats_number_of_likes'];
							//$comments = $VimeoStats['stats_number_of_comments'];
						}else{
							$plays = 0;
						}
						
					?>
					<div class="col-md-3">
						<div class="classbox">
							<div class="classimg bgtopcentr" style="background-image: url('<?php echo $exploreimg[0]; ?>')">
								<span><?php echo $className; ?></span>
							</div>
							<div class="classtitle">
								<h5><?php echo $teachername; ?></h5>					
							</div>
							<div class="classmeta">
								<ul class="d-flex">
									<li class="d-flex align-items-center"><i class="fa fa-eye"></i> <?php echo $plays; ?></li>									
								</ul>						
							</div>
							<div class="classsubtitle">
								<h5><?php the_title();?></h5>
							</div>
							<div class="classsdesc">
								<?php echo wp_trim_words( get_the_content(), 30, '[...]' ); ?> <a class="morelink" href="<?php the_permalink();?>">Read more</a>
							</div>	
						</div>                                                          
					</div>
					<?php endwhile; ?>
					<?php wp_reset_postdata(); ?>
					<?php else:  ?>
					<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
			   <?php endif; ?>
			</div>		
		</div>
	</div>
</div>

<?php get_footer();
