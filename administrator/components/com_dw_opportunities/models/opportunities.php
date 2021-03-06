<?php

/**
 * @version     1.0.4
 * @package     com_dw_opportunities
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Charalampos Kaklamanos <dev.yesinternet@gmail.com> - http://www.yesinternet.gr
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Dw_opportunities records.
 */
class Dw_opportunitiesModelOpportunities extends JModelList {

    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.6
     */
    public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                                'id', 'a.id',
                'state', 'a.state',
                'title', 'a.title',
                'alias', 'a.alias',
                'created_by', 'a.created_by',
                'created', 'a.created',
                'modified', 'a.modified',
                'modified_by', 'a.modified_by',
                'featured', 'a.featured',
                'publish_up', 'a.publish_up',
                'publish_down', 'a.publish_down',
                'hits', 'a.hits',
                'language', 'a.language',
                'ordering', 'a.ordering',
                'priority', 'a.priority',
                'category', 'a.category',
                'causearea', 'a.causearea',
                'skills', 'a.skills',
                'age', 'a.age',
                'image', 'a.image',
                'description', 'a.description',
                'address', 'a.address',
                'lat', 'a.lat',
                'lng', 'a.lng',
                'date_start', 'a.date_start',
                'date_end', 'a.date_end',
                'time_start', 'a.time_start',
                'time_end', 'a.time_end',
                'parameters', 'a.parameters',
                'images', 'a.images',

            );
        }

        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     */
    protected function populateState($ordering = null, $direction = null) {
        // Initialise variables.
        $app = JFactory::getApplication('administrator');

        // Load the filter state.
        $search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $published = $app->getUserStateFromRequest($this->context . '.filter.state', 'filter_published', '', 'string');
        $this->setState('filter.state', $published);

        
		//Filtering created_by
		$this->setState('filter.created_by', $app->getUserStateFromRequest($this->context.'.filter.created_by', 'filter_created_by', '', 'string'));

		//Filtering created
		$this->setState('filter.created.from', $app->getUserStateFromRequest($this->context.'.filter.created.from', 'filter_from_created', '', 'string'));
		$this->setState('filter.created.to', $app->getUserStateFromRequest($this->context.'.filter.created.to', 'filter_to_created', '', 'string'));

		//Filtering language
		$this->setState('filter.language', $app->getUserStateFromRequest($this->context.'.filter.language', 'filter_language', '', 'string'));

		//Filtering causearea
		$this->setState('filter.causearea', $app->getUserStateFromRequest($this->context.'.filter.causearea', 'filter_causearea', '', 'string'));

		//Filtering skills
		$this->setState('filter.skills', $app->getUserStateFromRequest($this->context.'.filter.skills', 'filter_skills', '', 'string'));

		//Filtering age
		$this->setState('filter.age', $app->getUserStateFromRequest($this->context.'.filter.age', 'filter_age', '', 'string'));


        // Load the parameters.
        $params = JComponentHelper::getParams('com_dw_opportunities');
        $this->setState('params', $params);

        // List state information.
        parent::populateState('a.title', 'asc');
    }

    /**
     * Method to get a store id based on model configuration state.
     *
     * This is necessary because the model is used by the component and
     * different modules that might need different sets of data or different
     * ordering requirements.
     *
     * @param	string		$id	A prefix for the store id.
     * @return	string		A store id.
     * @since	1.6
     */
    protected function getStoreId($id = '') {
        // Compile the store id.
        $id.= ':' . $this->getState('filter.search');
        $id.= ':' . $this->getState('filter.state');

        return parent::getStoreId($id);
    }

    /**
     * Build an SQL query to load the list data.
     *
     * @return	JDatabaseQuery
     * @since	1.6
     */
    protected function getListQuery() {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        $query->select(
                $this->getState(
                        'list.select', 'DISTINCT a.*'
                )
        );
        $query->from('`#__dw_opportunities` AS a');

        
		// Join over the users for the checked out user
		$query->select("uc.name AS editor");
		$query->join("LEFT", "#__users AS uc ON uc.id=a.checked_out");
		// Join over the user field 'created_by'
		$query->select('created_by.name AS created_by');
		$query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');
		// Join over the user field 'modified_by'
		$query->select('modified_by.name AS modified_by');
		$query->join('LEFT', '#__users AS modified_by ON modified_by.id = a.modified_by');

        

		// Filter by published state
		$published = $this->getState('filter.state');
		if (is_numeric($published)) {
			$query->where('a.state = ' . (int) $published);
		} else if ($published === '') {
			$query->where('(a.state IN (0, 1))');
		}

        // Filter by search in title
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('a.id = ' . (int) substr($search, 3));
            } else {
                $search = $db->Quote('%' . $db->escape($search, true) . '%');
                $query->where('( a.title LIKE '.$search.'  OR  a.language LIKE '.$search.'  OR  a.skills LIKE '.$search.'  OR  a.age LIKE '.$search.'  OR  a.description LIKE '.$search.'  OR  a.address LIKE '.$search.' )');
            }
        }

        

		//Filtering created_by
		$filter_created_by = $this->state->get("filter.created_by");
		if ($filter_created_by) {
			$query->where("a.created_by = '".$db->escape($filter_created_by)."'");
		}

		//Filtering created
		$filter_created_from = $this->state->get("filter.created.from");
		if ($filter_created_from) {
			$query->where("a.created >= '".$db->escape($filter_created_from)."'");
		}
		$filter_created_to = $this->state->get("filter.created.to");
		if ($filter_created_to) {
			$query->where("a.created <= '".$db->escape($filter_created_to)."'");
		}

		//Filtering language

		//Filtering causearea
		$filter_causearea = $this->state->get("filter.causearea");
		if ($filter_causearea) {
			$query->where("a.causearea = '".$db->escape($filter_causearea)."'");
		}

		//Filtering skills
		$filter_skills = $this->state->get("filter.skills");
		if ($filter_skills) {
			$query->where("a.skills LIKE '%\"".$db->escape($filter_skills)."\"%'");
		}

		//Filtering age
		$filter_age = $this->state->get("filter.age");
		if ($filter_age) {
			$query->where("a.age = '".$db->escape($filter_age)."'");
		}


        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering');
        $orderDirn = $this->state->get('list.direction');
        if ($orderCol && $orderDirn) {
            $query->order($db->escape($orderCol . ' ' . $orderDirn));
        }

        return $query;
    }

    public function getItems() {
        $items = parent::getItems();
        
        return $items;
    }

}
