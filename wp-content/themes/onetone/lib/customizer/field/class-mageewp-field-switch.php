<?php

/**
 * Field overrides.
 */
class Mageewp_Field_Switch extends Mageewp_Field_Checkbox {

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 */
	protected function set_type() {

		$this->type = 'mageewp-switch';

	}

	/**
	 * Sets the control choices.
	 *
	 * @access protected
	 */
	protected function set_choices() {

		if ( ! is_array( $this->choices ) ) {
			$this->choices = array();
		}

		$l10n = array(
			'on'  => esc_attr__( 'On', 'onetone' ),
			'off' => esc_attr__( 'Off', 'onetone' ),
		);

		if ( ! isset( $this->choices['on'] ) ) {
			$this->choices['on'] = $l10n['on'];
		}

		if ( ! isset( $this->choices['off'] ) ) {
			$this->choices['off'] = $l10n['off'];
		}

		if ( ! isset( $this->choices['round'] ) ) {
			$this->choices['round'] = false;
		}

	}
}
