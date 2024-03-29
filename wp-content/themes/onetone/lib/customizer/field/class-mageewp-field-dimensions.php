<?php

/**
 * Field overrides.
 */
class Mageewp_Field_Dimensions extends Mageewp_Field {

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 */
	protected function set_type() {

		$this->type = 'mageewp-dimensions';

	}

	/**
	 * Sets the $sanitize_callback.
	 *
	 * @access protected
	 */
	protected function set_sanitize_callback() {

		// If a custom sanitize_callback has been defined,
		// then we don't need to proceed any further.
		if ( ! empty( $this->sanitize_callback ) ) {
			return;
		}
		$this->sanitize_callback = array( $this, 'sanitize' );

	}

	/**
	 * Sanitizes the value.
	 *
	 * @access public
	 * @param array $value The value.
	 * @return array
	 */
	public function sanitize( $value ) {

		// Sanitize each sub-value separately.
		foreach ( $value as $key => $sub_value ) {
			$value[ $key ] = Mageewp_Sanitize_Values::css_dimension( $sub_value );
		}
		return $value;

	}

	/**
	 * Set the choices.
	 * Adds a pseudo-element "controls" that helps with the JS API.
	 *
	 * @access protected
	 */
	protected function set_choices() {

		$this->choices['controls'] = array();
		if ( is_array( $this->default ) ) {
			foreach ( $this->default as $key => $value ) {
				$this->choices['controls'][ $key ] = true;
			}
		}
	}
}
