<?php /* @var $this wtb_seo_box_section */  ?>
<h3 class="section-header section-no-<?php echo $this->getNo() ?>"><?php echo $this->keyword ?></h3>

<div class="section-no-<?php echo $this->getNo() ?>">
	
	<?php /* ?><div class="main-info">
		<div class="left-info">
			<span class="unit"><?php echo __('WDF', 'wtb_seo') ?></span>
			<span class="number"><?php echo wtb_seo_helper::formatNumber($this->wdf) ?>%</span>
			<input type="hidden" name="<?php echo $this->getInfoKey('wdf') ?>" value="<?php echo $this->score ?>" />
		</div>
		<div class="right-info">
			<span class="unit"><?php echo __('IDF', 'wtb_seo') ?></span>
			<span class="number"><?php echo wtb_seo_helper::formatNumber($this->idf) ?>%</span>
			<input type="hidden" name="<?php echo $this->getInfoKey('idf') ?>" value="<?php echo $this->idf ?>" />
		</div>
	</div>*/ ?>
	
	<div class="main-info">
        
        <div class="left-info <?php echo $this->getScoreColor() ?>" title="<?php echo __('Try to get a score near 100%. If you get a green checkmark on each criteria, you have the best chances to get to 100%.', 'wtb_seo') ?>">
            <span class="unit"><?php echo __('Score', 'wtb_seo') ?></span>
            <span class="number"><?php echo wtb_seo_helper::formatNumber($this->score) ?>%</span>
            <input type="hidden" name="<?php echo $this->getInfoKey('score') ?>" value="<?php echo ($this->score) ?>" size="25" />
        </div>
        
        <?php $s = get_option('wtb_seo_main', array());
        if (empty($s['wdf_vs_density']) or $s['wdf_vs_density'] == 'density') { ?>
            <div class="right-info <?php echo $this->getDensityColor() ?>" title="<?php echo __('A keyword Density of 3 % is ideal – that means if your text has a length of 250 words, your defined keyword should appear 9 times.', 'wtb_seo') ?>">
                <span class="unit"><?php echo __('Keyword Density', 'wtb_seo') ?></span>
                <span class="number"><?php echo wtb_seo_helper::formatNumber($this->density) ?>%</span>
                <input type="hidden" name="<?php echo $this->getInfoKey('density') ?>" value="<?php echo ($this->density) ?>" size="25" />
            </div>
        <?php } else { ?>
            <div class="right-info wdf-normal">
                <span class="unit"><?php echo __('WDF', 'wtb_seo') ?></span>
                <span class="number"><?php echo wtb_seo_helper::formatNumber($this->wdf) ?>%</span>
                <input type="hidden" name="<?php echo $this->getInfoKey('wdf') ?>" value="<?php echo $this->score ?>" />
            </div>
        <?php } ?>
	</div>

	<input type="hidden" name="<?php echo $this->getInfoKey('keyword') ?>" value="<?php echo ($this->keyword) ?>" size="25" />

	<table border="0" class="wtb-seo-results" cellpadding="0" cellspacing="0">
		<?php foreach ($this->getParamsNames() as $key => $value) { ?>
			<?php if (!$this->isParamAllowed($key)) continue; ?>
			<?php if (array_key_exists($key, $this->parameters) and $this->parameters[$key]) { ?>
				<tr class="active">
					<td class="wtb-seo-results-icon"><span> </span></td>
					<td>
						<?php echo $value['yes'] ?>
						<input type="hidden" value="1" name="<?php echo $this->getInfoKey('checkboxes').'['.$key.']' ?>" />
					</td>
					<td class="wtb-seo-results-faq"><span title="<?php echo $this->getParamsDescription($key) ?>"> </span></td>
				</tr>
			<?php } else { ?>
				<tr>
					<td class="wtb-seo-results-icon"><span> </span></td>
					<td><?php echo $value['no'] ?>
						<input type="hidden" value="0" name="<?php echo $this->getInfoKey('checkboxes').'['.$key.']' ?>" />
					</td>
					<td class="wtb-seo-results-faq"><span title="<?php echo $this->getParamsDescription($key) ?>"> </span></td>
				</tr>
			<?php } ?>
		<?php } ?>
	</table>
</div>