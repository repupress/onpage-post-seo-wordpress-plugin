<?php

/*
Plugin Name: On-Page and Post SEO
Plugin URI: http://www.repupress.com
Description: The On-Page and Post SEO Wordpress Plugin will help you write better content and analyse it for SEO factors to rank higher in Google, Yahoo and Bing and drive more traffic to your website.  
Version: 1.0
Author: RepUPress.com
Author URI: http://www.repupress.com/diy-seo/
License: GPL2
*/

// Primary Options Menu

	function onpage_post_seo_menu() {
		add_menu_page(
			'OnPage Post SEO',				/* Page Name */
			'OnPage Post SEO',						/* Menu Link */
			'manage_options',					/* Required User Role */
			'onpage-post-seo-settings',					/* Menu Slug */
			'onpage_post_seo_primary_options_page'		/* Function Name */
		);		
	}
	add_action( 'admin_menu', 'onpage_post_seo_menu' );

	function onpage_post_seo_primary_options_page() {
		require( 'onpage-post-primary-options.php' );
	}

// Premium SEO Page

	function onpage_post_seo_premium_menu() {
		add_submenu_page(
			'onpage-post-seo-settings',
			'Premium SEO Tools',						/* Page Name */
			'SEO Premium',								/* Menu Link */
			'manage_options',							/* Required User Role */
			'onpage-post-seo-premium',					/* Menu Slug */
			'onpage_post_seo_premium_options_page'		/* Function Name */
		);		
	}
	add_action( 'admin_menu', 'onpage_post_seo_premium_menu' );

	function onpage_post_seo_premium_options_page() {
		require_once 'onpage-post-seo-premium-options.php';
	}

//  OnPage Optimization Tool Options Page

	add_action('admin_menu', 'wp_keyword_tool_control_menu');

	function initPlugin(onpage_post_seo_actions $actions)
	{
		// load required files/classes
		// @todo load only if realy required
		requireForFunction();

		add_action( 'add_meta_boxes', array($actions, 'addBox' ));
		
		/* Do something with the data entered */
		add_action( 'save_post', array($actions, 'savePostdata' ));
		
		/* enqueue js and css */
		add_action( 'admin_enqueue_scripts', array($actions, 'addAssets' ));
		
		/* ajax */
		add_action('wp_ajax_wtb_seo_api', array($actions, 'wtb_seo_api_callback' ));
		
		/* settings page */
		add_action( 'admin_menu', array($actions, 'addSettingPage') );
	}

//  Keyword Tool Options Page

	function wp_keyword_tool_control_menu() {

		$page_hook_suffix = add_submenu_page( 'onpage-post-seo-settings', __('Keyword Tool Options','wp_keyword_tool'), 'Keyword Tool', 'administrator', 'wp_keyword_tools_settings', 'wp_keword_tool_fn' );
		add_action('admin_print_scripts-' . $page_hook_suffix, 'wp_keyword_tool_options_scripts');

	}
	require_once 'options-keyword-tool.php';

	function wp_keyword_tool_options_scripts(){
		wp_enqueue_script ( 'wp_keyword_tool_options_main', plugins_url ( '/js/options.js', __FILE__ ) );
		wp_enqueue_style ( 'wp-jquery-ui-dialog' );
		wp_enqueue_script ( 'jquery-ui-dialog' );
	}


//Premium SEO Styles

	function onpage_post_seo_premium_styles() {
		$onpage_post_seo_plugin_url = plugin_dir_url( __FILE__ );
		wp_enqueue_style( 'onpage_post_seo_premium_styles', $onpage_post_seo_plugin_url . 'css/onpage-post-seo-premium-styles.css' );	
	}
	add_action( 'admin_head', 'onpage_post_seo_premium_styles' );
	


//META BOX
	
	add_action( 'admin_menu', 'onpage_post_seo_create_meta_box' );


	function onpage_post_seo_create_meta_box() {
		add_meta_box( 'onpage-post-seo-meta-boxes', 'Title Generator', 'onpage_post_seo_meta_boxes', 'post', 'normal', 'high' );
	}
	function onpage_post_seo_meta_boxes(){
		require_once('pmeta.php');
	}

//SCRIPTS & STYLES
	
	add_action('admin_print_scripts-' . 'post-new.php', 'onpage_post_seo_admin_scripts');
	add_action('admin_print_scripts-' . 'post.php', 'onpage_post_seo_admin_scripts');

	function onpage_post_seo_admin_scripts(){
		wp_enqueue_style( 'onpage-post-seo-admin-style', plugins_url('css/style.css', __FILE__) );
		wp_enqueue_script('onpage-post-seo-db',plugins_url( '/js/db.js' , __FILE__ )	);
		wp_enqueue_script('onpage-post-seo-js',plugins_url( '/js/onpage-post-seo.js' , __FILE__ )	);
		
	}

