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
 * Extended User Profile
 *
 * @copyright       XOOPS Project http://xoops.org/
 * @license         GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package         profile
 * @since           2.3.0
 * @author          Jan Pedersen
 * @author          Taiwen Jiang <phppp@users.sourceforge.net>
 * @version         $Id$
 */

include __DIR__ . '/admin_header.php';
// Get main instance
$system = System::getInstance();
$xoops  = Xoops::getInstance();

// Get Action type
//$op = $system->cleanVars($_REQUEST, 'op', 'view', 'string');
$op = Request::getCmd('op', Request::getCmd('op', 'view', 'GET'), 'POST');
// Call header
$xoops->header();

$admin_page = new \Xoops\Module\Admin();
$admin_page->displayNavigation('permissions.php');

//    $categories_Handler = $xoops->getModuleHandler('alumni_categories', 'alumni');
$cats     = $alumniCategoriesHandler->getAll();
$cat_rows = $alumniCategoriesHandler->getCount();

include_once(XOOPS_ROOT_PATH . "/modules/{$moduleDirName}/class/alumni_tree.php");
$cattree = new AlumniObjectTree($cats, 'cid', 'pid');

if ('0' == $cat_rows) {
    echo constant($modinfoLang . '_MUST_ADD_CAT');
} else {
    $perm_desc = '';
    switch ($op) {

        case 'alumni_view':
        default:
            $title_of_form = AlumniLocale::PERMISSIONS_VIEW;
            $perm_name     = 'alumni_view';
            $restriction   = '';
            $anonymous     = true;
            break;

        case 'alumni_submit':
            $title_of_form = AlumniLocale::PERMISSIONS_SUBMIT;
            $perm_name     = 'alumni_submit';
            $restriction   = '';
            $anonymous     = false;
            break;

        case 'alumni_premium':
            $title_of_form = AlumniLocale::PERMISSIONS_PREMIUM;
            $perm_name     = 'alumni_premium';
            $perm_desc     = '';
            $restriction   = '';
            $anonymous     = false;
            break;
    }

    $opform    = new Xoops\Form\SimpleForm('', 'opform', 'permissions.php', 'get');
    $op_select = new Xoops\Form\Select('', 'op', $op);
    $op_select->setExtra('onchange="document.forms.opform.submit()"');
    $op_select->addOption('alumni_view', AlumniLocale::PERMISSIONS_VIEW);
    $op_select->addOption('alumni_submit', AlumniLocale::PERMISSIONS_SUBMIT);
    $op_select->addOption('alumni_premium', AlumniLocale::PERMISSIONS_PREMIUM);
    $opform->addElement($op_select);
    $opform->display();

    $module_id = $xoops->module->getVar('mid');
    $form      = new Xoops\Form\GroupPermissionForm($title_of_form, $module_id, $perm_name, $perm_desc, 'admin/permissions.php', $anonymous);

    foreach (array_keys($cats) as $i) {
        $cid     = $cats[$i]->getVar('cid');
        $title   = $cats[$i]->getVar('title');
        $pid     = $cats[$i]->getVar('pid');
        $allcats = $cattree->alumni_makeArrayTree($cats[$i]->getVar('cid'));
        $form->addItem($cid, $title, $pid);
    }
    $form->display();
}
$xoops->footer();
