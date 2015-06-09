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
include __DIR__ . '/header.php';

$moduleDirName = basename(__DIR__);
$main_lang     = '_MA_' . strtoupper($moduleDirName);
require_once(XOOPS_ROOT_PATH . "/modules/{$moduleDirName}/include/gtickets.php");
$myts      = MyTextSanitizer::getInstance();
$xoops     = Xoops::getInstance();
$alumni    = Alumni::getInstance();
$module_id = $xoopsModule->getVar('mid');

if (is_object($xoopsUser)) {
    $groups = $xoopsUser->getGroups();
} else {
    $groups = XOOPS_GROUP_ANONYMOUS;
}
$groupPermHandler = $xoops->getHandler('groupperm');
if (isset($_POST['item_id'])) {
    $perm_itemid = (int)($_POST['item_id']);
} else {
    $perm_itemid = 0;
}
//If no access
if (!$groupPermHandler->checkRight('' . $moduleDirName . '_view', $perm_itemid, $groups, $module_id)) {
    $xoops->redirect(XOOPS_URL . '/index.php', 3, _NOPERM);
    exit();
}
if (!$groupPermHandler->checkRight('' . $moduleDirName . '_premium', $perm_itemid, $groups, $module_id)) {
    $prem_perm = '0';
} else {
    $prem_perm = '1';
}

include(XOOPS_ROOT_PATH . "/modules/{$moduleDirName}/include/functions.php");

$cid = (int)($_GET['cid']);

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

$xoops->tpl()->assign('add_from', constant($main_lang . '_ADDFROM') . ' ' . $xoopsConfig['sitename']);
$xoops->tpl()->assign('add_from_title', constant($main_lang . '_ADDFROM'));
$xoops->tpl()->assign('add_from_sitename', $xoopsConfig['sitename']);
if ($xoops->isUser()) {
    $xoops->tpl()->assign('add_listing', "<a href='listing.php?op=new_listing&amp;cid=$cid'>" . constant($main_lang . '_ADDLISTING2') . '</a>');
}
$cat_banner = $xoops->getbanner();
$xoops->tpl()->assign('cat_banner', $cat_banner);

$cat_code_place = $xoops->getModuleConfig('' . $moduleDirName . '_code_place');
$use_extra_code = $xoops->getModuleConfig('' . $moduleDirName . '_use_code');
$use_banner     = $xoops->getModuleConfig('' . $moduleDirName . '_use_banner');
$cat_extra_code = $xoops->getModuleConfig('' . $moduleDirName . '_index_code');
$xoops->tpl()->assign('use_extra_code', $use_extra_code);
$xoops->tpl()->assign('use_banner', $use_banner);
$xoops->tpl()->assign('cat_extra_code', '<html>' . $cat_extra_code . '</html>');
$xoops->tpl()->assign('cat_code_place', $cat_code_place);

$alumniCategoriesHandler = $xoops->getModuleHandler('alumni_categories', 'alumni');

$alumni    = Alumni::getInstance();
$module_id = $xoops->module->getVar('mid');
// get permitted id
$groups       = $xoops->isUser() ? $xoops->user->getGroups() : XOOPS_GROUP_ANONYMOUS;
$alumni_ids   = $alumni->getGrouppermHandler()->getItemIds('alumni_view', $groups, $module_id);
$cat_criteria = new CriteriaCompo();
$cat_criteria->add(new Criteria('cid', $cid, '='));
$cat_criteria->add(new Criteria('cid', '(' . implode(', ', $alumni_ids) . ')', 'IN'));
$cat_criteria->setOrder('' . $xoops->getModuleConfig('' . $moduleDirName . '_csortorder') . '');
$numcat       = $alumniCategoriesHandler->getCount();
$category_arr = $alumniCategoriesHandler->getAll($cat_criteria);

$catObj = $alumniCategoriesHandler->get($cid);

