<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The "custom" control allows you to add any raw HTML.
 */
class Mageewp_Control_Custom extends WP_Customize_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'mageewp-custom';

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @see WP_Customize_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();
		$this->json['value'] = $this->value();
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
		<label>
			<# if ( data.label ) { #><span class="customize-control-title">{{{ data.label }}}</span><# } #>
			<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
			<?php
				/**
				 * The value is defined by the developer in the field configuration as 'default'.
				 * There is no user input on this field, it's a raw HTML/JS field and we do not sanitize it.
				 * Do not be alarmed, this is not a security issue.
				 * In order for someone to be able to change this they would have to have access to your filesystem.
				 * If that happens, they can change whatever they want anyways. This field is not a concern.
				 */
			?>
			{{{ data.value }}}
		</label>
		<?php

	}
}
