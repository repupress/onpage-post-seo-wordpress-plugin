<?php /* @var $this wtb_seo_box */ ?>

<div class="wp-seo-box-header wp-seo-box-general">
    <div class="wp-seo-box-header-wrapper">
		
		<div class="info">
			<b><?php echo __('General', 'wtb_seo') ?></b> <?php echo __('post optimisation', 'wtb_seo') ?>
		</div>

		<table border="0" class="wtb-seo-results" cellpadding="0" cellspacing="0">
            <?php $hasErrors = false; ?>
			<?php foreach ($this->getParamsNames() as $key => $value) { ?>
				<?php if (array_key_exists($key, $this->parameters)) { ?>
					<?php if (!empty($value[$this->parameters[$key]])) { ?>
						<?php if ((int)$this->parameters[$key]) { ?>
                            <?php continue; ?>
							<tr class="active">
								<td class="wtb-seo-results-icon"><span> </span></td>
								<td><?php echo $value[$this->parameters[$key]] ?></td>
								<td class="wtb-seo-results-faq"><span title="<?php echo $this->getParamsDescription($key) ?>"> </span></td>
							</tr>
						<?php } else { ?>
                            <?php $hasErrors = true; ?>
							<tr>
								<td class="wtb-seo-results-icon"><span> </span></td>
								<td><?php echo $value[$this->parameters[$key]] ?></td>
								<td class="wtb-seo-results-faq"><span title="<?php echo $this->getParamsDescription($key) ?>"> </span></td>
							</tr>
						<?php } ?>
					<?php } ?>
				<?php } ?>
			<?php } ?>
                            
            <?php if (!$hasErrors) { ?>
                <tr class="active">
                    <td class="wtb-seo-results-icon"><span> </span></td>
                    <td><?php echo __('Your post ist perfectly optimized', 'wtb_seo') ?></td>
                    <td class="wtb-seo-results-faq"></td>
                </tr>
            <?php } ?>
		</table>
        
        <?php 
        $score = 0;
        if (count($this->_sections) > 0) {
            foreach ($this->_sections as $sect) {
                $score += $sect->score;
            }
            $score /= count($this->_sections);
        }
        ?>
        
        <div class="main-info">
            <div class="<?php echo $this->getScoreColor($score) ?>">
                <span class="unit"><?php echo __('Total score', 'wtb_seo') ?></span>
                <span class="number"><?php echo wtb_seo_helper::formatNumber($score) ?>%</span>
            </div>
        </div>
	</div>
	
</div> 