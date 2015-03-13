<?php

defined('_JEXEC') or die;

$item = $this->item;
$form = $this->form;

?>
<nav id="opportunity-wizard-toolbar" class="uk-navbar uk-vertical-align uk-margin-small-left uk-margin-small-right" data-uk-sticky="{ media: 480 , animation: 'uk-animation-slide-top'}" style="height:75px;">
	
	<div class="uk-vertical-align-middle uk-width-1-1">
		
		<div class="uk-button-group uk-vertical-align-middle uk-float-left uk-width-6-10">
			
			<?php if( is_null ( $item->state ) ):?>
			<h1 class="uk-margin-remove"><?php echo JText::_('COM_DONORWIZ_DASHBOARD_VOLUNTEERS_ADD_TITLE'); ?></h1>
			<?php endif;?>

			<?php if( !is_null ( $item->state ) ):?>
			<div data-uk-button-radio>
				<button class="uk-button published<?php if($item->state=='1') echo ' uk-active';?>"><i class="uk-icon-check uk-icon-small"></i><span class="uk-hidden-small  uk-margin-small-left"><?php echo JText::_( 'COM_DW_OPPORTUNITIES_OPPORTUNITY_WIZARD_PUBLISHED' );?></span></button>
				<button class="uk-button unpublished<?php if($item->state=='0') echo ' uk-active';?>"><i class="uk-icon-remove uk-icon-small"></i><span class="uk-hidden-small  uk-margin-small-left"><?php echo JText::_( 'COM_DW_OPPORTUNITIES_OPPORTUNITY_WIZARD_UNPUBLISHED' );?></span></button>
			</div>
			<?php endif;?>
			
			<?php if( !is_null ( $item->state ) ):?>
			<a class="uk-button uk-button-link" target="_blank" href="<?php echo JRoute::_('index.php?option=com_dw_opportunities&view=dwopportunity&Itemid=261&&id='.(int) $form->getValue('id')); ?>" title="<?php echo JText::_( 'COM_DW_OPPORTUNITIES_OPPORTUNITY_WIZARD_PREVIEW' );?>" data-uk-tooltip>
				<i class="uk-icon-eye uk-icon-small"></i>
			</a>
			<?php endif;?>
			
			<?php if( !is_null ( $item->state ) ):?>
			<a class="uk-button uk-button-link uk-text-muted trashed" href="#" title="<?php echo JText::_( 'COM_DW_OPPORTUNITIES_OPPORTUNITY_WIZARD_TRASH' );?>" data-uk-tooltip>
				<i class="uk-icon-trash-o uk-icon-small"></i>
			</a>
			<?php endif;?>		
		</div>

		<div class="uk-vertical-align-middle uk-width-4-10 uk-text-right">
			<a class="uk-button uk-button-link uk-text-danger" href="<?php echo JRoute::_('index.php?option=com_donorwiz&view=dashboard&layout=dwopportunities', false);?>">
				<i class="uk-icon-long-arrow-left uk-icon-small"></i>
				<span class="uk-hidden-small uk-margin-small-left"><?php echo JText::_( 'COM_DW_OPPORTUNITIES_OPPORTUNITY_WIZARD_CANCEL' );?></span>
			</a>			
			<label for="submit-wizard-button">
				<a class="uk-button uk-button-success">
					<i class="uk-icon-save uk-icon-small"></i>
					<span class="uk-hidden-small uk-margin-small-left"><?php echo JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_WIZARD_SAVE'); ?></span>
				</a>
			</label>
		</div>
	</div>

</nav>

<hr>

<div class="uk-grid uk-margin-large">
    <div class="uk-width-large-1-4"><h2><?php echo JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_WIZARD_WE_NEED_VOLUNTEERS_FOR'); ?></h2></div>
    <div class="uk-width-large-3-4 uk-hidden-small"><h1><?php echo $item->title;?></h1></div>
</div>
	
