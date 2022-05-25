<?php

/**
 * This is nothing more than an alias for the Mageewp_Field_Select class.
 * In older versions of Mageewp there was a separate 'select2' field.
 * This exists here just for compatibility purposes.
 */
class Mageewp_Field_Select2_Multiple extends Mageewp_Field_Select {

	/**
	 * Sets the $multiple
	 *
	 * @access protected
	 */
	protected function set_multiple() {

		$this->multiple = 999;

	}
}
