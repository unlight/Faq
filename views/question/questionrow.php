<?php if (!defined('APPLICATION')) die(); 

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