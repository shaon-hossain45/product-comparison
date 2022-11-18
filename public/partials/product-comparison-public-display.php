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
if ( ! class_exists( 'PublicBaseDisplay' ) ) {
	class PublicBaseDisplay {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
		public function __construct( ) {

			add_shortcode( 'product_comparison', array( $this, 'template_shortcode' ) );

         //add_action( 'init', array( $this, 'product_attributes_filter' ) );
         
		}



      public function product_attributes_filter(){
      
      
      $attributes =  wc_get_attribute_taxonomies();
      //var_dump($attributes);

      if(isset($_GET['pa_brand-and-model']) And ($_GET['pa_brand-and-model'] != '')){
         $brandmodel = $_GET['pa_brand-and-model'];
      }else{
         $brandmodel ="";
      }
      if(isset($_GET['pa_power']) And ($_GET['pa_power'] != '')){
         $ppower = $_GET['pa_power'];
      }else{
         $ppower ="";
      }
      if(isset($_GET['pa_connector']) And ($_GET['pa_connector'] != '')){
         $pconnector = $_GET['pa_connector'];
      }else{
         $pconnector ="";
      }

      $output = '';
         foreach( wc_get_attribute_taxonomies() as $values ) {
            // Get the array of term names for each product attribute
            
            //var_dump($values);

            if($values->attribute_name == "brand-and-model"){
               
               $output .= '<select class="pa_brand-and-model">';
               
               $terms = get_terms( array('taxonomy' => 'pa_' . $values->attribute_name, 'exclude' => array(888,865,878,874), 'hide_empty' => false ) );
               //var_dump($terms);

               $output .='<option value="">Brand & Model</option>';
               foreach ( $terms as $x => $term ) {
                  $output .='<option value="'.$term->term_id.'"'.($brandmodel == $term->term_id ? "selected" : "").'>' . $term->name . '</option>';
               }
               $output .='<select>';
            }

            if($values->attribute_name == "power"){
              
               $output .= '<select class="pa_power">';
               $terms = get_terms( array('taxonomy' => 'pa_' . $values->attribute_name, 'hide_empty' => false ) );
               //var_dump($terms);

               $output .='<option value="">Power(kW)</option>';
               foreach ( $terms as $x => $term ) {
                  $output .='<option value="'.$term->term_id.'"'.( $ppower== $term->term_id ? "selected" : "").'>' . $term->name . '</option>';
               }
               $output .='<select>';
            }

            if($values->attribute_name == "connector"){
             
               $output .= '<select class="pa_connector">';
               $terms = get_terms( array('taxonomy' => 'pa_' . $values->attribute_name, 'hide_empty' => false ) );
               //var_dump($terms);

               $output .='<option value="">Connector</option>';
               foreach ( $terms as $x => $term ) {
                  //var_dump($term->slug);
                  $output .='<option value="'.$term->term_id.'"'.($pconnector == $term->term_id ? "selected" : "").'>' . $term->name . '</option>';
               }
               $output .='<select>';
            }
         }

         return $output;

      }



   /**
	 * Audio update setting
	 *
	 * @return [type] [description]
	 */
	public function template_shortcode( $atts , $content = null ) {

		// Attributes
		$atts = shortcode_atts(
			array(
				'label' => '',
			),
			$atts,
			'shortcode'
		);

		// global $wpdb;
		// Output
		$output = '';

		// if( ! empty( $item ) ){
 
		$output .='<div class="compare__table">
        <div class="compare__header">
                           <div class="compare__col agenda">
                              <div class="compare__row compare__title"></div>
                           </div>
                           <div class="compare__col product-values top-column-1">
                              <div class="compare__row compare__title">
                                 <div class="compare-product__wrapper">
                                 <div class="btn-filter-group">
                                 <button type="button" class="filter-btn"><span><i class="fa-solid fa-filter"></i></span></button>
                                 <div class="hidden-btn">+</div>
                                 <div class="select-dropdown">';
                                 $output .= $this->product_attributes_filter();
                                 $output .='</div></div>
                                    <ul class="compare-product">
                                       <li class="compare-product__dropdown">
                                          Choose product
                                       </li>
                                    </ul>
                                    <ul class="compare-product__sub-menu" data-colno="1">';

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

                                       $loop = new WP_Query( $args );
                                       if ( $loop->have_posts() ) {
                                             while ( $loop->have_posts() ) : $loop->the_post();
                                             global $product;
                                             $output .='<li>
                                             <button class="multple_values1andcolumn" product_id="'.$product->get_id().'">'.$product->get_name().'<span><strong>Brand & Model: </strong>'.$product->get_attribute( 'pa_brand-and-model' ).', <strong>Connector: </strong>'.$product->get_attribute( 'connector' ).', <strong>Power: </strong>'.$product->get_attribute( 'power' ).'</span></button>
                                          </li>';
                                             endwhile;
                                       } else {
                                             //echo __( 'No products found' );
                                       }
                                       wp_reset_postdata();
                                          $output .='</ul>
                                 </div>
                              </div>
                           </div>
                           <div class="compare__col product-values top-column-2">
                              <div class="compare__row compare__title">
                                 <div class="compare-product__wrapper">
                                 <div class="btn-filter-group">
                                 <button type="button" class="filter-btn"><span><i class="fa-solid fa-filter"></i></span></button>
                                 <div class="hidden-btn">+</div>
                                 <div class="select-dropdown">';
                                 $output .= $this->product_attributes_filter();
                                 $output .='</div></div>
                                 <div class="test-ajax"></div>
                                    <ul class="compare-product">
                                       <li class="compare-product__dropdown">
                                          Choose product
                                       </li>
                                    </ul>
                                    <ul class="compare-product__sub-menu" data-colno="2">';

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

                                       $loop = new WP_Query( $args );
                                       if ( $loop->have_posts() ) {
                                             while ( $loop->have_posts() ) : $loop->the_post();
                                             global $product;
                                             $output .='<li>
                                             <button class="multple_values1andcolumn" product_id="'.$product->get_id().'">'.$product->get_name().'<span><strong>Brand & Model: </strong>'.$product->get_attribute( 'pa_brand-and-model' ).', <strong>Connector: </strong>'.$product->get_attribute( 'connector' ).', <strong>Power: </strong>'.$product->get_attribute( 'power' ).'</span></button>
                                          </li>';
                                             endwhile;
                                       } else {
                                             //echo __( 'No products found' );
                                       }
                                       wp_reset_postdata();
                                          $output .='</ul>
                                 </div>
                              </div>
                           </div>
                           <div class="compare__col product-values top-column-3">
                              <div class="compare__row compare__title">
                                 <div class="compare-product__wrapper">
                                 <div class="btn-filter-group">
                                 <button type="button" class="filter-btn"><span><i class="fa-solid fa-filter"></i></span></button>
                                 <div class="hidden-btn">+</div>
                                 <div class="select-dropdown">';
                                 $output .= $this->product_attributes_filter();
                                 $output .='</div></div>
                                    <ul class="compare-product">
                                       <li class="compare-product__dropdown">
                                          Choose product
                                       </li>
                                    </ul>
                                    <ul class="compare-product__sub-menu" data-colno="3">';

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

                                       $loop = new WP_Query( $args );
                                       if ( $loop->have_posts() ) {
                                             while ( $loop->have_posts() ) : $loop->the_post();
                                             global $product;
                                             $output .='<li>
                                             <button class="multple_values1andcolumn" product_id="'.$product->get_id().'">'.$product->get_name().'<span><strong>Brand & Model: </strong>'.$product->get_attribute( 'pa_brand-and-model' ).', <strong>Connector: </strong>'.$product->get_attribute( 'connector' ).', <strong>Power: </strong>'.$product->get_attribute( 'power' ).'</span></button>
                                          </li>';
                                             endwhile;
                                       } else {
                                             //echo __( 'No products found' );
                                       }
                                       wp_reset_postdata();
                                          $output .='</ul>
                                 </div>
                              </div>
                           </div>
                        </div>
      <div class="compare__container">
        <div class="compare__col agenda">
         <div class="agenda_inner">
            <div class="compare__row">
               <h6>BRAND</h6>
            </div>
            <div class="compare__row">
               <h6>MAX POWER(KW)</h6>
            </div>
            <div class="compare__row">
               <h6>RFID</h6>
            </div>
            <div class="compare__row">
               <h6>COMMUNICATION</h6>
            </div>
            <div class="compare__row">
               <h6>CHARGING SCHEDULE</h6>
            </div>
            <div class="compare__row">
               <h6>OCPP Ready</h6>
            </div>
            <div class="compare__row">
               <h6>WARRANTY(month)</h6>
            </div>
            <div class="compare__row">
               <h6>PRICE €</h6>
            </div>
            <div class="compare__row">
               <h6>Operating Temperature</h6>
            </div>
            <div class="compare__row">
               <h6>INTEGRATED CABLE</h6>
            </div>
         </div>
         <div class="advdis-flex">
         </div>
        </div>
        
        <div class="compare__col product-values column" data-colno="1">
            <div class="compare__col__inner">
               <div class="compare__row value max-heightvalue">
                 <div class="compareImage"></div>
               </div>
               <div class="compare__row value max-heightvaluetitle">
                 <h5 class="compareTitlecolumn"></h5>
              </div>
            </div>
           <div class="compare__col__inner">
              <div class="compare__row value">
                 <p class="comapreBrand"></p>
              </div>
              <div class="compare__row value">
                 <p class="comparePower"></p>
              </div>
              <div class="compare__row value">
                 <p class="compareRfid"></p>
              </div>
              <div class="compare__row value">
                 <p class="compareCommunication HARGING_SCHEDULE3column"></p>
              </div>
              <div class="compare__row value ">
                 <p class="compareCharger APPLICATION_MANAGEMENT3column"></p>
              </div>
              <div class="compare__row value">
                 <p class="ocppReady"></p>
              </div>
               <div class="compare__row value">
                 <p class="compareWarranty"></p>
              </div>
              <div class="compare__row value">
                 <p class="comparePrice price3column"></p>
              </div>
               <div class="compare__row value">
                 <p class="operational_temperature"></p>
              </div>
              <div class="compare__row value">
                 <p class="integratedcable"></p>
              </div>
              <div class="compare__row value">
                 <div class="buyNowButton"></div>
              </div>						 
           </div>
           <div class="advdis-flex">
               <div class="advdis-part adv">
                  <h5>Advantage</h5><article class="advantage"></article>
               </div>
               <div class="advdis-part disadv">
                  <h5>Disadvantage</h5><article class="disadvantage"></article>
               </div>
            </div>
        </div>
          <div class="compare__col product-values column" data-colno="2">
            <div class="compare__col__inner">
               <div class="compare__row value max-heightvalue">
                 <div class="compareImage"></div>
               </div>
               <div class="compare__row value max-heightvaluetitle">
                 <h5 class="compareTitlecolumn"></h5>
              </div>
            </div>
           <div class="compare__col__inner">
               <div class="compare__row value">
                 <p class="comapreBrand"></p>
              </div>
              <div class="compare__row value">
                 <p class="comparePower"></p>
              </div>
              <div class="compare__row value">
                 <p class="compareRfid"></p>
              </div>
              <div class="compare__row value">
                 <p class="compareCommunication HARGING_SCHEDULE2column"></p>
              </div>
              <div class="compare__row value">
                 <p class="compareCharger APPLICATION_MANAGEMENT2column"></p>
              </div>
              <div class="compare__row value">
                 <p class="ocppReady"></p>
              </div>
               <div class="compare__row value">
                 <p class="compareWarranty"></p>
              </div>

              <div class="compare__row value">
                 <p class="comparePrice price2column"></p>
              </div>
               <div class="compare__row value">
                 <p class="operational_temperature"></p>
              </div>
              <div class="compare__row value">
                 <p class="integratedcable"></p>
              </div>
              <div class="compare__row value">
                 <div class="buyNowButton"></div>
              </div>
           </div>
           <div class="advdis-flex">
               <div class="advdis-part adv">
                  <h5>Advantage</h5><article class="advantage"></article>
               </div>
               <div class="advdis-part disadv">
                  <h5>Disadvantage</h5><article class="disadvantage"></article>
               </div>
            </div>
        </div>

        <div class="compare__col product-values column" data-colno="3">
            <div class="compare__col__inner">
               <div class="compare__row value max-heightvalue">
                 <div class="compareImage"></div>
               </div>
               <div class="compare__row value max-heightvaluetitle">
                 <h5 class="compareTitlecolumn"></h5>
              </div>
            </div>
           <div class="compare__col__inner">
               <div class="compare__row value">
                 <p class="comapreBrand"></p>
              </div>
              <div class="compare__row value">
                 <p class="comparePower"></p>
              </div>
              <div class="compare__row value">
                 <p class="compareRfid "></p>
              </div>
              <div class="compare__row value">
                 <p class="compareCommunication HARGING_SCHEDULE"></p>
              </div>
              <div class="compare__row value">
                 <p class="compareCharger APPLICATION_MANAGEMENT"></p>
              </div>
              <div class="compare__row value">
                 <p class="ocppReady"></p>
              </div>
                <div class="compare__row value">
                 <p class="compareWarranty"></p>
              </div>
              <div class="compare__row value">
                 <p class="comparePrice price"></p>
              </div>
               <div class="compare__row value">
                 <p class="operational_temperature"></p>
              </div>
              <div class="compare__row value">
                 <p class="integratedcable"></p>
              </div>
              <div class="compare__row value">
                 <div class="buyNowButton"></div>
              </div>
           </div>
           <div class="advdis-flex">
                  <div class="advdis-part adv">
                     <h5>Advantage</h5><article class="advantage"></article>
                  </div>
                  <div class="advdis-part disadv">
                     <h5>Disadvantage</h5><article class="disadvantage"></article>
                  </div>
            </div>
        </div>
     </div>
</div>';

		return $output;

	}
    
}
}
