<?php
function onpage_post_seo_tool_action_init()
{
	// Localization
	load_plugin_textdomain('onpage_post_seo_tool', false, basename( dirname( __FILE__ ) ) . '/languages' );
}

// Add actions
add_action('init', 'onpage_post_seo_tool_action_init');