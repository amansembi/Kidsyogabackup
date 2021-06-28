<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

function wpb_custom_new_menu() {
  register_nav_menu('my-custom-menu',__( 'User Login Main Menu' ));
  register_nav_menu('left-after-user-menu',__( 'left after user menu' ));
}
add_action( 'init', 'wpb_custom_new_menu' );

function my_function_admin_bar(){
	$current_user = wp_get_current_user();
	
	if( $current_user->roles[0] == 'administrator' ){
		
		 return false;
	}
   
}
add_filter( 'show_admin_bar' , 'my_function_admin_bar');
         
if ( !function_exists( 'child_theme_configurator_css' ) ):
    function child_theme_configurator_css() {
    	wp_enqueue_style( 'bootstrap-css', trailingslashit( get_stylesheet_directory_uri() ) . 'css/bootstrap.min.css', array());
        wp_enqueue_style( 'chld_thm_cfg_child', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array( 'twenty-twenty-one-style','twenty-twenty-one-style','twenty-twenty-one-print-style' ));        
        wp_enqueue_style( 'webfonts', trailingslashit( get_stylesheet_directory_uri() ) . 'webfonts/stylesheet.css', array());
        wp_enqueue_style( 'select2-min', trailingslashit( get_stylesheet_directory_uri() ) . 'webfonts/select2.min.css', array());
        wp_enqueue_style( 'font-awesome', trailingslashit( get_stylesheet_directory_uri() ) . 'webfonts/font-awesome.min.css', array());
		wp_enqueue_style( 'slick-css', trailingslashit( get_stylesheet_directory_uri() ) . 'css/slick.css', array());
		wp_enqueue_style( 'customcssfile-css', trailingslashit( get_stylesheet_directory_uri() ) . 'css/customcssfile.css', array());
		wp_enqueue_script( 'jquery-js', trailingslashit( get_stylesheet_directory_uri() ) . 'js/jquery.min.js', array());
		wp_enqueue_script( 'bootstrap-js', trailingslashit( get_stylesheet_directory_uri() ) . 'js/bootstrap.min.js', array());		
		wp_enqueue_script( 'slick-js', trailingslashit( get_stylesheet_directory_uri() ) . 'js/slick.min.js', array());			
		
        wp_enqueue_script( 'custom-js', trailingslashit( get_stylesheet_directory_uri() ) . 'js/custom.js', array());
        wp_enqueue_script( 'checkout-js', trailingslashit( get_stylesheet_directory_uri() ) . 'js/checkout.js', array());
        wp_enqueue_script( 'select2-min-js', trailingslashit( get_stylesheet_directory_uri() ) . 'js/select2.min.js', array());
        //wp_enqueue_script( 'jquery-vimeo-api-min-js', trailingslashit( get_stylesheet_directory_uri() ) . 'Vimeo-jQuery-API-master/dist/jquery.vimeo.api.min.js', array());
    } 
endif;
add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css', 10 );

function admin_style_sheet_added() {
    wp_enqueue_style('admin-styles-custom', get_theme_file_uri().'/admincustom.css');
}
add_action('admin_enqueue_scripts', 'admin_style_sheet_added');

// END ENQUEUE PARENT ACTION


// Register sidebars
register_sidebar( array(
    'name'          => __( 'Footer 1', 'textdomain' ),
    'id'            => 'footer-1',
    'description'   => __( 'Footer 1', 'textdomain' ),
    'before_widget' => '<div id="%1$s" class="widsec %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h4>',
    'after_title'   => '</h4>',
));
register_sidebar( array(
    'name'          => __( 'Footer 2', 'textdomain' ),
    'id'            => 'footer-2',
    'description'   => __( 'Footer 2', 'textdomain' ),
    'before_widget' => '<div id="%1$s" class="widsec %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h4>',
    'after_title'   => '</h4>',
));

