<?php if (!defined('APPLICATION')) exit(); 

if (!isset($Alt)) $Alt = True;
$Alt = !$Alt;
$Class = array('Item');
if ($Alt) $Class[] = 'Alt';

if (!isset($PermissionQuestionsEdit)) $PermissionQuestionsEdit = CheckPermission('Faq.Questions.Edit');

echo '<li class="'.implode(' ', $Class).'">';
echo '<a name="Item_'.$Question->FaqID.'"></a>';
?>
<strong><?php echo $Question->Question;?></strong>
	<div class="ItemContent<?php echo (!$Question->Visible) ? ' NotVisible' : '';?>">
		<div class="Body"><?php
			$this->EventArguments['Format'] =& $Question->Format;
			$this->EventArguments['Body'] =& $Question->Answer;
			$this->FireEvent('BeforeBodyFormat');
			$FormatBody = Gdn_Format::To($Question->Answer, $Question->Format);
			echo $FormatBody;
			if ($PermissionQuestionsEdit) echo "<br/>", Anchor(T('Edit'), 'faq/question/edit/'.$Question->FaqID);
		?></div>
	</div>
</li>
