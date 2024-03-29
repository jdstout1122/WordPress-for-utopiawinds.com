<?php

/**
 * Field overrides.
 */
class Mageewp_Field_Checkbox extends Mageewp_Field {

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 */
	protected function set_type() {

		$this->type = 'checkbox';

	}

	/**
	 * Sets the $sanitize_callback.
	 *
	 * @access protected
	 */
	protected function set_sanitize_callback() {

		if ( ! $this->sanitize_callback ) {
			$this->sanitize_callback = array( $this, 'sanitize' );
		}

	}

	/**
	 * Sanitizes checkbox values.
	 *
	 * @access public
	 * @param boolean|integer|string|null $value The checkbox value.
	 * @return bool
	 */
	public function sanitize( $value = null ) {

		if ( '0' === $value || 0 === $value || 'false' === $value ) {
			return 0;
		} elseif ( '1' === $value || 1 === $value || 'true' === $value ) {
			return 1;
		}

		return (bool) $value;

	}

	/**
	 * Sets the default value.
	 *
	 * @access protected
	 */
	protected function set_default() {

		$this->default = ( 1 === $this->default || '1' === $this->default || true === $this->default || 'true' === $this->default || 'on' === $this->default );

	}
}
