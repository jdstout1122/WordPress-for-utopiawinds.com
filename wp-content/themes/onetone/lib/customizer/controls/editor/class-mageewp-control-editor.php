<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * A TinyMCE control.
 */
class Mageewp_Control_Editor extends WP_Customize_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'mageewp-editor';

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
			$script_to_localize = 'mageewp-editor';
			wp_enqueue_script( 'mageewp-editor', trailingslashit( Mageewp::$url ) . 'controls/editor/editor.js', array( 'jquery', 'customize-base' ), false, true );
			wp_enqueue_style( 'mageewp-editor-css', trailingslashit( Mageewp::$url ) . 'controls/editor/editor.css', null );
		}
		wp_localize_script( $script_to_localize, 'editorMageewpL10n', array(
			'open-editor'   => esc_attr__( 'Open Editor', 'onetone' ),
			'close-editor'  => esc_attr__( 'Close Editor', 'onetone' ),
			'switch-editor' => esc_attr__( 'Switch Editor', 'onetone' ),
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
	 * The actual editor is added from the Mageewp_Field_Editor class.
	 * All this template contains is a button that triggers the global editor on/off
	 * and a hidden textarea element that is used to mirror save the options.
	 *
	 * @see WP_Customize_Control::print_template()
	 *
	 * @access protected
	 */
	protected function content_template() {
		?>
		<div class="mageewp-controls-loading-spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>
		<label>
			<# if ( data.label ) { #><span class="customize-control-title">{{{ data.label }}}</span><# } #>
			<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
			<div class="customize-control-content">
				<a href="#" class="button button-primary toggle-editor"></a>
				<textarea {{{ data.inputAttrs }}} class="hidden" {{{ data.link }}}>{{ data.value }}</textarea>
			</div>
		</label>
		<?php
	}
}
