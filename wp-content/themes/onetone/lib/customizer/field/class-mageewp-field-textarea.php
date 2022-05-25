<?php

/**
 * Field overrides.
 */
class Mageewp_Field_Textarea extends Mageewp_Field_Mageewp_Generic {

	/**
	 * Sets the $choices
	 *
	 * @access protected
	 */
	protected function set_choices() {

		if ( ! is_array( $this->choices ) ) {
			$this->choices = array();
		}
		$this->choices['element'] = 'textarea';
		$this->choices['rows']    = '5';

	}
}
