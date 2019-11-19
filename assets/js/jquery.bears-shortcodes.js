/**
* jquery.bears-shortcodes.js
*
* Author: Bearsthemes
* Author URI: http://bearsthemes.com
* Email: bearsthemes@gmail.com
* Version: 1.0.0
*/

! ( function( $ ) {

	/**
	* jQuery Hover3d
	* 
	* Version: 1.0.0
	* Docs: http://ariona.github.io/hover3d
	* Repo: http://github.com/ariona/hover3d
	* Issues: http://github.com/ariona/hover3d/issues
	*/

	$.fn.hover3d = function( options ){
		
		var settings = $.extend({
			selector      : null,
			perspective   : 1000,
			sensitivity   : 20,
			invert        : false,
			shine         : false,
			hoverInClass  : "hover-in",
			hoverOutClass : "hover-out",
			hoverClass    : "hover-3d"
		}, options);
		
		return this.each(function(){
			
			var $this = $(this),
				$card = $this.find(settings.selector);

			if( settings.shine ){
				$card.append('<div class="shine"></div>');
			}
			var $shine = $(this).find(".shine");

			// Set perspective and transformStyle value
			// for element and 3d object
			$this.css({
				perspective: settings.perspective+"px",
				transformStyle: "preserve-3d"
			});
			
			$card.css({
				perspective: settings.perspective+"px",
				transformStyle: "preserve-3d",
			});

			$shine.css({
				position  : "absolute",
				top       : 0,
				left      : 0,
				bottom    : 0,
				right     : 0,
				"z-index" : 9
			});
			
			// Mouse Enter function, this will add hover-in
			// Class so when mouse over it will add transition
			// based on hover-in class
			function enter(){
				$card.addClass(settings.hoverInClass+" "+settings.hoverClass);
				
				setTimeout(function(){
					$card.removeClass(settings.hoverInClass);
				}, 1000);
			}
			
			// Mouse movement Parallax effect
			function move(event){
				var w      = $this.innerWidth(),
					h      = $this.innerHeight(),
					ax 	   = settings.invert ?  ( w / 2 - event.offsetX)/settings.sensitivity : -( w / 2 - event.offsetX)/settings.sensitivity,
					ay     = settings.invert ? -( h / 2 - event.offsetY)/settings.sensitivity :  ( h / 2 - event.offsetY)/settings.sensitivity;
					dy     = event.offsetY - h / 2,
					dx     = event.offsetX - w / 2,
					theta  = Math.atan2(dy, dx),
					angle  = theta * 180 / Math.PI - 90;
					
				if (angle < 0) {
					angle  = angle + 360;
				}
				

				$card.css({
					perspective    : settings.perspective+"px",
					transformStyle : "preserve-3d",
					transform      : "rotateY("+ax+"deg) rotateX("+ay+"deg)"
				});

				$shine.css('background', 'linear-gradient(' + angle + 'deg, rgba(255,255,255,' + event.offsetY / h * .5 + ') 0%,rgba(255,255,255,0) 80%)');
			}
			
			// Mouse leave function, will set the transform
			// property to 0, and add transition class
			// for exit animation
			function leave(){
				$card.addClass(settings.hoverOutClass+" "+settings.hoverClass);
				$card.css({
					perspective    : settings.perspective+"px",
					transformStyle : "preserve-3d",
					transform      : "rotateX(0) rotateY(0)"
				});
				setTimeout( function(){
					$card.removeClass(settings.hoverOutClass+" "+settings.hoverClass);
				}, 1000 );
			}
			
			// Mouseenter event binding
			$this.on( "mouseenter", function(){
				return enter();
			});
			
			// Mousemove event binding
			$this.on( "mousemove", function(event){
				return move(event);
			});
			
			// Mouseleave event binding
			$this.on( "mouseleave", function(){
				return leave();
			});
			
		});
		
	};
	
	/* clear array */
	// Array.prototype.bsclean = function( deleteValue ) {
	//   	for ( var i = 0; i < this.length; i++ ) {
	//     	if ( this[i] == deleteValue ) {         
	//       		this.splice( i, 1 );
	//       		i--;
	//     	}
	//   	}

	//   	return this;
	// };

	var bsclean = function( arr, deleteValue ) {
		for ( var i = 0; i < arr.length; i++ ) {
	    	if ( arr[i] == deleteValue ) {         
	      		arr.splice( i, 1 );
	      		i--;
	    	}
	  	}

	  	return arr;
	}

	/* bsAnimation */
	var bsAnimation = {};
	bsAnimation.slideUp = function( el, callback, time ) {
		dynamics.css( 
			el, 
			{ translateY: $( el ).innerHeight(), opacity: 0 } );

		dynamics.animate(
			el, 
			{ 
				translateY: 0, 
				opacity: 1 }, 
			{ 
				type: dynamics.bezier, 
				duration: 327, 
				points: [{"x":0,"y":0,"cp":[{"x":0.153,"y":0.787}]},{"x":1,"y":1,"cp":[{"x":0.237,"y":1.067}]}], 
				delay: time,
				complete: function() {
					if( callback ) callback.call( this, el );
				}
			} 
		)
	}
	bsAnimation.slideDown = function( el, callback, time ) {
		dynamics.css( 
			el, 
			{ translateY: 0 } );

		dynamics.animate(
			el, 
			{ 
				translateY: $( el ).innerHeight()
			}, 
			{ 
				type: dynamics.bezier, 
				duration: 327, 
				points: [{"x":0,"y":0,"cp":[{"x":0.153,"y":0.787}]},{"x":1,"y":1,"cp":[{"x":0.237,"y":1.067}]}], 
				delay: time,
				complete: function() {
					if( callback ) callback.call( this, el );
				}
			} 
		)
	}

	/**
	 * tbbs_owlReinit
	 *
	 */
	function tbbs_owlReinit( owlObj, opts ) {
		owlObj.trigger( 'destroy.owl.carousel' ).removeClass( 'owl-carousel owl-loaded' );
		owlObj.html( owlObj.find('.owl-stage-outer').html() );
		owlObj.owlCarousel( opts );

		return owlObj;
	}

	/**
	 * tbbs_shortcodes
	 *
	 */
	function tbbs_shortcodes() {
		this.init();
	}

	tbbs_shortcodes.prototype = {
		init: function() {
			/* #code */
			this.owlCarouselHandle();
			this.slickCarouselHandle();
			this.imageLightbox();
			this.hover3Handle();
			this.qrcodejsHandle();
			this.skrollrHandle();
			this.textillateHandle();
			this.quickviewHandle();

			var self = this;
			$( window ).load( function() {
				setTimeout( function() {
					self.woofavorite();
				}, 1000 )
			} )
		},
 		owlCarouselHandle: function() {
	 		$( '[data-bs-courousel-owl]' ).each( function() {
		 		var $this = $( this ),
		 			opts = $this.data( 'bs-courousel-owl' );

		 		try{ 
		 			var owl_elem = $this.owlCarousel( opts );
		 			$( window ).load( function() { tbbs_owlReinit( owl_elem, opts ) } )
		 		} catch( err ) { console.log( err ); }
	 		} )
 		},
 		slickCarouselHandle: function() {
 			$( '[data-slick-carousel]' ).each( function() {
 				var $this = $( this ),
 					opts = $this.data( 'slick-carousel' );

 				try{
 					$this.slick( opts );
 				} catch( err ) { console.log( err ); }
 			} )
 		},
 		hover3Handle: function() {
 			$( '[data-hover3]' ).each( function() {
 				var $this = $( this ),
 					opts = $this.data( 'hover3' );

 				$this.hover3d( opts );
 			} )
 		},
 		imageLightbox: function() {
 			var imagelightboxEl = $( '[data-imagelightbox-thumbnail]' ),
			activityIndicatorOn = function() {
				$( '<div id="imagelightbox-loading"><div></div></div>' ).appendTo( 'body' );
			},
			activityIndicatorOff = function() {
				$( '#imagelightbox-loading' ).remove();
			},
			overlayOn = function() {
				$( '<div id="imagelightbox-overlay"></div>' ).appendTo( 'body' );
			},
			overlayOff = function() {
				$( '#imagelightbox-overlay' ).remove();
			};

			if( imagelightboxEl.length > 0 ) {
				imagelightboxEl.imageLightbox( {
					onStart: 	 function() { overlayOn(); },
					onEnd:	 	 function() { overlayOff(); activityIndicatorOff(); },
					onLoadStart: function() { activityIndicatorOn(); },
					onLoadEnd:	 function() { activityIndicatorOff(); }
				} );
			}
 		},
 		woofavorite: function() {
 			var self = this, 
 				iconUi = [ '<i class="ion-ios-heart"></i>', '<i class="ion-ios-heart-outline"></i>' ];
 				$woofavoriteContainer = $( '#bs-woofavorite-items' ),
 				$btnShowHide = $woofavoriteContainer.parents( '.bs-woofavorite' ).find( '.show-hide-wishlist' ),
 				favorited = [];
			
 			$woofavoriteContainer.on( {
 				'applyCarousel': function() {
 					var owlOptions = $( this ).data( 'owl-options' ),
 						$owl = $( this ).owlCarousel( owlOptions );

 					$( this ).data( 'owl', $owl );
 				},
 				'resetCarousel': function() {
 					tbbs_owlReinit( $( this ).data( 'owl' ), $( this ).data( 'owl-options' ) );
 				}
 			} )

 			/* get */
 			self.woofavorite.get = function() {
 				var bs_favorited = ( localStorage.getItem( 'bs_favorited' ) ) ? localStorage.getItem( 'bs_favorited' ) : [];			
 				
 				return  ( typeof bs_favorited === 'string' ) ?  bs_favorited.split( ',' ) : bs_favorited;
 			}

 			/* set */
 			self.woofavorite.set = function( pid ) {
 				var bs_favorited = self.woofavorite.get(),
 					st = '';

 				if( bs_favorited.indexOf( pid.toString() ) < 0 ) {
 					bs_favorited.push( pid );
 					st = 'add';
 				}
 				else {
 					delete bs_favorited[bs_favorited.indexOf( pid.toString() )];
 					// bs_favorited.bsclean( undefined );
 					bsclean( bs_favorited, undefined );
 					st = 'remove';
 				}
 				
 				localStorage.setItem( 'bs_favorited', bs_favorited.join( ',' ) );
 				return { favorited: self.woofavorite.get(), st: st };
 			}

 			/* clear */
 			self.woofavorite.clear = function( pid ) {
 				localStorage.removeItem( 'bs_favorited' );
 				return self.woofavorite.get();
 			}

 			self.woofavorite.setIcon = function( el, type ) {
 				if( type == 'add' ) el.addClass( 'active' ).html( iconUi[0] );
 				else el.removeClass( 'active' ).html( iconUi[1] );
 			}

 			/* ajax return Html */
 			self.woofavorite.request = function( listFavorited, callback ) {
 				$.ajax( {
 					type: 'POST',
 					url: bsObj.ajaxurl,
 					data: { action: 'tbbs_woofavorite_items', favorited: listFavorited },
 					success: function( result ) {
 						// console.log( result );

 						if( $woofavoriteContainer.length < 0 ) return;

						try{
							var obj = JSON.parse( result );
							$woofavoriteContainer
							.html( obj.html )
							.trigger( 'resetCarousel' );
							
							$btnShowHide.find( '.num' ).html( obj.count );

							if( obj.count > 0 ) $woofavoriteContainer.parents( '.bs-woofavorite' ).addClass( 'has-item' );
							else $woofavoriteContainer.parents( '.bs-woofavorite' ).removeClass( 'has-item' );
						} catch( e ){
							console.log( e );
						}

 						if( callback ) callback.call( this, result );
 					}
 				} )
 			}

 			/* active */
 			self.woofavorite.active = function() {
 				var listFavorited = self.woofavorite.get();
 				
 				$( '.bs-woofavorite-handle' ).each( function() {
 					var pid = $( this ).data( 'pid' );

 					if( listFavorited.indexOf( pid.toString() ) >= 0 ) self.woofavorite.setIcon( $( this ), 'add' );
	 				else self.woofavorite.setIcon( $( this ), 'remove' );
 				} )

 				listFavorited.forEach( function( pid ) {
 					self.woofavorite.setIcon( $( '.bs-woofavorite-handle[data-pid="'+parseInt( pid )+'"]' ), 'add' );
 				} )
 			}

 			// self.woofavorite.clear();
 			favorited = self.woofavorite.get();

 			$( 'body' )
 			.on( 'click.addfavorite', '.bs-woofavorite-handle', function( e ) {
 				e.preventDefault();

 				var $this = $( this ),
 					pid = $this.data( 'pid' );

 				/* check pid exist */
 				if( ! pid || pid == 0 ) return;

 				favorited = self.woofavorite.set( pid );
 				self.woofavorite.setIcon( $this, favorited.st );

 				/* update item active */
 				self.woofavorite.active();

 				/* update listing favorite */
 				var listFavorited = self.woofavorite.get();
 				self.woofavorite.request( listFavorited );
 			} )
 			.on( 'bs_favorite_setup', function() {
 				self.woofavorite.active();

 				/* apply owlCarousel */
 				$woofavoriteContainer.trigger( 'applyCarousel' );
 				var listFavorited = self.woofavorite.get();
 				self.woofavorite.request( listFavorited )	
 			} ).trigger( 'bs_favorite_setup' );

 			$btnShowHide.on( {
 				'click.toggleContent' : function( e ) {
 					e.preventDefault();
 					var $woofavoriteWrap = $woofavoriteContainer.parents( '.bs-woofavorite' );

 					$woofavoriteWrap.toggleClass( '--show' );
 						
 					if( $woofavoriteWrap.hasClass( '--show' ) ) {
 						
 						$woofavoriteContainer.find( '.owl-item' ).css( 'opacity', 0 );
 						bsAnimation.slideUp( $woofavoriteWrap[0], function() {
 							var $items = $woofavoriteContainer.find( '.owl-item' );
 							if( $items.length <= 0 ) return;
 							
 							$items.each( function() {
 								bsAnimation.slideUp( this, function() {}, $( this ).index() * 100 );
 							} )
 						} )
 					}else {
 						bsAnimation.slideDown( $woofavoriteWrap[0] );
 					}
 				}
 			} )

 			$( window ).on( 'scroll', function() {
				if( $woofavoriteContainer.parents( '.bs-woofavorite' ).hasClass( '--show' ) ) {
					$woofavoriteContainer.parents( '.bs-woofavorite' ).removeClass( '--show' );
					bsAnimation.slideDown( $woofavoriteContainer.parents( '.bs-woofavorite' )[0] );
				}
			} )
 		},
 		qrcodejsHandle: function() {
 			try{ 
	 			$( '[data-qrcodejs]' ).each( function() {
	 				var options = $( this ).data( 'qrcodejs' );
	 				console.log(options);
	 				$( this ).qrcode( options );
	 			} )
	 		} catch( err ) { console.log( err ); }
 		},
 		skrollrHandle: function() {
 			try{
 				var skrollr_opts = {
		 				forceHeight: false,
					    smoothScrolling: true,
					    mobileCheck: function() {
					    	// console.log((/Android|iPhone|iPad|iPod|BlackBerry/i).test(navigator.userAgent || navigator.vendor || window.opera));
					        // return (/Android|iPhone|iPad|iPod|BlackBerry/i).test(navigator.userAgent || navigator.vendor || window.opera);
					    	return false;
					    } 
					};

 				/*skrollr.init( skrollr_opts );*/				
 			} catch( err ) { console.log( err ); }
 		},
 		textillateHandle: function() {

 			$( '[data-textillate-handle]' ).each( function() {
 				var $this = $( this );
 					opts = $this.data( 'textillate-handle' );
 				
 				try{
 					$this.textillate( opts );
 					if( opts.autoStart == false ) {
 						$this.data( 'play', false );
 						$( window ).on( 'scroll.playTextillate', function() {
 							if( 
 								$this.data( 'play' ) == false && 
 								$( this ).height() + $( this ).scrollTop() > $this.offset().top 
 							) {
 								$this.textillate( 'start' ).data( 'play', true );
 							}
 						} ).trigger( 'scroll.playTextillate' );
 					}
 				} catch ( e ) {
 					console.log( e )
 				}
 			} )
 		},
 		quickviewHandle: function() {

 			this.quickviewHandle.buildModal = function() {
 				var $modal = $( '<div>', { 
 					class: 'tbbs-modal-quickview-wrap loading', 
 					html: '<div class="tbbs-modal-container"><a href="#" class="tbbs-modal-close" title="Close"><i class="ion-ios-close-empty"></i></a><div class="tbbs-modal-body"></div></div>' } );

 				$modal.on( {
 					close: function() {
 						$modal.find( '.tbbs-modal-container' ).animate( {
 							top: '-600px',
 							opacity: 0,
 						}, 300, function() {
 							$modal.fadeOut( 'slow', function() {
	 							$( this ).remove();
	 						} )
 						} )

 						
 					},
 					pushContent: function( e, content ) {
 						$modal.removeClass( 'loading' );
 						$modal.find( '.tbbs-modal-body' ).append( content );
 					}
 				} )

 				$modal.on( 'click', function( e ) {
 					if( $( e.target ).hasClass( 'tbbs-modal-quickview-wrap' ) )
 						$modal.trigger( 'close' );
 				} )

 				/* close modal */
 				$modal.find( '.tbbs-modal-close' ).on( 'click', function( e ) {
 					e.preventDefault();

 					$modal.trigger( 'close' );
 				} )

 				$( 'body' ).append( $modal );
 				return $modal;
 			}

 			var self = this;
 			$( 'body' ).on( 'click', '.tbbs-quickview-handle', function( e ) {
 				e.preventDefault();

 				var $this = $( this ),
 					pid = $this.data( 'pid' ),
 					layout = $this.data( 'layout' ),
 					$modal = self.quickviewHandle.buildModal();

 				$.ajax( {
 					type: 'POST',
 					url: bsObj.ajaxurl,
 					data: { action: 'tbbs_quickviewAjaxHandle', layout: layout, pid: pid },
 					success: function( result ) {
 						$modal.trigger( 'pushContent', [result] );
 						if( $modal.find( '[data-slick-carousel]' ).length > 0 ) {
 							$modal.find( '[data-slick-carousel]' ).each( function() {
 								var $this = $( this ),
 									opts = $this.data( 'slick-carousel' );

 								$this.slick( opts );
 							} )
 						}
 					},
 					error: function( e ) {
 						alert( JSON.stringify( e ) );
 						console.log( e );
 					}
 				} )
 			} )
 		}
	};

	/* DOM Ready */
	$( function() {
		/* #code */
		new tbbs_shortcodes();
	} )
} )( jQuery )