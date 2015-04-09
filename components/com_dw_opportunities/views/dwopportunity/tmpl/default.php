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

$showMap = (!$dashboard) ? true : null ;
$widthClass = ($showMap) ? 'uk-width-large-6-10 uk-width-medium-1-1' : 'uk-width-1-1' ;

?>

<div id="opportunityitem" class="uk-grid">
		
	<?php if($showMap) :?>
	<div class="uk-width-large-4-10 uk-hidden-medium uk-hidden-small" style="min-height:1px;">
		<?php echo JLayoutHelper::render('multiple', array ( 'items' => array ( '0' => $item ) , 'widthClass' => 'uk-width-4-10' ) , JPATH_ROOT .'/components/com_donorwiz/layouts/map' , null ); ?>
	</div>
	<?php endif;?>

	<div class="<?php echo $widthClass;?> uk-article">
					
		<?php if ($item->image):?>	
		
		<div class="uk-cover-background uk-position-relative" style="height: 300px; background-image: url('<?php echo $item->image;?>');">
			<img class="uk-invisible" src="<?php echo $item->image;?>" width="" height="" alt="">
		
		<?php endif;?>
			
		<?php if ($item->image):?>
			<div class="uk-position-cover uk-flex uk-flex-bottom">
		<?php endif;?>
			
			<div class="uk-width-1-1 uk-panel uk-panel-box uk-vertical-align" style="background: rgba(0, 0, 0, 0.75); color: #fff;">
				
			<?php echo JLayoutHelper::render( 
				'image', 
				array( 'src' => CFactory::getUser( $item-> created_by )->getThumbAvatar() , 'alt' => $item->title , 'title' => $item->title , 'class'=>'uk-border-circle uk-margin-small-right'), 
				JPATH_ROOT .'/components/com_donorwiz/layouts/media', 
				null ); 
			?>			
			
			<h1 class="uk-article-title uk-display-inline uk-text-middle" style="color:#ffffff"><?php echo $item->title; ?></h1>
				
			<?php if ( $item->parameters->video && $item->parameters->video!=''):?>
				<a class="uk-button uk-button-link uk-button-no-border uk-float-right" style="color:#ffffff" href="<?php echo $item->parameters->video;?>" data-lightbox="">
				<i class="uk-icon-youtube-play uk-icon-large"></i>
				</a>
			<?php endif;?>
				
			</div>
			
		<?php if ($item->image):?>	
			</div>
			
		</div>
		<?php endif;?>
		

		<?php if ( JFactory::getUser()->guest ):?>
		<!-- Login Button ---------------------------------------------------------------------------------->
			<?php echo JLayoutHelper::render(
				'popup-button', 
				array (
					'isAjax' => true,
					'buttonLink' => JRoute::_('index.php?option=com_donorwiz&view=login&Itemid=314&return='.base64_encode(JFactory::getURI()->toString()).'&'. JSession::getFormToken() .'=1'),
					'buttonText' => JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_I_WANT_TO_HELP'),
					'buttonIcon' => 'uk-icon-smile-o uk-icon-small uk-margin-small-right',
					'buttonType' => 'uk-button uk-button-primary uk-button-large uk-width-1-1',

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
					'buttonType' => 'uk-button uk-button-primary uk-button-large uk-width-1-1',
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
		
		<p><?php echo $item->description; ?></p>

		<div class="uk-grid">
			
			<div class="uk-width-medium-1-2 uk-margin-small-top">
				<?php echo JLayoutHelper::render( 'category' , array( 'item' => $item ) , JPATH_ROOT .'/components/com_dw_opportunities/layouts/elements' , null ); ?>	
			</div>

			<div class="uk-width-medium-1-2 uk-margin-small-top">
				<?php echo JLayoutHelper::render( 'schedule' , array( 'item' => $item ) , JPATH_ROOT .'/components/com_dw_opportunities/layouts/elements' , null ); ?>	
			</div>		

		</div>
		
		<?php if ( $item -> myresponse ) :?>
		
		<div class="uk-width-1-1 uk-margin-top">
			<?php echo JLayoutHelper::render( 'item.response' , array( 'response'=> $item -> myresponse ) , JPATH_ROOT .'/components/com_dw_opportunities_responses/layouts' , null ); ?>	
		</div>
		
		<?php endif; ?>
		
		<div class="uk-width-1-1">
				<?php echo JLayoutHelper::render( 'info' , array( 'beneficiary_id' => $item -> created_by ) , JPATH_ROOT .'/components/com_dw_opportunities/layouts/beneficiary' , null ); ?>	
		</div>

		<div class="uk-width-1-1">
			<?php echo JLayoutHelper::render( 
				'list.opportunities' , 
				array( 
					'created_by' => $item -> created_by, 
					'template' => 'textlinks',
					'list.limit' => 5,
					'itemid' => $item -> id	,
					'title' => '<h3>'.JText::sprintf('COM_DW_OPPORTUNITIES_MORE_ADS').'</h3>'
				) , 
				JPATH_ROOT .'/components/com_dw_opportunities/layouts' , 
				null ); 
			?>	
		</div>
		
		<div class="uk-width-1-1 uk-margin-top">
			<!-- www.addthis.com -->
			<div class="addthis_sharing_toolbox"></div>
		</div>
		
		<div class="uk-width-1-1 uk-text-right">
			<a class="uk-button uk-button-link" href="<?php echo JRoute::_('volunteer'); ?>">
			<i class="uk-icon-long-arrow-left uk-icon-small"></i>
			<?php echo JText::_('COM_DW_OPPORTUNITIES_BACK');?>
			</a>
		</div>
			
	</div>

</div>