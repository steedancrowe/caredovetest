<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://caredove.com
 * @since      0.1.0
 *
 * @package    Caredove
 * @subpackage Caredove/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Caredove
 * @subpackage Caredove/public
 * @author     Steedan Crowe <steedancrowe@gmail.com>
 */
class Caredove_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_shortcode('caredove_search', array($this, 'caredove_search_shortcode'));	
		add_shortcode('caredove_button', array($this, 'caredove_booking_button_shortcode'));	
		add_shortcode('caredove_listings', array($this, 'caredove_listings_shortcode'));	
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/caredove-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . '-modaal', plugin_dir_url( __FILE__ ) . 'css/modaal.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    0.1.0
	 */
	public function enqueue_scripts() {

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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/caredove-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name . '-modaal', plugin_dir_url( __FILE__ ) . 'js/modaal.js', array( 'jquery' ), $this->version, false );

	}
	public function caredove_modal() {
		?>
					<div class="caredove-modal">
				    <div class="caredove-modal-content">
				        <span class="caredove-modal-close">×</span>
				        	<iframe id="caredove-iframe" scrolling="yes" src=""></iframe>
				    </div>
					</div>
		<?php	
	}

	public function caredove_search_shortcode($atts) {
				$a = shortcode_atts( array(
						'page_url' => 'https://macrumors.com',
						'modal' => 'false',
						'button_text' => 'Open Search',
						'button_color' => '',
						'button_style' => 'default',
						'modal_title' => 'Search for Services'
				), $atts );

			 $iframe = '<iframe id="caredove-iframe" scrolling="yes" src="'.$a['page_url'].'?embed=1"></iframe>';

			 if($a['modal'] == 'true'){
						ob_start();
						?> 
							<button type="button" class="caredove-iframe-button caredove-button-<?php echo $a['button_style'] ?>" data-modal-title="<?php echo $a["modal_title"]?>" href="<?php echo $a["page_url"]?>" style="background-color:<?php echo $a['button_color']?>;"><?php echo $a['button_text']; ?></button>
						
						<?php
						return ob_get_clean();
			 } else {
			 		ob_start();
					echo $iframe;
					return ob_get_clean();	
			 }

	}

	public function caredove_booking_button_shortcode($atts) {
			$a = shortcode_atts( array(
					'page_url' => 'https://macrumors.com',
					'button_text' => 'Book Now',
					'button_color' => '',
					'button_style' => 'default',
					'modal_title' => 'Book an Appointment'
			), $atts );
		
					ob_start();
					?> 
						<button type="button" class="caredove-iframe-button caredove-button-<?php echo $a['button_style'] ?>" data-modal-title="<?php echo $a["modal_title"]?>" href="<?php echo $a["page_url"]?>" style="background-color:<?php echo $a['button_color']?>;"><?php echo $a['button_text']; ?></button>
					
					<?php
					return ob_get_clean();

	}

	public function caredove_listings_shortcode($atts) {
		$a = shortcode_atts( array(
				'listing_order' => 'ASC',
				'columns' => '1',
				'list_style' => 'full_width',
				'button_text' => 'Book Now',
				'button_color' => '',
				'button_style' => 'default',
				'modal_title' => 'Book an Appointment'
		), $atts );

		    $caredove_api_data = Caredove_Admin::connect_to_api(); 

		    $api_object = json_decode($caredove_api_data, true);
		    	
				ob_start();
				?> 
					<div class="caredove-listings caredove-listings-<?php echo $a['list_style'] ?>">
						<?php foreach ($api_object as $result){
							if (isset($result['eReferral']['formUrl'])){
							?>
								<div class="caredove-listing-item">
									<h3><?php echo $result['name'] ?></h3>
									<p><?php echo $result['details']['description'] ?></p>
									<br />
									<button type="button" class="caredove-iframe-button caredove-button-<?php echo $a['button_style']?>" data-modal-title="<?php echo $a['modal_title']?>" href="<?php echo $result['eReferral']['formUrl']?>" style="background-color:<?php echo $a['button_color']?>;">
										<?php echo html_entity_decode($a["button_text"]); ?>
									</button>

								</div>
							<?php
							}
						}?>
					</div>
				
				<?php
				return ob_get_clean();
	}

}
