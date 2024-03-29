wp.customize.controlConstructor['mageewp-code'] = wp.customize.Control.extend({

	// When we're finished loading continue processing
	ready: function() {

		'use strict';

		var control = this;

		// Add to the queue.
		control.mageewpLoader();
	},

	// Add control to a queue and load when the time is right.
	mageewpLoader: function( forceLoad ) {
		var control  = this,
			waitTime = 100,
			i;

		if ( _.isUndefined( window.mageewpControlsLoader ) ) {
			window.mageewpControlsLoader = {
				queue: [],
				done: [],
				busy: false
			};
		}

		// No need to proceed if this control has already been initialized.
		if ( -1 !== window.mageewpControlsLoader.done.indexOf( control.id ) ) {
			return;
		}

		// Add this control to the queue if it's not already there.
		if ( -1 === window.mageewpControlsLoader.queue.indexOf( control.id ) ) {
			window.mageewpControlsLoader.queue.push( control.id );
		}

		// If we're busy check back again later.
		if ( true === window.mageewpControlsLoader.busy ) {
			setTimeout( function() {
				control.mageewpLoader();
			}, waitTime );
			return;
		}

		// Run if force-loading and not busy.
		if ( true === forceLoad || false === window.mageewpControlsLoader.busy ) {

			// Set to busy.
			window.mageewpControlsLoader.busy = true;

			// Init the control JS.
			control.initMageewpControl();
			jQuery( control.container.find( '.mageewp-controls-loading-spinner' ) ).hide();

			// Mark as done and remove from queue.
			window.mageewpControlsLoader.done.push( control.id );
			i = window.mageewpControlsLoader.queue.indexOf( control.id );
			window.mageewpControlsLoader.queue.splice( i, 1 );

			// Set busy to false after waitTime has passed.
			setTimeout( function() {
				window.mageewpControlsLoader.busy = false;
			}, waitTime );
			return;
		}

		if ( control.id === window.mageewpControlsLoader.queue[0] ) {
			control.mageewpLoader( true );
		}
	},

	initMageewpControl: function() {

		'use strict';

		var control  = this,
		    element  = control.container.find( '.mageewp-codemirror-editor' ),
		    language = ( 'html' === control.params.choices.language ) ? { name: 'htmlmixed' } : control.params.choices.language,
		    editor,
		    container,
		    height;

		control.container.find( '.mageewp-controls-loading-spinner' ).hide();

		editor = CodeMirror.fromTextArea( element[0], {
			value:        control.setting._value,
			mode:         language,
			lineNumbers:  true,
			lineWrapping: true,
			theme:        control.params.choices.theme
		});

		if ( ! _.isUndefined( control.params.choices.height ) ) {
			height = Number( control.params.choices.height );
			if ( ! isNaN( height ) ) {
				container = control.container.find( '.codemirror-mageewp-wrapper' );
				jQuery( container ).css( 'max-height', function() {
					return control.params.choices.height;
				} );
				editor.setSize( null, control.params.choices.height );
			}
		}

		// On change make sure we infor the Customizer API
		editor.on( 'change', function() {
			control.setting.set( editor.getValue() );
		});

		// Hack to refresh the editor when we open a section
		element.parents( '.accordion-section' ).on( 'click', function() {
			editor.refresh();
		});
	}
});
