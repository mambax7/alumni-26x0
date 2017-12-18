<?php
// This Release Apr-04-2011
//defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');
$xoops = Xoops::getInstance();
$moduleDirName = basename(__DIR__);
$modinfoLang   = '_MI_' . strtoupper($moduleDirName);
//$blocksLang    = '_MB_' . strtoupper($moduleDirName);

//$xoops->loadLanguage('block', $moduleDirName);
//$xoops->loadLanguage('modinfo', $moduleDirName);

// ------------------- Informations ------------------- //
$modversion = array(
    'name'                => AlumniLocale::MODULE_NAME,
    'description'         => AlumniLocale::MODULE_DESC,
    'official'            => 0,
    //1 indicates supported by XOOPS Dev Team, 0 means 3rd party supported
    'author'              => 'John Mordo',
    'nickname'            => 'jlm69',
    'author_mail'         => 'author-email',
    'author_website_url'  => 'http://jlmzone.com/',
    'author_website_name' => 'JLM Zone',
    'credits'             => 'XOOPS Development Team, John Mordo',
    'license'             => 'GPL 2.0 or later',
    'license_url'         => 'www.gnu.org/licenses/gpl-2.0.html/',
    'help'                => 'page=help',
    //
    'release_info'        => 'Changelog',
    'release_file'        => XOOPS_URL . '/modules/{$moduleDirName}/docs/changelog file',
    //
    'manual'              => 'link to manual file',
    'manual_file'         => XOOPS_URL . '/modules/{$moduleDirName}/docs/install.txt',
    'min_php'             => '5.4.0',
    'min_xoops'           => '2.6.0',
    'min_admin'           => '1.1',
    'min_db'              => array(
        'mysql'  => '5.0.7',
        'mysqli' => '5.0.7'),
    // images
    'image'               => 'assets/images/module_logo.png',
    'iconsmall'           => 'assets/images/iconsmall.png',
    'iconbig'             => 'assets/images/iconbig.png',
    'dirname'             => "{$moduleDirName}",
    //Frameworks
    'dirmoduleadmin'      => 'Frameworks/moduleclasses/moduleadmin',
    'sysicons16'          => 'Frameworks/moduleclasses/icons/16',
    'sysicons32'          => 'Frameworks/moduleclasses/icons/32',
    // Local path icons
    'modicons16'          => 'assets/images/icons/16',
    'modicons32'          => 'assets/images/icons/32',
    //About
    'version'             => 3.1,
    'module_status'       => 'Beta 1',
    'release_date'        => '2015/06/03',
    //yyyy/mm/dd
    //    'release'             => '2015-04-04',
    'demo_site_url'       => 'http://www.xoops.org',
    'demo_site_name'      => 'XOOPS Demo Site',
    'support_url'         => 'https://xoops.org/modules/newbb',
    'support_name'        => 'Support Forum',
    'module_website_url'  => 'www.xoops.org',
    'module_website_name' => 'XOOPS Project',
    // paypal
    'paypal'              => array(
        'business'      => 'admin@jlmzone.com',
        'item_name'     => 'Donation : ' . AlumniLocale::MODULE_DESC,
        'amount'        => 0,
        'currency_code' => 'USD'),
    // Admin system menu
    'system_menu'         => 1,
    // Admin menu
    'hasAdmin'            => 1,
    'adminindex'          => 'admin/index.php',
    'adminmenu'           => 'admin/menu.php',
    // JQuery
    'jquery'              => 1,
    // Main menu
    'hasMain'             => 1,
    //Search & Comments
    //    'hasSearch'           => 1,
    //    'search'              => array(
    //        'file'   => 'include/search.inc.php',
    //        'func'   => 'XXXX_search'),
    //    'hasComments'         => 1,
    //    'comments'              => array(
    //        'pageName'   => 'index.php',
    //        'itemName'   => 'id'),

    // Install/Update
    'onInstall'           => 'include/oninstall.php',
    'onUpdate'            => 'include/onupdate.php'//  'onUninstall'         => 'include/onuninstall.php'

);

// ------------------- Mysql ------------------- //
$modversion['schema'] = 'sql/schema.yml';

// Tables created by sql file (without prefix!)
$modversion['tables'] = array(
    $moduleDirName . '_listing',
    $moduleDirName . '_categories',
    $moduleDirName . '_ip_log');

// ------------------- Templates ------------------- //

$modversion['templates'] = array(
    array('file' => 'alumni_adlist.tpl', 'description' => ''),
    array('file' => 'alumni_category.tpl', 'description' => ''),
    array('file' => 'alumni_index.tpl', 'description' => ''),
    array('file' => 'alumni_item.tpl', 'description' => ''),
    array('file' => 'alumni_search.tpl', 'description' => ''),
    array('file' => 'alumni_sendfriend.tpl', 'description' => ''),
    array('file' => '/admin/alumni_admin_cat.tpl', 'description' => ''),
    array('file' => '/admin/alumni_admin_listing.tpl', 'description' => ''),
    array('file' => '/admin/alumni_admin_moderated.tpl', 'description' => ''),
    array('file' => '/admin/alumni_admin_permissions.tpl', 'description' => ''),
    array('file' => '/blocks/alumni_block_new.tpl', 'description' => ''));

