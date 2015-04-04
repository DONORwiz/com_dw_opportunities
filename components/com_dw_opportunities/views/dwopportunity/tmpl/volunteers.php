<?php
 
// no direct access
defined('_JEXEC') or die;

$item = $this -> item ;

JFactory::getLanguage()->load('com_donorwiz');
JFactory::getLanguage()->load('com_dw_opportunities_responses');
JFactory::getLanguage()->load('com_dw_opportunities_responses_statuses');

JHtml::_('jquery.framework');

$script = array();

$script[] = 'var item_save_success = "'.JText::_('COM_DW_OPPORTUNITIES_ITEM_SAVE_SUCCESS').'";';
$script[] = 'var item_save_fail = "'.JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_ITEM_SAVE_FAIL').'";';
$script[] = 'var item_unpublished_warning = "'.JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_ITEM_UNPUBLISHED_WARNING').'";';
$script[] = 'var item_published_message = "'.JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_ITEM_PUBLISHED_MESSAGE').'";';

JFactory::getDocument()->addScriptDeclaration( implode( "\n" , $script ) );

JHtml::script(Juri::base() . 'media/com_donorwiz/js/list.js');
JHtml::script(Juri::base() . 'media/com_donorwiz/libs/js/listjs/list.min.js');

?>

<div id="opportunityvolunteers" class="uk-article">

	
	<div class="uk-text-right">
		<a class="uk-button uk-button-link uk-text-danger" href="<?php echo JRoute::_('index.php?Itemid='. JFactory::getApplication()->getMenu()->getItems( 'link', 'index.php?option=com_donorwiz&view=dashboard&layout=dwopportunities', true )->id );?>">
			<i class="uk-icon-long-arrow-left uk-icon-small"></i>
			<span class="uk-hidden-small uk-margin-small-left"><?php echo JText::_( 'COM_DW_OPPORTUNITIES_OPPORTUNITY_WIZARD_CANCEL' );?></span>
		</a>	
		
		<?php echo JLayoutHelper::render( 'edit.opportunity', array ( 'opportunity' => $item ) , JPATH_ROOT .'/components/com_dw_opportunities/layouts/acl/button' , null ); ?>
	
		<a class="uk-button uk-button-link" target="_blank" href="<?php echo JRoute::_('index.php?option=com_dw_opportunities&view=dwopportunity&Itemid=261&&id='. $item->id); ?>" title="<?php echo JText::_( 'COM_DW_OPPORTUNITIES_OPPORTUNITY_WIZARD_PREVIEW' );?>" data-uk-tooltip>
			<i class="uk-icon-eye uk-icon-small"></i>
		</a>
	</div>
	

	<h1 class="uk-article-title uk-text-center">
		<span><?php echo JText::_('COM_DW_OPPORTUNITIES_RESPONSES_MY_VOLUNTEERS'); ?>:</span> <?php echo $item->title; ?>
	</h1>
	
		<hr>


	<?php echo JLayoutHelper::render( 'statistics' , array( 'statistics' => $item->responses['statistics'] ) , JPATH_ROOT .'/components/com_dw_opportunities/layouts/volunteers' , null ); ?>	

	<?php if( $item -> responses ['items'] ): ?>

	<?php echo JLayoutHelper::render( 'responses' , array( 'items'=> $item -> responses ['items'] ) , JPATH_ROOT .'/components/com_dw_opportunities/layouts/volunteers' , null ); ?>	

	<?php endif;?>

</div>