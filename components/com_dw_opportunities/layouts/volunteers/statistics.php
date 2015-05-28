<?php

// no direct access
defined('_JEXEC') or die;

$statistics = $displayData['statistics'];

?>

<div id="opportunity_responses_statistics" class="statistics">

	<div class="uk-grid uk-margin">

		<div class="uk-width-1-1 uk-width-medium-1-3">
			<div class="uk-panel uk-panel-box uk-text-center">
				<div><span class="uk-badge uk-badge-notification uk-badge-warning number uk-text-large"><?php echo $statistics['pending'] ;?></span></div>
				<div>
					<a href="#" onclick="jQuery('select.status-filter option[value=pending]').prop('selected', 'selected');jQuery('select.status-filter').trigger('change');return false;">
						<span class="uk-text-warning"><?php echo JText::_('COM_DW_OPPORTUNITIES_RESPONSES_AWAITING'); ?></span>
					</a>
				</div>
			</div>
		</div>
		<div class="uk-width-1-1 uk-width-medium-1-3">
			<div class="uk-panel uk-panel-box uk-text-center">
				<div><span class="uk-badge uk-badge-notification uk-badge-success number uk-text-large"><?php echo $statistics['accepted'] ;?></span></div>
				<div>
					<a href="#" onclick="jQuery('select.status-filter option[value=accepted]').prop('selected', 'selected');jQuery('select.status-filter').trigger('change');return false;">
						<span class="uk-text-success"><?php echo JText::_('COM_DW_OPPORTUNITIES_RESPONSES_APPROVED'); ?></span>
					</a>
				</div>
			</div>
		</div>
		<div class="uk-width-1-1 uk-width-medium-1-3">
			<div class="uk-panel uk-panel-box uk-text-center">
				<div><span class="uk-badge uk-badge-notification uk-badge-danger number uk-text-large"><?php echo $statistics['declined'] ;?></span></div>
				<div>
					<a href="#" onclick="jQuery('select.status-filter option[value=declined]').prop('selected', 'selected');jQuery('select.status-filter').trigger('change');return false;">
						<span class="uk-text-danger"><?php echo JText::_('COM_DW_OPPORTUNITIES_RESPONSES_REJECTED'); ?></span>
					</a>
				</div>
			</div>
		</div>
	</div>
	
</div>