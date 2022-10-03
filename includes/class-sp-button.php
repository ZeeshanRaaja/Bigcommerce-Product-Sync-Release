<?php
	/**
	 * Main Loader File.
	 *
	 * @package Sync-Product
	 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'SP_button' ) ) {

	/**
	 * Class SP_button
	 */
	class SP_button {

		/**
		 * Constructor.
		 */
		public function __construct() {
			
		
			add_action('wp_ajax_test' , array( $this, 'test'));
			add_action('wp_ajax_nopriv_test' , array( $this, 'test'));
			add_action( 'woocommerce_product_options_general_product_data', array($this,'sp_migration_button' ));
			add_filter( 'woocommerce_settings_tabs_array', array( $this, 'bc_setting_tab' ), 50 );
			add_action( 'woocommerce_settings_bc_settings', array( $this, 'adds_bc_settings' ), 60 );
			add_action( 'woocommerce_update_options_bc_settings', array( $this, 'update_settings' ) );
		}

		/**
		 * product sync button for migrating product to bigcommerce
		 * 
		 */
		public function sp_migration_button () {
			
			global $post; ?>
			<a href="#" id="btnSubmit" class="button button-primary" name="sync"> Sync Product</a>
			<input type="text" id="post_id" name="post_id" value="<?php echo $post->ID ?>" style="display: none;" > <?php
			
			}

			/**
			 * setting tab for bigcommerce credendials
			 */
			public function bc_setting_tab( $settings_tabs ) {
				$settings_tabs['bc_settings'] = __( 'Bigcommerce Migration ', 'Sync-Product' );
				return $settings_tabs;
			}

			/**
			 * adding credentials 
			 */
			public function adds_bc_settings() {
				woocommerce_admin_fields( $this->get_settings_array() );
			}
	
			/**
			 * Getting bc Setting Array as return.
			 *
			 * @return array
			 */
			public function get_settings_array() {
				$settings = array(
					'section_title'     => array(
						'name' => __( 'Bigcommerce Migration ' ),
						'type' => 'title',
						'desc' => 'Put Bigcommerce store url and key.',
						'id'   => 'moq-settings-title',
					),
				
					'url'       => array(
						'name'        => __( 'Url', 'Sync-Product' ),
						'type'        => 'text',
						'placeholder' => 'Greater than 1',
						'desc_tip'    => true,
						'id'          => 'bc_url',
					),
					'api_key'       => array(
						'name'        => __( 'Key', 'Sync-Product' ),
						'type'        => 'password',
						'placeholder' => 'Api key',
						'desc_tip'    => true,
						'id'          => 'bc_key',
					),
					
				);
				return apply_filters( 'wc_settings_tab_demo_settings', $settings );
			}

			/**
			 * update settings
			 */
			public function update_settings() {
				woocommerce_update_options( $this->get_settings_array() );
			}
	
			


			/**
			 * ajax callback funtion to hig bigcommerce api
			 */
			public function ajax_callback_bc_api(){

			$p_id = $_REQUEST["hidden_value"];
			$post_id =  $p_id;

			$val = get_post_meta($post_id,"bc_pid",true);
			
			if(!$val){

			$product = wc_get_product($p_id);
			$product_name = $product->get_name();
			$sale_price = $product -> sale_price;
			$product_type = $product -> get_type();
			$product_weight = $product -> weight;
				
			$pro_url=get_option('bc_url');
			$pro_key=get_option('bc_key');

			$url ='https://api.bigcommerce.com/stores/'.$pro_url.'/v3/catalog/products';

			$header = array(
				'X-Auth-Token' => $pro_key
			);
			
			if($product_type=="simple"){
				$product_type = "physical";
			}
	

			$body = json_encode([
			
			   "name" => $product_name,
			   "price" => $sale_price,
			   "type" =>  $product_type,
			   "weight" => $product_weight

			]);

			
	   

			 $args = array(
				'method' => 'POST',
				   'headers' => $header,
				'body' => $body
			);
			
			

			$response = wp_remote_post($url,$args);
			
			$body = json_decode( wp_remote_retrieve_body($response));

			$bc_pid = $body->data->id;

			

			update_post_meta($post_id, "bc_pid", $bc_pid);

			}

			if($val){


			$product = wc_get_product($p_id);
			$product_name = $product->get_name();
			$sale_price = $product -> sale_price;
			$product_type = $product -> get_type();
			$product_weight = $product -> weight;
			$pro_url=get_option('bc_url');
			$pro_key=get_option('bc_key');

			$url ='https://api.bigcommerce.com/stores/'.$pro_url.'/v3/catalog/products/'.$val;

			$header = array(
				'X-Auth-Token' => $pro_key
			);
			
		
	

			$body = json_encode([
			
			   "name" => $product_name,
			   "price" => $sale_price,
			   "type" =>  "physical",
			   "weight" => $product_weight

			]);

			
	   

			 $args = array(
				'method' => 'PUT',
				'headers' => $header,
				'body' => $body
			);
			
			

			$response = wp_remote_post($url,$args);

			}

			
			
		
			}
		}
	
	}

new SP_button();

