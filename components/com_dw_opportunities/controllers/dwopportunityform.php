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
		
        // Get the user data.
		$jinput = JFactory::getApplication()->input;
        $data = JFactory::getApplication()->input->get('jform', array(), 'array');
		
		//If post data empty, die
		if(empty($data)) jexit(JText::_('EMPTY_POST_DATA'));
        
		// Initialise variables.
        $app = JFactory::getApplication();
        $model = $this->getModel('DwOpportunityForm', 'Dw_opportunitiesModel');		

        // Validate the posted data.
        $form = $model->getForm();
        
		if (!$form) {		
			
			try
			{
				$error = $model->getError(); //JForm::getInstance could not load file
				$app->enqueueMessage( $error );
				echo new JResponseJson( '' , $error , true );
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
        if ($data === false) {
            
			// Set the validation error
			$error = 'JForm::could not validate data'; //JForm::getInstance could not load file
			
			// Get the validation messages.
            $errors = $model->getErrors();

            // Push up to three validation messages out to the user.
            for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
                if ($errors[$i] instanceof Exception) {
                    $app->enqueueMessage($errors[$i]->getMessage(), 'warning');
                } else {
                    $app->enqueueMessage($errors[$i], 'warning');
                }
            }

			try
			{
				echo new JResponseJson( '' , $error , true );
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
        if ($return === false) {
		
			try
			{
				$error = $model->getError(); //JForm::could not save data
				$app->enqueueMessage( $error );
				echo new JResponseJson( '' , $error , true );
			}
			catch(Exception $e)
			{
				echo new JResponseJson($e);
			}
		
			jexit();
			
        }

        // Check in the profile.
        if ($return) {
            $model->checkin($return);
        }

        // Clear the profile id from the session.
		
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