// Classes Custom Post
function our_classes() {
    $labels = array(
        'name'                => _x( 'Classes', 'Post Type General Name', 'twenty-twenty-one-style' ),
        'singular_name'       => _x( 'Classes', 'Post Type Singular Name', 'twenty-twenty-one-style' ),
        'menu_name'           => __( 'Classes', 'twenty-twenty-one-style' ),
        'parent_item_colon'   => __( 'Parent Classes', 'twenty-twenty-one-style' ),
        'all_items'           => __( 'All Classes', 'twenty-twenty-one-style' ),
        'view_item'           => __( 'View Classes', 'twenty-twenty-one-style' ),
        'add_new_item'        => __( 'Add New Class', 'twenty-twenty-one-style' ),
        'add_new'             => __( 'Add New', 'twenty-twenty-one-style' ),
        'edit_item'           => __( 'Edit Class', 'twenty-twenty-one-style' ),
        'update_item'         => __( 'Update Class', 'twenty-twenty-one-style' ),
        'search_items'        => __( 'Search Class', 'twenty-twenty-one-style' ),
        'not_found'           => __( 'Not Found', 'twenty-twenty-one-style' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'twenty-twenty-one-style' ),
    );

    // Portfolio Post Option
    $args = array(
        'label'               => __( 'Class', 'twenty-twenty-one-style' ),
        'description'         => __( 'Class', 'twenty-twenty-one-style' ),
        'labels'              => $labels,       
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'tag', 'revisions', 'custom-fields', ),       
        'taxonomies'          => array( 'genres' ),        
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );
     
    // Register Post
    register_post_type( 'classes', $args ); 
}
add_action( 'init', 'our_classes', 0 );

// Classes Categories
function classes_taxonomies() {
  $labels = array(
    'name'              => _x( 'Classes', 'taxonomy general name' ),
    'singular_name'     => _x( 'Category', 'taxonomy singular name' ),
    'search_items'      => __( 'Search Classes Categories' ),
    'all_items'         => __( 'All Class Categories' ),
    'parent_item'       => __( 'Parent Class Category' ),
    'parent_item_colon' => __( 'Parent Class Category:' ),
    'edit_item'         => __( 'Edit Class Category' ), 
    'update_item'       => __( 'Update Class Category' ),
    'add_new_item'      => __( 'Add New Class Category' ),
    'new_item_name'     => __( 'New Class Category' ),
    'menu_name'         => __( 'Categories' ),
  );
  $args = array(
    'labels' => $labels,
    'hierarchical' => true,
  );
  register_taxonomy( 'classes_category', 'classes', $args );
}
add_action( 'init', 'classes_taxonomies', 0 );

// Classes Shortcode
add_shortcode('CLASSES', 'get_our_classes');
        function get_our_classes()
        {
        ob_start();?>
        <div class="container">                        
            <div class="portfolio"> 
                <div class="row">
                    <?php 
                        $args = array( 'post_type' => 'classes', 'posts_per_page' => 100 );
                        $the_query = new WP_Query( $args ); 
                    ?>                          
                    <?php if ( $the_query->have_posts() ) : ?>                          
                    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>                      
                    <div class="col-md-4 col-sm-4 portboxpad"> 
                        <div class="portbox">
                            <?php $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); ?>
                            <a href="<?php the_permalink();?>"><div class="portimg" style="background-image: url('<?php echo $backgroundImg[0]; ?>')">
                                <div class="portinfo">
                                    <div class="portbar">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                    <h4><?php the_title();?></h4>                               
                                </div>
                            </div></a>
                        </div>                                      
                    </div>              
                    <?php endwhile; ?>
                       <?php wp_reset_postdata(); ?>
                    <?php else:  ?>
                    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
                    <?php endif; ?>                             
                </div>  
            </div>                           
            <?php
            return $htmldata = ob_get_clean();
        }

// Classes category shortcode
function register_classes_shortcodes() {
    add_shortcode( 'CLASSES', 'shortcode_mostra_classes' );
}
add_action( 'init', 'register_classes_shortcodes' );
function shortcode_mostra_classes ( $atts ) {
  $atts = shortcode_atts( array(
    'category' => '',
    
  ), $atts );
    $terms = get_terms('classes_category');
    wp_reset_query();
    $args = array('post_type' => 'classes', 'orderby' => 'meta_value', 'order' => 'DESC',
      'tax_query' => array(
        array(
          'taxonomy' => 'classes_category', 
          'field' => 'slug',
          'terms' => $atts,
        ),
      ),
     );

     $loop = new WP_Query($args);
     if($loop->have_posts()) {
        while($loop->have_posts()) : $loop->the_post();?>           
        
        <div><a href="<?php the_permalink();?>"><?php the_title(); ?></a></div>
            <?php the_post_thumbnail(); ?>
            <?php the_excerpt(); ?>
     <?php       
        endwhile;
     }
}

