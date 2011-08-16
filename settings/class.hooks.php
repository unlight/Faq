<?php if (!defined('APPLICATION')) exit();

class FaqHooks implements Gdn_IPlugin {
	
	public function Base_GetAppSettingsMenuItems_Handler($Sender) {
		$Menu =& $Sender->EventArguments['SideMenu'];
		$Menu->AddLink('Add-ons', T('FAQ'), 'faq/question/browse', 'Faq.Questions.Browse');
	}
	
	public function Setup() {
		include(PATH_APPLICATIONS . '/faq/settings/structure.php');
	}
	
	public function OnDisable() {
		RemoveFromConfig('Faq.Version');
	}
	
}


