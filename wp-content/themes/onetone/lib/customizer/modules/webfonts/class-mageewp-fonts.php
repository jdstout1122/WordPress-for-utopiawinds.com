<?php

/**
 * The Mageewp_Fonts object.
 */
final class Mageewp_Fonts {

	/**
	 * The mode we'll be using to add google fonts.
	 * This is a todo item, not yet functional.
	 *
	 * @static
	 * @todo
	 * @access public
	 * @var string
	 */
	public static $mode = 'link';

	/**
	 * Holds a single instance of this object.
	 *
	 * @static
	 * @access private
	 * @var null|object
	 */
	private static $instance = null;

	/**
	 * An array of our google fonts.
	 *
	 * @static
	 * @access public
	 * @var null|object
	 */
	public static $google_fonts = null;

	/**
	 * The class constructor.
	 */
	private function __construct() {}

	/**
	 * Get the one, true instance of this class.
	 * Prevents performance issues since this is only loaded once.
	 *
	 * @return object Mageewp_Fonts
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Compile font options from different sources.
	 *
	 * @return array    All available fonts.
	 */
	public static function get_all_fonts() {
		$standard_fonts = self::get_standard_fonts();
		$google_fonts   = self::get_google_fonts();

		return apply_filters( 'options-framework/fonts/all', array_merge( $standard_fonts, $google_fonts ) );
	}

	/**
	 * Return an array of standard websafe fonts.
	 *
	 * @return array    Standard websafe fonts.
	 */
	public static function get_standard_fonts() {
		$standard_fonts = array(
			'serif' => array(
				'label' => 'Serif',
				'stack' => 'Georgia,Times,"Times New Roman",serif',
			),
			'sans-serif' => array(
				'label'  => 'Sans Serif',
				'stack'  => 'Helvetica,Arial,sans-serif',
			),
			'monospace' => array(
				'label' => 'Monospace',
				'stack' => 'Monaco,"Lucida Sans Typewriter","Lucida Typewriter","Courier New",Courier,monospace',
			),
		);
		return apply_filters( 'options-framework/fonts/standard_fonts', $standard_fonts );
	}

	/**
	 * Return an array of backup fonts based on the font-category
	 *
	 * @return array
	 */
	public static function get_backup_fonts() {
		$backup_fonts = array(
			'sans-serif'  => 'Helvetica, Arial, sans-serif',
			'serif'       => 'Georgia, serif',
			'display'     => '"Comic Sans MS", cursive, sans-serif',
			'handwriting' => '"Comic Sans MS", cursive, sans-serif',
			'monospace'   => '"Lucida Console", Monaco, monospace',
		);
		return apply_filters( 'options-framework/fonts/backup_fonts', $backup_fonts );
	}

	/**
	 * Return an array of all available Google Fonts.
	 *
	 * @return array    All Google Fonts.
	 */
	public static function get_google_fonts() {

		if ( null === self::$google_fonts || empty( self::$google_fonts ) ) {

			$fonts = include_once wp_normalize_path( dirname( __FILE__ ) . '/webfonts.php' );

			$google_fonts = array();
			if ( is_array( $fonts ) ) {
				foreach ( $fonts['items'] as $font ) {
					$google_fonts[ $font['family'] ] = array(
						'label'    => $font['family'],
						'variants' => $font['variants'],
						'subsets'  => $font['subsets'],
						'category' => $font['category'],
					);
				}
			}

			self::$google_fonts = apply_filters( 'options-framework/fonts/google_fonts', $google_fonts );

		}

		return self::$google_fonts;

	}

	/**
	 * Dummy function to avoid issues with backwards-compatibility.
	 * This is not functional, but it will prevent PHP Fatal errors.
	 *
	 * @static
	 * @access public
	 */
	public static function get_google_font_uri() {}

	/**
	 * Returns an array of all available subsets.
	 *
	 * @static
	 * @access public
	 * @return array
	 */
	public static function get_google_font_subsets() {
		return array(
			'cyrillic'     => 'Cyrillic',
			'cyrillic-ext' => 'Cyrillic Extended',
			'devanagari'   => 'Devanagari',
			'greek'        => 'Greek',
			'greek-ext'    => 'Greek Extended',
			'khmer'        => 'Khmer',
			'latin'        => 'Latin',
			'latin-ext'    => 'Latin Extended',
			'vietnamese'   => 'Vietnamese',
			'hebrew'       => 'Hebrew',
			'arabic'       => 'Arabic',
			'bengali'      => 'Bengali',
			'gujarati'     => 'Gujarati',
			'tamil'        => 'Tamil',
			'telugu'       => 'Telugu',
			'thai'         => 'Thai',
		);
	}

	/**
	 * Returns an array of all available variants.
	 *
	 * @static
	 * @access public
	 * @return array
	 */
	public static function get_all_variants() {
		return array(
			'100'       => esc_attr__( 'Ultra-Light 100', 'onetone' ),
			'100light'  => esc_attr__( 'Ultra-Light 100', 'onetone' ),
			'100italic' => esc_attr__( 'Ultra-Light 100 Italic', 'onetone' ),
			'200'       => esc_attr__( 'Light 200', 'onetone' ),
			'200italic' => esc_attr__( 'Light 200 Italic', 'onetone' ),
			'300'       => esc_attr__( 'Book 300', 'onetone' ),
			'300italic' => esc_attr__( 'Book 300 Italic', 'onetone' ),
			'400'       => esc_attr__( 'Normal 400', 'onetone' ),
			'regular'   => esc_attr__( 'Normal 400', 'onetone' ),
			'italic'    => esc_attr__( 'Normal 400 Italic', 'onetone' ),
			'500'       => esc_attr__( 'Medium 500', 'onetone' ),
			'500italic' => esc_attr__( 'Medium 500 Italic', 'onetone' ),
			'600'       => esc_attr__( 'Semi-Bold 600', 'onetone' ),
			'600bold'   => esc_attr__( 'Semi-Bold 600', 'onetone' ),
			'600italic' => esc_attr__( 'Semi-Bold 600 Italic', 'onetone' ),
			'700'       => esc_attr__( 'Bold 700', 'onetone' ),
			'700italic' => esc_attr__( 'Bold 700 Italic', 'onetone' ),
			'800'       => esc_attr__( 'Extra-Bold 800', 'onetone' ),
			'800bold'   => esc_attr__( 'Extra-Bold 800', 'onetone' ),
			'800italic' => esc_attr__( 'Extra-Bold 800 Italic', 'onetone' ),
			'900'       => esc_attr__( 'Ultra-Bold 900', 'onetone' ),
			'900bold'   => esc_attr__( 'Ultra-Bold 900', 'onetone' ),
			'900italic' => esc_attr__( 'Ultra-Bold 900 Italic', 'onetone' ),
		);
	}

	/**
	 * Determine if a font-name is a valid google font or not.
	 *
	 * @static
	 * @access public
	 * @param string $fontname The name of the font we want to check.
	 * @return bool
	 */
	public static function is_google_font( $fontname ) {
		if(!empty($fontname) && is_string($fontname))
			return ( array_key_exists( $fontname, self::$google_fonts ) );
		else
			return false;
	}

	/**
	 * Gets available options for a font.
	 *
	 * @static
	 * @access public
	 * @return array
	 */
	public static function get_font_choices() {
		$fonts = self::get_all_fonts();
		$fonts_array = array();
		foreach ( $fonts as $key => $args ) {
			$fonts_array[ $key ] = $key;
		}
		return $fonts_array;
	}
}
