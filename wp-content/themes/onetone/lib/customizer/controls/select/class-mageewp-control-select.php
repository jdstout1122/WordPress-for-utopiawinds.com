<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Select control.
 */
class Mageewp_Control_Select extends WP_Customize_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'mageewp-select';

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
	 * Maximum number of options the user will be able to select.
	 * Set to 1 for single-select.
	 *
	 * @access public
	 * @var int
	 */
	public $multiple = 1;

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

		if ( ! class_exists( 'Mageewp_Custom_Build' ) || ! Mageewp_Custom_Build::is_custom_build() ) {
			wp_enqueue_script( 'mageewp-select', trailingslashit( Mageewp::$url ) . 'controls/select/select.js', array( 'jquery', 'customize-base', 'select2', 'jquery-ui-sortable' ), false, true );
			wp_enqueue_style( 'mageewp-select-css', trailingslashit( Mageewp::$url ) . 'controls/select/select.css', null );
		}
		wp_enqueue_script( 'select2', trailingslashit( Mageewp::$url ) . 'assets/vendor/select2/js/select2.full.js', array( 'jquery' ), '4.0.3', true );
		wp_enqueue_style( 'select2', trailingslashit( Mageewp::$url ) . 'assets/vendor/select2/css/select2.css', array(), '4.0.3' );
		wp_enqueue_style( 'mageewp-select2', trailingslashit( Mageewp::$url ) . 'assets/vendor/select2/mageewp.css', null );
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

		$this->json['multiple'] = $this->multiple;
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
		<# if ( ! data.choices ) {
			return;
		}
		if ( 1 < data.multiple && data.value && _.isString( data.value ) ) {
			data.value = [ data.value ];
		}
		#>
		<label>
			<# if ( data.label ) { #><span class="customize-control-title">{{ data.label }}</span><# } #>
			<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
			<select {{{ data.inputAttrs }}} {{{ data.link }}}<# if ( 1 < data.multiple ) { #> data-multiple="{{ data.multiple }}" multiple="multiple"<# } #>>
				<# _.each( data.choices, function( optionLabel, optionKey ) { #>
					<# selected = ( data.value === optionKey ); #>
					<# if ( 1 < data.multiple && data.value ) { #>
						<# selected = _.contains( data.value, optionKey ); #>
					<# } #>
					<# if ( _.isObject( optionLabel ) ) { #>
						<optgroup label="{{ optionLabel[0] }}">
							<# _.each( optionLabel[1], function( optgroupOptionLabel, optgroupOptionKey ) { #>
								<# selected = ( data.value === optgroupOptionKey ); #>
								<# if ( 1 < data.multiple && data.value ) { #>
									<# selected = _.contains( data.value, optgroupOptionKey ); #>
								<# } #>
								<option value="{{ optgroupOptionKey }}"<# if ( selected ) { #> selected <# } #>>{{ optgroupOptionLabel }}</option>
							<# }); #>
						</optgroup>
					<# } else { #>
						<option value="{{ optionKey }}"<# if ( selected ) { #> selected <# } #>>{{ optionLabel }}</option>
					<# } #>
				<# }); #>
			</select>
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
