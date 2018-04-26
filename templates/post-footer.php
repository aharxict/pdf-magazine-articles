<?php

//	$output = '';
//	$output .= '<div class="post-footer"> POST FOOTER ';
//	$output .= '</div>';

?>
<div class="post-footer-container">
	<div class="inner">
		<?php echo $attached_id = get_post_meta(get_the_ID(), 'select', 1);?>
		<?php echo $thumb = get_the_post_thumbnail_url( $attached_id, 'full' );	?>
		<br>
		TEXT
		<br>
		<p>Do you want to see full edition?</p>
		<a href="<?php echo wp_get_canonical_url($attached_id); ?>">
			<img src="<?php echo $thumb; ?>" alt="">
		</a>
	</div>
</div>