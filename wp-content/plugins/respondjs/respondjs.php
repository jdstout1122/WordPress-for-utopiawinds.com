<?php
/*
Plugin Name: Respond.js
Plugin URI: http://www.ramoonus.nl/wordpress/respondjs/
Description: Respond.js is a fast and lightweight polyfill for min/max-width CSS3 Media Queries (for IE 6-8, and more).
Version: 1.4.2
Author: Ramoonus
Author URI: http://www.ramoonus.nl/
*/

function rw_respondjs() {
		wp_deregister_script('respondjs'); // deregister
		wp_enqueue_script('respondjs', plugins_url('/js/respond.min.js', __FILE__), false, '1.4.2', false); // re register // false for not in footer
}
add_action('wp_enqueue_scripts', 'rw_respondjs');
?>