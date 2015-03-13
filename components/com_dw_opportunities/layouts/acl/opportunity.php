<?php

defined('_JEXEC') or die;
$app = JFactory::getApplication();
$jinput = $app->input;
$dashboard = ( $jinput->get('dashboard', '', 'string'=='true') ) ? true : null ;

$user = JFactory::getUser();
$item = $displayData['item'];

?>

<?php if( $dashboard  ) :

//Check if user can edit opportunity item----------------------------------------
$canEdit = $user->authorise('core.edit', 'com_dw_opportunities');

if (!$canEdit && $user->authorise('core.edit.own', 'com_dw_opportunities'))
	$canEdit = $user->id == $item->created_by;

?>

<div class="uk-width-1-1 uk-margin acltoolbar uk-text-center">
	<?php if($canEdit) :?>
	<a class="uk-button uk-button-mini uk-button-primary" href="<?php echo JRoute::_('index.php?option=com_donorwiz&view=dashboard&layout=dwopportunityform&Itemid=298&id='.(int) $item->id); ?>" >
	<i class="uk-icon-edit"></i>
	<?php echo JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_WIZARD_EDIT'); ?>
	</a>

	<a class="uk-button uk-button-mini uk-button-success" href="<?php echo JRoute::_('index.php?option=com_donorwiz&view=dashboard&layout=dwopportunityvolunteers&Itemid=298&id='.(int) $item->id); ?>" >
	<i class="uk-icon-users"></i>
	<?php echo JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_VOLUNTEERS'); ?>
	</a>
	<?php endif; ?>
</div>

<?php endif; ?>