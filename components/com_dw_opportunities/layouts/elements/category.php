<?php

defined('_JEXEC') or die;

$app = JFactory::getApplication();
$jinput = $app->input;
$dashboard = ( $jinput->get('dashboard', '', 'string'=='true') ) ? true : null ;

$item = $displayData['item'];
?>

<?php if( $item->category == 'virtual') :?>
	
	<div data-uk-tooltip="{pos:'right'}" title="<?php echo JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_VIRTUAL_TOOLTIP');?>">
		<i class="uk-icon-laptop uk-icon-small"></i> 
		<span><?php echo JText::_('COM_DW_OPPORTUNITIES_VIRTUAL_DESCRIPTION');?></span>
	</div>
	
<?php else: ?>
	<div data-uk-tooltip="{pos:'right'}" title="<?php echo JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_LOCAL_TOOLTIP');?>">
		<i class="uk-icon-map-marker uk-icon-medium"></i> 
		<span><?php echo $item->address; ?></span>
		
		<?php if(!$dashboard):?>
		<a class="uk-hidden-small" href="javascript:void(0)" onclick="zoomMapByCoordinates(<?php echo $this->escape($item->lat); ?>,<?php echo $this->escape($item->lng); ?>);return false;"><?php echo JText::_('COM_DW_OPPORTUNITIES_VIEW_ON_MAP');?></a>
		<a class="uk-hidden-large uk-hidden-medium uk-icon-button uk-icon-mail-forward" target="_blank" href="http://maps.google.com/maps?z=12&t=m&q=loc:<?php echo $this->escape($item->lat); ?>+<?php echo $this->escape($item->lng); ?>"><i class="uk-icon uk-icon-map"></i></a>
		<?php endif; ?>
		
		<?php if($dashboard):?>
		<a target="_blank" href="http://maps.google.com/maps?z=12&t=m&q=loc:<?php echo $this->escape($item->lat); ?>+<?php echo $this->escape($item->lng); ?>"><?php echo JText::_('COM_DW_OPPORTUNITIES_VIEW_ON_MAP');?></a>
		<?php endif; ?>
	</div>
<?php endif; ?>