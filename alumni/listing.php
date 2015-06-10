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

use Xoops\Core\Request;

include __DIR__ . '/header.php';

$moduleDirName = basename(__DIR__);
$mainLang      = '_MA_' . strtoupper($moduleDirName);
require_once(XOOPS_ROOT_PATH . "/modules/{$moduleDirName}/include/gtickets.php");
$myts     = MyTextSanitizer::getInstance();
$xoops    = Xoops::getInstance();
$moduleId = $xoopsModule->getVar('mid');

if (is_object($xoopsUser)) {
    $groups = $xoopsUser->getGroups();
} else {
    $groups = XOOPS_GROUP_ANONYMOUS;
}
$groupPermHandler = $xoops->getHandler('groupperm');
if (isset($_POST['item_id'])) {
    $perm_itemid = (int)($_POST['item_id']);
} else {
    $perm_itemid = 0;
}
//If no access
if (!$groupPermHandler->checkRight('' . $moduleDirName . '_view', $perm_itemid, $groups, $moduleId)) {
    $xoops->redirect(XOOPS_URL . '/index.php', 3, _NOPERM);
    exit();
}
if (!$groupPermHandler->checkRight('' . $moduleDirName . '_premium', $perm_itemid, $groups, $moduleId)) {
    $prem_perm = '0';
} else {
    $prem_perm = '1';
}
//if (isset($_REQUEST['lid'])) {
//    $lid = (int)($_REQUEST['lid']);
//    $lid = ((int)($lid) > 0) ? (int)($lid) : 0;
//}
$lid = Request::getInt('lid', 0, 'GET');
$xoops->header('module:alumni/alumni_item.tpl');
Xoops::getInstance()->header();
//$xoops->tpl() = $xoops->tpl();
include(XOOPS_ROOT_PATH . '/class/pagenav.php');

//if (isset($_REQUEST['op'])) {
//    $op = $_REQUEST['op'];
//} else {
//    $op = 'list';
//}
$op = Request::getCmd('op', Request::getCmd('op', 'list', 'GET'), 'POST');

