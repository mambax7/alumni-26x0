<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.

 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package         alumni
 * @since           2.6.0
 * @author          John Mordo - jlm69
 */

include __DIR__ . '/header.php';

$xoops = Xoops::getInstance();
$op    = $request->asStr('op', 'alumni_view');
$xoops->header();
$admin_page = new Xoops\Module\Admin();
$admin_page->displayNavigation('groupperm.php');
$module_id          = $xoops->module->getVar('mid');
$categories_Handler = $xoops->getModuleHandler('alumni_categories', 'alumni');
$cats               = $categories_Handler->getall();
$cat_rows           = $categories_Handler->getCount();

include_once(XOOPS_ROOT_PATH . "/modules/{$moduleDirName}/class/alumni_tree.php");
$cattree = new AlumniObjectTree($cats, 'cid', 'pid');

if ($cat_rows == '0') {
    echo constant($modinfo_lang . '_MUST_ADD_CAT');
} else {

    $perm_desc = '';
    switch ($op) {

        case 'alumni_view':
        default:
            $title_of_form = constant($modinfo_lang . '_VIEWFORM');
            $perm_name     = 'alumni_view';
            $restriction   = '';
            $anonymous     = true;
            $form          = new XoopsGroupPermForm($title_of_form, $module_id, $perm_name, $perm_desc, 'admin/groupperm.php', $anonymous);
            break;

        case 'alumni_submit':
        default:
            $title_of_form = constant($modinfo_lang . '_SUBMITFORM');
            $perm_name     = 'alumni_submit';
            $restriction   = '';
            $anonymous     = false;
            $form          = new XoopsGroupPermForm($title_of_form, $module_id, $perm_name, $perm_desc, 'admin/groupperm.php', $anonymous);
            break;

        case 'alumni_premium':
            $title_of_form = constant($modinfo_lang . '_PREMIUM');
            $perm_name     = 'alumni_premium';
            $restriction   = '';
            $anonymous     = false;
            $form          = new XoopsGroupPermForm($title_of_form, $module_id, $perm_name, $perm_desc, 'admin/groupperm.php', $anonymous);
            break;
    }

    $opform    = new XoopsSimpleForm('', 'opform', 'groupperm.php', 'get');
    $op_select = new XoopsFormSelect('', 'op', $op);
    $op_select->setExtra('onchange="document.forms.opform.submit()"');
    $op_select->addOption('alumni_view', constant($modinfo_lang . '_VIEWFORM'));
    $op_select->addOption('alumni_submit', constant($modinfo_lang . '_SUBMITFORM'));
    $op_select->addOption('alumni_premium', constant($modinfo_lang . '_PREMIUM'));
    $opform->addElement($op_select);
    $opform->display();

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
