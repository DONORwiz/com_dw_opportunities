<?php

/**
 * @version     1.0.3
 * @package     com_dw_opportunities
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Charalampos Kaklamanos <dev.yesinternet@gmail.com> - http://www.yesinternet.gr
 */
// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modelitem');
jimport('joomla.event.dispatcher');

/**
 * Dw_opportunities model.
 */
class Dw_opportunitiesModelDwOpportunity extends JModelItem {

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @since	1.6
     */
    protected function populateState() {
        
		$app = JFactory::getApplication('com_dw_opportunities');

        // Load state from the request userState on edit or from the passed variable on default
        if (JFactory::getApplication()->input->get('layout') == 'edit') {
            $id = JFactory::getApplication()->getUserState('com_dw_opportunities.edit.opportunity.id');
        } else {
            $id = JFactory::getApplication()->input->get('id');
            JFactory::getApplication()->setUserState('com_dw_opportunities.edit.opportunity.id', $id);
        }
        $this->setState('opportunity.id', $id);

        // Load the parameters.
        $params = $app->getParams();
        $params_array = $params->toArray();
        if (isset($params_array['item_id'])) {
            $this->setState('opportunity.id', $params_array['item_id']);
        }
        $this->setState('params', $params);
    }

    /**
     * Method to get an ojbect.
     *
     * @param	integer	The id of the object to get.
     *
     * @return	mixed	Object on success, false on failure.
     */
    public function &getData($id = null) {
        if ($this->_item === null) {
            $this->_item = false;

            if (empty($id)) {
                $id = $this->getState('opportunity.id');
            }

            // Get a level row instance.
            $table = $this->getTable();

            // Attempt to load the row.
            if ($table->load($id)) {
                // Check published state.
                if ($published = $this->getState('filter.published')) {
                    if ($table->state != $published) {
                        return $this->_item;
                    }
                }

                // Convert the JTable to a clean JObject.
                $properties = $table->getProperties(1);
                $this->_item = JArrayHelper::toObject($properties, 'JObject');
            } elseif ($error = $table->getError()) {
                $this->setError($error);
            }
        }

		if ( isset($this->_item->created_by) ) {
			$this->_item->created_by_name = JFactory::getUser($this->_item->created_by)->name;
		}
		
		if ( isset($this->_item->modified_by) ) {
			$this->_item->modified_by_name = JFactory::getUser($this->_item->modified_by)->name;
		}
		
		//$this->_item->category = JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITIES_CATEGORY_OPTION_' . $this->_item->category);
		//$this->_item->causearea = JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITIES_CAUSEAREA_OPTION_' . $this->_item->causearea);

		// Get the title of every option selected.

		// $options = json_decode($this->_item->skills);

		// $options_text = array();

		// foreach($options as $option){
			// $options_text[] = JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITIES_SKILLS_OPTION_' . $option);

		// }
		// $this->_item->skills = !empty($options_text) ? implode(',', $options_text) : $this->_item->skills;
		//$this->_item->age = JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITIES_AGE_OPTION_' . $this->_item->age);

		$this -> _item -> url 				= JRoute::_('index.php?option=com_dw_opportunities&view=dwopportunity&id='.$this->_item->id );
		$this -> _item -> parameters 		= json_decode($this->_item->parameters);
		$this -> _item -> startDateExpired 	= $this-> getItemStartDateExpired( $this->_item->date_start );

		//Get item responses
		$this->_item-> userResponses = $this -> getItemUserResponses( JFactory::getUser() , $id );
		$this->_item-> responses = $this -> getItemResponses( $this->_item );
		
		$this->_item->volunteersNeeded = $this -> getItemVolunteersNeeded( $this->_item );
		$this->_item->availablePositions = $this -> getItemAvailablePositions( $this->_item );
		
		return $this->_item;
    }

	protected function getItemUserResponses ( $user , $id ){
		
		JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_dw_opportunities_responses/models', 'Dw_opportunities_responsesModel');
		$responsesModel = JModelLegacy::getInstance('DwOpportunitiesresponses', 'Dw_opportunities_responsesModel', array('ignore_request' => true));	
		$responses = $responsesModel -> getItemsByUser( $user , $id );
		return $responses;
	
	}

	protected function getItemResponses ( $item ){
		
		JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_dw_opportunities_responses/models', 'Dw_opportunities_responsesModel');
		
		$responsesModel = JModelLegacy::getInstance('DwOpportunitiesresponses', 'Dw_opportunities_responsesModel', array('ignore_request' => true));	
		
		$responses = $responsesModel -> getItemsByOpportunity( $item );
		
		return $responses;
	}
	
	protected function getItemStartDateExpired( $date_start ){
		
		$startDateExpired = false;
		
		//Check if start date is earlier than today
		$date_start = strtotime( $date_start );
		
		if( $date_start != false ){
		
			$today = strtotime( JFactory::getDate()->format('Y-m-d') );
		
			$data_diff = $date_start - 	$today ;
			
			if ( $data_diff <= 0 ){
				$startDateExpired = true;
			}
		
		}
		
		return $startDateExpired;
		
	}
	
	protected function getItemAvailablePositions( $item ){
	
		$availablePositions = ( $item->volunteersNeeded ) ? ( $item->volunteersNeeded - $item->responses['statistics']['accepted'] ) : 1000 ;
		
		return ( $availablePositions > 0 ) ? $availablePositions : 0 ;
		
	}
	
	protected function getItemVolunteersNeeded( $item ){
		
		if ( isset ( $item->parameters->volunteers_no_enabled ) && $item->parameters->volunteers_no_enabled=='1' && isset ( $item->parameters->volunteers_no ) ){
			return $item->parameters->volunteers_no;
		}
		else{
			return null ;
		}

	}
	


    public function getTable($type = 'Opportunity', $prefix = 'Dw_opportunitiesTable', $config = array()) {
        $this->addTablePath( JPATH_ADMINISTRATOR . '/components/com_dw_opportunities/tables');
        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * Method to check in an item.
     *
     * @param	integer		The id of the row to check out.
     * @return	boolean		True on success, false on failure.
     * @since	1.6
     */
    public function checkin($id = null) {
        // Get the id.
        $id = (!empty($id)) ? $id : (int) $this->getState('opportunity.id');

        if ($id) {

            // Initialise the table
            $table = $this->getTable();

            // Attempt to check the row in.
            if (method_exists($table, 'checkin')) {
                if (!$table->checkin($id)) {
                    $this->setError($table->getError());
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Method to check out an item for editing.
     *
     * @param	integer		The id of the row to check out.
     * @return	boolean		True on success, false on failure.
     * @since	1.6
     */
    public function checkout($id = null) {
        // Get the user id.
        $id = (!empty($id)) ? $id : (int) $this->getState('opportunity.id');

        if ($id) {

            // Initialise the table
            $table = $this->getTable();

            // Get the current user object.
            $user = JFactory::getUser();

            // Attempt to check the row out.
            if (method_exists($table, 'checkout')) {
                if (!$table->checkout($user->get('id'), $id)) {
                    $this->setError($table->getError());
                    return false;
                }
            }
        }

        return true;
    }

    public function getCategoryName($id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query
                ->select('title')
                ->from('#__categories')
                ->where('id = ' . $id);
        $db->setQuery($query);
        return $db->loadObject();
    }

    public function publish($id, $state) {
        $table = $this->getTable();
        $table->load($id);
        $table->state = $state;
        return $table->store();
    }

    public function delete($id) {
        $table = $this->getTable();
        return $table->delete($id);
    }

}
