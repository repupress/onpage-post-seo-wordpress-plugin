<?php /* @var $this wtb_seo_box */ ?>
<div class="wp-seo-box-header">
	
	<div class="wp-seo-box-header-wrapper">
		<?php if ($this->showErrorOnEmptyContent or $this->showErrorOnEmptyTitle) { ?>
			<div class="info-error">
				<?php if ($this->showErrorOnEmptyTitle and $this->showErrorOnEmptyContent) { ?>
					<?php echo __("Please fill your post title and write something in the content area", 'wtb_seo') ?>
				<?php } else if ($this->showErrorOnEmptyContent) { ?>
					<?php echo __("Please write something in the contentarea", 'wtb_seo') ?>
				<?php } else { ?>
					<?php echo __("Please fill your post title", 'wtb_seo') ?>
				<?php } ?>
			</div>
		<?php } ?>
		
		<div class="info">
			<?php echo __('You may optimize up to <strong>3 Keywords</strong>', 'wtb_seo') ?>
			<?php if (count($this->_sections) < 3) { ?>
				<br />
				<?php echo __('Click on "+" to add Keyword', 'wtb_seo') ?>
			<?php } ?>
		</div>

		<?php if (count($this->_sections) > 0) { ?>
			<ul class="to-remove-keyword">
				<?php foreach (array_reverse($this->_sections) as $section) { ?>
					<input type="text" disabled="disabled" name="remove-keyword" value="<?php echo $section->keyword ?>" />
					<div class="remove-keyword-trigger" data-remove="<?php echo $section->getNo() ?>" title="<?php echo __('remove', 'wtb_seo') ?>"></div>
				<?php } ?>
			</ul>
		<?php } ?>

		<?php if (count($this->_sections) < 3) { ?>
			<input type="text" placeholder="<?php echo __('Add keyword...', 'wtb_seo') ?>" id="add-keyword" name="add-keyword" />
			<!--<textarea maxlength="100" placeholder="<?php echo __('Add keyword...', 'wtb_seo') ?>" id="add-keyword" name="add-keyword"></textarea>-->
			<div id="add-keyword-trigger"></div>
		<?php } ?>
	</div>
	
	<?php if (count($this->_sections) > 0) { ?>
		<div id="wp-seo-refresh"><span><?php echo __('Click to Refresh Keywords', 'wtb_seo') ?></span> <i></i></div>
	<?php } else { ?>
		<div id="wp-seo-refresh"><span><?php echo __('Click to Refresh', 'wtb_seo') ?></span> <i></i></div>
	<?php } ?>
		
	<?php $settings = get_option('wtb_seo_main', array());
	if (isset($settings['disable_auto_refresh']) ? (int)$settings['disable_auto_refresh'] : 0) { ?>
		<input type="hidden" id="disable-auto-refresh" value="1" />
	<?php } else { ?>
		<input type="hidden" id="auto-refresh-time" value="<?php echo isset($settings['auto_refresh_time']) ? (int)$settings['auto_refresh_time'] : 15 ?>" />
	<?php } ?>
		
</div>