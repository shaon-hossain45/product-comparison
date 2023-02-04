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
if ( ! class_exists( 'PublicBaseAdvfilter' ) ) {
	class PublicBaseAdvfilter {

      /**
       * Initialize the class and set its properties.
       *
       * @since    1.0.0
       * @param      string $plugin_name       The name of this plugin.
       * @param      string $version    The version of this plugin.
       */
		public function __construct( ) {

         if (!function_exists('is_plugin_active')) {
            include_once(ABSPATH . 'wp-admin/includes/plugin.php');
         }

         /* Front End */

         add_action( 'wp_ajax_adv_filter_update_setting', array( $this, 'adv_filter_update_setting' ) );
			add_action( 'wp_ajax_nopriv_adv_filter_update_setting', array( $this, 'adv_filter_update_setting' ) );
		}

      
      /**
       * Dependable selector update setting
       *
       * @return [type] [description]
       */
      public function adv_filter_update_setting() {

         // this is default $item which will be used for new records

	      // here we are verifying does this request is post back and have correct nonce
         if ( isset( $_POST ) && wp_verify_nonce( $_POST['security'], 'product_advfilter_nonce' ) ) {

            if( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
                  // Plugin is active
                  global $woocommerce;

                  $taxonomy = $_POST['columndata'];
                  //$terms_name = explode(",", $_POST['value']);

         //$terms_name = array_filter($terms_name, function($value) {
            //  return $element !== "";
            //return !in_array($value, ['Brand & Model', 'Power(kW)']);
            //                   ↑
            // Array value which you want to delete
         //});

         //var_dump($_POST['value']);

      if($_POST['brand'] != 'pa_brand-and-model'){
         $pa_brandmodel = $_POST['brand'];
      }else{
         $pa_brandmodel = "";
      }

      if($_POST['connector'] != 'pa_connector'){
         $pa_connector = $_POST['connector'];
      }else{
         $pa_connector = "";
      }

      if($_POST['power'] != 'pa_power'){
         $pa_power = $_POST['power'];
      }else{
         $pa_power = "";
      }

				$tax_query = array('relation' => 'AND');
				
				if ( isset( $pa_brandmodel ) & ($pa_brandmodel != 'Brand & Model') ){
					$tax_query[] =  array(
							'taxonomy' => 'pa_brand-and-model',
							'field' => 'name',
							'terms' => $pa_brandmodel
						);
				 }
				
				if ( isset( $pa_connector ) & ($pa_connector != 'Connector') ){
					$tax_query[] =  array(
							'taxonomy' => 'pa_connector',
							'field' => 'name',
							'terms' => $pa_connector
						);
				 }
				
				if ( isset( $pa_power ) & ($pa_power != 'Power(kW)') ){
					$tax_query[] =  array(
							'taxonomy' => 'pa_power',
							'field' => 'name',
							'terms' => $pa_power
						);
				 }
				
               $args = array(
                  'post_type' => 'product',
                  'posts_per_page' => -1,
                  'tax_query'             => $tax_query,
                  );
				
               $loop = new WP_Query( $args );
               if ( $loop->have_posts() ) {
                     while ( $loop->have_posts() ) : $loop->the_post();
                     global $product;
                  //$product_ids[] = $loop->post->ID;

                  //$attributes_list = $product->get_attribute( 'pa_connector' );

                  //if($taxonomy == 'pa_brand-and-model'){
                     $product_arraylist[] = $product->get_attribute( 'pa_connector' );
                     $product_arraylist[] = $product->get_attribute( 'pa_power' );
                     $product_arraylist[] = $product->get_attribute( 'pa_brand-and-model' );
                  //}

                  // if($taxonomy == 'pa_connector'){
                  //    $product_arraylist[] = $product->get_attribute( 'pa_brand-and-model' );
                  //    $product_arraylist[] = $product->get_attribute( 'pa_power' );
                  // }

                  // if($taxonomy == 'pa_power'){
                  //    $product_arraylist[] = $product->get_attribute( 'pa_brand-and-model' );
                  //    $product_arraylist[] = $product->get_attribute( 'pa_connector' );
                  // }

                     endwhile;
               } else {
                  $product_arraylist[] = "";
               }
               wp_reset_postdata();

               // TEST: Output the Products IDs
               //print_r($product_arraylist);

               $return_success = array(
                  'insert' => 'success',
                  'column' => $taxonomy,
                  'exists' => $product_arraylist,
               );
               wp_send_json_success( $return_success );
            }
         }

      }

   }
}
