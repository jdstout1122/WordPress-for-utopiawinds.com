<?php
namespace MageeShortcodes\Shortcodes;
use MageeShortcodes\Classes\Helper;

class Magee_Dummy_Image {

	public static $args;
    private  $id;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {
        add_shortcode( 'ms_dummy_image', array( $this, 'render' ) );
	}

	/**
	 * Render the shortcode
	 * @param  array $args     Shortcode paramters
	 * @param  string $content Content between shortcode
	 * @return string          HTML output
	 */
	function render( $args, $content = '') {

		$defaults =	Helper::set_shortcode_defaults(
			array(
				'style' 				=>'',
				'class' 				=>'',
				'id' 				    =>'',
				'width'          		=>'',
				'height'                =>''
			), $args
		);
		
		extract( $defaults );
		self::$args = $defaults;
		$class .= ' magee-shortcode magee-dummy-image';
		
		if($style == 'any')
			$style = rand(0, 10) ;
			
		$link = '//lorempixel.com/' .esc_attr($width). '/' . esc_attr($height) . '/'.esc_attr($style).'/';
		$html = '<div class="'.esc_attr($class).'" id="'.esc_attr($id).'"><img src="'.$link.'" width="'.$width.'px" height="'.$height.'px"/></div>';
		return $html;

	}
	
}

new Magee_Dummy_Image();