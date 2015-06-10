<?php
//  -----------------------------------------------------------------------  //
//                           Alumni for Xoops 2.6.0                          //
//                            By John Mordo - jlm69                          //
//                             Licence Type   : GPL                          //
// ------------------------------------------------------------------------- //

use Xoops\Core\Request;

include __DIR__ . '/header.php';

$moduleDirName = basename(__DIR__);
$mainLang      = '_MA_' . strtoupper($moduleDirName);
require_once(XOOPS_ROOT_PATH . "/modules/{$moduleDirName}/include/gtickets.php");
$myts     = MyTextSanitizer::getInstance();
$xoops    = Xoops::getInstance();
$moduleId = $xoops->module->getVar('mid');

if (is_object($xoops->user)) {
    $groups = $xoops->user->getGroups();
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
if (!$groupPermHandler->checkRight('' . $moduleDirName . '_view', $perm_itemid, $groups, $moduleId)) {
    $xoops->redirect(XOOPS_URL . '/index.php', 3, _NOPERM);
    exit();
}
if (!$groupPermHandler->checkRight('' . $moduleDirName . '_premium', $perm_itemid, $groups, $moduleId)) {
    $prem_perm = '0';
} else {
    $prem_perm = '1';
}

include(XOOPS_ROOT_PATH . "/modules/{$moduleDirName}/include/functions.php");
include(XOOPS_ROOT_PATH . '/class/pagenav.php');
$xoops->header('module:alumni/alumni_index.tpl');
Xoops::getInstance()->header();
//$xoops->tpl() = $xoops->tpl();
$xoops->tpl()->assign('xmid', $xoopsModule->getVar('mid'));
$xoops->tpl()->assign('add_from', constant($mainLang . '_ADDFROM') . ' ' . $xoopsConfig['sitename']);
$xoops->tpl()->assign('add_from_title', constant($mainLang . '_ADDFROM'));
$xoops->tpl()->assign('add_from_sitename', $xoopsConfig['sitename']);
$xoops->tpl()->assign('add_from_title', constant($mainLang . '_ADDFROM'));
$xoops->tpl()->assign('class_of', constant($mainLang . '_CLASSOF'));
$xoops->tpl()->assign('front_intro', constant($mainLang . '_FINTRO'));

if ($xoops->getModuleConfig('' . $moduleDirName . '_offer_search') == '1') {
    $xoops->tpl()->assign('offer_search', true);
    $xoops->tpl()->assign('search_listings', constant($mainLang . '_SEARCH_LISTINGS'));
    $xoops->tpl()->assign('match', constant($mainLang . '_MATCH'));
    $xoops->tpl()->assign('all_words', constant($mainLang . '_ALL_WORDS'));
    $xoops->tpl()->assign('any_words', constant($mainLang . '_ANY_WORDS'));
    $xoops->tpl()->assign('exact_match', constant($mainLang . '_EXACT_MATCH'));
    $xoops->tpl()->assign('byyear', constant($mainLang . '_SEARCH_BYYEAR'));
    $xoops->tpl()->assign('bycategory', constant($mainLang . '_BYCATEGORY'));
    $xoops->tpl()->assign('keywords', constant($mainLang . '_SEARCH_KEYWORDS'));
    $xoops->tpl()->assign('search', constant($mainLang . '_SEARCH'));

    $alumniCategoriesHandler = $xoops->getModuleHandler('alumni_categories', 'alumni');

    $alumni   = Alumni::getInstance();
    $moduleId = $xoops->module->getVar('mid');

    // get permitted id
    $groups      = $xoops->isUser() ? $xoops->user->getGroups() : XOOPS_GROUP_ANONYMOUS;
    $alumniIds   = $alumni->getGrouppermHandler()->getItemIds('alumni_view', $groups, $moduleId);
    $catCriteria = new CriteriaCompo();
    $catCriteria->add(new Criteria('cid', '(' . implode(', ', $alumniIds) . ')', 'IN'));
    $catCriteria->setOrder('' . $xoops->getModuleConfig('' . $moduleDirName . '_csortorder') . '');
    $numcat        = $alumniCategoriesHandler->getCount();
    $categoryArray = $alumniCategoriesHandler->getAll($catCriteria);
    unset($catCriteria);

    foreach (array_keys($categoryArray) as $i) {
        $cid      = $categoryArray[$i]->getVar('cid');
        $pid      = $categoryArray[$i]->getVar('pid');
        $title    = $categoryArray[$i]->getVar('title', 'e');
        $img      = $categoryArray[$i]->getVar('img');
        $order    = $categoryArray[$i]->getVar('ordre');
        $affprice = $categoryArray[$i]->getVar('affprice');
        $title    = $myts->htmlSpecialChars($title);
        $xoops->tpl()->assign('title', $title);
    }

    include_once(XOOPS_ROOT_PATH . "/modules/{$moduleDirName}/class/alumni_tree.php");
    $cattree = new AlumniObjectTree($categoryArray, 'cid', 'pid');

    $categories     = $alumni->getCategoryHandler()->getCategoriesForSearch();
    $by_cat         = Request::getInt('by_cat', 0, 'POST');
    $selectCategory = "<select name=\"by_cat\">";
    $selectCategory .= "<option value=\"all\"";
    if (empty($by_cat) || count($by_cat) == 0) {
        $selectCategory .= "selected=\"selected\"";
    }
    $selectCategory .= ">" . XoopsLocale::ALL . "</option>";
    foreach ($categories as $cid => $title) {
        $selectCategory .= "<option value=\"" . $cid . "\"";
        if ($cid = $by_cat) {
            $selectCategory .= "selected=\"selected\"";
        }
        $selectCategory .= ">" . $title . "</option>";
    }
    $selectCategory .= "</select>";
    $xoops->tpl()->assign('category_select', $selectCategory);
}

$index_banner = $xoops->getbanner();
$xoops->tpl()->assign('index_banner', $index_banner);
$indexCodePlace = $xoops->getModuleConfig('' . $moduleDirName . '_code_place');
$useExtraCode   = $xoops->getModuleConfig('' . $moduleDirName . '_use_code');
$useBanner      = $xoops->getModuleConfig('' . $moduleDirName . '_useBanner');
$indexExtraCode = $xoops->getModuleConfig('' . $moduleDirName . '_index_code');
$xoops->tpl()->assign('useExtraCode', $useExtraCode);
$xoops->tpl()->assign('useBanner', $useBanner);
$xoops->tpl()->assign('indexExtraCode', '<html>' . $indexExtraCode . '</html>');
$xoops->tpl()->assign('indexCodePlace', $indexCodePlace);

$xoops->tpl()->assign('moduleDirName', $moduleDirName);

$cats  = $cattree->alumni_getFirstChild(0, $alumniIds);
$count = 0;

foreach (array_keys($cats) as $i) {
    if (in_array($cats[$i]->getVar('cid'), $alumniIds)) {
        $alumniListingHandler = $xoops->getModuleHandler('alumni_listing', 'alumni');
        $count_criteria       = new CriteriaCompo();
        $count_criteria->add(new Criteria('cid', $cats[$i]->getVar('cid'), '='));
        $count_criteria->add(new Criteria('valid', 1, '='));
        $count_criteria->add(new Criteria('cid', '(' . implode(', ', $alumniIds) . ')', 'IN'));
        $listings = $alumniListingHandler->getCount($count_criteria);

        $publishdate = isset($listings['date'][$cats[$i]->getVar('cid')]) ? $listings['date'][$cats[$i]->getVar('cid')] : 0;
        $all_subcats = $cattree->alumni_getAllChild($cats[$i]->getVar('cid'));
        if (count($all_subcats) > 0) {
            foreach (array_keys($all_subcats) as $k) {
                if (in_array($all_subcats[$k]->getVar('cid'), $alumniIds)) {
                    $publishdate = (isset($listings['date'][$all_subcats[$k]->getVar('cid')]) and $listings['date'][$all_subcats[$k]->getVar('cid')] > $publishdate) ? $listings['date'][$all_subcats[$k]->getVar('cid')] : $publishdate;
                }
            }
        }

        $cat_img = $cats[$i]->getVar('img');
        if ($cat_img != 'http://') {
            $cat_img = XOOPS_URL . "/modules/{$moduleDirName}/assets/images/cat/$cat_img";
        } else {
            $cat_img = '';
        }
    }
    $subcategories = array();

    $count++;

    $alumniListingHandler = $xoops->getModuleHandler('alumni_listing', 'alumni');
    $listingCriteria      = new CriteriaCompo();
    $listingCriteria->add(new Criteria('cid', $cats[$i]->getVar('cid'), '='));
    $listingCriteria->add(new Criteria('valid', 1, '='));
    $listingCriteria->add(new Criteria('cid', '(' . implode(', ', $alumniIds) . ')', 'IN'));
    $alumni_count = $alumniListingHandler->getCount($listingCriteria);

    if (count($all_subcats) > 0) {
        foreach (array_keys($all_subcats) as $k) {
            if (in_array($all_subcats[$k]->getVar('cid'), $alumniIds)) {
                $alumniListingHandler = $xoops->getModuleHandler('alumni_listing', 'alumni');
                $sub_count_criteria   = new CriteriaCompo();
                $sub_count_criteria->add(new Criteria('cid', $all_subcats[$k]->getVar('cid'), '='));
                $sub_count_criteria->add(new Criteria('valid', 1, '='));
                $sub_count_criteria->add(new Criteria('cid', '(' . implode(', ', $alumniIds) . ')', 'IN'));
                $alumni_subcount = $alumniListingHandler->getCount($sub_count_criteria);

                if ($xoops->getModuleConfig('alumni_showsubcat') == 1 and $all_subcats[$k]->getVar('pid') == $cats[$i]->getVar('cid')) { // if we are collecting subcat info for displaying, and this subcat is a first level child...
                    $subcategories[] = array('id' => $all_subcats[$k]->getVar('cid'), 'title' => $all_subcats[$k]->getVar('title'), 'count' => $alumni_subcount);
                }
            }
        }
    }

    if ($xoops->getModuleConfig('alumni_showsubcat') != 1) {
        unset($subcategories);

        $xoops->tpl()->append('categories', array(
            'image'     => $cat_img,
            'id'        => (int)($cats[$i]->getVar('cid')),
            'title'     => $cats[$i]->getVar('title'),
            'totalcats' => (int)($alumni_count),
            'count'     => (int)($count)));
    } else {
        $xoops->tpl()->append('categories', array(
            'image'         => $cat_img,
            'id'            => (int)($cats[$i]->getVar('cid')),
            'title'         => $cats[$i]->getVar('title'),
            'subcategories' => $subcategories,
            'totalcats'     => (int)($alumni_count),
            'count'         => (int)($count)));
    }
}
$xoops->tpl()->assign('total_confirm', '');
$xoops->tpl()->assign('cat_count', $count - 1);

$alumniListingHandler = $xoops->getModuleHandler('alumni_listing', 'alumni');

$xoops->tpl()->assign('moderated', false);
if ($xoops->getModuleConfig('' . $moduleDirName . '_moderated') == '1') {
    $xoops->tpl()->assign('moderated', true);
    $moderateCriteria = new CriteriaCompo();
    $moderateCriteria->add(new Criteria('valid', 0, '='));
    $moderateCriteria->add(new Criteria('cid', '(' . implode(', ', $alumniIds) . ')', 'IN'));
    $moderate_rows = $alumniListingHandler->getCount($moderateCriteria);
    $moderate_arr  = $listingHandler->getAll($moderateCriteria);

    if ($xoops->isUser()) {
        if ($xoops->user->isAdmin()) {
            $xoops->tpl()->assign('user_admin', true);

            $xoops->tpl()->assign('admin_block', constant($mainLang . '_ADMINCADRE'));
            if ($moderate_rows == 0) {
                $xoops->tpl()->assign('confirm_ads', constant($mainLang . '_NO_ALUM'));
            } else {
                $xoops->tpl()->assign('confirm_ads', constant($mainLang . '_THEREIS') . ' $moderate_rows  ' . constant($mainLang . '_WAIT') . "<br /><a href=\"admin/alumni.php?op=list_moderated\">" . constant($mainLang . '_SEEIT') . "</a>");
                $xoops->tpl()->assign('total_confirm', constant($mainLang . '_AND') . ' $moderate_rows ' . constant($mainLang . '_WAIT3'));
            }
        }
    }
}

$criteria = new CriteriaCompo();
$criteria->add(new Criteria('valid', 1, '='));
$criteria->add(new Criteria('cid', '(' . implode(', ', $alumniIds) . ')', 'IN'));
$criteria->setLimit($xoops->getModuleConfig('' . $moduleDirName . '_per_page'));
$numrows = $alumniListingHandler->getCount($criteria);

$xoops->tpl()->assign('total_listings', constant($mainLang . '_ACTUALY') . ' $numrows ' . constant($mainLang . '_LISTINGS') . ' ' . constant($mainLang . '_INCAT') . ' $numcat ' . constant($mainLang . '_CAT2'));

$xoops->tpl()->assign('last_head', constant($mainLang . '_THE') . ' ' . $xoops->getModuleConfig('' . $moduleDirName . '_newalumni') . ' ' . constant($mainLang . '_LASTADD'));
$xoops->tpl()->assign('last_head_name', constant($mainLang . '_NAME2'));
$xoops->tpl()->assign('last_head_school', constant($mainLang . '_SCHOOL2'));
$xoops->tpl()->assign('last_head_studies', constant($mainLang . '_STUDIES'));
$xoops->tpl()->assign('last_head_year', constant($mainLang . '_YEAR'));
$xoops->tpl()->assign('last_head_date', constant($mainLang . '_DATE'));
$xoops->tpl()->assign('last_head_local', constant($mainLang . '_LOCAL2'));
$xoops->tpl()->assign('last_head_views', constant($mainLang . '_VIEW'));
$xoops->tpl()->assign('last_head_photo', constant($mainLang . '_PHOTO'));
$xoops->tpl()->assign('last_head_photo2', constant($mainLang . '_PHOTO2'));

$listingArray = $listingHandler->getAll($criteria);

foreach (array_keys($listingArray) as $i) {
    $lid        = $listingArray[$i]->getVar('lid');
    $cid        = $listingArray[$i]->getVar('cid');
    $name       = $listingArray[$i]->getVar('name');
    $mname      = $listingArray[$i]->getVar('mname');
    $lname      = $listingArray[$i]->getVar('lname');
    $school     = $listingArray[$i]->getVar('school');
    $year       = $listingArray[$i]->getVar('year');
    $studies    = $listingArray[$i]->getVar('studies');
    $activities = $listingArray[$i]->getVar('activities');
    $extrainfo  = $listingArray[$i]->getVar('extrainfo');
    $occ        = $listingArray[$i]->getVar('occ');
    $date       = $listingArray[$i]->getVar('date');
    $date       = XoopsLocale::formatTimestamp($date, 's');
    $email      = $listingArray[$i]->getVar('email');
    $submitter  = $listingArray[$i]->getVar('submitter');
    $usid       = $listingArray[$i]->getVar('usid');
    $town       = $listingArray[$i]->getVar('town');
    $valid      = $listingArray[$i]->getVar('valid');
    $photo      = $listingArray[$i]->getVar('photo');
    $photo2     = $listingArray[$i]->getVar('photo2');
    $view       = $listingArray[$i]->getVar('view');

    $rank = 1;

    $a_item        = array();
    $a_item['new'] = '';

    $newcount  = $xoops->getModuleConfig('' . $moduleDirName . '_countday');
    $startdate = (time() - (86400 * $newcount));
    if ($startdate < $date) {
        $newitem       = "<img src=\"" . XOOPS_URL . "/modules/{$moduleDirName}/assets/images/newred.gif\" />";
        $a_item['new'] = $newitem;
    }

    $useroffset = '';
    if ($xoops->user) {
        $timezone = $xoops->user->timezone();
        if (isset($timezone)) {
            $useroffset = $xoops->user->timezone();
        } else {
            $useroffset = $xoopsConfig['default_TZ'];
        }
    }
    $date = ($useroffset * 3600) + $date;
    if ($xoops->user) {
        if ($xoops->user->isAdmin()) {
            $a_item['admin'] = "<a href='admin/alumni.php?op=edit_listing&amp;lid=$lid'><img src='assets/images/modif.gif' border=0 alt=\"" . constant($mainLang . '_MODADMIN') . "\" /></a>";
        }
    }

    $a_item['name']    = "<a href='listing.php?lid=$lid'><b>$name&nbsp;$mname&nbsp;$lname</b></a>";
    $a_item['school']  = $school;
    $a_item['year']    = $year;
    $a_item['studies'] = $studies;
    $a_item['date']    = $date;
    $a_item['local']   = '';
    if ($town) {
        $a_item['local'] .= $town;
    }

    if ($photo) {
        $a_item['photo'] = "<a href=\"javascript:CLA('display-image.php?lid=$lid')\"><img src=\"" . XOOPS_URL . "/modules/{$moduleDirName}/assets/images/photo.gif\" border=\"0\" width=\"15\" height=\"11\" alt='" . constant($mainLang . '_IMGPISP') . "' /></a>";
    }
    if ($photo2) {
        $a_item['photo2'] = "<a href=\"javascript:CLA('display-image2.php?lid=$lid')\"><img src=\"assets/images/photo.gif\" border=\"0\" width=\"15\" height=\"11\" alt='" . constant($mainLang . '_IMGPISP') . "' /></a>";
    }

    $a_item['views'] = $view;

    $rank++;
    $xoops->tpl()->append('items', $a_item);
}

Xoops::getInstance()->footer();
