<?php
/**
 * Initialize Mageewp
 */
class Mageewp_Init {

	/**
	 * Control types.
	 *
	 * @access private
	 * @var array
	 */
	private $control_types = array();

	/**
	 * The class constructor.
	 */
	public function __construct() {

		$this->set_url();
		add_action( 'after_setup_theme', array( $this, 'set_url' ) );
		add_action( 'wp_loaded', array( $this, 'add_to_customizer' ), 1 );
		add_filter( 'options-framework/control_types', array( $this, 'default_control_types' ) );

		new Mageewp_Custom_Build();
	}

	/**
	 * Properly set the Mageewp URL for assets.
	 * Determines if Hoo is installed as a plugin, in a child theme, or a parent theme
	 * and then does some calculations to get the proper URL for its CSS & JS assets.
	 */
	public function set_url() {

		Mageewp::$path = wp_normalize_path( dirname( MAGEEWP_OF_FILE ) );

		// Works in most cases.
		// Serves as a fallback in case all other checks fail.
		if ( defined( 'WP_CONTENT_DIR' ) ) {
			$content_dir = wp_normalize_path( WP_CONTENT_DIR );
			if ( false !== strpos( Mageewp::$path, $content_dir ) ) {
				$relative_path = str_replace( $content_dir, '', Mageewp::$path );
				Mageewp::$url = content_url( $relative_path );
			}
		}


		// Get the path to the theme.
		$theme_path = wp_normalize_path( get_template_directory() );

		//Mageewp Hoo included in the theme?
		if ( false !== strpos( Mageewp::$path, $theme_path ) ) {
			Mageewp::$url = get_template_directory_uri() . str_replace( $theme_path, '', Mageewp::$path );
		}

		// Is there a child-theme?
		$child_theme_path = wp_normalize_path( get_stylesheet_directory_uri() );
		if ( $child_theme_path !== $theme_path ) {
			// Is Mageewp included in a child theme?
			if ( false !== strpos( Mageewp::$path, $child_theme_path ) ) {
				Mageewp::$url = get_template_directory_uri() . str_replace( $child_theme_path, '', Mageewp::$path );
			}
		}

		// Apply the options-framework/config filter.
		$config = apply_filters( 'options-framework/config', array() );
		if ( isset( $config['url_path'] ) ) {
			Mageewp::$url = $config['url_path'];
		}

		// Escapes the URL.
		Mageewp::$url = esc_url_raw( Mageewp::$url );
		// Make sure the right protocol is used.
		Mageewp::$url = set_url_scheme( Mageewp::$url );
	}

	/**
	 * Add the default Mageewp control types.
	 *
	 * @access public
	 * @param array $control_types The control types array.
	 * @return array
	 */
	public function default_control_types( $control_types = array() ) {

		$this->control_types = array(
			'checkbox'              => 'WP_Customize_Control',
			'mageewp-background'      => 'Mageewp_Control_Background',
			'mageewp-code'            => 'Mageewp_Control_Code',
			'mageewp-color'           => 'Mageewp_Control_Color',
			'mageewp-color-palette'   => 'Mageewp_Control_Color_Palette',
			'mageewp-custom'          => 'Mageewp_Control_Custom',
			'mageewp-date'            => 'Mageewp_Control_Date',
			'mageewp-dashicons'       => 'Mageewp_Control_Dashicons',
			'mageewp-dimension'       => 'Mageewp_Control_Dimension',
			'mageewp-dimensions'      => 'Mageewp_Control_Dimensions',
			'mageewp-editor'          => 'Mageewp_Control_Editor',
			'mageewp-fontawesome'     => 'Mageewp_Control_FontAwesome',
			'mageewp-gradient'        => 'Mageewp_Control_Gradient',
			'mageewp-image'           => 'Mageewp_Control_Image',
			'mageewp-multicolor'      => 'Mageewp_Control_Multicolor',
			'mageewp-multicheck'      => 'Mageewp_Control_MultiCheck',
			'mageewp-number'          => 'Mageewp_Control_Number',
			'mageewp-palette'         => 'Mageewp_Control_Palette',
			'mageewp-preset'          => 'Mageewp_Control_Preset',
			'mageewp-radio'           => 'Mageewp_Control_Radio',
			'mageewp-radio-buttonset' => 'Mageewp_Control_Radio_ButtonSet',
			'mageewp-radio-image'     => 'Mageewp_Control_Radio_Image',
			'repeater'              => 'Mageewp_Control_Repeater',
			'mageewp-select'          => 'Mageewp_Control_Select',
			'mageewp-slider'          => 'Mageewp_Control_Slider',
			'mageewp-sortable'        => 'Mageewp_Control_Sortable',
			'mageewp-spacing'         => 'Mageewp_Control_Dimensions',
			'mageewp-switch'          => 'Mageewp_Control_Switch',
			'mageewp-generic'         => 'Mageewp_Control_Generic',
			'mageewp-toggle'          => 'Mageewp_Control_Toggle',
			'mageewp-typography'      => 'Mageewp_Control_Typography',
			'image'                 => 'Mageewp_Control_Image',
			'cropped_image'         => 'WP_Customize_Cropped_Image_Control',
			'upload'                => 'WP_Customize_Upload_Control',
		);
		return array_merge( $control_types, $this->control_types );

	}

