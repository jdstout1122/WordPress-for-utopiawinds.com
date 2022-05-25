wp.customize.controlConstructor['mageewp-radio-image'] = wp.customize.Control.extend({

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

		var control = this;

		control.container.find( '.mageewp-controls-loading-spinner' ).hide();

		// Change the value
		this.container.on( 'click', 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});

	}

});
