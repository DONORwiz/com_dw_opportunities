<?php

defined('_JEXEC') or die;

$item = $displayData['item'];
$volunteersNeeded = $item -> volunteersNeeded ;

?>

<?php if ($volunteersNeeded) : ?>
    <i class="uk-icon-users"></i>
    <span><?php echo JText::_('COM_DW_OPPORTUNITIES_OPPORTUNITY_WIZARD_LABEL_VOLUNTEERS_NO');?>: <?php echo $volunteersNeeded; ?></span>
<?php endif; ?>
