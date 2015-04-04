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
		$this->item->myresponse = null ;
		
		$canEdit = JFactory::getUser()->authorise('core.edit', 'com_dw_opportunities');
		if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_dw_opportunities')) {
			$canEdit = JFactory::getUser()->id == $this->item->created_by;
		}
		
		$canCreateResponse = JFactory::getUser()->authorise('core.create', 'com_dw_opportunities_responses');

		$donorwizUser = new DonorwizUser( JFactory::getUser() -> id );
		$isBeneficiary = $donorwizUser -> isBeneficiary('com_donorwiz');
		
		$isOwner = $user -> id == $this->item->created_by ;
		
		
		if ( $this->_layout == 'volunteers' )
		{
			if ( !$isBeneficiary || !$isOwner )
			{
				JError::raiseError( 404, '' );
			}
			
			$this->item->responses = $this->_getOpportunityResponses( $this->item->id );
			$this->item->responsesCount = $this->_getOpportunityResponsesCount($this->item->id);
		
		}
		
		if( $canCreateResponse )
		{
			$this->item->myresponse = $this->_getOpportunityMyResponse( $this->item->id );
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
		$item_url=rtrim(JUri::base(), '/') .JRoute::_('index.php?option=com_dw_opportunities&view=dwopportunity&Itemid=261&id='.$this -> item->id);
		
		$this->document->addHeadLink( $item_url, 'canonical', 'rel', null );
		
		$this->document->setTitle( $this -> item -> title . ', ' .  CFactory::getUser( $this -> item -> created_by ) -> name . ' - ' . $app->getCfg('sitename'));
		$this->document->setDescription( strip_tags ( $this -> item -> description ) );
		$this->document->setMetadata('keywords', $this -> item -> title . ', ' .  CFactory::getUser( $this -> item -> created_by ) -> name . ', ' . $app->getCfg('sitename') );
		//Open graph
		//Basic
		$this->document->setMetadata('og:title', $this -> item -> title . ' - ' . $app->getCfg('sitename') );
		$this->document->setMetadata('og:type', 'website');
		$og_image = ( $this -> item -> image ) ? $this -> item -> image : 'http://assets.donorwiz.com/logo/logo.png' ;
		$this->document->setMetadata('og:image', $og_image );

		
		$this->document->setMetadata('og:url', $item_url);
		//Optional
		$this->document->setMetadata('og:locale',  str_replace ( '-' , '_' ,JFactory::getLanguage() ->getTag()  ) );
		
		$this->document->setMetadata('og:site_name', 'DONORwiz');
		if( $this -> item -> parameters -> video )
		$this->document->setMetadata('og:video', $this -> item -> parameters -> video);
	}
	protected function _getOpportunityResponsesCount($opportunity_id){
		
		JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_dw_opportunities_responses/models', 'Dw_opportunities_responsesModel');
		
		$responsesModel = JModelLegacy::getInstance('DwOpportunitiesresponses', 'Dw_opportunities_responsesModel', array('ignore_request' => true));	
		
		$count = intval ( $responsesModel -> getCount( $opportunity_id ) );
		
		return $count;
	}
	
	protected function _getOpportunityMyResponse( $opportunity_id  )
	{
			
		JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_dw_opportunities_responses/models', 'Dw_opportunities_responsesModel');
		
		$responsesModel = JModelLegacy::getInstance('DwOpportunitiesresponses', 'Dw_opportunities_responsesModel', array('ignore_request' => true));	
		
		$responsesModel ->setState( 'filter.created_by', JFactory::getUser()->id);
		$responsesModel ->setState( 'filter.opportunity_id', $opportunity_id);
		
		$responses = $responsesModel -> getItems();

		$response = ( isset( $responses[0] ) ) ? $responses[0] : false ;

		return $response;	

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