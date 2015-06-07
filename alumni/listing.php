<?php
//  -----------------------------------------------------------------------  //
//                           Alumni for Xoops 2.6.x                           //
//                               By John Mordo                               //
//                                                                           //
//                                                                           //
//                                                                           //
// ------------------------------------------------------------------------- //
// Author: John Mordo - jlm69                                    //
// Author Website : jlmzone.com                          //
// Licence Type   : GPL                                                      //
// ------------------------------------------------------------------------- //
include __DIR__ . '/header.php';

$moduleDirName = basename(__DIR__);
$main_lang = '_MA_' . strtoupper($moduleDirName);
require_once(XOOPS_ROOT_PATH . "/modules/{$moduleDirName}/include/gtickets.php");
$myts      = MyTextSanitizer::getInstance();
$xoops     = Xoops::getInstance();
$module_id = $xoopsModule->getVar('mid');

if (is_object($xoopsUser)) {
    $groups = $xoopsUser->getGroups();
} else {
    $groups = XOOPS_GROUP_ANONYMOUS;
}
$gperm_handler = $xoops->getHandler('groupperm');
if (isset($_POST['item_id'])) {
    $perm_itemid = (int)($_POST['item_id']);
} else {
    $perm_itemid = 0;
}
//If no access
if (!$gperm_handler->checkRight('' . $moduleDirName . '_view', $perm_itemid, $groups, $module_id)) {
    $xoops->redirect(XOOPS_URL . '/index.php', 3, _NOPERM);
    exit();
}
if (!$gperm_handler->checkRight('' . $moduleDirName . '_premium', $perm_itemid, $groups, $module_id)) {
    $prem_perm = '0';
} else {
    $prem_perm = '1';
}
if (isset($_REQUEST['lid'])) {
    $lid = (int)($_REQUEST['lid']);
    $lid = ((int)($lid) > 0) ? (int)($lid) : 0;
}
$xoops->header('module:alumni/alumni_item.tpl');
Xoops::getInstance()->header();
//$xoops->tpl() = $xoops->tpl();
include(XOOPS_ROOT_PATH . '/class/pagenav.php');

if (isset($_REQUEST['op'])) {
    $op = $_REQUEST['op'];
} else {
    $op = 'list';
}

