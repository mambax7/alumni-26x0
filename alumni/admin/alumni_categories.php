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
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         GPL 2.0 or later
 * @package         alumni
 * @since           2.5.x
 * @author          XOOPS Development Team ( http://xoops.org )
 * @version         $Id: const_entete.php 9860 2012-07-13 10:41:41Z txmodxoops $
 */
include __DIR__ . '/admin_header.php';
$xoops = Xoops::getInstance();
$xoops->header();

if (isset($_REQUEST['op'])){
$op = $_REQUEST['op'];}
else {
    $op = 'list';
}

switch ($op) {
case "list":
default:
//$alumni_categories_Handler = $xoops->getModuleHandler('alumni_categories', 'alumni');
    $indexAdmin = new Xoops\Module\Admin();
    $indexAdmin->displayNavigation('alumni_categories.php');
    $indexAdmin->addItemButton(AlumniLocale::A_ADD_CAT, 'alumni_categories.php?op=new_category', 'add');
    $indexAdmin->renderButton('left', '');
    
        $limit = empty($_REQUEST['limit']) ? 10 : intval($_REQUEST['limit']);
        $start = isset($_REQUEST['start']) ? intval($_REQUEST['start']) : 0;
        $order = $xoops->getModuleConfig('alumni_csortorder');
    $cat_criteria = new CriteriaCompo();
    $cat_criteria->setSort("cid");
    $cat_criteria->setOrder($order);
    $numrows = $alumni_categories_Handler->getCount();

	$cat_criteria->setStart($start);
        $cat_criteria->setLimit($limit);

    $category_arr = $alumni_categories_Handler->getall($cat_criteria);

    //Function that allows display child categories
    function alumniCategoryDisplayChildren($cid = 0, $category_arr, $prefix = "", $order = "", &$class) {
     $xoops = Xoops::getInstance();

   //  $alumni_categories_Handler = $xoops->getModuleHandler('alumni_categories', 'alumni');

        $prefix = $prefix."<img src='".XOOPS_URL."/modules/alumni/images/arrow.gif'>";
        foreach (array_keys($category_arr) as $i) {
            $cid   = $category_arr[$i]->getVar("cid");
            $pid   = $category_arr[$i]->getVar("pid");
            $title = $category_arr[$i]->getVar("title");
            $img   = $category_arr[$i]->getVar("img");
            $order = $category_arr[$i]->getVar("ordre");

            echo "<tr class='" . $class . "'>";
            echo "<td align=\"left\">" . $prefix . "&nbsp;" . $category_arr[$i]->getVar("title") . "</td>";

            echo "<td align=\"center\"><img src=\"" . XOOPS_URL . "/modules/alumni/images/cat/". $category_arr[$i]->getVar("img")
                . "\" height=\"16px\" title=\"img\" alt=\"img\"></td>";
            echo "<td align=\"center\">" . $category_arr[$i]->getVar("ordre") . "</td>";
            echo "<td align='center' width='10%'>
						<a href='alumni_categories.php?op=edit_category&cid=" . $category_arr[$i]->getVar("cid")
                . "'><img src='../images/edit.gif' alt='" . XoopsLocale::A_EDIT . "' title='" . XoopsLocale::A_EDIT . "'></a>
						<a href='alumni_categories.php?op=delete_category&cid=" . $category_arr[$i]->getVar("cid")
		. "'><img src='../images/dele.gif' alt='" . XoopsLocale::A_DELETE . "' title='" . XoopsLocale::A_DELETE . "'></a></td></tr>";
            $class    = ($class == "even") ? "odd" : "even";
            
            
            
            $alumni_categories_Handler = $xoops->getModuleHandler('alumni_categories', 'alumni');
            $criteria2 = new CriteriaCompo();
            $criteria2->add(new Criteria("pid", $category_arr[$i]->getVar("cid")));
            $criteria2->setSort("title");
            $criteria2->setOrder("ASC");
            $cat_pid = $alumni_categories_Handler->getAll($criteria2);
            $num_pid = $alumni_categories_Handler->getCount();
            if ($num_pid != 0) {
                alumniCategoryDisplayChildren($cid, $cat_pid, $prefix, $order, $class);
            }
            
            
            
        }
    }

    //Table View
    if ($numrows > 0) {
     if ($numrows > 1) {
        if ($numrows > $limit) {
            $cat_url[] = "limit=" . $limit;
            $cat_url[] = "orderby=" . $order;

            if (isset($cat_url)) {
                $args = implode("&amp;", $cat_url);
            }
            $nav = new XoopsPageNav($numrows, $limit, $start, "start", $args);
            
     echo "" .$nav->renderNav(5, '', 'center'). "";  

        } 
    }

        echo "<table width='100%' cellspacing='1' class='outer'>
		<tr>
		<th align=\"center\">" . _AM_ALUMNI_CATEGORY_TITLE . "</th>
		<th align=\"center\">" . _AM_ALUMNI_IMGCAT . "</th>
		<th align=\"center\">" . XoopsLocale::ORDER . "</th>
		<th align='center' width='10%'>" . XoopsLocale::ACTIONS . "</th></tr>";
        $class  = "odd";
        $prefix = "<img src='" . XOOPS_URL . "/modules/alumni/images/arrow.gif'>";
        
        $category_arr2 = $alumni_categories_Handler->getall($cat_criteria);
        
        foreach (array_keys($category_arr2) as $i) {
            if ($category_arr2[$i]->getVar("pid") == 0) {
                $cid   = $category_arr2[$i]->getVar("cid");
                $img   = $category_arr2[$i]->getVar("img");
                $title = $category_arr2[$i]->getVar("title");
                $order = $category_arr2[$i]->getVar("ordre");
                echo "<tr class='" . $class . "'>";
                echo "<td align=\"left\">" . $prefix . "&nbsp;" . $category_arr2[$i]->getVar("title") . "</td>";

                echo "<td align=\"center\"><img src=\"" . XOOPS_URL . "/modules/alumni/images/cat/"
                    . $category_arr2[$i]->getVar("img")
                    . "\" height=\"16px\" title=\"img\" alt=\"img\"></td>";
                echo "<td align=\"center\">" . $category_arr2[$i]->getVar("ordre") . "</td>";
                echo "<td align='center' width='10%'>
				<a href='alumni_categories.php?op=edit_category&cid="
                    . $category_arr2[$i]->getVar("cid") . "'><img src='../images/edit.gif' alt='" .XoopsLocale::A_EDIT
                    . "' title='" . XoopsLocale::A_EDIT . "'></a>
				<a href='alumni_categories.php?op=delete_category&cid="
                    . $category_arr2[$i]->getVar("cid") . "'><img src='../images/dele.gif' alt='"
                    . XoopsLocale::A_DELETE . "' title='" . XoopsLocale::A_DELETE . "'></a></td></tr>";
                $class    = ($class == "even") ? "odd" : "even";
                $criteria3 = new CriteriaCompo();
                $criteria3->add(new Criteria("pid", $cid));
                $criteria3->setSort("title");
                $criteria3->setOrder("ASC");
                $pid = $alumni_categories_Handler->getall($criteria3);
                $num_pid      = $alumni_categories_Handler->getCount();

                if ($pid != 0) {
                    alumniCategoryDisplayChildren($cid, $pid, $prefix, "title", $class);
                }
            }
        }
        echo "</table><br /><br />";  
    }

    break;

case "new_category":
    $xoops->header();
    $indexAdmin = new Xoops\Module\Admin();
    $indexAdmin->displayNavigation('alumni_categories.php');
    $indexAdmin->addItemButton(_AM_ALUMNI_CATEGORYLIST, 'alumni_categories.php');
    $indexAdmin->renderButton('left', '');
    $obj  = $alumni_categories_Handler->create();
    $form = $obj->getForm();
    $form->display();
    break;

case "save_category":
    if (!$GLOBALS["xoopsSecurity"]->check()) {
        $xoops->redirect("alumni_categories.php", 3, implode(",", $GLOBALS["xoopsSecurity"]->getErrors()));
    }
    if (isset($_REQUEST["cid"])) {
        $obj = $alumni_categories_Handler->get($_REQUEST["cid"]);
    } else {
        $obj = $alumni_categories_Handler->create();
    }

    $obj->setVar("pid", $_REQUEST["pid"]);
    $obj->setVar("title", $_REQUEST["title"]);

    include_once XOOPS_ROOT_PATH . "/class/uploader.php";
    $uploaddir = XOOPS_UPLOAD_PATH . "/alumni/images/";
    $photomax     = $xoops->getModuleConfig('alumni_photomax');
    $maxwide     = $xoops->getModuleConfig('alumni_maxwide');
    $maxhigh     = $xoops->getModuleConfig('alumni_maxhigh');
    $allowed_mimetypes = array('image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png');
    $uploader  = new XoopsMediaUploader($uploaddir, $allowed_mimetypes, $photomax, $maxwide, $maxhigh);
    if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
        $uploader->setPrefix("category_img_");
        $uploader->fetchMedia($_POST['xoops_upload_file'][0]);
        if (!$uploader->upload()) {
            $errors = $uploader->getErrors();
            $xoops->redirect("javascript:history.go(-1)", 3, $errors);
        } else {
            $obj->setVar("img", $uploader->getSavedFileName());
        }
    } else {
        $obj->setVar("img", $_REQUEST["img"]);
    }

  	$destination = XOOPS_ROOT_PATH."/modules/alumni/photos/school_photos";
	
	if(isset($_REQUEST["del_photo"]) == "1"){
		if (@file_exists("".$destination."/".$_REQUEST['photo_old']."")) {
			 unlink("".$destination."/".$_REQUEST['photo_old']."");
		}
		
		$obj->setVar("scphoto", "");
	}
    $obj->setVar("ordre", $_REQUEST["ordre"]);
    $obj->setVar("scaddress", $_REQUEST["scaddress"]);
    $obj->setVar("scaddress2", $_REQUEST["scaddress2"]);
    $obj->setVar("sccity", $_REQUEST["sccity"]);
    $obj->setVar("scstate", $_REQUEST["scstate"]);
    $obj->setVar("sczip", $_REQUEST["sczip"]);
    $obj->setVar("scphone", $_REQUEST["scphone"]);
    $obj->setVar("scfax", $_REQUEST["scfax"]);
    $obj->setVar("scmotto", $_REQUEST["scmotto"]);
    $obj->setVar("scurl", $_REQUEST["scurl"]);
    
    $date = time();
    if ( !empty($_FILES['scphoto']['name']) ) {
    include_once XOOPS_ROOT_PATH . "/class/uploader.php";
    $uploaddir = XOOPS_ROOT_PATH."/modules/alumni/photos/school_photos";
    $photomax     = $xoops->getModuleConfig('alumni_photomax');
    $maxwide     = $xoops->getModuleConfig('alumni_maxwide');
    $maxhigh     = $xoops->getModuleConfig('alumni_maxhigh');
    $allowed_mimetypes = array('image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png');
    $uploader  = new XoopsMediaUploader($uploaddir, $allowed_mimetypes, $photomax, $maxwide, $maxhigh);
    if ($uploader->fetchMedia($_POST['xoops_upload_file'][1])) {
        $uploader->setTargetFileName($date.'_'.$_FILES['scphoto']['name']);
        $uploader->fetchMedia($_POST['xoops_upload_file'][1]);
        if (!$uploader->upload()) {
            $errors = $uploader->getErrors();
            $xoops->redirect("javascript:history.go(-1)", 3, $errors);
        } else {
		$obj->setVar("scphoto", $uploader->getSavedFileName());
        }
    } else {
        $obj->setVar("scphoto", $_REQUEST["scphoto"]);
    }
    } 

    if ($alumni_categories_Handler->insert($obj)) {
        $xoops->redirect("alumni_categories.php", 3, _AM_ALUMNI_FORMOK);
    }
    echo $obj->getHtmlErrors();
    $form =& $obj->getForm();
    $form->display();
    break;

case "edit_category":

$xoops = Xoops::getInstance();
$xoops->header();
    $indexAdmin = new Xoops\Module\Admin();
    $indexAdmin->displayNavigation("alumni_categories.php");
    $indexAdmin->addItemButton(_AM_ALUMNI_CATEGORYLIST, 'alumni.php', 'list');
    $indexAdmin->renderButton('left', '');
    $obj  = $alumni_categories_Handler->get($_REQUEST["cid"]);
    $form = $obj->getForm();
    $form->display();
    break;

case "delete_category":
    $xoops = Xoops::getInstance();
    $xoops->header();
    $obj = $alumni_categories_Handler->get($_REQUEST["cid"]);
    if (isset($_REQUEST["ok"]) && $_REQUEST["ok"] == 1) {
        if (!$GLOBALS["xoopsSecurity"]->check()) {
            $xoops->redirect("alumni_categories.php", 3, implode(",", $GLOBALS["xoopsSecurity"]->getErrors()));
        }
        if ($alumni_categories_Handler->delete($obj)) {
            $xoops->redirect("alumni_categories.php", 3, _AM_ALUMNI_FORMDELOK);
        } else {
            echo $obj->getHtmlErrors();
        }
    } else {
        $xoops->confirm(array("ok" => 1, "cid" => $_REQUEST["cid"], "op" => "delete_category"), $_SERVER["REQUEST_URI"], sprintf(_AM_ALUMNI_FORMSUREDEL, $obj->getVar("category")));
    }
    break;
}

$xoops->footer();
