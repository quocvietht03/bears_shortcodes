<?php
/**
 * bears_social_func
 * [bears_social social='facebook,twitter,pinterest,google' url='#' extra_data='json']
 *
 * @param array $atts
 * @param string $content
 */
if( ! function_exists( 'bears_social_func' ) ) :
	function bears_social_func( $atts, $content ){
		$atts = array_merge( array(
			'social' => 'facebook,twitter,google,pinterest',
			'url' => '',
			'extra_data' => '{}',
			'class' => '',
			), $atts );

		extract( $atts );

		/* check social exist */
		if( empty( $social ) ) return;

		$social = explode( ',', $social );
		$output = '';
		foreach( $social as $s ) : 
			$title = __( 'share on ' . $s, TBBS_NAME );
			switch ( $s ) {
				case 'facebook':
					$output .= "
					<a href='{$url}' onclick='bs_shareSocial( this );return false;' class='bs-social-item s-{$s}' data-stype='{$s}' data-extradata='{$extra_data}' title='{$title}'>
						<i class='ion-social-facebook'></i>
					</a>";
					break;
				
				case 'twitter':
					$output .= "
					<a href='{$url}' onclick='bs_shareSocial( this );return false;' class='bs-social-item s-{$s}' data-stype='{$s}' data-extradata='{$extra_data}' title='{$title}'>
						<i class='ion-social-twitter'></i>
					</a>";
					break;

				case 'google':
					$output .= "
					<a href='{$url}' onclick='bs_shareSocial( this );return false;' class='bs-social-item s-{$s}' data-stype='{$s}' data-extradata='{$extra_data}' title='{$title}'>
						<i class='ion-social-googleplus-outline'></i>
					</a>";
					break;

				case 'pinterest':
					$output .= "
					<a href='{$url}' onclick='bs_shareSocial( this );return false;' class='bs-social-item s-{$s}' data-stype='{$s}' data-extradata='{$extra_data}' title='{$title}'>
						<i class='ion-social-pinterest'></i>
					</a>";
					break;

				case 'instagram':
					$output .= "
					<a href='{$url}' onclick='bs_shareSocial( this );return false;' class='bs-social-item s-{$s}' data-stype='{$s}' data-extradata='{$extra_data}' title='{$title}'>
						<i class='ion-social-instagram'></i>
					</a>";
					break;
			}
		endforeach;

		return "
		<div class='bs-social'>
			{$output}
		</div>";
	}
endif;
add_shortcode( 'bears_social', 'bears_social_func' );

/**
 * tbbs_sharesocial_enqueue_script
 *
 */
if( ! function_exists( 'tbbs_sharesocial_enqueue_script' ) ) :
	function tbbs_sharesocial_enqueue_script() 
	{
?>
<script type="text/javascript">
	function bs_shareSocial( el ) {
		var $ = jQuery;
		var $this = $( el ),
			link = $this.attr( 'href' ),
			type = $this.data( 'stype' ),
			extraData = $this.data( 'extradata' );
		// console.log(extraData);
		switch( type ) {
			case 'facebook': 
				var share_link = 'http://www.facebook.com/sharer.php?u=[post-url]';
				break;

			case 'google': 
				var share_link = 'https://plus.google.com/share?url=[post-url]';
				break;

			case 'twitter': 
				var share_link = 'https://twitter.com/share?url=[post-url]&text=[post-title]';
				break;

			case 'pinterest': 
				var share_link = 'https://pinterest.com/pin/create/bookmarklet/?media=[post-img]&url=[post-url]&description=[post-description]';
				break;
		}

		var mapObj = { 
			'[post-url]'		: link, 
			'[post-title]'	: ( extraData.title ) ? extraData.title : '', 
			'[post-img]'		: ( extraData.thumbnail ) ? extraData.thumbnail : '', 
			'[post-description]': ( extraData.description ) ? extraData.description : '', 
			// '[via]'		: via, 
			// '[hashtags]'	: hashtags, 
			// '[is_video]'	: is_video 
			};

		for (var val in mapObj ) { share_link = share_link.split( val ).join( mapObj[val] ); }
		window.open( share_link, 'share on ' + type, 'width=450,height=300,top=150,left='+ (($( window ).width() / 2) - (450 / 2)) );
	}
</script>
<?php
	}
endif;
add_action( 'wp_head', 'tbbs_sharesocial_enqueue_script' );

