<?php

defined('_JEXEC') or die;

$app = JFactory::getApplication();
$jinput = $app->input;
$dashboard = ( $jinput->get('dashboard', '', 'string'=='true') ) ? true : null ;

$item = $displayData['item'];
?>

<div class="uk-text-center">

<?php if( $item->category == 'virtual') :?>
	
	<i class="uk-icon-laptop uk-icon-medium"></i> 
	<div><?php echo JText::_('COM_DW_OPPORTUNITIES_VIRTUAL_DESCRIPTION');?></div>
	
<?php else: ?>

	<i class="uk-icon-map-marker uk-icon-medium"></i> 
	<div><?php echo $item->address; ?></div>
	
	<?php if(!$dashboard):?>
	<a class="uk-hidden-small uk-hidden-medium" href="javascript:void(0)" onclick="zoomMapByCoordinates(<?php echo $this->escape($item->lat); ?>,<?php echo $this->escape($item->lng); ?>);return false;">Προβολή στον χάρτη</a>
	<a class="uk-hidden-large" target="_blank" href="http://maps.google.com/maps?z=12&t=m&q=loc:<?php echo $this->escape($item->lat); ?>+<?php echo $this->escape($item->lng); ?>">Προβολή στον χάρτη</a>
	<?php endif; ?>
	
	<?php if($dashboard):?>
	<a target="_blank" href="http://maps.google.com/maps?z=12&t=m&q=loc:<?php echo $this->escape($item->lat); ?>+<?php echo $this->escape($item->lng); ?>">Προβολή στον χάρτη</a>
	<?php endif; ?>
	
<?php endif; ?>

</div>
