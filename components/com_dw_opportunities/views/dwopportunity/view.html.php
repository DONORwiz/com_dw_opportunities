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

        $user = JFactory::getUser();

        $this->state = $this->get('State');
        $this->item = $this->get('Data');

		$this->_checkViewAccess() ;
        
		// Check for errors.
        if (count($errors = $this->get('Errors')))
		{
            throw new Exception(implode("\n", $errors));
        }
		
		JFactory::getApplication()->setUserState('com_dw_opportunities.opportunity.id'.$this->item->id , $this->item);
		
        $this->_prepareDocument();
		 
        parent::display($tpl);
		
    }

	protected function _checkViewAccess(){
		
		$showItem = true;
		
		$user = JFactory::getUser();
		
		$canEdit = $user->authorise('core.edit', 'com_dw_opportunities');
		
		if (!$canEdit && $user->authorise('core.edit.own', 'com_dw_opportunities'))
		{
			$canEdit = $user->id == $this->item->created_by;
		}
				
		//?layout=volunteers
		if ( $this->_layout == 'volunteers' )
		{
			//Only users who can edit , can access this layout
			if ( !$canEdit )
			{
				JError::raiseError( 403, 'Access denied' );
			}

		}
		
		//?layout=default
		if ( $this->_layout == 'default' )
		{
			//If item is not published and user cannot edit, do not show item
			if ( $this->item->state != 1 && !$canEdit)
			{ 
				JError::raiseError( 404, '' );
			}
		}
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
		
		if( $this -> item -> parameters -> video ){
			$this->document->setMetadata('og:video', $this -> item -> parameters -> video);
		}
	}
}