<?php

/**
 * Output overrides.
 */
class Mageewp_Output_Field_Typography extends Mageewp_Output {

	/**
	 * Processes a single item from the `output` array.
	 *
	 * @access protected
	 * @param array $output The `output` item.
	 * @param array $value  The field's value.
	 */
	protected function process_output( $output, $value ) {

		$output['media_query'] = ( isset( $output['media_query'] ) ) ? $output['media_query'] : 'global';
		$output['element']     = ( isset( $output['element'] ) ) ? $output['element'] : 'body';
		$output['prefix']      = ( isset( $output['prefix'] ) ) ? $output['prefix'] : '';
		$output['suffix']      = ( isset( $output['suffix'] ) ) ? $output['suffix'] : '';

		$value = Mageewp_Field_Typography::sanitize( $value );

		$properties = array(
			'font-family',
			'font-size',
			'font-weight',
			'font-style',
			'letter-spacing',
			'word-spacing',
			'line-height',
			'text-align',
			'text-transform',
			'color',
		);

		foreach ( $properties as $property ) {
			if ( ! isset( $value[ $property ] ) || ! $value[ $property ] ) {
				continue;
			}
			if ( isset( $output['choice'] ) && $output['choice'] !== $property ) {
				continue;
			}

			$property_value = $this->process_property_value( $property, $value[ $property ] );
			if ( 'font-family' === $property ) {
				$value['font-backup'] = ( isset( $value['font-backup'] ) ) ? $value['font-backup'] : '';
				$property_value = $this->process_property_value( $property, array(
					$value['font-family'],
					$value['font-backup'],
				) );
			}
			$property_value = ( is_array( $property_value ) && isset( $property_value[0] ) ) ? $property_value[0] : $property_value;
			$this->styles[ $output['media_query'] ][ $output['element'] ][ $property ] = $output['prefix'] . $property_value . $output['suffix'];
		}
	}
}
