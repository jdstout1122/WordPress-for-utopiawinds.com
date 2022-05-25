<?php

/**
 * Field overrides.
 */
class Mageewp_Field_Palette extends Mageewp_Field_Radio {

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 */
	protected function set_type() {

		$this->type = 'mageewp-palette';

	}
}
