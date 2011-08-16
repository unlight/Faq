<?php if (!defined('APPLICATION')) exit();

class CategoryController extends FaqController {
	
	public $Uses = array('FaqCategoryModel', 'Form');
	public $AdminView = True;
	
	public function Initialize() {
		parent::Initialize();
		if ($this->DeliveryType() == DELIVERY_TYPE_ALL) {
			$this->AddCssFile('faq.css');
			$this->AddSideMenu();
		}
	}
	
	public function Browse() {
		$this->Permission('Faq.Categories.Browse');
		$this->FaqCategory = $this->FaqCategoryModel->Get();
		$this->Title(T('Faq Categories'));
		$this->Render();
	}
	
	public function Add() {
		$this->View = 'Edit';
		$this->Edit();
	}
	
	public function Edit($FaqCategoryID = '') {
		$this->Permission('Faq.Categories.Edit');
		$FaqCategory = False;
		$this->Form->SetModel($this->FaqCategoryModel);
		if ($FaqCategoryID) {
			$FaqCategory = $this->FaqCategoryModel->GetID($FaqCategoryID);
			if ($FaqCategory) $this->Form->AddHidden('FaqCategoryID', $FaqCategory->FaqCategoryID);
		}
		if ($this->Form->AuthenticatedPostBack()) {
			$SaveID = $this->Form->Save();
			if ($SaveID) $this->InformMessage(T('Saved'), array('Sprite' => 'Check', 'CssClass' => 'Dismissable AutoDismiss'));
		} else {
			$this->Form->SetData($FaqCategory);			
		}
		$this->Title(ConcatSep(' - ', T('Categories'), GetValue('Name', $FaqCategory)));
		$this->Render();
	}


	
	public function Delete($FaqCategoryID) {
		$this->Permission('Faq.Categories.Delete');
		$this->FaqCategoryModel->Delete($FaqCategoryID);
		if ($this->_DeliveryType == DELIVERY_TYPE_ALL) {
			Redirect('faq/category/browse');
		}
		$this->Render();
	}
	


}
