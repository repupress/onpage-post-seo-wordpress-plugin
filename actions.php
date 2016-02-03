<?php

/**
 * actions to extend wordpress
 */
class onpage_post_seo_actions 
{
	/**
	 * add plugin box to edit page of posts and pages
	 */
	function addBox()
	{
		$settings = get_option('wtb_seo_main', array());
		$cptSettings = !empty($settings['cpt']) ? (array)$settings['cpt'] : array();
		
		foreach (get_post_types() as $cpt) {
			if (!in_array($cpt, array('attachment', 'revision', 'nav_menu_item'))) {
				if (empty($settings) or (!empty($cptSettings[$cpt]) and $cptSettings[$cpt] == 1)) {
					add_meta_box(
							'wtb_seo', 
							__('OnPage Post SEO', 'wtb_seo'),
							array($this, 'printBox'), 
							$cpt, 
							'side', 
							'high');
				}
			}
		}

	}
	
	/**
	 * print plugin box
	 * @see onpage_post_seo_actions::addBox()
	 * @param WP_Post $post
	 */
	function printBox( $post )
	{
		// Use nonce for verification
		wp_nonce_field( 'wtb_seo', 'wtb_seo_noncename' );

		// hack for wooCommerce, to check short description not main content
		if (is_plugin_active('woocommerce/woocommerce.php')) {
			if ($post->post_type == 'product') {
				$settings = get_option('wtb_seo_main', array());
				if (isset($settings['check_short_description']) ? (int)$settings['check_short_description'] : 0) {
					echo '<input type="hidden" value="1" id="woo_check_short_description" />';
				}
			}
		}
		
		$wpSlot = new wtb_seo_wp_slot($post);
		$wpSlot->generateBox()->display();
		
		// log about this plugi to home
		if (function_exists('curl_init')) {
			$currentDomain = (string)parse_url(get_option('siteurl'), PHP_URL_HOST);
			$url = "http://www.webtec-braun.com/fileadmin/wp-themes/seopost/desc/logo.jpg?domain=" . $currentDomain;
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 2);
			curl_exec($ch) ;
			curl_close($ch);
		}
	}
	
	/**
	 * after save of page or post, info of plugin will be saved too
	 * @param int $post_id
	 * @return void
	 */
	function savePostdata( $post_id ) 
	{
		if (empty($_POST) || empty($_POST['post_type'])) {
			return;
		}

		// First we need to check if the current user is authorised to do this action. 
		if ( 'page' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}
		} else if ( 'post' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		} else {
			if ( ! current_user_can( 'edit_' . $_POST['post_type'], $post_id ) ) {
				return;
			}
		}

		// Secondly we need to check if the user intended to change this value.
		if ( ! isset( $_POST['wtb_seo_noncename'] ) || ! wp_verify_nonce( $_POST['wtb_seo_noncename'], 'wtb_seo' ) ) {
			return;
		}

		// save sections
		$slot = new wtb_seo_post_saver();
		$slot->generateBox()->save((int)$_POST['post_ID']);
	}

	/**
	 * add plugin assets to required pages
	 * @param string $hook
	 */
	function addAssets($hook) 
	{
		if (in_array($hook, array('post.php', 'post-new.php'))) {
			wp_enqueue_script( 'jquery-ui-accordion' );
			
			$onpage_post_seo_plugin_url = plugin_dir_url( __FILE__ );

			// tipsy
			wp_register_style( 'tipsy-css', $onpage_post_seo_plugin_url . 'assets/css/tipsy.css', array(), '1.0.0a' );
			wp_enqueue_style( 'tipsy-css');

			wp_register_script( 'tipsy-scripts', $onpage_post_seo_plugin_url . 'assets/js/jquery.tipsy.js', array('jquery'), '1.0.0a' );
			wp_enqueue_script( 'tipsy-scripts' );
			
			// our css and scripts
			wp_register_style( 'wtb-seo-css', $onpage_post_seo_plugin_url . 'assets/css/main.css', array(), '1.0.2' );
			wp_enqueue_style( 'wtb-seo-css');

			wp_register_script( 'wtb-seo-scripts', $onpage_post_seo_plugin_url . 'assets/js/scripts.js', array('jquery'), '1.0.2' );
			wp_enqueue_script( 'wtb-seo-scripts' );
		}
	}
	
	/**
	 * ajax plugin api, to check info of content
	 */
	function wtb_seo_api_callback()
	{
		$json = array();

		$postCopy = $_POST;
		
		// hack for create autosave
		if (0) { // exclude for short time, to find out 
			// why sometimes post_preview() trows wordpress error
			$post_ID = (int) $_POST['post']['post_ID'];
			$status = get_post_status( $post_ID );
			if ( 'auto-draft' != $status ) {
				$_POST = $_POST['post'];
				post_preview();
			}
		}
		// end of hack
		
		$wpSlot = new wtb_seo_calculator($postCopy);
		$json['box'] = $wpSlot->generateBox()->render();

		echo json_encode($json);

		die(); // this is required to return a proper result
	}

	/**
	 * add link to plugin settings page under settings menu
	 */
	function addSettingPage()
	{
		add_submenu_page( 
			'onpage-post-seo-settings',
			__('SEO Check Options', 'wtb_seo'), 
			__('SEO Check', 'wtb_seo'), 
			'manage_options', 'wtb_seo_settings', 
			array(new wtb_seo_settings(), 'renderSettingsPage') );
		
		//call register settings function
		add_action( 'admin_init', array(new wtb_seo_settings(), 'registerSettings') );
	}
}