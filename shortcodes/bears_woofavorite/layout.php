<?php 
	$owlOptions = array(
		'loop' 		=> true,
		'margin' 	=> 20,
    	'nav' 		=> true,
    	'responsive'=> array( 0 => array( 'items' => 1 ), 600 => array( 'items' => 2 ), 1000 => array( 'items' => 5 ) ),
		'navText'	=> array( '<i class="ion-ios-arrow-thin-left"></i>', '<i class="ion-ios-arrow-thin-right"></i>' )
		);
?>
<div class="bs-woofavorite">
	<a href="#" class="show-hide-wishlist" title="<?php echo esc_attr( $title ); ?>">
		<span class="num">0</span>
		<i class="ion-ios-heart"></i>
	</a>
	<div class="container-fluid">
		<?php if( ! empty( $title ) ) echo "<h4 class='heading'>{$title}</h4>"; ?>
		<div id="bs-woofavorite-items" data-owl-options='<?php echo esc_attr( json_encode( $owlOptions ) ); ?>' class="owl-carousel">	
		</div>
	</div>
</div>