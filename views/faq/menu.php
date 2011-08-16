<?php if (!defined('APPLICATION')) exit(); 

$Options = array();
if (CheckPermission('Faq.Questions.Browse')) {
	$Options[] = Anchor(T('Questions'), 'faq/question/browse', 'Button SmallButton');
	$Options[] = Anchor(T('Asked questions'), 'faq/question/asked', 'Button SmallButton');
}

if (CheckPermission('Faq.Questions.Edit')) {
	$Options[] = Anchor(T('Add question'), 'faq/question/add', 'Button SmallButton');
}

if (CheckPermission('Faq.Categories.Browse')) {
	$Options[] = Anchor(T('Categories'), 'faq/category/browse', 'Button SmallButton');
}

if (CheckPermission('Faq.Categories.Edit')) {
	$Options[] = Anchor(T('Add category'), 'faq/category/add', 'Button SmallButton');
}

if (CheckPermission('Faq.Settings.Manage')) {
	$Options[] = Anchor(T('Settings'), 'faq/settings', 'Button SmallButton');
}

// style="padding-bottom: 10px;
?>

<div class="FilterMenu">
<?php echo implode("\n", $Options); ?>
</div>