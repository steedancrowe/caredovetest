<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://caredove.com
 * @since      0.1.0
 *
 * @package    Caredove
 * @subpackage Caredove/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
    <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
    <form action="options.php" method="post">
        <?php
            settings_fields( $this->plugin_name );
            do_settings_sections( $this->plugin_name );
            submit_button();
    	  ?>
    </form>

    <?php $caredove_api_data = Caredove_Admin::get_listings(); 

    $api_object = json_decode($caredove_api_data, true);
    
		foreach ($api_object as $result){
			if (isset($result['eReferral']['formUrl'])){
				print $result['id'].'-'.$result['name'].'-'.$result['eReferral']['formUrl'].'<br />';	
			}
		}

		$listing_categories = Caredove_Admin::get_categories();

		print_r($listing_categories);

    ?>


</div>