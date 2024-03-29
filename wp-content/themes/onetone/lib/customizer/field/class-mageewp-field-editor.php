<?php

/**
 * Field overrides.
 */
class Mageewp_Field_Editor extends Mageewp_Field {

	/**
	 * Constructor.
	 * Since editor fields only work properly if there's a single tinyMCE instance
	 * We'll be adding a global editor using the add_editor method.
	 *
	 * @access public
	 * @param string $config_id    The ID of the config we want to use.
	 *                             Defaults to "global".
	 *                             Configs are handled by the Mageewp_Config class.
	 * @param array  $args         The arguments of the field.
	 */
	public function __construct( $config_id = 'global', $args = array() ) {

		// Call the parent-class constructor.
		parent::__construct( $config_id, $args );

		// Add the editor.
		add_action( 'customize_controls_print_footer_scripts', array( __CLASS__, 'add_editor' ) );

	}

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 */
	protected function set_type() {

		$this->type = 'mageewp-editor';

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
		$this->sanitize_callback = 'wp_kses_post';

	}

	/**
	 * Adds the global textarea
	 *
	 * @static
	 * @access public
	 */
	public static function add_editor() {
		wp_enqueue_script( 'tiny_mce' );

		echo '<div id="mageewp_editor_pane" class="hide">';
		wp_editor( '', 'mageewp-editor', array(
			'_content_editor_dfw' => false,
			'drag_drop_upload'    => true,
			'tabfocus_elements'   => 'content-html,save-post',
			'editor_height'       => 200,
			'default_editor'      => 'tinymce',
			'teeny'               => true,
			'tinymce'             => array(
				'resize'             => false,
				'wp_autoresize_on'   => false,
				'add_unload_trigger' => false,
			),
		) );
		echo '</div>';
		do_action( 'admin_footer' );
		do_action( 'admin_print_footer_scripts' );
	}
}
