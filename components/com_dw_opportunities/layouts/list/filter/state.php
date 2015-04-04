<?php 

defined('_JEXEC') or die;

$app = JFactory::getApplication();

$jinput = $app->input;

$jinputFilter = $app->input->get('filter','','array');

$jinputState = ( isset ( $jinputFilter['state'] ) ) ? $jinputFilter['state'] : '' ;

$dashboard = ( $jinput->get('dashboard', '', 'string')=='true' ) ? true : null ;

$donorwizUrl = new DonorwizUrl();

//Check if user can edit state
$canEditStateOpportunity = JFactory::getUser()->authorise('core.edit.state', 'com_dw_opportunities');

?>

<?php if( $dashboard && $canEditStateOpportunity ):?>

<select class="uk-form-large uk-width-1-1" onchange="if (this.value) window.location.href=this.value" >

	<option value="<?php echo $donorwizUrl -> getCurrentUrlWithNewParams( array( 'filter' => array ( 'state' => '' ) ) ) ;?>" <?php if ( $jinputState=='' ) echo 'selected="selected"';?> ><?php echo JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_WIZARD_STATE');?></option>
	
	<option value="<?php echo $donorwizUrl -> getCurrentUrlWithNewParams( array( 'filter' => array ( 'state' => '0' ) ) ) ;?>" <?php if ( $jinputState=='0' ) echo 'selected="selected"';?>><?php echo JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_WIZARD_UNPUBLISHED');?></option>
	
	<option value="<?php echo $donorwizUrl -> getCurrentUrlWithNewParams( array( 'filter' => array ( 'state' => '1' ) ) ) ;?>" <?php if ( $jinputState=='1' ) echo 'selected="selected"';?>><?php echo JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_WIZARD_PUBLISHED');?></option>
	
</select>

<?php endif;?>