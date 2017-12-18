<?php

defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');
////$path = dirname(dirname(dirname(__DIR__)));
////include_once $path . '/mainfile.php';
include_once dirname(__DIR__) . '/include/common.php';
$alumni = Alumni::getInstance();

$moduleDirName = basename(dirname(__DIR__));
$xoops         = Xoops::getInstance();
$xoops->loadLanguage('modinfo', $moduleDirName);

$modinfoLang = '_MI_' . strtoupper($moduleDirName);

//$adminmenu = array();

$adminmenu[] = array(
    'title' => constant($modinfoLang . '_ADMENU1'),
    'link'  => 'admin/index.php',
    'icon'  => 'home.png');

$adminmenu[] = array(
    'title' => constant($modinfoLang . '_ADMENU5'),
    'link'  => 'admin/alumni.php',
    'icon'  => 'manage.png');

$adminmenu[] = array(
    'title' => constant($modinfoLang . '_ADMENU2'),
    'link'  => 'admin/alumni_categories.php',
    'icon'  => 'category.png');

$adminmenu[] = array(
    'title' => constant($modinfoLang . '_ADMENU3'),
    'link'  => 'admin/permissions.php',
    'icon'  => 'permissions.png');

$adminmenu[] = array(
    'title' => constant($modinfoLang . '_ADMENU7'),
    'link'  => 'admin/about.php',
    'icon'  => 'about.png');
