<?php

/**
 * settings page
 */
class wtb_seo_settings
{
	/**
	 * register settings for our plugin
	 */
	function registerSettings()
	{
		//register our settings
		register_setting('wtb_seo_settings_main_group', 'wtb_seo_main', array($this, 'sanitize'));
		
		add_settings_section(
			'wtb_seo_settings_main_section',
			__('On-Page and Post Options', 'wtb_seo'),
			null,
			'wtb_seo_settings'
		);	

		// ideal density
		add_settings_field(
			'ideal_density', 
			__('Ideal keyword density (default: 3%)', 'wtb_seo'),
			array($this, 'create_an_ideal_density_field'), 
			'wtb_seo_settings',
			'wtb_seo_settings_main_section'	
		);
		
		// ideal lenght
		add_settings_field(
			'ideal_lenght', 
			__('Ideal post lenght (default: 250)', 'wtb_seo'),
			array($this, 'create_an_ideal_lenght_field'), 
			'wtb_seo_settings',
			'wtb_seo_settings_main_section'	
		);
		
		// checkboxes to check
		add_settings_field(
			'to_check', 
			__('Parameter to check', 'wtb_seo'),
			array($this, 'create_to_check_fields'), 
			'wtb_seo_settings',
			'wtb_seo_settings_main_section'	
		);
		
        // wfd or density
		add_settings_field(
			'wdf_vs_density', 
			__('Keyword density or WDF to show', 'wtb_seo'),
			array($this, 'create_an_wdf_vs_density_field'), 
			'wtb_seo_settings',
			'wtb_seo_settings_main_section'	
		);
        
		// custom post types
		add_settings_section(
			'wtb_seo_settings_cpt_section',
			__('Activate in custom post types', 'wtb_seo'),
			null,
			'wtb_seo_settings'
		);	

		add_settings_field(
			'cpt', 
			__('Custom post types', 'wtb_seo'),
			array($this, 'create_an_custom_post_types_fields'), 
			'wtb_seo_settings',
			'wtb_seo_settings_cpt_section'	
		);
		
		// woocommerce
		if (is_plugin_active('woocommerce/woocommerce.php')) {
			add_settings_section(
				'wtb_seo_settings_woo_section',
				__('WooCommerce settings', 'wtb_seo'),
				null,
				'wtb_seo_settings'
			);	

			add_settings_field(
				'check_short_description', 
				__('Check short description', 'wtb_seo'),
				array($this, 'create_check_short_description'), 
				'wtb_seo_settings',
				'wtb_seo_settings_woo_section'	
			);
		}
		
		// auto refresh
		add_settings_section(
			'wtb_seo_settings_ar_section',
			__('Auto refresh settings', 'wtb_seo'),
			null,
			'wtb_seo_settings'
		);	

		add_settings_field(
			'disable_auto_refresh', 
			__('Disabled', 'wtb_seo'),
			array($this, 'create_auto_refresh_disable'), 
			'wtb_seo_settings',
			'wtb_seo_settings_ar_section'	
		);
		
		add_settings_field(
			'auto_refresh_time', 
			__('Auto refresh after (sec.)', 'wtb_seo'),
			array($this, 'create_auto_refresh_time'), 
			'wtb_seo_settings',
			'wtb_seo_settings_ar_section'	
		);
	}
	
	/**
	 * renders plugin settings page
	 */
	function renderSettingsPage()
	{
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		} ?>

		<div class="wrap">
			<?php screen_icon(); ?>
			<h2><?php echo __('OnPage Post SEO Settings', 'wtb_seo'); ?></h2>
			
			<form method="post" action="options.php">
				
				<?php
					settings_fields('wtb_seo_settings_main_group');	
					do_settings_sections('wtb_seo_settings');
				?>
				
