<?php
/**
 * The header.
 *
 * This is the template that displays all of the <head> section and everything up until main.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */
session_start();
$userid =   $_SESSION["userID"];
$new_user = get_userdata( $userid );

$first_name = $new_user->first_name;
$avtarUrl = get_avatar_url($userid);
$imgUrl = get_user_meta($userid,'kids_profile_image');
if(empty($imgUrl)){
	$imgUrl = $avtarUrl;
}
//print_r($imgUrl);

?>
<!doctype html>
<html <?php language_attributes(); ?> <?php twentytwentyone_the_html_classes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<header class="mainhead ptb20">
		<div class="container d-flex justify-content-between align-items-center">
			<div class="logo">
				<?php the_custom_logo(); ?>
			</div>
			<div class="mainmenu">
				<ul>
					<?php wp_nav_menu( array( 'menu' => 'Login User Menu',  'theme_location' => '__no_such_location', 'fallback_cb'    => false ) ); ?>
					<li> <?php echo '<span> Hi </span>'.''.$first_name  ?> <img src="<?php  echo $imgUrl; ?>"  style="height: 25px; width: 25px; display: inline-block;"></li>
				</ul>
			</div>
		</div>		
	</header>	