<?php
//  -----------------------------------------------------------------------  //
//                           Alumni for Xoops 2.0x                           //
//                  By John Mordo from the myAds 2.04 Module                 //
//                    All Original credits left below this                   //
//                                                                           //
//                                                                           //
//                                                                           //
// ------------------------------------------------------------------------- //
//               E-Xoops: Content Management for the Masses                  //
//                       < http://www.e-xoops.com >                          //
// ------------------------------------------------------------------------- //
// Original Author: Pascal Le Boustouller                                    //
// Author Website : pascal.e-xoops@perso-search.com                          //
// Licence Type   : GPL                                                      //
// ------------------------------------------------------------------------- //

use Xoops\Core\Request;

include __DIR__ . '/header.php';
include XOOPS_ROOT_PATH . '/modules/system/locale/en_US/en_US.php';
$moduleDirName = basename(__DIR__);
$mainLang      = '_MA_' . strtoupper($moduleDirName);
require_once(XOOPS_ROOT_PATH . "/modules/{$moduleDirName}/class/gtickets.php");
$myts     = MyTextSanitizer::getInstance();
$xoops    = Xoops::getInstance();
$alumni   = Alumni::getInstance();
$moduleId = $xoopsModule->getVar('mid');

$groups = SystemLocale::ANONYMOUS_USERS_GROUP;
if (is_object($xoops->user)) {
    $groups = $xoops->user->getGroups();
}
//$groupPermHandler = $xoops->getHandler('groupperm');
$perm_itemid = 0;
if ($tempItemId = Request::getInt('item_id', null, 'POST')) {
    $perm_itemid = $tempItemId;
}
//If no access
if (!$groupPermHandler->checkRight('' . $moduleDirName . '_view', $perm_itemid, $groups, $moduleId)) {
    $xoops->redirect(XOOPS_URL . '/index.php', 3, XoopsLocaleEn_US::E_NO_ACCESS_PERMISSION);
    exit();
}
$prem_perm = '1';
if (!$groupPermHandler->checkRight('' . $moduleDirName . '_premium', $perm_itemid, $groups, $moduleId)) {
    $prem_perm = '0';
}

//include(XOOPS_ROOT_PATH . "/modules/{$moduleDirName}/include/functions.php");

$cid = Request::getInt('cid', 0, 'GET');

$xoops->header('module:alumni/alumni_category.tpl');
Xoops::getInstance()->header();
//$xoops->tpl() = $xoops->tpl();

$xoTheme->addScript(ALUMNI_URL . '/media/jquery/jquery-1.8.3.min.js');
$xoTheme->addScript(ALUMNI_URL . '/media/jquery/tablesorter-master/js/jquery.tablesorter.js');
$xoTheme->addScript(ALUMNI_URL . '/media/jquery/tablesorter-master/addons/pager/jquery.tablesorter.pager.js');
$xoTheme->addScript(ALUMNI_URL . '/media/jquery/tablesorter-master/js/jquery.tablesorter.widgets.js');
$xoTheme->addScript(ALUMNI_URL . '/media/jquery/pager-custom-controls.js');
$xoTheme->addScript(ALUMNI_URL . '/media/jquery/myjs.js');
$xoTheme->addStylesheet(ALUMNI_URL . '/media/jquery/css/theme.blue.css');
$xoTheme->addStylesheet(ALUMNI_URL . '/media/jquery/tablesorter-master/addons/pager/jquery.tablesorter.pager.css');
$xoTheme->addScript(ALUMNI_URL . '/media/jquery/photo.js');
$default_sort = $xoops->getModuleConfig('' . $moduleDirName . '_csortorder');
$listing_sort = $xoops->getModuleConfig('' . $moduleDirName . '_lsortorder');

$cid = ((int)($cid) > 0) ? (int)($cid) : 0;

