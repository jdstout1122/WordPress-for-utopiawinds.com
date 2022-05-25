<?php

// @codingStandardsIgnoreFile

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'mageewp_get_option' ) ) {
	/**
	 * Get the value of a field.
	 * This is a deprecated function that we in use when there was no API.
	 * Please use the Mageewp::get_option() method instead.
	 * Documentation is available for the new method on https://github.com/aristath/options-framework/wiki/Getting-the-values
	 *
	 * @return mixed
	 */
	function mageewp_get_option( $option = '' ) {
		return Mageewp::get_option( '', $option );
	}
}

if ( ! function_exists( 'mageewp_sanitize_hex' ) ) {
	function mageewp_sanitize_hex( $color ) {
		return Mageewp_Color::sanitize_hex( $color );
	}
}

if ( ! function_exists( 'mageewp_get_rgb' ) ) {
	function mageewp_get_rgb( $hex, $implode = false ) {
		return Mageewp_Color::get_rgb( $hex, $implode );
	}
}

if ( ! function_exists( 'mageewp_get_rgba' ) ) {
	function mageewp_get_rgba( $hex = '#fff', $opacity = 100 ) {
		return Mageewp_Color::get_rgba( $hex, $opacity );
	}
}

if ( ! function_exists( 'mageewp_get_brightness' ) ) {
	function mageewp_get_brightness( $hex ) {
		return Mageewp_Color::get_brightness( $hex );
	}
}

/**
 * Class was deprecated in 2.2.7
 *
 * @see https://github.com/aristath/options-framework/commit/101805fd689fa8828920b789347f13efc378b4a7
 */
if ( ! class_exists( 'Mageewp_Colourlovers' ) ) {
	/**
	 * Deprecated.
	 */
	class Mageewp_Colourlovers {
		public static function get_palettes( $palettes_nr = 5 ) {
			return array();
		}
	}
}
