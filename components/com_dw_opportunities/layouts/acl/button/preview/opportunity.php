<?php

defined('_JEXEC') or die;

JFactory::getLanguage()->load('com_dw_opportunities');

$opportunity = $displayData['opportunity'];

?>

<a class="uk-button uk-button-blank" href="<?php echo JRoute::_('index.php?option=com_dw_opportunities&view=dwopportunity&Itemid=261&&id=' . $opportunity->id); ?>" title="<?php echo JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_WIZARD_PREVIEW_OPPORTUNITY'); ?>" data-uk-tooltip>
	<i class="uk-icon-eye"></i>
</a>

