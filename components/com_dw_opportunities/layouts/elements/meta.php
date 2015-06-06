<?php

// no direct access
defined('_JEXEC') or die;

include_once JPATH_ROOT.'/components/com_community/libraries/core.php';

$created_by_id = $displayData['created_by_id'];

$item = $displayData['item'];

$created_by = CFactory::getUser( $created_by_id ) ;

$created_by_name = $created_by->getDisplayName();

$link = CRoute::_('index.php?option=com_community&view=profile&userid='.$created_by_id); 

?>

<p class="uk-article-meta uk-margin-small-top">
	<?php if( !JFactory::getApplication()->input->get('dashboard','','string') ) : ?>
	
	<span class="uk-hidden-small"><?php echo JText::_('COM_DW_OPPORTUNITIES_ITEM_POSTED_ON');?></span>
	<?php echo JFactory::getDate($item->created)->format('D, d M Y');?>

	<?php echo JLayoutHelper::render(
		'popup-button', 
		array (
			'isAjax' => true,
			'buttonLink' => JRoute::_('index.php?option=com_donorwiz&view=login&Itemid=314&mode=register&return='.base64_encode(JFactory::getURI()->toString()).'&'. JSession::getFormToken() .'=1'),
			'buttonText' => $created_by_name,
			'buttonIcon' => '',
			'buttonType' => 'uk-button uk-button-link uk-button-mini uk-hidden-large uk-hidden-medium uk-display-block uk-text-right',
			'layoutPath' => JPATH_ROOT .'/components/com_dw_opportunities/layouts/beneficiary',
			'layoutName' => 'info',
			'layoutParams' => array( 'beneficiary_id' => $item -> created_by , 'isPopup'=>true ),
			'scripts'=>array(Juri::base() . 'media/com_donorwiz/js/registration.js')
		), 
		JPATH_ROOT .'/components/com_donorwiz/layouts/popup' , 
		null ); 
	?>
	
	<?php endif;?>
</p>