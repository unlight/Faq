<?php if (!defined('APPLICATION')) die(); 

?>

<h1><?php echo T('F. A. Q.');?></h1>

<p class="P"><?php echo T('Faq.WelcomeText', 'Here you can ask us any question.');?></p>

<?php if ($this->Faqs->NumRows() > 0) {
	echo $this->Pager->ToString('less');
	echo '<ul class="DataList MessageList Faqs">';
	foreach ($this->Faqs as $Question) {
		include $QuestionLocation;
	}
	echo '</ul>';
	echo $this->Pager->ToString('more');
}

