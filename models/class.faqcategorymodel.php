<?php if (!defined('APPLICATION')) die();

class FaqCategoryModel extends Gdn_Model {
	
	public function __construct() {
		parent::__construct('FaqCategory');
	}
	
	public function Save($FormValues) {
		$FaqCategoryID = parent::Save($FormValues);
		return $FaqCategoryID;
	}
	
	public function Get($Where = False, $Offset = False, $Limit = False, $OrderBy = False, $OrderDirection = 'desc') {
		$bCountQuery = GetValue('bCountQuery', $Where, False, True);
		if ($bCountQuery) {
			$this->SQL->Select('*', 'count', 'RowCount');
			$Offset = False;
			$Limit = False;
			$OrderBy = False;
		}
		
		if (GetValue('Summary', $Where, True, True) && !$bCountQuery) {
			$this->SQL
				->Select('c.FaqCategoryID, c.Name, c.Description');
		}
		
		if (is_array($Where)) $this->SQL->Where($Where);
		if ($OrderBy !== False) $this->SQL->OrderBy($OrderBy, $OrderDirection);
		
		$Result = $this->SQL
			->From($this->Name.' c')
			->Limit($Limit, $Offset)
			->Get();
		if ($bCountQuery) $Result = $Result->FirstRow()->RowCount;
		return $Result;
	}	
}
