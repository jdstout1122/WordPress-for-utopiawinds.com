<?php
namespace MageeShortcodes\Shortcodes;
use MageeShortcodes\Classes\Helper;
use MageeShortcodes\Classes\Utils;

class Magee_Button {

	public static $args;
    private  $id;


	/**
	 * Initiate the shortcode
	 */
	public function __construct() {
		add_filter( 'magee_attr_button-shortcode', array( $this, 'attr' ) );
        add_shortcode( 'ms_button', array( $this, 'render' ) );
	}

	/**
	 * Render the shortcode
	 * @param  array $args     Shortcode paramters
	 * @param  string $content Content between shortcode
	 * @return string          HTML output
	 */

	 
	function render( $args, $content = '') {
		
		Helper::get_style_depends(['font-awesome', 'magee-shortcodes']);
		Helper::get_script_depends(['magee-shortcodes']);

		$defaults =	Helper::set_shortcode_defaults(
			array(
				'id' =>'',
				'class' =>'',
				'style' =>'normal', //normal,dark,light,2d,3d,line,line_dark,line_light
				'link' =>'#',
				'size'		=>'middle',
				'shape' =>'',
				'shadow' =>'no',
				'block' =>'no',
				'target' =>'_blank',
				'gradient' =>'no',
				'color' => '',
				'text_color' => '',
				'icon' =>'',
				'icon_animation_type' =>'',
				'border_width'=>2,
				'is_preview' => ''
			), $args
		);
		
		extract( $defaults );
		self::$args = $defaults;
		
		$class .= ' magee-shortcode magee-btn-normal';
		$css_style = ' .magee-btn-normal,.magee-btn-normal:hover{text-decoration:none !important;}';
		$add_class = Utils::rand_str('button-');
		$class .= ' '.$add_class;
		
		if( $shape != '' )
			$class .= ' btn-'.$shape;
		$border_width = str_replace('px','', $border_width);

		if( $shadow == 'yes' )
			$class .= ' btn-text-shadow';
		
		if( $block == 'yes' )
			$class .= ' btn-block';
		
		if( $gradient == 'yes' )
			$class .= ' btn-gradient';
		
		switch( $size ) {
			case "small":
			$class .= ' btn-sm';
			break;
			case "medium":
			$class .= ' btn-md';
			break;
			case "large":
			$class .= ' btn-lg';
			break;
			case "xlarge":
			$class .= ' btn-xl';
			break;
		}
			
		switch( $style) {
			case "dark":
			$class .= ' btn-dark';
			break;
			case "light":
			$class .= ' btn-light';
			break;
			case "2d":
			$class .= ' btn-2d';
			break;
			case "3d":
			$class .= ' btn-3d';
			break;
			case "line":
			$class .= ' btn-line';
			if( is_numeric($border_width )) {
				$css_style .= 'a.'.$add_class.' {border-width:'.$border_width.'px !important;}';
			}
			break;
			case "line_dark":
			$class .= ' btn-line btn-dark';
			$css_style .= 'a.'.$add_class.' {border-width:'.$border_width.'px !important;}';
			break;
			case "line_light":
			$class .= ' btn-line btn-light';
			$css_style .= 'a.'.$add_class.' {border-width:'.$border_width.'px !important;}';
			break;
			
		}

		if( $icon !='' ) {
			$animated = '';
			if( $icon_animation_type != '' )
				$animated = 'animated infinite '.$icon_animation_type;
			if( stristr($icon,'fa-')):
				$content  = '<i class="fa '.$icon.' '.$animated.'"></i>  '.$content;
			else:
				$content = '<img class="image-instead" src="'.esc_attr($icon).'" style="padding-right:10px"/>'.$content;
			endif;

		}
		
		if( $text_color !='' ) {
			$css_style .= 'a.'.$add_class.',a.'.$add_class.':hover{color:'.$text_color.';}';
			$css_style .= 'a.'.$add_class.' {color: '.$text_color.' !important;border-color: '.$text_color.' !important;}';
		}
		
		if( $color !='' ) {
			
			switch( $style) {
				case "normal":
				case "2d":
				$css_style .= 'a.'.$add_class.' {background-color:'.$color.' !important;}';
				$css_style .= 'a.'.$add_class.':active,
				a.'.$add_class.':hover,
				a.'.$add_class.':focus
				{background-color:'.Helper::colourBrightness($color,-0.9).' !important;}';
			
				break;
				case "3d":
				$css_style .= 'a.'.$add_class.' {background-color:'.$color.';box-shadow: 0 3px 0 0 '.Helper::colourBrightness($color,-0.6).' !important;}';
				$css_style .= 'a.'.$add_class.':active,
				a.'.$add_class.':hover,
				a.'.$add_class.':focus
				{background-color:'.Helper::colourBrightness($color,-0.9).' !important;}';

				break;
				case "dark":
				case "light":
				$css_style .= 'a.'.$add_class.' {background-color:'.$color.'!important;}';
				$css_style .= 'a.'.$add_class.':active,
				a.'.$add_class.':hover,
				a.'.$add_class.':focus
				{background-color:'.Helper::colourBrightness($color,-0.9).' !important;}';
				break;
			
				case "line":
				case "line_dark":
				case "line_light":
				$css_style .= 'a.'.$add_class.':active,
				a.'.$add_class.':hover,
				a.'.$add_class.':focus
				{background-color:'.$color.' !important;}';
				
				break;
			
			}
			
		}		

		$html = sprintf( '<a href="%1$s" target="%2$s" class="%3$s" id="%4$s">%5$s</a>', esc_url($link), $target, $class, $id, do_shortcode( Helper::fix_shortcodes($content)) );
		
		if (class_exists('\Elementor\Plugin') && \Elementor\Plugin::instance()->editor->is_edit_mode() ){
			$is_preview = "1";
		}

		if ($is_preview == "1"){
			$html = sprintf( '<style type="text/css" scoped="scoped">%1$s</style>%2$s' , $css_style, $html );
		}else{
			wp_add_inline_style('magee-shortcodes', $css_style);
		}
		
		return $html;
	}

}

new Magee_Button();