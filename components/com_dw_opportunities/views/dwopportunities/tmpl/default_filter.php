<?php

defined('JPATH_BASE') or die;

$user = JFactory::getUser();

$view = $displayData['view'];
$state = $view->get('State');
$filterForm = $view->filterForm;
$activeFilters = $view->activeFilters;

//If exists, add search terms to active filters array
$jinput = JFactory::getApplication()->input;
$filterArray = $jinput->get('filter', array(), 'array');

if( $filterArray['search'] ){
	$activeFilters = array_merge( $activeFilters , array( "search" => $filterArray['search']) );
}

$isDashboard = $state -> get ('filter.dashboard') ;
$filterCreatedBy = $state -> get ('filter.created_by') ;

//Reset URL
$uri = JUri::getInstance();
$isSEF = ( JFactory::getConfig()->get("sef")==1 ) ? true : null ;
if ( $isSEF )
{
	$resetURL = JUri::current ();
}else
{
	$resetURI = clone $uri;
	$resetURI->delVar('filter');
	$resetURI->delVar('list');
	$resetURL = $resetURI->toString();
}

$filters      = false;

if (isset($filterForm))
{
	
    //Filter created_by
	$created_by_query = 'SELECT "" AS id, "'.JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITIES_FILTERS_ORGANIZATION').'" AS title UNION ALL SELECT DISTINCT a.created_by , b.name FROM #__dw_opportunities as A LEFT JOIN #__users AS b ON a.created_by=b.id';
    $filterForm->setFieldAttribute( 'created_by', 'query' ,$created_by_query, 'filter' );
	//Filter created_by -------------------------------------------------------------------------------------------
    
    //Filter causearea
    $causeareaXMLString = '<field ';
    $causeareaXMLString .= 'name="causearea" ';
    $causeareaXMLString .= 'type="list" ';
    $causeareaXMLString .= 'onchange="this.form.submit();" ';
    $causeareaXMLString .= 'class="uk-form-large uk-width-1-1" ';
    $causeareaXMLString .= 'default="" ';
    $causeareaXMLString .= '>';
 
    require_once(JPATH_ROOT.'/components/com_community/libraries/core.php');
    
    $db = JFactory::getDBO();
    $causeareas = new CTableProfileField($db);
    $causeareas -> load( array('fieldcode'=>'FIELD_OBJECTIVE') );
    $causeareas->options = explode("\n",$causeareas->options);

    $causeareaXMLString .= '<option value="">COM_DW_OPPORTUNITIES_OPPORTUNITY_CAUSE_AREA</option>';
    foreach ($causeareas->options as $causearea) {
        $causeareaXMLString .= '<option value="'.$causearea.'">'.$causearea.'</option>';
    }

    $causeareaXMLString .= '</field>';
    
    $causeareaXML = new SimpleXmlElement($causeareaXMLString);
    $filterForm ->setField ($causeareaXML,'filter',true);
    $filterForm ->setValue ('causearea','filter', $activeFilters['causearea']);
    //Filter causearea -------------------------------------------------------------------------------------------
       
	$filters = $filterForm->getGroup('filter');
	$list = $filterForm->getGroup('list');
    
}

?>

<form id="dwopportunities_default_filter" action="<?php echo JURI::current();?>" method="get" class="form-validate uk-form uk-form-stacked " enctype="multipart/form-data">

	<?php if(JFactory::getConfig()->get("sef")!=1): ?>
        <input type="hidden" name="option" value="<?php echo $uri->getVar('option'); ?>"  />
        <input type="hidden" name="view" value="<?php echo $uri->getVar('view'); ?>"  />
        <input type="hidden" name="layout" value="<?php echo $uri->getVar('layout'); ?>"  />
        <input type="hidden" name="Itemid" value="<?php echo $uri->getVar('Itemid'); ?>"  />
        <input type="hidden" name="lang" value="<?php echo $uri->getVar('lang'); ?>"  />
    <?php endif ?>
	
