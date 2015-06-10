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

defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');

/**
 * Class AlumniGroupPermHandler
 */
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

    /**
     * @param       $cid
     * @param array $groups
     */
    public function updatePerms($cid, $groups = array())
    {
        $moduleId = Alumni::getInstance()->getModule()->getVar('mid');

        $groupsExists = parent::getGroupIds('alumni_view', $cid, $moduleId);
        $groupsExists = array_values($groupsExists);
        $groupsDelete = array_diff(array_values($groupsExists), $groups);
        $groups_add   = array_diff($groups, array_values($groupsExists));

        $groups1Exists = parent::getGroupIds('alumni_submit', $cid, $moduleId);
        $groups1Exists = array_values($groups1Exists);
        $groups1Delete = array_diff(array_values($groups1Exists), $groups);
        $groups1Add    = array_diff($groups, array_values($groups1Exists));

        $groups2Exists = parent::getGroupIds('alumni_premium', $cid, $moduleId);
        $groups2Exists = array_values($groups2Exists);
        $groups2Delete = array_diff(array_values($groups2Exists), $groups);
        $groups2Add    = array_diff($groups, array_values($groups2Exists));

        // delete classifieds_view
        if (0 != count($groupsDelete)) {
            $criteria = $criteria = new CriteriaCompo();
            $criteria->add(new Criteria('gperm_itemid', $cid));
            $criteria->add(new Criteria('gperm_modid', $moduleId));
            $criteria->add(new Criteria('gperm_name', 'alumni_view', '='));
            $criteria->add(new Criteria('gperm_groupid', '(' . implode(', ', $groupsDelete) . ')', 'IN'));
            if (parent::deleteAll($criteria)) {
            }
        }

        // delete classifieds_view
        if (0 != count($groups1Delete)) {
            $criteria = $criteria = new CriteriaCompo();
            $criteria->add(new Criteria('gperm_itemid', $cid));
            $criteria->add(new Criteria('gperm_modid', $moduleId));
            $criteria->add(new Criteria('gperm_name', 'alumni_submit', '='));
            $criteria->add(new Criteria('gperm_groupid', '(' . implode(', ', $groups1Delete) . ')', 'IN'));
            if (parent::deleteAll($criteria)) {
            }
        }

        // delete classifieds_view
        if (0 != count($groups2Delete)) {
            $criteria = $criteria = new CriteriaCompo();
            $criteria->add(new Criteria('gperm_itemid', $cid));
            $criteria->add(new Criteria('gperm_modid', $moduleId));
            $criteria->add(new Criteria('gperm_name', 'alumni_premium', '='));
            $criteria->add(new Criteria('gperm_groupid', '(' . implode(', ', $groups2Delete) . ')', 'IN'));
            if (parent::deleteAll($criteria)) {
            }
        }

        // Add classifieds_view
        if (0 != count($groups_add)) {
            foreach ($groups_add as $group_id) {
                parent::addRight('alumni_view', $cid, $group_id, $moduleId);
            }
        }

        // Add classifieds_submit
        if (0 != count($groups1Add)) {
            foreach ($groups1Add as $group_id) {
                parent::addRight('alumni_submit', $cid, $group_id, $moduleId);
            }
        }

        // Add classifieds_submit
        if (0 != count($groups2Add)) {
            foreach ($groups2Add as $group_id) {
                parent::addRight('alumni_premium', $cid, $group_id, $moduleId);
            }
        }
    }
}
