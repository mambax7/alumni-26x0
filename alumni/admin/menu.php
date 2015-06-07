<?php

defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');
////$path = dirname(dirname(dirname(__DIR__)));
////include_once $path . '/mainfile.php';
include_once dirname(__DIR__) . '/include/common.php';
$alumni = Alumni::getInstance();

$moduleDirName = basename(dirname(__DIR__));
$xoops         = Xoops::getInstance();
$xoops->loadLanguage('modinfo', $moduleDirName);

$modinfo_lang = '_MI_' . strtoupper($moduleDirName);

//$adminmenu = array();

$i                      = 0;
$adminmenu[$i]['title'] = constant($modinfo_lang . '_ADMENU1');
$adminmenu[$i]['link']  = 'admin/index.php';
$adminmenu[$i]['icon']  = 'home.png';

++$i;
$adminmenu[$i]['title'] = constant($modinfo_lang . '_ADMENU5');
$adminmenu[$i]['link']  = 'admin/alumni.php';
$adminmenu[$i]['icon']  = 'manage.png';
++$i;
$adminmenu[$i]['title'] = constant($modinfo_lang . '_ADMENU2');
$adminmenu[$i]['link']  = 'admin/alumni_categories.php';
$adminmenu[$i]['icon']  = 'category.png';

++$i;
$adminmenu[$i]['title'] = constant($modinfo_lang . '_ADMENU3');
$adminmenu[$i]['link']  = 'admin/permissions.php';
$adminmenu[$i]['icon']  = 'permissions.png';

++$i;
$adminmenu[$i]['title'] = constant($modinfo_lang . '_ADMENU7');
$adminmenu[$i]['link']  = 'admin/about.php';
$adminmenu[$i]['icon']  = 'about.png';
