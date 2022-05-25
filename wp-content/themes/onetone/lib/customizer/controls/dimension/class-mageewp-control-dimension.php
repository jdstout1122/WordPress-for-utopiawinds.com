<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * A text control with validation for CSS units.
 */
class Mageewp_Control_Dimension extends WP_Customize_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'mageewp-dimension';

	/**
	 * Used to automatically generate all CSS output.
	 *
	 * @access public
	 * @var array
	 */
	public $output = array();

	/**
	 * Data type
	 *
	 * @access public
	 * @var string
	 */
	public $option_type = 'theme_mod';

	/**
	 * The mageewp_config we're using for this control
	 *
	 * @access public
	 * @var string
	 */
	public $mageewp_config = 'global';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {

		if ( class_exists( 'Mageewp_Custom_Build' ) ) {
			Mageewp_Custom_Build::register_dependency( 'jquery' );
			Mageewp_Custom_Build::register_dependency( 'customize-base' );
		}

		$script_to_localize = 'mageewp-build';
		if ( ! class_exists( 'Mageewp_Custom_Build' ) || ! Mageewp_Custom_Build::is_custom_build() ) {
			$script_to_localize = 'mageewp-dimension';
			wp_enqueue_script( 'mageewp-dimension', trailingslashit( Mageewp::$url ) . 'controls/dimension/dimension.js', array( 'jquery', 'customize-base' ), false, true );
			wp_enqueue_style( 'mageewp-dimension-css', trailingslashit( Mageewp::$url ) . 'controls/dimension/dimension.css', null );
		}
		wp_localize_script( $script_to_localize, 'dimensionhooL10n', array(
			'invalid-value' => esc_attr__( 'Invalid Value', 'onetone' ),
		) );
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @see WP_Customize_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();

		$this->json['default'] = $this->setting->default;
		if ( isset( $this->default ) ) {
			$this->json['default'] = $this->default;
		}
		$this->json['output']  = $this->output;
		$this->json['value']   = $this->value();
		$this->json['choices'] = $this->choices;
		$this->json['link']    = $this->get_link();
		$this->json['id']      = $this->id;

		$this->json['inputAttrs'] = '';
		foreach ( $this->input_attrs as $attr => $value ) {
			$this->json['inputAttrs'] .= $attr . '="' . esc_attr( $value ) . '" ';
		}

	}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
	 *
	 * @see WP_Customize_Control::print_template()
	 *
	 * @access protected
	 */
	protected function content_template() {
		?>
		<div class="mageewp-controls-loading-spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>
		<label class="customizer-text">
			<# if ( data.label ) { #><span class="customize-control-title">{{{ data.label }}}</span><# } #>
			<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
			<div class="input-wrapper">
				<input {{{ data.inputAttrs }}} type="text" value="{{ data.value }}"/>
			</div>
		</label>
		<?php
	}
}
