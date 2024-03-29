<?php

/**
 * The Mageewp_Modules_Reset object.
 */
class Mageewp_Modules_Reset {

	/**
	 * The object instance.
	 *
	 * @static
	 * @access private
	 * @var object
	 */
	private static $instance;

	/**
	 * Constructor.
	 *
	 * @access protected
	 */
	protected function __construct() {
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'customize_controls_enqueue_scripts' ), 20 );
	}

	/**
	 * Gets an instance of this object.
	 * Prevents duplicate instances which avoid artefacts and improves performance.
	 *
	 * @static
	 * @access public
	 * @return object
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Enqueue scripts
	 *
	 * @access public
	 */
	public function customize_controls_enqueue_scripts() {

		$translation_strings = array(
			/* translators: Icon followed by reset label. */
			'reset-with-icon' => sprintf( esc_attr__( '%s Reset', 'onetone' ), '<span class="dashicons dashicons-update"></span><span class="label">' ) . '</span>',
		);
		// Enqueue the reset script.
		wp_enqueue_script( 'mageewp-set-setting-value', trailingslashit( Mageewp::$url ) . 'modules/reset/set-setting-value.js', array( 'jquery', 'customize-base', 'customize-controls' ) );
		wp_enqueue_script( 'mageewp-reset', trailingslashit( Mageewp::$url ) . 'modules/reset/reset.js', array( 'jquery', 'customize-base', 'customize-controls', 'mageewp-set-setting-value' ) );
		wp_localize_script( 'mageewp-reset', 'hooResetButtonLabel', $translation_strings );
		wp_enqueue_style( 'mageewp-reset', trailingslashit( Mageewp::$url ) . 'modules/reset/reset.css', null );

	}
}
