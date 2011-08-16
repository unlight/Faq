<?php if (!defined('APPLICATION')) die(); 

?>

<h1><?php echo T('Ask question');?></h1>

<div class="AskQuestionForm">

<?php echo $this->Form->Open(); ?>
<?php echo $this->Form->Errors(); ?>

<ul>

<?php if (!$this->UserSessionValid) { ?>

	<li>
	<?php 
	echo $this->Form->Label('Your name', 'InsertName');
	echo $this->Form->TextBox('InsertName');
	?>
	</li>	
	<li>
	<?php 
	echo $this->Form->Label('Your email', 'InsertEmail');
	echo $this->Form->TextBox('InsertEmail');
	?>
	</li>
	
	
	
	
<?php } ?>

	<li>
	<?php 
	echo $this->Form->Label('Question', 'Question');
	echo $this->Form->TextBox('Question', array('MultiLine' => True));
	?>
	</li>



</ul>

<?php echo $this->Form->Button('Send'); ?>
<?php echo $this->Form->Close(); ?>

</div>