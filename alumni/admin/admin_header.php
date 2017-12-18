<?php
/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    XOOPS Project https://xoops.org/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package
 * @since
 * @author       XOOPS Development Team
 * @version      $Id $
 */

include_once dirname(dirname(dirname(__DIR__))) . '/mainfile.php';
include_once dirname(__DIR__) . '/include/common.php';
//include_once XOOPS_ROOT_PATH . '/include/cp_header.php';
//include_once '../include/functions.php';
XoopsLoad::load('system', 'system');
//global $xoopsModule;
$xoops = Xoops::getInstance();
$xoops->loadLanguage('modinfo');
//get local language for SystemLocale
$xoops->loadLocale('system');

$helper = Alumni::getInstance();
//$xoops  = $helper->xoops();

$moduleDirName = basename(dirname(__DIR__));
$modinfoLang   = '_MI_' . strtoupper($moduleDirName);
$adminLang     = '_AM_' . strtoupper($moduleDirName);

//$request = Xoops_Request::getInstance();
//$alumniListingHandler    = $xoops->getModuleHandler('Listing', $moduleDirName);
//$alumniCategoryHandler = $xoops->getModuleHandler('Category', $moduleDirName);
//$alumniGrouppermHandler  = $helper->getGrouppermHandler();

// Get handlers
$categoryHandler = $helper->getCategoryHandler();
$listingHandler  = $helper->getListingHandler();
$groupPermHandler = $helper->getGrouppermHandler();



$moduleId                = $helper->getModule()->getVar('mid');

XoopsLoad::loadFile($xoops->path(XOOPS_ROOT_PATH . '/include/cp_header.php'));
// Define Stylesheet
$xoops->theme()->addStylesheet('modules/system/css/admin.css');
// Add Scripts
$xoops->theme()->addScript('media/xoops/xoops.js');