switch ($op) {
    case 'list':
    default:
        $listingHandler = $xoops->getModuleHandler('alumni_listing', 'alumni');

        $alumni     = Alumni::getInstance();
        $moduleId   = $xoops->module->getVar('mid');
        $listingObj = $listingHandler->get($lid);

        $alumniCategoriesHandler = $xoops->getModuleHandler('alumni_categories', 'alumni');
        $catObj                  = $alumniCategoriesHandler->get($listingObj->getVar('cid'));

        $homePath        = "<a href='" . ALUMNI_URL . "/index.php'>" . constant($mainLang . '_MAIN') . "</a>&nbsp;:&nbsp;";
        $itemPath        = "<a href='" . ALUMNI_URL . "/categories.php?cid=" . $catObj->getVar("cid") . "'>" . $catObj->getVar("title") . "</a>";
        $path            = '';
        $myParent        = $catObj->getVar('pid');
        $catpathCriteria = new CriteriaCompo();
        $catpathCriteria->add(new Criteria('cid', $myParent, '='));
        $catpathArray = $alumniCategoriesHandler->getAll($catpathCriteria);
        foreach (array_keys($catpathArray) as $i) {
            $mytitle = $catpathArray[$i]->getVar('title');
        }

        if ($myParent != 0) {
            $path = "<a href='" . ALUMNI_URL . "/categories.php?cid=" . $catpathArray[$i]->getVar("cid") . "'>" . $catpathArray[$i]->getVar("title") . "</a>&nbsp;:&nbsp;{$path}";
        }

        $path = "{$homePath}{$path}{$itemPath}";
        $path = str_replace("&nbsp;:&nbsp;", " <img src='" . XOOPS_URL . "/modules/{$moduleDirName}/assets/images/arrow.gif" . "' style='border-width: 0px;' alt='' /> ", $path);

        $xoops->tpl()->assign('category_path', $path);

        // get permitted id
        $groups    = $xoops->isUser() ? $xoops->user->getGroups() : XOOPS_GROUP_ANONYMOUS;
        $alumniIds = $alumni->getGrouppermHandler()->getItemIds('alumni_view', $groups, $moduleId);
        $criteria  = new CriteriaCompo();
        $criteria->add(new Criteria('lid', $lid, '='));
        $criteria->add(new Criteria('cid', '(' . implode(', ', $alumniIds) . ')', 'IN'));
        $numrows      = $listingHandler->getCount();
        $listingArray = $listingHandler->getAll($criteria);

        foreach (array_keys($listingArray) as $i) {
            $lid        = $listingArray[$i]->getVar('lid');
            $cid        = $listingArray[$i]->getVar('cid');
            $name       = $listingArray[$i]->getVar('name');
            $mname      = $listingArray[$i]->getVar('mname');
            $lname      = $listingArray[$i]->getVar('lname');
            $school     = $listingArray[$i]->getVar('school');
            $year       = $listingArray[$i]->getVar('year');
            $studies    = $listingArray[$i]->getVar('studies');
            $activities = $listingArray[$i]->getVar('activities');
            $extrainfo  = $listingArray[$i]->getVar('extrainfo');
            $occ        = $listingArray[$i]->getVar('occ');
            $date       = $listingArray[$i]->getVar('date');
            $date       = XoopsLocale::formatTimestamp($date, 's');
            $email      = $listingArray[$i]->getVar('email');
            $submitter  = $listingArray[$i]->getVar('submitter');
            $usid       = $listingArray[$i]->getVar('usid');
            $town       = $listingArray[$i]->getVar('town');
            $valid      = $listingArray[$i]->getVar('valid');
            $photo      = $listingArray[$i]->getVar('photo');
            $photo2     = $listingArray[$i]->getVar('photo2');
            $view       = $listingArray[$i]->getVar('view');

            $recordexist = false;

            if ($lid != 0) {
                $recordexist = true;
            }

            $xoops->tpl()->assign('add_from', constant($mainLang . '_ADDFROM') . ' ' . $xoopsConfig['sitename']);
            $xoops->tpl()->assign('add_from_title', constant($mainLang . '_ADDFROM'));
            $xoops->tpl()->assign('add_from_sitename', $xoopsConfig['sitename']);
            $xoops->tpl()->assign('class_of', constant($mainLang . '_CLASSOF'));
            $xoops->tpl()->assign('listing_exists', $recordexist);
            $count = 0;
            $x     = 0;
            $i     = 0;

            $printA = "<a href=\"print.php?op=PrintAlum&amp;lid=" . addslashes($lid) . "\" target=\"_blank\"><img src=\"assets/images/print.gif\" border=0 alt=\"" . constant($mainLang . '_PRINT') . "\" width=15 height=11 /></a>&nbsp;";
            $mailA  = "<a href=\"sendfriend.php?op=SendFriend&amp;lid=$lid\"><img src=\"../{$moduleDirName}/assets/images/friend.gif\" border=\"0\" alt=\"" . constant($mainLang . '_FRIENDSEND') . "\" width=\"15\" height=\"11\" /></a>";
            if ($usid > 0) {
                $xoops->tpl()->assign('submitter', constant($mainLang . '_FROM') . "<a href='" . XOOPS_URL . "/userinfo.php?uid=" . addslashes($usid) . "'>$submitter</a>");
            } else {
                $xoops->tpl()->assign('submitter', constant($mainLang . '_FROM') . "$submitter");
            }

            $xoops->tpl()->assign('print', '$printA');
            $xoops->tpl()->assign('sfriend', '$mailA');
            $xoops->tpl()->assign('read', '$view ' . constant($mainLang . '_VIEW2'));

            if ($xoops->isUser()) {
                $calusern = $xoops->user->getVar('uid', 'E');
                if ($usid == $calusern) {
                    $xoops->tpl()->assign('modify', "<a href=\"listing.php?op=edit_listing&amp;lid=" . addslashes($lid) . "\">" . constant($mainLang . '_MODIFY') . "</a>  |  <a href=\"listing.php?op=delete_listing&amp;lid=" . addslashes($lid) . "\">" . constant($mainLang . '_DELETE') . "</a>");
                }
                if ($xoops->user->isAdmin()) {
                    $xoops->tpl()->assign('admin', "<a href=\"admin/alumni.php?op=edit_listing&amp;lid=" . addslashes($lid) . "\"><img src=\"assets/images/modif.gif\" border=0 alt=\"" . constant($mainLang . '_MODADMIN') . "\" /></a>");
                }
            }

            $activities1 = $myts->displayTarea($activities, 1, 0, 1, 1, 0);

            $xoops->tpl()->assign('name', $name);
            $xoops->tpl()->assign('mname', $mname);
            $xoops->tpl()->assign('lname', $lname);
            $xoops->tpl()->assign('school', $school);
            $xoops->tpl()->assign('year', $year);
            $xoops->tpl()->assign('studies', $studies);
            $xoops->tpl()->assign('name_head', constant($mainLang . '_NAME2'));
            $xoops->tpl()->assign('class_of', constant($mainLang . '_CLASSOF'));
            $xoops->tpl()->assign('mname_head', constant($mainLang . '_MNAME'));
            $xoops->tpl()->assign('lname_head', constant($mainLang . '_LNAME'));
            $xoops->tpl()->assign('school_head', constant($mainLang . '_SCHOOL'));
            $xoops->tpl()->assign('year_head', constant($mainLang . '_YEAR'));
            $xoops->tpl()->assign('studies_head', constant($mainLang . '_STUDIES'));
            $xoops->tpl()->assign('local_town', $town);
            $xoops->tpl()->assign('local_head', constant($mainLang . '_LOCAL'));
            $xoops->tpl()->assign('alumni_mustlogin', constant($mainLang . '_MUSTLOGIN'));
            $xoops->tpl()->assign('photo_head', constant($mainLang . '_GPHOTO'));
            $xoops->tpl()->assign('photo2_head', constant($mainLang . '_RPHOTO2'));
            $xoops->tpl()->assign('activities', $activities1);
            $xoops->tpl()->assign('extrainfo', $myts->displayTarea($extrainfo, 1));
            $xoops->tpl()->assign('activities_head', constant($mainLang . '_ACTIVITIES'));
            $xoops->tpl()->assign('extrainfo_head', constant($mainLang . '_EXTRAINFO'));

            if ($email) {
                $xoops->tpl()->assign('contact_head', constant($mainLang . '_CONTACT'));
                $xoops->tpl()->assign('contact_email', "<a href=\"contact.php?lid=$lid\">" . constant($mainLang . '_BYMAIL2') . "</a>");
            }
            $xoops->tpl()->assign('contact_occ_head', constant($mainLang . '_OCC'));
            $xoops->tpl()->assign('contact_occ', '$occ');

            $xoops->tpl()->assign('photo', '');
            $xoops->tpl()->assign('photo2', '');

            if ($photo) {
                $xoops->tpl()->assign('photo', "<img src=\"photos/grad_photo/$photo\" alt=\"\" width=\"125\"/>");
            }
            if ($photo2) {
                $xoops->tpl()->assign('photo2', "<img src=\"photos/now_photo/$photo2\" alt=\"\" width=\"125\" />");
            }
            $xoops->tpl()->assign('date', constant($mainLang . '_DATE2') . " $date ");

            $xoops->tpl()->assign('link_main', "<a href=\"../{$moduleDirName}/\">" . constant($mainLang . '_MAIN') . '</a>');
        }
        $xoops->tpl()->assign('no_listing', 'no listing');

        break;

    case 'new_listing':
        $xoops->header();
        $moduleId = $xoopsModule->getVar('mid');
        if (is_object($xoopsUser)) {
            $groups = $xoopsUser->getGroups();
        } else {
            $groups = XOOPS_GROUP_ANONYMOUS;
        }
        $groupPermHandler = $xoops->getHandler('groupperm');
        if (isset($_POST['item_id'])) {
            $perm_itemid = (int)($_POST['item_id']);
        } else {
            $perm_itemid = 0;
        }
        //If no access
        if (!$groupPermHandler->checkRight('' . $moduleDirName . '_view', $perm_itemid, $groups, $moduleId)) {
            $xoops->redirect(XOOPS_URL . '/index.php', 3, _NOPERM);
            exit();
        }
        $obj    = $listingHandler->create();
        $new_id = $listingHandler->get_new_id();
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

        if ($tempLid = Request::getInt('lid', null, 'GET')) {
            $obj = $listingHandler->get($tempLid);
            $obj->setVar('date', Request::getString('date', '', 'POST'));
        } else {
            $obj = $listingHandler->create();
            $obj->setVar('date', time());
            $lid = '0';
        }

        $destination = XOOPS_ROOT_PATH . "/modules/{$moduleDirName}/photos/grad_photo";
        if (1 == Request::getInt('del_photo', null, 'POST')) {
            if (@file_exists('' . $destination . '/' . Request::getString('photo_old', '', 'POST') . '')) {
                unlink('' . $destination . '/' . Request::getString('photo_old', '', 'POST') . '');
            }
            $obj->setVar('photo', '');
        }

        $destination2 = XOOPS_ROOT_PATH . "/modules/{$moduleDirName}/photos/now_photo";

        if (1 == Request::getInt('del_photo2', null, 'POST')) {
            if (@file_exists('' . $destination2 . '/' . Request::getString('photo_old2', '', 'POST') . '')) {
                unlink('' . $destination2 . '/' . Request::getString('photo_old2', '', 'POST') . '');
            }
            $obj->setVar('photo2', '');
        }

        if ($tempLid = Request::getInt('lid', null, 'POST')) {
            $obj->setVar('lid', $tempLid);
        }

        $obj->setVar('cid', Request::getInt('cid', null, 'POST')); //$_REQUEST['cid']);
        $obj->setVar('name', Request::getString('name', '', 'POST')); //$_REQUEST['name']);
        $obj->setVar('mname', Request::getString('mname', '', 'POST')); //$_REQUEST['mname']);
        $obj->setVar('lname', Request::getString('lname', '', 'POST')); //$_REQUEST['lname']);
        $obj->setVar('school', Request::getString('school', '', 'POST')); //$_REQUEST['year']); $cat_name);
        $obj->setVar('year', Request::getString('year', '', 'POST')); //$_REQUEST['year']);
        $obj->setVar('studies', Request::getString('studies', '', 'POST')); //$_REQUEST['studies']);
        $obj->setVar('activities', Request::getString('activities', '', 'POST')); //$_REQUEST['activities']);
        $obj->setVar('extrainfo', Request::getString('extrainfo', '', 'POST')); //$_REQUEST['extrainfo']);
        $obj->setVar('occ', Request::getString('occ', '', 'POST')); //$_REQUEST['occ']);
        $obj->setVar('email', Request::getString('email', '', 'POST')); //$_REQUEST['email']);
        $obj->setVar('submitter', Request::getString('submitter', '', 'POST')); //$_REQUEST['submitter']);
        $obj->setVar('usid', Request::getInt('usid', null, 'POST')); //$_REQUEST['usid']);
        $obj->setVar('town', Request::getString('town', '', 'POST')); //$_REQUEST['town']);

        if ($xoops->getModuleConfig('alumni_moderated') == '1') {
            $obj->setVar('valid', '0');
        } else {
            $obj->setVar('valid', '1');
        }

        $date = time();

        if (!empty($_FILES['photo']['name'])) {
            include_once XOOPS_ROOT_PATH . '/class/uploader.php';
            $uploaddir        = XOOPS_ROOT_PATH . '/modules/alumni/photos/grad_photo';
            $photomax         = $xoops->getModuleConfig('alumni_photomax');
            $maxwide          = $xoops->getModuleConfig('alumni_maxwide');
            $maxhigh          = $xoops->getModuleConfig('alumni_maxhigh');
            $allowedMimetypes = array('image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png');
            $uploader         = new XoopsMediaUploader($uploaddir, $allowedMimetypes, $photomax, $maxwide, $maxhigh);
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
                $obj->setVar('photo', Request::getString('photo', '', 'POST'));
            }
        }

        if (!empty($_FILES['photo2']['name'])) {
            include_once XOOPS_ROOT_PATH . '/class/uploader.php';
            $uploaddir2       = XOOPS_ROOT_PATH . '/modules/alumni/photos/now_photo';
            $photomax         = $xoops->getModuleConfig('alumni_photomax');
            $maxwide          = $xoops->getModuleConfig('alumni_maxwide');
            $maxhigh          = $xoops->getModuleConfig('alumni_maxhigh');
            $allowedMimetypes = array('image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png');
            $uploader2        = new XoopsMediaUploader($uploaddir2, $allowedMimetypes, $photomax, $maxwide, $maxhigh);
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
                $obj->setVar('photo2', Request::getString('photo2', '', 'POST'));
            }
        }

        if ($new_id = $listingHandler->insert($obj)) {
            if ($xoops->getModuleConfig('alumni_moderated') == '1') {
                $xoops->redirect('index.php', 3, constant($mainLang . '_MODERATE'));
            } else {
                $xoops->redirect('listing.php?lid=$new_id', 3, constant($mainLang . '_NOMODERATE'));
            }
            //notifications
            if ($lid == 0 && $xoops->isActiveModule('notifications')) {
                $notificationHandler = Notifications::getInstance()->getHandlerNotification();
                $tags                = array();
                $tags['MODULE_NAME'] = 'alumni';
                $tags['ITEM_NAME']   = Request::getString('lname', '', 'POST');
                $tags['ITEM_URL']    = XOOPS_URL . '/modules/alumni/listing.php?lid=' . $new_id;
                $notificationHandler->triggerEvent('global', 0, 'new_listing', $tags);
                $notificationHandler->triggerEvent('category', $new_id, 'new_listing', $tags);
            }
        }

        echo $obj->getHtmlErrors();
        $form = $obj->getForm();
        $form->display();
        break;

    case 'edit_listing':
        $obj  = $listingHandler->get(Request::getInt('lid', 0, 'GET'));
        $form = $obj->getForm();
        $form->display();
        break;

    case 'delete_listing':
        $obj = $listingHandler->get(Request::getInt('lid', 0, 'GET'));
        if (1 == Request::getInt('ok', null, 'POST')) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                $xoops->redirect('index.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($listingHandler->delete($obj)) {
                $xoops->redirect('index.php', 3, constant($mainLang . '_FORMDELOK'));
            } else {
                echo $obj->getHtmlErrors();
            }
        } else {
            $xoops->confirm(array('ok' => 1, 'lid' => Request::getInt('lid', 0, 'GET'), 'op' => 'delete_listing'), Request::getString('REQUEST_URI', '', 'SERVER'), sprintf(constant($mainLang . '_FORMSUREDEL'), $obj->getVar('lid')));
        }
        break;
}

Xoops::getInstance()->footer();
