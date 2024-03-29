<?php

/**
 * Field overrides.
 */
class Mageewp_Field_Radio extends Mageewp_Field {

	/**
	 * Whitelisting for backwards-compatibility.
	 *
	 * @access protected
	 * @var string
	 */
	protected $mode = '';

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 */
	protected function set_type() {

		$this->type = 'mageewp-radio';
		// Tweaks for backwards-compatibility:
		// Prior to version 0.8 radio-buttonset & radio-image were part of the radio control.
		if ( in_array( $this->mode, array( 'buttonset', 'image' ), true ) ) {
			$this->type = 'radio-' . $this->mode;
		}

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
		$this->sanitize_callback = 'esc_attr';

	}
}
