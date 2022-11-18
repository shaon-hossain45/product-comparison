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
if ( ! class_exists( 'AdminBaseAttributesTaxonomy' ) ) {
	class AdminBaseAttributesTaxonomy {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
		public function __construct( ) {
			
			if ( is_admin() && isset( $_GET['taxonomy'], $_GET['post_type'] ) && $_GET['post_type'] === 'product' ) {
				//$taxonomy_name = sanitize_text_field( $_GET['taxonomy'] );
				$taxonomy_name = 'pa_brand-and-model';
				add_action( $taxonomy_name.'_add_form_fields', array( $this, 'rudr_add_term_fields' ) );
				add_action( $taxonomy_name.'_edit_form_fields', array( $this, 'rudr_edit_term_fields' ), 10, 2 );
			}
				//var_dump($taxonomy_name);
				$taxonomy_name = 'pa_brand-and-model';
				add_action( 'created_'.$taxonomy_name, array ( $this, 'rudr_save_term_fields' ), 10, 2 );
        		add_action( 'edited_'.$taxonomy_name, array ( $this, 'rudr_save_term_fields' ), 10, 2 );

		}

        /**
         * Product attribute fileds
         *
         * @return [type] [description]
         */

		function rudr_add_term_fields( $taxonomy ) {
			?>
				<div class="form-field term-custom_taxonomy_advantage-wrap">
					<label for="custom_taxonomy_advantage">Advantage</label>
					<textarea name="custom_taxonomy_advantage" id="custom_taxonomy_advantage" rows="5" cols="40" aria-describedby="custom_taxonomy_advantage-description" spellcheck="false"></textarea>
					<p id="custom_taxonomy_advantage-description">The advantage is not prominent by default; however, some themes may show it.</p>
				</div>
				<div class="form-field term-custom_taxonomy_disadvantage-wrap">
					<label for="custom_taxonomy_disadvantage">Disadvantage</label>
					<textarea name="custom_taxonomy_disadvantage" id="custom_taxonomy_disadvantage" rows="5" cols="40" aria-describedby="custom_taxonomy_disadvantage-description" spellcheck="false"></textarea>
					<p id="custom_taxonomy_disadvantage-description">The disadvantage is not prominent by default; however, some themes may show it.</p>
				</div>
			<?php
		}



		function rudr_edit_term_fields( $term, $taxonomy ) {

			// get meta data value
			$text_fieldadv = get_term_meta( $term->term_id, 'custom_taxonomy_advantage', true );
			$text_fielddis = get_term_meta( $term->term_id, 'custom_taxonomy_disadvantage', true );

			?>
			<tr class="form-field">
				<th><label for="custom_taxonomy_advantage">Disadvantage</label></th>
				<td>
					<textarea name="custom_taxonomy_advantage" id="custom_taxonomy_advantage" rows="5" cols="40" aria-describedby="custom_taxonomy_advantage-description" spellcheck="false"><?php echo esc_attr( $text_fieldadv ) ?></textarea>
					<p id="custom_taxonomy_advantage-description">The advantage is not prominent by default; however, some themes may show it.</p>
				</td>
			</tr>
			<tr class="form-field">
				<th><label for="custom_taxonomy_disadvantage">Advantage</label></th>
				<td>
					<textarea name="custom_taxonomy_disadvantage" id="custom_taxonomy_disadvantage" rows="5" cols="40" aria-describedby="custom_taxonomy_disadvantage-description" spellcheck="false"><?php echo esc_attr( $text_fielddis ) ?></textarea>
					<p id="custom_taxonomy_disadvantage-description">The advantage is not prominent by default; however, some themes may show it.</p>
				</td>
			</tr>
			<?php
		}

		
		function rudr_save_term_fields( $term_id ) {
			
			update_term_meta(
				$term_id,
				'custom_taxonomy_advantage',
				sanitize_text_field( $_POST[ 'custom_taxonomy_advantage' ] )
			);
			update_term_meta(
				$term_id,
				'custom_taxonomy_disadvantage',
				sanitize_text_field( $_POST[ 'custom_taxonomy_disadvantage' ] )
			);
		}

    }
}