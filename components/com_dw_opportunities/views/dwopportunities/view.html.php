<?php

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of Volunteers.
 */
class Dw_opportunitiesViewDwOpportunities extends JViewLegacy {

    protected $items;
    protected $pagination;
    protected $state;
    protected $params;

    /**
     * Display the view
     */
    public function display($tpl = null) {
        
		$app = JFactory::getApplication();

        $this->state = $this->get('State');
		$this->items = $this->get('Items');
		$this->jinputFilter = $app->input->get('filter','','array');

		//Default ordering
		if( $app->input->get('filter_order','','string')=='' )
		{
			$this->state->set('list.ordering','a.created');
		}
		
		//Default ordering
		if( $app->input->get('filter_order_Dir','','string')=='' )
		{
			$this->state->set('list.direction','desc');
		}

		$jinputFilter = $this->jinputFilter;
		
		//Default created_by
		if(!isset($jinputFilter['created_by']))
		{
			$this->state->set('filter.created_by','');
		}
		//Default causearea
		if(!isset($jinputFilter['causearea']))
		{
			$this->state->set('filter.causearea','');
		}		

		//Default category
		if(!isset($jinputFilter['category']))
		{
			$this->state->set('filter.category','');
		}

		//Default category
		if(!isset($jinputFilter['dashboard']))
		{
			$this->state->set('filter.dashboard','');
		}
		
		//Default lat
		if( !isset ( $jinputFilter['lat'] ) )
		{
			$this->state->set('filter.lat','0');
		}
		//Default lng
		if( !isset ( $jinputFilter['lng'] ) )
		{
			$this->state->set('filter.lng','0');
		}
		
		$this->pagination = $this->get('Pagination');

        $this->params = $app->getParams('com_dw_opportunities');
        
		//$this->filterForm = $this->get('FilterForm');
		//$this->activeFilters = $this->get('ActiveFilters');
		
		$this->beneficiaries = $this->_getVolunteeringBeneficiaries();
		$this->causeareas = $this->_getCauseAreas();
		$this->resetlink = $this->_showResetlink( JFactory::getApplication()->input );

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
				throw new Exception(implode("\n", $errors));
        }

		
        $this->_prepareDocument();
        parent::display($tpl);
    }
	
	protected function _getVolunteeringBeneficiaries() {
		
		//Get Volunteering beneficiaries from component parameters
        $params = JFactory::getApplication()->getParams('com_dw_opportunities');
		$volunteeringBeneficiariesUsergroupsIDs=$params->get('beneficiary_usergroups');
		
		//Get the user ids array
		$donorwizusers = new DonorwizUsers();
		$volunteeringBeneficiaries =  $donorwizusers -> getUsersByUserGroupsIDs ( $volunteeringBeneficiariesUsergroupsIDs , true ) ;
		
		if ( !count( $volunteeringBeneficiaries ) )
		{
			return array();
		}
			
		//Get profile data for each user
		include_once JPATH_ROOT.'/components/com_community/libraries/core.php';
		
		$volunteeringBeneficiariesArray = array();
		
		foreach ( $volunteeringBeneficiaries as $key => $userID)
		{

			$volunteeringBeneficiariesArray [$key] ['user_id'] = $userID;
			$volunteeringBeneficiariesArray [$key] ['name'] = CFactory::getUser( $userID )->getDisplayName();
		}		
	
		return $volunteeringBeneficiariesArray;		
	}
	
	protected function _getCauseAreas() {
		
		require_once(JPATH_ROOT.'/components/com_community/libraries/core.php');
		
		$db = JFactory::getDBO();
		
		$causeareas = new CTableProfileField($db);
		$causeareas -> load( array('fieldcode'=>'FIELD_OBJECTIVE') );
		$causeareas->options = explode("\n",$causeareas->options);

		return $causeareas->options;		
	}
	
	
	protected function _showResetlink( $jinput ){
		
		$jinputFilter = $jinput->get('filter','','array');
		
		$jinputCategory = ( isset ( $jinputFilter['category'] ) ) ? $jinputFilter['category'] : '' ;
		$jinputCreatedBy = ( isset ( $jinputFilter['created_by'] ) ) ? $jinputFilter['created_by'] : '' ;
		$jinputCauseArea = ( isset ( $jinputFilter['causearea'] ) ) ? $jinputFilter['causearea'] : '' ;

		$showResetlink = false;
		
		if( 
			$jinputCategory		!='' ||	
			$jinputCreatedBy		!='' ||	
			$jinputCauseArea		!='' 
			// $jinput->get('category', '', 'string')		!=''	|| 
			// $jinput->get('category', '', 'string')		!=''	||
			// $jinput->get('created_by', '', 'string')	!=''	||	
			// $jinput->get('nearby_place', '', 'string')	!=''	
		)
		{
			
			$showResetlink = true;
			
		}
				
		return $showResetlink;
		
	}
	
	
    /**
     * Prepares the document
     */
    protected function _prepareDocument() {
        $app = JFactory::getApplication();
        $menus = $app->getMenu();
        $title = null;

        // Because the application sets a default page title,
        // we need to get it from the menu item itself
        $menu = $menus->getActive();
        if ($menu) {
            $this->params->def('page_heading', $this->params->get('page_title', $menu->title));
        } else {
            $this->params->def('page_heading', JText::_('COM_DW_OPPORTUNITIES_DEFAULT_PAGE_TITLE'));
        }
        $title = $this->params->get('page_title', '');
        if (empty($title)) {
            $title = $app->getCfg('sitename');
        } elseif ($app->getCfg('sitename_pagetitles', 0) == 1) {
            $title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
        } elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
            $title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
        }
        $this->document->setTitle($title);

        if ($this->params->get('menu-meta_description')) {
            $this->document->setDescription($this->params->get('menu-meta_description'));
        }

        if ($this->params->get('menu-meta_keywords')) {
            $this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
        }

        if ($this->params->get('robots')) {
            $this->document->setMetadata('robots', $this->params->get('robots'));
        }
    }

}