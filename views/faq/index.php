<?php if (!defined('APPLICATION')) die(); 

$PermissionQuestionsEdit = CheckPermission('Faq.Questions.Edit');
$QuestionLocation = $this->FetchViewLocation('question', 'faq');
?>

<h1><?php echo T('F. A. Q.');?></h1>

<?php if (CheckPermission('Garden.Plugins.Manage')) include $this->FetchViewLocation('menu', 'faq'); ?>

<p class="P"><?php 
	$AskAnchor = Anchor(T('Faq.AskUs', T('ask us')), Url('faq/ask'), array('class' => 'Popup', 'rel' => 'nofollow'));
	echo sprintf(T('Faq.WelcomeText', 'Here you can %s any question.'), $AskAnchor);?></p>

<?php if ($this->Faqs->NumRows() > 0) {
	if (isset($this->Pager)) echo $this->Pager->ToString('less');
	echo '<ul class="DataList MessageList P Faqs">';
	foreach ($this->Faqs as $Question) {
		include $QuestionLocation;
	}
	echo '</ul>';
	if (isset($this->Pager)) echo $this->Pager->ToString('more');
}
