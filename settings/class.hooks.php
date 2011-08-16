<?php if (!defined('APPLICATION')) exit();

class FaqHooks implements Gdn_IPlugin {
	
	public function Base_GetAppSettingsMenuItems_Handler($Sender) {
		$Menu =& $Sender->EventArguments['SideMenu'];
		$Menu->AddLink('Add-ons', T('FAQ'), 'faq/question/browse', 'Faq.Questions.Browse');
	}
	
	public function Setup() {
		include(PATH_APPLICATIONS . '/faq/settings/structure.php');
		$ApplicationInfo = array();
		include(CombinePaths(array(PATH_APPLICATIONS . '/candy/settings/about.php')));
		$Version = GetValue('Version', GetValue('Faq', $ApplicationInfo));
		SaveToConfig('Faq.Version', $Version);
	}
	
	public function OnDisable() {
		RemoveFromConfig('Faq.Version');
	}
	
}


