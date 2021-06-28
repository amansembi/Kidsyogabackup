<?php
/**
 * Template Name: Instructors
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


global $current_user_X;
$userid = $current_user_X->data->ID;


$bnrimg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );  ?>

<div id="mainsite" class="">	
	
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
	
	<div class="allexperts pt60">
		<div class="container">		
			<div class="row">
				<?php 
					$args = array( 'post_type' => 'instructor', 'posts_per_page' => -1 );
					$the_query = new WP_Query( $args ); 
				?>                          
				<?php if ( $the_query->have_posts() ) : ?>                          
					<?php while ( $the_query->have_posts() ) : $the_query->the_post(); 				
						$exploreimg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); 
					?>
					<div class="col-md-2">
						<div class="expertbox text-center">
							<a href="<?php the_permalink();?>"><div class="expertimg bgtopcentr" style="background-image: url('<?php echo $exploreimg[0]; ?>')"></div></a>
							<div class="experttitle">
								<h5><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h5>
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