				<?php submit_button(); ?>
			</form>
		</div>
		<?php 
	}
	
	/**
	 * check input from settings page
	 * @param type $input
	 * @return type
	 */
	public function sanitize($input)
	{
		$ideal_density = round((float)str_replace(',', '.', $input['ideal_density']), 2);
		if ($ideal_density) {
			if ($ideal_density < 0) {
				$ideal_density = 3;
			}
			if ($ideal_density > 100) {
				$ideal_density = 100;
			}
			if (get_option('wtb_seo_ideal_density') === FALSE) {
				add_option('wtb_seo_ideal_density', $ideal_density);
			} else {
				update_option('wtb_seo_ideal_density', $ideal_density);
			}
		}
		
		$ideal_lenght = (int)$input['ideal_lenght'];
		if ($ideal_lenght) {
			if ($ideal_lenght < 0) {
				$ideal_lenght = 0;
			}
			if (get_option('wtb_seo_ideal_lenght') === FALSE) {
				add_option('wtb_seo_ideal_lenght', $ideal_lenght);
			} else {
				update_option('wtb_seo_ideal_lenght', $ideal_lenght);
			}
		}

		$auto_refresh_time = (int)$input['auto_refresh_time'];
		if ($auto_refresh_time > 999999) {
			$auto_refresh_time = 999999;
		} else if ($auto_refresh_time < 1) {
			$auto_refresh_time = 1;
		}
		
		return array(
			'cpt' => $input['cpt'],
			'to_check' => $input['to_check'],
			'disable_auto_refresh' => (int)$input['disable_auto_refresh'],
			'wdf_vs_density' => $input['wdf_vs_density'],
			'auto_refresh_time' => $auto_refresh_time,
			'ideal_lenght' => $ideal_lenght,
			'ideal_density' => $ideal_density,
			'check_short_description' => (int)$input['check_short_description']
			);
	}
	
	/**
	 * render ideal density field
	 */
	public function create_an_ideal_density_field()
	{
		?><input type="text" id="" name="wtb_seo_main[ideal_density]" value="<?php echo get_option('wtb_seo_ideal_density');?>" />%	<?php
    }
	
	/**
	 * render ideal lenght field
	 */
	public function create_an_ideal_lenght_field()
	{
		?><input type="text" id="" name="wtb_seo_main[ideal_lenght]" value="<?php echo get_option('wtb_seo_ideal_lenght');?>" />
		<?php echo __('words', 'wtb_seo');
    }
	
	/**
	 * render custom post types selection fields
	 */
	public function create_an_custom_post_types_fields()
	{
		$settings = get_option('wtb_seo_main', array());
		$cptSettings = !empty($settings['cpt']) ? (array)$settings['cpt'] : array();
		foreach (get_post_types() as $cpt) {
			if (!in_array($cpt, array('attachment', 'revision', 'nav_menu_item'))) { ?>
				<input type="hidden" name="wtb_seo_main[cpt][<?php echo $cpt ?>]" value="-1" />
				<label>
					<input type="checkbox" name="wtb_seo_main[cpt][<?php echo $cpt ?>]" 
							<?php checked(!empty($cptSettings[$cpt]) and $cptSettings[$cpt] == 1)  ?>
						   value="1" /> 
					<?php echo $cpt; ?>
				</label><br />
				<?php
			}
		}
		
		echo '<br />';
		echo '<br />';
    }
	
	public function create_to_check_fields()
	{
		$settings = get_option('wtb_seo_main', array());
		$cptSettings = !empty($settings['to_check']) ? (array)$settings['to_check'] : array();
		foreach (array(
			'title' => __('Title tag', 'wtb_seo'),
			'h1' => __('H1 tag', 'wtb_seo'),
			'h2' => __('H2 tag', 'wtb_seo'),
			'h3' => __('H3 tag', 'wtb_seo'),
			'bold' => __('bold', 'wtb_seo'),
			'italic' => __('italicize', 'wtb_seo'),
			'underline' => __('underline', 'wtb_seo'),
			'alt' => __('picture', 'wtb_seo')
		) as $key => $txt) { ?>
			<input type="hidden" name="wtb_seo_main[to_check][<?php echo $key ?>]" value="0" />
			<label>
				<input type="checkbox" name="wtb_seo_main[to_check][<?php echo $key ?>]" 
						<?php checked(!isset($cptSettings[$key]) or $cptSettings[$key] == 1)  ?>
					   value="1" /> 
				<?php echo $txt; ?>
			</label><br />
			<?php
		}
		
		echo '<br />';
		echo '<br />';
    }
	
	public function create_check_short_description()
	{
		$settings = get_option('wtb_seo_main', array());
		$wooSettings = isset($settings['check_short_description']) ? (int)$settings['check_short_description'] : 0;
		?>
		<input type="hidden" name="wtb_seo_main[check_short_description]" value="0" />
		<input type="checkbox" name="wtb_seo_main[check_short_description]" value="1" <?php checked(!empty($wooSettings)) ?> />	<?php
		
		echo '<br />';
		echo '<br />';
    }
	
	public function create_auto_refresh_disable()
	{
		$settings = get_option('wtb_seo_main', array());
		$arSettings = isset($settings['disable_auto_refresh']) ? (int)$settings['disable_auto_refresh'] : 0;
		?>
		<input type="hidden" name="wtb_seo_main[disable_auto_refresh]" value="0" />
		<input type="checkbox" name="wtb_seo_main[disable_auto_refresh]" value="1" <?php checked(!empty($arSettings)) ?> />	<?php
    }
	
	public function create_auto_refresh_time()
	{
		$settings = get_option('wtb_seo_main', array());
		$arSettings = isset($settings['auto_refresh_time']) ? (int)$settings['auto_refresh_time'] : 15;
		?>
		<input type="text" name="wtb_seo_main[auto_refresh_time]" value="<?php echo $arSettings ?>" />	<?php
    }
    
    public function create_an_wdf_vs_density_field()
    {
        $settings = get_option('wtb_seo_main', array());
		$cptSettings = !empty($settings['wdf_vs_density']) ? $settings['wdf_vs_density'] : 'density';
        ?>
            
            <select name="wtb_seo_main[wdf_vs_density]">
                <option value="density" <?php echo selected($cptSettings, 'density') ?>>Density</option>
                <option value="wdf" <?php echo selected($cptSettings, 'wdf') ?>>WDF</option>
            </select>
            
        <?php
		
		echo '<br />';
		echo '<br />';
    }
}