<?php if (!defined('APPLICATION')) die();

class FaqModel extends Gdn_Model {
	
	public function __construct() {
		parent::__construct('Faq');
	}
	
	public function GetCount($Where = False) {
		$Where['bCountQuery'] = True;
		$Result = $this->Get($Where);
		return $Result;
	}
	
	public function Get($Where = False, $Offset = False, $Limit = False, $OrderBy = 'f.Sort', $OrderDirection = 'desc') {
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
		if ($Visible === Null) unset($Where['f.Visible']);

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