$homePath = "<a href='" . ALUMNI_URL . "/index.php'>" . constant($main_lang . '_MAIN') . '</a>&nbsp;:&nbsp;';
$itemPath = $catObj->getVar('title');
$path     = '';
$myParent = $catObj->getVar('pid');

$catpath_criteria = new CriteriaCompo();
$catpath_criteria->add(new Criteria('cid', $myParent, '='));
$catpath_arr = $alumniCategoriesHandler->getAll($catpath_criteria);
foreach (array_keys($catpath_arr) as $i) {

    $mytitle = $catpath_arr[$i]->getVar('title');

}

if ($myParent != 0) {

    $path = "<a href='" . ALUMNI_URL . '/categories.php?cid=' . $catpath_arr[$i]->getVar('cid') . "'>" . $catpath_arr[$i]->getVar('title') . '</a>&nbsp;:&nbsp;{$path}';
}
$path = "{$homePath}{$path}{$itemPath}";
$path = str_replace('&nbsp;:&nbsp;', " <img src='" . XOOPS_URL . "/modules/{$moduleDirName}/assets/images/arrow.gif" . "' style='border-width: 0px;' alt='' /> ", $path);

$xoops->tpl()->assign('category_path', $path);

unset($cat_criteria);

foreach (array_keys($category_arr) as $i) {
    $cat_id     = $category_arr[$i]->getVar('cid');
    $cat_pid    = $category_arr[$i]->getVar('pid');
    $title      = $category_arr[$i]->getVar('title', 'e');
    $scaddress  = $category_arr[$i]->getVar('scaddress');
    $scaddress2 = $category_arr[$i]->getVar('scaddress2');
    $sccity     = $category_arr[$i]->getVar('sccity');
    $scstate    = $category_arr[$i]->getVar('scstate');
    $sczip      = $category_arr[$i]->getVar('sczip');
    $scphone    = $category_arr[$i]->getVar('scphone');
    $scfax      = $category_arr[$i]->getVar('scfax');
    $scmotto    = $category_arr[$i]->getVar('scmotto');
    $scurl      = $category_arr[$i]->getVar('scurl');
    $img        = $category_arr[$i]->getVar('img');
    $scphoto    = $category_arr[$i]->getVar('scphoto');
    $order      = $category_arr[$i]->getVar('ordre');

    $xoops->tpl()->assign('moderated', '');
    if ($xoops->getModuleConfig('alumni_moderated') == 1) {
        $xoops->tpl()->assign('moderated', '1');
    }
    $xoops->tpl()->assign('lang_subcat', '');
    if ($xoops->getModuleConfig('alumni_showsubcat') == 1) {

        $subcat_criteria = new CriteriaCompo();
        $subcat_criteria->add(new Criteria('pid', $cid, '='));
        $subcat_criteria->add(new Criteria('cid', '(' . implode(', ', $alumni_ids) . ')', 'IN'));
        $subcat_criteria->setOrder('' . $xoops->getModuleConfig('' . $moduleDirName . '_csortorder') . '');
        $numsubcat  = $alumniCategoriesHandler->getCount($subcat_criteria);
        $subcat_arr = $alumniCategoriesHandler->getAll($subcat_criteria);
        unset($subcat_criteria);
        foreach (array_keys($subcat_arr) as $i) {
            $subcat_id     = $subcat_arr[$i]->getVar('cid');
            $subcat_pid    = $subcat_arr[$i]->getVar('pid');
            $sub_cat_title = $subcat_arr[$i]->getVar('title', 'e');

            //      $alumniListingHandler = $xoops->getModuleHandler('alumni_listing', 'alumni');
            $listing_criteria = new CriteriaCompo();
            $listing_criteria->add(new Criteria('cid', $subcat_id, '='));
            $listing_criteria->add(new Criteria('valid', 1, '='));
            $listing_criteria->add(new Criteria('cid', '(' . implode(', ', $alumni_ids) . ')', 'IN'));
            $alumni_count = $alumniListingHandler->getCount($listing_criteria);

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
    $xoops->tpl()->assign('top_scphoto', "<img src='" . XOOPS_URL . "/modules/{$moduleDirName}/photos/school_photos/$scphoto' align='middle' alt='$school_name' />");
    $xoops->tpl()->assign('head_scphone', constant($main_lang . '_SCPHONE'));
    $xoops->tpl()->assign('head_scfax', constant($main_lang . '_SCFAX'));
    $xoops->tpl()->assign('web', constant($main_lang . '_WEB'));
    $xoops->tpl()->assign('school_name', $title);
    $xoops->tpl()->assign('title', $title);
    $xoops->tpl()->assign('module_name', $xoopsModule->getVar('name'));
    $xoops->tpl()->assign('nav_subcount', '');
    $xoops->tpl()->assign('trows', '');
    $xoops->tpl()->assign('school_listings', '');
    $xoops->tpl()->assign('sub_listings', '');
    $xoops->tpl()->assign('show_nav', false);
    $xoops->tpl()->assign('no_listings', constant($main_lang . '_NO_LISTINGS'));

    $alumniListingHandler = $xoops->getModuleHandler('alumni_listing', 'alumni');
    $listing_criteria     = new CriteriaCompo();
    $listing_criteria->add(new Criteria('cid', $cid, '='));
    $listing_criteria->add(new Criteria('valid', 1, '='));
    $listing_criteria->add(new Criteria('cid', '(' . implode(', ', $alumni_ids) . ')', 'IN'));
    $numrows = $alumniListingHandler->getCount($listing_criteria);

    $listing_arr = $alumniListingHandler->getAll($listing_criteria);
    unset($listing_criteria);
    foreach (array_keys($listing_arr) as $i) {
        $lid        = $listing_arr[$i]->getVar('lid');
        $cid        = $listing_arr[$i]->getVar('cid');
        $name       = $listing_arr[$i]->getVar('name');
        $mname      = $listing_arr[$i]->getVar('mname');
        $lname      = $listing_arr[$i]->getVar('lname');
        $school     = $listing_arr[$i]->getVar('school');
        $year       = $listing_arr[$i]->getVar('year');
        $studies    = $listing_arr[$i]->getVar('studies');
        $activities = $listing_arr[$i]->getVar('activities');
        $extrainfo  = $listing_arr[$i]->getVar('extrainfo');
        $occ        = $listing_arr[$i]->getVar('occ');
        $date       = $listing_arr[$i]->getVar('date');
        $email      = $listing_arr[$i]->getVar('email');
        $submitter  = $listing_arr[$i]->getVar('submitter');
        $usid       = $listing_arr[$i]->getVar('usid');
        $town       = $listing_arr[$i]->getVar('town');
        $valid      = $listing_arr[$i]->getVar('valid');
        $photo      = $listing_arr[$i]->getVar('photo');
        $photo2     = $listing_arr[$i]->getVar('photo2');
        $view       = $listing_arr[$i]->getVar('view');

        $trows = $numrows;

        $cat_sort = $xoops->getModuleConfig('' . $moduleDirName . '_csortorder');

        $xoops->tpl()->assign('xoops_pagetitle', $title);

        $xoops->tpl()->assign('nav_subcount', $trows);
        $xoops->tpl()->assign('trows', $trows);
        $xoops->tpl()->assign('title', $title);
        $xoops->tpl()->assign('lang_subcat', constant($main_lang . '_AVAILAB'));

        if ($trows > '0') {

            $xoops->tpl()->assign('last_head', constant($main_lang . '_THE') . ' ' . $xoops->getModuleConfig('' . $moduleDirName . '_newalumni') . ' ' . constant($main_lang . '_LASTADD'));
            $xoops->tpl()->assign('last_head_name', constant($main_lang . '_NAME2'));
            $xoops->tpl()->assign('last_head_mname', constant($main_lang . '_MNAME'));
            $xoops->tpl()->assign('last_head_lname', constant($main_lang . '_LNAME'));
            $xoops->tpl()->assign('last_head_school', constant($main_lang . '_SCHOOL'));
            $xoops->tpl()->assign('class_of', constant($main_lang . '_CLASSOF'));
            $xoops->tpl()->assign('last_head_studies', constant($main_lang . '_STUDIES2'));
            $xoops->tpl()->assign('last_head_occ', constant($main_lang . '_OCC'));
            $xoops->tpl()->assign('last_head_activities', constant($main_lang . '_ACTIVITIES'));
            $xoops->tpl()->assign('last_head_date', constant($main_lang . '_DATE'));
            $xoops->tpl()->assign('last_head_local', constant($main_lang . '_LOCAL2'));
            $xoops->tpl()->assign('last_head_views', constant($main_lang . '_VIEW'));
            $xoops->tpl()->assign('last_head_photo', constant($main_lang . '_PHOTO'));
            $xoops->tpl()->assign('last_head_photo2', constant($main_lang . '_PHOTO2'));
            $xoops->tpl()->assign('cat', $cid);

            $rank = 1;

            if ($trows > "1") {

                $xoops->tpl()->assign('show_nav', true);
                $xoops->tpl()->assign('lang_sortby', constant($main_lang . '_SORTBY'));
                $xoops->tpl()->assign('lang_name', constant($main_lang . '_NAME2'));
                $xoops->tpl()->assign('lang_nameatoz', constant($main_lang . '_NAMEATOZ'));
                $xoops->tpl()->assign('lang_nameztoa', constant($main_lang . '_NAMEZTOA'));
                $xoops->tpl()->assign('lang_schoolatoz', constant($main_lang . '_SCHOOLATOZ'));
                $xoops->tpl()->assign('lang_schoolztoa', constant($main_lang . '_SCHOOLZTOA'));
                $xoops->tpl()->assign('lang_yearold', constant($main_lang . '_YEAROLD'));
                $xoops->tpl()->assign('lang_yearnew', constant($main_lang . '_YEARNEW'));
                $xoops->tpl()->assign('lang_date', constant($main_lang . '_DATE'));
                $xoops->tpl()->assign('lang_dateold', constant($main_lang . '_DATEOLD'));
                $xoops->tpl()->assign('lang_datenew', constant($main_lang . '_DATENEW'));
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
            if ($xoopsUser) {
                $timezone = $xoopsUser->timezone();
                if (isset($timezone)) {
                    $useroffset = $xoopsUser->timezone();
                } else {
                    $useroffset = $xoopsConfig['default_TZ'];
                }
            }
            $date = ($useroffset * 3600) + $date;
            $date = XoopsLocale::formatTimestamp($date, 's');
            if ($xoopsUser) {
                if ($xoopsUser->isAdmin()) {
                    $a_item['admin'] = "<a href='admin/alumni.php?op=edit_listing&amp;lid=$lid'><img src='assets/images/modif.gif' border=0 alt=\"" . constant($main_lang . '_MODADMIN') . "\" /></a>";
                }
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
                $a_item['photo'] = "<a href=\"javascript:CLA('display-image.php?lid=$lid')\"><img src=\"assets/images/photo.gif\" border=\"0\" width=\"15\" height=\"11\" alt='" . constant($main_lang . '_IMGPISP') . "' /></a>";
            }

            if ($photo2) {
                $a_item['photo2'] = "<a href=\"javascript:CLA('display-image2.php?lid=$lid')\"><img src=\"assets/images/photo.gif\" border=\"0\" width=\"15\" height=\"11\" alt='" . constant($main_lang . '_IMGPISP') . "' /></a>";
            }

            $a_item['views'] = $view;
            $rank++;
            $xoops->tpl()->append('items', $a_item);
        } else {
            $xoops->tpl()->assign('no_listings', constant($main_lang . '_NO_LISTINGS'));
        }
    }
}

Xoops::getInstance()->footer();
