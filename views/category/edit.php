<?php if (!defined('APPLICATION')) die(); 

?>

<h1><?php echo $this->Data('Title');?></h1>

<?php include $this->FetchViewLocation('menu', 'faq'); ?>

<?php 
echo $this->Form->Open();
echo $this->Form->Errors();
?>

<ul>
<?php
echo Wrap(
	$this->Form->Label('Name', 'Name').
	$this->Form->TextBox('Name'), 'li');
echo Wrap(
	$this->Form->Label('Description', 'Description').
	$this->Form->TextBox('Description', array('Multiline' => True)), 'li');
?>
</ul>

<?php
echo $this->Form->Button('Save');
echo $this->Form->Close();
?>