<?php if (!defined('APPLICATION')) die();

class FaqModel extends Gdn_Model {
	
	public function __construct() {
		parent::__construct('Faq');
	}
	
	/**
	* Undocumented 
	* 
	*/
	protected static function SetNullValues(&$Fields, $Nulls = array('')) {
		if (!is_array($Nulls)) $Nulls = array_slice(func_get_args(), 1);
		foreach ($Fields as &$Value) {
			if (in_array($Value, $Nulls, True)) $Value = NULL;
		}
	}
	
	public function Save($FormValues, $Settings = False) {
		self::SetNullValues($FormValues, '');
		if (array_key_exists('InsertName', $FormValues)) $this->Validation->ApplyRule('InsertName', 'Required');
		if (array_key_exists('InsertEmail', $FormValues)) $this->Validation->ApplyRule('InsertEmail', array('Required', 'Email'));
		$FaqID = parent::Save($FormValues);
		if ($FaqID) {
			$SendQuestion = GetValue('SendQuestion', $Settings);
			if ($SendQuestion) $this->SendQuestion($FaqID);
		}
		return $FaqID;
	}
	
	protected function SendQuestion($ID) {
		$SendTo = C('Faq.NewQuestions.SendTo');
		if ($SendTo) {
			$Data = $this->GetFaqID($ID);
			$Subject = FormatString(T('Faq.EmailAskQuestionSubject'), $Data);
			$Message = FormatString(T('Faq.EmailAskQuestionMessage'), $Data);
			$Email = new Gdn_Email();
			$Email
				->To($SendTo)
				->Subject($Subject)
				->Message($Message)
				->Send();
		}
	}
	
	public function GetFaqID($FaqID) {
		$this->SQL->Select('f.*');
		$Data = $this->Get(array('f.FaqID' => $FaqID, 'WithAuthor' => True), False, False, False, False);
		return $Data->FirstRow();
	}
	
	public function GetCount($Where = False) {
		$Where['bCountQuery'] = True;
		$Result = $this->Get($Where);
		return $Result;
	}
	
	public function Get($Where = False, $Offset = False, $Limit = False, $OrderBy = 'f.Sort', $OrderDirection = 'asc') {
		$bCountQuery = GetValue('bCountQuery', $Where, False, True);
		if ($bCountQuery) {
			$this->SQL->Select('*', 'count', 'RowCount');
			$Offset = False;
			$Limit = False;
			$OrderBy = False;
		}
		
		if (GetValue('Summary', $Where, True, True) && !$bCountQuery) {
			$this->SQL
				->Select('f.FaqID, f.Question, f.Answer, f.Format, f.Sort, f.Visible, f.DateInserted, f.DateUpdated');
		}
		$Visible = TouchValue('f.Visible', $Where, 1);
		if ($Visible === Null || array_key_exists('f.FaqID', $Where)) unset($Where['f.Visible']);

		$this->EventAeguments['Where'] = $Where;
		$this->EventAeguments['bCountQuery'] = $bCountQuery;
		$this->FireEvent('BeforeGet');
		
		$OnlyCategory = GetValue('OnlyCategory', $Where, False, True);
		if ($OnlyCategory) {
			if ($OnlyCategory === True) $OnlyCategory = Gdn::Config('Faq.Questions.OnlyCategory');
			if ($OnlyCategory) {
				if (!is_array($OnlyCategory)) $OnlyCategory = array($OnlyCategory);
				$this->SQL->WhereIn('f.FaqCategoryID', (array)$OnlyCategory);
			}
		}
		
		if (GetValue('WithCategory', $Where, False, True)) {
			if (!$bCountQuery) {
				$this->SQL
					->Join('FaqCategory c', 'c.FaqCategoryID = f.FaqCategoryID', 'left');
				$this->SQL->Select('c.Name as CategoryName');
			}
		}
		
		if (GetValue('WithAuthor', $Where, False, True)) {
			if (!$bCountQuery) {
				$this->SQL
					->Join('User u', 'u.UserID = f.InsertUserID', 'left')
					->Select('f.InsertName, u.Name', 'coalesce', 'AuthorName')
					->Select('f.InsertEmail, u.Email', 'coalesce', 'AuthorEmail');
			}
		}
		
		if (is_array($Where)) $this->SQL->Where($Where);
		if ($OrderBy !== False) {
			$OrderBys = array_map('trim', explode(',', $OrderBy));
			foreach ($OrderBys as $OrderBy) {
				if (!strpos($OrderBy, ' ')) $OrderBy .= ' ' .  $OrderDirection;
				list($Field, $Direction) = explode(' ', $OrderBy);
				$this->SQL->OrderBy($Field, $Direction);
			}
		}
		
		$Result = $this->SQL
			->From($this->Name.' f')
			->Limit($Limit, $Offset)
			->Get();
		if ($bCountQuery) $Result = $Result->FirstRow()->RowCount;
		return $Result;
	}	
}
