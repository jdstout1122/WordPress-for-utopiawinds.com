<?php

/**
 * The Mageewp_Modules class.
 */
class Mageewp_Modules {

	/**
	 * An array of available modules.
	 *
	 * @static
	 * @access private
	 * @var array
	 */
	private static $modules = array();

	/**
	 * An array of active modules (objects).
	 *
	 * @static
	 * @access private
	 * @var array
	 */
	private static $active_modules = array();

	/**
	 * Constructor.
	 *
	 * @access public
	 */
	public function __construct() {

		$this->default_modules();
		$this->init();

	}

	/**
	 * Set the default modules and apply the 'options-framework/modules' filter.
	 *
	 * @access private
	 */
	private function default_modules() {

		self::$modules = apply_filters( 'options-framework/modules', array(
			'css'                => 'Mageewp_Modules_CSS',
			'customizer-styling' => 'Mageewp_Modules_Customizer_Styling',
			'icons'              => 'Mageewp_Modules_Icons',
			// 'loading'            => 'Mageewp_Modules_Loading',
			'reset'              => 'Mageewp_Modules_Reset',
			'tooltips'           => 'Mageewp_Modules_Tooltips',
			'branding'           => 'Mageewp_Modules_Customizer_Branding',
			'postMessage'        => 'Mageewp_Modules_PostMessage',
			'selective-refresh'  => 'Mageewp_Modules_Selective_Refresh',
			'field-dependencies' => 'Mageewp_Modules_Field_Dependencies',
			'custom-sections'    => 'Mageewp_Modules_Custom_Sections',
			// 'collapsible'        => 'Mageewp_Modules_Collapsible',
			// 'resize'             => 'Mageewp_Modules_Resize',
			'webfonts'           => 'Mageewp_Modules_Webfonts',
		) );

	}

	/**
	 * Instantiates the modules.
	 *
	 * @access private
	 */
	private function init() {

		foreach ( self::$modules as $key => $module_class ) {
			if ( class_exists( $module_class ) ) {
				// Use this syntax instead of $module_class::get_instance()
				// for PHP 5.2 compatibility.
				self::$active_modules[ $key ] = call_user_func( array( $module_class, 'get_instance' ) );
			}
		}
	}

	/**
	 * Add a module.
	 *
	 * @static
	 * @access public
	 * @param string $module The classname of the module to add.
	 */
	public static function add_module( $module ) {

		if ( ! in_array( $module, self::$modules, true ) ) {
			self::$modules[] = $module;
		}

	}

	/**
	 * Remove a module.
	 *
	 * @static
	 * @access public
	 * @param string $module The classname of the module to add.
	 */
	public static function remove_module( $module ) {

		$key = array_search( $module, self::$modules, true );
		if ( false !== $key ) {
			unset( self::$modules[ $key ] );
		}
	}

	/**
	 * Get the modules array.
	 *
	 * @static
	 * @access public
	 * @return array
	 */
	public static function get_modules() {

		return self::$modules;

	}

	/**
	 * Get the array of active modules (objects).
	 *
	 * @static
	 * @access public
	 * @return array
	 */
	public static function get_active_modules() {

		return self::$active_modules;

	}
}
