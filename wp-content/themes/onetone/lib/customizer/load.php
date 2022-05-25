<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// No need to proceed if Mageewp already exists.
if ( class_exists( 'Mageewp' ) ) {
	return;
}

// Include the autoloader.
include_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'autoloader.php';

if ( ! defined( 'MAGEEWP_OF_FILE' ) ) {
	define( 'MAGEEWP_OF_FILE', __FILE__ );
}

if ( ! function_exists( 'Mageewp' ) ) {
	// @codingStandardsIgnoreStart
	/**
	 * Returns an instance of the Mageewp object.
	 */
	function Mageewp() {
		$mageewp = Mageewp_Toolkit::get_instance();
		return $mageewp;
	}
	// @codingStandardsIgnoreEnd

}
// Start Mageewp.
global $mageewp;
$mageewp = Mageewp();
// Instamtiate the modules.
$mageewp->modules = new Mageewp_Modules();

// Make sure the path is properly set.
Mageewp::$path = wp_normalize_path( dirname( __FILE__ ) );

if ( function_exists( 'is_link' ) && is_link( dirname( __FILE__ ) ) && function_exists( 'readlink' ) ) {
	// If the path is a symlink, get the target.
	Mageewp::$path = readlink( Mageewp::$path );
}

// Instantiate 2ndary classes.
new Mageewp();

// Include deprecated functions & methods.
include_once wp_normalize_path( dirname( __FILE__ ) . '/core/deprecated.php' );

// Include the ariColor library.
include_once wp_normalize_path( dirname( __FILE__ ) . '/lib/class-aricolor.php' );

// Add an empty config for global fields.
Mageewp::add_config( '' );

$custom_config_path = dirname( __FILE__ ) . '/custom-config.php';
$custom_config_path = wp_normalize_path( $custom_config_path );
if ( file_exists( $custom_config_path ) ) {
	include_once $custom_config_path;
}


