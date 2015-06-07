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
 * @copyright    XOOPS Project http://xoops.org/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package
 * @since
 * @author       XOOPS Development Team
 * @version      $Id $
 */

use Xoops\Core\Request;

include_once dirname(dirname(dirname(__DIR__))) . '/mainfile.php';
include_once dirname(__DIR__) . '/include/common.php';
//include_once XOOPS_ROOT_PATH . '/include/cp_header.php';
//include_once '../include/functions.php';
XoopsLoad::load('system', 'system');
//global $xoopsModule;
$xoops = Xoops::getInstance();
$xoops->loadLanguage('modinfo');

$helper = Alumni::getInstance();
$xoops  = $helper->xoops();

$moduleDirName = basename(dirname(__DIR__));
$modinfo_lang  = '_MI_' . strtoupper($moduleDirName);
$admin_lang    = '_AM_' . strtoupper($moduleDirName);

//$request = Xoops_Request::getInstance();
$alumni_listing_Handler    = $xoops->getModuleHandler('alumni_listing', 'alumni');
$alumni_categories_Handler = $xoops->getModuleHandler('alumni_categories', 'alumni');
$alumni_gperm_Handler      = $helper->getGrouppermHandler();
$module_id                 = $helper->getModule()->getVar('mid');

XoopsLoad::loadFile($xoops->path(XOOPS_ROOT_PATH . '/include/cp_header.php'));
// Define Stylesheet
$xoops->theme()->addStylesheet('modules/system/css/admin.css');

// Add Scripts
$xoops->theme()->addScript('media/xoops/xoops.js');