$xoops->tpl()->assign('add_from', constant($mainLang . '_ADDFROM') . ' ' . $xoopsConfig['sitename']);
$xoops->tpl()->assign('add_from_title', constant($mainLang . '_ADDFROM'));
$xoops->tpl()->assign('add_from_sitename', $xoopsConfig['sitename']);
if ($xoops->isUser()) {
    $xoops->tpl()->assign('add_listing', "<a href='listing.php?op=new_listing&amp;cid=$cid'>" . constant($mainLang . '_ADDLISTING2') . '</a>');
}
$cat_banner = $xoops->getBanner();
$xoops->tpl()->assign('cat_banner', $cat_banner);

$cat_code_place = $xoops->getModuleConfig('' . $moduleDirName . '_code_place');
$useExtraCode   = $xoops->getModuleConfig('' . $moduleDirName . '_use_code');
$useBanner      = $xoops->getModuleConfig('' . $moduleDirName . '_useBanner');
$catExtraCode   = $xoops->getModuleConfig('' . $moduleDirName . '_index_code');
$xoops->tpl()->assign('useExtraCode', $useExtraCode);
$xoops->tpl()->assign('useBanner', $useBanner);
$xoops->tpl()->assign('catExtraCode', '<html>' . $catExtraCode . '</html>');
$xoops->tpl()->assign('cat_code_place', $cat_code_place);

// $alumniCategoryHandler = $xoops->getModuleHandler('Category', $moduleDirName);

$alumni   = Alumni::getInstance();
$moduleId = $xoops->module->getVar('mid');
// get permitted id
$groups      = $xoops->isUser() ? $xoops->user->getGroups() : SystemLocale::ANONYMOUS_USERS_GROUP;
$alumniIds   = $alumni->getGrouppermHandler()->getItemIds('alumni_view', $groups, $moduleId);
$catCriteria = new CriteriaCompo();
$catCriteria->add(new Criteria('cid', $cid, '='));
$catCriteria->add(new Criteria('cid', '(' . implode(', ', $alumniIds) . ')', 'IN'));
$catCriteria->setOrder('' . $xoops->getModuleConfig('' . $moduleDirName . '_csortorder') . '');
$numcat        = $categoryHandler->getCount();
$categoryArray = $categoryHandler->getAll($catCriteria);

$catObj = $categoryHandler->get($cid);

$homePath = '<a href=\'' . ALUMNI_URL . "/index.php'>" . constant($mainLang . '_MAIN') . '</a>&nbsp;:&nbsp;';
$itemPath = $catObj->getVar('title');
$path     = '';
$myParent = $catObj->getVar('pid');

$catpathCriteria = new CriteriaCompo();
$catpathCriteria->add(new Criteria('cid', $myParent, '='));
$catpathArray = $categoryHandler->getAll($catpathCriteria);
foreach (array_keys($catpathArray) as $i) {
    $mytitle = $catpathArray[$i]->getVar('title');
}

if ($myParent != 0) {
    $path = "<a href='" . ALUMNI_URL . '/categories.php?cid=' . $catpathArray[$i]->getVar('cid') . "'>" . $catpathArray[$i]->getVar('title') . '</a>&nbsp;:&nbsp;{$path}';
}
$path = "{$homePath}{$path}{$itemPath}";
$path = str_replace('&nbsp;:&nbsp;', " <img src='" . XOOPS_URL . "/modules/{$moduleDirName}/assets/images/arrow.gif" . "' style='border-width: 0px;' alt='' /> ", $path);

$xoops->tpl()->assign('category_path', $path);

unset($catCriteria);

