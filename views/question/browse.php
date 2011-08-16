<?php if (!defined('APPLICATION')) die(); 

$Alt = False;
$PermissionQuestionsEdit = CheckPermission('Faq.Questions.Edit');
$PermissionQuestionsDelete = CheckPermission('Faq.Questions.Delete');
?>

<h1><?php echo $this->Data('Title');?></h1>

<?php include $this->FetchViewLocation('menu', 'faq'); ?>

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

<?php foreach ($this->Faqs as $Question) {
	
	$Row = '';
	$Row .= Wrap($Question->FaqID, 'td');
	$Row .= Wrap('<small>'.$Question->CategoryName.'</small>', 'td');
	$Row .= Wrap('<small>'.$Question->Question.'</small>', 'td');
	$Row .= Wrap(Gdn_Format::To($Question->Answer, $Question->Format), 'td');
	$Row .= Wrap(Gdn_Format::Date($Question->DateUpdated), 'td');
	
	$Options = array();
	if ($PermissionQuestionsEdit) $Options[] = Anchor(T('Edit'), 'faq/question/edit/'.$Question->FaqID);
	if ($PermissionQuestionsDelete) $Options[] = Anchor(T('Delete'), 'faq/question/delete/'.$Question->FaqID, 'PopConfirm');
	
	$Row .= Wrap(implode(' ', $Options), 'td');

	$Alt = !$Alt;
	echo Wrap($Row, 'tr', array('class' => $Alt ? 'Alt' : ''));
}
?>

</table>

<?php echo $this->Pager->ToString('more'); ?>