// Classes categories shortcode
add_shortcode('CLASSES_CATEGORIES', 'get_classes_categories');
function get_classes_categories(){
    ob_start();?>
    <?php $taxonomy = 'classes_category';
        $terms = get_terms($taxonomy); // Get all terms of a taxonomy
        if ( $terms && !is_wp_error( $terms ) ) :
    ?>
    <div class="clsctgry">
        <div class="row">
            <?php foreach ($terms as $term) { ?>
				
			<?php  $terms = get_the_terms( get_the_ID(), 'classes_category' );
				$catimg = get_field('class_category_image', $term); ?>
				
                <div class="col-md-3">
                    <div class="clsctgrybox">
                        <a href="<?php echo site_url().'/explore?term='.$term->term_id; ?>">
                            <div class="clsctgryimg bgcentr" style="background-image: url('<?php echo esc_url($catimg['url']); ?>')"></div>
                        </a>
                        <div class="clsctgrytitle pt20">
                            <h5 class="text-uppercase"><a href="<?php echo get_term_link($term->slug, $taxonomy); ?>"><?php echo $term->name; ?> <i class=" fa fa-angle-right"></i></a></h5>
                        </div>                    
                        <div class="clsctgrydesc">
                            <?php echo $term->description; ?>    
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php endif;?>
<?php return $htmldata = ob_get_clean();  }

// Instructor custom post
function yoga_instructors() {
    $labels = array(
        'name'                => _x( 'Instructor', 'Post Type General Name', 'twenty-twenty-one-style' ),
        'singular_name'       => _x( 'Instructor', 'Post Type Singular Name', 'twenty-twenty-one-style' ),
        'menu_name'           => __( 'Instructor', 'twenty-twenty-one-style' ),
        'parent_item_colon'   => __( 'Parent Instructor', 'twenty-twenty-one-style' ),
        'all_items'           => __( 'All Instructor', 'twenty-twenty-one-style' ),
        'view_item'           => __( 'View Instructor', 'twenty-twenty-one-style' ),
        'add_new_item'        => __( 'Add New Instructor', 'twenty-twenty-one-style' ),
        'add_new'             => __( 'Add New', 'Avada' ),
        'edit_item'           => __( 'Edit Instructor', 'twenty-twenty-one-style' ),
        'update_item'         => __( 'Update Instructor', 'twenty-twenty-one-style' ),
        'search_items'        => __( 'Search Instructor', 'twenty-twenty-one-style' ),
        'not_found'           => __( 'Not Found', 'twenty-twenty-one-style' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'twenty-twenty-one-style' ),
    );

    // Instructor custom post
    $args = array(
        'label'               => __( 'Instructor', 'twenty-twenty-one-style' ),
        'description'         => __( 'Instructor', 'twenty-twenty-one-style' ),
        'labels'              => $labels,       
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),       
        'taxonomies'          => array( 'genres' ),        
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );     
    // Register Post
    register_post_type( 'instructor', $args ); 
}
add_action( 'init', 'yoga_instructors', 0 );

// Instructor Categories
function instructor_taxonomies() {
  $labels = array(
    'name'              => _x( 'Instructor Categories', 'taxonomy general name' ),
    'singular_name'     => _x( 'Instructor Category', 'taxonomy singular name' ),
    'search_items'      => __( 'Search Instructor Categories' ),
    'all_items'         => __( 'All Instructor Categories' ),
    'parent_item'       => __( 'Parent Instructor Category' ),
    'parent_item_colon' => __( 'Parent Instructor Category:' ),
    'edit_item'         => __( 'Edit Instructor Category' ), 
    'update_item'       => __( 'Update Instructor Category' ),
    'add_new_item'      => __( 'Add New Instructor Category' ),
    'new_item_name'     => __( 'New Instructor Category' ),
    'menu_name'         => __( 'Instructor Categories' ),
  );
  $args = array(
    'labels' => $labels,
    'hierarchical' => true,
  );
  register_taxonomy( 'instructor_category', 'instructor', $args );
}
add_action( 'init', 'instructor_taxonomies', 0 );

// Instructor Categories
function classes_instructor() {
  $labels = array(
    'name'              => _x( 'Classes Instructor', 'taxonomy general name' ),
    'singular_name'     => _x( 'Classes Instructor', 'taxonomy singular name' ),
    'search_items'      => __( 'Search Classes Instructor' ),
    'all_items'         => __( 'All Classes Instructor' ),
    'parent_item'       => __( 'Parent Classes Instructor' ),
    'parent_item_colon' => __( 'Parent Classes Instructor' ),
    'edit_item'         => __( 'Edit Classes Instructor' ), 
    'update_item'       => __( 'Update Classes Instructor' ),
    'add_new_item'      => __( 'Add New Classes Instructor' ),
    'new_item_name'     => __( 'New Classes Instructor' ),
    'menu_name'         => __( 'Classes Instructor' ),
  );
  $args = array(
    'labels' => $labels,
    'hierarchical' => true,
  );
  register_taxonomy( 'classes_instructor', 'classes', $args );
}
add_action( 'init', 'classes_instructor', 0 );

