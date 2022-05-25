( function() {

	_.each( collapsible, function( label, setting ) {

		setTimeout( function() {
			var control = jQuery( '#customize-control-' + setting ),
			    controlTitleElement;

			// Collapse field.
			control.addClass( 'mageewp-collapsible mageewp-collapsed-control' );

			// Add the header before the field.
			control.before( '<div class="mageewp-collapsed-control-header mageewp-collapsible-header-' + setting + '"><span class="customize-control-title"><span class="dashicons dashicons-arrow-down-alt2"></span> ' + label + '</span></div>' );

			// Add an (x) before the field title.
			controlTitleElement = control.find( '.customize-control-title' );
			controlTitleElement.prepend( '<span class="dashicons dashicons-arrow-up-alt2"></span>' );

			// Show/hide the field when the header is clicked.
			jQuery( '.mageewp-collapsible-header-' + setting ).click( function() {
				if ( control.hasClass( 'mageewp-collapsed-control' ) ) {
					control.removeClass( 'mageewp-collapsed-control' );
					control.addClass( 'mageewp-expanded-control' );
					control.show();
					jQuery( '.mageewp-collapsible-header-' + setting ).hide();
				} else {
					control.addClass( 'mageewp-collapsed-control' );
					control.removeClass( 'mageewp-expanded-control' );
					control.hide();
					jQuery( '.mageewp-collapsible-header-' + setting ).show();
				}
			});

			controlTitleElement.click( function() {
				if ( control.hasClass( 'mageewp-collapsed-control' ) ) {
					control.removeClass( 'mageewp-collapsed-control' );
					control.addClass( 'mageewp-expanded-control' );
					control.show();
					jQuery( '.mageewp-collapsible-header-' + setting ).hide();
				} else {
					control.addClass( 'mageewp-collapsed-control' );
					control.removeClass( 'mageewp-expanded-control' );
					control.hide();
					jQuery( '.mageewp-collapsible-header-' + setting ).show();
				}
			});

		}, 300 );

	});

})( jQuery );
