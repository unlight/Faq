<?php if (!defined('APPLICATION')) exit();

if (!isset($Drop)) $Drop = False;
if (!isset($Explicit)) $Explicit = True;

$Version = C('Faq.Version');

$Database = Gdn::Database();
$Px = $Database->DatabasePrefix;
$SQL = $Database->SQL(); // To run queries.
$Construct = $Database->Structure(); // To modify and add database tables.
$Validation = new Gdn_Validation(); // To validate permissions (if necessary).

Gdn::Structure()
	->Table('Faq')
	->PrimaryKey('FaqID', 'usmallint')
	->Column('FaqCategoryID', 'usmallint', True, 'key')
	->Column('Question', 'varchar(200)')
	->Column('Answer', 'text', True)
	->Column('Format', 'varchar(20)', 'xHtml')
	->Column('Sort', 'smallint', 0)
	->Column('Visible', 'tinyint(1)', 0)
	->Column('InsertName', 'varchar(120)', True)
	->Column('InsertEmail', 'varchar(120)', True)
	->Column('InsertUserID', 'int', 0)
	->Column('DateInserted', 'datetime')
	->Column('UpdateUserID', 'int', True)
	->Column('DateUpdated', 'datetime', True)
	->Engine('MyISAM')
	->Set($Explicit, $Drop);
	
Gdn::Structure()
	->Table('FaqCategory')
	->PrimaryKey('FaqCategoryID', 'usmallint')
	->Column('Name', 'varchar(120)')
	->Column('Description', 'varchar(500)', True)
	->Engine('MyISAM')
	->Set($Explicit, $Drop);
	
	
// Set route
/*if (!Gdn::Router()->GetRoute('faq')) {
	//Gdn::Router()->SetRoute('map', 'candy/content/map', 'Internal');
}*/

$PermissionModel = Gdn::PermissionModel();

$PermissionModel->Define(array(
	'Faq.Settings.Manage',
	'Faq.Questions.Edit',
	'Faq.Questions.Delete',
	'Faq.Questions.Browse',
	'Faq.Categories.Browse',
	'Faq.Categories.Edit',
	'Faq.Categories.Delete',
));

$PermissionModel->Save(array(
	'RoleID' => 16,
	'Faq.Questions.Browse' => 1,
));



/*$PermissionModel->Define(array(
),
	'tinyint',
	'Section',
	'SectionID'
);*/



