<?php if ($filters) : ?>

	<div id="filter-options" class="<?php if ( empty ( $activeFilters ) ) echo 'uk-hidden';?>">

		<div class="uk-grid uk-grid-small uk-margin-small-top">
			
			<div class="uk-width-medium-1-2">
				<div class="uk-grid uk-grid-small">
					<div class="uk-width-4-5">
						<?php echo $filters['filter_search']->input;?>
					</div>
					<div class="uk-width-1-5">
						<button class="uk-button uk-button-large uk-button-primary uk-width-1-1 uk-float-right" type="submit"><i class="uk-icon-search"></i></button>
					</div>
				</div>
			</div>
			
			<div class="uk-width-medium-1-2">
				
				<div class="uk-grid uk-grid-small">
					<div class="uk-width-1-2">
					<?php if ( $filterCreatedBy !=  $user->id ) :?>
						<?php echo $filters['filter_created_by']->input;?>
					<?php endif; ?>
					</div>
		
					<div class="uk-width-medium-1-2">
						<?php echo $filters['filter_causearea']->input;?>
					</div>
				</div>
				
			</div>
			

		
		</div>
		
		<hr class="uk-artivle-divider uk-margin-small">
	
	</div>
    
    <?php echo $filters['filter_category']->input;?>
    <div class="uk-grid uk-grid-small uk-margin-small-top">
			
		<div class="uk-width-medium-1-2">
		
			<a class="uk-button uk-button-large uk-width-1-1 truncate <?php if( $filterArray['category'] == 'local') echo 'uk-active uk-button-success'; ?>" 
                onclick="event.preventDefault();if ( jQuery('#filter_category').val()=='local' ) { jQuery('#filter_category').val('') } else { jQuery('#filter_category').val('local') };jQuery('#dwopportunities_default_filter').trigger('submit');"
                href="#" data-uk-tooltip="{pos:'bottom'}" title="<?php echo JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_LOCAL_TOOLTIP');?>">
				<i class="uk-icon-map-marker uk-icon-small"></i>
				<?php echo JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_LOCAL');?>
			</a>
			
		</div>
			
		<div class="uk-width-medium-1-2">
			
			<a class="uk-button uk-button-large uk-width-1-1 truncate <?php if( $filterArray['category'] == 'virtual') {echo 'uk-active uk-button-success';} ?>" 
                onclick="event.preventDefault();if ( jQuery('#filter_category').val()=='virtual' ) { jQuery('#filter_category').val('') } else { jQuery('#filter_category').val('virtual') };jQuery('#dwopportunities_default_filter').trigger('submit');"
                href="#" data-uk-tooltip="{pos:'bottom'}" title="<?php echo JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_VIRTUAL_TOOLTIP');?>">
              	<i class="uk-icon-laptop uk-icon-small"></i>
				<?php echo JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_VIRTUAL');?>
			</a>
		
		</div>	
		
	</div>

<?php endif; ?>
    
    <div class="uk-margin-small-top">
        
        <?php if ($list) : ?>
    
            <div class="uk-float-right">
 
                 <?php if( $filters && $user->authorise('core.edit.state', 'com_dw_opportunities') && $isDashboard ) : ?>
                    <?php echo $filters['filter_state']->input;?>
                <?php endif; ?>
                
                <?php echo $list['list_fullordering']->input;?>
                
                <?php if( $isDashboard ) : ?>
                    <?php echo $list['list_limit']->input;?>
                <?php endif; ?>
                
            </div>
        
        <?php endif; ?>
        
        <a class="uk-button uk-button-link uk-button-primary uk-float-right" data-uk-toggle="{target:'#filter-options'}"><i class="uk-icon-filter uk-margin-small-right"></i><?php echo JText::_('COM_DW_OPPORTUNITIES_FILTER_OPTIONS'); ?></a>
        
        <?php if ( $filters && !empty ( $activeFilters ) ) :?>
        
            <button type="submit" onclick="jQuery('[name^=filter]').removeAttr('value');this.form.submit();" class="uk-button uk-float-right uk-button-primary"><i class="uk-icon-remove"></i></button>
        
        <?php endif;?>
        
    </div>
    
</form>