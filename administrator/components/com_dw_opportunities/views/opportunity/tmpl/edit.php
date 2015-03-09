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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_dw_opportunities/assets/css/dw_opportunities.css');
?>
<script type="text/javascript">
    js = jQuery.noConflict();
    js(document).ready(function() {
        
    });

    Joomla.submitbutton = function(task)
    {
        if (task == 'opportunity.cancel') {
            Joomla.submitform(task, document.getElementById('opportunity-form'));
        }
        else {
            
            if (task != 'opportunity.cancel' && document.formvalidator.isValid(document.id('opportunity-form'))) {
                
                Joomla.submitform(task, document.getElementById('opportunity-form'));
            }
            else {
                alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
            }
        }
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_dw_opportunities&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="opportunity-form" class="form-validate">

    <div class="form-horizontal">
        <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_DW_OPPORTUNITIES_TITLE_OPPORTUNITY', true)); ?>
        <div class="row-fluid">
            <div class="span10 form-horizontal">
                <fieldset class="adminform">

                    				<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('state'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('state'); ?></div>
			</div>
				<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
				<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('title'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('title'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('alias'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('alias'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('created_by'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('created_by'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('created'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('created'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('modified'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('modified'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('modified_by'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('modified_by'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('featured'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('featured'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('publish_up'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('publish_up'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('publish_down'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('publish_down'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('hits'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('hits'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('language'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('language'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('priority'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('priority'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('category'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('category'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('causearea'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('causearea'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('skills'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('skills'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('age'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('age'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('image'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('image'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('description'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('description'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('address'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('address'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('lat'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('lat'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('lng'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('lng'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('date_start'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('date_start'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('date_end'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('date_end'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('time_start'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('time_start'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('time_end'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('time_end'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('parameters'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('parameters'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('images'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('images'); ?></div>
			</div>


                </fieldset>
            </div>
        </div>
        <?php echo JHtml::_('bootstrap.endTab'); ?>
        
        

        <?php echo JHtml::_('bootstrap.endTabSet'); ?>

        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>

    </div>
</form>