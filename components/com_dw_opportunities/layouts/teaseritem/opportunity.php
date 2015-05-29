<?php

defined('_JEXEC') or die;

$item = $displayData['item'];
$isDashboard = $displayData['isDashboard'];

$descrLength = ( isset ( $displayData['descrLength'] ) ) ? $displayData['descrLength'] : 0 ;

$app = JFactory::getApplication();

$jinput = $app->input;

$jinputFilter = $jinput->get('filter','','array');

include_once JPATH_ROOT.'/components/com_community/libraries/core.php';
$created_by = CFactory::getUser( $item->created_by ) ;

$created_by_name = $created_by->getDisplayName();
$avatarUrl = $created_by->getThumbAvatar();

?>

<div class="uk-panel uk-panel-box uk-panel-blank uk-panel-border uk-panel-shadow volunteering-opportunity uk-margin-small teaser uk-visible-hover-inline<?php if( $item -> state == '0' ) echo ' uk-panel-transparent' ;?><?php echo ' featured_'.$item->featured; ?>"  data-title="<?php echo $this->escape($item->title); ?>" data-address="<?php echo $this->escape($item->address); ?>" data-lat="<?php echo $this->escape($item->lat); ?>" data-lng="<?php echo $this->escape($item->lng); ?>">

	<div class="uk-grid">
			
		<div class="uk-width-small-2-10 uk-width-large-1-6 uk-text-left-small uk-hidden-small">

			<a class="" href="<?php echo JRoute::_('index.php?option=com_dw_opportunities&view=dwopportunity&Itemid=261&id='.(int) $item->id); ?>" style="text-decoration:none!important">
				<img class="uk-thumbnail uk-border-circle uk-animation-slide-left" src="<?php echo $avatarUrl ; ?>" alt="<?php echo $created_by_name; ?>" title="<?php echo JText::_('COM_DW_OPPORTUNITIES_MORE_ABOUT_OPPORTUNITY');?> <?php echo $item->title; ?>" data-uk-tooltip>
			</a>

		</div>	

		<div class="uk-width-small-8-10 uk-width-large-5-6">
			
			<a <?php if ($isDashboard) echo 'target="_blank"';?> 
				href="<?php echo JRoute::_('index.php?option=com_dw_opportunities&view=dwopportunity&Itemid=261&id='.(int) $item->id); ?>"
			>
				<h2 class="uk-margin-remove">
				
					<?php echo $this->escape($item->title); ?> 
					<img class="uk-float-right" style="display:none;" onLoad="this.style.display='inline-block';" src="<?php echo Juri::base();?>media/com_donorwiz/images/mapicons/<?php echo $item->causearea;?>.png" title="<?php echo JText::_($item->causearea); ?>" data-uk-tooltip>
				</h2>
			</a>
			
			<?php echo JLayoutHelper::render( 'meta.opportunity' , array( 'created_by_id' => $this->escape($item->created_by) , 'item' => $item )  , JPATH_ROOT .'/components/com_dw_opportunities/layouts' , null ); ?>
			
			<div>			
			
			<?php if( $isDashboard  ) :?>

				<?php echo JLayoutHelper::render( 'edit.opportunity', array ( 'opportunity' => $item ) , JPATH_ROOT .'/components/com_dw_opportunities/layouts/acl/button' , null ); ?>
				<?php echo JLayoutHelper::render( 'edit.opportunityvolunteers', array ( 'opportunity' => $item ) , JPATH_ROOT .'/components/com_dw_opportunities/layouts/acl/button' , null ); ?>
				<?php echo JLayoutHelper::render( 'preview.opportunity', array ( 'opportunity' => $item ) , JPATH_ROOT .'/components/com_dw_opportunities/layouts/acl/button' , null ); ?>

				<?php if( $item->state == '0' ) :?>
					<span class="uk-text-danger"><?php echo JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_WIZARD_UNPUBLISHED');?></span>
				<?php endif; ?>
					
			<?php endif; ?>
			
			</div>
			<?php if( $descrLength != 0 ) : ?>
				<div class="uk-hidden-medium uk-hidden-small uk-margin-top"><?php echo substr( $item->description , 0, $descrLength).'...'; ?></div>
			<?php endif; ?>

			<?php if (!$isDashboard): ?>
			
			<div class="uk-grid uk-margin-small-top">
				
				<div class="uk-width-medium-1-1">
					<?php echo JLayoutHelper::render( 'category' , array( 'item' => $item ) , JPATH_ROOT .'/components/com_dw_opportunities/layouts/elements' , null ); ?>	
				</div>

				<div class="uk-width-medium-1-1 uk-margin-small-top">
					<?php echo JLayoutHelper::render( 'schedule' , array( 'item' => $item ) , JPATH_ROOT .'/components/com_dw_opportunities/layouts/elements' , null ); ?>	
				</div>		

			</div>
			
			<div class="uk-width-1-1 uk-hidden-small uk-margin-top  uk-grid">

				<div class="uk-width-1-2 uk-margin-small-bottom">

				<a class="uk-button uk-button-blank uk-width-1-1 uk-text-truncate readmore" href="<?php echo JRoute::_('index.php?option=com_dw_opportunities&view=dwopportunity&Itemid=261&id='.(int) $item->id); ?>" style="text-decoration:none!important">
					<?php echo JText::_('COM_DW_OPPORTUNITIES_READ_MORE');?>
				</a>	
				</div>

				<div class="uk-width-1-2 uk-hidden uk-text-right">
				<!-- www.addthis.com -->
				<div class="addthis_sharing_toolbox"></div>

				</div>

			</div>
			
			<?php endif;?>
		
		</div>	

		<div class="uk-width-1-1 uk-hidden-medium uk-hidden-large uk-margin-top">
		
			<a class="uk-button uk-button-blank uk-width-1-1" href="<?php echo JRoute::_('index.php?option=com_dw_opportunities&view=dwopportunity&Itemid=261&id='.(int) $item->id); ?>" style="text-decoration:none!important">
				<?php echo JText::_('COM_DW_OPPORTUNITIES_READ_MORE');?>
			</a>		
		</div>


		
	</div>	
	</div>	


	