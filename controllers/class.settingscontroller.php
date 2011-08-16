<?php if (!defined('APPLICATION')) exit();

class SettingsController extends FaqController {
	
	public $Uses = array('Form');
	public $AdminView = True;
	
	public function Initialize() {
		parent::Initialize();
		if ($this->DeliveryType() == DELIVERY_TYPE_ALL) {
			$this->AddCssFile('faq.css');
			$this->AddSideMenu();
		}
	}
	
	public function Index() {
		$this->Permission('Faq.Settings.Manage');
		
		if ($this->Form->IsPostBack()) {
			$FormValues = $this->Form->FormValues();
			settype($FormValues['Faq.Questions.PerPage'], 'int');
			settype($FormValues['Faq.NewQuestions.AllowGuest'], 'bool');
			if (array_key_exists('Faq.Candy.SectionID', $FormValues)) settype($FormValues['Faq.Candy.SectionID'], 'int');
			$this->Form->FormValues($FormValues);
		}
		
		$this->ConfigurationModule = new ConfigurationModule($this);
		$Schema = array(
			'Faq.Questions.PerPage' => array('Control' => 'TextBox', 'Type' => 'Integer'),
			'Faq.NewQuestions.SendTo' => array('LabelCode' => 'New questions send to'), // TODO: CHECKBOX2 LABEL CODE BEFORE
			'Faq.NewQuestions.AllowGuest' => array('LabelCode' => 'Allow guests to ask', 'Control' => 'CheckBox')
		);
		if (C('Candy.Version')) {
			$SectionModel = Gdn::Factory('SectionModel');
			$Sections = $SectionModel->Full('*', '', C('Candy.RootSectionID'), False);
			$Options = array('IncludeNull' => True, 'TextField' => 'Name', 'ValueField' => 'SectionID');
			$Schema['Faq.Candy.SectionID'] = array('Control' => 'DropDown', 'Items' => $Sections, 'Options' => $Options);
		}
		$this->ConfigurationModule->Schema($Schema);
		$this->ConfigurationModule->Initialize();
		
		$this->Title(T('Settings'));
		$this->Render();
	}
	

}
