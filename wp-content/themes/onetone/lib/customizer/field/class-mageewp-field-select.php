<?php

/**
 * Field overrides.
 */
class Mageewp_Field_Select extends Mageewp_Field {

	/**
	 * Use only on select controls.
	 * Defines if this is a multi-select or not.
	 * If value is > 1, then the maximum number of selectable options
	 * is the number defined here.
	 *
	 * @access protected
	 * @var integer
	 */
	protected $multiple = 1;

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 */
	protected function set_type() {

		$this->type = 'mageewp-select';

	}

	/**
	 * Sets the $multiple
	 *
	 * @access protected
	 */
	protected function set_multiple() {

		$this->multiple = absint( $this->multiple );

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
		$this->sanitize_callback = array( $this, 'sanitize' );

	}

	/**
	 * Sanitizes select control values.
	 *
	 * @access public
	 * @param array $value The value.
	 * @return string|array
	 */
	public function sanitize( $value ) {
		return $value;
		if ( is_array( $value ) ) {
			foreach ( $value as $key => $subvalue ) {
				if ( '' !== $subvalue || isset( $this->choices[''] ) ) {
					$key = sanitize_key( $key );
					$value[ $key ] = esc_attr( $subvalue );
				}
			}
			return $value;
		}
		return esc_attr( $value );

	}

	/**
	 * Sets the default value.
	 *
	 * @access protected
	 */
	protected function set_default() {

		if ( 1 < $this->multiple && ! is_array( $this->default ) ) {
			$this->default = array( $this->default );
		}
	}
}
