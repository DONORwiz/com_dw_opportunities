<?php
 
// no direct access
defined('_JEXEC') or die;

JFactory::getLanguage()->load('com_donorwiz');
JFactory::getLanguage()->load('com_dw_opportunities_responses');
JFactory::getLanguage()->load('com_dw_opportunities_responses_statuses');

JHtml::_('jquery.framework');

$app = JFactory::getApplication();
$jinput = $app->input;
$dashboard = ( $jinput->get('dashboard', '', 'string'=='true') ) ? true : null ;

$item = $this -> item ;

$canEdit = JFactory::getUser()->authorise('core.edit', 'com_dw_opportunities');
if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_dw_opportunities')) {
	$canEdit = JFactory::getUser()->id == $this->item->created_by;
}

//If user can edit opportunity load wizard.js
if( $canEdit ) {

	$script = array();

	$script[] = 'var item_save_success = "'.JText::_('COM_DW_OPPORTUNITIES_ITEM_SAVE_SUCCESS').'";';
	$script[] = 'var item_save_fail = "'.JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_ITEM_SAVE_FAIL').'";';
	$script[] = 'var item_unpublished_warning = "'.JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_ITEM_UNPUBLISHED_WARNING').'";';
	$script[] = 'var item_published_message = "'.JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_ITEM_PUBLISHED_MESSAGE').'";';

	JFactory::getDocument()->addScriptDeclaration( implode( "\n" , $script ) );
	
	JHtml::script(Juri::base() . 'media/com_donorwiz/js/wizard.js');

	if( count ( $item->responses ) > 1 ) 
	{
		JHtml::script(Juri::base() . 'media/com_donorwiz/js/list.js');
		JHtml::script(Juri::base() . 'media/com_donorwiz/libs/js/listjs/list.min.js');
	}
}

?>





<div class="uk-grid">
	
	<?php if(!$dashboard) :?>
	<div class="uk-width-large-4-10 uk-hidden-medium uk-hidden-small">
	
		<?php echo JLayoutHelper::render('multiple', array ( 'items' => array ( '0' => $item ) , 'widthClass' => 'uk-width-4-10' ) , JPATH_ROOT .'/components/com_donorwiz/layouts/map' , null ); ?>

	</div>
	<?php endif;?>

	<div class="<?php if($dashboard) { echo 'uk-width-1-1' ;} else { echo 'uk-width-large-6-10 uk-width-medium-1-1';}?>">
		

		

<div id="opportunityitem" class="uk-article">

<div class="uk-grid">
		
	<div class="uk-width-3-4">
		
		<h1 class="uk-article-title"><?php echo $item->title; ?></h1>
					
		<?php //echo JLayoutHelper::render( 'opportunity' , array( 'item' => $item ) , JPATH_ROOT .'/components/com_dw_opportunities/layouts/acl' , null ); ?>
		
		<p><?php echo $item->description; ?></p>

		<?php if($item->showLoginButton):?>
		
			<?php echo JLayoutHelper::render(
				'popup-button', 
				array (
					'buttonText' => JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_I_WANT_TO_HELP'),
					'buttonIcon' => 'uk-icon-smile-o uk-icon-small uk-margin-small-right',
					'buttonType' => 'uk-button uk-button-primary uk-button-large',

					'layoutPath' => JPATH_ROOT .'/components/com_donorwiz/layouts/user',
					'layoutName' => 'login',
					'layoutParams' => array()
				), 
				JPATH_ROOT .'/components/com_donorwiz/layouts/popup' , 
				null ); 
			?>

		<?php endif;?>
		
		<?php if( $item -> showResponseWizard ): ?>

			<?php echo JLayoutHelper::render(
				'popup-button', 
				array (
					'buttonText' => JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_I_WANT_TO_HELP'),
					'buttonIcon' => 'uk-icon-smile-o uk-icon-small uk-margin-small-right',
					'buttonType' => 'uk-button uk-button-primary uk-button-large',
					'popupParams' => array (
						'header' => '<h2 class="uk-article-title"><i class="uk-icon-smile-o uk-icon-medium uk-margin-small-right"></i>'.JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_I_WANT_TO_HELP').'</h2>',
						'footer' => ''
					),
					'layoutPath' => JPATH_ROOT .'/components/com_dw_opportunities_responses/layouts/wizard',
					'layoutName' => 'response',
					'layoutParams' => array( 'opportunity_id' => $item->id , 'response' => null )
				), 
				JPATH_ROOT .'/components/com_donorwiz/layouts/popup' , 
				null ); 
			?>

			
		
		<?php endif; ?>
		



<?php if ( $canEdit ) : ?>

<h2 class="uk-article-title uk-text-center"><?php echo JText::_('COM_DW_OPPORTUNITIES_RESPONSES_VOLUNTEERS'); ?></h2>

