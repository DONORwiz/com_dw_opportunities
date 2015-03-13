<?php

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View to edit
 */
class Dw_opportunitiesViewDwOpportunity extends JViewLegacy {

    protected $state;
    protected $item;
    protected $form;
    protected $params;

    /**
     * Display the view
    */
    public function display($tpl = null) {

        $app = JFactory::getApplication();
        $user = JFactory::getUser();

        $this->state = $this->get('State');
        $this->item = $this->get('Data');
        $this->item->responses = null;
		
		$canEdit = JFactory::getUser()->authorise('core.edit', 'com_dw_opportunities');
		if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_dw_opportunities')) {
			$canEdit = JFactory::getUser()->id == $this->item->created_by;
		}
		
		$canCreateResponse = JFactory::getUser()->authorise('core.create', 'com_dw_opportunities_responses');


		if ( $this->_layout == 'volunteers' )
		{
			if ( !$canEdit )
			{
				JError::raiseError( 404, '' );
			}
			
			$this->item->responses = $this->_getOpportunityResponses( $this->item->id );
			$this->item->responsesCount = $this->_getOpportunityResponsesCount($this->item->id);
		
		}
		
		if( $canCreateResponse )
		{
			$this->item->responses = $this->_getOpportunityResponses( $this->item->id );
		}
		
		if ( $this->_showItem() == false )
			JError::raiseError( 404, '' );
		
        $this->params = $app->getParams('com_dw_opportunities');

		$this->item-> showResponseWizard = $this->_showResponseWizard( $this->item->id );
		

		
		// if (!empty($this->item)) {
            
			// $this->form	= $this->get('Form');
        
		// }

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }
		
		JFactory::getApplication()->setUserState('com_dw_opportunities.opportunity.id'.$this->item->id , $this->item);
		
        $this->_prepareDocument();
		
		//var_dump($opportunityUserState);

        parent::display($tpl);
    }

    /**
     * Prepares the document
     */
    protected function _prepareDocument() {
		
		$app = JFactory::getApplication();

		$this->document->setTitle($this -> item -> title . ' - ' . $app->getCfg('sitename'));
		$this->document->setDescription($this -> item -> description);
		$this->document->setMetadata('keywords', $this -> item -> title);
		//Open graph
		$this->document->setMetadata('og:title', $this -> item -> title);

	}
	
	protected function _getOpportunityResponsesCount($opportunity_id){
		
		JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_dw_opportunities_responses/models', 'Dw_opportunities_responsesModel');
		
		$responsesModel = JModelLegacy::getInstance('DwOpportunitiesresponses', 'Dw_opportunities_responsesModel', array('ignore_request' => true));	
		
		$count = intval ( $responsesModel -> getCount( $opportunity_id ) );
		
		return $count;
	}
	
	protected function _getOpportunityResponses( $opportunity_id  ){
		
		if( JFactory::getUser() ->guest)
			return null;
			
		JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_dw_opportunities_responses/models', 'Dw_opportunities_responsesModel');
		
		$responsesModel = JModelLegacy::getInstance('DwOpportunitiesresponses', 'Dw_opportunities_responsesModel', array('ignore_request' => true));	
		
		$responses = $responsesModel -> getItemsByOpportunity( $opportunity_id  );
		
		return $responses;
	
	}
	

	
	protected function _showResponseWizard( $opportunity_id ){
		
		//Check if user can create response item-----------------------------------------
		$canCreateResponse = JFactory::getUser()->authorise('core.create', 'com_dw_opportunities_responses');
		
		if( $canCreateResponse )
		{
			//Check the user has already created a response for this opportunity_id - ONLY 1 allowed - yesinternet
			JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_dw_opportunities_responses/models', 'Dw_opportunities_responsesModel');
			$opportunitiesresponsesModel = JModelLegacy::getInstance('DwOpportunitiesresponses', 'Dw_opportunities_responsesModel', array('ignore_request' => true));        
			$opportunityresponses = $opportunitiesresponsesModel -> getItemsByVolunteer( JFactory::getUser()->id , $opportunity_id );

			//Check if user has already created a response
			if( $opportunityresponses )
				$canCreateResponse = false;
		}
		
		return $canCreateResponse;
		
	}
	
	protected function _showItem(){
		
		$user = JFactory::getUser();
		
		//Check if user can edit opportunity item----------------------------------------
		$canEdit = $user->authorise('core.edit', 'com_dw_opportunities');

		if (!$canEdit && $user->authorise('core.edit.own', 'com_dw_opportunities'))
			$canEdit = $user->id == $this->item->created_by;

		//Check if item should be shown --------------------------------------
		$showItem = false;
		
		
		if ( $this->item && ( $this->item->state == 1 || $canEdit) ) 
			$showItem = true;
		
		
		return $showItem;

	}
}