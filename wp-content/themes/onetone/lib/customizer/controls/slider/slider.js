wp.customize.controlConstructor['mageewp-slider'] = wp.customize.Control.extend({

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

		var control = this,
		    value,
		    thisInput,
		    inputDefault,
		    changeAction;

		control.container.find( '.mageewp-controls-loading-spinner' ).hide();

		// Update the text value
		jQuery( 'input[type=range]' ).on( 'mousedown', function() {
			value = jQuery( this ).attr( 'value' );
			jQuery( this ).mousemove( function() {
				value = jQuery( this ).attr( 'value' );
				jQuery( this ).closest( 'label' ).find( '.mageewp_range_value .value' ).text( value );
			});
		});

		// Handle the reset button
		jQuery( '.mageewp-slider-reset' ).click( function() {
			thisInput    = jQuery( this ).closest( 'label' ).find( 'input' );
			inputDefault = thisInput.data( 'reset_value' );
			thisInput.val( inputDefault );
			thisInput.change();
			jQuery( this ).closest( 'label' ).find( '.mageewp_range_value .value' ).text( inputDefault );
		});

		changeAction = ( 'postMessage' === control.setting.transport ) ? 'mousemove change' : 'change';

		// Save changes.
		this.container.on( changeAction, 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});
	}
});
