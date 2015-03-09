<?php

defined('_JEXEC') or die;

echo JLayoutHelper::render(
		'opportunity',
		array (
			'state'=>$this->state,
			'item'=>$this->item,
			'form'=>$this->form, 
			'id' => $this->item->id 
		), 
		JPATH_ROOT .'/components/com_dw_opportunities/layouts/wizard', 
		null
	);