<?php


// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View to edit
 */
class Dw_opportunitiesViewDwopportunityform extends JViewLegacy {

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
        $this->params = $app->getParams('com_dw_opportunities');
        $this->form		= $this->get('Form');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

		
		//Check permissions to create
		if( !$this -> item -> id )
		{
			if( !$user->authorise('core.create', 'com_dw_opportunities') )
			{
				JError::raiseError( '500' , JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_WIZARD_PERMISSION_DENIED') );
			}

		}
		

		
		//Check if item exists or trashed
		if( !$this->item || $this->item->state=='-2')
		{
			$menuItemID = JFactory::getApplication()->getMenu()->getItems( 'link', 'index.php?option=com_donorwiz&view=dashboard&layout=dwopportunities', true )->id;
			JFactory::getApplication()->redirect(JRoute::_('index.php?Itemid='.$menuItemID));
		}

		//Check if user can edit opportunity----------------------------------------
		if( $this -> item -> id )
		{
			$canEditOpportunity = $user->authorise('core.edit', 'com_dw_opportunities');
			
			if (!$canEditOpportunity && $user->authorise('core.edit.own', 'com_dw_opportunities'))
			{
				$canEditOpportunity = $user -> id == $this->item->created_by;
			}

			if( !$canEditOpportunity )
			{
				$menuItemID = JFactory::getApplication()->getMenu()->getItems( 'link', 'index.php?option=com_donorwiz&view=dashboard&layout=dwopportunities', true )->id;
				JFactory::getApplication()->redirect(JRoute::_('index.php?Itemid='.$menuItemID));

			}
			
		}



		
		//Store this item id in user session, in order to prevent editing another item id

		$formSession = JFactory::getApplication()->setUserState('com_dw_opportunities.form.item', $this->item );

		
		//Set item defaults

		//Volunteers No Enabled
		if( !isset($this->item->parameters['volunteers_no_enabled']))
			$this->item->parameters['volunteers_no_enabled']='0';
		
		
		//YouTube Video
		$this->item->YouTubeVideoID = '';
		
		if( isset($this->item->parameters['video']))
		{
			$DonorwizVideo = new DonorwizVideo();
			$this->item->YouTubeVideoID = $DonorwizVideo->getYouTubeVideoID($this->item->parameters['video']);
			
		}
		
        $this->_prepareDocument();
        
		$this->_loadScripts();

        parent::display($tpl);
    }

    protected function _loadScripts() {
		
		JHtml::_('jquery.framework');
		JHtml::_('behavior.formvalidation');
		
		JFactory::getLanguage()->load('com_donorwiz');
		
		$script = array();

		$script[] = 'var waitingModal;';
		$script[] = 'var JText_COM_DONORWIZ_WIZARD_SAVE_FAIL = "'.JText::_('COM_DONORWIZ_WIZARD_SAVE_FAIL').'";';
		$script[] = 'var JText_COM_DONORWIZ_WIZARD_TRASH_CONFIRM = "'.JText::_('COM_DONORWIZ_WIZARD_TRASH_CONFIRM').'";';
		$script[] = 'var JText_COM_DONORWIZ_MODAL_PLEASE_WAIT = "'.JText::_('COM_DONORWIZ_MODAL_PLEASE_WAIT').'";';

		JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));
		
	}
    
	protected function _prepareDocument() {
        
        $this->document->setTitle(JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_WIZARD'));
    }
}
