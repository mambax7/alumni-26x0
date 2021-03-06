<?php
//Released on Apr. 11 2011

defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');

$moduleDirName   = basename(dirname(__FILE__));
$cloned_lang = '_MI_' . strtoupper($moduleDirName);

$modversion['name']        = _MI_ALUMNI_NAME;
$modversion['version']     = '3.1';
$modversion['description'] = _MI_ALUMNI_DESC;
$modversion['credits']     = "Alumni Module for Xoops by John Mordo Created from Myads jp 2.04";
$modversion['author']      = "John Mordo";
$modversion['pseudo']      = 'jlm69';
$modversion['help']        = 'page=help';
$modversion['license']     = 'GNU GPL 2.0';
$modversion['license_url'] = "www.gnu.org/licenses/gpl-2.0.html/";
$modversion['official']    = 0;
$modversion['image']       = 'images/alumni_slogo.png';
$modversion['dirname']     = $moduleDirName;

//Mage
$modversion['status_version']   = 'ALPHA-1';
$modversion['release_date']     = '2014/05/27';
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';

//about
$modversion["module_website_url"]  = "http://www.jlmzone.com/";
$modversion["module_website_name"] = "jlmzone";
$modversion["release"]             = "2014/05/27";
$modversion["module_status"]       = "RC";
$modversion["author_website_url"]  = "http://www.jlmzone.com/";
$modversion["author_website_name"] = "jlmzone";

// Admin things
$modversion['hasAdmin']    = 1;
$modversion['system_menu'] = 1;
$modversion['adminindex']  = "admin/index.php";
$modversion['adminmenu']   = "admin/menu.php";

// Menu
$modversion['hasMain'] = 1;

// Templates
$modversion['templates'][1]['file']        = 'alumni_index.html';
$modversion['templates'][1]['description'] = '';
$modversion['templates'][2]['file']        = 'alumni_adlist.html';
$modversion['templates'][2]['description'] = '';
$modversion['templates'][3]['file']        = 'alumni_category.html';
$modversion['templates'][3]['description'] = '';
$modversion['templates'][4]['file']        = 'alumni_item.html';
$modversion['templates'][4]['description'] = '';
$modversion['templates'][5]['file']        = 'alumni_sendfriend.html';
$modversion['templates'][5]['description'] = '';
$modversion['templates'][6]['file']        = 'alumni_search.html';
$modversion['templates'][6]['description'] = '';

// Blocks
$modversion['blocks'][1]['file']        = "alumni.php";
$modversion['blocks'][1]['name']        = _MI_ALUMNI_BNAME;
$modversion['blocks'][1]['description'] = _MI_ALUMNI_BNAME_DESC;
$modversion['blocks'][1]['show_func']   = 'alumni_show';
$modversion['blocks'][1]['edit_func']   = "alumni_edit";
$modversion['blocks'][1]['template']    = 'alumni_block_new.html';
//$modversion['blocks'][1]['can_clone'] = "true" ;
$modversion['blocks'][1]['options'] = "date|10|25|0";

// Sql file (must contain sql generated by phpMyAdmin or phpPgAdmin)
// All tables should not have any prefix!
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

// Tables created by sql file (without prefix!)
$modversion['tables'][0] = 'alumni_listing';
$modversion['tables'][1] = 'alumni_categories';
$modversion['tables'][2] = 'alumni_ip_log';

// Search
$modversion['hasSearch']      = 1;
$modversion['search']['file'] = "include/search.inc.php";
$modversion['search']['func'] = 'alumni_search';

$i = 0;
//	Module Configs
// $xoopsModuleConfig['alumni_usecat']
$i++;
$modversion['config'][$i]['name']        = 'alumni_usecat';
$modversion['config'][$i]['title']       = _MI_ALUMNI_USECAT;
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = '1';
$modversion['config'][$i]['options']     = array();

// $xoopsModuleConfig['alumni_moderated']
$i++;
$modversion['config'][$i]['name']        = 'alumni_moderated';
$modversion['config'][$i]['title']       = _MI_ALUMNI_MODERAT;
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = '0';
$modversion['config'][$i]['options']     = array();

