<?php

defined('_JEXEC') or die;

$layout = JFactory::getApplication()->input->get('layout', '', 'string');

JFactory::getLanguage()->load('com_dw_opportunities');

$opportunity = $displayData['opportunity'];

$user = JFactory::getUser();

//Check if user can edit opportunity----------------------------------------
$canEditOpportunity = $user->authorise('core.edit', 'com_dw_opportunities');

if (!$canEditOpportunity && $user->authorise('core.edit.own', 'com_dw_opportunities'))
	$canEditOpportunity = $user -> id == $opportunity -> created_by;

?>

<?php if( $canEditOpportunity ) : ?>

<a class="uk-button uk-button-primary" href="<?php echo JRoute::_('index.php?option=com_donorwiz&view=dashboard&layout=dwopportunityform&id=' . $opportunity->id); ?>" title="<?php echo JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_WIZARD_EDIT').': '.$opportunity->title; ?>" data-uk-tooltip>
	<i class="uk-icon-edit"></i>
</a>

<?php endif; ?>