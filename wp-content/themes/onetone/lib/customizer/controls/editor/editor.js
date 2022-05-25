wp.customize.controlConstructor['mageewp-editor'] = wp.customize.Control.extend({

	// When we're finished loading continue processing
	ready: function() {

		'use strict';

		var control = this;

		// Init the control.
		if ( ! _.isUndefined( window.mageewpControlLoader ) && _.isFunction( mageewpControlLoader ) ) {
			mageewpControlLoader( control );
		} else {
			control.initMageewpControl();
		}
	},

	initMageewpControl: function() {

		'use strict';

		var control      = this,
		    element      = control.container.find( 'textarea' ),
		    toggler      = control.container.find( '.toggle-editor' ),
		    wpEditorArea = jQuery( '#mageewp_editor_pane textarea.wp-editor-area' ),
		    setChange,
		    content;

		control.container.find( '.mageewp-controls-loading-spinner' ).hide();
		jQuery( window ).load( function() {

			var editor  = tinyMCE.get( 'mageewp-editor' );

			// Add the button text
			toggler.html( editorMageewpL10n['open-editor'] );

			toggler.on( 'click', function() {

				// Toggle the editor.
				control.toggleEditor();

				// Change button.
				control.changeButton();

				// Add the content to the editor.
				control.setEditorContent( editor );

				// Modify the preview-area height.
				control.previewHeight();

			});

			// Update the option from the editor contents on change.
			if ( editor ) {

				editor.onChange.add( function( ed ) {

					ed.save();
					content = editor.getContent();
					clearTimeout( setChange );
					setChange = setTimeout( function() {
						element.val( content ).trigger( 'change' );
						wp.customize.instance( control.getEditorWrapperSetting() ).set( content );
					}, 500 );
				});
			}

			// Handle text mode.
			wpEditorArea.on( 'change keyup paste', function() {
				wp.customize.instance( control.getEditorWrapperSetting() ).set( jQuery( this ).val() );
			});
		});
	},

	/**
	 * Modify the button text and classes.
	 */
	changeButton: function() {

		'use strict';

		var control = this;

		// Reset all editor buttons.
		// Necessary if we have multiple editor fields.
		jQuery( '.customize-control-mageewp-editor .toggle-editor' ).html( editorMageewpL10n['switch-editor'] );

		// Change the button text & color.
		if ( false !== control.getEditorWrapperSetting() ) {
			jQuery( '.customize-control-mageewp-editor .toggle-editor' ).html( editorMageewpL10n['switch-editor'] );
			jQuery( '#customize-control-' + control.getEditorWrapperSetting() + ' .toggle-editor' ).html( editorMageewpL10n['close-editor'] );
		} else {
			jQuery( '.customize-control-mageewp-editor .toggle-editor' ).html( editorMageewpL10n['open-editor'] );
		}
	},

	/**
	 * Toggle the editor.
	 */
	toggleEditor: function() {

		'use strict';

		var control = this,
		    editorWrapper = jQuery( '#mageewp_editor_pane' );

		if ( ! control.getEditorWrapperSetting() || control.id !== control.getEditorWrapperSetting() ) {
			editorWrapper.removeClass();
			editorWrapper.addClass( control.id );
		} else {
			editorWrapper.removeClass();
			editorWrapper.addClass( 'hide' );
		}
	},

	/**
	 * Set the content.
	 */
	setEditorContent: function( editor ) {

		'use strict';

		var control = this;

		editor.setContent( control.setting._value );
	},

	/**
	 * Gets the setting from the editor wrapper class.
	 */
	getEditorWrapperSetting: function() {

		'use strict';

		if ( jQuery( '#mageewp_editor_pane' ).hasClass( 'hide' ) ) {
			return false;
		}

		if ( jQuery( '#mageewp_editor_pane' ).attr( 'class' ) ) {
			return jQuery( '#mageewp_editor_pane' ).attr( 'class' );
		} else {
			return false;
		}
	},

	/**
	 * Modifies the height of the preview area.
	 */
	previewHeight: function() {
		if ( jQuery( '#mageewp_editor_pane' ).hasClass( 'hide' ) ) {
			if ( jQuery( '#customize-preview' ).hasClass( 'is-mageewp-editor-open' ) ) {
				jQuery( '#customize-preview' ).removeClass( 'is-mageewp-editor-open' );
			}
		} else {
			if ( ! jQuery( '#customize-preview' ).hasClass( 'is-mageewp-editor-open' ) ) {
				jQuery( '#customize-preview' ).addClass( 'is-mageewp-editor-open' );
			}
		}
	}
});