// $xoopsModuleConfig['alumni_per_page']
$i++;
$modversion['config'][$i]['name']        = 'alumni_per_page';
$modversion['config'][$i]['title']       = '_MI_ALUMNI_PERPAGE';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'select';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = '10';
$modversion['config'][$i]['options']     = array('10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '35' => 35, '40' => 40, '50' => 50);

// $xoopsModuleConfig['alumni_new_listing']
$i++;
$modversion['config'][$i]['name']        = 'alumni_new_listing';
$modversion['config'][$i]['title']       = _MI_ALUMNI_VIEWNEWCLASS;
$modversion['config'][$i]['description'] = _MI_ALUMNI_ONHOME;
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = '1';
$modversion['config'][$i]['options']     = array();

// $xoopsModuleConfig['alumni_newalumni']
$i++;
$modversion['config'][$i]['name']        = 'alumni_newalumni';
$modversion['config'][$i]['title']       = _MI_ALUMNI_NUMNEW;
$modversion['config'][$i]['description'] = _MI_ALUMNI_ONHOME;
$modversion['config'][$i]['formtype']    = 'textbox';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = '10';
$modversion['config'][$i]['options']     = array();

// $xoopsModuleConfig['alumni_countday']
$i++;
$modversion['config'][$i]['name']        = 'alumni_countday';
$modversion['config'][$i]['title']       = _MI_ALUMNI_NEWTIME;
$modversion['config'][$i]['description'] = _MI_ALUMNI_INDAYS;
$modversion['config'][$i]['formtype']    = 'textbox';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = '3';
$modversion['config'][$i]['options']     = array();

// $xoopsModuleConfig['alumni_photomax']
$i++;
$modversion['config'][$i]['name']        = 'alumni_photomax';
$modversion['config'][$i]['title']       = _MI_ALUMNI_MAXIIMGS;
$modversion['config'][$i]['description'] = _MI_ALUMNI_INBYTES;
$modversion['config'][$i]['formtype']    = 'textbox';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = '500000';
$modversion['config'][$i]['options']     = array();

// $xoopsModuleConfig['alumni_maxwide']
$i++;
$modversion['config'][$i]['name']        = 'alumni_maxwide';
$modversion['config'][$i]['title']       = _MI_ALUMNI_MAXWIDE;
$modversion['config'][$i]['description'] = _MI_ALUMNI_INPIXEL;
$modversion['config'][$i]['formtype']    = 'textbox';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = '700';
$modversion['config'][$i]['options']     = array();

// $xoopsModuleConfig['alumni_maxhigh']
$i++;
$modversion['config'][$i]['name']        = 'alumni_maxhigh';
$modversion['config'][$i]['title']       = _MI_ALUMNI_MAXHIGH;
$modversion['config'][$i]['description'] = _MI_ALUMNI_INPIXEL;
$modversion['config'][$i]['formtype']    = 'textbox';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = '1000';
$modversion['config'][$i]['options']     = array();

// $xoopsModuleConfig['alumni_csortorder']
$i++;
$modversion['config'][$i]['name']        = 'alumni_csortorder';
$modversion['config'][$i]['title']       = _MI_ALUMNI_ORDER;
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'select';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = 'title ASC';
$modversion['config'][$i]['options']     = array(_MI_ALUMNI_ORDREALPHA => 'title', _MI_ALUMNI_ORDREPERSO => 'ordre');

// $xoopsModuleConfig['alumni_showsubcat']
$i++;
$modversion['config'][$i]['name']        = 'alumni_showsubcat';
$modversion['config'][$i]['title']       = _MI_ALUMNI_DISPLSUBCAT;
$modversion['config'][$i]['description'] = _MI_ALUMNI_ONHOME;
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = '1';
$modversion['config'][$i]['options']     = array();

// $xoopsModuleConfig['alumni_numsubcat']
$i++;
$modversion['config'][$i]['name']        = 'alumni_numsubcat';
$modversion['config'][$i]['title']       = _MI_ALUMNI_NUMSUBCAT;
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'textbox';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = '4';
$modversion['config'][$i]['options']     = array();

// $xoopsModuleConfig['alumni_csortorder']
$i++;
$modversion['config'][$i]['name']        = 'alumni_csortorder';
$modversion['config'][$i]['title']       = _MI_ALUMNI_ORDER;
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'select';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = 'title';
$modversion['config'][$i]['options']     = array(_MI_ALUMNI_ORDREALPHA => 'title', _MI_ALUMNI_ORDREPERSO => 'ordre');

// $xoopsModuleConfig['alumni_lsortorder']
$i++;
$modversion['config'][$i]['name']        = 'alumni_lsortorder';
$modversion['config'][$i]['title']       = _MI_ALUMNI_AORDER;
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'select';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = 'name';
$modversion['config'][$i]['options']     = array(_MI_ALUMNI_ORDER_DATE => 'date DESC', _MI_ALUMNI_ORDER_NAME => 'name ASC', _MI_ALUMNI_ORDER_POP => 'hits DESC');

// $xoopsModuleConfig['alumni_form_options'] - Use WYSIWYG Editors?
$i++;
$modversion['config'][$i]['name']        = 'alumni_form_options';
$modversion['config'][$i]['title']       = _MI_ALUMNI_EDITOR;
$modversion['config'][$i]['description'] = _MI_ALUMNI_LIST_EDITORS;
$modversion['config'][$i]['formtype']    = 'select';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = 'dhtmltextarea';
XoopsLoad::load('XoopsEditorHandler');
$editor_handler                      = XoopsEditorHandler::getInstance();
$modversion['config'][$i]['options'] = array_flip($editor_handler->getList());

// $xoopsModuleConfig['alumni_use_captcha']
$i++;
$modversion['config'][$i]['name']        = 'alumni_use_captcha';
$modversion['config'][$i]['title']       = _MI_ALUMNI_USE_CAPTCHA;
$modversion['config'][$i]['description'] = _MI_ALUMNI_USE_CAPTCHA_DESC;
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = '1';
$modversion['config'][$i]['options']     = array();

// $xoopsModuleConfig['alumni_use_code']
$i++;
$modversion['config'][$i]['name']        = 'alumni_use_code';
$modversion['config'][$i]['title']       = _MI_ALUMNI_USE_INDEX_CODE;
$modversion['config'][$i]['description'] = _MI_ALUMNI_USE_INDEX_CODE_DESC;
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = '1';
$modversion['config'][$i]['options']     = array();

// $xoopsModuleConfig['alumni_use_banner']
$i++;
$modversion['config'][$i]['name']        = 'alumni_use_banner';
$modversion['config'][$i]['title']       = _MI_ALUMNI_USE_BANNER;
$modversion['config'][$i]['description'] = _MI_ALUMNI_USE_BANNER_DESC;
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = '1';
$modversion['config'][$i]['options']     = array();

// $xoopsModuleConfig['alumni_index_code']
$i++;
$modversion['config'][$i]['name']        = 'alumni_index_code';
$modversion['config'][$i]['title']       = _MI_ALUMNI_INDEX_CODE;
$modversion['config'][$i]['description'] = _MI_ALUMNI_INDEX_CODE_DESC;
$modversion['config'][$i]['formtype']    = 'textarea';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = '';

// $xoopsModuleConfig['alumni_index_code_place']
$i++;
$modversion['config'][$i]['name']        = 'alumni_code_place';
$modversion['config'][$i]['title']       = _MI_ALUMNI_INDEX_CODE_PLACE;
$modversion['config'][$i]['description'] = _MI_ALUMNI_INDEX_CODE_PLACE_DESC;
$modversion['config'][$i]['formtype']    = 'textbox';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = '5';

// $xoopsModuleConfig['alumni_offer_search'] - added for optional search
$i++;
$modversion['config'][$i]['name']        = 'alumni_offer_search';
$modversion['config'][$i]['title']       = _MI_ALUMNI_OFFER_SEARCH;
$modversion['config'][$i]['description'] = _MI_ALUMNI_OFFER_SEARCH_DESC;
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = '1';
$modversion['config'][$i]['options']     = array();

//Notification
$modversion["notification"]    = array();
$modversion['hasNotification'] = 1;

// On Update
//if( ! empty( $_POST['fct'] ) && ! empty( $_POST['op'] ) && $_POST['fct'] == 'modulesadmin' && $_POST['op'] == 'update_ok' && $_POST['dirname'] == $modversion['dirname'] ) {
//	include dirname( __FILE__ ) . "/include/onupdate.inc.php" ;
//}
;
