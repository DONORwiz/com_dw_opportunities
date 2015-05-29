<?php

defined('_JEXEC') or die;

$app = JFactory::getApplication();

$jinput = $app->input;

$jinputFilter = $jinput->get('filter','','array');

$isDashboard = $this->state->get("filter.dashboard") ;

?>

<div class="uk-grid">
	
	<?php if(!$isDashboard) :?>
	<div class="uk-width-large-4-10 uk-hidden-medium uk-hidden-small" style="min-height:1px;">
	
		<?php echo JLayoutHelper::render('multiple', array ( 'items' => $this->items , 'widthClass' => 'uk-width-4-10' ) , JPATH_ROOT .'/components/com_donorwiz/layouts/map' , null ); ?>

	</div>
	<?php endif;?>

	<div class="<?php if($isDashboard) { echo 'uk-width-1-1' ;} else { echo 'uk-width-large-6-10 uk-width-medium-1-1';}?>">
		
		<?php echo JLayoutHelper::render('default_filter', array('view' => $this), dirname(__FILE__)); ?>

		<?php echo JLayoutHelper::render( 
			'export.items', 
			array ( 
				'items' => $this->items , 
				'component' => 'com_dw_opportunities' , 
				'fields' => 'id,state,title,created,category,causearea,skills,description,address' ,
				'filename' => 'donorwiz_opportunities_'.JFactory::getUser() -> name.'_'.JFactory::getDate()->format('d M Y') 
			) , 
			JPATH_ROOT .'/components/com_dw_opportunities/layouts' , 
			null 
		); ?>
		
		<h1>

		<?php if( $this->pagination->total == 0 ):?>
		<?php echo JText::_('COM_DW_OPPORTUNITIES_VOLUNTEERING_OPPORTUNITIES_NOT_FOUND'); ?>
		<?php endif;?>

		<?php if( $this->pagination->total == 1 ):?>
		<?php echo JText::_('COM_DW_OPPORTUNITIES_VOLUNTEERING_OPPORTUNITIES_ONE_FOUND'); ?>
		<?php endif;?>

		<?php if( $this->pagination->total > 1 ):?>
		<?php echo JText::_('COM_DW_OPPORTUNITIES_WE_FOUND').' '.$this->pagination->total.' '.JText::_('COM_DW_OPPORTUNITIES_VOLUNTEERING_OPPORTUNITIES_FOUND') ?>
		<?php endif;?>

		</h1>
		
		<?php if ( $this->items ) : ?>

		<?php foreach ( $this->items as $i => $item) : ?>

			<?php echo JLayoutHelper::render('teaseritem.opportunity', array ( 'item' => $item , 'isDashboard' => $isDashboard , 'descrLength' => 0 ) , JPATH_ROOT .'/components/com_dw_opportunities/layouts' , null ); ?>

		<?php endforeach; ?>

		<?php endif; ?>

		<?php 

		echo $this->pagination->getPagesLinks(); 

		?>

	</div>
</div>