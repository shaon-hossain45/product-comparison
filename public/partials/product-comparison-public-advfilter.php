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
                  $terms_name = $_POST['value'];

               $args = array(
                  'post_type' => 'product',
                  'posts_per_page' => -1,
                  'tax_query'             => array(
                     'relation' => 'AND',
                     array(
                        'taxonomy' => $taxonomy,
                        'field'    => 'slug',
                        'terms'    => array($terms_name),
                        'operator' => 'IN',
                     )
                  )
                  );
               $loop = new WP_Query( $args );
               if ( $loop->have_posts() ) {
                     while ( $loop->have_posts() ) : $loop->the_post();
                     global $product;
                  //$product_ids[] = $loop->post->ID;

                  //$attributes_list = $product->get_attribute( 'pa_connector' );

if($taxonomy == 'pa_brand-and-model'){
   $product_arraylist[] = $product->get_attribute( 'pa_connector' );
   $product_arraylist[] = $product->get_attribute( 'pa_power' );
}

if($taxonomy == 'pa_connector'){
   $product_arraylist[] = $product->get_attribute( 'pa_brand-and-model' );
   $product_arraylist[] = $product->get_attribute( 'pa_power' );
}
if($taxonomy == 'pa_power'){
   $product_arraylist[] = $product->get_attribute( 'pa_brand-and-model' );
   $product_arraylist[] = $product->get_attribute( 'pa_connector' );
}

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
