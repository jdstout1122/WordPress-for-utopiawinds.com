jQuery( document ).ready( function() {

	function hooCompareValues( value1, value2, operator, extras ) {
		switch ( operator ) {
			case '===':
				return value1 === value2;
			case '==':
			case '=':
			case 'equals':
			case 'equal':
				return value1 == value2; // jshint ignore:line
			case '!==':
				return value1 !== value2;
			case '!=':
			case 'not equal':
				return value1 != value2; // jshint ignore:line
			case '>=':
			case 'greater or equal':
			case 'equal or greater':
				return value2 >= value1;
			case '<=':
			case 'smaller or equal':
			case 'equal or smaller':
				return value2 <= value1;
			case '>':
			case 'greater':
				return value2 > value1;
			case '<':
			case 'smaller':
				return value2 < value1;
			case 'contains':
			case 'in':
				if ( _.isObject( value2 ) ) {
					if ( ! _.isUndefined( value2[ value1 ] ) ) {
						return true;
					}
					window.mageewpControlDependencies[ extras[0] ][ extras[1] ] = false;
					_.each( value2, function( subValue ) {
						if ( value1 === subValue ) {
							window.mageewpControlDependencies[ extras[0] ][ extras[1] ] = true;
						}
					});
					return window.mageewpControlDependencies[ extras[0] ][ extras[1] ];
				} else if ( _.isString( value2 ) ) {
					return value2.indexOf( value1 );
				}
				break;
			default:
				return true;

		}
	}

	_.each( fieldDependencies, function( args, slaveControlID ) {

		// An array of all master controls for this slave.
		var DependenciesMasterControls = [],
			showControl                = {};

		// Populate the DependenciesMasterControls array.
		_.each( args, function( dependency ) {
			if ( _.isObject( dependency ) ) {
				_.each( dependency, function( subDependency ) {
					if ( ! _.isUndefined( subDependency.setting ) ) {
						DependenciesMasterControls.push( subDependency.setting );
					}
				});
			}
			DependenciesMasterControls.push( dependency.setting );
		});

		_.each( DependenciesMasterControls, function( masterControlID ) {

			wp.customize( masterControlID, function( masterSetting ) {

				// Listen for changes to the master control values.
				masterSetting.bind( function() {
					var show = true;
					_.each( args, function( dependency ) {
						if ( ! _.isUndefined( dependency[0] ) && ! _.isUndefined( dependency[0].setting ) ) {

							// Var orConditionShow = {},
							//     orConditionID   = '';
							//
							// _.each( dependency, function( subDependency, subIndex ) {
							// 	orConditionShow[ masterControlID ] = hooCompareValues(
							// 		subDependency.value,
							// 		masterSetting.get(),
							// 		subDependency.operator,
							// 		[slaveControlID, subDependency.setting]
							// 	);
							// });
							// _.each( dependency, function( subDependency ) {
							// 	orConditionID += subDependency.setting;
							// });
							//
							// _.each( orConditionShow, function( val ) {
							// 	console.log( val );
							// 	if ( true === val ) {
							// 		showControl[ orConditionID ] = true;
							// 	}
							// });
						} else {
							showControl[ masterControlID ] = hooCompareValues(
								dependency.value,
								masterSetting.get(),
								dependency.operator,
								[slaveControlID, dependency.setting]
							);
						}
					});
					_.each( showControl, function( val ) {
						if ( false === val ) {
							show = false;
						}
					});
					if ( false === show ) {
						wp.customize.control( slaveControlID ).deactivate();
					} else {
						wp.customize.control( slaveControlID ).activate();
					}
				});
			});
		});
	});
});
