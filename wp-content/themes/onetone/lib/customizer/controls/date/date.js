wp.customize.controlConstructor['mageewp-date'] = wp.customize.Control.extend({

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

		var control  = this,
		    selector = control.selector + ' input.datepicker';

		// Init the datepicker
		jQuery( selector ).datepicker();

		control.container.find( '.mageewp-controls-loading-spinner' ).hide();

		// Save the changes
		this.container.on( 'change keyup paste', 'input.datepicker', function() {
			control.setting.set( jQuery( this ).val() );
		});
	}
});