/* Add a new meta box to the admin menu. */
	
	add_action ( 'admin_menu', 'onpage_post_seo_tool_create_meta_box' );

//  Function for adding meta boxes to the admin.

	function onpage_post_seo_tool_create_meta_box() {
		add_meta_box ( 'onpage_post_seo_tool-meta-boxes', __('On-Page and Post SEO' ,'onpage_post_seo_tool'), 'onpage_post_seo_tool_meta_boxes', 'post', 'side', 'high' );
		add_meta_box ( 'onpage_post_seo_tool-meta-boxes2', __('Keyword Tool Density Check','onpage_post_seo_tool'), 'onpage_post_seo_tool_meta_boxes2', 'post', 'side', 'high' );
		
		add_meta_box ( 'onpage_post_seo_tool-meta-boxes', __('On-Page and Post SEO' ,'onpage_post_seo_tool'), 'onpage_post_seo_tool_meta_boxes', 'page', 'side', 'high' );
		add_meta_box ( 'onpage_post_seo_tool-meta-boxes2', __('Keyword Tool Density Check','onpage_post_seo_tool'), 'onpage_post_seo_tool_meta_boxes2', 'page', 'side', 'high' );
		
	}
	function onpage_post_seo_tool_meta_boxes() {
		
		 global $post;
		 $pid=$post->ID;
		
		 ?>


		<input id="onpage_post_seo_tool_ajax_src" type="hidden" value="<?php echo site_url('/?onpage_post_seo_tool=ajax&pid='.$pid)  ?>"> <input type="text" value="" autocomplete="off" placeholder=<?php _e( 'Keyword...','onpage_post_seo_tool' ) ?> size="14" class="newtag form-input-tip" id="onpage_post_seo_tool_search_txt"> 
		<input type="button" tabindex="3" value="<?php _e('Search','onpage_post_seo_tool') ?>" class="button" id="onpage_post_seo_tool_more">
		<input type="button" tabindex="3" value="x" class="button tagadd" id="onpage_post_seo_tool_clean">
		 
		
		
	<div id="onpage_post_seo_tool_body">
		
		
		<div id="onpage_post_seo_tool_keywords" class="wp-tab-panel"></div>
		
		<div style="margin-bottom:10px;padding-left:5px"><label><input type="checkbox" id="onpage_post_seo_tool_check" value="s"><?php _e('Check/uncheck all','onpage_post_seo_tool') ?></label></div>
		
		<input type="button"   value="<?php _e('Add Tags','onpage_post_seo_tool') ?>" class="button" id="onpage_post_seo_tool_tag_btn"> 
		<input type="button"   value="<?php _e('Watch Density','onpage_post_seo_tool') ?>" class="button" id="onpage_post_seo_tool_density_btn">
		<input type="button"   value="<?php _e('Show as list','onpage_post_seo_tool') ?>" class="button" id="onpage_post_seo_tool_list_btn">
		
		<p>
			<?php _e('keyword tool has found','onpage_post_seo_tool') ?> (<span class="onpage_post_seo_tool_count"></span>) <?php _e('keywords for the term','onpage_post_seo_tool') ?>
		(<span class="onpage_post_seo_tool_keyword_status"></span>) 
		
		
		</p>
		
	</div>

	<div  style="display: none"  id="onpage-post-seo-list-wrap">
		<textarea style="width:100%;height: 300px;" id="onpage-post-seo-list"></textarea>
	</div>

	<?php
	}
	function onpage_post_seo_tool_meta_boxes2() {
		global $post;
		$pid=$post->ID;
		$oldkeys=get_post_meta($pid,'onpage_post_seo_tool_density',1 );
		
		if(! is_array($oldkeys)) $oldkeys=array();
		
		$display= ' style="display:none" ';
		if(count($oldkeys) >0) $display = "";
		
		echo '<div id="onpage_post_seo_tool_density_head" '.$display.' class="onpage_post_seo_tool_itm noborder"><div class="onpage_post_seo_tool_keyword"><strong>'.__('Keyword','onpage_post_seo_tool').'</strong></div><div class="onpage_post_seo_tool_volume"><strong>'.__('Density','onpage_post_seo_tool').'</strong></div><div class="clear"></div></div>';
		echo '<div id="onpage_post_seo_tool_keywords_density">'; 
		
		foreach($oldkeys as $key){
			?>
			<div class="onpage_post_seo_tool_itm tagchecklist"><span><a   class="ntdelbutton">X</a></span><div class="onpage_post_seo_tool_keyword"><?php echo $key ?></div><div class="onpage_post_seo_tool_volume">-</div><div class="clear"></div></div>
			<?php 
		}
		
		echo '</div>';
		?>

	<p>
		<a id="onpage_post_seo_tool_density_info" href="#"><?php _e('What should density equal ?','onpage_post_seo_tool') ?></a>
	<p style="display: none" class="the-tagcloud" id="onpage_post_seo_tool_density_info_box" style="display: block;">
		<?php _e('Ideal Keyword density for single keyword is','onpage_post_seo_tool') ?> <a href="http://www.submitedge.com/blog/ideal-keyword-density/">1-2%</a>
	</p>
	</p>

	<?php
	}

	function onpage_post_seo_tool_options_scripts(){
		wp_enqueue_script ( 'onpage_post_seo_tool_options_main', plugins_url ( '/js/options.js', __FILE__ ) );
		wp_enqueue_style ( 'wp-jquery-ui-dialog' );
		wp_enqueue_script ( 'jquery-ui-dialog' );
	}	



