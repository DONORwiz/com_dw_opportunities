<?php

defined('_JEXEC') or die;

?>

<div id="opportunityresponsesfilters" class="uk-form">

	<div class="uk-grid uk-grid-small" data-uk-grid-margin>
		
		<div class="uk-width-medium-1-1 uk-width-large-1-2">
			<input class="uk-form-large uk-width-1-1 search" type="text" placeholder="<?php echo JText::_('COM_DW_OPPORTUNITIES_RESPONSES_VOLUNTEERS_SEARCH'); ?>" class="search">
		</div>

		<div class="uk-width-medium-1-1 uk-width-large-1-2">
		
			<div class="uk-grid uk-grid-small">
				
				<div class="uk-width-1-2">
				
					<select class="uk-form-large uk-width-1-1 created-sort">
						<option value="NEWEST"><?php echo JText::_('COM_DW_OPPORTUNITIES_RESPONSES_SORT_BY_DATE_DESC'); ?></option>
						<option value="OLDEST"><?php echo JText::_('COM_DW_OPPORTUNITIES_RESPONSES_SORT_BY_DATE_ASC'); ?></option>
					</select>

				</div>
			
				<div class="uk-width-1-2">
					
					<select class="uk-form-large status-filter uk-width-1-1">
						
						<option value=""><?php echo JText::_('COM_DW_OPPORTUNITIES_RESPONSES_SORT_BY_STATUS'); ?></option>
						<option value="ALL"><?php echo JText::_('JALL'); ?></option>
						<option value="pending"><?php echo JText::_('COM_DW_OPPORTUNITIES_RESPONSES_STATUSES_PENDING'); ?></option>
						<option value="accepted"><?php echo JText::_('COM_DW_OPPORTUNITIES_RESPONSES_STATUSES_ACCEPTED'); ?></option>
						<option value="declined"><?php echo JText::_('COM_DW_OPPORTUNITIES_RESPONSES_STATUSES_DECLINED'); ?></option>

					</select>
					
				</div>
			
			</div>
			
		</div>

	</div>
	
</div>

<script type="text/javascript">

var hash = window.location.hash;

jQuery(document).ready(function () 
{

	var hash = jQuery(window.location.hash);

	hash.addClass('uk-animation-fade');

	for (i = 0; i < 20; i++) 
	{ 
		setTimeout(function(){hash.toggleClass('uk-panel-box-primary'); }, i*1000);
	}

});

</script>