<div class="post-footer-container">
	<div class="inner">
		<?php  $attached_id = get_post_meta(get_the_ID(), 'select', 1);?>
		<?php  $thumb = get_the_post_thumbnail_url( $attached_id, 'pma_post_footer' );	?>
		<div class="title">
			<?php if(!is_user_logged_in()) {
				?>
				<h3 class="entry-title">Subscribe or login to download the full issue</h3>
				<?php
			}
			?>
		</div>
		<div class="content-block">
		<div class="img-block">
			<a
			<?php if(is_user_logged_in()) {
				echo "href='" . wp_get_canonical_url( $attached_id ) . " ' " ;
			}
			 ?>
			>
				<img src="<?php echo $thumb; ?>" alt="">
			</a>
		</div>
		<div class="variable-block">
			<?php if(!is_user_logged_in()) {
				?>
				<h3 class="entry-title">Already registered?</h3>
				<?php
				echo do_shortcode("[ultimatemember form_id=136]");
			} else {
				$pdf_url = get_field('issue-pdf',$attached_id);
			?>
			<div class="pdf-link">
				<h3 class="entry-title">Download
					<a href="<?php echo $pdf_url;?>">PDF</a>
				</h3>
			</div>
			<?php
			}
			?>

		</div>
		</div>
	</div>
</div>