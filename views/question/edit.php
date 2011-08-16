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
	$this->Form->Label('Question', 'Question').
	$this->Form->TextBox('Question'), 'li');
echo Wrap(
	$this->Form->Label('Category', 'FaqCategoryID').
	$this->Form->DropDown('FaqCategoryID', $this->FaqCategory, array('TextField' => 'Name', 'ValueField' => 'FaqCategoryID')), 'li');
echo Wrap(
	$this->Form->Label('Answer', 'Answer').
	$this->Form->TextBox('Answer', array('Multiline' => True)), 'li');
	
$FormatOptions = array('Text', 'Html', 'xHtml', 'Markdown', 'Textile');
$FormatOptions = array_combine($FormatOptions, $FormatOptions);

echo Wrap(
	$this->Form->Label('Format', 'Format').
	$this->Form->DropDown('Format', $FormatOptions), 'li');
echo Wrap(
	$this->Form->Label('Sort', 'Sort').
	$this->Form->TextBox('Sort'), 'li');
echo Wrap(
	$this->Form->Label('Visible', 'Visible').
	$this->Form->CheckBox('Visible'), 'li');
?>
</ul>

<?php
echo $this->Form->Button('Save');
echo $this->Form->Close();
?>