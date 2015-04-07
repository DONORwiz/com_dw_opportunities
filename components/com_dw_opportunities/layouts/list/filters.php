<?php 

defined('_JEXEC') or die;

$beneficiaries = $displayData['beneficiaries'];
$causeareas = $displayData['causeareas'];
$resetlink = $displayData['resetlink'];

$app = JFactory::getApplication();
$jinput = $app->input;

$jinputFilter = $app->input->get('filter','','array');

$jinputCategory = ( isset ( $jinputFilter['category'] ) ) ? $jinputFilter['category'] : '' ;
$jinputCreatedBy = ( isset ( $jinputFilter['created_by'] ) ) ? $jinputFilter['created_by'] : '' ;
$jinputCauseArea = ( isset ( $jinputFilter['causearea'] ) ) ? $jinputFilter['causearea'] : '' ;

$dashboard = ( isset ( $jinputFilter[ 'dashboard' ] ) && $jinputFilter[ 'dashboard' ] == 'true' ) ? true : null ;

$donorwizUrl = new DonorwizUrl();

?>

<div class="uk-width-1-1 uk-margin-small-bottom">

	<div id="filters-toggle" class="uk-form uk-animation-slide-top uk-hidden">
	
			<div class="uk-grid uk-grid-small uk-margin-small-top">
				
				<div class="uk-width-medium-1-2">
						
					<?php echo JLayoutHelper::render( 'list.filter.state', array ( ) , JPATH_ROOT .'/components/com_dw_opportunities/layouts' , null ); ?>
						
						<?php if(!$dashboard):?>
						
						<select class="uk-form-large uk-width-1-1" onchange="if (this.value) window.location.href=this.value" <?php if ( !count( $beneficiaries ) ) echo 'disabled="true"'; ?> >

							<option value="<?php echo $donorwizUrl -> getCurrentUrlWithNewParams( array( 'filter' => array ( 'created_by' => '' ) ) ) ;?>" ><?php echo JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITIES_FILTERS_ORGANIZATION');?></option>
							
							<?php if ( count( $beneficiaries ) ) : ?>
								
								<?php foreach ( $beneficiaries as $key => $value) : ?>

									<option 
										
										<?php if( $jinputCreatedBy != $value['user_id'] ) :?>
											value="<?php echo $donorwizUrl -> getCurrentUrlWithNewParams(  array( 'filter' => array ( 'created_by' => $value['user_id'] ) ) );?>"
										<?php endif;?>
										
										<?php if( $jinputCreatedBy == $value['user_id'] ) :?>
											selected="selected"
										<?php endif;?>
									
									>
										<?php echo $value['name'];?>
									
									</option>

								<?php endforeach;?>
							
							<?php endif; ?>
						
						</select>
						
						<?php endif;?>
					
	
				</div>
				
				<div class="uk-width-medium-1-2">
					
						<select class="uk-form-large uk-width-1-1" onchange="if (this.value) window.location.href=this.value">
						
							<option value="<?php echo $donorwizUrl -> getCurrentUrlWithNewParams( array( 'filter' => array ( 'causearea' => '' ) ) ); ?>" ><?php echo JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_CAUSE_AREA');?></option>
							
							<?php if ( $causeareas && count( $causeareas ) > 0 ) : ?>
								
								<?php foreach ($causeareas as $key => $causearea) :  ?>

									<option 
									<?php if( $jinputCauseArea != $causearea) :?>
										value="<?php echo $donorwizUrl -> getCurrentUrlWithNewParams( array( 'filter' => array ( 'causearea' => $causearea ) ) );?>" 
									<?php endif; ?>
									<?php if( $jinputCauseArea == $causearea ) :?>
										selected="selected"
									<?php endif; ?>
									>
										<?php echo JText::_($causearea);?>
									</option>
									
								<?php endforeach;?>
								
							<?php endif; ?>
						
						</select>
			
				</div>
			</div>		
		
		<?php if(!$dashboard):?>
			
			<form class="uk-form" method="get" action="<?php echo JURI::current();?>" enctype="text/plain">
			
				<div class="uk-grid uk-grid-small uk-margin-small-top">
				
					<div class="uk-width-medium-1-2">

						<?php JFormHelper::addFieldPath( JPATH_SITE . '/components/com_donorwiz/models/fields/addressautocomplete'); ?>
						<?php $addressautocomplete = JFormHelper::loadFieldType('addressautocomplete', false);?>
						<?php echo $addressautocomplete ->getInput();?>
					
					</div>

					<div class="uk-width-medium-1-2">
						<button type="submit" class="uk-button uk-button-primary uk-button-large uk-width-1-1"><?php echo JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITIES_FILTERS_NEARBY');?></button>
					</div>
				
				</div>
			
			</form>
			
		<?php endif; ?>
	</div>
	

	<div class="uk-grid uk-grid-small uk-margin-small-top">
			
		<div class="uk-width-medium-1-2">
		
			<a class="uk-button uk-button-large uk-width-1-1 truncate
				<?php if( $jinputCategory == 'local') :?>
					uk-active uk-button-success
				<?php endif;?>
				" 
				<?php if( $jinputCategory == 'local'):?>
					href="<?php echo $donorwizUrl -> getCurrentUrlWithNewParams( array( 'filter' => array ( 'category' => '' ) ) ); ?>"
				<?php else:?>
					href="<?php echo $donorwizUrl -> getCurrentUrlWithNewParams( array( 'filter' => array ( 'category' => 'local' ) ) ); ?>"
				<?php endif;?>				
				data-uk-tooltip="{pos:'bottom'}" title="<?php echo JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_LOCAL_TOOLTIP');?>">
				<i class="uk-icon-map-marker uk-icon-small"></i>
				<?php echo JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_LOCAL');?>
			</a>
			
		</div>
			
		<div class="uk-width-medium-1-2">
			
			<a class="uk-button uk-button-large uk-width-1-1 truncate<?php if( $jinputCategory == 'virtual') {echo 'uk-active uk-button-success';} ?>" 
				
				<?php if( $jinputCategory == 'virtual'):?>
					href="<?php echo $donorwizUrl -> getCurrentUrlWithNewParams( array( 'filter' => array ( 'category' => '' ) ) ); ?>"
				<?php else:?>
					href="<?php echo $donorwizUrl -> getCurrentUrlWithNewParams( array( 'filter' => array ( 'category' => 'virtual' ) ) ); ?>"
				<?php endif;?>
				
				data-uk-tooltip="{pos:'bottom'}" title="<?php echo JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_VIRTUAL_TOOLTIP');?>">
				
				<i class="uk-icon-laptop uk-icon-small"></i>
				<?php echo JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_VIRTUAL');?>

			</a>
		
		</div>	
		
	</div>
	
		<div class="uk-width-1-1 uk-text-right uk-margin-small-top uk-form">
		
		<?php if( $resetlink == true && !$dashboard ):?>
				<a class="uk-button uk-button-mini uk-button-link" href="<?php echo JRoute::_( $donorwizUrl -> getCurrentUrlWithNewParams( array ( ) ) ); ?>">
					<i class="uk-icon-remove uk-icon-small"></i>
					<?php echo JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITIES_FILTERS_RESET');?>
				</a>
		<?php endif;?>

		<?php if( $dashboard ):?>
			<a class="uk-button uk-button-mini uk-button-link" href="<?php echo JRoute::_('index.php?Itemid='. JFactory::getApplication()->getMenu()->getItems( 'link', 'index.php?option=com_donorwiz&view=dashboard&layout=dwopportunities', true )->id );?>">
				<i class="uk-icon-remove uk-icon-small"></i>
				<?php echo JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITIES_FILTERS_RESET');?>
			</a>
		<?php endif;?>
		
		<select class="uk-form-small uk-hidden" onchange="if (this.value) window.location.href=this.value">

			<option value="<?php echo $donorwizUrl -> getCurrentUrlWithNewParams( array ( 'created_by' => '' ) ); ?>" ><?php echo JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITIES_FILTERS_SORT_BY_DATE');?></option>
			<option value="<?php echo $donorwizUrl -> getCurrentUrlWithNewParams( array ( 'created_by' => '' ) ); ?>" ><?php echo JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITIES_FILTERS_SORT_BY_EVENT');?></option>
		
		</select>	
		
		<a href="#" class="uk-button uk-button-mini uk-button-primary filters-toggle" onclick="jQuery('.filters-toggle').toggleClass('uk-hidden');" data-uk-toggle="{target:'#filters-toggle', animation:'uk-animation-slide-top, uk-animation-slide-bottom'}">
			<i class="uk-icon-angle-down uk-icon-large uk-margin-small-right"></i>
			<?php echo JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITIES_FILTERS_MORE');?>
		</a>
		
		<a href="#" class="uk-button uk-button-mini uk-button-primary filters-toggle uk-hidden" onclick="jQuery('.filters-toggle').toggleClass('uk-hidden');" data-uk-toggle="{target:'#filters-toggle', animation:'uk-animation-slide-top, uk-animation-slide-bottom'}">
			<i class="uk-icon-angle-up uk-icon-large uk-margin-small-right"></i>
			<?php echo JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITIES_FILTERS_LESS');?>
		</a>
	
	</div>
	


</div>