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
		$isDashboard = $this->state->get("filter.dashboard") ;
		
		if ( $isDashboard )
		{
			$donorwizUser = new DonorwizUser( JFactory::getUser() -> id );
			$isBeneficiary = $donorwizUser -> isBeneficiary('com_donorwiz');
			$isDonor = $donorwizUser -> isDonor();
			
			if( $isDonor ){
				$this->state->set('filter.donor_id', JFactory::getUser()->id );
			}
			if ( $isBeneficiary ){
				$this->state->set('filter.created_by', JFactory::getUser()->id );
			}
		}
		
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->params = $app->getParams('com_dw_opportunities');
		$this->filterForm = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');	

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
				throw new Exception(implode("\n", $errors));
        }
		
        $this->_prepareDocument();
        parent::display($tpl);
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