//  Function for adding header style sheets and js

	add_action ( 'admin_print_scripts-' . 'post-new.php', 'onpage_post_seo_tool_admin_scripts' );
	add_action ( 'admin_print_scripts-' . 'post.php', 'onpage_post_seo_tool_admin_scripts' );

	function onpage_post_seo_tool_admin_scripts() {
		
		wp_enqueue_style ( 'wp-jquery-ui-dialog' );
		wp_enqueue_script ( 'jquery-ui-dialog' );

		$onpage_post_seo_tool_alphabets=get_option('onpage_post_seo_tool_alphabets','a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z');	

		$letters_arr=explode(',', trim($onpage_post_seo_tool_alphabets));
		$letters=array_filter($letters_arr);
		$onpage_post_seo_tool_google = trim( get_option('onpage_post_seo_tool_google','google.com'));
		
		?> <script type="text/javascript">
				
				var onpage_post_seo_tool_letters=<?php echo json_encode($letters) ; ?>;
				var onpage_post_seo_tool_google = '<?php echo ($onpage_post_seo_tool_google) ; ?>';
				</script>
		<?php 
		// jquery main
		wp_enqueue_script ( 'onpage_post_seo_tool_jquery_main', plugins_url ( '/js/main.js', __FILE__ ) );
		
		// jquery gcomplete main
		wp_enqueue_script ( 'onpage_post_seo_tool_jquery_gcomplete', plugins_url ( '/js/jquery.gcomplete.0.1.2.js', __FILE__ ) );
		
		wp_enqueue_style ( 'onpage_post_seo_tool-admin-style', plugins_url ( 'css/style.css', __FILE__ ) );
		wp_enqueue_style ( 'onpage_post_seo_tool-admin-style-gcomplete', plugins_url ( 'css/jquery.gcomplete.default-themes.css', __FILE__ ) );
	}

// custom request for fetch boards

	function onpage_post_seo_tool_parse_request($wp) {
		
		// only process requests with "my-plugin=ajax-handler"
		if (array_key_exists ( 'onpage_post_seo_tool', $wp->query_vars )) {
			
			if ($wp->query_vars ['onpage_post_seo_tool'] == 'ajax') {
				
				require_once ('onpage_post_seo_ajax.php');
				exit ();
			}
		}
	}
	add_action ( 'parse_request', 'onpage_post_seo_tool_parse_request' );
	function onpage_post_seo_tool_query_vars($vars) {
		$vars [] = 'onpage_post_seo_tool';
		return $vars;
	}
	add_filter ( 'query_vars', 'onpage_post_seo_tool_query_vars' );


//  Function Selected

	if(! function_exists('opt_selected')){
		function opt_selected($src,$val){
			if (trim($src)==trim($val)) echo ' selected="selected" ';
		}
	}

//  Dashboard Widget

	require_once 'widget.php';

//  Translating the Plugin

	require_once 'ptranslation.php';

// dont load not in admin

	if (!is_admin()) {
		return;
	}

/* config and settings classes */

	require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'actions.php';
	require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'settings.php';

//  require all files only if plugin activated

	function requireForFunction()
	{
		/* load classes */
		require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'box.php';
		require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'box_section.php';
		
		require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'helper.php';

		require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'data_collectors/wp_slot.php';
		require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'data_collectors/calculator.php';
		require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'data_collectors/post_saver.php';

		/* vendors */
		require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'vendors' . DIRECTORY_SEPARATOR . 'simple_html_dom.php';
	}


// and we start

	initPlugin(new onpage_post_seo_actions());
