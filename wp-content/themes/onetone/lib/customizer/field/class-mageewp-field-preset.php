<?php

/**
 * Field overrides.
 */
class Mageewp_Field_Preset extends Mageewp_Field_Select {

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 */
	protected function set_type() {

		$this->type = 'mageewp-preset';

	}

	/**
	 * Sets the $multiple
	 *
	 * @access protected
	 */
	protected function set_multiple() {

		$this->multiple = 1;

	}
}
