<?php 

defined('_JEXEC') or die;

//Load opportunities model
JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_dw_opportunities/models', 'Dw_opportunitiesModel');
$opportunitiesModel = JModelLegacy::getInstance('DwOpportunities', 'Dw_opportunitiesModel', array('ignore_request' => true));	

//Set model state

//filter.created_by
$filter_created_by = ( isset( $displayData['created_by'] ) ) ? $displayData['created_by'] : null ;
if ( $filter_created_by ) 
	$opportunitiesModel -> setState ('filter.created_by', $filter_created_by) ;

//filter.dashboard
$filter_dashboard = ( isset ( $jinputFilter[ 'dashboard' ] ) && $jinputFilter[ 'dashboard' ] == 'true' ) ? 'true' : null ;
if ( $filter_dashboard ) 
	$opportunitiesModel -> setState ('filter.dashboard', $filter_dashboard) ;

//list.limit
$list_limit = ( isset( $displayData['list.limit'] ) ) ? $displayData['list.limit'] : 10 ;
	$opportunitiesModel -> setState ('list.limit', $list_limit) ;
	
$items = $opportunitiesModel -> getItems();

//check itemid
$itemid = ( isset( $displayData['itemid'] ) ) ? $displayData['itemid'] : 0 ;

if( count ($items) == 1 && $itemid == $items[0]->id )
{
	$items = null;
}

$displayData = array_merge($displayData, array ( 'items' => $items ) );

?>

<?php echo JLayoutHelper::render( 
	'list.templates.'.$displayData['template'] , 
	$displayData , 
	JPATH_ROOT .'/components/com_dw_opportunities/layouts' , 
	null ); 
?>

