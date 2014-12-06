var WolfPortfolio = WolfPortfolio || {};

/* jshint -W062 */
WolfPortfolio = function ( $ ) {

	'use strict';

	return {

		/**
		 * Init portfolio isotope masonry
		 */
		init : function () {
			
			var mainContainer = $( '.works' ),
				OptionFilter = $( '#work-filter' ),
				OptionFilterLinks = OptionFilter.find( 'a' ),
				selector;

			mainContainer.imagesLoaded( function() {
				mainContainer.isotope( {
					itemSelector : '.work-item'
				} );
			} );

			OptionFilterLinks.click( function() {
				selector = $( this ).attr( 'data-filter' );
				OptionFilterLinks.attr( 'href', '#' );
				mainContainer.isotope( {
					filter : '.' + selector,
					itemSelector : '.work-item',
					layoutMode : 'fitRows',
					animationEngine : 'best-available'
				} );

				OptionFilterLinks.removeClass( 'active' );
				$( this ).addClass( 'active' );
				return false;
			} );
		}
	};

}( jQuery );

;( function( $ ) {

	'use strict';

	$( document ).ready( function() {

		if ( $( '.works' ).length ) {
			WolfPortfolio.init();
		}
	} );

} )( jQuery );