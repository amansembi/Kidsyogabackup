<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */
 get_header();

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
				
global $post;
global $current_user_X;
$userid = $current_user_X->data->ID;
$instructor_array = array();
$instrctrimg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID),'full'); 
$bnrimg = get_field('banner_image'); 
$post_slug = $post->post_name;
$postId = $post->ID;

$teacher_videos = get_post_meta($postId,'teacher_video',true);
$term = get_term_by('slug', $post_slug, 'classes_instructor');
$args = array(
    'post_type' => 'classes',
	'posts_per_page' => -1,
	'orderby'	=>  'menu_order',
	'order'	=>  'ASC',
	'tax_query' => array(
		array(
			'taxonomy' => 'classes_instructor',//$taxonomy_name,
				'field' => 'term_id',
				'terms' => $term->term_id,
		)
	)
);

$total_posts = get_posts($args); 
	
?>

<div id="mainsite">
		
	<div class="instrctrbnr bgcentr" style="background-image: url('<?php echo esc_url($bnrimg['url']); ?>')"></div>	
	<div class="instrctrinfo text-center">
		<div class="instrctrimg bgcentr" style="background-image: url('<?php echo $instrctrimg[0]; ?>')"></div>
		<div class="instrctrtitle">
			<h1 class="text-uppercase"><?php the_title();?></h1>
		</div>
		<div class="instrctrsoc">
			<ul class="d-flex justify-content-center">
				<li><a href="#"><i class="fa fa-facebook"></i></a></li>
				<li><a href="#"><i class="fa fa-instagram"></i></a></li>
				<li><a href="#"><i class="fa fa-world"></i></a></li>
			</ul>	
		</div>		
	</div>
	
	<div class="instrctrcont pb100">	 
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-11">
					<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
						the_content();
						endwhile; else: ?>
						<p>Sorry, no posts matched your criteria.</p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	
	<div class="instrctrcls">
		<div class="container">
			<div class="row">
				<?php// if ( $total_posts ) : 
					//foreach ($total_posts as $values) :
					//$instrctrimg = wp_get_attachment_image_src( get_post_thumbnail_id($values->ID),'full'); 
						
				?>
				<?php
					if(!empty($teacher_videos)){
					foreach($teacher_videos as $teacher_video){
				$posts = $wpdb->get_results("SELECT * FROM $wpdb->postmeta
					WHERE meta_key = 'dgv_response' AND  meta_value = '/videos/".$teacher_video."' LIMIT 1", ARRAY_A);
				$vimeoVdID = $posts[0]['post_id'];
				$postsID = $wpdb->get_results("SELECT * FROM $wpdb->postmeta
					WHERE meta_key = 'vimeo_videos_id' AND  meta_value = '".$vimeoVdID."'", ARRAY_A);
					$post_id = $postsID[0]['post_id'];
					//print_r($posts);
					$classespermalink = get_permalink($post_id);
					
					$VimeoStats = getVimeoStats($teacher_video);	
					
					 $vidId = $teacher_video; 
					 $title = $VimeoStats['title']; 
					 $thumbnail_medium = $VimeoStats['thumbnail_large']; 
					 $number_of_plays = $VimeoStats['stats_number_of_plays']; 
					 $number_of_likes = $VimeoStats['stats_number_of_likes']; 
					$videoType = get_option( 'dgv_response_type_'.$teacher_video );
					
					$term = get_term_by('slug', $videoType, 'classes_category'); 
					$className = $term->name;
				?>
				<div class="col-md-6 <?php if(empty($userid)){ echo 'openpoup'; }else{ echo ''; }  ?>" id="allVideoOfTeacher" >
					<div class="classbox">					
						<a href="<?php echo $classespermalink; ?>" ><div class="classimg bgtopcentr" style="background-image: url('<?php echo $thumbnail_medium; ?>')">
							<span><?php echo $className; ?></span>
						</div></a>
						<div class="classtitle">
							<h5><?php echo $term->name;?></h5>					
						</div>
						<div class="classmeta">
							<ul class="d-flex">
								<li class="d-flex align-items-center"><i class="fa fa-play"></i><?php echo $number_of_likes; ?></li>
								<li class="d-flex align-items-center"><i class="fa fa-user-o"></i><?php echo $number_of_plays; ?></li>
							</ul>							
						</div>
						<div class="classsubtitle">
							<h5><?php echo $title; ?></h5>
						</div>
						<div class="classsdesc">
				<?php echo wp_trim_words( $values->post_content, 60, '[...]' ); ?> <a class="morelink" href="<?php echo $classespermalink ;?>">Read more</a>
						</div>	
					</div>                                                          
				</div> 
				<?php
	
					} }else{ ?>
				
				<p>Sorry, no posts matched your criteria.</p>
					<?php }  ?>
			</div>
		</div>
	</div>
</div>
<script>
var allVideoOfTeacher = $( "#allVideoOfTeacher" ).hasClass( "openpoup" );
if(allVideoOfTeacher === true){
	
	//$('#mainsite a').bind("click.myDisable", function() { return false; });
	$('#allVideoOfTeacher a').attr("href", 'javascript:void(0)');
	
}
</script>
<?php get_footer();