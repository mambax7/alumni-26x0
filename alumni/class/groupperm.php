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
 * page module
 *
 * @copyright       XOOPS Project http://xoops.org/
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package         page
 * @since           2.6.0
 * @author          DuGris (aka Laurent JEN)
 * @version         $Id$
 */

use Xoops\Core\Request;

defined('XOOPS_ROOT_PATH') or die('Restricted access');

class AlumniGroupPermHandler extends XoopsGroupPermHandler
{
    /**
     * Check permission
     *
     * @param string    $gperm_name
     * @param int       $gperm_itemid
     * @param array|int $gperm_groupid
     * @param int       $gperm_modid
     * @param bool      $trueifadmin
     *
     * @return bool
     */
    public function checkRight($gperm_name, $gperm_itemid, $gperm_groupid, $gperm_modid = 1, $trueifadmin = true)
    {
        return parent::checkRight($gperm_name, $gperm_itemid, $gperm_groupid, $gperm_modid, $trueifadmin);
    }

    public function updatePerms($cid, $groups = array())
    {
        $module_id = Alumni::getInstance()->getModule()->getVar('mid');

        $groups_exists = parent::getGroupIds('alumni_view', $cid, $module_id);
        $groups_exists = array_values($groups_exists);
        $groups_delete = array_diff(array_values($groups_exists), $groups);
        $groups_add = array_diff($groups, array_values($groups_exists));

        $groups1_exists = parent::getGroupIds('alumni_submit', $cid, $module_id);
        $groups1_exists = array_values($groups1_exists);
        $groups1_delete = array_diff(array_values($groups1_exists), $groups);
        $groups1_add = array_diff($groups, array_values($groups1_exists));
        
        $groups2_exists = parent::getGroupIds('alumni_premium', $cid, $module_id);
        $groups2_exists = array_values($groups2_exists);
        $groups2_delete = array_diff(array_values($groups2_exists), $groups);
        $groups2_add = array_diff($groups, array_values($groups2_exists));
        
        
        
        
        
        
        
        // delete classifieds_view
        if (count($groups_delete) != 0 ) {
            $criteria = $criteria = new CriteriaCompo();
            $criteria->add(new Criteria('gperm_itemid', $cid));
            $criteria->add(new Criteria('gperm_modid', $module_id));
            $criteria->add(new Criteria('gperm_name', 'alumni_view', '='));
            $criteria->add(new Criteria('gperm_groupid', '(' . implode(', ', $groups_delete) . ')', 'IN'));
            if (parent::deleteAll($criteria)) {
            }
        }
        
        
        // delete classifieds_view
        if (count($groups1_delete) != 0 ) {
            $criteria = $criteria = new CriteriaCompo();
            $criteria->add(new Criteria('gperm_itemid', $cid));
            $criteria->add(new Criteria('gperm_modid', $module_id));
            $criteria->add(new Criteria('gperm_name', 'alumni_submit', '='));
            $criteria->add(new Criteria('gperm_groupid', '(' . implode(', ', $groups1_delete) . ')', 'IN'));
            if (parent::deleteAll($criteria)) {
            }
        }
        
        // delete classifieds_view
        if (count($groups2_delete) != 0 ) {
            $criteria = $criteria = new CriteriaCompo();
            $criteria->add(new Criteria('gperm_itemid', $cid));
            $criteria->add(new Criteria('gperm_modid', $module_id));
            $criteria->add(new Criteria('gperm_name', 'alumni_premium', '='));
            $criteria->add(new Criteria('gperm_groupid', '(' . implode(', ', $groups2_delete) . ')', 'IN'));
            if (parent::deleteAll($criteria)) {
            }
        } 
        
        // Add classifieds_view
        if (count($groups_add) != 0 ) {
            foreach($groups_add as $group_id) {
                parent::addRight('alumni_view', $cid, $group_id, $module_id);
            }
        }
        
                // Add classifieds_submit
        if (count($groups1_add) != 0 ) {
            foreach($groups1_add as $group_id) {
                parent::addRight('alumni_submit', $cid, $group_id, $module_id);
            }
        }
        
                // Add classifieds_submit
        if (count($groups2_add) != 0 ) {
            foreach($groups2_add as $group_id) {
                parent::addRight('alumni_premium', $cid, $group_id, $module_id);
            }
        }
        
        
    }
}