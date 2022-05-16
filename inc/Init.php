<?php
/**
 * Init. Loopes through classes in get_classes() array and calls register method.
 *
 * @package easy-resources-page
 * @version 1.0.0
 */

namespace EasyResourcesPage;

/**
 * Final Init class.
 */
final class Init {

	/**
	 * Array of classes.
	 *
	 * @return array List of classes whose register methods we want to call.
	 */
	public static function get_services() {
		return array(
			CustomTaxonomy\Resource::class,
			Base\Enqueue::class,
			Base\TemplateController::class,
			API\Settings::class
		);
	}


	/**
	 * Loop classes, call each register method.
	 */
	public static function register_services() {

		$classes = self::get_services();
		foreach ( $classes as $the_class ) {
			$service = self::instantiate( $the_class );
			if ( method_exists( $service, 'register' ) ) {
				$service->register();
			}
		}
	}

	/**
	 * Init class.
	 *
	 * @param class $the_class Class being instantiated.
	 */
	private static function instantiate( $the_class ) {
		return new $the_class();
	}
}
