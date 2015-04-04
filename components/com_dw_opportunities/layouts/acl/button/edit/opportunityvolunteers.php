<?php

defined('_JEXEC') or die;

JFactory::getLanguage()->load('com_dw_opportunities');

$layout = JFactory::getApplication()->input->get('layout', '', 'string');

$opportunity = $displayData['opportunity'];

$user = JFactory::getUser();

//Check if user can edit opportunity----------------------------------------
$canEditOpportunity = $user->authorise('core.edit', 'com_dw_opportunities');

if (!$canEditOpportunity && $user->authorise('core.edit.own', 'com_dw_opportunities'))
	$canEditOpportunity = $user -> id == $opportunity -> created_by;

?>

<?php if( $canEditOpportunity && $layout != 'dwopportunityvolunteers' ) : ?>

<?php if ( isset ( $opportunity -> responses ) && count( $opportunity -> responses ['items'] ) ): ?>

<a class="uk-button uk-button-success" href="<?php echo JRoute::_('index.php?option=com_donorwiz&view=dashboard&layout=dwopportunityvolunteers&Itemid=298&id='. $opportunity->id); ?>" title="<?php echo JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_VOLUNTEERS').': '.$opportunity->title; ?>" data-uk-tooltip>
	<i class="uk-icon-users"></i>
	(<?php echo count( $opportunity->responses ['items']);?>)
</a>

<?php endif;?>

<?php endif; ?>