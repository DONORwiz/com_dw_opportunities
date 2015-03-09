<?php
/**
 * @version     1.0.4
 * @package     com_dw_opportunities
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Charalampos Kaklamanos <dev.yesinternet@gmail.com> - http://www.yesinternet.gr
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Opportunity controller class.
 */
class Dw_opportunitiesControllerOpportunity extends JControllerForm
{

    function __construct() {
        $this->view_list = 'opportunities';
        parent::__construct();
    }

}