<div id="opportunity_responses_statistics" class="statistics">

	<div class="uk-grid uk-margin">
		<div class="uk-width-1-2 uk-width-medium-1-4">
			<div class="uk-panel uk-text-center">
				<div><span class="uk-badge uk-badge-notification number uk-text-large"><?php echo $item->responses['statistics']['total'] ;?></span></div>
				<div><a href="#" onclick="jQuery('select.status-filter option[value=ALL]').prop('selected', 'selected');jQuery('select.status-filter').trigger('change');return false;"><span class="uk-text-secondary"><?php echo JText::_('COM_DW_OPPORTUNITIES_RESPONSES_INTERESTED'); ?></span></a></div>
				
			</div>
		</div>
		<div class="uk-width-1-2 uk-width-medium-1-4">
			<div class="uk-panel uk-text-center">
				<div><span class="uk-badge uk-badge-notification uk-badge-warning number uk-text-large"><?php echo $item->responses['statistics']['pending'] ;?></span></div>
				<div><a href="#" onclick="jQuery('select.status-filter option[value=pending]').prop('selected', 'selected');jQuery('select.status-filter').trigger('change');return false;"><span class="uk-text-warning"><?php echo JText::_('COM_DW_OPPORTUNITIES_RESPONSES_AWAITING'); ?></span></a></div>
			</div>
		</div>
		<div class="uk-width-1-2 uk-width-medium-1-4">
			<div class="uk-panel uk-text-center">
				<div><span class="uk-badge uk-badge-notification uk-badge-success number uk-text-large"><?php echo $item->responses['statistics']['accepted'] ;?></span></div>
				<div><a href="#" onclick="jQuery('select.status-filter option[value=accepted]').prop('selected', 'selected');jQuery('select.status-filter').trigger('change');return false;"><span class="uk-text-success"><?php echo JText::_('COM_DW_OPPORTUNITIES_RESPONSES_APPROVED'); ?></span></a></div>
			</div>
		</div>
		<div class="uk-width-1-2 uk-width-medium-1-4">
			<div class="uk-panel uk-text-center">
				<div><span class="uk-badge uk-badge-notification uk-badge-danger number uk-text-large"><?php echo $item->responses['statistics']['declined'] ;?></span></div>
				<div><a href="#" onclick="jQuery('select.status-filter option[value=declined]').prop('selected', 'selected');jQuery('select.status-filter').trigger('change');return false;"><span class="uk-text-danger"><?php echo JText::_('COM_DW_OPPORTUNITIES_RESPONSES_REJECTED'); ?></span></a></div>
			</div>
		</div>
	</div>
	
</div>

<?php endif; ?>


<?php if( $item -> responses ['items'] ): ?>


<script type="text/javascript">
	var hash = window.location.hash;

	jQuery(document).ready(function () {

	var hash = jQuery(window.location.hash);

	hash.addClass('uk-animation-fade');

	for (i = 0; i < 20; i++) { 
		setTimeout(function(){hash.toggleClass('uk-panel-box-primary'); }, i*1000);
	}

	});

</script>

<div id="opportunity_responses">
	
	<?php if($canEdit): ?>
	
	<div class="uk-form">
	
		<div class="uk-grid uk-grid-small" data-uk-grid-margin>
			
			<div class="uk-width-medium-1-1 uk-width-large-1-2">
				<input class="uk-form-large uk-width-1-1 search" type="text" placeholder="<?php echo JText::_('COM_DW_OPPORTUNITIES_RESPONSES_VOLUNTEERS_SEARCH'); ?>" class="search">
			</div>

				
			<div class="uk-width-medium-1-1 uk-width-large-1-2">
			
				<div class="uk-grid uk-grid-small">
					
					<div class="uk-width-1-2">
					
						<select class="uk-form-large uk-width-1-1 created-sort">
							<option value="NEWEST"><?php echo JText::_('COM_DW_OPPORTUNITIES_RESPONSES_SORT_BY_DATE_DESC'); ?></option>
							<option value="OLDEST"><?php echo JText::_('COM_DW_OPPORTUNITIES_RESPONSES_SORT_BY_DATE_ASC'); ?></option>
						</select>

					</div>
				
					<div class="uk-width-1-2">
						
						<select class="uk-form-large status-filter uk-width-1-1">
							
							<option value=""><?php echo JText::_('COM_DW_OPPORTUNITIES_RESPONSES_SORT_BY_STATUS'); ?></option>
							<option value="ALL"><?php echo JText::_('JALL'); ?></option>
							<option value="pending"><?php echo JText::_('COM_DW_OPPORTUNITIES_RESPONSES_STATUSES_PENDING'); ?></option>
							<option value="accepted"><?php echo JText::_('COM_DW_OPPORTUNITIES_RESPONSES_STATUSES_ACCEPTED'); ?></option>
							<option value="declined"><?php echo JText::_('COM_DW_OPPORTUNITIES_RESPONSES_STATUSES_DECLINED'); ?></option>

						</select>
						
					</div>
				
				</div>
				
			</div>
	
		</div>
		
	</div>
	
	<?php endif; ?>

	<ul class="uk-list list">

		<?php foreach ( $item -> responses ['items'] as $i => $response) : ?>

		<?php echo JLayoutHelper::render( 'response' , array ( 'response' => $response  ) , JPATH_ROOT .'/components/com_dw_opportunities_responses/layouts/item' , null ); ?>
		
		<?php endforeach;?>
	
	</ul>
	
</div>

<?php endif;?>


		</div>
	
	<div  class="uk-width-1-4">
	
		<div class="uk-width-1-1">
			<?php echo JLayoutHelper::render( 'infocard' , array( 'created_by_id' => $item->created_by , 'item' => $item )  , JPATH_ROOT .'/components/com_dw_opportunities/layouts/misc' , null ); ?>
		</div>
		
		<div class="uk-width-1-1 uk-margin-top">
			<?php echo JLayoutHelper::render( 'category' , array( 'item' => $item ) , JPATH_ROOT .'/components/com_dw_opportunities/layouts/elements' , null ); ?>	
		</div>

		<div class="uk-width-1-1 uk-margin-top">
			<?php echo JLayoutHelper::render( 'schedule' , array( 'item' => $item ) , JPATH_ROOT .'/components/com_dw_opportunities/layouts/elements' , null ); ?>	
		</div>	
		
		

		
		
		
	</div>

	</div>
	
</div>









	</div>
</div>