// Instructor shortcode
add_shortcode('INSTRUCTORS', 'get_our_instructor');
        function get_our_instructor()
        {
        ob_start();?>		
			
		<div class="expertswrap posrel">
            <div class="experts">                 
                    <?php 
                        $args = array( 'post_type' => 'instructor', 'posts_per_page' => -1 );
                        $the_query = new WP_Query( $args ); 
                    ?>                          
                    <?php if ( $the_query->have_posts() ) : ?>                          
                    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); 
						$expertimg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); 
					?>
                    <div class="expertbox">                            
                    	<a href="<?php the_permalink();?>">
							<div class="expertimg bgcentr" style="background-image: url('<?php echo $expertimg[0]; ?>')"></div>
						</a>
						<a href="<?php the_permalink();?>">
                        	<div class="expertinfo">                           
                            	<h5><?php the_title();?></h5>
								<h6><?php the_field('sub_title')?></h6>
                            </div>   	
						</a>
                    </div>                                                          
                    <?php endwhile; ?>
                       <?php wp_reset_postdata(); ?>
                    <?php else:  ?>
                    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
                    <?php endif; ?> 
            </div>                  
			<div class="expertsldrbtns d-flex justify-content-center">
				<div class="prevbtn"><i class="fa fa-angle-left"></i></div>
				<div class="nextbtn"><i class="fa fa-angle-right"></i></div>	
			</div>
		</div>
                        
	    	<?php
	    	return $htmldata = ob_get_clean();
		}

		// Portfolio Category Shortcode
		function instructors_shortcodes() {
			add_shortcode( 'INSTRUCTORS_CATEGORY', 'shortcode_mostra_instructors' );
		}
		add_action( 'init', 'instructors_shortcodes' );
		function shortcode_mostra_instructors ( $atts ) {
		  $atts = shortcode_atts( array(
			'category' => '',
			
		  ), $atts );
			$terms = get_terms('instructor_category');
			wp_reset_query();
			$args = array('post_type' => 'instructor', 'orderby' => 'meta_value', 'order' => 'DESC',
			  'tax_query' => array(
				array(
				  'taxonomy' => 'instructor_category', 
				  'field' => 'slug',
				  'terms' => $atts,
				),
			  ),
			 );

			 $loop = new WP_Query($args);
			 if($loop->have_posts()) {
				while($loop->have_posts()) : $loop->the_post();?>			
					
			<div class="clsctgry">
				<div class="row">
					<?php foreach ($terms as $term) { ?>
						<div class="col-md-3">
							<div class="clsctgrybox">
								<a href="<?php echo get_term_link($term->slug, $taxonomy); ?>">
									<div class="clsctgryimg bgcentr"></div>
								</a>
								<div class="clsctgrytitle pt20">
									<h5 class="text-uppercase"><a href="<?php echo get_term_link($term->slug, $taxonomy); ?>"><?php echo $term->name; ?> <i class=" fa fa-angle-right"></i></a></h5>
								</div>                    
								<div class="clsctgrydesc">
									<?php echo $term->description; ?>    
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>	
				
			 <?php       
				endwhile;
			 }
		}

// disable for posts
add_filter('use_block_editor_for_post', '__return_false', 10);

// disable for post types
add_filter('use_block_editor_for_post_type', '__return_false', 10);







// Our custom post type function
function create_posttype() {
 
    register_post_type( 'Promotions ',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Promotions ' ),
                'singular_name' => __( 'Promotions ' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'Promotions '),
            'show_in_rest' => true,
 
        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype' );


/*
* Creating a function to create our CPT
*/
 
function custom_post_type() {
 
// Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Promotions ', 'Post Type General Name', 'twentytwenty' ),
        'singular_name'       => _x( 'Promotions ', 'Post Type Singular Name', 'twentytwenty' ),
        'menu_name'           => __( 'Promotions ', 'twentytwenty' ),
        'parent_item_colon'   => __( 'Parent Movie', 'twentytwenty' ),
        'all_items'           => __( 'Promotions Baner', 'twentytwenty' ),
        'view_item'           => __( 'View Promotions', 'twentytwenty' ),
        'add_new_item'        => __( 'Add New Promotions', 'twentytwenty' ),
        'add_new'             => __( 'Add New', 'twentytwenty' ),
        'edit_item'           => __( 'Promotions Movie', 'twentytwenty' ),
        'update_item'         => __( 'Update Promotions', 'twentytwenty' ),
        'search_items'        => __( 'Search Promotions', 'twentytwenty' ),
        'not_found'           => __( 'Not Found', 'twentytwenty' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'twentytwenty' ),
    );
     
// Set other options for Custom Post Type
     
    $args = array(
        'label'               => __( 'Promotions', 'twentytwenty' ),
        'description'         => __( 'Promotions', 'twentytwenty' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array( 'genres' ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */ 
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest' => true,
 
    );
     
    // Registering your Custom Post Type
    register_post_type( 'Promotions', $args );
 
}
 
/* Hook into the 'init' action so that the function
* Containing our post type registration is not 
* unnecessarily executed. 
*/
 
add_action( 'init', 'custom_post_type', 0 );
/*
Ajax for Add fevrate videos

*/
add_action( 'wp_enqueue_scripts', 'my_enqueue' );
function my_enqueue() {
    wp_enqueue_script( 'ajax-script', get_template_directory_uri() . '/js/my-ajax-script.js', array('jquery') );
    wp_localize_script( 'ajax-script', 'my_ajax_object',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
	
	add_action("wp_ajax_my_user_vote", "my_user_vote");
	add_action("wp_ajax_nopriv_my_user_vote", "my_user_vote");

function my_user_vote() {	
	$userLikedVedio = array();
	$likedByUser = array();
	$post_video_id    = $_POST['post_video_id'];
	$video_id    = $_POST['video_id'];	
	$current_user = get_current_user_id();
	$user_liked_vedio = get_user_meta( $current_user, 'user_liked_vedio' , true );
	$liked_by_user = get_post_meta( $post_video_id, 'liked_by_user', true );	
		if(!is_array($user_liked_vedio) || $user_liked_vedio == ''){
			$user_liked_vedio = array();	
		}
		if(in_array($video_id,$user_liked_vedio)){
			unset($user_liked_vedio[$video_id]);
			$favrate_vid_status = 0;			
		}else{
			$user_liked_vedio[$video_id] = $video_id;
			$favrate_vid_status = 1;			
		}			
		update_user_meta( $current_user, 'user_liked_vedio', $user_liked_vedio);

		
		if(!is_array($liked_by_user) || $liked_by_user == ''){		
			$liked_by_user = array();	
		}
		if(in_array($current_user,$liked_by_user)){
			unset($liked_by_user[$current_user]);
			$favrate_vid_status = 0;
		}else{
			$liked_by_user[$current_user] = $current_user;
			$favrate_vid_status = 1;
		}						
		update_post_meta( $post_video_id, 'liked_by_user', $liked_by_user);		
		echo $favrate_vid_status;
	
	
	
	
	
	
	
	
	exit();
}

function callback($buffer) {
    // You can modify $buffer here, and then return the updated code
    return $buffer;
}
// function buffer_start() { ob_start("callback"); }
// function buffer_end() { ob_end_flush(); }
//Add hooks for output buffering
// add_action('init', 'buffer_start');
// add_action('wp_footer', 'buffer_end');


/* Logout check */
function users_last_login() { 
    update_user_meta( $userinfo->ID, 'user_status', '0' );
    session_start();  
}
add_action('clear_auth_cookie', 'users_last_login', 10);




add_action("wp_ajax_check_promo_code", "check_promo_code");
	add_action("wp_ajax_nopriv_check_promo_code", "check_promo_code");

function check_promo_code() {	
    session_start();  
	$status    = $_POST['trialtime'];	
	$promoCode    = $_POST['promoCode'];
	$loggedin_user    = $_POST['loggedin_user'];
	$rate    = $_POST['rate'];	
	$todaydate = date("Ymd");
	$args = array( 'post_type' => 'promotions', 'posts_per_page' => -1 );
	$the_query = new WP_Query( $args );	

		if ( $the_query->have_posts() ) :                          
		  while ( $the_query->have_posts()) : $the_query->the_post(); 

			$exploreimg = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' ); 
			$promotion_coupon_code = get_post_meta( get_the_ID(), 'promotion_coupon_code', true );
			$promotion_expiry_date = get_post_meta( get_the_ID(), 'promotion_expiry_date', true );
			$percentage_off = get_post_meta( get_the_ID(), 'percentage_off', true );
			$free_trial = get_post_meta( get_the_ID(), 'free_trial', true );
			$total_coupon_codes = get_post_meta( get_the_ID(), 'total_coupon_codes', true );
        if($promoCode == ''){
		   $selling_price  =  $rate;
           $_SESSION["selling_price"] = $selling_price;
           $_SESSION["status"] = $status;
		   echo $selling_price; die;
		}elseif($promoCode == $promotion_coupon_code ){							
			$start_date = date_create($promotion_expiry_date); 
			$end_date   = date_create($todaydate);
			$diff = date_diff($start_date,$end_date);
			$finaldays = $diff->format("%a");

			if($finaldays > 0 && $total_coupon_codes > 0){
				$selling_price = $rate - ($rate * ($percentage_off / 100)); 
				$total_coupon_codes = $total_coupon_codes - 1;
				update_post_meta( get_the_ID(), 'total_coupon_codes', $total_coupon_codes );
				update_user_meta($loggedin_user,'used_coupon_code',$promotion_coupon_code);
				update_user_meta($loggedin_user,'used_coupon_id',get_the_ID());
				update_user_meta($loggedin_user,'user_select_price',$rate);
				update_user_meta($loggedin_user,'user_get_discount',$selling_price);
                $_SESSION["selling_price"] = $selling_price;
                $_SESSION["status"] = $status;
				echo $selling_price;             
				
			}else{
				echo 'expire';
			}							
			}				
		  endwhile;
		endif;
	exit;
}


add_shortcode("GIFT_CARDS","get_product_details");
function get_product_details() {
global $wpdb;

$args = array( 'post_type' => 'plans','post_status' => 'publish', 'posts_per_page' => 10, 'orderby' => 'date', 'order' => 'ASC');
					$loop = new WP_Query( $args );
					while ( $loop->have_posts() ) : $loop->the_post();
					$price = get_post_meta( get_the_ID(), 'price', true );
						$valid = get_post_meta( get_the_ID(), 'valid', true );
						//print_r($valid);
						$title = get_the_title();
						$priceData .= '<li class="d-flex justify-content-center align-items-center">                           
                                    <input type="radio" name="carAmount" for="'.$valid.'"  value="'.$price.'">
                                    <label>1 '.$valid.'. $'.$price.'</label>
                                </li>';
				endwhile;							
				 $today = date('Y-m-d');
				 $custom_cart_details = $wpdb->get_results("SELECT * FROM wp_custom_cart_details");
				 
				 echo '<div class="giftsldrwrap posrel"><div class="giftsldr ptb60">';
                  foreach ($custom_cart_details as $key => $value) {
                     $expr = strtotime($value->ending_date); 
                     $today =  strtotime($today); 
                      if($expr >= $today){
                        $card_id =  $value->id;
                        $title =   $value->title;
                        $image =  $value->image;
                        $card_code =  $value->card_code;
                        $starting_date =   $value->starting_date; 
                        $ending_date =   $value->ending_date;
                        $count  = $value->count;
                        $status = $value->status;
				
                        echo '<div class="giftboxitem">
                                 <div class="giftbox giftbox1 bgltpink d-flex justify-content-center align-items-center">
                                   <img src="'.$image.'" alt="Gift Image">
                                    <input type="hidden" name="cartId" class="cartId" value="'.$card_id.'">  
                                    <input type="hidden" name="cardcode" class="cardcode" value="'.$card_code.'">  
                                </div>                              
                            </div>';
                    }
                }
   echo '</div>
   	     <div class="giftsldrbtns d-flex justify-content-between posabs">
			<div class="prevbtn"><i class="fa fa-angle-left"></i></div>
			<div class="nextbtn"><i class="fa fa-angle-right"></i></div>	
		</div>
		</div>
   ';
   echo '<div class="giftform pb60">
                <div class="row justify-content-center text-center">
                    <div class="col-md-6">
                        <h5>Select an amount</h5>
                        <form class="pt20">
                            <ul class="d-flex justify-content-center align-items-center pb50">
                                '.$priceData.'
                            </ul>
                            <div class="btn btnpink fontlato getCardDetails disabledcmn" >Continue To Delivery</div>
                        </form>                                             
                    </div>
                </div>      
            </div>
        </div>';


} 	

//add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');

add_action('init', 'plans');

function plans() {

    register_taxonomy(
       'plans_category', //event_type',
       'plans', //wr_event',
       array(
       
       'label' => __( 'Plans Categories' ),
			'hierarchical' => true,
           'singular_label' => 'Plans',
           'query_var' => true,
           'rewrite' => array('slug' => ''),
       )
   );

   $labels = array(
       'name' => _x('Plans', 'plans_categories'),
       'singular_name' => _x('Plans', 'plans_category')
   );

   $args = array(
       'labels' => $labels,
       'public' => true,
       'publicly_queryable' => true,
       'show_ui' => true,
       'query_var' => true,
       'capability_type' => 'post',
       'hierarchical' => false,
       'menu_position' => null,
       'supports' => array('title','editor','author','thumbnail', 'excerpt'),
       'has_archive' => 'plans'
   );

   register_post_type( 'plans' , $args );
}

	
	


add_action( 'add_meta_boxes', 'cd_meta_box_add' );
function cd_meta_box_add()
{
	
	if(get_post_type() == "classes") {
    	add_meta_box( 'my-meta-box-id', 'Select Vimeo Video for class', 'cd_meta_box_cb');
	}
	
}

function cd_meta_box_cb(){
	$args = array( 'post_type' => 'dgv-upload', 'posts_per_page' => -1 );
	$the_query = new WP_Query( $args );
	$editpostID = $_GET['post'];
	$vimeo_videos_id = get_post_meta($editpostID,'vimeo_videos_id',true);
	
		?>
		
		<select name="vimeo-videos" id="vimeo-videos">
			<option>Select Vimeo Video</option>
			<?php		
			if ( $the_query->have_posts() ) :                          
				  while ( $the_query->have_posts()) : $the_query->the_post(); 			  
				  $title = get_the_title();
				  $id = get_the_ID();
				  if ($vimeo_videos_id == $id){
				  ?>		
					 <option value="<?php echo $id; ?>" selected><?php echo $title; ?></option>		
				  <?php }else{ ?>			
					 <option value="<?php echo $id; ?>" ><?php echo $title; ?></option>		
				  <?php
				  }
				  endwhile;
			endif; ?>
		</select>
			<?php
	}


add_action('save_post','my_save_function');

function my_save_function(){
	
	$final_teacher_video = array();

	if($_POST['post_type'] == 'classes'){
		update_post_meta( $_POST['post_ID'], 'vimeo_videos_id', $_POST['vimeo-videos']);
	}
	if($_POST['post_type'] == 'instructor'){
		
		ob_start();
		$teacherId = $_POST['post_ID'];

	
   	      $fname = $_POST['acf']['field_606d58e3b5d68'];
   	      $lname = $_POST['acf']['field_606d5902b5d69'];
   	      $email = $_POST['acf']['field_606d585240c53'];
   	      $password = $_POST['acf']['field_606d587440c54'];
   	      $username = $fname .''. $lname;			 
		if (username_exists($username) == null && email_exists($email) == false) {        
        $user_id = wp_create_user($username, $password, $email);        
        $user = get_user_by('id', $user_id);      
        $user->remove_role('subscriber');        
        $user->add_role('teacher');
		
    }
	$teacherSelectVideos = $_POST['teachervideos'];
	foreach($teacherSelectVideos as $teacherSelectVideo){
		//print_r($teacherSelectVideo);
		$final_teacher_video[$teacherSelectVideo] = $teacherSelectVideo;	
		update_post_meta( $teacherId, 'teacher_video', $final_teacher_video);
	}
	
	
	ob_end_flush();
	}
	
}

function cgc_ub_action_links($actions, $user) {
	$userCanceled = get_user_meta($user->ID, 'subscription_deleted', true);
	$actions['cancel_user'] = "<a class='cancel_user_id_value' cancelUser='$userCanceled' userid='$user->ID' href='#' data-toggle='modal' data-target='#exampleModal'>" . __( 'Cancel User', 'cgc_ub' ) . "</a>";
	return $actions;
}
add_filter('user_row_actions', 'cgc_ub_action_links', 10, 2);


add_action('admin_footer', 'my_user_del_button');
function my_user_del_button() {
    $screen = get_current_screen();
    if ( $screen->id != "users" )   // Only add to users.php page
        return;
    echo '<div class="modal fade cancelpopup" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Cancel User</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
				<span class="confirm_msg"></span>
				<input type="hidden" class="userid_in_popup" value="" id="userid_in_popup">
				<input type="hidden" name="childUrl" class="childUrl" value='.get_theme_file_uri().'>
				<div class="cancel_user_responding"></div>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary cancle_the_user">Cancel</button>
			  </div>
			</div>
		  </div>
		</div>';
}
add_action('admin_footer', 'add_custom_script');
function add_custom_script() {
    $screen = get_current_screen();
    if ( $screen->id != "users" )   // Only add to users.php page
return;
$url = get_theme_file_uri();
echo '<script src="'.$url.'/js/popup.js"></script>';



}

function set_last_login($login) {
    $user = get_userdatabylogin($login);
    $curent_login_time = get_user_meta( $user->ID , 'current_login', true);
    //add or update the last login value for logged in user
    if(!empty($curent_login_time)){
        update_usermeta( $user->ID, 'last_login', $curent_login_time );
        update_usermeta( $user->ID, 'current_login', current_time('mysql') );
    }else {
        update_usermeta( $user->ID, 'current_login', current_time('mysql') );
        update_usermeta( $user->ID, 'last_login', current_time('mysql') );
    }
}
add_action('wp_login', 'set_last_login');


/***********************************************************************************/
add_action( 'add_meta_boxes', 'teacher_meta_box_add' );
function teacher_meta_box_add()
{
	
	if(get_post_type() == "instructor") {
    	add_meta_box( 'my-meta-box-id', 'Edit and add videos in instructor', 'teacher_meta_box_cb');
	}
	
}

function teacher_meta_box_cb(){
	$args = array( 'post_type' => 'dgv-upload', 'posts_per_page' => -1 );
	$the_query = new WP_Query( $args );
	$editpostID = $_GET['post'];
	$vimeo_videos_id = get_post_meta($editpostID,'teacher_video',true);
	$teacher_video_duplicate = get_post_meta($editpostID,'teacher_video_duplicate',true);
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
	//print_r($teacher_video_duplicate);
	?>
	
<select class="js-example-basic-multiple" name="teachervideos[]" multiple="multiple">
<?php		
			// if ( $the_query->have_posts() ) :                          
				  // while ( $the_query->have_posts()) : $the_query->the_post(); 			  
				  // $title = get_the_title();
				  // $id = get_the_ID();
				  // $vemeo_vid = get_post_meta($id,'dgv_response',true);
				  // $vd_id = preg_replace( '/\D/', '', html_entity_decode($vemeo_vid) );	
				  
				  
					foreach($teacher_video_duplicate as $teacher_video_duplicat){
						$videoDetail = getVimeoStats($teacher_video_duplicat);
						///print_r($videoDetail['title']);
					 if (in_array($teacher_video_duplicat, $vimeo_videos_id)){
				  ?>	
				<option value="<?php echo $teacher_video_duplicat; ?>" selected><?php echo $videoDetail['title']; ?></option>
				<?php }else{ ?>
				<option value="<?php echo $teacher_video_duplicat; ?>"><?php echo $videoDetail['title']; ?></option>					 
				<?php
					}	}			 
			//endwhile;
			//endif;
			?>
</select>
<script>
	$(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
</script>
	<?php
	}
	/***********************************************/
function new_modify_user_table( $column ) {
    $column['plan'] = 'Plan';
    $column['price'] = 'Price';
    $column['status'] = 'Status';
    $column['endat'] = 'End At';
    return $column;
}
add_filter( 'manage_users_columns', 'new_modify_user_table' );

function new_modify_user_table_row( $val, $column_name, $user_id ) {
	 global $wpdb;
	$plan_ids = $wpdb->get_results("SELECT plan_id,subscription_amount,user_id,subscription_end_at,trail_ends_at FROM wp_user_subscriptions WHERE user_id = '$user_id'");
			foreach($plan_ids as $plan_id){
				$subscriptionEndAt = $plan_id->subscription_end_at;
				$trailEndsAt = $plan_id->trail_ends_at;
				
				$userCanceled = get_user_meta($plan_id->user_id, 'subscription_deleted', true);
				if($userCanceled == ''){
						
					if($subscriptionEndAt){
					$subEndAt = $subscriptionEndAt;
					$userCanceled1 = 'Paid User';
				}else{
					$subEndAt = $trailEndsAt;
					$userCanceled1 = 'Trial period';
				}
				}else{
					$userCanceled1 = 'Canceled';
				}
				//print_r($plan_id->user_id);
				if($plan_id->plan_id == 'price_1IfIWgA5JkmCD4ai9O77pxZH'){
					$plan ='Monthly';
					$price = $plan_id->subscription_amount;
				}elseif($plan_id->plan_id == 'price_1IfIWyA5JkmCD4aiy3kFwnDY'){
					$plan ='Yearly ';
					$price = $plan_id->subscription_amount;
				}
				
			}
    switch ($column_name) {
        case 'plan' :			
			return $plan;           
        case 'price' :
            return $price;
		case 'status' :
            return $userCanceled1;
		case 'endat' :
            return $subEndAt;
        default:
    }
    return $val;
}
add_filter( 'manage_users_custom_column', 'new_modify_user_table_row', 10, 3 );





add_action( 'wp', 'redirect_non_logged_users_to_specific_page' );

function redirect_non_logged_users_to_specific_page() {

/*if ( !is_user_logged_in() &&  is_page( array( 'my-classes', 'account', 'instructors', 'explore', 'why-yoga' ) )  ) {*/
if ( !is_user_logged_in() &&  is_page( array( 'my-classes', 'account' ) )  ) {

wp_redirect( 'http://kidsyoga.securework.co/' ); 
    exit;
   }
}
function wtnerd_global_vars() {

	global $wtnerd;
	$wtnerd['loginuser'] = wp_get_current_user();
	

}
add_action( 'parse_query', 'wtnerd_global_vars' );