//$modversion['templates'][1]['file'] = 'alumni_index.html';
//$modversion['templates'][1]['description'] = '';
//$modversion['templates'][2]['file'] = 'alumni_adlist.html';
//$modversion['templates'][2]['description'] = '';
//$modversion['templates'][3]['file'] = 'alumni_category.html';
//$modversion['templates'][3]['description'] = '';
//$modversion['templates'][4]['file'] = 'alumni_item.html';
//$modversion['templates'][4]['description'] = '';
//$modversion['templates'][5]['file'] = 'alumni_sendfriend.html';
//$modversion['templates'][5]['description'] = '';
//$modversion['templates'][6]['file'] = 'alumni_search.html';
//$modversion['templates'][6]['description'] = '';

// ------------------- blocks ------------------- //
//blocks should or don't have have hardcoded numbers?
/*
$modversion['blocks'][] = array(
    'file'        => 'alumni.php',
    'name'        => constant($blocksLang . '_BNAME'),
    'description' => constant($blocksLang . '_BNAME_DESC'),
    'show_func'   => 'alumni_show',
    'edit_func'   => 'alumni_edit',
    'template'    => 'alumni_block_new.tpl',
    //    'can_clone'     => true,
    'options'     => 'date|10|25|0');
*/
$modversion['blocks'][] = array(
    'file'        => 'alumni.php',
    'name'        => constant($modinfoLang . '_BNAME'),
    'description' => constant($modinfoLang . '_BNAME_DESC'),
    'show_func'   => 'alumni_show',
    'edit_func'   => 'alumni_edit',
    'template'    => 'alumni_block_new.tpl',
    'can_clone'   => true,
    'options'     => 'date|10|25|0');

// Search
//$modversion['hasSearch'] = 1;
//$modversion['search']['file'] = 'include/search.inc.php';
//$modversion['search']['func'] = 'alumni_search';

// If you want the comments for ads instead of the seller uncomment below and comment out above and uncomment below.
// Comments
//$modversion['hasComments'] = 1;

//$modversion['comments']['itemName'] = 'lid';
//$modversion['comments']['pageName'] = 'viewad.php';
//$modversion['comments']['extraParams'] = array('lid');
// Comment callback functions - do not uncomment this line
//$modversion['comments']['callbackFile'] = 'include/comment_functions.php';
//$modversion['comments']['callback']['approve'] = "".$moduleDirName."_com_approve";
//$modversion['comments']['callback']['update'] = "".$moduleDirName."_com_update";

// ------------------- Config Options ------------------- //
$modversion['config'][] = array(
    'name'        => 'alumni_usecat',
    'title'       => constant($modinfoLang . '_USECAT'),
    'description' => '',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '1',
    'options'     => array());

// $xoopsModuleConfig['alumni_moderated']
$modversion['config'][] = array(
    'name'        => 'alumni_moderated',
    'title'       => constant($modinfoLang . '_MODERAT'),
    'description' => '',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '0',
    'options'     => array());

