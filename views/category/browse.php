<?php if (!defined('APPLICATION')) die(); 

$Alt = False;
$PermissionEdit = CheckPermission('Faq.Categories.Edit');
$PermissionDelete = CheckPermission('Faq.Categories.Delete');
?>

<h1><?php echo $this->Data('Title');?></h1>

<?php include $this->FetchViewLocation('menu', 'faq'); ?>

<table class="AltRows">
<tr>
	<th><?php echo T('@#');?></th>
	<th><?php echo T('Category');?></th>
	<th><?php echo T('Description');?></th>
	<th><?php echo T('Options');?></th>
</tr>

<?php foreach ($this->FaqCategory as $Category) {
	
	$Row = '';
	$Row .= Wrap($Category->FaqCategoryID, 'td');
	$Row .= Wrap($Category->Name, 'td');
	$Row .= Wrap($Category->Description, 'td');
	
	$Options = array();
	if ($PermissionEdit) $Options[] = Anchor(T('Edit'), 'faq/category/edit/'.$Category->FaqCategoryID);
	if ($PermissionDelete) $Options[] = Anchor(T('Delete'), 'faq/category/delete/'.$Category->FaqCategoryID, 'PopConfirm');
	
	$Row .= Wrap(implode(', ', $Options), 'td');

	$Alt = !$Alt;
	echo Wrap($Row, 'tr', array('class' => $Alt ? 'Alt' : ''));
}
?>

</table>
