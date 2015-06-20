<?php
/**
 * ****************************************************************************
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package         alumni
 * @author          John Mordo (jlm69)
 * @version         : $Id:
 * ****************************************************************************
 */

//require_once dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';

include __DIR__ . '/admin_header.php';
//include_once '../include/functions.php';
//$xoops = Xoops::getInstance();
$xoops->header();
//$xoops->theme()->addStylesheet("modules/{$moduleDirName}/assets/css/moduladmin.css");

//$listingHandler = $xoops->getModuleHandler('Listing', $moduleDirName);

$criteria = new CriteriaCompo();
$criteria->add(new Criteria('valid', 1));
$listing_valid = $listingHandler->getCount($criteria);
//	unset($criteria);

$moderateCriteria = new CriteriaCompo();
$moderateCriteria->add(new Criteria('valid', 0, '='));
$moderate_count = $listingHandler->getCount($moderateCriteria);
//	unset($moderateCriteria);

$indexAdmin = new \Xoops\Module\Admin();
$indexAdmin->displayNavigation('index.php');

$indexAdmin->addInfoBox(AlumniLocale::LISTINGS, 'content');
$indexAdmin->addInfoBoxLine(sprintf(AlumniLocale::TOTAL_LISTINGS, $moderate_count + $listing_valid), 'content');
$indexAdmin->addInfoBoxLine(sprintf(AlumniLocale::TOTAL_VALID, $listing_valid), 'content');
$indexAdmin->addInfoBoxLine(sprintf(AlumniLocale::TOTAL_NOT_VALID, $moderate_count), 'content');

$extensions = array(
    'comments'      => 'extension',
    'notifications' => 'extension',
    'xcaptcha'      => 'extension');
foreach ($extensions as $module => $type) {
    $indexAdmin->addConfigBoxLine(array($module, 'warning'), $type);
}

//$indexAdmin->addConfigBoxLine(array('comments', 'warning'), 'extension');
//$indexAdmin->addConfigBoxLine(array('notifications', 'warning'), 'extension');
//$indexAdmin->addConfigBoxLine(array('xcaptcha', 'warning'), 'extension');

$indexAdmin->displayIndex();
//alumni_filechecks();

$xoops->footer();
