<?php if (!defined('APPLICATION')) die(); 

$Alt = False;
$PermissionQuestionsEdit = CheckPermission('Faq.Questions.Edit');
$PermissionQuestionsDelete = CheckPermission('Faq.Questions.Delete');
$RowLocation = $this->FetchViewLocation('questionrow', 'question');
?>

<h1><?php echo $this->Data('Title');?></h1>

<?php include $this->FetchViewLocation('menu', 'faq'); ?>

<?php if ($this->Faqs->NumRows() == 0):?>
	<div class="Empty Info"><?php echo T('Nothing.');?></div>
<?php else: ?>

<?php echo $this->Pager->ToString('less'); ?>

<table class="AltRows">
<tr>
	<th><?php echo T('@#');?></th>
	<th><?php echo T('Category');?></th>
	<th><?php echo T('Question');?></th>
	<th><?php echo T('Answer');?></th>
	<th><?php echo T('@');?></th>
	<th><?php echo T('Options');?></th>
</tr>

<?php foreach ($this->Faqs as $Question) include $RowLocation; ?>

</table>

<?php echo $this->Pager->ToString('more'); ?>

<?php endif; ?>