<?php

/**
 * @version     1.0.3
 * @package     com_dw_opportunities
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Charalampos Kaklamanos <dev.yesinternet@gmail.com> - http://www.yesinternet.gr
 */
// No direct access
defined('_JEXEC') or die;

require_once JPATH_COMPONENT . '/controller.php';

/**
 * Opportunity controller class.
 */
class Dw_opportunitiesControllerDwOpportunityForm extends Dw_opportunitiesController {

    public function save() {
		
		// Check for request forgeries.
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Initialise variables.
        $app = JFactory::getApplication();
        $model = $this->getModel('DwOpportunityForm', 'Dw_opportunitiesModel');	

        // Get the user data.
        $data = JFactory::getApplication()->input->get('jform', array(), 'array');
		
		// Check if user can edit or create the item ---------------------------------------------------------------------------------------------
		$id = ( ( $data['id'] == 0 ) || !isset ( $data['id'] ) ) ? null : (int)$data['id'];
        $user = JFactory::getUser();

        if( $id ) 
		{
        	//Check the user can edit this item
            $authorised = $user->authorise('core.edit', 'com_dw_opportunities');
			
			if(!$authorised && $user->authorise('core.edit.own', 'com_dw_opportunities'))
			{
				//Check the owner from the model
				$itemData = $model -> getData($id);
				$itemOwner = ( isset ( $itemData -> created_by ) ) ? $itemData -> created_by : null ;
				$authorised = $user -> id == $itemOwner ; 
			}
		
        } 
		else 
		{
            //Check the user can create new item
            $authorised = $user->authorise('core.create', 'com_dw_opportunities');
        }		

		if (!$authorised)
		{		
			try
			{
				echo new JResponseJson( '' , JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_WIZARD_PERMISSION_DENIED') , true );
			}
			catch(Exception $e)
			{
				echo new JResponseJson($e);
			}
		
			jexit();
		}
		// ------------------------------------------------------------------------------------------------------------------------------
		
        // Validate the posted data.
        $form = $model->getForm();
        
		if (!$form)
		{		
			try
			{
				echo new JResponseJson( '' , $model->getError() , true ); //JForm::getInstance could not load file
			}
			catch(Exception $e)
			{
				echo new JResponseJson($e);
			}
		
			jexit();
		}
		
        // Validate the posted data.
        $data = $model->validate($form, $data);

        // Check for errors.
        if ($data === false) 
		{
        	try
			{
				echo new JResponseJson( '' , $model->getErrors() , true );
			}
			catch(Exception $e)
			{
				echo new JResponseJson($e);
			}
		
			jexit();
			
        }

        // Attempt to save the data.
        $return = $model->save($data);

        // Check for errors.
        if ($return === false) 
		{
			try
			{
				echo new JResponseJson( '' , $model->getError() , true );
			}
			catch(Exception $e)
			{
				echo new JResponseJson($e);
			}
		
			jexit();
			
        }

		try
		{
			echo new JResponseJson( $return );
		}
		catch(Exception $e)
		{
			echo new JResponseJson($e);
		}
	
		jexit();
    }
}