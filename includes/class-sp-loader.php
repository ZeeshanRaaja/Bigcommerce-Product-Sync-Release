<?php
	/**
	 * Main Loader File.
	 *
	 * @package Sync-Product
	 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'SP_Loader' ) ) {

	/**
	 * Class SP_Loader
	 */
	class SP_Loader {

		/**
		 * Constructor.
		 */
		public function __construct() {
			
			$this->includes();
			 add_action('admin_enqueue_scripts', array($this, 'client_scripts'));

			
		
		}
		public function client_scripts()
		{
			wp_enqueue_script('client',  plugin_dir_url(__DIR__) . '/asset/js/sp.js',   array('jquery'), wp_rand());
			wp_localize_script('client', 'ajax_object', array('ajaxurl' => admin_url('admin-ajax.php')));
		}
	

		public function includes(){

			include_once 'class-sp-button.php';


		}

	
	}
}
new SP_Loader();

