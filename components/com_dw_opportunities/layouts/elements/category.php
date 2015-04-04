<?php

defined('_JEXEC') or die;

$app = JFactory::getApplication();
$jinput = $app->input;
$dashboard = ( $jinput->get('dashboard', '', 'string'=='true') ) ? true : null ;

$item = $displayData['item'];
?>


<?php if( $item->category == 'virtual') :?>
	
	<i class="uk-icon-laptop uk-icon-small"></i> 
	<span><?php echo JText::_('COM_DW_OPPORTUNITIES_VIRTUAL_DESCRIPTION');?></span>
	
<?php else: ?>

	<i class="uk-icon-map-marker uk-icon-medium"></i> 
	<span><?php echo $item->address; ?></span>
	
	<?php if(!$dashboard):?>
	<a class="uk-button uk-button-small uk-button-blank uk-hidden-small uk-hidden-medium" href="javascript:void(0)" onclick="zoomMapByCoordinates(<?php echo $this->escape($item->lat); ?>,<?php echo $this->escape($item->lng); ?>);return false;"><?php echo JText::_('COM_DW_OPPORTUNITIES_VIEW_ON_MAP');?></a>
	<a class="uk-button uk-button-small uk-button-blank uk-hidden-large" target="_blank" href="http://maps.google.com/maps?z=12&t=m&q=loc:<?php echo $this->escape($item->lat); ?>+<?php echo $this->escape($item->lng); ?>"><?php echo JText::_('COM_DW_OPPORTUNITIES_VIEW_ON_MAP');?></a>
	<?php endif; ?>
	
	<?php if($dashboard):?>
	<a target="_blank" href="http://maps.google.com/maps?z=12&t=m&q=loc:<?php echo $this->escape($item->lat); ?>+<?php echo $this->escape($item->lng); ?>"><?php echo JText::_('COM_DW_OPPORTUNITIES_VIEW_ON_MAP');?></a>
	<?php endif; ?>
	
<?php endif; ?>

