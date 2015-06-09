<?php
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
 * @copyright       XOOPS Project http://xoops.org/
 * @license         GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package         page
 * @since           2.6.0
 * @author          Mage Grégory (AKA Mage)
 * @version         $Id$
 */

include __DIR__ . '/admin_header.php';

// Get Action type
$op = Request::getString('op', 'alumni_view');

// Call header
$xoops->header('admin:alumni/alumni_admin_permissions.tpl');

$admin_page = new \Xoops\Module\Admin();
$admin_page->renderNavigation('permissions.php');

$opform    = new Xoops\Form\SimpleForm('', 'opform', 'permissions.php', 'get');
$op_select = new Xoops\Form\Select('', 'op', $op);
$op_select->setExtra('onchange="document.forms.opform.submit()"');
$op_select->addOption('alumni_view', AlumniLocale::PERMISSIONS_VIEW);
$op_select->addOption('alumni_submit', AlumniLocale::PERMISSIONS_SUBMIT);
//$op_select->addOption('submit', AlumniLocale::PERMISSIONS_SUBMIT);
//$op_select->addOption('premium', AlumniLocale::PERMISSIONS_PREMIUM);
$opform->addElement($op_select);
$xoops->tpl()->assign('form', $opform->render());

switch ($op) {

    //    case 'alumni_view':
    //    default:
    //        $view_perm_array = array('1' => AlumniLocale::PERMISSIONS_VIEW);
    //        $form = new Xoops\Form\GroupPermissionForm('', $module_id, 'alumni_view', '', 'admin/permissions.php', true);
    //       foreach ($view_perm_array as $perm_id => $perm_name) {
    //            $form->addItem($perm_id, $perm_name);
    //        }
    //        $form->display();
    //       break;

    case 'alumni_view':
    default:
        // Content
        $limit        = empty($_REQUEST['limit']) ? 10 : (int)($_REQUEST['limit']);
        $start        = isset($_REQUEST['start']) ? (int)($_REQUEST['start']) : 0;
        $order        = $xoops->getModuleConfig('alumni_csortorder');
        $cat_criteria = new CriteriaCompo();
        $cat_criteria->setSort("cid");
        $cat_criteria->setOrder($order);
        $cat_criteria->setStart($start);
        $cat_criteria->setLimit($limit);
        $cat_count = $alumniCategoriesHandler->getCount($cat_criteria);

        $category_arr = $alumniCategoriesHandler->getAll($cat_criteria);
        //$content_count = $content_Handler->countPage($start, $nb_limit);
        //$content_arr = $content_Handler->getPage($start, $nb_limit);

        // Assign Template variables
        $xoops->tpl()->assign('cat_count', $cat_count);

        if ($cat_count > 0) {
            $group_list = $xoops->getHandler('member')->getGroupList();

            $xoops->tpl()->assign('groups', $group_list);
            foreach (array_keys($category_arr) as $i) {
                $cid             = $category_arr[$i]->getVar('cid');
                $perms           = '';
                $groups_ids_view = $alumniGrouppermHandler->getGroupIds('alumni_view', $cid, $module_id);
                $groups_ids_view = array_values($groups_ids_view);
                foreach (array_keys($group_list) as $j) {
                    $perms .= '<img id="loading_display' . $cid . '_' . $j . '" src="' . $xoops->url('media/xoops/images/spinner.gif') . '" style="display:none;" alt="' . XoopsLocale::LOADING . '" />';
                    if (in_array($j, $groups_ids_view)) {
                        $perms .= "<img class=\"cursorpointer\" id=\"display" . $cid . "_" . $j . "\" onclick=\"Xoops.changeStatus( 'permissions.php', { op: 'update_view', cid: " . $cid . ", group: " . $j . ", status: 'no' }, 'display" . $cid . "_" . $j . "', 'permissions.php' )\" src=\"" . $xoops->url('modules/system/images/icons/default/success.png') . "\" alt=\"" . XoopsLocale::A_DISABLE . "\" title=\"" . XoopsLocale::A_DISABLE . "\" />";
                    } else {
                        $perms .= "<img class=\"cursorpointer\" id=\"display" . $cid . "_" . $j . "\" onclick=\"Xoops.changeStatus( 'permissions.php', { op: 'update_view', cid: " . $cid . ", group: " . $j . ", status: 'yes' }, 'display" . $cid . "_" . $j . "', 'permissions.php' )\" src=\"" . $xoops->url('modules/system/images/icons/default/cancel.png') . "\" alt=\"" . XoopsLocale::A_ENABLE . "\" title=\"" . XoopsLocale::A_ENABLE . "\" />";
                    }
                    $perms .= $group_list[$j] . '<br />';
                }
                $categories['id']          = $cid;
                $categories['title']       = $category_arr[$i]->getVar('title');
                $categories['permissions'] = $perms;
                $xoops->tpl()->appendByRef('category', $categories);
                unset($categories);
            }
            // Display Page Navigation
            if ($cat_count < 1) {
                //            $nav = new XoopsPageNav($cat_count, $nb_limit, $start, 'start', 'op=view');
                //            $xoops->tpl()->assign('nav_menu', $nav->renderNav(4));
                //        }
            } else {
                $xoops->tpl()->assign('error_message', AlumniLocale::E_NO_CAT);
            }
        }
        break;

    case 'update_view':
        $cid    = $system->cleanVars($_REQUEST, 'cid', 0, 'int');
        $group  = $system->cleanVars($_REQUEST, 'group', 0, 'int');
        $status = $system->cleanVars($_REQUEST, 'status', '', 'string');
        if ($cid > 0 && $group > 0 && '' != $status) {
            if ('no' == $status) {
                // deleting permissions
                $criteria = new CriteriaCompo();
                $criteria->add(new Criteria('gperm_groupid', $group));
                $criteria->add(new Criteria('gperm_itemid', $cid));
                $criteria->add(new Criteria('gperm_modid', $module_id));
                $criteria->add(new Criteria('gperm_name', 'alumni_view'));
                $alumniGrouppermHandler->deleteAll($criteria);
            } else {
                // add permissions
                $alumniGrouppermHandler->addRight('alumni_view', $cid, $group, $module_id);
            }
        }
        break;
}
$xoops->footer();
