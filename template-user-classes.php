	<?php
/**
 * Template Name: User Classes
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
// session_start(); 

$bnrimg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); 

$taxonomy = 'classes_category';
$terms = get_terms($taxonomy);
global $current_user_X;
$userid = $current_user_X->data->ID;
 ?>

 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
<div id="mainsite">	
	
	<!-- Start Banner -->
	<div class="inrbnr d-flex align-items-center justify-content-center text-center bgcentr" style="background-image: url('<?php echo $bnrimg[0]; ?>')">
		<div class="container">
			<h1 class="text-uppercase"><?php the_title();?></h1>
			<div class="inrbnrdesc"><?php the_field('banner_sub_title');?></div>
		</div>		
	</div>
	<!-- End Banner -->
	
	<div class="exploretab"><div class="container">
		<div class="exploretab-full">   
		<div class="exploretab-left count_result">
			<h3>showing <span class="resultcount"></span> results</h3>
		</div>
		<div class="exploretab-right d-flex">
		
		<input type="hidden" name="childUrl" class="childUrl" value="<?php echo get_theme_file_uri(); ?> ">
		<nav aria-label="Pati Montero's design system">
		  <ul id="navcontent" class="mainnav">
			<li class="filter_dropdown">
			  <button aria-expanded="true" aria-controls="id-brand-menu" value="">Duration &nbsp;<span class="selected_value_duration"></span></button>
			  <ul id="id-brand-menu">				
				<li><a href="javascript:void(0)">3-10</a></li>				
				<li><a href="javascript:void(0)">10-20</a></li>				
				<li><a href="javascript:void(0)">20-30</a></li>				
				<li><a href="javascript:void(0)">30-40</a></li>				
				<li><a href="javascript:void(0)">40-50</a></li>
				<li><a href="javascript:void(0)">50-60</a></li>
			  </ul>
			</li>
			<li class="filter_dropdown">
			  <button aria-expanded="true" aria-controls="id-style-menu" value="">Age &nbsp;<span class="selected_value_age"></span></button>
			  <ul id="id-style-menu" >
				<li><a href="javascript:void(0)">5-15</a></li>
				<li><a href="javascript:void(0)">15-25</a></li>
				<li><a href="javascript:void(0)">25-35</a></li>
				<li><a href="javascript:void(0)">35-45</a></li>
			  </ul>
			</li>
			<li class="filter_dropdown">
			  <button aria-expanded="true" aria-controls="id-components-menu" value="">Type &nbsp;<span class="selected_value_type"></span></button>
			  <ul id="id-components-menu" >
			  	<?php foreach($terms as $term){	?>			  
					<li><a href="javascript:void(0)"><?php echo $term->name; ?></a></li>				
			  	<?php } ?>
			  </ul>
			</li>
		  </ul>
		</nav>
		
		
		</div></div>
	</div></div><!--exploretab-->   
	
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
		the_content();
		endwhile; else: ?>
		<p>Sorry, no posts matched your criteria.</p>
	<?php endif; ?>

<?php 
$texquery='';
	if(isset($_GET['term'])){
		$texquery = array(
		array(
				'taxonomy' => 'classes_category',
				'field' => 'term_id',
				'terms' => $_GET['term']
			)
		);
	}

	$args = array( 
		'post_type' => 'classes', 
		'posts_per_page' => -1,
		'tax_query' => $texquery		
	);
	
	$the_query = new WP_Query( $args );	

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

	<div id="explrclasses" class="explrclasses pt60">
		<div class="container">		
			<div class="row">
						
				<?php if ( $the_query->have_posts() ) : ?>                          
					<?php while ( $the_query->have_posts() ) : $the_query->the_post(); 				
						$exploreimg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); 
						$video_id = get_post_meta( get_the_ID(), 'vimeo_videos_id', true );
						$vemeo_vid = get_post_meta($video_id, 'dgv_response', true );
						$vd_id = preg_replace( '/\D/', '', html_entity_decode($vemeo_vid) );
						$videoType = get_option( 'dgv_response_type_'.$vd_id );
						$teacherId = get_option('teacher_id_'.$vd_id) ;
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
					<div class="col-md-3 <?php if(empty($userid)){ echo 'openpoup'; }else{ echo ''; }  ?>" id="user_class_disablelink">
						<div class="classbox">
						<a href="<?php the_permalink(); ?>">
							<div class="classimg bgtopcentr" style="background-image: url('<?php echo $exploreimg[0]; ?>')">
								<span><?php echo $className; ?></span>
							</div></a>
							<div class="classtitle">
								<h5><a href="<?php echo get_permalink($teacherId); ?>"><?php echo $teachername;?></a></h5>					
							</div>
							<div class="classmeta">
								<ul class="d-flex">
									<li class="d-flex align-items-center"><i class="fa fa-eye"></i> <?php echo $plays; ?></li>									
								</ul>						
							</div>
							<div class="classsubtitle">
								<h5><a href="<?php the_permalink();?>"><?php the_title();?></a></h5>
							</div>
							<div class="classsdesc">
								<?php echo wp_trim_words( get_the_content(), 30, '[...]' ); ?> <a class="morelink" href="<?php the_permalink(); ?>">Read more</a>
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
<script>

var explrclasses = $( "#user_class_disablelink" ).hasClass( "openpoup" );
if(explrclasses === true){
	
	//$('#mainsite a').bind("click.myDisable", function() { return false; });
	$('#user_class_disablelink a').attr("href", 'javascript:void(0)');
	
}





var MainNav = function (domNode) {
  this.rootNode = domNode;
  this.triggerNodes = [];
  this.controlledNodes = [];
  this.openIndex = null;
  this.useArrowKeys = true;
};

MainNav.prototype.init = function () {
  var buttons = this.rootNode.querySelectorAll('button[aria-expanded][aria-controls]');
  for (var i = 0; i < buttons.length; i++) {
    var button = buttons[i];
    var menu = button.parentNode.querySelector('ul');
    if (menu) {
      // save ref to button and controlled menu
      this.triggerNodes.push(button);
      this.controlledNodes.push(menu);

      // collapse menus
      button.setAttribute('aria-expanded', 'false');
      this.toggleMenu(menu, false);

      // attach event listeners
      menu.addEventListener('keydown', this.handleMenuKeyDown.bind(this));
      button.addEventListener('click', this.handleButtonClick.bind(this));
      button.addEventListener('keydown', this.handleButtonKeyDown.bind(this));
    }
  }

  this.rootNode.addEventListener('focusout', this.handleBlur.bind(this));
};

MainNav.prototype.toggleMenu = function (domNode, show) {
  if (domNode) {
    domNode.style.display = show ? 'block' : 'none';
  }
};

MainNav.prototype.toggleExpand = function (index, expanded) {
  // close open menu, if applicable
  if (this.openIndex !== index) {
    this.toggleExpand(this.openIndex, false);
  }

  // handle menu at called index
  if (this.triggerNodes[index]) {
    this.openIndex = expanded ? index : null;
    this.triggerNodes[index].setAttribute('aria-expanded', expanded);
    this.toggleMenu(this.controlledNodes[index], expanded);
  }
};

MainNav.prototype.controlFocusByKey = function (keyboardEvent, nodeList, currentIndex) {
  switch (keyboardEvent.key) {
    case 'ArrowUp':
    case 'ArrowLeft':
      keyboardEvent.preventDefault();
      if (currentIndex > -1) {
        var prevIndex = Math.max(0, currentIndex - 1);
        nodeList[prevIndex].focus();
      }
      break;
    case 'ArrowDown':
    case 'ArrowRight':
      keyboardEvent.preventDefault();
      if (currentIndex > -1) {
        var nextIndex = Math.min(nodeList.length - 1, currentIndex + 1);
        nodeList[nextIndex].focus();
      }
      break;
    case 'Home':
      keyboardEvent.preventDefault();
      nodeList[0].focus();
      break;
    case 'End':
      keyboardEvent.preventDefault();
      nodeList[nodeList.length - 1].focus();
      break;
  }
};

/* Event Handlers */
MainNav.prototype.handleBlur = function (event) {
  var menuContainsFocus = this.rootNode.contains(event.relatedTarget);
  if (!menuContainsFocus && this.openIndex !== null) {
    this.toggleExpand(this.openIndex, false);
  }
};

