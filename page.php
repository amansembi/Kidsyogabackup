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
$inrbnr = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); ?>

<?php if(is_front_page()) :?>
<?php else : ?>
<?php if($inrbnr){	
 ?>
<div class="inrbnr inrpagebnr bgcentr" style="background-image: url('<?php echo $inrbnr[0]; ?>')"></div>
<?php } endif ;?>

<div id="mainsite">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
		the_content();
		endwhile; else: ?>
		<p>Sorry, no posts matched your criteria.</p>
	<?php endif; ?>
</div>

<?php get_footer();