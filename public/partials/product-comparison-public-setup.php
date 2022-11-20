<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://https://github.com/shaon-hossain45
 * @since      1.0.0
 *
 * @package    Product_Comparison
 * @subpackage Product_Comparison/public/partials
 */
?>
<?php
if ( ! class_exists( 'PublicBaseSetup' ) ) {
	class PublicBaseSetup {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
		public function __construct( ) {

			add_action( 'wp_ajax_compare_table_update_setting', array( $this, 'compare_table_update_setting' ) );
			add_action( 'wp_ajax_nopriv_compare_table_update_setting', array( $this, 'compare_table_update_setting' ) );

			add_action( 'wp_ajax_filter_update_setting', array( $this, 'filter_update_setting' ) );
			add_action( 'wp_ajax_nopriv_filter_update_setting', array( $this, 'filter_update_setting' ) );

		}

	/**
	 * Audio update setting
	 *
	 * @return [type] [description]
	 */
	public function compare_table_update_setting() {

	// this is default $item which will be used for new records

	// here we are verifying does this request is post back and have correct nonce
	if ( isset( $_POST ) && wp_verify_nonce( $_POST['security'], 'product_comp_nonce' ) ) {

		if( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
            // Plugin is active
            global $woocommerce;
			// Get $product object from product ID
			$product_id = $_POST['value'];
			$product = wc_get_product( $product_id );

			$tag_slug = $product->get_attribute('brand-and-model');
			$attributes_terms = get_term_by('name', $tag_slug, 'pa_brand-and-model');
			$advantage = get_term_meta($attributes_terms->term_id, 'custom_taxonomy_advantage', true);
			$disadvantage = get_term_meta($attributes_terms->term_id, 'custom_taxonomy_disadvantage', true);

			// var_dump($product->get_attribute('warranty'));

				// // String to array
				// parse_str( $_POST['value'], $itechArray );
			$product_title = $product->get_name();
			if(strlen($product_title) > 60){
				$product_title = substr($product_title, 0, 50)."...";
			}



		// // combine our default item with request params
		// // Collect data from - form request array
		$items = array(
         'dataColumn' => $_POST['dataColumn'],
		// 'ID'               => $itechArray['ID'],
		'product_title'  => $product_title,
         'product_image' => $product->get_image(),
		 'product_url' => get_permalink( $product_id ),
         'communication' => $product->get_attribute('communication'),
         'integrated_cable' => $product->get_attribute('cable'),
         'POWER_MANAGEMENT' => "",
         'RFID' => $product->get_attribute('rfid'),
         'WARRANTY' => $product->get_attribute('warranty'),
		 'ocppReady' => $product->get_attribute('ocpp-ready'),
         'max_power' => $product->get_attribute('power'),
         'overheat_protection' => "",
		 'CHARGING_SCHEDULE' => $product->get_attribute('charging-schedule'),
         'price' => $product->get_price(),
         'operational_temperature' => $product->get_attribute('operating-temperature'),
		 'Brand' => $product->get_attribute('brand'),
		 'Advantage' => esc_attr($advantage),
		 'DisAdvantage' => $disadvantage,
		);

			$return_success = array(
            'insert' => 'success',
            'exists' => $items,
			);
			wp_send_json_success( $return_success );
		}
	}
	}

	public function filter_update_setting(){
// this is default $item which will be used for new records

	// here we are verifying does this request is post back and have correct nonce
	if ( isset( $_POST ) && wp_verify_nonce( $_POST['security'], 'product_filter_nonce' ) ) {
		if( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
            // Plugin is active
            global $woocommerce;
		// var_dump($product->get_attribute('warranty'));
		
			// // String to array
			// parse_str( $_POST['value'], $itechArray );
		
			
			
			$brandmodel = $_POST['BrandModel'];
			$power = $_POST['Power'];
			$connector = $_POST['Conncetor'];


			if( !empty( $brandmodel ) && !empty( $power ) && !empty( $connector ) ){

			$args = array(
				'post_type' => 'product',
				'posts_per_page' => -1,
				'tax_query'             => array(
				   'relation' => 'AND',
				   array(
					  'taxonomy'      => 'product_cat',
					  'field' => 'slug', //This is optional, as it defaults to 'term_id'
					  'terms'         => 'wallbox-charging-station',
					  'include_children' => false,
					  'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
				   ),
				   array(
					'taxonomy' => 'product_cat',
					'field'    => 'slug',
					'terms'    => array( 'accessories-charging-cables' ),
					'operator' => 'NOT IN',
				   ),
				   array(
					'taxonomy' => 'pa_brand-and-model',
					'field'    => 'term_id',
					'terms'    => array( $brandmodel ),
					'operator' => 'IN',
				   ),
				   array(
					'taxonomy' => 'pa_power',
					'field'    => 'term_id',
					'terms'    => array( $power ),
					'operator' => 'IN',
				   ),
				   array(
					'taxonomy' => 'pa_connector',
					'field'    => 'term_id',
					'terms'    => array( $connector ),
					'operator' => 'IN',
					)
				)
			);
		}else if( !empty( $brandmodel ) && !empty( $connector ) ){
			$args = array(
				'post_type' => 'product',
				'posts_per_page' => -1,
				'tax_query'             => array(
				   'relation' => 'AND',
				   array(
					  'taxonomy'      => 'product_cat',
					  'field' => 'slug', //This is optional, as it defaults to 'term_id'
					  'terms'         => 'wallbox-charging-station',
					  'include_children' => false,
					  'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
				   ),
				   array(
					'taxonomy' => 'product_cat',
					'field'    => 'slug',
					'terms'    => array( 'accessories-charging-cables' ),
					'operator' => 'NOT IN',
				   ),
				   array(
					'taxonomy' => 'pa_brand-and-model',
					'field'    => 'term_id',
					'terms'    => array( $brandmodel ),
					'operator' => 'IN',
				   ),
				   array(
					'taxonomy' => 'pa_connector',
					'field'    => 'term_id',
					'terms'    => array( $connector ),
					'operator' => 'IN',
					)
				)
			);
		}else if( !empty( $brandmodel ) && !empty( $power ) ){
			$args = array(
				'post_type' => 'product',
				'posts_per_page' => -1,
				'tax_query'             => array(
				   'relation' => 'AND',
				   array(
					  'taxonomy'      => 'product_cat',
					  'field' => 'slug', //This is optional, as it defaults to 'term_id'
					  'terms'         => 'wallbox-charging-station',
					  'include_children' => false,
					  'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
				   ),
				   array(
					'taxonomy' => 'product_cat',
					'field'    => 'slug',
					'terms'    => array( 'accessories-charging-cables' ),
					'operator' => 'NOT IN',
				   ),
				   array(
					'taxonomy' => 'pa_brand-and-model',
					'field'    => 'term_id',
					'terms'    => array( $brandmodel ),
					'operator' => 'IN',
				   ),
				   array(
					'taxonomy' => 'pa_power',
					'field'    => 'term_id',
					'terms'    => array( $power ),
					'operator' => 'IN',
				   )
				)
			);
		}else if( !empty( $power ) && !empty( $connector ) ){

			$args = array(
				'post_type' => 'product',
				'posts_per_page' => -1,
				'tax_query'             => array(
				   'relation' => 'AND',
				   array(
					  'taxonomy'      => 'product_cat',
					  'field' => 'slug', //This is optional, as it defaults to 'term_id'
					  'terms'         => 'wallbox-charging-station',
					  'include_children' => false,
					  'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
				   ),
				   array(
					'taxonomy' => 'product_cat',
					'field'    => 'slug',
					'terms'    => array( 'accessories-charging-cables' ),
					'operator' => 'NOT IN',
				   ),
				   array(
					'taxonomy' => 'pa_power',
					'field'    => 'term_id',
					'terms'    => array( $power ),
					'operator' => 'IN',
				   ),
				   array(
					'taxonomy' => 'pa_connector',
					'field'    => 'term_id',
					'terms'    => array( $connector ),
					'operator' => 'IN',
					)
				)
			);
		}else if( !empty( $power ) ){
			$args = array(
				'post_type' => 'product',
				'posts_per_page' => -1,
				'tax_query'             => array(
				   'relation' => 'AND',
				   array(
					  'taxonomy'      => 'product_cat',
					  'field' => 'slug', //This is optional, as it defaults to 'term_id'
					  'terms'         => 'wallbox-charging-station',
					  'include_children' => false,
					  'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
				   ),
				   array(
					'taxonomy' => 'product_cat',
					'field'    => 'slug',
					'terms'    => array( 'accessories-charging-cables' ),
					'operator' => 'NOT IN',
				   ),array(
					'taxonomy' => 'pa_power',
					'field'    => 'term_id',
					'terms'    => array( $power ),
					'operator' => 'IN',
				   )
				)
			);
		}else if( !empty( $connector ) ){
			$args = array(
				'post_type' => 'product',
				'posts_per_page' => -1,
				'tax_query'             => array(
				   'relation' => 'AND',
				   array(
					  'taxonomy'      => 'product_cat',
					  'field' => 'slug', //This is optional, as it defaults to 'term_id'
					  'terms'         => 'wallbox-charging-station',
					  'include_children' => false,
					  'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
				   ),
				   array(
					'taxonomy' => 'product_cat',
					'field'    => 'slug',
					'terms'    => array( 'accessories-charging-cables' ),
					'operator' => 'NOT IN',
				   ),
				   array(
					'taxonomy' => 'pa_connector',
					'field'    => 'term_id',
					'terms'    => array( $connector ),
					'operator' => 'IN',
					)
				)
			);
		}else if( !empty( $brandmodel ) ){
			$args = array(
				'post_type' => 'product',
				'posts_per_page' => -1,
				'tax_query'             => array(
				   'relation' => 'AND',
				   array(
					  'taxonomy'      => 'product_cat',
					  'field' => 'slug', //This is optional, as it defaults to 'term_id'
					  'terms'         => 'wallbox-charging-station',
					  'include_children' => false,
					  'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
				   ),
				   array(
					'taxonomy' => 'product_cat',
					'field'    => 'slug',
					'terms'    => array( 'accessories-charging-cables' ),
					'operator' => 'NOT IN',
				   ),array(
					'taxonomy' => 'pa_brand-and-model',
					'field'    => 'term_id',
					'terms'    => array( $brandmodel ),
					'operator' => 'IN',
				   )
				)
			);
		}else{
			$args = array(
				'post_type' => 'product',
				'posts_per_page' => -1,
				'tax_query'             => array(
				   'relation' => 'AND',
				   array(
					  'taxonomy'      => 'product_cat',
					  'field' => 'slug', //This is optional, as it defaults to 'term_id'
					  'terms'         => 'wallbox-charging-station',
					  'include_children' => false,
					  'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
				   ),
				   array(
					'taxonomy' => 'product_cat',
					'field'    => 'slug',
					'terms'    => array( 'accessories-charging-cables' ),
					'operator' => 'NOT IN',
				   )
				)
			);
		}
            // if(isset($_POST['Conncetor']) And ($_POST['Conncetor'] != '')){
			// 	$connector = $_POST['Conncetor'];
			// 	$args['tax_query'] = array(
			// 		'relation' => 'AND',
			// 		array(
			// 				'taxonomy' => 'pa_connector',
			// 				'field'    => 'term_id',
			// 				'terms'    => array( $connector ),
			// 				'operator' => 'IN',
			// 			)
			// 	);
            // };

			// if(isset($_POST['Power']) And ($_POST['Power'] != '')){
			// 	$power = $_POST['Power'];
			// 	$args['tax_query'] = array(
			// 		'relation' => 'AND',
			// 		array(
			// 				'taxonomy' => 'pa_power',
			// 				'field'    => 'term_id',
			// 				'terms'    => array( $power ),
			// 				'operator' => 'IN',
			// 			)
			// 	);
            // };

			// if(isset($_POST['BrandModel']) And ($_POST['BrandModel'] != '')){
			// 	$brandmodel = $_POST['BrandModel'];
            //    $args['tax_query'] = array(
			// 	'relation' => 'AND',
            //       array(
            //             'taxonomy' => 'pa_brand-and-model',
            //             'field'    => 'term_id',
            //             'terms'    => array( $brandmodel ),
            //             'operator' => 'IN',
            //          )
            //    );
            // };

			$output ='';
			$loop = new WP_Query( $args );
			
			if ( $loop->have_posts() ) {
				while ( $loop->have_posts() ) : $loop->the_post();
				global $product;
				$output .='<li>
				<button class="multple_ajax" product_id="'.$product->get_id().'">'.$product->get_name().'<span><strong>Brand & Model: </strong>'.$product->get_attribute( 'pa_brand-and-model' ).', <strong>Connector: </strong>'.$product->get_attribute( 'connector' ).', <strong>Power: </strong>'.$product->get_attribute( 'power' ).'</span></button>
			 </li>';
				endwhile;
			} else {
				//echo __( 'No products found' );
			}
			wp_reset_postdata();

			echo $output;
			die();
			}
	}

}
}
}