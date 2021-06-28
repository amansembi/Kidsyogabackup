<?php
/* Template Name: User Favourite Videos */
get_header(); ?>

<div class="container">
	<div class="singlpstttl">
		<p> <i class="fa fa-long-arrow-left" aria-hidden="true"></i> <a href="http://kidsyoga.securework.co/classes">Back To All classes </a> </p>
		<?php global $post;
    		$post_id = $post->ID;
    		$getProductCat = get_the_terms( $post_id, 'classes_category' );
			echo "<div class='clspstdtls'>";
			echo"<h4>"; echo  get_the_title( $post_id ); echo "</h4>";
			foreach ( $getProductCat as $productInfo ) {
				echo"<span>"; echo $productInfo->name; echo "</span>";
                }
			echo "</div>";	
		?>
	</div>
</div>

<div class="sglclsvid">
	<div class="container-fluid p-0">
		<div class="row no-gutters">
			<div class="col-md-8">
				<video width="100%" height="100%" controls autoplay  id="video-active">
					<source src="<?php the_field('yoga_video'); ?>" type="video/mp4">>
				</video>					
			</div>
			<div class="col-md-4 sglvidfavlistcol">
				<div class="sglvidfavlist">
					<div class="sglvidfavlistitem d-flex align-items-center">
						<div class="sglvidfavlistnum">1.</div>
						<div class="sglvidfavlisttitle">Your Favourites video 1</div>
						<div class="sglvidfavlisdur">5:15</div>
					</div>
					<div class="sglvidfavlistitem d-flex align-items-center">
						<div class="sglvidfavlistnum">2.</div>
						<div class="sglvidfavlisttitle">Your Favourites video 2</div>
						<div class="sglvidfavlisdur">5:15</div>
					</div>
					<div class="sglvidfavlistitem d-flex align-items-center">
						<div class="sglvidfavlistnum">3.</div>
						<div class="sglvidfavlisttitle">Your Favourites video 3</div>
						<div class="sglvidfavlisdur">5:15</div>
					</div>
					<div class="sglvidfavlistitem d-flex align-items-center">
						<div class="sglvidfavlistnum">4.</div>
						<div class="sglvidfavlisttitle">Your Favourites video 4</div>
						<div class="sglvidfavlisdur">5:15</div>
					</div>
					<div class="sglvidfavlistitem d-flex align-items-center">
						<div class="sglvidfavlistnum">5.</div>
						<div class="sglvidfavlisttitle">Your Favourites video 5</div>
						<div class="sglvidfavlisdur">5:15</div>
					</div>
					<div class="sglvidfavlistitem d-flex align-items-center">
						<div class="sglvidfavlistnum">6.</div>
						<div class="sglvidfavlisttitle">Your Favourites video 5</div>
						<div class="sglvidfavlisdur">5:15</div>
					</div>
					<div class="sglvidfavlistitem d-flex align-items-center">
						<div class="sglvidfavlistnum">7.</div>
						<div class="sglvidfavlisttitle">Your Favourites video 5</div>
						<div class="sglvidfavlisdur">5:15</div>
					</div>
					<div class="sglvidfavlistitem d-flex align-items-center">
						<div class="sglvidfavlistnum">8.</div>
						<div class="sglvidfavlisttitle">Your Favourites video 5</div>
						<div class="sglvidfavlisdur">5:15</div>
					</div>
					<div class="sglvidfavlistitem d-flex align-items-center">
						<div class="sglvidfavlistnum">9.</div>
						<div class="sglvidfavlisttitle">Your Favourites video 5</div>
						<div class="sglvidfavlisdur">5:15</div>
					</div>
					<div class="sglvidfavlistitem d-flex align-items-center">
						<div class="sglvidfavlistnum">10.</div>
						<div class="sglvidfavlisttitle">Your Favourites video 5</div>
						<div class="sglvidfavlisdur">5:15</div>
					</div>
				</div>				
			</div>			
		</div>
	</div>
</div>





<div id="mainsite">
	<div class="container">		   
		<div class="row">
			<div class="col-md-8">
				<h4> DESCRIPTION </h4>
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
					the_content();
					endwhile; else: ?>
					<p>Sorry, no posts matched your criteria.</p>
				<?php endif; ?>
			</div>
			<div class="col-md-4">
				<div class="sglclssidebar">
					<div class="slgclsfavbtn">
						<a href="#" class="btn btnorange"> </a>						
					</div>
					<div class="sglclssidbaritems">
					   <div class="sglclssidbaritem d-flex">
						    <div class="sglclssidbaritemlabel favbtn"> 
								<a href="#">  Add to Favorites </a>
							</div>
						</div>
						<div class="sglclssidbaritem d-flex align-items-center">
							<div class="sglclssidbaritemlabel prflsec">
								<img src="http://kidsyoga.securework.co/wp-content/uploads/2021/03/image-instructor-2.jpg" alt="" height="50px; width:50px;">
							</div>
							<div class="sglclssidbaritemvaluenm prflsectxt">
                               Kayla Nielsen
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
									<div class="sglclssidbaritemvalue durationval"></div>									
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
										<?php the_field('age_');?>
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
										<?php the_field('type');?>
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

<?php get_footer();