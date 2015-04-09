<?php 

defined('_JEXEC') or die;

$items = $displayData['items'];

$created_by = ( isset ( $displayData ['created_by'] ) ) ? $displayData ['created_by'] : null ;

?>

<?php if ( $items ) : ?>

	<div class="uk-panel uk-panel-box">

	<?php echo $displayData['title'];?>

	<ul class="uk-list uk-list-line">

	<?php foreach ( $items as $i => $item) : ?>

		<?php 

		if( $item->category == 'virtual')
		{
			$iconClass = 'uk-icon-laptop';
			$categoryDescr = JText::_('COM_DW_OPPORTUNITIES_VIRTUAL_DESCRIPTION');
		}
		else
		{
			$iconClass = 'uk-icon-map-marker uk-icon-small';
			$categoryDescr = $item->address;
		}

		?>

		<li>

			<i class="<?php echo $iconClass;?> uk-margin-small-right"></i> 

			<a class="uk-text-primary" 
				href="<?php echo JRoute::_('index.php?option=com_dw_opportunities&view=dwopportunity&Itemid=261&id='.$item->id); ?>" title="<?php echo $categoryDescr;?>" data-uk-tooltip>
				<?php echo $item->title;?>
			</a>
			
		</li>
		
	<?php endforeach; ?>

	</ul>

	<?php if ( $created_by ) : ?>

	<a class="uk-button uk-button-blank uk-button-mini" href="<?php echo JRoute::_('index.php?filter[created_by]='.$created_by.'&Itemid='. JFactory::getApplication()->getMenu()->getItems( 'link', 'index.php?option=com_dw_opportunities&view=dwopportunities', true )->id );?>">
		<?php echo JText::sprintf('COM_DW_OPPORTUNITIES_ALL_FROM', JFactory::getUser( $created_by )-> name );?>
	</a>

	<?php endif;?>

	</div>

<?php endif;?>