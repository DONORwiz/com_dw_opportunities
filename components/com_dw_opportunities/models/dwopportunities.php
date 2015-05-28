<?php

/**
 * @version     1.0.3
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
class Dw_opportunitiesModelDwOpportunities extends JModelList
{

	/**
	 * Constructor.
	 *
	 * @param    array    An optional associative array of configuration settings.
	 *
	 * @see        JController
	 * @since      1.6
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
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
	 *
	 * @since    1.6
	 */
	protected function populateState($ordering = null, $direction = null)
	{


		// Initialise variables.
		$app = JFactory::getApplication();

		// List state information
		$limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'));
		$this->setState('list.limit', $limit);

		$limitstart = $app->input->getInt('limitstart', 0);
		$this->setState('list.start', $limitstart);
		
		if ($list = $app->getUserStateFromRequest($this->context . '.list', 'list', array(), 'array'))
		{
			foreach ($list as $name => $value)
			{
				// Extra validations
				switch ($name)
				{
					case 'fullordering':
						$orderingParts = explode(' ', $value);

						if (count($orderingParts) >= 2)
						{
							// Latest part will be considered the direction
							$fullDirection = end($orderingParts);

							if (in_array(strtoupper($fullDirection), array('ASC', 'DESC', '')))
							{
								$this->setState('list.direction', $fullDirection);
							}

							unset($orderingParts[count($orderingParts) - 1]);

							// The rest will be the ordering
							$fullOrdering = implode(' ', $orderingParts);

							if (in_array($fullOrdering, $this->filter_fields))
							{
								$this->setState('list.ordering', $fullOrdering);
							}
						}
						else
						{
							$this->setState('list.ordering', $ordering);
							$this->setState('list.direction', $direction);
						}
						break;

					case 'ordering':
						if (!in_array($value, $this->filter_fields))
						{
							$value = $ordering;
						}
						break;

					case 'direction':
						if (!in_array(strtoupper($value), array('ASC', 'DESC', '')))
						{
							$value = $direction;
						}
						break;

					case 'limit':
						$limit = $value;
						break;

					// Just to keep the default case
					default:
						$value = $value;
						break;
				}

				$this->setState('list.' . $name, $value);
			}
		}

		// Receive & set filters
		if ($filters = $app->getUserStateFromRequest($this->context . '.filter', 'filter', array(), 'array'))
		{
			foreach ($filters as $name => $value)
			{
				$this->setState('filter.' . $name, $value);
			}
		}
				
		$ordering = $app->input->get('filter_order');
		if (!empty($ordering))
		{
			$list             = $app->getUserState($this->context . '.list');
			$list['ordering'] = $app->input->get('filter_order');
			$app->setUserState($this->context . '.list', $list);
		}

		$orderingDirection = $app->input->get('filter_order_Dir');
		if (!empty($orderingDirection))
		{
			$list              = $app->getUserState($this->context . '.list');
			$list['direction'] = $app->input->get('filter_order_Dir');
			$app->setUserState($this->context . '.list', $list);
		}

		$list = $app->getUserState($this->context . '.list');

		if (empty($list['ordering']))
		{
			$list['ordering'] = 'created';
		}

		if (empty($list['direction']))
		{
			$list['direction'] = 'desc';
		}

		$this->setState('list.ordering', $list['ordering']);
		$this->setState('list.direction', $list['direction']);
	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return    JDatabaseQuery
	 * @since    1.6
	 */
	protected function getListQuery()
	{
		// Create a new query object.
		$db    = $this->getDbo();
		$query = $db->getQuery(true);

		// Select the required fields from the table.
		$query
			->select(
				$this->getState(
					'list.select', 'DISTINCT a.*'
				)
			);
		
		$lat = $this->getState('filter.lat');
		$lng = $this->getState('filter.lng');		
		
		if( $lat && $lng )
		{
			//search nearest locations
			$query->select('( 6371 * acos( cos( radians( '.$lat.' ) ) * cos( radians( a.lat ) ) * cos( radians( a.lng ) - radians( '.$lng.' ) ) + sin( radians( '.$lat.' ) ) * sin( radians( a.lat ) ) ) ) AS distance');
		}

		$query->from('`#__dw_opportunities` AS a');

		//donor_id - yesinternet
		$filter_donor_id = $this->state->get("filter.donor_id");
		$filter_dashboard = $this->state->get("filter.dashboard");
		
		if ($filter_donor_id && $filter_dashboard == 'true') {
			
			$query->join('LEFT', '#__dw_opportunities_responses AS b ON a.id = b.opportunity_id');
		
		}

		// // Join over the users for the checked out user.
		// $query->select('uc.name AS editor');
		// $query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');
    
		// // Join over the created by field 'created_by'
		// $query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');
		// // Join over the created by field 'modified_by'
		// $query->join('LEFT', '#__users AS modified_by ON modified_by.id = a.modified_by');


		//Filtering state - yesinternet
		
		$filter_state = $this->state->get("filter.state");
		$canEditStateOpportunity = JFactory::getUser()->authorise('core.edit.state', 'com_dw_opportunities');
		
		if( $filter_dashboard == 'true' && $canEditStateOpportunity)
		{
			if( $filter_state =='1' || $filter_state =='0' )
				$query->where("a.state = '".$db->escape($filter_state)."'");
			else
				$query->where("(a.state = '1' OR a.state = '0')");
		}
		else
		{
			$query->where("a.state = '1'");
		}
		
		// Filter by search in title
		// $search = $this->getState('filter.search');
		// if (!empty($search))
		// {
			// if (stripos($search, 'id:') === 0)
			// {
				// $query->where('a.id = ' . (int) substr($search, 3));
			// }
			// else
			// {
				// $search = $db->Quote('%' . $db->escape($search, true) . '%');
				// $query->where('( a.title LIKE '.$search.'  OR  a.language LIKE '.$search.'  OR  a.description LIKE '.$search.'  OR  a.address LIKE '.$search.' )');
			// }
		// }

		

		//Filtering created_by
		$filter_created_by = $this->state->get("filter.created_by");
		if ($filter_created_by) {
			$query->where("a.created_by = '".$db->escape($filter_created_by)."'");
		}

		//Filtering created

		//Checking "_dateformat"
		$filter_created_from = $this->state->get("filter.created_from_dateformat");
		if ($filter_created_from && preg_match("/^(19|20)\d\d[-](0[1-9]|1[012])[-](0[1-9]|[12][0-9]|3[01])$/", $filter_created_from) && date_create($filter_created_from) ) {
			$query->where("a.created >= '".$db->escape($filter_created_from)."'");
		}
		$filter_created_to = $this->state->get("filter.created_to_dateformat");
		if ($filter_created_to && preg_match("/^(19|20)\d\d[-](0[1-9]|1[012])[-](0[1-9]|[12][0-9]|3[01])$/", $filter_created_to) && date_create($filter_created_to) ) {
			$query->where("a.created <= '".$db->escape($filter_created_to)."'");
		}

		//Filtering language

		//Filtering category
		$filter_category = $this->state->get("filter.category");
		if ($filter_category) {
			$query->where("a.category = '".$db->escape($filter_category)."'");
		}

		//Force category filtering to local if lat,lng
		if($lat&$lng)
		{
			$query->where("a.category = 'local'");
		}
		
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
		// $filter_age = $this->state->get("filter.age");
		// if ($filter_age) {
			// $query->where("a.age = '".$db->escape($filter_age)."'");
		// }
		
		//donor_id - yesinternet
		$filter_donor_id = $this->state->get("filter.donor_id");
	
		if ( $filter_donor_id && $filter_dashboard == 'true' ) {
			
			$query->where("b.created_by = '".$db->escape($filter_donor_id)."'");
			$query->where("b.state = '1'");
		}
		
		//lat lng  - yesinternet
		if($lat&&$lng){
			$query->having( $db->escape( 'distance < 50' ) );
			$query->order( $db->escape( 'distance DESC' ) );
		}		
		
		//Featured first - yesinternet
        $query->order($db->escape('a.featured DESC'));
		

		// Add the list ordering clause.
		$orderCol  = $this->state->get('list.ordering');
		$orderDirn = $this->state->get('list.direction');
		
		if ($orderCol && $orderDirn)
		{
			$query->order($db->escape($orderCol . ' ' . $orderDirn));
		}

		return $query;
	}

	public function getItems()
	{
		$items = parent::getItems();
		
		if ( is_array( $items ) )
		{
			JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_dw_opportunities_responses/models', 'Dw_opportunities_responsesModel');
		
			foreach($items as $item){
		
				//$item->category = JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITIES_CATEGORY_OPTION_' . strtoupper($item->category));
				//$item->causearea = JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITIES_CAUSEAREA_OPTION_' . strtoupper($item->causearea));
				// Get the title of every option selected.
				//$options = json_decode($item->skills);
				//$options_text = array();
				//foreach($options as $option){
					//$options_text[] = JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITIES_SKILLS_OPTION_' . strtoupper($option));
				//}
				//$item->skills = !empty($options_text) ? implode(',', $options_text) : $item->skills;
				if ( isset ( $item->id ) ){
					$item->url = JRoute::_('index.php?option=com_dw_opportunities&view=dwopportunity&Itemid=261&id='.$item->id);
				}
				
				$responsesModel = JModelLegacy::getInstance('DwOpportunitiesresponses', 'Dw_opportunities_responsesModel', array('ignore_request' => true));
				$item -> responses = $responsesModel -> getItemsByOpportunity( $item  );
			
			}
		}

		return $items;
	}
	
	
	public function getCount( )
    {
		$this -> setState ('list.select', 'COUNT(*) as count');
		
		$row = $this -> getItems() ;
		
		$count = $row[0] -> count ;

		return $count;
    }
	
	/**
	 * Overrides the default function to check Date fields format, identified by
	 * "_dateformat" suffix, and erases the field if it's not correct.
	 */
	protected function loadFormData()
	{
		$app              = JFactory::getApplication();
		$filters          = $app->getUserState($this->context . '.filter', array());
		$error_dateformat = false;
		foreach ($filters as $key => $value)
		{
			if (strpos($key, '_dateformat') && !empty($value) && !$this->isValidDate($value))
			{
				$filters[$key]    = '';
				$error_dateformat = true;
			}
		}
		if ($error_dateformat)
		{
			$app->enqueueMessage(JText::_("COM_PRUEBA_SEARCH_FILTER_DATE_FORMAT"), "warning");
			$app->setUserState($this->context . '.filter', $filters);
		}

		return parent::loadFormData();
	}

	/**
	 * Checks if a given date is valid and in an specified format (YYYY-MM-DD)
	 *
	 * @param string Contains the date to be checked
	 *
	 */
	private function isValidDate($date)
	{
		return preg_match("/^(19|20)\d\d[-](0[1-9]|1[012])[-](0[1-9]|[12][0-9]|3[01])$/", $date) && date_create($date);
	}

}
