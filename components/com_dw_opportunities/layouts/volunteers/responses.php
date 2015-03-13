<?php

defined('_JEXEC') or die;

$items = $displayData['items'];

?>

<ul class="uk-list list">

	<?php foreach ( $items as $i => $response) : ?>

	<?php echo JLayoutHelper::render( 'response' , array ( 'response' => $response  ) , JPATH_ROOT .'/components/com_dw_opportunities_responses/layouts/item' , null ); ?>
	
	<?php endforeach;?>

</ul>