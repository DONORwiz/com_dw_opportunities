<?php

defined('_JEXEC') or die;

JFactory::getLanguage()->load('com_dw_opportunities');

$opportunity = $displayData['opportunity'];

$user = JFactory::getUser();

//Check if user can edit.state opportunity----------------------------------------
$canEditStateOpportunity = $user->authorise('core.edit.state', 'com_dw_opportunities');

?>

<?php if ( $canEditStateOpportunity && !is_null ( $opportunity->state ) ) : ?>

<a class="uk-button uk-button-link uk-text-muted trashed" href="#" title="<?php echo JText::_( 'COM_DW_OPPORTUNITIES_OPPORTUNITY_WIZARD_TRASH' );?>" data-uk-tooltip>
	<i class="uk-icon-trash-o uk-icon-small"></i>
</a>

<?php endif; ?>