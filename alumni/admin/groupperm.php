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
$op    = Request::getString('op', 'alumni_view');
$xoops->header();
$admin_page = new Xoops\Module\Admin();
$admin_page->displayNavigation('groupperm.php');
$moduleId                = $xoops->module->getVar('mid');
$alumniCategoriesHandler = $xoops->getModuleHandler('alumni_categories', 'alumni');
$cats                    = $alumniCategoriesHandler->getAll();
$cat_rows                = $alumniCategoriesHandler->getCount();

include_once(XOOPS_ROOT_PATH . "/modules/{$moduleDirName}/class/alumni_tree.php");
$cattree = new AlumniObjectTree($cats, 'cid', 'pid');

if ('0' == $cat_rows) {
    echo constant($modinfoLang . '_MUST_ADD_CAT');
} else {
    $perm_desc = '';
    switch ($op) {

        case 'alumni_view':
        default:
            $title_of_form = constant($modinfoLang . '_VIEWFORM');
            $perm_name     = 'alumni_view';
            $restriction   = '';
            $anonymous     = true;
            $form          = new XoopsGroupPermForm($title_of_form, $moduleId, $perm_name, $perm_desc, 'admin/groupperm.php', $anonymous);
            break;

        case 'alumni_submit':
        default:
            $title_of_form = constant($modinfoLang . '_SUBMITFORM');
            $perm_name     = 'alumni_submit';
            $restriction   = '';
            $anonymous     = false;
            $form          = new XoopsGroupPermForm($title_of_form, $moduleId, $perm_name, $perm_desc, 'admin/groupperm.php', $anonymous);
            break;

        case 'alumni_premium':
            $title_of_form = constant($modinfoLang . '_PREMIUM');
            $perm_name     = 'alumni_premium';
            $restriction   = '';
            $anonymous     = false;
            $form          = new XoopsGroupPermForm($title_of_form, $moduleId, $perm_name, $perm_desc, 'admin/groupperm.php', $anonymous);
            break;
    }

    $opform   = new XoopsSimpleForm('', 'opform', 'groupperm.php', 'get');
    $opSelect = new XoopsFormSelect('', 'op', $op);
    $opSelect->setExtra('onchange="document.forms.opform.submit()"');
    $opSelect->addOption('alumni_view', constant($modinfoLang . '_VIEWFORM'));
    $opSelect->addOption('alumni_submit', constant($modinfoLang . '_SUBMITFORM'));
    $opSelect->addOption('alumni_premium', constant($modinfoLang . '_PREMIUM'));
    $opform->addElement($opSelect);
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
