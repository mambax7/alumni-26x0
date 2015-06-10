<?php
//  -----------------------------------------------------------------------  //
//                           Alumni for Xoops 2.3.x                          //
//                  By John Mordo from the myAds 2.04 Module                 //
//                    All Original credits left below this                   //
//                                                                           //
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

$moduleDirName = basename(dirname(__DIR__));
$xoops         = Xoops::getInstance();
require_once(XOOPS_ROOT_PATH . "/modules/{$moduleDirName}/include/gtickets.php");
include_once(XOOPS_ROOT_PATH . "/modules/{$moduleDirName}/include/functions.php");

$alumni = Alumni::getInstance();

$myts    = MyTextSanitizer::getInstance();
$by_cat  = Request::getInt('by_cat', '');
$andor   = Request::getString('query', 'OR');
$queries = array();
$query   = Request::getString('query', '');
$start   = Request::getString('start', '0');

function alumni_search($queries, $andor, $limit, $start, $userid, $by_cat)
{
    global $by_cat, $xoops, $query;

    $alumni         = Alumni::getInstance();
    $module_id      = $xoops->module->getVar('mid');
    $listingHandler = $xoops->getModuleHandler('alumni_listing', 'alumni');
    $groups         = $xoops->isUser() ? $xoops->user->getGroups() : XOOPS_GROUP_ANONYMOUS;
    $alumni_ids     = $alumni->getGrouppermHandler()->getItemIds('alumni_view', $groups, $module_id);
    $criteria       = new CriteriaCompo();
    $criteria->add(new Criteria('valid', 1, '='));
    $criteria->add(new Criteria('date', time(), '<='));
    $criteria->add(new Criteria('cid', '(' . implode(', ', $alumni_ids) . ')', 'IN'));
    if ($userid != 0) {
        $criteria->add(new Criteria('usid', $userid, '='));
    }

    if ($by_cat != '') {
        $criteria->add(new Criteria('cid', $by_cat, '='));
    }

    $queries = array($query);
    $queries = implode('+', $queries);

    $count = 0;
    $i     = 0;

    $criteria->add(new Criteria('name', '%' . $queries . '%', 'LIKE'), 'AND');
    $criteria->add(new Criteria('mname', '%' . $queries . '%', 'LIKE'), 'OR');
    $criteria->add(new Criteria('lname', '%' . $queries . '%', 'LIKE'), 'OR');
    //      $criteria->add(new Criteria('school', '%' . $queries[0] . '%', 'LIKE'), 'OR');
    $criteria->add(new Criteria('year', '%' . $queries . '%', 'LIKE'), 'OR');

    $criteria->setLimit($limit);
    $criteria->setSort('date');
    $criteria->setOrder('DESC');
    $criteria->setStart($start);

    $numrows     = $listingHandler->getCount();
    $this_search = $listingHandler->getAll($criteria);

    $ret = array();
    $k   = 0;

    foreach ($this_search as $obj) {
        $ret[$k]['image'] = 'assets/images/cat/default.gif';
        $ret[$k]['link']  = 'listing.php?lid=' . $obj->getVar('lid') . '';
        $ret[$k]['title'] = $obj->getVar('name') . ' ' . $obj->getVar('mname') . ' ' . $obj->getVar('lname') . '   ---   ' . $obj->getVar('school') . '
		---   ' . $obj->getVar('year');
        $ret[$k]['time']  = $obj->getVar('date');
        $ret[$k]['uid']   = $obj->getVar('usid');
        $k++;
    }

    return $ret;
}
