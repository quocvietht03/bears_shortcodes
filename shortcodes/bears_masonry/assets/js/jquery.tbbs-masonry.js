/**
 * jquery.tbbs-masonry.js
 * Author: Bearsthemes
 * Author URI: http://bearsthemes.com
 * Email: bearsthemes@gmail.com
 * Ver: 1.0.0
 */

! ( function( $ ) {
	'use strict';

	function tbbs_makeRemoveClassHandler( regex ) {
	  	return function (index, classes) {
	    	return classes.split(/\s+/).filter(function (el) {return regex.test(el);}).join(' ');
	  	}
	}

	var tbbsMasonry = function() {
		this.init();
	}

	tbbsMasonry.prototype = {
		init: function() {
			/* #code */
			this.applyMasonry();
		},
		options: function( opts ) {
			return $.extend( {
				itemSelector: '.grid-item',
			    percentPosition: true,
			    masonry: {
			      	columnWidth: '.grid-sizer',
			      	gutter: '.gutter-sizer'
			    },

			    tbbsGridData		: {},
			    tbbsPadding			: 0,
			    tbbsHeight			: 180,
				tbbsResizable		: false,
				tbbsSave 			: false,
			}, opts );
		},
		applyMasonry: function() {
			var self = this;

			$( '[data-bs-masonry]' ).each( function() {
				var $this = $( this ),
					options = self.options( $this.data( 'bs-masonry' ) );

				/* set setStyleItem */
				self.setStyleItem( $this.find( '.grid-item' ), options );

				var $grid = $this.isotope( options );

				/* save data grid */
				$this.data('grid', $grid );

				/* apply filter */
				self.applyFilter( $this, $grid );

				/* loadmore handle */
				self.loadMoreHandle( $this, $grid );

				/* resizable */
				if( options.tbbsResizable == true ) self.resizableHandle( $this, $grid, options );

				/* save */
				if( options.tbbsSave == true ) self.saveHandle( $this );

				/* window load complete */
				$( window ).load( function() { $grid.isotope('layout'); } )
			} )
		},
		applyFilter: function( $el, $grid ) {
			var self = this;

			/* filter default */
			$el.parents( '.bs-masonry' ).on( 'click', 'a[data-titlefilter]', function( e ) {
				e.preventDefault();

				var $this = $( this ),
					filterValue = $this.data( 'titlefilter' );

				$grid.isotope( { 
					itemSelector: '.grid-item',
					filter: filterValue 
				} );

				$this
				.parent()
				.addClass( 'tbbs-filter-current' )
				.siblings()
				.removeClass( 'tbbs-filter-current' );
			} )

			/* filter select */
			$el.parents( '.bs-masonry' ).on( 'click', '.tbbs-filter-select-wrap', function( e ) {
				e.preventDefault();
				$( this ).toggleClass( 'tbbs-select-active' );

				$( this )
				.off( 'click.item', 'a[data-title]' )
				.on( 'click.item', 'a[data-title]', function( e ) {
					$( this )
					.parents( '.tbbs-filter-select-wrap' )
					.find( '.tbbs-filter-value span' )
					.html( $( this ).data( 'title' ) );
				} )
			} )
		},
		loadMoreHandle: function( $el, $gridEl ) {
			var self = this,
				ajax_type = $el.data( 'bs-ajaxloadmore' );

			if( ajax_type == '' ) return;

			this.loadMoreHandle.ajaxLoadMoreItems = function( $el, $gridEl, atts, paged, callback ) {
				var masonry_opts = $el.data( 'bs-masonry' );

				$.ajax( {
					type: 'POST',
					url: tbbsMasonryObj.ajax_url,
					data: { action: 'tbbs_MasonryAjaxLoadmoreItems', atts: atts, paged: paged },
					success: function( result ) {
						var  $wrap = $( '<div>', { html: result } );
						self.setStyleItem( $wrap.find( '.grid-item' ), masonry_opts );
						$gridEl.isotope( 'insert', $( $wrap.html() ) );
						callback.call( this, result );
					}
				} )
			}

			$el.on( 'scrollLoadmore', function( e, $gridEl ) {
				var $this = $( this );
					
					$this.atts = $this.data( 'bs-atts' );
					$this.paged = 2;
					$this.do_ajax = true;

				$( window ).on( 'scroll.masonryLoadMore_'+$this.atts.element_id, function( e ) {
					var elInfo = { h: $this.height(), t: $this.offset().top },
						$window = $( this );

					if( 
						( $( this ).scrollTop() + $( this ).height() ) >= ( elInfo.t + elInfo.h + 100 ) 
						&& ( $( this ).scrollTop() + $( this ).height() ) <= ( elInfo.t + elInfo.h + $( this ).height() ) 
						&& $this.do_ajax == true 
					) {
						$this.do_ajax = false;
						self.loadMoreHandle.ajaxLoadMoreItems( $this, $gridEl, $this.atts, $this.paged, function( result ) { 
							if( result == '' ) {
								$this.off( 'scrollLoadmore' );
								$window.off( 'scroll.masonryLoadMore_'+$this.atts.element_id );
							} 
							
							$this.do_ajax = true;
							$this.paged += 1;
						} )
					}
				} )
			} )

			$el.on( 'clickButtonLoadmore', function() {
				var $this = $( this ),
					$btn = $this.parents( '.bs-masonry' ).find( '[data-masonryloadmorebtn]' ),
					$contentBtn = $btn.html();

				$this.atts = $this.data( 'bs-atts' );
				$this.paged = 2;
				$this.do_ajax = true;

				$btn.on( 'click', function( e ) {
					e.preventDefault();
					$btn.addClass( 'tbbs-ajax-handle' ).html( 'Loadmore...' );

					self.loadMoreHandle.ajaxLoadMoreItems( $this, $gridEl, $this.atts, $this.paged, function( result ) {
						if( result == '' ) {
							$btn.fadeOut( 'slow', function() { $( this ).remove() } )
						}
						$btn.removeClass( 'tbbs-ajax-handle' ).html( $contentBtn );
						$this.paged += 1;
					} )
				} )
			} )

			switch( ajax_type ) {
				case 'scroll': $el.trigger( 'scrollLoadmore', [$gridEl] ); break;
				case 'click_button': $el.trigger( 'clickButtonLoadmore', [$gridEl] ); break;
			}
		},
		setStyleItem: function( $items, options ) {
			$items.each( function( index ) {

				/* set data grid */
				if( options.tbbsGridData && Object.keys( options.tbbsGridData ).length > 0 ) {
					var _size = ( options.tbbsGridData[index] ) ? options.tbbsGridData[index].size : '',
						_offsetHeight = ( options.tbbsGridData[index] ) ? parseFloat( options.tbbsGridData[index].offsetHeight ) : 1;
						
					$( this ).data( 'size', _size );
					$( this ).data( 'offset-height', _offsetHeight );
				}

				/* set height */
				$( this ).css( {
					height: options.tbbsHeight * parseFloat( $( this ).data( 'offset-height' ) ),
					padding: options.tbbsPadding,
				} )

				/* add width class */
				if( $( this ).data( 'size' ) != '' )
					$( this ).addClass( 'grid-item--'+$( this ).data( 'size' ) );
			} )
		},
		resizableHandle: function( $el, $gridEl, options ) {
			var widthContent = $el.width(),
				step = options.tbbsHeight / 2,
				sizeData = {};

			$( window ).resize( function() {
				widthContent = $el.width();
				sizeData = {
					width3	: widthContent / 3,
					width2	: widthContent / 2,
					width75	: ( widthContent / 4 ) * 3,
					width1	: widthContent,
				};
			} ).trigger( 'resize' );
			
			

			$el.find( '.tbbs-grid-item' )
			.resizable( {
				handles: 'se',
				resize: function( event, ui ) {

					var oHeight = ( parseInt( ui.size.height / step ) > 0 ) ? parseInt( ui.size.height / step ) / 2 : 0.5;
					if( oHeight != ui.element.data( 'offset-height' ) ) {
						ui.element.data( 'offset-height',  oHeight );
						$gridEl.isotope('layout');
					}

					if( ui.size.width >= sizeData.width75 + 30 ) sizeClass = 'width1';
					else if( ui.size.width >= sizeData.width2 + 30 ) sizeClass = 'width75';
					else if( ui.size.width >= sizeData.width3 + 30 ) sizeClass = 'width2';
					else sizeClass = 'width4';
					
					ui.element.data( 'size',sizeClass  );

					var sizeClass = 'grid-item--'+sizeClass;

					if( ! ui.element.hasClass( sizeClass ) ) {

						ui.element
						.removeClass( tbbs_makeRemoveClassHandler(/^grid-item--/) )
						.addClass( sizeClass );

						$gridEl.isotope('layout');
					}
					
				},
				stop: function( event, ui ) {
					ui.element.css( {
						width: "",
						height: options.tbbsHeight * $( this ).data( 'offset-height' ),
					} )

					$gridEl.isotope('layout');
				}
			} );
		},
		renderData: function( $items ) {
			var data = [];

			$items.each( function() {
				data.push( { 
					size: $( this ).data( 'size' ),
					offsetHeight: $( this ).data( 'offset-height' ),
				} )
			} )

			return data;
		},
		saveHandle: function( $el ) {
			var self = this,
				elementID = $el.parent( '.bs-masonry' ).data( 'elementid' ),
				$save = $( '<a href="#" class="tbbs-masonry-save-btn">Save</a>' );
			
			$el.parent().append( $save );

			$save.on( 'click', function( e ) {
				e.preventDefault();
				$save.addClass( 'tbbs-ajax-handle' ).html( 'Saving...' );

				var gridData = self.renderData( $el.find( '.tbbs-grid-item' ) );
				console.log( gridData );
				$.ajax( {
					type 	: 'POST',
					url 	: tbbsMasonryObj.ajax_url,
					data 	: { 
						action 		: 'tbbs_ShortcodeMasonrySaveDataGrid', 
						elementid 	: elementID, 
						grid 		: gridData },
					success : function( result ) {
						$save.removeClass( 'tbbs-ajax-handle' ).html( 'Save' );
					}
				} )
			} )
		},
	}

	/* DOM Ready */
	$( function() {
		new tbbsMasonry();
	} )
} )( jQuery )