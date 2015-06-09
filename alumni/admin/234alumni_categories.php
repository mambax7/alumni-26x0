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
 * Alumni module for xoops
 *
 * @copyright       XOOPS Project http://xoops.org/
 * @license         GPL 2.0 or later
 * @package         alumni
 * @since           2.5.x
 * @author          XOOPS Development Team ( http://xoops.org )
 * @version         $Id:
 */
include __DIR__ . '/admin_header.php';
$moduleDirName = basename(dirname(__DIR__));
include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
$myts  = MyTextSanitizer::getInstance();
$xoops = Xoops::getInstance();
//$xoops->header();
$op = 'list';
if (isset($_REQUEST['op'])) {
    $op = $_REQUEST['op'];
}

switch ($op) {
    case 'list':
    default:

        $xoops->header('admin:alumni/alumni_admin_cat.tpl');

        //$alumniCategoriesHandler = $xoops->getModuleHandler('alumni_categories', 'alumni');
        $indexAdmin = new Xoops\Module\Admin();
        $indexAdmin->displayNavigation('alumni_categories.php');

        $xoTheme->addScript(ALUMNI_URL . '/media/jquery/jquery-1.8.3.min.js');
        $xoTheme->addScript(ALUMNI_URL . '/media/jquery/tablesorter-master/js/jquery.tablesorter.js');
        $xoTheme->addScript(ALUMNI_URL . '/media/jquery/tablesorter-master/addons/pager/jquery.tablesorter.pager.js');
        $xoTheme->addScript(ALUMNI_URL . '/media/jquery/tablesorter-master/js/jquery.tablesorter.widgets.js');
        $xoTheme->addScript(ALUMNI_URL . '/media/jquery/pager-custom-controls.js');
        $xoTheme->addScript(ALUMNI_URL . '/media/jquery/myAdminCatjs.js');
        $xoTheme->addStylesheet(ALUMNI_URL . '/media/jquery/css/theme.blue.css');
        $xoTheme->addStylesheet(ALUMNI_URL . '/media/jquery/tablesorter-master/addons/pager/jquery.tablesorter.pager.css');

        $indexAdmin->addItemButton(AlumniLocale::A_ADD_CAT, 'alumni_categories.php?op=new_category', 'add');
        $indexAdmin->renderButton('left', '');
        $limit        = empty($_REQUEST['limit']) ? 10 : (int)($_REQUEST['limit']);
        $start        = isset($_REQUEST['start']) ? (int)($_REQUEST['start']) : 0;
        $order        = $xoops->getModuleConfig('alumni_csortorder');
        $cat_criteria = new CriteriaCompo();
        $cat_criteria->setSort('cid');
        $cat_criteria->setOrder($order);
        $numrows = $alumniCategoriesHandler->getCount();
        $xoops->tpl()->assign('numrows', $numrows);
        $cat_criteria->setStart($start);
        $cat_criteria->setLimit($limit);

        $category_arr = $alumniCategoriesHandler->getAll($cat_criteria);

        //Function that allows display child categories
        //   function alumniCategoryDisplayChildren($cid = 0, $category_arr, $prefix = "", $order = "", &$class) {
        //    $xoops = Xoops::getInstance();

        //  $alumniCategoriesHandler = $xoops->getModuleHandler('alumni_categories', 'alumni');

        //       $prefix = $prefix."<img src='".XOOPS_URL."/modules/{$moduleDirName}/assets/images/arrow.gif'>";
        if ($numrows > 0) {
            foreach (array_keys($category_arr) as $i) {
                $cid   = $category_arr[$i]->getVar('cid');
                $pid   = $category_arr[$i]->getVar('pid');
                $title = $category_arr[$i]->getVar('title');
                $img   = $category_arr[$i]->getVar('img');
                $order = $category_arr[$i]->getVar('ordre');

                $xoops->tpl()->assign('cat', $cid);
                $category = array();
                $title    = $myts->undoHtmlSpecialChars($title);

                $category['cid']     = $cid;
                $category['title']   = $title;
                $category['ordre']   = $ordre;
                $category['numrows'] = $numrows;
                $xoopsTpl->append('category', $category);

            }

            unset($listing);

        } else {
            $xoops->tpl()->assign('error_message', AlumniLocale::E_NO_CAT);
        }
        break;

    case 'new_category':
        $xoops->header();
        $indexAdmin = new Xoops\Module\Admin();
        $indexAdmin->displayNavigation('alumni_categories.php');
        $indexAdmin->addItemButton(constant($admin_lang . '_CATEGORYLIST'), 'alumni_categories.php');
        $indexAdmin->renderButton('left', '');
        $obj  = $alumniCategoriesHandler->create();
        $form = $obj->getForm();
        $form->display();
        break;

    case 'save_category':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $xoops->redirect('alumni_categories.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (isset($_REQUEST['cid'])) {
            $obj = $alumniCategoriesHandler->get($_REQUEST['cid']);
        } else {
            $obj = $alumniCategoriesHandler->create();
        }

        $obj->setVar('pid', $_REQUEST['pid']);
        $obj->setVar('title', $_REQUEST['title']);

        include_once XOOPS_ROOT_PATH . '/class/uploader.php';
        $uploaddir         = XOOPS_UPLOAD_PATH . "/{$moduleDirName}/assets/images/";
        $photomax          = $xoops->getModuleConfig('alumni_photomax');
        $maxwide           = $xoops->getModuleConfig('alumni_maxwide');
        $maxhigh           = $xoops->getModuleConfig('alumni_maxhigh');
        $allowed_mimetypes = array('image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png');
        $uploader          = new XoopsMediaUploader($uploaddir, $allowed_mimetypes, $photomax, $maxwide, $maxhigh);
        if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
            $uploader->setPrefix('category_img_');
            $uploader->fetchMedia($_POST['xoops_upload_file'][0]);
            if (!$uploader->upload()) {
                $errors = $uploader->getErrors();
                $xoops->redirect('javascript:history.go(-1)', 3, $errors);
            } else {
                $obj->setVar('img', $uploader->getSavedFileName());
            }
        } else {
            $obj->setVar('img', $_REQUEST['img']);
        }

        $destination = XOOPS_ROOT_PATH . "/modules/{$moduleDirName}/photos/school_photos";

        if ('1' == isset($_REQUEST['del_photo'])) {
            if (@file_exists('' . $destination . '/' . $_REQUEST['photo_old'] . '')) {
                unlink('' . $destination . '/' . $_REQUEST['photo_old'] . '');
            }

            $obj->setVar('scphoto', '');
        }
        $obj->setVar('ordre', $_REQUEST['ordre']);
        $obj->setVar('scaddress', $_REQUEST['scaddress']);
        $obj->setVar('scaddress2', $_REQUEST['scaddress2']);
        $obj->setVar('sccity', $_REQUEST['sccity']);
        $obj->setVar('scstate', $_REQUEST['scstate']);
        $obj->setVar('sczip', $_REQUEST['sczip']);
        $obj->setVar('scphone', $_REQUEST['scphone']);
        $obj->setVar('scfax', $_REQUEST['scfax']);
        $obj->setVar('scmotto', $_REQUEST['scmotto']);
        $obj->setVar('scurl', $_REQUEST['scurl']);

        $date = time();
        if (!empty($_FILES['scphoto']['name'])) {
            include_once XOOPS_ROOT_PATH . '/class/uploader.php';
            $uploaddir         = XOOPS_ROOT_PATH . "/modules/{$moduleDirName}/photos/school_photos";
            $photomax          = $xoops->getModuleConfig('alumni_photomax');
            $maxwide           = $xoops->getModuleConfig('alumni_maxwide');
            $maxhigh           = $xoops->getModuleConfig('alumni_maxhigh');
            $allowed_mimetypes = array('image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png');
            $uploader          = new XoopsMediaUploader($uploaddir, $allowed_mimetypes, $photomax, $maxwide, $maxhigh);
            if ($uploader->fetchMedia($_POST['xoops_upload_file'][1])) {
                $uploader->setTargetFileName($date . '_' . $_FILES['scphoto']['name']);
                $uploader->fetchMedia($_POST['xoops_upload_file'][1]);
                if (!$uploader->upload()) {
                    $errors = $uploader->getErrors();
                    $xoops->redirect('javascript:history.go(-1)', 3, $errors);
                } else {
                    $obj->setVar('scphoto', $uploader->getSavedFileName());
                }
            } else {
                $obj->setVar('scphoto', $_REQUEST['scphoto']);
            }
        }

        if ($alumniCategoriesHandler->insert($obj)) {
            $xoops->redirect('alumni_categories.php', 3, constant($admin_lang . '_FORMOK'));
        }
        echo $obj->getHtmlErrors();
        $form =& $obj->getForm();
        $form->display();
        break;

    case 'edit_category':

        $xoops = Xoops::getInstance();
        $xoops->header();
        $indexAdmin = new Xoops\Module\Admin();
        $indexAdmin->displayNavigation('alumni_categories.php');
        $indexAdmin->addItemButton(constant($admin_lang . '_CATEGORYLIST'), 'alumni.php', 'list');
        $indexAdmin->renderButton('left', '');
        $obj  = $alumniCategoriesHandler->get($_REQUEST['cid']);
        $form = $obj->getForm();
        $form->display();
        break;

    case 'delete_category':
        $xoops = Xoops::getInstance();
        $xoops->header();
        $obj = $alumniCategoriesHandler->get($_REQUEST['cid']);
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                $xoops->redirect('alumni_categories.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($alumniCategoriesHandler->delete($obj)) {
                $xoops->redirect('alumni_categories.php', 3, constant($admin_lang . '_FORMDELOK'));
            } else {
                echo $obj->getHtmlErrors();
            }
        } else {
            $xoops->confirm(array('ok' => 1, 'cid' => $_REQUEST['cid'], 'op' => 'delete_category'), $_SERVER['REQUEST_URI'], sprintf(constant($admin_lang . '_FORMSUREDEL'), $obj->getVar('category')));
        }
        break;
}

$xoops->footer();
