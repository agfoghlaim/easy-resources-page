<?php
/**
 * Template Name: Resources (plugin)
 *
 * @package easy-resources-page
 */

get_header();

// Exit if the 'erp_resource' taxonomy does not exist.
if ( ! taxonomy_exists( 'erp_resource' ) ) {
	exit;
}

?>
<div class="easy-resources-page-content-wrap">
	<section class="resources-intro">
		<?php
			the_content();
		?>
	</section>

	<?php

		// Get list of 'erp_resource' taxonomy terms eg 'strategic-plan', 'consent-form'.
		$the_terms = get_terms(
			array(
				'taxonomy'   => 'erp_resource',
				'hide_empty' => true,
				'orderby'    => 'name',
			)
		);
		echo '<section class="easy-resources-page-section-wrap" >';

		if ( ! is_array( $the_terms ) || empty( $the_terms ) || is_wp_error( $the_terms ) ) {
			return;
		}

		// Loop through $the_terms and find any attachments assigned with term.
		foreach ( $the_terms as $the_term ) {
			$args = array(
				'post_status' => 'inherit',
				'post_type'   => 'attachment',
				// @codingStandardsIgnoreStart WordPress.VIP.SlowDBQuery.slow_db_query
				'tax_query'   => array(
					array(
						'taxonomy' => 'erp_resource',
						'field'    => 'slug',
						'terms'    => $the_term->slug,
					),
				),

			);
			$attachments_with_this_term = new WP_Query( $args );

			// Loop through the attachments with current term, render <div> with <h2>$the_term->name</h2> and list of relevant attachments.
			if ( $attachments_with_this_term->have_posts() ) :
				?>
				<div class="easy-resources-page-item item-<?php echo esc_html( $the_term->slug ); ?>">
			
					<h2 class="easy-resources-page-title"> 

						<button
						style="<?php \EasyResourcesPage\Base\TemplateController::get_css( 'erp-button-background', 'background'); ?><?php \EasyResourcesPage\Base\TemplateController::get_css( 'erp-button-color', 'color'); ?>"
						id="toggle-<?php echo esc_attr( $the_term->slug ); ?>"
						class="showHideResourcesBtn" 
						data-target-id="<?php echo esc_attr($the_term->slug ); ?>"
						aria-expanded="false"
						aria-controls="<?php echo esc_attr($the_term->slug ); ?>"
						>
						<span class="easy-resources-page-term-title"><?php echo esc_html( $the_term->name ); ?></span>
						<span class="easy-resources-page-term-description"><?php echo esc_html( $the_term->description ); ?></span>
						</button>
					</h2>
			
					<div 
					style="<?php echo \EasyResourcesPage\Base\TemplateController::get_css( 'erp-dropdown-background', 'background'); ?> "
						class="easy-resources-page-panel" 
						id="<?php echo esc_attr( $the_term->slug ); ?>" 
						role="region"
						aria-labeledby="toggle-<?php echo esc_attr( $the_term->slug ); ?>"
					>

						<?php
						while ( $attachments_with_this_term->have_posts() ) :

							$attachments_with_this_term->the_post();

							// Get more attachment metadata (alt, description, caption etc).
							$more_details = wp_prepare_attachment_for_js( $post->ID );

							// Render Resouces Item Panel.
							 $easy_resources_page_resource_item = dirname( __FILE__ ) . '/parts/resources-panel-item.php';
							
							if ( file_exists( $easy_resources_page_resource_item) ) {
								include $easy_resources_page_resource_item;
							}

						endwhile;

						wp_reset_postdata();

						?>

					</div><!-- .easy-resources-page-panel-->

				</div><!-- .easy-resources-page-item-->

				<?php

			endif;

		} // foreach.

		echo '</section>';

		?>
		</div><!-- easy-resources-page-content-wrap -->
<?php get_footer(); ?>