foreach (array_keys($categoryArray) as $i) {
    $cat_id     = $categoryArray[$i]->getVar('cid');
    $cat_pid    = $categoryArray[$i]->getVar('pid');
    $title      = $categoryArray[$i]->getVar('title', 'e');
    $scaddress  = $categoryArray[$i]->getVar('scaddress');
    $scaddress2 = $categoryArray[$i]->getVar('scaddress2');
    $sccity     = $categoryArray[$i]->getVar('sccity');
    $scstate    = $categoryArray[$i]->getVar('scstate');
    $sczip      = $categoryArray[$i]->getVar('sczip');
    $scphone    = $categoryArray[$i]->getVar('scphone');
    $scfax      = $categoryArray[$i]->getVar('scfax');
    $scmotto    = $categoryArray[$i]->getVar('scmotto');
    $scurl      = $categoryArray[$i]->getVar('scurl');
    $img        = $categoryArray[$i]->getVar('img');
    $scphoto    = $categoryArray[$i]->getVar('scphoto');
    $order      = $categoryArray[$i]->getVar('ordre');

    $xoops->tpl()->assign('moderated', '');
    if ($xoops->getModuleConfig('alumni_moderated') == 1) {
        $xoops->tpl()->assign('moderated', '1');
    }
    $xoops->tpl()->assign('lang_subcat', '');
    if ($xoops->getModuleConfig('alumni_showsubcat') == 1) {
        $subcatCriteria = new CriteriaCompo();
        $subcatCriteria->add(new Criteria('pid', $cid, '='));
        $subcatCriteria->add(new Criteria('cid', '(' . implode(', ', $alumniIds) . ')', 'IN'));
        $subcatCriteria->setOrder('' . $xoops->getModuleConfig('' . $moduleDirName . '_csortorder') . '');
        $numsubcat  = $categoryHandler->getCount($subcatCriteria);
        $subcat_arr = $categoryHandler->getAll($subcatCriteria);
        unset($subcatCriteria);
        foreach (array_keys($subcat_arr) as $j) {
            $subcat_id     = $subcat_arr[$j]->getVar('cid');
            $subcat_pid    = $subcat_arr[$j]->getVar('pid');
            $sub_cat_title = $subcat_arr[$j]->getVar('title', 'e');

            //      $alumniListingHandler = $xoops->getModuleHandler('Listing', $moduleDirName);
            $listingCriteria = new CriteriaCompo();
            $listingCriteria->add(new Criteria('cid', $subcat_id, '='));
            $listingCriteria->add(new Criteria('valid', 1, '='));
            $listingCriteria->add(new Criteria('cid', '(' . implode(', ', $alumniIds) . ')', 'IN'));
            $alumni_count = $listingHandler->getCount($listingCriteria);

            $xoops->tpl()->append('subcategories', array('title' => $sub_cat_title, 'id' => $subcat_id, 'totallinks' => $alumni_count, 'count' => $numsubcat));
        }
        $xoops->tpl()->assign('showsubcat', true);
    }
    $xoops->tpl()->assign('subcats', $numsubcat);
    $school_name = $myts->htmlSpecialChars($title);
    $xoops->tpl()->assign('scaddress', $scaddress);
    $xoops->tpl()->assign('scaddress2', $scaddress2);
    $xoops->tpl()->assign('sccity', $sccity);
    $xoops->tpl()->assign('scstate', $scstate);
    $xoops->tpl()->assign('sczip', $sczip);
    $xoops->tpl()->assign('scphone', $scphone);
    $xoops->tpl()->assign('scfax', $scfax);
    $xoops->tpl()->assign('scmotto', $scmotto);
    $xoops->tpl()->assign('scurl', $scurl);
    if ($scphoto) {
        $xoops->tpl()->assign('top_scphoto', "<img src='" . XOOPS_URL . "/uploads/{$moduleDirName}/photos/school_photos/$scphoto' align='middle' alt='$school_name' />");
    }
    $xoops->tpl()->assign('head_scphone', constant($mainLang . '_SCPHONE'));
    $xoops->tpl()->assign('head_scfax', constant($mainLang . '_SCFAX'));
    $xoops->tpl()->assign('web', constant($mainLang . '_WEB'));
    $xoops->tpl()->assign('school_name', $title);
    $xoops->tpl()->assign('title', $title);
    $xoops->tpl()->assign('module_name', $xoopsModule->getVar('name'));
    $xoops->tpl()->assign('nav_subcount', '');
    $xoops->tpl()->assign('trows', '');
    $xoops->tpl()->assign('school_listings', '');
    $xoops->tpl()->assign('sub_listings', '');
    $xoops->tpl()->assign('show_nav', false);
    $xoops->tpl()->assign('no_listings', constant($mainLang . '_NO_LISTINGS'));

    // $alumniListingHandler = $xoops->getModuleHandler('Listing', $moduleDirName);
    $listingCriteria      = new CriteriaCompo();
    $listingCriteria->add(new Criteria('cid', $cid, '='));
    $listingCriteria->add(new Criteria('valid', 1, '='));
    $listingCriteria->add(new Criteria('cid', '(' . implode(', ', $alumniIds) . ')', 'IN'));
    $numrows = $listingHandler->getCount($listingCriteria);

    $listingArray = $listingHandler->getAll($listingCriteria);
    unset($listingCriteria);
    foreach (array_keys($listingArray) as $j) {
        $lid        = $listingArray[$j]->getVar('lid');
        $cid        = $listingArray[$j]->getVar('cid');
        $name       = $listingArray[$j]->getVar('name');
        $mname      = $listingArray[$j]->getVar('mname');
        $lname      = $listingArray[$j]->getVar('lname');
        $school     = $listingArray[$j]->getVar('school');
        $year       = $listingArray[$j]->getVar('year');
        $studies    = $listingArray[$j]->getVar('studies');
        $activities = $listingArray[$j]->getVar('activities');
        $extrainfo  = $listingArray[$j]->getVar('extrainfo');
        $occ        = $listingArray[$j]->getVar('occ');
        $date       = $listingArray[$j]->getVar('date');
        $email      = $listingArray[$j]->getVar('email');
        $submitter  = $listingArray[$j]->getVar('submitter');
        $usid       = $listingArray[$j]->getVar('usid');
        $town       = $listingArray[$j]->getVar('town');
        $valid      = $listingArray[$j]->getVar('valid');
        $photo      = $listingArray[$j]->getVar('photo');
        $photo2     = $listingArray[$j]->getVar('photo2');
        $view       = $listingArray[$j]->getVar('view');

        $trows = $numrows;

        $cat_sort = $xoops->getModuleConfig('' . $moduleDirName . '_csortorder');

        $xoops->tpl()->assign('xoops_pagetitle', $title);

        $xoops->tpl()->assign('nav_subcount', $trows);
        $xoops->tpl()->assign('trows', $trows);
        $xoops->tpl()->assign('title', $title);
        $xoops->tpl()->assign('lang_subcat', constant($mainLang . '_AVAILAB'));

        if ($trows > '0') {
            $xoops->tpl()->assign('last_head', constant($mainLang . '_THE') . ' ' . $xoops->getModuleConfig('' . $moduleDirName . '_newalumni') . ' ' . constant($mainLang . '_LASTADD'));
            $xoops->tpl()->assign('last_head_name', constant($mainLang . '_NAME2'));
            $xoops->tpl()->assign('last_head_mname', constant($mainLang . '_MNAME'));
            $xoops->tpl()->assign('last_head_lname', constant($mainLang . '_LNAME'));
            $xoops->tpl()->assign('last_head_school', constant($mainLang . '_SCHOOL'));
            $xoops->tpl()->assign('class_of', constant($mainLang . '_CLASSOF'));
            $xoops->tpl()->assign('last_head_studies', constant($mainLang . '_STUDIES2'));
            $xoops->tpl()->assign('last_head_occ', constant($mainLang . '_OCC'));
            $xoops->tpl()->assign('last_head_activities', constant($mainLang . '_ACTIVITIES'));
            $xoops->tpl()->assign('last_head_date', constant($mainLang . '_DATE'));
            $xoops->tpl()->assign('last_head_local', constant($mainLang . '_LOCAL2'));
            $xoops->tpl()->assign('last_head_views', constant($mainLang . '_VIEW'));
            $xoops->tpl()->assign('last_head_photo', constant($mainLang . '_PHOTO'));
            $xoops->tpl()->assign('last_head_photo2', constant($mainLang . '_PHOTO2'));
            $xoops->tpl()->assign('cat', $cid);

            $rank = 1;

            if ($trows > '1') {
                $xoops->tpl()->assign('show_nav', true);
                $xoops->tpl()->assign('lang_sortby', constant($mainLang . '_SORTBY'));
                $xoops->tpl()->assign('lang_name', constant($mainLang . '_NAME2'));
                $xoops->tpl()->assign('lang_nameatoz', constant($mainLang . '_NAMEATOZ'));
                $xoops->tpl()->assign('lang_nameztoa', constant($mainLang . '_NAMEZTOA'));
                $xoops->tpl()->assign('lang_schoolatoz', constant($mainLang . '_SCHOOLATOZ'));
                $xoops->tpl()->assign('lang_schoolztoa', constant($mainLang . '_SCHOOLZTOA'));
                $xoops->tpl()->assign('lang_yearold', constant($mainLang . '_YEAROLD'));
                $xoops->tpl()->assign('lang_yearnew', constant($mainLang . '_YEARNEW'));
                $xoops->tpl()->assign('lang_date', constant($mainLang . '_DATE'));
                $xoops->tpl()->assign('lang_dateold', constant($mainLang . '_DATEOLD'));
                $xoops->tpl()->assign('lang_datenew', constant($mainLang . '_DATENEW'));
            }

            $a_item     = array();
            $name       = $myts->undoHtmlSpecialChars($name);
            $mname      = $myts->undoHtmlSpecialChars($mname);
            $lname      = $myts->undoHtmlSpecialChars($lname);
            $school     = $myts->undoHtmlSpecialChars($school);
            $year       = $myts->htmlSpecialChars($year);
            $studies    = $myts->htmlSpecialChars($studies);
            $activities = $myts->htmlSpecialChars($activities);
            $occ        = $myts->htmlSpecialChars($occ);
            $town       = $myts->undoHtmlSpecialChars($town);

            $useroffset    = '';
            $a_item['new'] = '';

            $newcount  = $xoops->getModuleConfig('' . $moduleDirName . '_countday');
            $startdate = (time() - (86400 * $newcount));
            if ($startdate < $date) {
                $newitem       = "<img src=\"" . XOOPS_URL . "/modules/{$moduleDirName}/assets/images/newred.gif\" />";
                $a_item['new'] = $newitem;
            }
            if ($xoops->user) {
                $timezone = $xoops->user->timezone();
                if (null !== $timezone) {
                    $useroffset = $xoops->user->timezone();
                } else {
                    $useroffset = $xoopsConfig['default_TZ'];
                }
            }
            $date = ($useroffset * 3600) + $date;
            $date = XoopsLocale::formatTimestamp($date, 's');
            if ($xoops->user && $xoops->user->isAdmin()) {
                    $a_item['admin'] = "<a href='admin/alumni.php?op=edit_listing&amp;lid=$lid'><img src='assets/images/modif.gif' border=0 alt=\"" . constant($mainLang . '_MODADMIN') . "\" /></a>";
            }

            $a_item['name']       = "<a href='listing.php?lid=$lid'><b>$name&nbsp;$mname&nbsp;$lname</b></a>";
            $a_item['school']     = $school;
            $a_item['year']       = $year;
            $a_item['studies']    = $studies;
            $a_item['occ']        = $occ;
            $a_item['activities'] = $activities;
            $a_item['date']       = $date;
            $a_item['local']      = '';
            if ($town) {
                $a_item['local'] .= $town;
            }
            $cat = addslashes($cid);
            if ($photo) {
                $a_item['photo'] = "<a href=\"javascript:CLA('display-image.php?lid=$lid')\"><img src=\"assets/images/photo.gif\" border=\"0\" width=\"15\" height=\"11\" alt='" . constant($mainLang . '_IMGPISP') . "' /></a>";
            }

            if ($photo2) {
                $a_item['photo2'] = "<a href=\"javascript:CLA('display-image2.php?lid=$lid')\"><img src=\"assets/images/photo.gif\" border=\"0\" width=\"15\" height=\"11\" alt='" . constant($mainLang . '_IMGPISP') . "' /></a>";
            }

            $a_item['views'] = $view;
            ++$rank;
            $xoops->tpl()->append('items', $a_item);
        } else {
            $xoops->tpl()->assign('no_listings', constant($mainLang . '_NO_LISTINGS'));
        }
    }
}

Xoops::getInstance()->footer();
