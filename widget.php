<?php
if (! function_exists ( 'repupress_add_dashboard_widgets' )) {
	
	add_action ( 'wp_dashboard_setup', 'repupress_add_dashboard_widgets' );
	function repupress_add_dashboard_widgets() {
		add_meta_box ( 'repupress_dashboard_widget', 'On-Page and Post SEO Support', 'repupress_dashboard_widget_function', 'dashboard', 'side', 'high' );
	}
	
	/**
	 * Create the function to output the contents of our Dashboard Widget.
	 */
	function repupress_dashboard_widget_function() {
		
		 
		$purl = plugins_url('',__FILE__);
		 
		?>

<table>

	<tbody>
		<tr>
		
			<td>
				<img style="float: left; margin-bottom: 20px;" src="<?php echo $purl ?>/img/widget/help.png">
			</td>

			<td>

				<p>
					If you need help with this Plugin or have any questions, please feel free to <a href="http://www.repupress.com/contact-us/">contact us</a>.
				</p>

			</td>
		</tr>

		<tr>
			
			<td></td>
		
			<td><p></p>
				<div class="more-work">
					
					<div class="clear">
						<!-- -->
					</div>
					
				</div>
				<p></p></td>
		</tr>
		
		<tr><td>&nbsp;</td></tr>

	</tbody>
</table>

<script type="text/javascript">
	jQuery('#wp_valvepress_widget_hide').click(function(){
		jQuery('#repupress_dashboard_widget-hide').trigger('click');
	});
</script>

<?php
	} // function of the widget
}//function exists
