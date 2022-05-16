<?php
/**
 * Register resource taxonomy.
 *
 * @see https://make.wordpress.org/core/2019/01/23/improved-taxonomy-metabox-sanitization-in-5-1/
 * @package easy-resources-page
 * @version 1.0.0
 */

namespace EasyResourcesPage\CustomTaxonomy;

/**
 * The resource class
 */
if ( ! class_exists( 'EasyResourcesPage' ) ) {

	/**
	 * The resource class
	 */
	class  Resource {

		/**
		 * Add action to create the custom taxonomy. See Init.
		 */
		public function register() {

			add_action( 'init', array( $this, 'register_resource_taxonomy' ) );
		}


		/**
		 * Create the custom taxonomy.
		 */
		public function register_resource_taxonomy() {
			$labels = array(
				'name'              => _x( 'Resources', 'taxonomy general name', 'easy-resources-page' ),
				'singular_name'     => _x( 'Resource', 'taxonomy singular name', 'easy-resources-page' ),
				'search_items'      => __( 'Search Resources', 'easy-resources-page' ),
				'all_items'         => __( 'All Resources', 'easy-resources-page' ),
				'parent_item'       => __( 'Parent Resource', 'easy-resources-page' ),
				'parent_item_colon' => __( 'Parent Resource:', 'easy-resources-page' ),
				'edit_item'         => __( 'Edit Resource', 'easy-resources-page' ),
				'update_item'       => __( 'Update Resource', 'easy-resources-page' ),
				'add_new_item'      => __( 'Add New Resource', 'easy-resources-page' ),
				'new_item_name'     => __( 'New Resource Name', 'easy-resources-page' ),
				'menu_name'         => __( 'Resource', 'easy-resources-page' ),

			);

			register_taxonomy(
				'erp_resource',
				'attachment',
				array(
					'labels'                => $labels,
					'public'                => true,
					'show_in_rest'          => true,
					'show_ui'               => true,
					'show_admin_column'     => true,
					'update_count_callback' => '_update_generic_term_count',
					'hierarchical'          => false, // changed march 2022.
					'show_admin_column'     => true,
					'meta_box_cb'           => 'post_categories_meta_box',
				)
			);
		}
	}
}
