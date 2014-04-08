var WolfPortfolio = WolfPortfolio || {},
	WolfPortfolioParams = WolfPortfolioParams || {};

/* jshint -W062 */
WolfPortfolio = function ( $ ) {

	'use strict';

	return {

		/**
		 * Init portfolio isotope masonry
		 */
		init : function () {
			
			var $this = this,
				mainWorkContainer = $( '.works' ),
				workOptionFilter = $( '#work-filter' ),
				workOptionFilterLinks = workOptionFilter.find( 'a' ),
				selector;
			
			$( '.works' ).imagesLoaded( function() {
				$this.setColumnWidth( '.work-item', mainWorkContainer );
				$( '.works' ).isotope( {
					itemSelector : '.work-item'
				} );
			} );

			workOptionFilterLinks.click( function() {
				selector = $( this ).attr( 'data-filter' );
				workOptionFilterLinks.attr( 'href', '#' );
				$this.setColumnWidth( '.work-item', mainWorkContainer );
				$( '.works' ).isotope( {
					filter : '.' + selector,
					itemSelector : '.work-item',
					layoutMode : 'fitRows',
					animationEngine : 'best-available'
				} );

				workOptionFilterLinks.removeClass( 'active' );
				$( this ).addClass( 'active' );
				return false;
			} );

			$( window ).smartresize( function() {
				$this.setColumnWidth( '.work-item', mainWorkContainer );
				$( '.works' ).isotope( 'reLayout' );
			} );
		},

		/**
		 * Get column count depending on container width
		 */
		getNumColumns : function ( mainContainer ) {
			var winWidth = mainContainer.width(),
				column = WolfPortfolioParams.columns;
			if ( 481 > winWidth ) {
				column = 1;
			} else if ( 481 <= winWidth && 767 > winWidth ) {
				column = 2;
			} else if ( 767 <= winWidth ) {
				column = WolfPortfolioParams.columns;
			}
			return column;
		},
		
		/**
		 * Get column width depending on column number
		 */
		getColumnWidth : function ( mainContainer ) {
			var columns = this.getNumColumns( mainContainer ),
				wrapperWidth = mainContainer.width(),
				columnWidth = Math.floor( wrapperWidth / columns );
			return columnWidth;
		},

		/**
		 * Set column width
		 */
		setColumnWidth : function ( selector, mainContainer ) {
			var ColumnWidth = this.getColumnWidth( mainContainer );
			$( selector ).each( function() {
				$( this ).css( { 'width' : ColumnWidth + 'px' } );
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