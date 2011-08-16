<?php
if (!defined('APPLICATION')) die();

?>

<h1><?php echo $this->Data('Title');?></h1>

<?php include $this->FetchViewLocation('menu', 'faq'); ?>

<?php $this->ConfigurationModule->Render(); ?>