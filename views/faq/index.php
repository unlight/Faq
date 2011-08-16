<?php if (!defined('APPLICATION')) die(); 

$QuestionLocation = $this->FetchViewLocation('question', 'faq');
$AllowAsk = Gdn::Session()->IsValid() || Gdn::Config('Faq.NewQuestions.AllowGuest');
?>

<h1><?php echo T('F. A. Q.');?></h1>

<?php if (CheckPermission('Garden.Plugins.Manage')) include $this->FetchViewLocation('menu', 'faq'); ?>

<?php if ($AllowAsk): ?>
<p class="P"><?php 
	$AskAnchor = Anchor(T('Faq.AskUs', T('ask us')), Url('faq/ask'), array('class' => 'Popup', 'rel' => 'nofollow'));
	echo sprintf(T('Faq.WelcomeText', 'Here you can %s any question.'), $AskAnchor);?></p>
<?php endif; ?>


<?php if ($this->Faqs->NumRows() > 0) {
	if (isset($this->Pager)) echo $this->Pager->ToString('less');
	echo '<ul class="DataList MessageList P Faqs">';
	foreach ($this->Faqs as $Question) {
		include $QuestionLocation;
	}
	echo '</ul>';
	if (isset($this->Pager)) echo $this->Pager->ToString('more');
}
?>
