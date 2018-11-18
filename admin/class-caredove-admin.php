<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://caredove.com
 * @since      0.1.0
 *
 * @package    Caredove
 * @subpackage Caredove/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Caredove
 * @subpackage Caredove/admin
 * @author     Steedan Crowe <steedancrowe@gmail.com>
 */
class Caredove_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;
	/**
	 * The options name to be used in this plugin
	 *
	 * @since  	0.1.0
	 * @access 	private
	 * @var  	string 		$option_name 	Option name of this plugin
	 */
	private $option_name = 'caredove';

	/**
	 * The version of this plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the visual shortcode for the visual editor.
	 *
	 * @since    0.1.0
	 */

	public function visual_shortcode($options) {
		
		
		return $options;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    0.1.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Caredove_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Caredove_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( $this->plugin_name . 'visualshortcodes', plugin_dir_url( __FILE__ ) . 'css/buttons.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/caredove-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    0.1.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/caredove-admin.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * Registers the shortcode images script as a tinyMCE plugin.
	 * 
	 * @since 0.1.0
	 * @param array $plugins An associative array of plugins
	 * @return array 
	 */

	public function tmce_plugin($plugins) {
		$plugins['visualshortcodes'] = plugins_url('js/caredove-mce-placeholder.js', __FILE__);
		return $plugins;
	}


	/**
	 * Registers the vars for our caredove-mce-placeholder.js file.
	 * 
	 *
	 * @since 0.1.0
	 * @param array $langs An associative array of objects
	 * @return array
	 */
	public function shortcode_config($string) {
			$popup = new stdClass();
			//Define the standard buttons (these can be overridden for a specific shortcode if desired)
			$popup->buttons = [array ('text' => 'cancel','onclick' => 'close'), array ('text' => 'Insert','onclick' => 'submit')];

		  $caredove_api_data = $this->connect_to_api();
		  $api_object = json_decode($caredove_api_data, true);
			
			foreach ($api_object as $result){
				if (isset($result['eReferral']['formUrl'])){
					$caredove_booking_buttons[] = array('text' => $result['name'], 'value' => $result['eReferral']['formUrl']);
				}
			}

			//these are the defaults for button_options we want included whenever there is buttons available
		  $popup->button_options[] = array(
              'type'=> 'textbox',
              'name'=> 'button_text',
              'label'=> 'Button Text',
              'tooltip'=> 'This will be used for the button text'
            );
		  $popup->button_options[] = array (
              'type'   => 'colorbox',
              'name'   => 'button_color',
              'label'  => 'Button Color',
              'text'   => '#fff',
              'values' => [
                  array ( 'text'=> 'White', 'value'=> '#fff' ),
                  array ( 'text'=> 'Black', 'value'=> '#000' ),                 
              ],
              'onaction' => 'createColorPickAction()'
			      );
			 $popup->button_options[] = array( 
		    			'type'   => 'listbox',
              'name'   => 'button_style',
              'label'  => 'Button Style',
              'values' => [
                  array( 'text'=> 'Default', 'value'=> 'default' ),
                  array( 'text'=> 'Style 1', 'value'=> 'style-1' ),
                  array( 'text'=> 'Style 2', 'value'=> 'style-2' )
              ],
              'value' => 'default'
			      );

		
		  
		  //string is the array of shortcode options for the TinyMCE editor popup
			$string = array(
					//first shortcode 'caredove search'
					'0' => array (
					'shortcode' => 'caredove_search',
					'title'=> 'Search Page Settings',
		    	'image' => 'https://via.placeholder.com/350x150',
		    	'command' => 'editImage',
		    	'buttons' => $popup->buttons,
		    	'popupbody' => [
            array(
              'type'=> 'textbox',
              'name'=> 'page_url',
              'label'=> 'Search Page URL',
              'tooltip'=> 'This is the Caredove URL of your search page'
            ),
            array (
              'type'   => 'checkbox',
              'name'   => 'modal',
              'label'  => 'Show search in Modal?',
              'text'   => 'Yes',
              'checked' => true
            ),
            array (
              'type'   => 'textbox',
              'name'   => 'modal_title',
              'label'  => 'Modal Title',
              'value'  => 'Search for Services',
              'tooltip' => 'The title for the popup modal, default: Serach for Services',
              'classes' => 'requires_modal'
            ), $popup->button_options[0],$popup->button_options[1],$popup->button_options[2]
          	]
					), //seccond shortcode 'caredove button'
					'1' => array (
						'shortcode' => 'caredove_button',
						'title' => 'Create a Booking Form Button',
						'image' => 'https://via.placeholder.com/150x150',
		    		'command' => 'editImage',
		    		'buttons' => $popup->buttons,
		    		'popupbody' => [		    			
			    		array( 
			    					'type'   => 'listbox',
                    'name'   => 'page_url',
                    'label'  => 'Booking Form',
                    'values' => $caredove_booking_buttons,
                    'value' => 'none'
              ),
	            array (
	              'type'   => 'textbox',
	              'name'   => 'modal_title',
	              'label'  => 'Modal Title',
	              'value'  => 'Book an Appointment',
	              'tooltip' => 'The title for the popup modal, default: Book an Appointment',
	            ), $popup->button_options[0],$popup->button_options[1],$popup->button_options[2]
			    	]
					), //third shortcode 'caredove listings'
					'2' => array ( //do we need Category options? 
						'shortcode' => 'caredove_listings',
						'title' => 'Display your caredove listings',
						'image' => 'https://via.placeholder.com/50x150',
		    		'command' => 'editImage',
		    		'buttons' => $popup->buttons,
		    		'popupbody' => [
			    		array(
	              'type'   => 'listbox',
	              'name'   => 'list_style',
	              'label'  => 'List Style',
	              'values' => [
	                  array( 'text'=> 'Full Width', 'value'=> 'full_width' ),
	                  array( 'text'=> '2 Column', 'value'=> '2-column' ),
	                  array( 'text'=> '3 Column', 'value'=> '3-column' )
	              ],
	              'value' => 'full_width'
	            ), $popup->button_options[0],$popup->button_options[1],$popup->button_options[2]
			    	]
					) 

				);

			wp_localize_script( 'jquery', 'caredove_tinymce_options', $string);
	}


	//Reference: https://www.sitepoint.com/adding-a-media-button-to-the-content-editor/
	public function media_button_insert_search_page() {
		echo '<a href="#" id="insert-caredove-search-page" class="button caredove-admin-button">+Caredove Search Page</a>';
		echo '<a href="#" id="insert-caredove-button" class="button caredove-admin-button">+Caredove Button</a>';
		echo '<a href="#" id="insert-caredove-listings" class="button caredove-admin-button">+Caredove Listings</a>';
	}

	/**
	 * Add an options page under the Settings submenu
	 *
	 * @since  0.1.0
	 */
	public function add_options_page() {

		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'Caredove Settings', 'caredove' ),
			__( 'Caredove', 'caredove' ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_options_page' )
		);

	}

	/**
	 * Render the options page for plugin
	 *
	 * @since  0.1.0
	 */
	public function display_options_page() {
		include_once 'partials/caredove-admin-display.php';
	}

	/**
	 * Register all related settings of this plugin
	 *
	 * @since  0.1.0
	 */
	public function register_setting() {

		add_settings_section(
			$this->option_name . '_general',
			__( 'General', 'caredove' ),
			array( $this, $this->option_name . '_general_options' ),
			$this->plugin_name
		);

		add_settings_field(
			$this->option_name . '_api_username',
			__( 'API Username', 'caredove' ),
			array( $this, $this->option_name . '_api_username_field' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_api_username' )
		);

		add_settings_field(
			$this->option_name . '_api_password',
			__( 'API password', 'caredove' ),
			array( $this, $this->option_name . '_api_password_field' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_api_password' )
		);

		add_settings_field(
			$this->option_name . '_api_org_id',
			__( 'Your Organization ID', 'caredove' ),
			array( $this, $this->option_name . '_api_org_id_field' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_api_org_id' )
		);

		register_setting( $this->plugin_name, $this->option_name . '_api_username', 'text' );
		register_setting( $this->plugin_name, $this->option_name . '_api_password', 'text' );
		register_setting( $this->plugin_name, $this->option_name . '_api_org_id', 'text' );
	}

	/**
	 * Render the text for the general section
	 *
	 * @since  0.1.0
	 */
	public function caredove_general_options() {
		echo '<p>' . __( 'Please change the settings accordingly.', 'caredove' ) . '</p>';
	}
	/**
	 * Render the option page options
	 *
	 * @since  0.1.0
	 */
	public function caredove_api_username_field() {
		$api_username = get_option( $this->option_name . '_api_username' );
		echo '<input type="text" name="' . $this->option_name . '_api_username' . '" id="' . $this->option_name . '_api_username' . '" value="' . $api_username . '"> ' . __( 'get your API username from caredove.com', 'caredove' );
		}
	public function caredove_api_password_field() {
		$api_password = get_option( $this->option_name . '_api_password' );
		echo '<input type="password" name="' . $this->option_name . '_api_password' . '" id="' . $this->option_name . '_api_password' . '" value="' . $api_password . '"> ' . __( 'get your API password from caredove.com', 'caredove' );
	}
	public function caredove_api_org_id_field() {
		$api_org_id = get_option( $this->option_name . '_api_org_id' );
		echo '<input type="text" name="' . $this->option_name . '_api_org_id' . '" id="' . $this->option_name . '_api_org_id' . '" value="' . $api_org_id . '"> ' . __( 'get your organization ID from caredove.com', 'caredove' );
	}

	public function connect_to_api() {

    	$api_username = get_option('caredove_api_username',array());
    	$api_password = get_option('caredove_api_password',array());
    	$api_org_id = get_option('caredove_api_org_id',array());
    	$api_auth = $api_username . ':' . $api_password;
			$url = 'https://sandbox.caredove.com/api/native_v1/Service/?organization_id=' . $api_org_id;
			$args = array(
	    'headers' => array(
	        'Authorization' => 'Basic ' . base64_encode($api_auth)
			    )
			);
			$response = wp_remote_get( $url, $args );
			$http_code = wp_remote_retrieve_response_code( $response );
			if($http_code == '200'){
				$caredove_api_data = wp_remote_retrieve_body( $response );	
			} else {
				$caredove_api_data = "something went wrong: " . $http_code;
			}

			set_transient('caredove_listings', $caredove_api_data, 60 * 10);
			
			return $caredove_api_data;
			
	}

	public function get_listings() {
			//https://gist.github.com/leocaseiro/455df1f8e1118cb8a2a2
			$listings = get_transient('caredove_listings');
		
			if (!$listings) {
				
				return Caredove_Admin::connect_to_api();
			}

			return $listings;
	}

	public function get_categories() {

		$listing_categories = array();

		$caredove_api_data = Caredove_Admin::get_listings();

    $api_object = json_decode($caredove_api_data, true);
    
		foreach ($api_object as $result){
			if (isset($result['category']['display'])){
				if(!in_array($result['category']['display'], $listing_categories, true)){
        	array_push($listing_categories, $result['category']['display']);
    		}
			}
		}

		return $listing_categories;
	}
}