MainNav.prototype.handleButtonKeyDown = function (event) {
  var targetButtonIndex = this.triggerNodes.indexOf(document.activeElement);

  // close on escape
  if (event.key === 'Escape') {
    this.toggleExpand(this.openIndex, false);
  }

  // move focus into the open menu if the current menu is open
  else if (this.useArrowKeys && this.openIndex === targetButtonIndex && event.key === 'ArrowDown') {
    event.preventDefault();
    this.controlledNodes[this.openIndex].querySelector('a').focus();
  }

  // handle arrow key navigation between top-level buttons, if set
  else if (this.useArrowKeys) {
    this.controlFocusByKey(event, this.triggerNodes, targetButtonIndex);
  }
};

MainNav.prototype.handleButtonClick = function (event) {
  var button = event.target;
  var buttonIndex = this.triggerNodes.indexOf(button);
  var buttonExpanded = button.getAttribute('aria-expanded') === 'true';
  this.toggleExpand(buttonIndex, !buttonExpanded);
};

MainNav.prototype.handleMenuKeyDown = function (event) {
  if (this.openIndex === null) {
    return;
  }

  var menuLinks = Array.prototype.slice.call(this.controlledNodes[this.openIndex].querySelectorAll('a'));
  var currentIndex = menuLinks.indexOf(document.activeElement);

  // close on escape
  if (event.key === 'Escape') {
    this.triggerNodes[this.openIndex].focus();
    this.toggleExpand(this.openIndex, false);
  }

  // handle arrow key navigation within menu links, if set
  else if (this.useArrowKeys) {
    this.controlFocusByKey(event, menuLinks, currentIndex);
  }
};

