<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://https://github.com/shaon-hossain45
 * @since      1.0.0
 *
 * @package    Product_Comparison
 * @subpackage Product_Comparison/admin/partials
 */
?>
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
if ( ! class_exists( 'AdminBaseAttributes' ) ) {
	class AdminBaseAttributes {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
		public function __construct( ) {
			
            add_action( 'woocommerce_after_add_attribute_fields', array( $this, 'woocommerce_custom_product_attribute_field' ) );
			add_action( 'woocommerce_after_edit_attribute_fields', array( $this, 'woocommerce_custom_product_attribute_field' ) );

			add_action( 'woocommerce_attribute_added', array( $this, 'save_woocommerce_custom_product_attribute' ) );
			add_action( 'woocommerce_attribute_updated', array( $this, 'save_woocommerce_custom_product_attribute' ) );
		}

        /**
         * Product attribute fileds
         *
         * @return [type] [description]
         */
		public function woocommerce_custom_product_attribute_field() {
			$id = isset( $_GET['edit'] ) ? absint( $_GET['edit'] ) : 0;
			$value = $id ? get_option( "woocommerce_custom_attribute_field-$id" ) : '';
			$value2 = $id ? get_option( "woocommerce_custom_attribute_field2-$id" ) : '';
			?>
				<tr class="form-field">
					<th scope="row" valign="top">
						<label for="custom_attribute_field">Advantage</label>
					</th>
					<td>
						<input type="text" class="custom_attribute_field" name="custom_attribute_field" id="custom_attribute_field" value="<?php echo esc_attr( $value ); ?>" />
						<!-- <p class="description">Product attribute filed advantage description.</p> -->
					</td>
				</tr>
				<tr class="form-field">
					<th scope="row" valign="top">
						<label for="custom_attribute_field2">Disadvantage</label>
					</th>
					<td>
						<input type="text" class="custom_attribute_field" name="custom_attribute_field2" id="custom_attribute_field2" value="<?php echo esc_attr( $value2 ); ?>" />
						<!-- <p class="description">Product attribute filed disadvantage description.</p> -->
					</td>
				</tr>
			<?php
		}

		public function save_woocommerce_custom_product_attribute( $id ) {
			if ( is_admin() && isset( $_POST['custom_attribute_field'] ) ) {
				$option = "woocommerce_custom_attribute_field-$id";
				update_option( $option, sanitize_text_field( $_POST['custom_attribute_field'] ) );
			}
			if ( is_admin() && isset( $_POST['custom_attribute_field2'] ) ) {
				$option = "woocommerce_custom_attribute_field2-$id";
				update_option( $option, sanitize_text_field( $_POST['custom_attribute_field2'] ) );
			}
		}

    }
}