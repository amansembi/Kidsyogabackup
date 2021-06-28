<?php 
/* Template Name: Gift Cards */
get_header();

 ?>

	<div id="mainsite">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
			the_content();
			endwhile; else: ?>
			<p>Sorry, no posts matched your criteria.</p>
		<?php endif;
         global $current_user;
	     $userID =  $current_user->ID;

		 ?>
	</div>

	<div class="giftcardbtm bgwhite">
		<div class="container d-flex flex-wrap">
			<?php echo do_shortcode('[GIFT_CARDS]');
			  
			?>	

		</div>				
	</div>

	<div class="giftdynamicPopup">
		<div class="giftfixedPopup">
			<div class="giftpop justify-content-center align-items-center">
				<div class="container">
					<div class="giftpopwrap bgwhite">
						<div class="row">
							<div class="col-md-7 giftpopltcol">
								<div class="giftpoplt">
									<h2>Wonder kids gift</h2>
									<form>
										<h5>To</h5>						
										<div class="formfield">
											<input type="text"  name="text" placeholder="Recipient Name" class="formcontrol to_name" value="">					
										</div>
										<div class="formfield">
											<input type="text"  name="text" placeholder="Message Here" class="formcontrol pop_msg" value="" >					
										</div>
										<div class="formfield">
											<input type="text"  name="email" placeholder="Recipient Email" class="formcontrol to_email" value="" required>					
										</div>
										<h5 class="pt20">From</h5>
										<div class="formfield">
											<input type="text"  name="text" placeholder="Sender Name" class="formcontrol from_name" value="" >					
										</div>
										<div class="formfield">
											<input type="text"  name="email" placeholder="Sender Email" class="formcontrol from_email" value="" required>
											<input type="hidden" name="popCartID" class="popCartID" value="">
											<input type="hidden" name="popCartCode" class="popCartCode" value="">
											<input type="hidden" name="expirStatus" class="expirStatus" value="">
											<input type="hidden" name="popCartAmount" class="popCartAmount" value="">
											<input type="hidden" name="current_userID" class="current_userID" value="<?php echo $userID;  ?>">
											<input type="hidden" name="checkoutUrl" class="checkoutUrl" value="<?php echo get_home_url().'/payment-details'; ?>">		

										 <input type="hidden" name="childUrl" class="childUrl" value="<?php echo get_theme_file_uri();  ?>">				
										</div>
										<div class="formfield">
											<input type="button"  name="payOut" id="gotoCheckout" value="" class="formcontrol sbmtbtn" >					
										</div>
									</form>						
								</div>					
							</div>				
							<div class="col-md-5 bgltgray giftpoprtcol p-0" style="background-color: #f1f1f1;max-width: 41.666667%;">
								<div class="giftpopcls posabs" style="position: absolute;top: 20px;right: 35px;">
									<i class="fa fa-close"></i>
								</div>
								<div class="giftpophead d-flex justify-content-between align-items-center" style="padding: 40px 100px 40px 50px;border-bottom: 4px solid #fff;display: flex!important;    justify-content: space-between!important;    align-items: center!important;">
									<div class="giftpopheadlt">
										<?php the_custom_logo(); ?>	
									</div>
									<div class="giftpopheadlt">
										One Year Membership
									</div>
								</div>						
								<div class="giftselectitem" style="padding: 70px 50px;">
									<h5 style="color: #000000;font-size: 20px;font-weight: 600;line-height: 26px;">You've received a special gift from <span class="from"></span></h5>
									<div class="giftselectbox" style="width: 100%;height: 270px;margin: 30px 0;">
									  <img src="">    
									</div>								
									<div class="giftselectinfo">
										<div class="giftinfotxt giftinfotxt1 pb10">
											<span>To:</span>
											<h5></h5>							
										</div>					
										<div class="giftinfotxt giftinfotxt2">
											<span>Message::</span>
											<h5></h5>
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