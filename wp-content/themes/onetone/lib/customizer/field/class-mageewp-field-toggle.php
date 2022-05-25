<?php

/**
 * Field overrides.
 */
class Mageewp_Field_Toggle extends Mageewp_Field_Checkbox {

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 */
	protected function set_type() {

		$this->type = 'mageewp-toggle';

	}
}