<form id="form-opportunity" class="uk-form uk-form-horizontal form-validate dw-ajax-submit" method="post" action="<?php echo JURI::base();?>index.php?option=com_dw_opportunities&task=dwopportunityform.save" enctype="multipart/form-data">
	
	<?php echo $form->getInput('id'); ?>
	
	<div class="uk-hidden">
		<?php echo $form->getInput('created_by'); ?>
		<?php echo $form->getInput('created'); ?>
	</div>
	
	<input id="jform_state" type="hidden" name="jform[state]" value="<?php echo $item->state; ?>" />		
	
	<input type="hidden" name="jform[checked_out]" value="<?php echo $item->checked_out; ?>" />

	<input type="hidden" name="jform[checked_out_time]" value="<?php echo $item->checked_out_time; ?>" />		
	<input type="hidden" name="jform[created_by]" value="<?php echo JFactory::getUser()->id; ?>" />		

	<div class="uk-width-1-1">

		<div class="uk-grid">
			
			<div class="uk-width-medium-1-4">
				
				<ul class="uk-tab uk-tab-left" data-uk-tab="{connect:'#tab-left-content'}">
					<li class="uk-active"><a href="#general"><?php echo JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_WIZARD_TAB_GENERAL'); ?></a></li>
					<li class="item-update-visible<?php if( is_null ( $item->state ) ) echo ' visibility-hidden';?>"><a href="#duration"><?php echo JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_WIZARD_TAB_DURATION'); ?></a></li>
					<li class="item-update-visible<?php if( is_null ( $item->state ) ) echo ' visibility-hidden';?>"><a href="#volunteers"><?php echo JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_WIZARD_TAB_VOLUNTEERS'); ?></a></li>
					<li class="item-update-visible<?php if( is_null ( $item->state ) ) echo ' visibility-hidden';?>"><a href="#media"><?php echo JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_WIZARD_TAB_MEDIA'); ?></a></li>
				</ul>

			</div>
			
			<div class="uk-width-medium-3-4">
				
				<ul id="tab-left-content" class="uk-switcher">
					
					<li>
						<div class="uk-margin-top uk-hidden-large"></div>
						<div class="uk-form-row">
							<label class="uk-form-label"><?php echo $form->getLabel('title'); ?>
							<?php if( $form ->getFieldAttribute( 'title' , 'tooltip' , '' , '' ) ) :?>
								<i data-uk-tooltip title="<?php echo JText::_( $form ->getFieldAttribute( 'title' , 'tooltip' , '' , '' ) );?>" class="uk-icon-question-circle uk-margin-left-small uk-float-right"></i>
							<?php endif;?>
							</label>
							<div class="uk-form-controls"><?php echo $form->getInput('title'); ?></div>
						</div>
		
						<div class="uk-form-row">
							<label class="uk-form-label"><?php echo $form->getLabel('description'); ?>
							<?php if( $form ->getFieldAttribute( 'description' , 'tooltip' , '' , '' ) ) :?>
								<i data-uk-tooltip title="<?php echo JText::_( $form ->getFieldAttribute( 'description' , 'tooltip'  , '' , '' ) );?>" class="uk-icon-question-circle uk-margin-left-small uk-float-right"></i>
							<?php endif;?>
							</label>
							<div class="uk-form-controls"><?php echo $form->getInput('description'); ?></div>
							<style>.toggle-editor{display:none!important}</style>
						</div>  
						<div class="uk-form-row">
							<label class="uk-form-label"><?php echo $form->getLabel('causearea'); ?>
							<?php if( $form ->getFieldAttribute( 'causearea' , 'tooltip'  , '' , '' ) ) :?>
								<i data-uk-tooltip title="<?php echo JText::_( $form ->getFieldAttribute( 'category' , 'tooltip'  , '' , '' ) );?>" class="uk-icon-question-circle uk-margin-left-small uk-float-right"></i>
							<?php endif;?>
							</label>
							<div class="uk-form-controls"><?php echo $form->getInput('causearea'); ?></div>
						</div>

						<div class="uk-form-row">
							<label class="uk-form-label"><?php echo $form->getLabel('skills'); ?>
							<?php if( $form ->getFieldAttribute( 'skills' , 'tooltip'  , '' , '' ) ) :?>
								<i data-uk-tooltip title="<?php echo JText::_( $form ->getFieldAttribute( 'category' , 'tooltip'  , '' , '' ) );?>" class="uk-icon-question-circle uk-margin-left-small uk-float-right"></i>
							<?php endif;?>							
							</label>
							<div class="uk-form-controls"><?php echo $form->getInput('skills'); ?></div>	
						</div>
						<div class="uk-form-row">
							<label class="uk-form-label"><?php echo $form->getLabel('category'); ?>
							<?php if( $form ->getFieldAttribute( 'category' , 'tooltip'  , '' , '' ) ) :?>
								<i data-uk-tooltip title="<?php echo JText::_( $form ->getFieldAttribute( 'category' , 'tooltip'  , '' , '' ) );?>" class="uk-icon-question-circle uk-margin-left-small uk-float-right"></i>
							<?php endif;?>								
							</label>
							<div class="uk-form-controls"><?php echo $form->getInput('category'); ?></div>
						</div>
		
						<div id="address_elm_wrapper" class="uk-form-row<?php if( $item->category == 'virtual' || !$item->category) echo ' visibility-hidden'; ?>">
							<label class="uk-form-label"><?php echo $form->getLabel('address'); ?>
							<?php if( $form ->getFieldAttribute( 'address' , 'tooltip'  , '' , '' ) ) :?>
								<i data-uk-tooltip title="<?php echo JText::_( $form ->getFieldAttribute( 'address' , 'tooltip'  , '' , '' ) );?>" class="uk-icon-question-circle uk-margin-left-small uk-float-right"></i>
							<?php endif;?>								
							</label>
							<div class="uk-form-controls">
								<?php echo $form->getInput('address'); ?>
							</div>

						</div> 
					
					</li>

					<li>     
						<div class="uk-margin-top uk-hidden-large"></div>
						
						<p><?php echo JText::_( 'COM_DW_OPPORTUNITIES_OPPORTUNITY_WIZARD_LABEL_DATE_TIME_TITLE' );?></p>
						
						<div id="date_start_elm_wrapper" class="uk-form-row">
						
							<div class="uk-text-bold"><?php echo JText::_( 'COM_DW_OPPORTUNITIES_OPPORTUNITY_WIZARD_LABEL_DATE_START_TITLE' );?><i data-uk-tooltip title="<?php echo JText::_( 'COM_DW_OPPORTUNITIES_OPPORTUNITY_WIZARD_LABEL_DATE_START_TITLE_TOOLTIP' );?>" class="uk-icon-question-circle uk-margin-small-left"></i></div>
							
							<label class="uk-form-label"><?php echo $form->getLabel('date_start'); ?>
							<?php if( $form ->getFieldAttribute( 'date_start' , 'tooltip'  , '' , '' ) ) :?>
								<i data-uk-tooltip title="<?php echo JText::_( $form ->getFieldAttribute( 'date_start' , 'tooltip'  , '' , '' ) );?>" class="uk-icon-question-circle uk-margin-left-small uk-float-right"></i>
							<?php endif;?>								
							</label>
							<div class="uk-form-controls">
								<?php echo $form->getInput('date_start'); ?>
							</div>
							<label class="uk-form-label"><?php echo $form->getLabel('time_start'); ?>
							<?php if( $form ->getFieldAttribute( 'time_start' , 'tooltip'  , '' , '' ) ) :?>
								<i data-uk-tooltip title="<?php echo JText::_( $form ->getFieldAttribute( 'time_start' , 'tooltip'  , '' , '' ) );?>" class="uk-icon-question-circle uk-margin-left-small uk-float-right"></i>
							<?php endif;?>								
							</label>
							<div class="uk-form-controls">
								<?php echo $form->getInput('time_start'); ?>
							</div>
							
						</div>		

						<div id="date_end_elm_wrapper" class="uk-form-row">
							
							<div class="uk-text-bold"><?php echo JText::_( 'COM_DW_OPPORTUNITIES_OPPORTUNITY_WIZARD_LABEL_DATE_END_TITLE' );?><i data-uk-tooltip title="<?php echo JText::_( 'COM_DW_OPPORTUNITIES_OPPORTUNITY_WIZARD_LABEL_DATE_END_TITLE_TOOLTIP' );?>" class="uk-icon-question-circle uk-margin-small-left"></i></div>
							
							<label class="uk-form-label"><?php echo $form->getLabel('date_end'); ?>
							<?php if( $form ->getFieldAttribute( 'date_end' , 'tooltip'  , '' , '' ) ) :?>
								<i data-uk-tooltip title="<?php echo JText::_( $form ->getFieldAttribute( 'date_end' , 'tooltip'  , '' , '' ) );?>" class="uk-icon-question-circle uk-margin-left-small uk-float-right"></i>
							<?php endif;?>								
							</label>
							<div class="uk-form-controls">
								<?php echo $form->getInput('date_end'); ?>
	
							</div>
							<label class="uk-form-label"><?php echo $form->getLabel('time_end'); ?>
							<?php if( $form ->getFieldAttribute( 'time_end' , 'tooltip'  , '' , '' ) ) :?>
								<i data-uk-tooltip title="<?php echo JText::_( $form ->getFieldAttribute( 'time_end' , 'tooltip'  , '' , '' ) );?>" class="uk-icon-question-circle uk-margin-left-small uk-float-right"></i>
							<?php endif;?>								
							</label>
							<div class="uk-form-controls">
								<?php echo $form->getInput('time_end'); ?>
							</div>
							
						</div>

					</li>
					
					<li>      
						<div class="uk-margin-top uk-hidden-large"></div>
						<div class="uk-form-row">
							<label class="uk-form-label"><?php echo $form->getLabel('volunteers_no_enabled','parameters'); ?>
							<?php if( $form ->getFieldAttribute( 'volunteers_no_enabled' , 'tooltip' , '' , 'parameters') ) :?>
								<i data-uk-tooltip title="<?php echo JText::_( $form ->getFieldAttribute( 'volunteers_no_enabled', 'tooltip' , '' , 'parameters') );?>" class="uk-icon-question-circle uk-margin-left-small uk-float-right"></i>
							<?php endif;?>	
							</label>
							<div class="uk-form-controls"><?php echo $form->getInput('volunteers_no_enabled','parameters'); ?></div>
						</div>

						<div id="volunteers_no_elm_wrapper" class="uk-form-row<?php if( $item->parameters['volunteers_no_enabled'] == '0') echo ' visibility-hidden'; ?>" >
							<label class="uk-form-label"><?php echo $form->getLabel('volunteers_no','parameters'); ?>
							<?php if( $form ->getFieldAttribute( 'volunteers_no' , 'tooltip' , '' , 'parameters') ) :?>
								<i data-uk-tooltip title="<?php echo JText::_( $form ->getFieldAttribute( 'volunteers_no', 'tooltip' , '' , 'parameters') );?>" class="uk-icon-question-circle uk-margin-left-small uk-float-right"></i>
							<?php endif;?>	
							</label>
							<div class="uk-form-controls"><?php echo $form->getInput('volunteers_no','parameters'); ?></div>
						</div>
					</li> 

					<li>
						
						<h3><?php echo $form->getLabel('image');?></h3>
						
						<?php if( $form ->getFieldAttribute( 'image' , 'tooltip'  , '' , '' ) && $item -> image=='') :?>
							<p><?php echo JText::_( $form ->getFieldAttribute( 'image' , 'tooltip'  , '' , '' ) );?></p>
						<?php endif;?>	

						<?php echo $form->getInput('image'); ?>
						
						<h3><?php echo $form->getLabel('video','parameters');?></h3>
						
						<?php if( $form ->getFieldAttribute( 'video' , 'tooltip' , '' , 'parameters') ) :?>
							<p><?php echo JText::_( $form ->getFieldAttribute( 'video' , 'tooltip'  , '' , 'parameters' ) );?></p>
						<?php endif;?>	
						<?php echo $form->getInput('video','parameters'); ?>
						
						<?php if( isset($item->parameters['video']) && $item->parameters['video']!='' && $item->YouTubeVideoID ):?>
							<a class="uk-button uk-button-link uk-float-right uk-margin-small-top" href="<?php echo $item->parameters['video'];?>" data-lightbox><i class="uk-icon-youtube-play uk-icon-small"></i><span class="uk-margin-small-left"><?php echo JText::_( 'COM_DW_OPPORTUNITIES_OPPORTUNITY_WIZARD_PREVIEW' );?></span></a>
						<?php elseif( isset($item->parameters['video']) && $item->parameters['video']!=''):?>
							<div class="uk-badge uk-badge-danger uk-float-right uk-margin-small-top">
								<?php echo JText::_( 'COM_DW_OPPORTUNITIES_OPPORTUNITY_WIZARD_INVALID_URL' );?>
							</div>
						<?php endif;?>

						
					</li>	

				</ul>

			</div>
		</div>

	</div>
	
	<?php echo JHtml::_('form.token'); ?>

	<input type="submit" id="submit-wizard-button" class="validate uk-button uk-button-primary uk-button-large uk-hidden"/>

</form>