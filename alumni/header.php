﻿<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/
use Xoops\Core\Request;
/**
 * page module
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package         page
 * @since           2.6.0
 * @author          Mage Grégory (AKA Mage)
 * @version         $Id$
 */

include_once dirname(dirname(__DIR__)) . '/mainfile.php';
include_once __DIR__ . '/include/common.php';
// Get main instance
XoopsLoad::load('system', 'system');
$system = System::getInstance();

//$request = Xoops_Request::getInstance();
$helper = Alumni::getInstance();
//$xoops = Xoops::getInstance();
$xoops = $helper->xoops();
// Get handler
$category_Handler = $helper->getCategoryHandler();
$listing_Handler = $helper->getListingHandler();

$gperm_Handler = $helper->getGrouppermHandler();

//permission
$groups = $xoops->getUserGroups();
$uid = $helper->getUserId();
// Define Stylesheet
$xoops->theme()->addStylesheet($helper->url('css/styles.css'));
$xoops->theme()->addStylesheet($helper->url('css/rating.css'));

// Get $_POST, $_GET, $_REQUEST
//$start = Request::getInt('start', 0);

// Parameters
$module_id = $helper->getModule()->getVar('mid');
$interval = 3600; //1 hour