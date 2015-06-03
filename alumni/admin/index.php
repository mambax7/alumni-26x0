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
 * @license        GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package         alumni
 * @author          John Mordo (jlm69)
 * @version : $Id:
 * ****************************************************************************
 */
//require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/include/cp_header.php';
include __DIR__ . '/admin_header.php';
//include_once '../include/functions.php';
//$xoops = Xoops::getInstance();
$xoops->header();


	$listing_Handler = $xoops->getModuleHandler('alumni_listing', 'alumni');

	$criteria = new CriteriaCompo();
	$criteria->add(new Criteria('valid', 1));
	$listing_valid = $listing_Handler->getCount($criteria);
//	unset($criteria);
	
        $moderate_criteria = new CriteriaCompo();
        $moderate_criteria->add(new Criteria('valid', 0, '='));
	$moderate_count = $listing_Handler->getCount($moderate_criteria);
//	unset($moderate_criteria);
	
$indexAdmin = new Xoops\Module\Admin();
$indexAdmin->displayNavigation('index.php');
	

$indexAdmin->addInfoBox(AlumniLocale::LISTINGS, 'listing');
$indexAdmin->addInfoBoxLine(sprintf(AlumniLocale::TOTAL_LISTINGS, $moderate_count + $listing_valid), 'listing');
$indexAdmin->addInfoBoxLine(sprintf(AlumniLocale::TOTAL_VALID, $listing_valid), 'listing');
$indexAdmin->addInfoBoxLine(sprintf(AlumniLocale::TOTAL_NOT_VALID, $moderate_count), 'listing');

$extensions = array('comments' => 'extension',
                    'notifications' => 'extension',
                    'xcaptcha' => 'extension',
                    );
foreach ($extensions as $module => $type) {
    $indexAdmin->addConfigBoxLine(array($module, 'warning'), $type);
}



//$indexAdmin->addConfigBoxLine(array('comments', 'warning'), 'extension');
//$indexAdmin->addConfigBoxLine(array('notifications', 'warning'), 'extension');
//$indexAdmin->addConfigBoxLine(array('xcaptcha', 'warning'), 'extension');
       
                    
                    
                    
$indexAdmin->displayIndex();
//alumni_filechecks();

$xoops->footer();
