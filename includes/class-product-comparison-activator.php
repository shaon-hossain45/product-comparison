<?php

/**
 * Fired during plugin activation
 *
 * @link       https://https://github.com/shaon-hossain45
 * @since      1.0.0
 *
 * @package    Product_Comparison
 * @subpackage Product_Comparison/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Product_Comparison
 * @subpackage Product_Comparison/includes
 * @author     Shaon Hossain <shaonhossain615@gmail.com>
 */
class Product_Comparison_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		// Compare page
		if ( is_admin() ) {

		   $new_page_title    = 'Compare Wallbox Stations';
		   $new_page_content  = '[product_comparison]';
		   $new_page_template = 'page-blank.php'; // ex. template-custom.php. Leave blank if you don't want a custom page template.

		   // don't change the code bellow, unless you know what you're doing

		   $page_check = get_page_by_title( $new_page_title );
		   $new_page   = array(
			  'post_type'    => 'page',
			  'post_title'   => $new_page_title,
			  'post_content' => $new_page_content,
			  'post_status'  => 'publish',
			  'post_author'  => 1,
		   );
		   if ( ! isset( $page_check->ID ) ) {
			  $new_page_id = wp_insert_post( $new_page );
			  if ( ! empty( $new_page_template ) ) {
				 update_post_meta( $new_page_id, '_wp_page_template', $new_page_template );
			  }
		   }
		}
	}

}
