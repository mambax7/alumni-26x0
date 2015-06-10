<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * alumni module
 * Edited by John Mordo (jlm69)
 * @copyright       XOOPS Project http://xoops.org/
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @since           2.6.0
 * @author          Mage Grégory (AKA Mage)
 * @version         $Id: $
 */

use Xoops\Module\Plugin\PluginAbstract;

defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');
include_once(XOOPS_ROOT_PATH . "/modules/{$moduleDirName}/include/common.php");

/**
 * Class AlumniSearchPlugin
 */
class AlumniSearchPlugin extends PluginAbstract implements SearchPluginInterface
{
    /**
     * @param string[] $queries
     * @param string   $andor
     * @param int      $limit
     * @param int      $offset
     * @param type     $uid
     * @return array
     */
    public function search($queries, $andor, $limit, $offset, $uid)
    {
        global $by_cat, $xoops, $query;

        if (isset($_REQUEST['by_cat'])) {
            $by_cat = $_REQUEST['by_cat'];
            $by_cat = ((int)($by_cat) > 0) ? (int)($by_cat) : 0;
        }

        $alumni = Alumni::getInstance();
        $xoops  = Xoops::getInstance();
        //	$request = Xoops_Request::getInstance();
        $action = $_REQUEST['action'];
        //	$query = Request::getString('query', '', 'POST');
        //	$queries = array();
        $module_id      = $xoops->module->getVar('mid');
        $listingHandler = $xoops->getModuleHandler('alumni_listing', 'alumni');
        $groups         = $xoops->isUser() ? $xoops->user->getGroups() : XOOPS_GROUP_ANONYMOUS;
        $alumni_ids     = $alumni->getGrouppermHandler()->getItemIds('alumni_view', $groups, $module_id);
        $criteria       = new CriteriaCompo();
        $criteria->setStart($offset);
        $criteria->setLimit($limit);
        $criteria->setSort('date');
        $criteria->setOrder('DESC');
        $criteria->add(new Criteria('valid', 1, '='));
        $criteria->add(new Criteria('date', time(), '<='));
        $criteria->add(new Criteria('cid', '(' . implode(', ', $alumni_ids) . ')', 'IN'));
        if (0 != $uid) {
            $criteria->add(new Criteria('usid', $uid, '='));
        }

        //	if ($by_cat != "0" ) {
        $criteria->add(new Criteria('cid', $by_cat, '='));
        //       }
        //        if ( is_array($queries) && $count = count($queries) )
        //        {
        $queries = array($query);
        //	$count = count($queries);

        $queries = implode('+', $queries);
        //        $count   = count($queries);
        //	$i=1;
        //     $queries = clone($criteria);
        //	for ($i = 0; $i < $count; $i ++) {

        //if ($queries) {
        $queriesCount     = count($queries);
        $criteriaKeywords = new CriteriaCompo();
        for ($x = 0; $x < $queriesCount; ++$x) {

            //foreach ($queries as $key => $value) {

            $thisSearchTerm  = count($queries) > 0 ? $queries[$x] : '';
            $criteriaKeyword = new CriteriaCompo();

            $criteriaKeyword->add(new Criteria('name', '%' . $thisSearchTerm . '%', 'LIKE'), 'AND');
            $criteriaKeyword->add(new Criteria('mname', '%' . $thisSearchTerm . '%', 'LIKE'), 'OR');
            $criteriaKeyword->add(new Criteria('lname', '%' . $thisSearchTerm . '%', 'LIKE'), 'OR');
            $criteriaKeyword->add(new Criteria('school', '%' . $thisSearchTerm . '%', 'LIKE'), 'OR');
            $criteriaKeyword->add(new Criteria('year', '%' . $thisSearchTerm . '%', 'LIKE'), 'OR');
        }
        $criteriaKeywords->add($criteriaKeyword, $andor);
        unset($criteriaKeyword, $queries);

        $criteria->add($criteriaKeywords);
        //	}
        unset($criteriaKeywords);

        //	}
        $numrows     = $listingHandler->getCount();
        $this_search = $listingHandler->getObjects($criteria, true);

        $ret = array();
        $k   = 0;

        foreach (array_keys($this_search) as $i) {

            $ret[$k]['image'] = 'assets/images/cat/default.gif';
            $ret[$k]['link']  = 'listing.php?lid=' . $this_search[$i]->getVar('lid') . '';
            $ret[$k]['title'] = $this_search[$i]->getVar('name') . ' ' . $this_search[$i]->getVar('mname') . ' ' . $this_search[$i]->getVar('lname') . '   ---   ' . $this_search[$i]->getVar('school') . '
		---   ' . $this_search[$i]->getVar('year');
            $ret[$k]['time']  = $this_search[$i]->getVar('date');
            $ret[$k]['uid']   = $this_search[$i]->getVar('usid');
            ++$k;
        }

        return $ret;

    }
}
