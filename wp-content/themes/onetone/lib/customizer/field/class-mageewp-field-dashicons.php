<?php

/**
 * Field overrides.
 */
class Mageewp_Field_Dashicons extends Mageewp_Field {

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 */
	protected function set_type() {

		$this->type = 'mageewp-dashicons';

	}

	/**
	 * Sets the $sanitize_callback
	 *
	 * @access protected
	 */
	protected function set_sanitize_callback() {

		// If a custom sanitize_callback has been defined,
		// then we don't need to proceed any further.
		if ( ! empty( $this->sanitize_callback ) ) {
			return;
		}
		// Custom fields don't actually save any value.
		// just use __return_true.
		$this->sanitize_callback = 'esc_attr';

	}
}
