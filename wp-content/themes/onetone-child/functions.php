<?php

add_action( 'wp_enqueue_scripts', 'enqueue_child_theme_styles', PHP_INT_MAX);
function enqueue_child_theme_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
    wp_enqueue_style( 'child-style', get_stylesheet_uri(), array('parent-style')  );
}

function display_custom_post_type(){
        $args = array(
            'post_type' => 'song',
            'post_status' => 'publish'
        );

        $string = '';
        $query = new WP_Query( $args );
        if( $query->have_posts() ){
            $string .= '<div>';
            while( $query->have_posts() ){
                $query->the_post();
                $string .= '<p>' . get_the_content() . '</p>';
            }
            $string .= '</div>';
        }
        wp_reset_query();
        return $string;
    }

add_shortcode( 'repertoire', 'display_custom_post_type' );

// Custom sort by rating
function my_custom_sort( $query ) {

    if ( $query->is_archive())
    {
    	$query->set('meta_key', 'composer');
		$query->set('orderby', 'meta_value title');
    	$query->set('order', 'ASC');
    }
	return $query;
}
add_action('pre_get_posts', 'my_custom_sort');


function custom_posts_per_page( $query ) {
    if ( $query->is_archive() && $query->is_main_query() ) {
        $query->set( 'posts_per_page', '-1' );
    }
}
add_action( 'pre_get_posts', 'custom_posts_per_page' );

?>