<?php

defined("XOOPS_ROOT_PATH") or die("XOOPS root path not defined");
////$path = dirname(dirname(dirname(dirname(__FILE__))));
////include_once $path . '/mainfile.php';
include_once dirname(__DIR__) . '/include/common.php';
$alumni = Alumni::getInstance();
$alumni->loadLanguage('admin');

//$adminmenu = array();

$i = 0;
$adminmenu[$i]["title"] = _MI_ALUMNI_ADMENU1;
$adminmenu[$i]["link"] = 'admin/index.php';
$adminmenu[$i]["icon"] = 'home.png';

++$i;
$adminmenu[$i]["title"] = _MI_ALUMNI_ADMENU5;
$adminmenu[$i]["link"] = 'admin/alumni.php';
$adminmenu[$i]["icon"] = 'manage.png';
++$i;
$adminmenu[$i]["title"] = _MI_ALUMNI_ADMENU2;
$adminmenu[$i]["link"] = 'admin/alumni_categories.php';
$adminmenu[$i]["icon"] = 'category.png';

++$i;
$adminmenu[$i]["title"] = _MI_ALUMNI_ADMENU3;
$adminmenu[$i]["link"] = 'admin/permissions.php';
$adminmenu[$i]["icon"] = 'permissions.png';

++$i;
$adminmenu[$i]["title"] = _MI_ALUMNI_ADMENU7;
$adminmenu[$i]["link"] = 'admin/about.php';
$adminmenu[$i]["icon"] = 'about.png';

