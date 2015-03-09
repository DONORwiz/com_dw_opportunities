<?php

/**
 * @version     1.0.4
 * @package     com_dw_opportunities
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Charalampos Kaklamanos <dev.yesinternet@gmail.com> - http://www.yesinternet.gr
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of Dw_opportunities.
 */
class Dw_opportunitiesViewOpportunities extends JViewLegacy {

    protected $items;
    protected $pagination;
    protected $state;

    /**
     * Display the view
     */
    public function display($tpl = null) {
        $this->state = $this->get('State');
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

        Dw_opportunitiesHelper::addSubmenu('opportunities');

        $this->addToolbar();

        $this->sidebar = JHtmlSidebar::render();
        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     * @since	1.6
     */
    protected function addToolbar() {
        require_once JPATH_COMPONENT . '/helpers/dw_opportunities.php';

        $state = $this->get('State');
        $canDo = Dw_opportunitiesHelper::getActions($state->get('filter.category_id'));

        JToolBarHelper::title(JText::_('COM_DW_OPPORTUNITIES_TITLE_OPPORTUNITIES'), 'opportunities.png');

        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/opportunity';
        if (file_exists($formPath)) {

            if ($canDo->get('core.create')) {
                JToolBarHelper::addNew('opportunity.add', 'JTOOLBAR_NEW');
            }

            if ($canDo->get('core.edit') && isset($this->items[0])) {
                JToolBarHelper::editList('opportunity.edit', 'JTOOLBAR_EDIT');
            }
        }

        if ($canDo->get('core.edit.state')) {

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::custom('opportunities.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
                JToolBarHelper::custom('opportunities.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            } else if (isset($this->items[0])) {
                //If this component does not use state then show a direct delete button as we can not trash
                JToolBarHelper::deleteList('', 'opportunities.delete', 'JTOOLBAR_DELETE');
            }

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::archiveList('opportunities.archive', 'JTOOLBAR_ARCHIVE');
            }
            if (isset($this->items[0]->checked_out)) {
                JToolBarHelper::custom('opportunities.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
            }
        }

        //Show trash and delete for components that uses the state field
        if (isset($this->items[0]->state)) {
            if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
                JToolBarHelper::deleteList('', 'opportunities.delete', 'JTOOLBAR_EMPTY_TRASH');
                JToolBarHelper::divider();
            } else if ($canDo->get('core.edit.state')) {
                JToolBarHelper::trash('opportunities.trash', 'JTOOLBAR_TRASH');
                JToolBarHelper::divider();
            }
        }

        if ($canDo->get('core.admin')) {
            JToolBarHelper::preferences('com_dw_opportunities');
        }

        //Set sidebar action - New in 3.0
        JHtmlSidebar::setAction('index.php?option=com_dw_opportunities&view=opportunities');

        $this->extra_sidebar = '';
        
		JHtmlSidebar::addFilter(

			JText::_('JOPTION_SELECT_PUBLISHED'),

			'filter_published',

			JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), "value", "text", $this->state->get('filter.state'), true)

		);

		//Filter for the field created_by
		$this->extra_sidebar .= '<small><label for="filter_created_by">Created by</label></small>';
		$this->extra_sidebar .= JHtmlList::users('filter_created_by', $this->state->get('filter.created_by'), 1, 'onchange="this.form.submit();"');
			//Filter for the field created
			$this->extra_sidebar .= '<small><label for="filter_from_created">'. JText::sprintf('COM_DW_OPPORTUNITIES_FROM_FILTER', 'Created') .'</label></small>';
			$this->extra_sidebar .= JHtml::_('calendar', $this->state->get('filter.created.from'), 'filter_from_created', 'filter_from_created', '%Y-%m-%d', array('style' => 'width:142px;', 'onchange' => 'this.form.submit();'));
			$this->extra_sidebar .= '<small><label for="filter_to_created">'. JText::sprintf('COM_DW_OPPORTUNITIES_TO_FILTER', 'Created') .'</label></small>';
			$this->extra_sidebar .= JHtml::_('calendar', $this->state->get('filter.created.to'), 'filter_to_created', 'filter_to_created', '%Y-%m-%d', array('style' => 'width:142px;', 'onchange'=> 'this.form.submit();'));
			$this->extra_sidebar .= '<hr class="hr-condensed">';

		//Filter for the field causearea
		$select_label = JText::sprintf('COM_DW_OPPORTUNITIES_FILTER_SELECT_LABEL', 'Causearea');
		$options = array();
		$options[0] = new stdClass();
		$options[0]->value = "FIELD_OBJECTIVE_NONE";
		$options[0]->text = "FIELD_OBJECTIVE_NONE";
		JHtmlSidebar::addFilter(
			$select_label,
			'filter_causearea',
			JHtml::_('select.options', $options , "value", "text", $this->state->get('filter.causearea'), true)
		);

		//Filter for the field skills
		$select_label = JText::sprintf('COM_DW_OPPORTUNITIES_FILTER_SELECT_LABEL', 'Skills');
		$options = array();
		$options[0] = new stdClass();
		$options[0]->value = "FIELD_SKILLS_NONE";
		$options[0]->text = "FIELD_SKILLS_NONE";
		JHtmlSidebar::addFilter(
			$select_label,
			'filter_skills',
			JHtml::_('select.options', $options , "value", "text", $this->state->get('filter.skills'), true)
		);

		//Filter for the field age
		$select_label = JText::sprintf('COM_DW_OPPORTUNITIES_FILTER_SELECT_LABEL', 'Age');
		$options = array();
		$options[0] = new stdClass();
		$options[0]->value = "kids";
		$options[0]->text = "Kids";
		$options[1] = new stdClass();
		$options[1]->value = "teens";
		$options[1]->text = "Teens";
		$options[2] = new stdClass();
		$options[2]->value = "adults";
		$options[2]->text = "Adults";
		$options[3] = new stdClass();
		$options[3]->value = "mature";
		$options[3]->text = "Mature";
		JHtmlSidebar::addFilter(
			$select_label,
			'filter_age',
			JHtml::_('select.options', $options , "value", "text", $this->state->get('filter.age'), true)
		);

    }

	protected function getSortFields()
	{
		return array(
		'a.id' => JText::_('JGRID_HEADING_ID'),
		'a.state' => JText::_('JSTATUS'),
		'a.title' => JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITIES_TITLE'),
		'a.created_by' => JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITIES_CREATED_BY'),
		'a.created' => JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITIES_CREATED'),
		'a.featured' => JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITIES_FEATURED'),
		'a.hits' => JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITIES_HITS'),
		'a.language' => JText::_('JGRID_HEADING_LANGUAGE'),
		'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
		'a.priority' => JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITIES_PRIORITY'),
		);
	}

}
