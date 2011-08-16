<?php if (!defined('APPLICATION')) exit();

class QuestionController extends FaqController {
	
	public $Uses = array('FaqModel', 'Form');
	public $AdminView = True;
	
	public function Initialize() {
		parent::Initialize();
		if ($this->DeliveryType() == DELIVERY_TYPE_ALL) {
			$this->AddCssFile('faq.css');
			$this->AddSideMenu();
		}
	}
	
	public function Add() {
		$this->View = 'Edit';
		$this->Edit();
	}
	
	public function Edit($FaqID = '') {
		$this->Permission('Faq.Questions.Edit');
		$FaqCategoryModel = new FaqCategoryModel();
		$Question = False;
		$this->Form->SetModel($this->FaqModel);
		if ($FaqID) {
			$Question = $this->FaqModel->GetID($FaqID);
			if ($Question) $this->Form->AddHidden('FaqID', $Question->FaqID);
		}
		if ($this->Form->AuthenticatedPostBack()) {
			$this->Form->Save();
		} else {
			$this->Form->SetData($Question);			
		}
		$this->FaqCategory = $FaqCategoryModel->Get();
		$this->Title(ConcatSep(' - ', T('Questions'), GetValue('Question', $Question)));
		$this->Render();
	}

	public function Browse($Page = '') {
		$this->Permission('Faq.Questions.Browse');
		list($Offset, $Limit) = OffsetLimit($Page, 20);
		$Where = array('f.Visible' => Null, 'OnlyCategory' => False, 'WithCategory' => True);
		$this->RecordCount = $this->FaqModel->GetCount($Where);
		$this->Faqs = $this->FaqModel->Get($Where, $Offset, $Limit);
		
		$this->Pager = new PagerModule($this);
		$this->Pager->Configure($Offset, $Limit, $this->RecordCount, 'faq/questions/%s');
		
		$this->Title(T('Questions'));
		$this->Render();
	}
	
	public function Delete($FaqID) {
		$this->Permission('Faq.Questions.Delete');
		$this->FaqModel->Delete($FaqID);
		if ($this->_DeliveryType == DELIVERY_TYPE_ALL) {
			Redirect('faq/question/browse');
		}
		$this->Render();
	}
	


}
