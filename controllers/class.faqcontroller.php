<?php if (!defined('APPLICATION')) exit();

class FaqController extends Gdn_Controller {
	
	public $Uses = array('FaqModel');
	public $AdminView;
	
	public function __construct() {
		parent::__construct();
		$this->PageName = 'faq';
	}
	
	public function Ask() {
		$this->UserSessionValid = Gdn::Session()->IsValid();
		$AllowAsk = Gdn::Session()->IsValid() || Gdn::Config('Faq.NewQuestions.AllowGuest');
		if (!$AllowAsk) throw PermissionException();
		$this->Form = Gdn::Factory('Form');
		$this->Form->SetModel($this->FaqModel);
		
		if ($this->Form->IsPostBack()) {
			$Settings = array('SendQuestion' => True);
			$FaqID = $this->Form->Save($Settings);
			if ($FaqID) {
				$this->InformMessage(T('Faq.AskThankMessage', 'Thank you for question.'), array('CssClass' => 'Dismissable AutoDismiss'));
				$this->RedirectUrl = Url('faq');
			}
		}
		
		$this->Title(T('Ask question'));
		$this->Render();
	}
	
	public function Index($Page = 'p1') {
		$this->AddJsFile('jquery.accordion.js');
		$QuestionsPerPage = C('Faq.Questions.PerPage');
		$Where = array('f.Visible' => 1, 'OnlyCategory' => True);
		list($Offset, $Limit) = OffsetLimit($Page, $QuestionsPerPage);
		if ($QuestionsPerPage) {
			$this->RecordCount = $this->FaqModel->GetCount($Where);
			$this->Pager = new PagerModule($this);
			$this->Pager->Configure($Offset, $Limit, $this->RecordCount, 'faq/%s');
		} else {
			$Offset = False;
			$Limit = False;
		}
		
		$this->Faqs = $this->FaqModel->Get($Where, $Offset, $Limit);
		$this->Title(T('F. A. Q.'));
		$this->Render();
	}
	
	public function Initialize() {
		parent::Initialize();
		if ($this->DeliveryType() == DELIVERY_TYPE_ALL) {
			$this->Head = new HeadModule($this);
			$this->AddJsFile('jquery.js');
			$this->AddJsFile('jquery.livequery.js');
			$this->AddJsFile('jquery.form.js');
			$this->AddJsFile('jquery.popup.js');
			$this->AddJsFile('jquery.gardenhandleajaxform.js');
			$this->AddJsFile('global.js');
			if ($this->AdminView) {
				$this->AddCssFile('admin.css');
				$this->MasterView = 'admin';
			} else {
				$this->AddCssFile('style.css');
			}
			$this->AddCssFile('faq.css');
			$this->AddJsFile('jquery.autogrow.js');
			$this->AddJsFile('faq.js');
			
			if (!$this->AdminView) {
				$SectionID = C('Faq.Candy.SectionID');
				if ($SectionID && class_exists('CandyHooks') && method_exists('CandyHooks', 'AddModules')) {
					CandyHooks::AddModules($this, $SectionID);
				}
			}
		}
	}
	
	/**
	* Build and add the Dashboard's side navigation menu.
	* 
	* @since 2.0.0
	* @access public
	*
	* @param string $CurrentUrl Used to highlight correct route in menu.
	*/
	public function AddSideMenu($CurrentUrl = FALSE) {
		if (!$CurrentUrl) $CurrentUrl = strtolower($this->SelfUrl);
		
		// Only add to the assets if this is not a view-only request
		if ($this->_DeliveryType == DELIVERY_TYPE_ALL) {
			// Configure SideMenu module
			$SideMenu = new SideMenuModule($this);
			$SideMenu->HtmlId = '';
			$SideMenu->HighlightRoute($CurrentUrl);
			$SideMenu->Sort = C('Garden.DashboardMenu.Sort');
		
			// Hook for adding to menu
			$this->EventArguments['SideMenu'] = &$SideMenu;
			$this->FireEvent('GetAppSettingsMenuItems');
		
			// Add the module
			$this->AddModule($SideMenu, 'Panel');
		}
	}
	
}
