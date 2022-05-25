/*jshint -W065 */
wp.customize.controlConstructor['mageewp-select'] = wp.customize.Control.extend({

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
		    element  = this.container.find( 'select' ),
		    multiple = parseInt( element.data( 'multiple' ) ),
		    selectValue,
		    select2Options = {
				escapeMarkup: function( markup ) {
					return markup;
				}
		    };

		control.container.find( '.mageewp-controls-loading-spinner' ).hide();

		if ( 1 < multiple ) {
			select2Options.maximumSelectionLength = multiple;
		}
		jQuery( element ).select2( select2Options ).on( 'change', function() {
			selectValue = jQuery( this ).val();
			control.setting.set( selectValue );
		});
	}
});
