<?php
/**
 * Render resources Item Panel.
 *
 * @package easy-resources-page
 */

?>

<div 
style="<?php \EasyResourcesPage\Base\TemplateController::get_css( 'erp-panel-background', 'background' ); ?> <?php \EasyResourcesPage\Base\TemplateController::get_css( 'erp-panel-color', 'color' ); ?>"
class="easy-resources-page-panel-item"
>

	<?php
	// Get attachment file type (.pdf, .jpg etc).
	$path_parts           = pathinfo( $post->guid );
	$attachment_file_type = $path_parts['extension'];
	$attachment_mime_type = $post->post_mime_type;
	?>
	<div class="easy-resources-page-panel-left">
		<h3><?php echo esc_html( $post->post_title ); ?></h3>
		<div class="easy-resources-page-file-info">
			<?php
			( isset( $attachment_mime_type ) ) &&
			\EasyResourcesPage\Base\IconController::get_svg_by_mime_type( $attachment_mime_type );
			?>

			<?php
			if ( ' ' !== esc_html( $attachment_file_type ) ) {
				echo '<span class="easy-resources-page-file-info">.' . esc_html( $attachment_file_type ) . '</span>';
			}
			?>
		</div>
	</div>

	<div class="easy-resources-page-panel-center">
		<p>
		<?php echo esc_html( $more_details['description'] ); ?>
		</p>
	</div>

	<div class="easy-resources-page-panel-right">
		<?php
			$previewable_file_types = array( 'pdf', 'jpg', 'jpeg', 'png', 'mp4', 'mp3' );

			$link_class = esc_attr( get_option( 'erp-link-css-class' ) );

		if ( in_array( $attachment_file_type, $previewable_file_types, true ) ) {

			?>
				<a 
					class="easy-resources-page-default-btn <?php echo isset( $link_class ) && '' !== $link_class ? esc_attr( $link_class ) : ''; ?>" 
					title="View in new tab" 
					href="<?php echo esc_url( $post->guid ); ?>" 
					target="<?php echo esc_attr( '_blank' ); ?>">
					<span class="screen-reader-text">View <?php echo esc_html( $post->post_title ); ?></span>
					<span>View</span>
				</a>
				<?php
		}
		?>
				<a 
					class="easy-resources-page-default-btn <?php echo isset( $link_class ) && '' !== $link_class ? esc_attr( $link_class ) : ''; ?>" 
					title="Download file" 
					href="<?php echo esc_url( $post->guid ); ?>" 
					download="<?php echo esc_html( $post->post_title ); ?>" >
					<span class="screen-reader-text">Download <?php echo esc_html( $post->post_title ); ?></span>
					<span>Download</span>
				</a>
	</div>

</div>
