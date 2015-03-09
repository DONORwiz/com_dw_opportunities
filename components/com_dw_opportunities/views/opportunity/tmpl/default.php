<?php
/**
 * @version     1.0.4
 * @package     com_dw_opportunities
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Charalampos Kaklamanos <dev.yesinternet@gmail.com> - http://www.yesinternet.gr
 */
// no direct access
defined('_JEXEC') or die;

$canEdit = JFactory::getUser()->authorise('core.edit', 'com_dw_opportunities');
if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_dw_opportunities')) {
	$canEdit = JFactory::getUser()->id == $this->item->created_by;
}
?>
<?php if ($this->item) : ?>

    <div class="item_fields">
        <table class="table">
            <tr>
			<th><?php echo JText::_('COM_DW_OPPORTUNITIES_FORM_LBL_OPPORTUNITY_ID'); ?></th>
			<td><?php echo $this->item->id; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DW_OPPORTUNITIES_FORM_LBL_OPPORTUNITY_STATE'); ?></th>
			<td>
			<i class="icon-<?php echo ($this->item->state == 1) ? 'publish' : 'unpublish'; ?>"></i></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DW_OPPORTUNITIES_FORM_LBL_OPPORTUNITY_TITLE'); ?></th>
			<td><?php echo $this->item->title; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DW_OPPORTUNITIES_FORM_LBL_OPPORTUNITY_ALIAS'); ?></th>
			<td><?php echo $this->item->alias; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DW_OPPORTUNITIES_FORM_LBL_OPPORTUNITY_CREATED_BY'); ?></th>
			<td><?php echo $this->item->created_by_name; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DW_OPPORTUNITIES_FORM_LBL_OPPORTUNITY_CREATED'); ?></th>
			<td><?php echo $this->item->created; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DW_OPPORTUNITIES_FORM_LBL_OPPORTUNITY_MODIFIED'); ?></th>
			<td><?php echo $this->item->modified; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DW_OPPORTUNITIES_FORM_LBL_OPPORTUNITY_MODIFIED_BY'); ?></th>
			<td><?php echo $this->item->modified_by_name; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DW_OPPORTUNITIES_FORM_LBL_OPPORTUNITY_FEATURED'); ?></th>
			<td></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DW_OPPORTUNITIES_FORM_LBL_OPPORTUNITY_PUBLISH_UP'); ?></th>
			<td><?php echo $this->item->publish_up; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DW_OPPORTUNITIES_FORM_LBL_OPPORTUNITY_PUBLISH_DOWN'); ?></th>
			<td><?php echo $this->item->publish_down; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DW_OPPORTUNITIES_FORM_LBL_OPPORTUNITY_HITS'); ?></th>
			<td><?php echo $this->item->hits; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DW_OPPORTUNITIES_FORM_LBL_OPPORTUNITY_LANGUAGE'); ?></th>
			<td><?php echo $this->item->language; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DW_OPPORTUNITIES_FORM_LBL_OPPORTUNITY_PRIORITY'); ?></th>
			<td><?php echo $this->item->priority; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DW_OPPORTUNITIES_FORM_LBL_OPPORTUNITY_CATEGORY'); ?></th>
			<td><?php echo $this->item->category; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DW_OPPORTUNITIES_FORM_LBL_OPPORTUNITY_CAUSEAREA'); ?></th>
			<td><?php echo $this->item->causearea; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DW_OPPORTUNITIES_FORM_LBL_OPPORTUNITY_SKILLS'); ?></th>
			<td><?php echo $this->item->skills; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DW_OPPORTUNITIES_FORM_LBL_OPPORTUNITY_AGE'); ?></th>
			<td><?php echo $this->item->age; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DW_OPPORTUNITIES_FORM_LBL_OPPORTUNITY_IMAGE'); ?></th>
			<td><?php echo $this->item->image; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DW_OPPORTUNITIES_FORM_LBL_OPPORTUNITY_DESCRIPTION'); ?></th>
			<td><?php echo $this->item->description; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DW_OPPORTUNITIES_FORM_LBL_OPPORTUNITY_ADDRESS'); ?></th>
			<td><?php echo $this->item->address; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DW_OPPORTUNITIES_FORM_LBL_OPPORTUNITY_LAT'); ?></th>
			<td><?php echo $this->item->lat; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DW_OPPORTUNITIES_FORM_LBL_OPPORTUNITY_LNG'); ?></th>
			<td><?php echo $this->item->lng; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DW_OPPORTUNITIES_FORM_LBL_OPPORTUNITY_DATE_START'); ?></th>
			<td><?php echo $this->item->date_start; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DW_OPPORTUNITIES_FORM_LBL_OPPORTUNITY_DATE_END'); ?></th>
			<td><?php echo $this->item->date_end; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DW_OPPORTUNITIES_FORM_LBL_OPPORTUNITY_TIME_START'); ?></th>
			<td><?php echo $this->item->time_start; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DW_OPPORTUNITIES_FORM_LBL_OPPORTUNITY_TIME_END'); ?></th>
			<td><?php echo $this->item->time_end; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DW_OPPORTUNITIES_FORM_LBL_OPPORTUNITY_PARAMETERS'); ?></th>
			<td><?php echo $this->item->parameters; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_DW_OPPORTUNITIES_FORM_LBL_OPPORTUNITY_IMAGES'); ?></th>
			<td><?php echo $this->item->images; ?></td>
</tr>

        </table>
    </div>
    <?php if($canEdit && $this->item->checked_out == 0): ?>
		<a class="btn" href="<?php echo JRoute::_('index.php?option=com_dw_opportunities&task=opportunity.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_DW_OPPORTUNITIES_EDIT_ITEM"); ?></a>
	<?php endif; ?>
								<?php if(JFactory::getUser()->authorise('core.delete','com_dw_opportunities')):?>
									<a class="btn" href="<?php echo JRoute::_('index.php?option=com_dw_opportunities&task=opportunity.remove&id=' . $this->item->id, false, 2); ?>"><?php echo JText::_("COM_DW_OPPORTUNITIES_DELETE_ITEM"); ?></a>
								<?php endif; ?>
    <?php
else:
    echo JText::_('COM_DW_OPPORTUNITIES_ITEM_NOT_LOADED');
endif;
?>