	/**
	 * Helper function that adds the fields, sections and panels to the customizer.
	 *
	 * @return void
	 */
	public function add_to_customizer() {
		$this->fields_from_filters();
		add_action( 'customize_register', array( $this, 'register_control_types' ) );
		add_action( 'customize_register', array( $this, 'add_panels' ), 97 );
		add_action( 'customize_register', array( $this, 'add_sections' ), 98 );
		add_action( 'customize_register', array( $this, 'add_fields' ), 99 );
	}

	/**
	 * Register control types
	 *
	 * @return  void
	 */
	public function register_control_types() {
		global $wp_customize;

		$section_types = apply_filters( 'options-framework/section_types', array() );
		foreach ( $section_types as $section_type ) {
			$wp_customize->register_section_type( $section_type );
		}
		if ( empty( $this->control_types ) ) {
			$this->control_types = $this->default_control_types();
		}
		$do_not_register_control_types = apply_filters( 'options-framework/control_types/exclude', array(
			'Mageewp_Control_Repeater',
		) );
		foreach ( $this->control_types as $control_type ) {
			if ( 0 === strpos( $control_type, 'Mageewp' ) && ! in_array( $control_type, $do_not_register_control_types, true ) && class_exists( $control_type ) ) {
				$wp_customize->register_control_type( $control_type );
			}
		}
	}

	/**
	 * Register our panels to the WordPress Customizer.
	 *
	 * @access public
	 */
	public function add_panels() {
		if ( ! empty( Mageewp::$panels ) ) {
			foreach ( Mageewp::$panels as $panel_args ) {
				// Extra checks for nested panels.
				if ( isset( $panel_args['panel'] ) ) {
					if ( isset( Mageewp::$panels[ $panel_args['panel'] ] ) ) {
						// Set the type to nested.
						$panel_args['type'] = 'mageewp-nested';
					}
				}

				new Mageewp_Panel( $panel_args );
			}
		}
	}

	/**
	 * Register our sections to the WordPress Customizer.
	 *
	 * @var	object	The WordPress Customizer object
	 * @return  void
	 */
	public function add_sections() {
		if ( ! empty( Mageewp::$sections ) ) {
			foreach ( Mageewp::$sections as $section_args ) {
				// Extra checks for nested sections.
				if ( isset( $section_args['section'] ) ) {
					if ( isset( Mageewp::$sections[ $section_args['section'] ] ) ) {
						// Set the type to nested.
						$section_args['type'] = 'mageewp-nested';
						// We need to check if the parent section is nested inside a panel.
						$parent_section = Mageewp::$sections[ $section_args['section'] ];
						if ( isset( $parent_section['panel'] ) ) {
							$section_args['panel'] = $parent_section['panel'];
						}
					}
				}
				new Mageewp_Section( $section_args );
			}
		}
	}

	/**
	 * Create the settings and controls from the $fields array and register them.
	 *
	 * @var	object	The WordPress Customizer object
	 * @return  void
	 */
	public function add_fields() {

		global $wp_customize;
		foreach ( Mageewp::$fields as $args ) {

			// Create the settings.
			new Mageewp_Settings( $args );

			// Check if we're on the customizer.
			// If we are, then we will create the controls, add the scripts needed for the customizer
			// and any other tweaks that this field may require.
			if ( $wp_customize ) {

				// Create the control.
				new Mageewp_Control( $args );

			}
		}
	}

	/**
	 * Process fields added using the 'options-framework/fields' and 'options-framework/controls' filter.
	 * These filters are no longer used, this is simply for backwards-compatibility.
	 *
	 * @access private
	 */
	private function fields_from_filters() {

		$fields = apply_filters( 'options-framework/controls', array() );
		$fields = apply_filters( 'options-framework/fields', $fields );

		if ( ! empty( $fields ) ) {
			foreach ( $fields as $field ) {
				Mageewp::add_field( 'global', $field );
			}
		}
	}


	/**
	 * Alias for the get_variables static method in the Mageewp_Util class.
	 * This is here for backwards-compatibility purposes.
	 *
	 * @static
	 * @access public
	 * @return array Formatted as array( 'variable-name' => value ).
	 */
	public static function get_variables() {
		// Log error for developers.
		// @codingStandardsIgnoreLine
		error_log( 'We detected you\'re using Mageewp_Init::get_variables(). Please use Mageewp_Util::get_variables() instead. This message was added in Hoo 3.0.9.' );
		// Return result using the Mageewp_Util class.
		return Mageewp_Util::get_variables();
	}

}