// switch on/off arrow key navigation
MainNav.prototype.updateKeyControls = function (useArrowKeys) {
  this.useArrowKeys = useArrowKeys;
};

/* Initialize Main Menus */

window.addEventListener('load', function (event) {
  var menus = document.querySelectorAll('.mainnav');
  var mainMenus = [];

  for (var i = 0; i < menus.length; i++) {
    mainMenus[i] = new MainNav(menus[i]);
    mainMenus[i].init();
  }

  // listen to arrow key checkbox
  var arrowKeySwitch = document.getElementById('arrow-behavior-switch');
  arrowKeySwitch.addEventListener('change', function (event) {
    var checked = arrowKeySwitch.checked;
    for (var i = 0; i < mainMenus.length; i++) {
      mainMenus[i].updateKeyControls(checked);
    }
  });

  // fake link behavior
  var links = document.querySelectorAll('[href="#mythical-page-content"]');
  var examplePageHeading = document.getElementById('mythical-page-heading');
  for (var i = 0; i < links.length; i++) {
    links[i].addEventListener('click', function (event) {
      var pageTitle = event.target.innerText;
      examplePageHeading.innerText = pageTitle;

      // handle aria-current
      for (var n = 0; n < links.length; n++) {
        links[n].removeAttribute('aria-current');
      }
      this.setAttribute('aria-current', 'page');
    });
  }
}, false);


/*****************************************************************************************************/
var filterparams = [];

var countdiv = $('.explrclasses .row .col-md-3').length;
$('.count_result .resultcount').text(countdiv);
filterparams.push({
					'duration':''
				});
filterparams.push({
					'age':''
				});