// $xoopsModuleConfig['alumni_per_page']
$modversion['config'][] = array(
    'name'        => 'alumni_per_page',
    'title'       => constant($modinfoLang . '_PERPAGE'),
    'description' => '',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => '10',
    'options'     => array('10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '35' => 35, '40' => 40, '50' => 50));

// $xoopsModuleConfig['alumni_new_listing']
$modversion['config'][] = array(
    'name'        => 'alumni_new_listing',
    'title'       => constant($modinfoLang . '_VIEWNEWCLASS'),
    'description' => constant($modinfoLang . '_ONHOME'),
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '1',
    'options'     => array());

// $xoopsModuleConfig['alumni_newalumni']
$modversion['config'][] = array(
    'name'        => 'alumni_newalumni',
    'title'       => constant($modinfoLang . '_NUMNEW'),
    'description' => constant($modinfoLang . '_ONHOME'),
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => '10',
    'options'     => array());

// $xoopsModuleConfig['alumni_countday']
$modversion['config'][] = array(
    'name'        => 'alumni_countday',
    'title'       => constant($modinfoLang . '_NEWTIME'),
    'description' => constant($modinfoLang . '_INDAYS'),
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => '3',
    'options'     => array());

// $xoopsModuleConfig['alumni_photomax']
$modversion['config'][] = array(
    'name'        => 'alumni_photomax',
    'title'       => constant($modinfoLang . '_MAXIIMGS'),
    'description' => constant($modinfoLang . '_INBYTES'),
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => '500000',
    'options'     => array());

// $xoopsModuleConfig['alumni_maxwide']
$modversion['config'][] = array(
    'name'        => 'alumni_maxwide',
    'title'       => constant($modinfoLang . '_MAXWIDE'),
    'description' => $modinfoLang . '_INPIXEL',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => '700',
    'options'     => array());

// $xoopsModuleConfig['alumni_maxhigh']
$modversion['config'][] = array(
    'name'        => 'alumni_maxhigh',
    'title'       => constant($modinfoLang . '_MAXHIGH'),
    'description' => constant($modinfoLang . '_INPIXEL'),
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => '1000',
    'options'     => array());

// $xoopsModuleConfig['alumni_csortorder']
$modversion['config'][] = array(
    'name'        => 'alumni_csortorder',
    'title'       => constant($modinfoLang . '_ORDER'),
    'description' => '',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'title ASC',
    'options'     => array($modinfoLang . '_ORDREALPHA' => 'title', $modinfoLang . '_ORDREPERSO' => 'ordre'));

// $xoopsModuleConfig['alumni_showsubcat']
$modversion['config'][] = array(
    'name'        => 'alumni_showsubcat',
    'title'       => constant($modinfoLang . '_DISPLSUBCAT'),
    'description' => constant($modinfoLang . '_ONHOME'),
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '1',
    'options'     => array());

// $xoopsModuleConfig['alumni_numsubcat']
$modversion['config'][] = array(
    'name'        => 'alumni_numsubcat',
    'title'       => constant($modinfoLang . '_NUMSUBCAT'),
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => '4',
    'options'     => array());

// $xoopsModuleConfig['alumni_csortorder']
$modversion['config'][] = array(
    'name'        => 'alumni_csortorder',
    'title'       => constant($modinfoLang . '_ORDER'),
    'description' => '',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'title',
    'options'     => array($modinfoLang . '_ORDREALPHA' => 'title', $modinfoLang . '_ORDREPERSO' => 'ordre'));

// $xoopsModuleConfig['alumni_lsortorder']
$modversion['config'][] = array(
    'name'        => 'alumni_lsortorder',
    'title'       => constant($modinfoLang . '_AORDER'),
    'description' => '',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'name',
    'options'     => array($modinfoLang . '_ORDER_DATE' => 'date DESC', $modinfoLang . '_ORDER_NAME' => 'name ASC', $modinfoLang . '_ORDER_POP' => 'hits DESC'));

// $xoopsModuleConfig['alumni_form_options'] - Use WYSIWYG Editors?

$editors = XoopsLists::getDirListAsArray(XOOPS_ROOT_PATH . '/class/xoopseditor');

$modversion['config'][] = array(
    'name'        => 'alumni_form_options',
    'title'       => constant($modinfoLang . '_EDITOR'),
    'description' => constant($modinfoLang . '_LIST_EDITORS'),
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'dhtmltextarea',
    'options'     => $editors);

//$modversion['config'][$i]['name'] = 'alumni_form_options';
//$modversion['config'][$i]['title'] =  $modinfoLang . '_EDITOR';
//$modversion['config'][$i]['description'] =  $modinfoLang . '_LIST_EDITORS';
//$modversion['config'][$i]['formtype'] = 'select';
//$modversion['config'][$i]['valuetype'] = 'text';
//$modversion['config'][$i]['default'] = 'dhtmltextarea';
//XoopsLoad::load('XoopsEditorHandler');
//$editorHandler = XoopsEditorHandler::getInstance();
//$modversion['config'][$i]['options'] = array_flip($editorHandler->getList());

// $xoopsModuleConfig['alumni_use_captcha']
$modversion['config'][] = array(
    'name'        => 'alumni_use_captcha',
    'title'       => constant($modinfoLang . '_USE_CAPTCHA'),
    'description' => constant($modinfoLang . '_USE_CAPTCHA_DESC'),
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '1',
    'options'     => array());

// $xoopsModuleConfig['alumni_use_code']
$modversion['config'][] = array(
    'name'        => 'alumni_use_code',
    'title'       => constant($modinfoLang . '_USE_INDEX_CODE'),
    'description' => constant($modinfoLang . '_USE_INDEX_CODE_DESC'),
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '1',
    'options'     => array());

// $xoopsModuleConfig['alumni_useBanner']
$modversion['config'][] = array(
    'name'        => 'alumni_useBanner',
    'title'       => constant($modinfoLang . '_useBanner'),
    'description' => constant($modinfoLang . '_useBanner_DESC'),
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '1',
    'options'     => array());

// $xoopsModuleConfig['alumni_index_code']
$modversion['config'][] = array(
    'name'        => 'alumni_index_code',
    'title'       => constant($modinfoLang . '_INDEX_CODE'),
    'description' => constant($modinfoLang . '_INDEX_CODE_DESC'),
    'formtype'    => 'textarea',
    'valuetype'   => 'text',
    'default'     => ''

);

// $xoopsModuleConfig['alumni_indexCodePlace']
$modversion['config'][] = array(
    'name'        => 'alumni_code_place',
    'title'       => constant($modinfoLang . '_indexCodePlace'),
    'description' => constant($modinfoLang . '_indexCodePlace_DESC'),
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => '5');

// $xoopsModuleConfig['alumni_offer_search'] - added for optional search
$modversion['config'][] = array(
    'name'        => 'alumni_offer_search',
    'title'       => constant($modinfoLang . '_OFFER_SEARCH'),
    'description' => constant($modinfoLang . '_OFFER_SEARCH_DESC'),
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '1',
    'options'     => array());

$modversion['notification']    = array();
$modversion['hasNotification'] = 1;
