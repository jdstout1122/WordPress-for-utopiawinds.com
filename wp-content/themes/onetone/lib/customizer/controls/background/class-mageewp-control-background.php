<?php
/**
 * Adds multiple input fiels that combined make up the background control.
 */
class Mageewp_Control_Background extends WP_Customize_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'mageewp-background';

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
			Mageewp_Custom_Build::register_dependency( 'wp-color-picker' );
		}
		wp_enqueue_style( 'wp-color-picker-alpha' );
		wp_enqueue_script( 'wp-color-picker-alpha', trailingslashit( Mageewp::$url ) . 'assets/vendor/wp-color-picker-alpha/wp-color-picker-alpha.js', array( 'wp-color-picker' ), '1.2', true );

		if ( ! class_exists( 'Mageewp_Custom_Build' ) || ! Mageewp_Custom_Build::is_custom_build() ) {
			wp_enqueue_script( 'mageewp-background', trailingslashit( Mageewp::$url ) . 'controls/background/background.js', array( 'jquery', 'wp-color-picker-alpha' ) );
			wp_enqueue_style( 'mageewp-background', trailingslashit( Mageewp::$url ) . 'controls/background/background.css', null );
		}
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @access public
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
			<span class="customize-control-title">{{{ data.label }}}</span>
			<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
		</label>
		<div class="background-wrapper">

			<!-- background-color -->
			<div class="background-color">
				<h4><?php esc_attr_e( 'Background Color', 'onetone' ); ?></h4>
				<input type="text" data-default-color="{{ data.default['background-color'] }}" data-alpha="true" value="{{ data.value['background-color'] }}" class="mageewp-color-control"/>
			</div>

			<!-- background-image -->
			<div class="background-image">
				<h4><?php esc_attr_e( 'Background Image', 'onetone' ); ?></h4>
				<div class="attachment-media-view background-image-upload">
					<# if ( data.value['background-image'] ) { #>
						<div class="thumbnail thumbnail-image"><img src="{{ data.value['background-image'] }}" alt="" /></div>
					<# } else { #>
						<div class="placeholder"><?php esc_attr_e( 'No File Selected', 'onetone' ); ?></div>
					<# } #>
					<div class="actions">
						<button class="button background-image-upload-remove-button<# if ( ! data.value['background-image'] ) { #> hidden <# } #>"><?php esc_attr_e( 'Remove', 'onetone' ); ?></button>
						<button type="button" class="button background-image-upload-button"><?php esc_attr_e( 'Select File', 'onetone' ); ?></button>
					</div>
				</div>
			</div>

			<!-- background-repeat -->
			<div class="background-repeat">
				<h4><?php esc_attr_e( 'Background Repeat', 'onetone' ); ?></h4>
				<select {{{ data.inputAttrs }}}>
					<option value="no-repeat"<# if ( 'no-repeat' === data.value['background-repeat'] ) { #> selected <# } #>><?php esc_attr_e( 'No Repeat', 'onetone' ); ?></option>
					<option value="repeat-all"<# if ( 'repeat-all' === data.value['background-repeat'] ) { #> selected <# } #>><?php esc_attr_e( 'Repeat All', 'onetone' ); ?></option>
					<option value="repeat-x"<# if ( 'repeat-x' === data.value['background-repeat'] ) { #> selected <# } #>><?php esc_attr_e( 'Repeat Horizontally', 'onetone' ); ?></option>
					<option value="repeat-y"<# if ( 'repeat-y' === data.value['background-repeat'] ) { #> selected <# } #>><?php esc_attr_e( 'Repeat Vertically', 'onetone' ); ?></option>
				</select>
			</div>

			<!-- background-position -->
			<div class="background-position">
				<h4><?php esc_attr_e( 'Background Position', 'onetone' ); ?></h4>
				<select {{{ data.inputAttrs }}}>
					<option value="left top"<# if ( 'left top' === data.value['background-position'] ) { #> selected <# } #>><?php esc_attr_e( 'Left Top', 'onetone' ); ?></option>
					<option value="left center"<# if ( 'left center' === data.value['background-position'] ) { #> selected <# } #>><?php esc_attr_e( 'Left Center', 'onetone' ); ?></option>
					<option value="left bottom"<# if ( 'left bottom' === data.value['background-position'] ) { #> selected <# } #>><?php esc_attr_e( 'Left Bottom', 'onetone' ); ?></option>
					<option value="right top"<# if ( 'right top' === data.value['background-position'] ) { #> selected <# } #>><?php esc_attr_e( 'Right Top', 'onetone' ); ?></option>
					<option value="right center"<# if ( 'right center' === data.value['background-position'] ) { #> selected <# } #>><?php esc_attr_e( 'Right Center', 'onetone' ); ?></option>
					<option value="right bottom"<# if ( 'right bottom' === data.value['background-position'] ) { #> selected <# } #>><?php esc_attr_e( 'Right Bottom', 'onetone' ); ?></option>
					<option value="center top"<# if ( 'center top' === data.value['background-position'] ) { #> selected <# } #>><?php esc_attr_e( 'Center Top', 'onetone' ); ?></option>
					<option value="center center"<# if ( 'center center' === data.value['background-position'] ) { #> selected <# } #>><?php esc_attr_e( 'Center Center', 'onetone' ); ?></option>
					<option value="center bottom"<# if ( 'center bottom' === data.value['background-position'] ) { #> selected <# } #>><?php esc_attr_e( 'Center Bottom', 'onetone' ); ?></option>
				</select>
			</div>

			<!-- background-size -->
			<div class="background-size">
				<h4><?php esc_attr_e( 'Background Size', 'onetone' ); ?></h4>
				<div class="buttonset">
					<input {{{ data.inputAttrs }}} class="switch-input screen-reader-text" type="radio" value="cover" name="_customize-bg-{{{ data.id }}}-size" id="{{ data.id }}cover" <# if ( 'cover' === data.value['background-size'] ) { #> checked="checked" <# } #>>
						<label class="switch-label switch-label-<# if ( 'cover' === data.value['background-size'] ) { #>on <# } else { #>off<# } #>" for="{{ data.id }}cover"><?php esc_attr_e( 'Cover', 'onetone' ); ?></label>
					</input>
					<input {{{ data.inputAttrs }}} class="switch-input screen-reader-text" type="radio" value="contain" name="_customize-bg-{{{ data.id }}}-size" id="{{ data.id }}contain" <# if ( 'contain' === data.value['background-size'] ) { #> checked="checked" <# } #>>
						<label class="switch-label switch-label-<# if ( 'contain' === data.value['background-size'] ) { #>on <# } else { #>off<# } #>" for="{{ data.id }}contain"><?php esc_attr_e( 'Contain', 'onetone' ); ?></label>
					</input>
					<input {{{ data.inputAttrs }}} class="switch-input screen-reader-text" type="radio" value="auto" name="_customize-bg-{{{ data.id }}}-size" id="{{ data.id }}auto" <# if ( 'auto' === data.value['background-size'] ) { #> checked="checked" <# } #>>
						<label class="switch-label switch-label-<# if ( 'auto' === data.value['background-size'] ) { #>on <# } else { #>off<# } #>" for="{{ data.id }}auto"><?php esc_attr_e( 'Auto', 'onetone' ); ?></label>
					</input>
				</div>
			</div>

			<!-- background-attachment -->
			<div class="background-attachment">
				<h4><?php esc_attr_e( 'Background Attachment', 'onetone' ); ?></h4>
				<div class="buttonset">
					<input {{{ data.inputAttrs }}} class="switch-input screen-reader-text" type="radio" value="scroll" name="_customize-bg-{{{ data.id }}}-attachment" id="{{ data.id }}scroll" <# if ( 'scroll' === data.value['background-attachment'] ) { #> checked="checked" <# } #>>
						<label class="switch-label switch-label-<# if ( 'scroll' === data.value['background-attachment'] ) { #>on <# } else { #>off<# } #>" for="{{ data.id }}scroll"><?php esc_attr_e( 'Scroll', 'onetone' ); ?></label>
					</input>
					<input {{{ data.inputAttrs }}} class="switch-input screen-reader-text" type="radio" value="fixed" name="_customize-bg-{{{ data.id }}}-attachment" id="{{ data.id }}fixed" <# if ( 'fixed' === data.value['background-attachment'] ) { #> checked="checked" <# } #>>
						<label class="switch-label switch-label-<# if ( 'fixed' === data.value['background-attachment'] ) { #>on <# } else { #>off<# } #>" for="{{ data.id }}fixed"><?php esc_attr_e( 'Fixed', 'onetone' ); ?></label>
					</input>
				</div>
			</div>
			<# valueJSON = JSON.stringify( data.value ).replace( /'/g, '&#39' ); #>
			<input class="background-hidden-value" type="hidden" value='{{{ valueJSON }}}' {{{ data.link }}}>
		<?php
	}
}
