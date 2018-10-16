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

		  //string is the array of shortocdes
			$string = array(
					//first shortcode
					'0' => array (
					'shortcode' => 'caredove_search',
					'title'=> 'Search Page Settings',
		    	'image' => 'https://via.placeholder.com/350x150',
		    	'command' => 'editImage',
		    	'buttons' => $popup->buttons,
		    	'popupbody' => [
		    		array(
              'type'=> 'textbox',
              'name'=> 'button_text',
              'label'=> 'Button Text',
              'tooltip'=> 'This text will be used inside the button for the popup'
            ),
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
              'checked' => false
            ),
            array (
              'type'   => 'textbox',
              'name'   => 'modal_title',
              'label'  => 'Modal Title',
              'value'  => 'Search for Services',
              'tooltip' => 'The title for the popup modal, default: Serach for Services',
              'classes' => 'requires_modal'
            ),
            array (
                'type'   => 'colorbox',
                'name'   => 'button_color',
                'label'  => 'Button Color',
                'text'   => '#fff',
                'values' => [
                    array ( 'text'=> 'White', 'value'=> '#fff' ),
                    array ( 'text'=> 'Black', 'value'=> '#000' ),                 
                ],
                'onaction' => 'createColorPickAction()'
            ),
         	 	array( 
			    			'type'   => 'listbox',
                    'name'   => 'button_style',
                    'label'  => 'Button Style',
                    'values' => [
                        array( 'text'=> 'Default', 'value'=> 'default' ),
                        array( 'text'=> 'Style 1', 'value'=> 'style-1' ),
                        array( 'text'=> 'Style 2', 'value'=> 'style-2' )
                    ],
                    'value' => 'default'
              )]
					),
					'1' => array (
						'shortcode' => 'caredove_button',
						'title' => '',
						'image' => 'https://via.placeholder.com/150x150',
		    		'command' => 'editImage',
		    		'buttons' => $popup->buttons,
		    		'popupbody' => [
			    		array(
	              'type'=> 'textbox',
	              'name'=> 'text',
	              'label'=> 'Button Text'
	            ),
			    		array( 
			    			'type'   => 'listbox',
                    'name'   => 'listbox',
                    'label'  => 'listbox',
                    'values' => [
                        array( 'text'=> 'None', 'value'=> 'none' ),
                        array( 'text'=> 'Test2', 'value'=> 'test2' ),
                        array( 'text'=> 'Test3', 'value'=> 'test3' )
                    ],
                    'value' => 'none'
              )
			    	]
					),
					'2' => array (
						'shortcode' => 'caredove_listings',
						'title' => '',
						'image' => 'https://via.placeholder.com/50x150',
		    		'command' => 'editImage',
		    		'buttons' => $popup->buttons,
		    		'popupbody' => [
			    		array(
	              'type'=> 'textbox',
	              'name'=> 'text',
	              'label'=> 'List Style'
	            )]
					) 

				);

			wp_localize_script( 'jquery', 'caredove_tinymce_options', $string);
	}


	//https://www.sitepoint.com/adding-a-media-button-to-the-content-editor/
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
			$this->option_name . '_api_token',
			__( 'API Token', 'caredove' ),
			array( $this, $this->option_name . '_api_token_field' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_api_token' )
		);

		register_setting( $this->plugin_name, $this->option_name . '_api_username', 'text' );
		register_setting( $this->plugin_name, $this->option_name . '_api_token', 'text' );
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

	public function caredove_api_token_field() {
		$api_token = get_option( $this->option_name . '_api_token' );
		echo '<input type="text" name="' . $this->option_name . '_api_token' . '" id="' . $this->option_name . '_api_token' . '" value="' . $api_token . '"> ' . __( 'get your API token from caredove.com', 'caredove' );
	}

	public function connect_to_api() {
    	$api_token = get_option('caredove_api_token',array());
			$url = 'https://api.github.com/user/orgs';
			$args = array(
	    'headers' => array(
	    		//a2d42a477afde9fb921ca9e124877129086ded59
	        'Authorization' => 'token ' . $api_token
			    )
			);
			$response = wp_remote_get( $url, $args );
			$http_code = wp_remote_retrieve_response_code( $response );
			if($http_code == '200'){
				$caredove_api_data = wp_remote_retrieve_body( $response );	
			} else {
				$caredove_api_data = "something went wrong: " . $http_code;
			}

			print_r($caredove_api_data);
	}

}