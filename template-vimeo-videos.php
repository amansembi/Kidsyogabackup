<?php
/* Template Name:Vimeo Videos */
?>
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
<?php // THIS TECHNIQUE WORKS, BUT IT'S NOT RECOMMENDED
    $VimeoStats = getVimeoStats(365531165); // set video ID
    $plays = $VimeoStats['stats_number_of_plays'];
    $likes = $VimeoStats['stats_number_of_likes'];
    $comments = $VimeoStats['stats_number_of_comments'];
	echo "<pre>";
	print_r($VimeoStats);
	echo "</pre>";
 


?>
<iframe src="https://player.vimeo.com/video/365531165?autoplay=1&loop=1&badge=0" width="640" height="346" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
<p><a href="https://vimeo.com/365531165">Oeil pour Oeil (2019)</a> from <a href="https://vimeo.com/studiodesaviateurs">Studio des Aviateurs</a> on <a href="https://vimeo.com">Vimeo</a>.</p>
<?php

//get_footer();