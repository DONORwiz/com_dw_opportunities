<?php

// no direct access
defined('_JEXEC') or die;

$item = $displayData['item'];

$descrLength = ( isset ( $displayData['descrLength'] ) ) ? $displayData['descrLength'] : 0 ;

if( JFactory::getApplication()->input->get('dashboard','','string') == 'true')
{
	$descrLength = 0;
}

$app = JFactory::getApplication();
$jinput = $app->input;
$dashboard = ( $jinput->get('dashboard', '', 'string'=='true') ) ? true : null ;

include_once JPATH_ROOT.'/components/com_community/libraries/core.php';

?>

<div class="uk-panel uk-panel-box volunteering-opportunity teaser <?php echo 'featured_'.$item->featured; ?>"  data-title="<?php echo $this->escape($item->title); ?>" data-address="<?php echo $this->escape($item->address); ?>" data-lat="<?php echo $this->escape($item->lat); ?>" data-lng="<?php echo $this->escape($item->lng); ?>">

	<div class="uk-grid">
			
		<div class="uk-hidden-small uk-width-large-2-10">
			<?php echo JLayoutHelper::render( 'infocard' , array( 'created_by_id' => $this->escape($item->created_by) , 'item' => $item )  , JPATH_ROOT .'/components/com_dw_opportunities/layouts/misc' , null ); ?>
			
			<div class="uk-width-1-1 uk-text-center uk-margin-small-top">
				<img style="display:none;" onLoad="this.style.display='inline-block';" src="<?php echo Juri::base();?>media/com_donorwiz/images/mapicons/<?php echo $item->causearea;?>.png" title="<?php echo JText::_($item->causearea); ?>" data-uk-tooltip>
			</div>
			
			<?php echo JLayoutHelper::render( 'opportunity' , array( 'item' => $item ) , JPATH_ROOT .'/components/com_dw_opportunities/layouts/acl' , null ); ?>
		</div>	

		<div class="uk-width-large-8-10">
			
			<a <?php if ($dashboard) echo 'target="_blank"';?> href="<?php echo JRoute::_('index.php?option=com_dw_opportunities&view=dwopportunity&Itemid=261&id='.(int) $item->id); ?>">

				<h2 class="uk-margin-remove">
				<?php echo $this->escape($item->title); ?> 
				<?php if ($dashboard):?>
				<i class="uk-icon-external-link"></i>
				<?php endif;?>
				</h2>

			</a>
			
			<?php echo JLayoutHelper::render( 'opportunity' , array( 'created_by_id' => $this->escape($item->created_by) , 'item' => $item )  , JPATH_ROOT .'/components/com_dw_opportunities/layouts/meta' , null ); ?>
			
			
			<?php if( $descrLength != 0 ) : ?>
				<div class="uk-hidden-medium uk-hidden-small uk-margin-top"><?php echo substr( $item->description , 0, $descrLength).'...'; ?></div>
			<?php endif; ?>

	
			<div class="uk-grid uk-margin-top">
				
				<div class="uk-width-1-2">
					<?php echo JLayoutHelper::render( 'category' , array( 'item' => $item ) , JPATH_ROOT .'/components/com_dw_opportunities/layouts/elements' , null ); ?>	
				</div>

				<div class="uk-width-1-2">
					<?php echo JLayoutHelper::render( 'schedule' , array( 'item' => $item ) , JPATH_ROOT .'/components/com_dw_opportunities/layouts/elements' , null ); ?>	
				</div>		

			</div>
		
		</div>	
		
	</div>	

</div>

