/**
* jquery.bears-shortcodes.js
*
* Author: Bearsthemes
* Author URI: http://bearsthemes.com
* Email: bearsthemes@gmail.com
* Version: 1.0.0
*/

! ( function( $ ) {
	
	$.fn.tbbsSerializeObject = function(){

        var self = this,
            json = {},
            push_counters = {},
            patterns = {
                "validate": /^[a-zA-Z][a-zA-Z0-9_]*(?:\[(?:\d*|[a-zA-Z0-9_]+)\])*$/,
                "key":      /[a-zA-Z0-9_]+|(?=\[\])/g,
                "push":     /^$/,
                "fixed":    /^\d+$/,
                "named":    /^[a-zA-Z0-9_]+$/
            };


        this.build = function(base, key, value){
            base[key] = value;
            return base;
        };

        this.push_counter = function(key){
            if(push_counters[key] === undefined){
                push_counters[key] = 0;
            }
            return push_counters[key]++;
        };

        $.each($(this).serializeArray(), function(){

            // skip invalid keys
            if(!patterns.validate.test(this.name)){
                return;
            }

            var k,
                keys = this.name.match(patterns.key),
                merge = this.value,
                reverse_key = this.name;

            while((k = keys.pop()) !== undefined){

                // adjust reverse_key
                reverse_key = reverse_key.replace(new RegExp("\\[" + k + "\\]$"), '');

                // push
                if(k.match(patterns.push)){
                    merge = self.build([], self.push_counter(reverse_key), merge);
                }

                // fixed
                else if(k.match(patterns.fixed)){
                    merge = self.build([], k, merge);
                }

                // named
                else if(k.match(patterns.named)){
                    merge = self.build({}, k, merge);
                }
            }

            json = $.extend(true, json, merge);
        });

        return json;
    };
    
    /**
	* Open media
	*/
	function tbbs_OpenMedia(title, button_text, opts, callback) {
		var custom_uploader = wp.media({
	        title: title,
	        button: {
	            text: button_text
	        },
	        multiple: opts.multiple
	    })
	    .on('select', function() {
	        var attachment = custom_uploader.state().get('selection').toJSON();
	        callback.call(this, attachment);
	    })
	    .open();
	}
	
	/**
	 * tbbs_shortcodes
	 *
	 */
	function tbbs_shortcodes_backend() {
		this.init();
	}

	tbbs_shortcodes_backend.prototype = {
		init: function() {
			/* #code */
			this.loadparambytemplate();
			this.fieldMediaHandle();
		},
		loadparambytemplate: function() {
 			$( 'html' ).on( 'change', '[data-loadparambytemplate]', function() {
 				var $this = $( this ),
 					field_HTML = $this.find( 'option:selected' ).data( 'fieldhtml' );

 				/* check Html base46_encode */
 				try {
 					/* is base64 */
				    field_HTML = window.atob( field_HTML );
				} catch( e ) { }

 				$this.next( '.tbbs-params-container' ).html( field_HTML );
 			} )

 			/* */
 			$( '#vc_ui-panel-edit-element' ).ajaxComplete( function() {
 				var loadparambytemplateEl = $( this ).find( '[data-loadparambytemplate]' ),
 					self = $( this );

 				if( loadparambytemplateEl.length > 0 ) {
 					$( this ).find( '[data-loadparambytemplate]' ).each( function() {
 						if( $( this ).data( 'loadparambytemplate' ) != true ) {
 							/* */
 							$( this ).data( 'loadparambytemplate', true ).trigger( 'change' );

 							/* */
 							self.find( '[data-vc-ui-element="button-save"]' ).on( 'mouseenter', function() {
			 					var groupFieldContainer = self.find( '.tbbs-shortcode-supper-template' );
			 					if( groupFieldContainer.length <= 0 ) return;

			 					groupFieldContainer.each( function() {
			 						var $this = $( this ),
			 							jsonContentEl = $( this ).find( '[data-jsoncontent]' ),
			 							groupField = $this.find( '.tbbs-template-group-field' );

			 						var objParams = groupField.find('input[name],select[name],textarea[name]').tbbsSerializeObject();
			 						jsonContentEl.val( window.btoa( JSON.stringify( objParams ) ) );
			 					} )
			 				} )
 						}
 					} )
 				}
 			} )

 			/* addmore field */
 			$( 'html' ).on( 'click', 'a.bs-addmore-fields', function( e ) {
 				e.preventDefault();

 				var $this = $( this ),
 					$clone = $this.parents( '.addmore-1' ).clone();

 				/* reset value */
 				$clone.find( 'input[type="text"], textarea, select' ).val( '' );

 				/* append */
 				$this.parents( '.addmore-1' ).after( $clone );
 			} )

 			/* delete field */
 			$( 'html' ).on( 'click', 'a.bs-del-fields', function( e ) {
 				e.preventDefault();

 				var $this = $( this );
 					ask = confirm( "Do you want DELETE it?" );

				if ( ask == true ) $this.parents( '.addmore-1' ).fadeOut( 'slow', function() { $( this ).remove(); } );
 			} )
 		},
 		fieldMediaHandle: function() {
	 		$( 'body' ).on( 'click', '.tbbs-field-media-choose', function( e ) {
		 		e.preventDefault();
		 		var $this = $( this ),
		 			$field = $this.parent().find( '.tbbs-media-data-field' );
		 			opts = { multiple: $field.data( 'multiple' ) },
		 			images_obj = [];
		 		
		 		tbbs_OpenMedia('Select Images', 'Select images', opts, function(result) {
					$.each(result, function(index, item) {
						images_obj.push( item[$field.data( 'typedata' )] );
					})
					
					$field.val( images_obj.join( ',' ) );
				})
	 		} )
 		},
	};

	/* DOM Ready */
	$( function() {
		/* #code */
		new tbbs_shortcodes_backend();
	} )
} )( jQuery )