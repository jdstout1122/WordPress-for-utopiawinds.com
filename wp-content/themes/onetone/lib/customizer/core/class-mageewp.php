<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This class acts as an interface.
 * Developers may use this object to add configurations, fields, panels and sections.
 * You can also access all available configurations, fields, panels and sections
 * by accessing the object's static properties.
 */
class Mageewp extends Mageewp_Init {

	/**
	 * Absolute path to the Mageewp folder.
	 *
	 * @static
	 * @access public
	 * @var string
	 */
	public static $path;

	/**
	 * URL to the Mageewp folder.
	 *
	 * @static
	 * @access public
	 * @var string
	 */
	public static $url;

	/**
	 * An array containing all configurations.
	 *
	 * @static
	 * @access public
	 * @var array
	 */
	public static $config = array();

	/**
	 * An array containing all fields.
	 *
	 * @static
	 * @access public
	 * @var array
	 */
	public static $fields = array();

	/**
	 * An array containing all panels.
	 *
	 * @static
	 * @access public
	 * @var array
	 */
	public static $panels = array();

	/**
	 * An array containing all sections.
	 *
	 * @static
	 * @access public
	 * @var array
	 */
	public static $sections = array();

	/**
	 * Modules object.
	 *
	 * @access public
	 * @var object
	 */
	public $modules;

	/**
	 * Get the value of an option from the db.
	 *
	 * @static
	 * @access public
	 * @param string $config_id The ID of the configuration corresponding to this field.
	 * @param string $field_id  The field_id (defined as 'settings' in the field arguments).
	 * @return mixed The saved value of the field.
	 */
	public static function get_option( $config_id = '', $field_id = '' ) {

		return Mageewp_Values::get_value( $config_id, $field_id );

	}

	/**
	 * Sets the configuration options.
	 *
	 * @static
	 * @access public
	 * @param string $config_id The configuration ID.
	 * @param array  $args      The configuration options.
	 */
	public static function add_config( $config_id, $args = array() ) {

		$config = Mageewp_Config::get_instance( $config_id, $args );
		$config_args = $config->get_config();
		self::$config[ $config_args['id'] ] = $config_args;

	}

	/**
	 * Create a new panel.
	 *
	 * @static
	 * @access public
	 * @param string $id   The ID for this panel.
	 * @param array  $args The panel arguments.
	 */
	public static function add_panel( $id = '', $args = array() ) {

		$args['id']          = esc_attr( $id );
		$args['description'] = ( isset( $args['description'] ) ) ? esc_textarea( $args['description'] ) : '';
		$args['priority']    = ( isset( $args['priority'] ) ) ? esc_attr( $args['priority'] ) : 10;
		$args['type']        = ( isset( $args['type'] ) ) ? $args['type'] : 'default';
		$args['type']        = 'mageewp-' . $args['type'];
		if ( ! isset( $args['active_callback'] ) ) {
			$args['active_callback'] = ( isset( $args['required'] ) ) ? array( 'Mageewp_Active_Callback', 'evaluate' ) : '__return_true';
		}

		self::$panels[ $args['id'] ] = $args;

	}

	/**
	 * Create a new section.
	 *
	 * @static
	 * @access public
	 * @param string $id   The ID for this section.
	 * @param array  $args The section arguments.
	 */
	public static function add_section( $id, $args ) {

		$args['id']          = esc_attr( $id );
		$args['panel']       = ( isset( $args['panel'] ) ) ? esc_attr( $args['panel'] ) : '';
		$args['description'] = ( isset( $args['description'] ) ) ? esc_textarea( $args['description'] ) : '';
		$args['priority']    = ( isset( $args['priority'] ) ) ? esc_attr( $args['priority'] ) : 10;
		$args['type']        = ( isset( $args['type'] ) ) ? $args['type'] : 'default';
		$args['type']        = 'mageewp-' . $args['type'];
		if ( ! isset( $args['active_callback'] ) ) {
			$args['active_callback'] = ( isset( $args['required'] ) ) ? array( 'Mageewp_Active_Callback', 'evaluate' ) : '__return_true';
		}

		self::$sections[ $args['id'] ] = $args;

	}

	/**
	 * Create a new field.
	 *
	 * @static
	 * @access public
	 * @param string $config_id The configuration ID for this field.
	 * @param array  $args      The field arguments.
	 */
	public static function add_field( $config_id, $args ) {

		if ( isset( $args['type'] ) ) {
			$str = str_replace( array( '-', '_' ), ' ', $args['type'] );
			$classname = 'Mageewp_Field_' . str_replace( ' ', '_', ucwords( $str ) );
			
			if ( class_exists( $classname ) ) {
				new $classname( $config_id, $args );
				return;
			}
			if ( false !== strpos( $classname, 'Mageewp_Field_Mageewp_' ) ) {
				$classname = str_replace( 'Mageewp_Field_Mageewp_', 'Mageewp_Field_', $classname );
				if ( class_exists( $classname ) ) {
					new $classname( $config_id, $args );
					return;
				}
			}
		}

		new Mageewp_Field( $config_id, $args );

	}
}
