<?php
namespace MageeShortcodes\Shortcodes;
use MageeShortcodes\Classes\Helper;
use MageeShortcodes\Classes\Utils;

class Magee_Counter {

	public static $args;
    private  $id;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {
        add_shortcode( 'ms_counter', array( $this, 'render' ) );
	}

	/**
	 * Render the shortcode
	 * @param  array $args     Shortcode paramters
	 * @param  string $content Content between shortcode
	 * @return string          HTML output
	 */
	function render( $args, $content = '') {

		Helper::get_style_depends(['font-awesome', 'magee-shortcodes']);
		Helper::get_script_depends(['jquery-waypoints', 'jquery-countto', 'magee-shortcodes']);

		$defaults =	Helper::set_shortcode_defaults(
			array(
				'id' =>'',
				'class' =>'',
				'box_width' => '',
				'top_icon' => '',
				'top_icon_color' =>'',
				'middle_left_icon' => '',
				'middle_left_text' =>'',
				'counter_num' =>'',
				'middle_right_text' =>'',
				'bottom_title'        =>'',
				'border' =>'0',
				'is_preview' => ''
			), $args
		);
		
		extract( $defaults );
		self::$args = $defaults;
		$status_class = $class;
		$columnclass='';
		switch($box_width)
		{
			case '1/1':
				$columnclass='col-md-12';
				break;
			case '1/2':
				$columnclass='col-md-6';
				break;
			case '1/3':
				$columnclass='col-md-4';
				break;
			case '1/4':
				$columnclass='col-md-3';
				break;
			case '1/5':
				$columnclass='col-md-1_5';
				break;
			case '1/6':
				$columnclass='col-md-2';
				break;
			case '2/3':
				$columnclass='col-md-8';
				break;
			case '2/5':
				$columnclass='col-md-2_5';
				break;
			case '3/4':
				$columnclass='col-md-9';
				break;
			case '3/5':
				$columnclass='col-md-3_5';
				break;
			case '4/5':
				$columnclass='col-md-4_5';
				break;
			case '5/6':
				$columnclass='col-md-10';
				break;
		}
		$class .= ' box-border';
		$addclass = Utils::rand_str('counter-');
		$class   .= ' '.$addclass;
		$css_style = '';
		$html = '<div class="magee-shortcode magee-counter"><div class="'.$columnclass.'">' ;
		if( $top_icon_color)
		$css_style .= '.'.$addclass.' .counter-top-icon i{color:'.$top_icon_color.'}';
		
		if( $border == '1' || $border == 'yes' ):
		$html .= '<div class="magee-counter-box '.esc_attr($class).'" id="'.esc_attr($id).'">';
		else:
		$html .= '<div class="magee-counter-box '.$addclass.' '.$status_class.'" id="'.esc_attr($id).'">';
		endif;
		if( $top_icon )
		    if( stristr($top_icon,'fa-')):
			$html .= '<div class="counter-top-icon"><i class="fa '.esc_attr($top_icon).'"></i></div>';
			else:
			$html .= '<div class="counter-top-icon"><img class="image-instead" src="'.esc_attr($top_icon).'" /></div>'; 
		    endif;   
		$html .= '<div class="counter">';
        if( $middle_left_icon )       
		    if( stristr($middle_left_icon,'fa-')):
			$html .= '<i class="fa '.esc_attr($middle_left_icon).'"></i> '; 
			else:
			$html .= '<img class="image-instead" src="'.esc_attr($middle_left_icon).'" />';
		    endif;                               
		if( $middle_left_text )
		$html .= '<span class="unit">'.esc_attr($middle_left_text).'</span>';
		if( $counter_num )
		$html .= '<span class="counter-num js-counter" data-from="0" data-to="'.absint($counter_num).'" data-speed="3000" data-refresh-interval="50"></span>';
		if( $middle_right_text )
		$html .= '<span class="unit">'.esc_attr($middle_right_text).'</span>';
		
        $html .= '</div>';                                             
                                                
        $html .= '<h3 class="counter-bottom_title">'.esc_attr($bottom_title).'</h3>';
        $html .= '</div></div></div>';

		if (class_exists('\Elementor\Plugin') && \Elementor\Plugin::instance()->editor->is_edit_mode() ){
			$this->is_preview = "1";
		}

		if ($this->is_preview == "1"){
			$html = sprintf( '<style type="text/css" scoped="scoped">%1$s</style>%2$s' ,$css_style, $html );
		}else{
			wp_add_inline_style('magee-shortcodes', $css_style);
		}

		return $html;
	} 
	
}

new Magee_Counter();