switch ($op) {
    case 'list':
    default:
        $listing_Handler = $xoops->getModuleHandler('alumni_listing', 'alumni');


        $alumni     = Alumni::getInstance();
        $module_id  = $xoops->module->getVar('mid');
        $listingObj = $listing_Handler->get($lid);

        $alumni_categories_Handler = $xoops->getModuleHandler('alumni_categories', 'alumni');
        $catObj                    = $alumni_categories_Handler->get($listingObj->getVar('cid'));

        $homePath         = "<a href='" . ALUMNI_URL . "/index.php'>" . constant($main_lang . '_MAIN') . "</a>&nbsp;:&nbsp;";
        $itemPath         = "<a href='" . ALUMNI_URL . "/categories.php?cid=" . $catObj->getVar("cid") . "'>" . $catObj->getVar("title") . "</a>";
        $path             = '';
        $myParent         = $catObj->getVar('pid');
        $catpath_criteria = new CriteriaCompo();
        $catpath_criteria->add(new Criteria('cid', $myParent, '='));
        $catpath_arr = $alumni_categories_Handler->getall($catpath_criteria);
        foreach (array_keys($catpath_arr) as $i) {
            $mytitle = $catpath_arr[$i]->getVar('title');
        }

        if ($myParent != 0) {
            $path = "<a href='" . ALUMNI_URL . "/categories.php?cid=" . $catpath_arr[$i]->getVar("cid") . "'>" . $catpath_arr[$i]->getVar("title") . "</a>&nbsp;:&nbsp;{$path}";
        }

        $path = "{$homePath}{$path}{$itemPath}";
        $path = str_replace("&nbsp;:&nbsp;", " <img src='" . XOOPS_URL . "/modules/alumni/images/arrow.gif" . "' style='border-width: 0px;' alt='' /> ", $path);

        $xoops->tpl()->assign('category_path', $path);


        // get permitted id
        $groups     = $xoops->isUser() ? $xoops->user->getGroups() : XOOPS_GROUP_ANONYMOUS;
        $alumni_ids = $alumni->getGrouppermHandler()->getItemIds('alumni_view', $groups, $module_id);
        $criteria   = new CriteriaCompo();
        $criteria->add(new Criteria('lid', $lid, '='));
        $criteria->add(new Criteria('cid', '(' . implode(', ', $alumni_ids) . ')', 'IN'));
        $numrows     = $listing_Handler->getCount();
        $listing_arr = $listing_Handler->getall($criteria);

        foreach (array_keys($listing_arr) as $i) {
            $lid        = $listing_arr[$i]->getVar('lid');
            $cid        = $listing_arr[$i]->getVar('cid');
            $name       = $listing_arr[$i]->getVar('name');
            $mname      = $listing_arr[$i]->getVar('mname');
            $lname      = $listing_arr[$i]->getVar('lname');
            $school     = $listing_arr[$i]->getVar('school');
            $year       = $listing_arr[$i]->getVar('year');
            $studies    = $listing_arr[$i]->getVar('studies');
            $activities = $listing_arr[$i]->getVar('activities');
            $extrainfo  = $listing_arr[$i]->getVar('extrainfo');
            $occ        = $listing_arr[$i]->getVar('occ');
            $date       = $listing_arr[$i]->getVar('date');
            $date       = XoopsLocale::formatTimestamp($date, 's');
            $email      = $listing_arr[$i]->getVar('email');
            $submitter  = $listing_arr[$i]->getVar('submitter');
            $usid       = $listing_arr[$i]->getVar('usid');
            $town       = $listing_arr[$i]->getVar('town');
            $valid      = $listing_arr[$i]->getVar('valid');
            $photo      = $listing_arr[$i]->getVar('photo');
            $photo2     = $listing_arr[$i]->getVar('photo2');
            $view       = $listing_arr[$i]->getVar('view');

            $recordexist = false;

            if ($lid != 0) {

                $recordexist = true;
            }

            $xoops->tpl()->assign('add_from', constant($main_lang . '_ADDFROM') . ' ' . $xoopsConfig['sitename']);
            $xoops->tpl()->assign('add_from_title', constant($main_lang . '_ADDFROM'));
            $xoops->tpl()->assign('add_from_sitename', $xoopsConfig['sitename']);
            $xoops->tpl()->assign('class_of', constant($main_lang . '_CLASSOF'));
            $xoops->tpl()->assign('listing_exists', $recordexist);
            $count = 0;
            $x     = 0;
            $i     = 0;

            $printA = "<a href=\"print.php?op=PrintAlum&amp;lid=" . addslashes($lid) . "\" target=\"_blank\"><img src=\"images/print.gif\" border=0 alt=\"" . constant($main_lang . '_PRINT') . "\" width=15 height=11 /></a>&nbsp;";
            $mailA  = "<a href=\"sendfriend.php?op=SendFriend&amp;lid=$lid\"><img src=\"../{$moduleDirName}/images/friend.gif\" border=\"0\" alt=\"" . constant($main_lang . '_FRIENDSEND') . "\" width=\"15\" height=\"11\" /></a>";
            if ($usid > 0) {
                $xoops->tpl()->assign('submitter', constant($main_lang . '_FROM') . "<a href='" . XOOPS_URL . "/userinfo.php?uid=" . addslashes($usid) . "'>$submitter</a>");
            } else {
                $xoops->tpl()->assign('submitter', constant($main_lang . '_FROM') . "$submitter");
            }

            $xoops->tpl()->assign('print', '$printA');
            $xoops->tpl()->assign('sfriend', '$mailA');
            $xoops->tpl()->assign('read', '$view ' . constant($main_lang . '_VIEW2'));

            if ($xoops->isUser()) {
                $calusern = $xoops->user->getVar('uid', 'E');
                if ($usid == $calusern) {
                    $xoops->tpl()->assign('modify', "<a href=\"listing.php?op=edit_listing&amp;lid=" . addslashes($lid) . "\">" . constant($main_lang . '_MODIFY') . "</a>  |  <a href=\"listing.php?op=delete_listing&amp;lid=" . addslashes($lid) . "\">" . constant($main_lang . '_DELETE') . "</a>");
                }
                if ($xoops->user->isAdmin()) {
                    $xoops->tpl()->assign('admin', "<a href=\"admin/alumni.php?op=edit_listing&amp;lid=" . addslashes($lid) . "\"><img src=\"images/modif.gif\" border=0 alt=\"" . constant($main_lang . '_MODADMIN') . "\" /></a>");
                }
            }

            $activities1 = $myts->displayTarea($activities, 1, 0, 1, 1, 0);

            $xoops->tpl()->assign('name', $name);
            $xoops->tpl()->assign('mname', $mname);
            $xoops->tpl()->assign('lname', $lname);
            $xoops->tpl()->assign('school', $school);
            $xoops->tpl()->assign('year', $year);
            $xoops->tpl()->assign('studies', $studies);
            $xoops->tpl()->assign('name_head', constant($main_lang . '_NAME2'));
            $xoops->tpl()->assign('class_of', constant($main_lang . '_CLASSOF'));
            $xoops->tpl()->assign('mname_head', constant($main_lang . '_MNAME'));
            $xoops->tpl()->assign('lname_head', constant($main_lang . '_LNAME'));
            $xoops->tpl()->assign('school_head', constant($main_lang . '_SCHOOL'));
            $xoops->tpl()->assign('year_head', constant($main_lang . '_YEAR'));
            $xoops->tpl()->assign('studies_head', constant($main_lang . '_STUDIES'));
            $xoops->tpl()->assign('local_town', $town);
            $xoops->tpl()->assign('local_head', constant($main_lang . '_LOCAL'));
            $xoops->tpl()->assign('alumni_mustlogin', constant($main_lang . '_MUSTLOGIN'));
            $xoops->tpl()->assign('photo_head', constant($main_lang . '_GPHOTO'));
            $xoops->tpl()->assign('photo2_head', constant($main_lang . '_RPHOTO2'));
            $xoops->tpl()->assign('activities', $activities1);
            $xoops->tpl()->assign('extrainfo', $myts->displayTarea($extrainfo, 1));
            $xoops->tpl()->assign('activities_head', constant($main_lang . '_ACTIVITIES'));
            $xoops->tpl()->assign('extrainfo_head', constant($main_lang . '_EXTRAINFO'));

            if ($email) {
                $xoops->tpl()->assign('contact_head', constant($main_lang . '_CONTACT'));
                $xoops->tpl()->assign('contact_email', "<a href=\"contact.php?lid=$lid\">" . constant($main_lang . '_BYMAIL2') . "</a>");
            }
            $xoops->tpl()->assign('contact_occ_head', constant($main_lang . '_OCC'));
            $xoops->tpl()->assign('contact_occ', '$occ');

            $xoops->tpl()->assign('photo', '');
            $xoops->tpl()->assign('photo2', '');


            if ($photo) {
                $xoops->tpl()->assign('photo', "<img src=\"photos/grad_photo/$photo\" alt=\"\" width=\"125\"/>");
            }
            if ($photo2) {
                $xoops->tpl()->assign('photo2', "<img src=\"photos/now_photo/$photo2\" alt=\"\" width=\"125\" />");
            }
            $xoops->tpl()->assign('date', constant($main_lang . '_DATE2') . " $date ");

            $xoops->tpl()->assign('link_main', "<a href=\"../{$moduleDirName}/\">" . constant($main_lang . '_MAIN') . '</a>');
        }
        $xoops->tpl()->assign('no_listing', 'no listing');


        break;

    case 'new_listing':
        $xoops->header();
        $module_id = $xoopsModule->getVar('mid');
        if (is_object($xoopsUser)) {
            $groups = $xoopsUser->getGroups();
        } else {
            $groups = XOOPS_GROUP_ANONYMOUS;
        }
        $gperm_handler = $xoops->getHandler('groupperm');
        if (isset($_POST['item_id'])) {
            $perm_itemid = (int)($_POST['item_id']);
        } else {
            $perm_itemid = 0;
        }
        //If no access
        if (!$gperm_handler->checkRight('' . $moduleDirName . '_view', $perm_itemid, $groups, $module_id)) {
            $xoops->redirect(XOOPS_URL . '/index.php', 3, _NOPERM);
            exit();
        }
        $obj    = $listing_Handler->create();
        $new_id = $listing_Handler->get_new_id();
        $form   = $obj->getForm();
        $form->display();
        break;

    case 'save_listing':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $xoops->redirect('index.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if ($xoops->getModuleConfig('alumni_use_captcha') == '1' & !$xoops->user->isAdmin()) {
            $xoopsCaptcha = XoopsCaptcha::getInstance();
            if (!$xoopsCaptcha->verify()) {
                $xoops->redirect('javascript:history.go(-1)', 4, $xoopsCaptcha->getMessage());
                exit(0);
            }
        }

        if (isset($_REQUEST['lid'])) {
            $obj = $listing_Handler->get($_REQUEST['lid']);
            $obj->setVar('date', $_REQUEST['date']);

        } else {
            $obj = $listing_Handler->create();
            $obj->setVar('date', time());
            $lid = '0';
        }

        $destination = XOOPS_ROOT_PATH . "/modules/{$moduleDirName}/photos/grad_photo";
        if (isset($_REQUEST['del_photo'])) {
            if ($_REQUEST['del_photo'] == '1') {
                if (@file_exists('' . $destination . '/' . $_REQUEST['photo_old'] . '')) {
                    unlink('' . $destination . '/' . $_REQUEST['photo_old'] . '');
                }
                $obj->setVar('photo', '');
            }
        }
        $destination2 = XOOPS_ROOT_PATH . "/modules/{$moduleDirName}/photos/now_photo";
        if (isset($_REQUEST['del_photo2'])) {
            if ($_REQUEST['del_photo2'] == '1') {
                if (@file_exists('' . $destination2 . '/' . $_REQUEST['photo2_old'] . '')) {
                    unlink('' . $destination2 . '/' . $_REQUEST['photo2_old'] . '');
                }
                $obj->setVar('photo2', '');
            }
        }

        if (isset($_REQUEST['lid'])) {
            $obj->setVar('lid', $_REQUEST['lid']);
        }
        $obj->setVar('cid', $_REQUEST['cid']);
        $obj->setVar('name', $_REQUEST['name']);
        $obj->setVar('mname', $_REQUEST['mname']);
        $obj->setVar('lname', $_REQUEST['lname']);
        $obj->setVar('school', $_REQUEST['school']);
        $obj->setVar('year', $_REQUEST['year']);
        $obj->setVar('studies', $_REQUEST['studies']);
        $obj->setVar('activities', $_REQUEST['activities']);
        $obj->setVar('extrainfo', $_REQUEST['extrainfo']);
        $obj->setVar('occ', $_REQUEST['occ']);
        $obj->setVar('email', $_REQUEST['email']);
        $obj->setVar('submitter', $_REQUEST['submitter']);
        $obj->setVar('usid', $_REQUEST['usid']);
        $obj->setVar('town', $_REQUEST['town']);

        if ($xoops->getModuleConfig('alumni_moderated') == '1') {
            $obj->setVar('valid', '0');
        } else {
            $obj->setVar('valid', '1');
        }

        $date = time();

        if (!empty($_FILES['photo']['name'])) {
            include_once XOOPS_ROOT_PATH . '/class/uploader.php';
            $uploaddir         = XOOPS_ROOT_PATH . '/modules/alumni/photos/grad_photo';
            $photomax          = $xoops->getModuleConfig('alumni_photomax');
            $maxwide           = $xoops->getModuleConfig('alumni_maxwide');
            $maxhigh           = $xoops->getModuleConfig('alumni_maxhigh');
            $allowed_mimetypes = array('image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png');
            $uploader          = new XoopsMediaUploader($uploaddir, $allowed_mimetypes, $photomax, $maxwide, $maxhigh);
            if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
                $uploader->setTargetFileName($date . '_' . $_FILES['photo']['name']);
                $uploader->fetchMedia($_POST['xoops_upload_file'][0]);
                if (!$uploader->upload()) {
                    $errors = $uploader->getErrors();
                    $xoops->redirect('javascript:history.go(-1)', 3, $errors);
                } else {
                    $obj->setVar('photo', $uploader->getSavedFileName());
                }
            } else {
                $obj->setVar('photo', $_REQUEST['photo']);
            }
        }

        if (!empty($_FILES['photo2']['name'])) {
            include_once XOOPS_ROOT_PATH . '/class/uploader.php';
            $uploaddir2        = XOOPS_ROOT_PATH . '/modules/alumni/photos/now_photo';
            $photomax          = $xoops->getModuleConfig('alumni_photomax');
            $maxwide           = $xoops->getModuleConfig('alumni_maxwide');
            $maxhigh           = $xoops->getModuleConfig('alumni_maxhigh');
            $allowed_mimetypes = array('image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png');
            $uploader2         = new XoopsMediaUploader($uploaddir2, $allowed_mimetypes, $photomax, $maxwide, $maxhigh);
            if ($uploader2->fetchMedia($_POST['xoops_upload_file'][1])) {
                $uploader2->setTargetFileName($date . '_' . $_FILES['photo2']['name']);
                $uploader2->fetchMedia($_POST['xoops_upload_file'][1]);
                if (!$uploader2->upload()) {
                    $errors = $uploader2->getErrors();
                    $xoops->redirect('javascript:history.go(-1)', 3, $errors);
                } else {
                    $obj->setVar('photo2', $uploader2->getSavedFileName());
                }
            } else {
                $obj->setVar('photo2', $_REQUEST['photo2']);
            }
        }

        if ($new_id = $listing_Handler->insert($obj)) {
            if ($xoops->getModuleConfig('alumni_moderated') == '1') {
                $xoops->redirect('index.php', 3, constant($main_lang . '_MODERATE'));
            } else {
                $xoops->redirect('listing.php?lid=$new_id', 3, constant($main_lang . '_NOMODERATE'));
            }
            //notifications
            if ($lid == 0 && $xoops->isActiveModule('notifications')) {
                $notification_handler = Notifications::getInstance()->getHandlerNotification();
                $tags                 = array();
                $tags['MODULE_NAME']  = 'alumni';
                $tags['ITEM_NAME']    = $request->asStr('lname', '');
                $tags['ITEM_URL']     = XOOPS_URL . '/modules/alumni/listing.php?lid=' . $new_id;
                $notification_handler->triggerEvent('global', 0, 'new_listing', $tags);
                $notification_handler->triggerEvent('category', $new_id, 'new_listing', $tags);
            }
        }

        echo $obj->getHtmlErrors();
        $form = $obj->getForm();
        $form->display();
        break;

    case 'edit_listing':
        $obj  = $listing_Handler->get($_REQUEST['lid']);
        $form = $obj->getForm();
        $form->display();
        break;

    case 'delete_listing':
        $obj = $listing_Handler->get($_REQUEST['lid']);
        if (isset($_REQUEST['ok']) && $_REQUEST['ok'] == 1) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                $xoops->redirect('index.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($listing_Handler->delete($obj)) {
                $xoops->redirect('index.php', 3, constant($main_lang . '_FORMDELOK'));
            } else {
                echo $obj->getHtmlErrors();
            }
        } else {
            $xoops->confirm(array('ok' => 1, 'lid' => $_REQUEST['lid'], 'op' => 'delete_listing'), $_SERVER['REQUEST_URI'], sprintf(constant($main_lang . '_FORMSUREDEL'), $obj->getVar('lid')));
        }
        break;
}

Xoops::getInstance()->footer();