filterparams.push({
					'type':''
				});
var childUrl = $('.childUrl').val();
var controllerPath = childUrl+'/ajaxController.php';
$('.exploretab-right .mainnav .filter_dropdown button').click(function(){
	$('.filter_dropdown').removeClass('active');
	$(this).parents('.filter_dropdown').addClass('active');
	
});
function callajax(filterparams, controllerPath){

	// console.log('filterparams',filterparams);
	// console.log('controllerPath',controllerPath);
	
	$.ajax({
          type:"post",
          url:controllerPath,
          data:{type:'filter_class',filterparams:filterparams},
          success:function(res){
			  $('.explrclasses .row').html(res);
           // console.log(res);
          var countdiv = $('.explrclasses .row .col-md-3').length;
			$('.count_result .resultcount').text(countdiv);
          }
        });
		
	
}
$('#id-brand-menu li').click(function(){
	//alert(controllerPath);
	$('#id-brand-menu li').removeClass('active');
	$(this).addClass('active');
	var duration_select = $('#id-brand-menu li.active a').text();
	$('.selected_value_duration').text(duration_select);  
	var i;
	for (i = 0; i < filterparams.length; i++) {		
		 if ('duration' in filterparams[i]){			
				 filterparams[i].duration = duration_select;
				 break;
			}
		}
callajax(filterparams,controllerPath);	
});
$('#id-style-menu li').click(function(){
	$('#id-style-menu li').removeClass('active');
	$(this).addClass('active');
	var age_select = $('#id-style-menu li.active a').text();
	$('.selected_value_age').text(age_select);	
	var j;
	for (j = 0; j < filterparams.length; j++) {
	 if ('age' in filterparams[j]){				 
			 filterparams[j].age = age_select;
			  break;
		}
	}
callajax(filterparams,controllerPath);
});
$('#id-components-menu li').click(function(){
	$('#id-components-menu li').removeClass('active');
	$(this).addClass('active');
	var type_select = $('#id-components-menu li.active a').text();
	$('.selected_value_type').text(type_select);	
var k;
	for (k = 0; k < filterparams.length; k++) {
		 if ('type' in filterparams[k]){			
				 filterparams[k].type = type_select;
				 break; 
			}
		}
callajax(filterparams,controllerPath);	
});


</script>
<style>
.mainnav {
  background-color: #ffffff;
  display: flex;
  list-style-type: none;
  padding: 0;
}

.mainnav ul {
  border-radius: 0 0 4px 4px;
  display: block;
  list-style-type: none;
  margin: 0;
  min-width: 200px;
  padding: 0;
  position: absolute;
}

.mainnav li {
  margin: 0;
}

.mainnav ul a {
  border: 0;
  color: #000;
  display: block;
  margin: 0;
  padding: 0.5em 1em;
  text-decoration: underline;
}

.mainnav ul a:hover,
.mainnav ul a:focus {
  background-color: #ddd;
  margin-bottom: 0;
  text-decoration: none;
}

.mainnav ul a:focus {
  outline: 5px solid rgba(0, 90, 156, 0.75);
  position: relative;
}

.mainnav button {
  align-items: center;
  border: 1px solid transparent;
  border-right-color: #ccc;
  display: flex;
  padding: 1em;
}

.mainnav button::after {
  content: "";
  border-bottom: 1px solid #000;
  border-right: 1px solid #000;
  height: 0.5em;
  margin-left: 0.75em;
  width: 0.5em;
  transform: rotate(45deg);
}

.mainnav button:focus {
  border-color: #005a9c;
  outline: 5px solid rgba(0, 90, 156, 0.75);
  position: relative;
}

.mainnav button:hover,
.mainnav button[aria-expanded="true"] {
  background-color: #005a9c;
  color: #fff;
}

.mainnav button:hover::after,
.mainnav button[aria-expanded="true"]::after {
  border-color: #fff;
}


</style>
<?php get_footer();
