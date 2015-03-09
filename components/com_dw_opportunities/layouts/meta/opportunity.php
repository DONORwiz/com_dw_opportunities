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

<p class="uk-article-meta uk-margin-remove">
	<?php if( !JFactory::getApplication()->input->get('dashboard','','string') ) : ?>
	<?php echo JText::_('COM_DW_OPPORTUNITIES_ITEM_POST_BY');?>  <a href="<?php echo $link; ?>"><?php echo $created_by_name; ?></a>
	<?php endif;?>
	<?php echo JFactory::getDate($item->created)->format('D, d M Y');?>
</p>