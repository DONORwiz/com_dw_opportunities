<?php

// no direct access
defined('_JEXEC') or die;

$item = $displayData['item'];

$item_date_start = ( $item -> date_start == '' || $item -> date_start == '0000-00-00' ) ? null : $item -> date_start ;
$item_date_end = ( $item -> date_end == '' || $item -> date_end == '0000-00-00' ) ? null : $item -> date_end ;

$date_start = ( $item_date_start ) ? JFactory::getDate($item -> date_start)->format('D, d M Y') : null ;
$date_end = ( $item_date_end ) ? JFactory::getDate($item -> date_end)->format('D, d M Y') : null  ;

$item_time_start = ( $item -> time_start == '' || $item -> time_start == '00:00:00' ) ? null : $item -> time_start ;
$item_time_end = ( $item -> time_end == '' || $item -> time_end == '00:00:00' ) ? null : $item -> time_end ;

$time_start = ( $item_time_start && $item_date_start ) ? JFactory::getDate('0000-00-00 '.$item -> time_start)->format('H:i') : null ;
$time_end = ( $item_time_end && $item_date_end ) ? JFactory::getDate('0000-00-00 '.$item -> time_end)->format('H:i') : null ;
?>

<div class="uk-text-center">

<?php if ( !$date_start && !$date_end ):?>
	<i class="uk-icon-smile-o uk-icon-medium"></i>
	<div><?php echo JText::_('COM_DW_OPPORTUNITIES_SCHEDULE_FLEXIBLE');?></div>
<?php else: ?>

	
	<i class="uk-icon-calendar uk-icon-medium"></i> 
	<?php if( $date_start ) :?>
		<div>
			<?php echo JText::_('COM_DW_OPPORTUNITIES_DATE_FROM_LOWER').' '. $date_start;?>
			<?php if( $time_start ) :?>
			<span class="time start"><?php echo JText::_('COM_DW_OPPORTUNITIES_TIME_LOWER').' '. $time_start;?></span>
			<?php endif;?>
		</div>
	<?php endif;?>
	<?php if( $date_end ) :?>
		<div>
			<?php echo JText::_('COM_DW_OPPORTUNITIES_DATE_TO_LOWER').' '. $date_end;?>
			<?php if( $time_end ) :?>
			<span class="time start"><?php echo JText::_('COM_DW_OPPORTUNITIES_TIME_LOWER').' '. $time_end;?></span>
			<?php endif;?>
		</div>
	<?php endif;?>
<?php endif;?>

</div>