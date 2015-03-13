<?php

defined('_JEXEC') or die;

$app = JFactory::getApplication();
$jinput = $app->input;

$dashboard = ( $jinput->get('dashboard', '', 'string'=='true') ) ? true : null ;
$opportunities = $this->items;
$pagination = $this->pagination;
$beneficiaries = $this->beneficiaries;
$causeareas = $this->causeareas;
$resetlink = $this->resetlink;

?>

<div class="uk-grid">
	
	<?php if(!$dashboard) :?>
	<div class="uk-width-large-4-10 uk-hidden-medium uk-hidden-small">
	
		<?php echo JLayoutHelper::render('multiple', array ( 'items' => $opportunities , 'widthClass' => 'uk-width-4-10' ) , JPATH_ROOT .'/components/com_donorwiz/layouts/map' , null ); ?>

	</div>
	<?php endif;?>

	<div class="<?php if($dashboard) { echo 'uk-width-1-1' ;} else { echo 'uk-width-large-6-10 uk-width-medium-1-1';}?>">
		
		<?php echo JLayoutHelper::render(
			'filters', 
			array ( 
				'beneficiaries' => $beneficiaries, 
				'causeareas' => $causeareas, 
				'resetlink' => $resetlink, 
			), 
			JPATH_ROOT .'/components/com_dw_opportunities/layouts/list', 
			null 
		); ?>


		<h1>

		<?php if( $pagination->total == 0 ):?>
		<?php echo JText::_('COM_DW_OPPORTUNITIES_VOLUNTEERING_OPPORTUNITIES_NOT_FOUND'); ?>
		<?php endif;?>

		<?php if( $pagination->total == 1 ):?>
		<?php echo JText::_('COM_DW_OPPORTUNITIES_VOLUNTEERING_OPPORTUNITIES_ONE_FOUND'); ?>
		<?php endif;?>

		<?php if( $pagination->total > 1 ):?>
		<?php echo JText::_('COM_DW_OPPORTUNITIES_WE_FOUND').' '.$pagination->total.' '.JText::_('COM_DW_OPPORTUNITIES_VOLUNTEERING_OPPORTUNITIES_FOUND') ?>
		<?php endif;?>

		</h1>

		<?php if ($opportunities) : ?>

		<?php foreach ($opportunities as $i => $item) : ?>

			<?php echo JLayoutHelper::render('opportunity', array ( 'item' => $item , 'descrLength' => 0 ) , JPATH_ROOT .'/components/com_dw_opportunities/layouts/teaseritem' , null ); ?>

		<?php endforeach; ?>

		<?php endif; ?>

		<?php 

		echo $pagination->getPagesLinks(); 

		?>

	</div>
</div>