<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Select control.
 */
class Mageewp_Control_FontAwesome extends WP_Customize_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'mageewp-fontawesome';

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
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {

		if ( class_exists( 'Mageewp_Custom_Build' ) ) {
			Mageewp_Custom_Build::register_dependency( 'jquery' );
			Mageewp_Custom_Build::register_dependency( 'customize-base' );
			Mageewp_Custom_Build::register_dependency( 'select2' );
			Mageewp_Custom_Build::register_dependency( 'jquery-ui-sortable' );
		}

		$script_to_localize = 'mageewp-build';
		if ( ! class_exists( 'Mageewp_Custom_Build' ) || ! Mageewp_Custom_Build::is_custom_build() ) {
			$script_to_localize = 'mageewp-fontawesome';
			wp_enqueue_script( 'mageewp-fontawesome', trailingslashit( Mageewp::$url ) . 'controls/fontawesome/fontawesome.js', array( 'jquery', 'customize-base', 'select2', 'jquery-ui-sortable' ), false, true );
			wp_enqueue_style( 'mageewp-fontawesome-css', trailingslashit( Mageewp::$url ) . 'controls/fontawesome/fontawesome.css', null );
			wp_enqueue_style( 'mageewp-fontawesome-font-css', trailingslashit( Mageewp::$url ) . 'controls/fontawesome/font-awesome.css', null );
		}
		wp_enqueue_script( 'select2', trailingslashit( Mageewp::$url ) . 'assets/vendor/select2/js/select2.full.js', array( 'jquery' ), '4.0.3', true );
		wp_enqueue_style( 'select2', trailingslashit( Mageewp::$url ) . 'assets/vendor/select2/css/select2.css', array(), '4.0.3' );
		wp_enqueue_style( 'mageewp-select2', trailingslashit( Mageewp::$url ) . 'assets/vendor/select2/mageewp.css', null );
		ob_start();
		$json_path = wp_normalize_path( dirname( __FILE__ ) . '/fontawesome.json' );
		load_template( $json_path );
		$font_awesome_json = ob_get_clean();
		wp_localize_script( $script_to_localize, 'fontAwesomeJSON', $font_awesome_json );
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
		<label>
			<# if ( data.label ) { #><span class="customize-control-title">{{ data.label }}</span><# } #>
			<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
			<select {{{ data.inputAttrs }}} {{{ data.link }}}></select>
		</label>
		<?php
	}

	/**
	 * Render the control's content.
	 *
	 * Allows the content to be overridden without having to rewrite the wrapper in `$this::render()`.
	 *
	 * Supports basic input types `text`, `checkbox`, `textarea`, `radio`, `select` and `dropdown-pages`.
	 * Additional input types such as `email`, `url`, `number`, `hidden` and `date` are supported implicitly.
	 *
	 * Control content can alternately be rendered in JS. See WP_Customize_Control::print_template().
	 *
	 */
	protected function render_content() {}
}
