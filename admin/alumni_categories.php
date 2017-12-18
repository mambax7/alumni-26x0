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
 * @copyright       XOOPS Project https://xoops.org/
 * @license         GPL 2.0 or later
 * @package         alumni
 * @since           2.5.x
 * @author          XOOPS Development Team ( https://xoops.org )
 * @version         $Id: const_entete.php 9860 2012-07-13 10:41:41Z txmodxoops $
 */

use Xoops\Core\Request;

include __DIR__ . '/admin_header.php';
$xoops = Xoops::getInstance();
$xoops->header();

//$op = 'list';
//if (isset($_REQUEST['op'])) {
//    $op = $_REQUEST['op'];
//}
$op = Request::getCmd('op', Request::getCmd('op', 'list', 'GET'), 'POST');

switch ($op) {
    case 'list':
    default:
        //$alumniCategoryHandler = $xoops->getModuleHandler('alumni_categories', $moduleDirName);
        $indexAdmin = new Xoops\Module\Admin();
        echo $indexAdmin->displayNavigation('alumni_categories.php');
        $indexAdmin->addItemButton(AlumniLocale::A_ADD_CAT, 'alumni_categories.php?op=new_category', 'add');
        echo $indexAdmin->renderButton('left', '');
        $limit       = Request::getInt('limit', 10, 'POST');
        $start       = Request::getInt('start', 0, 'POST');
        $order       = $xoops->getModuleConfig('alumni_csortorder');
        $catCriteria = new CriteriaCompo();
        $catCriteria->setSort('cid');
        $catCriteria->setOrder($order);
        $numrows = $categoryHandler->getCount();

        $catCriteria->setStart($start);
        $catCriteria->setLimit($limit);

        $categoryArray = $categoryHandler->getAll($catCriteria);

        //Function that allows display child categories
        /**
         * @param int    $cid
         * @param        $categoryArray
         * @param string $prefix
         * @param string $order
         * @param        $class
         */
        function alumniCategoryDisplayChildren($cid = 0, $categoryArray, $prefix = '', $order = '', &$class)
        {
            $xoops = Xoops::getInstance();

            //  $alumniCategoryHandler = $xoops->getModuleHandler('alumni_categories', $moduleDirName);
            $moduleDirName = basename(dirname(__DIR__));
            $prefix        = $prefix . '<img src=\'' . XOOPS_URL . "/modules/{$moduleDirName}/assets/images/arrow.gif'>";
            foreach (array_keys($categoryArray) as $i) {
                $cid   = $categoryArray[$i]->getVar('cid');
                $pid   = $categoryArray[$i]->getVar('pid');
                $title = $categoryArray[$i]->getVar('title');
                $img   = $categoryArray[$i]->getVar('img');
                $order = $categoryArray[$i]->getVar('ordre');

                echo '<tr class="' . $class . '">';
                echo '<td align="left">' . $prefix . '&nbsp;' . $categoryArray[$i]->getVar('title') . '</td>';

                echo '<td align="center"><img src="' . XOOPS_URL . "/modules/{$moduleDirName}/assets/images/cat/" . $categoryArray[$i]->getVar('img') . '" height="16px" title="img" alt="img"></td>';
                echo '<td align="center">' . $categoryArray[$i]->getVar('ordre') . '</td>';
                echo "<td align='center' width='10%'>
						<a href='alumni_categories.php?op=edit_category&cid=" . $categoryArray[$i]->getVar('cid') . "'><img src='../assets/images/edit.gif' alt='" . XoopsLocale::A_EDIT . "' title='" . XoopsLocale::A_EDIT . "'></a>
						<a href='alumni_categories.php?op=delete_category&cid=" . $categoryArray[$i]->getVar('cid') . "'><img src='../assets/images/dele.gif' alt='" . XoopsLocale::A_DELETE . "' title='" . XoopsLocale::A_DELETE . "'></a></td></tr>";
                $class = ('even' == $class) ? 'odd' : 'even';

                // $alumniCategoryHandler = $xoops->getModuleHandler('Category', $moduleDirName);
                $criteria2               = new CriteriaCompo();
                $criteria2->add(new Criteria('pid', $categoryArray[$i]->getVar('cid')));
                $criteria2->setSort('title');
                $criteria2->setOrder('ASC');
                $cat_pid = $categoryHandler->getAll($criteria2);
                $num_pid = $categoryHandler->getCount();
                if (0 != $num_pid) {
                    alumniCategoryDisplayChildren($cid, $cat_pid, $prefix, $order, $class);
                }
            }
        }

        //Table View
        if ($numrows > 0) {
            if ($numrows > 1) {
                if ($numrows > $limit) {
                    $cat_url[] = 'limit=' . $limit;
                    $cat_url[] = 'orderby=' . $order;

                    if (null !== $cat_url) {
                        $args = implode('&amp;', $cat_url);
                    }
                    $nav = new XoopsPageNav($numrows, $limit, $start, 'start', $args);

                    echo '' . $nav->renderNav(5, '', 'center') . '';
                }
            }

            echo "<table width='100%' cellspacing='1' class='outer'>
		<tr>
		<th align=\"center\">" . constant($adminLang . '_CATEGORY_TITLE') . "</th>
		<th align=\"center\">" . constant($adminLang . '_IMGCAT') . "</th>
		<th align=\"center\">" . XoopsLocale::ORDER . "</th>
		<th align='center' width='10%'>" . XoopsLocale::ACTIONS . '</th></tr>';
            $class  = 'odd';
            $prefix = "<img src='" . XOOPS_URL . "/modules/{$moduleDirName}/assets/images/arrow.gif'>";

            $categoryArray2 = $categoryHandler->getAll($catCriteria);

            foreach (array_keys($categoryArray2) as $i) {
                if (0 == $categoryArray2[$i]->getVar('pid')) {
                    $cid   = $categoryArray2[$i]->getVar('cid');
                    $img   = $categoryArray2[$i]->getVar('img');
                    $title = $categoryArray2[$i]->getVar('title');
                    $order = $categoryArray2[$i]->getVar('ordre');
                    echo "<tr class='" . $class . "'>";
                    echo "<td align=\"left\">" . $prefix . "&nbsp;" . $categoryArray2[$i]->getVar('title') . '</td>';

                    echo "<td align=\"center\"><img src=\"" . XOOPS_URL . "/modules/{$moduleDirName}/assets/images/cat/" . $categoryArray2[$i]->getVar('img') . "\" height=\"16px\" title=\"img\" alt=\"img\"></td>";
                    echo "<td align=\"center\">" . $categoryArray2[$i]->getVar('ordre') . '</td>';
                    echo "<td align='center' width='10%'>
				<a href='alumni_categories.php?op=edit_category&cid=" . $categoryArray2[$i]->getVar("cid") . "'><img src='../assets/images/edit.gif' alt='" . XoopsLocale::A_EDIT . "' title='" . XoopsLocale::A_EDIT . "'></a>
				<a href='alumni_categories.php?op=delete_category&cid=" . $categoryArray2[$i]->getVar("cid") . "'><img src='../assets/images/dele.gif' alt='" . XoopsLocale::A_DELETE . "' title='" . XoopsLocale::A_DELETE . "'></a></td></tr>";
                    $class     = ('even' == $class) ? 'odd' : 'even';
                    $criteria3 = new CriteriaCompo();
                    $criteria3->add(new Criteria('pid', $cid));
                    $criteria3->setSort('title');
                    $criteria3->setOrder('ASC');
                    $pid     = $categoryHandler->getAll($criteria3);
                    $num_pid = $categoryHandler->getCount();

                    if (0 != $pid) {
                        alumniCategoryDisplayChildren($cid, $pid, $prefix, 'title', $class);
                    }
                }
            }
            echo '</table><br /><br />';
        }

        break;

    case 'new_category':
        $xoops->header();
        $indexAdmin = new Xoops\Module\Admin();
        $indexAdmin->displayNavigation('alumni_categories.php');
        $indexAdmin->addItemButton(constant($adminLang . '_CATEGORYLIST'), 'alumni_categories.php');
        $indexAdmin->renderButton('left', '');
        $obj  = $categoryHandler->create();
        $form = $obj->getForm();
        $form->display();
        break;

    case 'save_category':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $xoops->redirect('alumni_categories.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if ($tempCid = Request::getInt('cid', null, 'GET')) {
            $obj = $categoryHandler->get($tempCid);
        } else {
            $obj = $categoryHandler->create();
        }

        $obj->setVar('pid', Request::getInt('pid', 0, 'POST'));
        $obj->setVar('title', Request::getString('title', '', 'POST'));

        include_once XOOPS_ROOT_PATH . '/class/uploader.php';
        $uploaddir         = \XoopsBaseConfig::get('uploads-path') . "/{$moduleDirName}/assets/images/";
        $photomax         = $xoops->getModuleConfig('alumni_photomax');
        $maxwide          = $xoops->getModuleConfig('alumni_maxwide');
        $maxhigh          = $xoops->getModuleConfig('alumni_maxhigh');
        $allowedMimetypes = array('image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png');
        $uploader         = new XoopsMediaUploader($uploaddir, $allowedMimetypes, $photomax, $maxwide, $maxhigh);
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
            $obj->setVar('img', Request::getString('img', '', 'POST'));
        }

        $destination = XOOPS_ROOT_PATH . "/uploads/{$moduleDirName}/photos/school_photos";

        if ('1' == Request::getInt('del_photo', 0, 'POST')) {
            if (@file_exists('' . $destination . '/' . Request::getString('photo_old', '', 'POST') . '')) {
                unlink('' . $destination . '/' . Request::getString('photo_old', '', 'POST') . '');
            }

            $obj->setVar('scphoto', '');
        }
        $obj->setVar('ordre', Request::getString('ordre', '', 'POST')); // $_REQUEST['ordre']);
        $obj->setVar('scaddress', Request::getString('scaddress', '', 'POST')); // $_REQUEST['scaddress']);
        $obj->setVar('scaddress2', Request::getString('scaddress2', '', 'POST')); // $_REQUEST['scaddress2']);
        $obj->setVar('sccity', Request::getString('sccity', '', 'POST')); // $_REQUEST['sccity']);
        $obj->setVar('scstate', Request::getString('scstate', '', 'POST')); // $_REQUEST['scstate']);
        $obj->setVar('sczip', Request::getString('sczip', '', 'POST')); // $_REQUEST['sczip']);
        $obj->setVar('scphone', Request::getString('scphone', '', 'POST')); // $_REQUEST['scphone']);
        $obj->setVar('scfax', Request::getString('scfax', '', 'POST')); // $_REQUEST['scfax']);
        $obj->setVar('scmotto', Request::getString('scmotto', '', 'POST')); // $_REQUEST['scmotto']);
        $obj->setVar('scurl', Request::getString('scurl', '', 'POST')); // $_REQUEST['scurl']);

        $date = time();
        if (!empty($_FILES['scphoto']['name'])) {
            include_once XOOPS_ROOT_PATH . '/class/uploader.php';
            $uploaddir        = XOOPS_ROOT_PATH . "/uploads/{$moduleDirName}/photos/school_photos";
            $photomax         = $xoops->getModuleConfig('alumni_photomax');
            $maxwide          = $xoops->getModuleConfig('alumni_maxwide');
            $maxhigh          = $xoops->getModuleConfig('alumni_maxhigh');
            $allowedMimetypes = array('image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png');
            $uploader         = new XoopsMediaUploader($uploaddir, $allowedMimetypes, $photomax, $maxwide, $maxhigh);
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
                $obj->setVar('scphoto', Request::getString('scphoto', '', 'POST')); // $_REQUEST['scphoto']);
            }
        }

        if ($categoryHandler->insert($obj)) {
            $xoops->redirect('alumni_categories.php', 3, constant($adminLang . '_FORMOK'));
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
        $indexAdmin->addItemButton(constant($adminLang . '_CATEGORYLIST'), 'alumni.php', 'list');
        $indexAdmin->renderButton('left', '');
        $obj  = $categoryHandler->get(Request::getInt('cid', 0, 'GET'));
        $form = $obj->getForm();
        $form->display();
        break;

    case 'delete_category':
        $xoops = Xoops::getInstance();
        $xoops->header();
        $obj = $categoryHandler->get(Request::getInt('cid', 0, 'GET'));
        if (1 == Request::getInt('ok', null, 'POST')) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                $xoops->redirect('alumni_categories.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($categoryHandler->delete($obj)) {
                $xoops->redirect('alumni_categories.php', 3, constant($adminLang . '_FORMDELOK'));
            } else {
                echo $obj->getHtmlErrors();
            }
        } else {
            echo $xoops->confirm(array('ok' => 1, 'cid' => Request::getInt('cid', 0, 'GET'), 'op' => 'delete_category'), Request::getString('REQUEST_URI', '', 'SERVER'), sprintf(constant($adminLang . '_FORMSUREDEL'), $obj->getVar('category')));
        }
        break;
}

$xoops->footer();
