<?php

// no direct access
defined('_JEXEC') or die;

include_once JPATH_ROOT.'/components/com_community/libraries/core.php';

$created_by_id = $displayData['created_by_id'];

$item = $displayData['item'];

$created_by = CFactory::getUser( $created_by_id ) ;

$created_by_name = $created_by->getDisplayName();

$avatarUrl = $created_by->getThumbAvatar();

$link = CRoute::_('index.php?option=com_community&view=profile&userid='.$created_by_id); 
?>

<div class="uk-text-center" >

	<a href="<?php echo $link; ?>" style="text-decoration:none!important">
		<img class="uk-thumbnail" src="<?php echo $avatarUrl ; ?>" alt="<?php echo $created_by_name; ?>" title="<?php echo $created_by_name; ?>">
	</a>
	<br>
	<p class="uk-article-meta uk-margin-remove">
		<?php echo JText::_('COM_DW_OPPORTUNITIES_ITEM_POST_BY');?>  <a href="<?php echo $link; ?>"><?php echo $created_by_name; ?></a>
		<br/>
		<?php echo JFactory::getDate($item->created)->format('D, d M Y');?>
		<br/>
		<span class="uk-badge uk-badge-success"><?php echo JTEXT::_($item->category); ?></span>
	</p>
	
	<div class="fb-share-button showonhover uk-margin-small-top" style="display:none;" data-href="<?php echo JRoute::_('index.php?option=com_dw_opportunities&view=dwopportunity&Itemid=0&id='.(int) $item->id); ?>" data-layout="button_count"></div>

	
</div>