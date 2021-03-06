<?php
//                 Alumni for Xoops 2.5.5 and up  by John Mordo - jlm69 at Xoops              //
//                                                                                           //
// include_once '../../../include/cp_header.php';

use Xoops\Core\Request;

include __DIR__ . '/admin_header.php';
$moduleDirName = basename(dirname(__DIR__));
include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
$myts  = MyTextSanitizer::getInstance();
$xoops = Xoops::getInstance();

//$op = 'list';
//if (isset($_REQUEST['op'])) {
//    $op = $_REQUEST['op'];
//}
$op = Request::getCmd('op', Request::getCmd('op', 'list', 'GET'), 'POST');

switch ($op) {
    case 'list':
    default:
        $xoops->header('admin:alumni/alumni_admin_listing.tpl');
        $indexAdmin = new Xoops\Module\Admin();
        $indexAdmin->displayNavigation('alumni.php');

        $xoTheme->addScript(ALUMNI_URL . '/media/jquery/jquery-1.8.3.min.js');
        $xoTheme->addScript(ALUMNI_URL . '/media/jquery/tablesorter-master/js/jquery.tablesorter.js');
        $xoTheme->addScript(ALUMNI_URL . '/media/jquery/tablesorter-master/addons/pager/jquery.tablesorter.pager.js');
        $xoTheme->addScript(ALUMNI_URL . '/media/jquery/tablesorter-master/js/jquery.tablesorter.widgets.js');
        $xoTheme->addScript(ALUMNI_URL . '/media/jquery/pager-custom-controls.js');
        $xoTheme->addScript(ALUMNI_URL . '/media/jquery/myAdminjs.js');
        $xoTheme->addStylesheet(ALUMNI_URL . '/media/jquery/css/theme.blue.css');
        $xoTheme->addStylesheet(ALUMNI_URL . '/media/jquery/tablesorter-master/addons/pager/jquery.tablesorter.pager.css');

        $indexAdmin->addItemButton(AlumniLocale::A_ADD_LISTING, 'alumni.php?op=new_listing', 'add');

        if ('1' == $xoops->getModuleConfig('alumni_moderated')) {
            $indexAdmin->addItemButton(AlumniLocale::A_MODERATE_LISTING, 'alumni.php?op=list_moderated', 'add');
        }

        $indexAdmin->renderButton('left', '');

        $listingCount = $listingHandler->countAlumni();
        $listingArray = $listingHandler->getAll();

        // Assign Template variables
        $xoops->tpl()->assign('listingCount', $listingCount);
        if ($listingCount > 0) {
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
                $email      = $listingArray[$i]->getVar('email');
                $submitter  = $listingArray[$i]->getVar('submitter');
                $usid       = $listingArray[$i]->getVar('usid');
                $town       = $listingArray[$i]->getVar('town');
                $valid      = $listingArray[$i]->getVar('valid');
                $photo      = $listingArray[$i]->getVar('photo');
                $photo2     = $listingArray[$i]->getVar('photo2');
                $view       = $listingArray[$i]->getVar('view');

                $xoops->tpl()->assign('cat', $cid);

                $listing = array();
                $name    = $myts->undoHtmlSpecialChars($name);
                $mname   = $myts->undoHtmlSpecialChars($mname);
                $lname   = $myts->undoHtmlSpecialChars($lname);
                $school  = $myts->undoHtmlSpecialChars($school);
                $year    = $myts->htmlSpecialChars($year);

                $useroffset = '';
                $newcount   = $xoops->getModuleConfig('' . $moduleDirName . '_countday');
                $startdate  = (time() - (86400 * $newcount));
                if ($startdate < $date) {
                    $newitem        = "<img src=\"" . XOOPS_URL . "/modules/{$moduleDirName}/assets/images/newred.gif\" />";
                    $listing['new'] = $newitem;
                }
                if ($xoops->user) {
                    $timezone = $xoops->user->timezone();
                    if (null !== $timezone) {
                        $useroffset = $xoops->user->timezone();
                    } else {
                        $useroffset = $xoopsConfig['default_TZ'];
                    }
                }
                $date = ($useroffset * 3600) + $date;
                $date = XoopsLocale::formatTimestamp($date, 's');

                $listing['lid']       = $lid;
                $listing['name']      = "<a href='../listing.php?lid=$lid'><b>$name&nbsp;$mname&nbsp;$lname</b></a>";
                $listing['school']    = $school;
                $listing['year']      = $year;
                $listing['submitter'] = $submitter;
                $listing['date']      = $date;
                $listing['valid']     = $valid;
                $listing['view']      = $view;

                $cat = addslashes($cid);

                $listing['views'] = $view;
                $xoops->tpl()->append('listing', $listing);
                $xoops->tpl()->assign('valid', AlumniLocale::A_APPROVE);
                $xoops->tpl()->assign('school', AlumniLocale::A_SCHOOL);
                $xoops->tpl()->assign('class_of', AlumniLocale::A_CLASS_OF);
            }
            unset($listing);
            $xoops->tpl()->assign('error_message', '');
        } else {
            $xoops->tpl()->assign('error_message', AlumniLocale::E_NO_LISTING);
        }
        break;

    case 'new_listing':
        //    xoops_cp_header();

        //$alumniListingHandler = $xoops->getModuleHandler('Listing', $moduleDirName);

        $xoops->header();
        $indexAdmin = new Xoops\Module\Admin();
        $indexAdmin->displayNavigation('alumni.php');
        $indexAdmin->addItemButton(constant($adminLang . '_CATEGORYLIST'), 'alumni.php');
        echo $indexAdmin->renderButton('left', '');
        $obj  = $listingHandler->create();
        $form = $obj->getAdminForm();
        $form->display();
        break;

    case 'save_listing':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $xoops->redirect('alumni.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }

        if ('1' == $xoops->getModuleConfig('alumni_use_captcha') && !$xoops->user->isAdmin()) {
            $xoopsCaptcha = XoopsCaptcha::getInstance();
            if (!$xoopsCaptcha->verify()) {
                $xoops->redirect(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/addlisting.php', 6, $xoopsCaptcha->getMessage());
                exit(0);
            }
        }

        $date = time();

        //        if (isset($_REQUEST['lid'])) {
        //            $obj = $listingHandler->get($_REQUEST['lid']);
        //            $obj->setVar('lid', $_REQUEST['lid']);
        //        } else {
        //            $obj = $listingHandler->create();
        //        }

        if ($tempLid = Request::getInt('lid', null, 'POST')) {
            $obj = $listingHandler->get($tempLid);
            $obj->setVar('lid', $lidTest);
        } else {
            $obj = $listingHandler->create();
        }

        $destination = XOOPS_ROOT_PATH . "/uploads/{$moduleDirName}/photos/grad_photo";

        if ('1' == Request::getInt('del_photo', null, 'POST')) {
//            if (@file_exists('' . $destination . '/' . Request::getString('photo_old', '', 'POST') . '')) {
            if(false !==  stream_resolve_include_path('' . $destination . '/' . Request::getString('photo_old', '', 'POST') . '')) {
                unlink('' . $destination . '/' . Request::getString('photo_old', '', 'POST') . '');
            }
            $obj->setVar('photo', '');
        }

        $destination2 = XOOPS_ROOT_PATH . "/uploads/{$moduleDirName}/photos/now_photo";
        if ('1' == Request::getInt('del_photo2', null, 'POST')) {
//            if (@file_exists('' . $destination2 . '/' . Request::getString('photo2_old', '', 'POST') . '')) {
            if (false !==  stream_resolve_include_path('' . $destination2 . '/' . Request::getString('photo2_old', '', 'POST') . '')) {
                unlink('' . $destination2 . '/' . Request::getString('photo_old2', '', 'POST') . '');
            }

            $obj->setVar('photo2', '');
        }

        if ($tempCid = Request::getInt('cid', null, 'POST')) {
            $cat_name                = '';
            // $alumniCategoryHandler = $xoops->getModuleHandler('Category', $moduleDirName);
            $catObj                  = $categoryHandler->get($tempCid);
            $cat_name                = $catObj->getVar('title');
        }

        $obj->setVar('cid', Request::getInt('cid', null, 'POST')); //$_REQUEST['cid']);
        $obj->setVar('name', Request::getString('name', '', 'POST')); //$_REQUEST['name']);
        $obj->setVar('mname', Request::getString('mname', '', 'POST')); //$_REQUEST['mname']);
        $obj->setVar('lname', Request::getString('lname', '', 'POST')); //$_REQUEST['lname']);
        $obj->setVar('school', $cat_name);
        $obj->setVar('year', Request::getString('year', '', 'POST')); //$_REQUEST['year']);
        $obj->setVar('studies', Request::getString('studies', '', 'POST')); //$_REQUEST['studies']);
        $obj->setVar('activities', Request::getString('activities', '', 'POST')); //$_REQUEST['activities']);
        $obj->setVar('extrainfo', Request::getString('extrainfo', '', 'POST')); //$_REQUEST['extrainfo']);
        $obj->setVar('occ', Request::getString('occ', '', 'POST')); //$_REQUEST['occ']);
        $obj->setVar('date', time());
        $obj->setVar('email', Request::getString('email', '', 'POST')); //$_REQUEST['email']);
        $obj->setVar('submitter', Request::getString('submitter', '', 'POST')); //$_REQUEST['submitter']);
        $obj->setVar('usid', Request::getInt('usid', null, 'POST')); //$_REQUEST['usid']);
        $obj->setVar('town', Request::getString('town', '', 'POST')); //$_REQUEST['town']);

        if ('1' == $xoops->getModuleConfig('alumni_moderate')) {
            $obj->setVar('valid', '0');
        } else {
            $obj->setVar('valid', '1');
        }

        if (!empty($_FILES['photo']['name'])) {
            include_once XOOPS_ROOT_PATH . '/class/uploader.php';
            $uploaddir        = XOOPS_ROOT_PATH . "/uploads/{$moduleDirName}/photos/grad_photo";
            $photomax         = $xoops->getModuleConfig('alumni_photomax');
            $maxwide          = $xoops->getModuleConfig('alumni_maxwide');
            $maxhigh          = $xoops->getModuleConfig('alumni_maxhigh');
            $allowedMimetypes = array('image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png');
            $uploader         = new XoopsMediaUploader($uploaddir, $allowedMimetypes, $photomax, $maxwide, $maxhigh);
            if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
                //       $uploader->setPrefix("pic_");
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
            $uploaddir2       = XOOPS_ROOT_PATH . "/uploads/{$moduleDirName}/photos/now_photo";
            $photomax         = $xoops->getModuleConfig('alumni_photomax');
            $maxwide          = $xoops->getModuleConfig('alumni_maxwide');
            $maxhigh          = $xoops->getModuleConfig('alumni_maxhigh');
            $allowedMimetypes = array('image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png');
            $uploader2        = new XoopsMediaUploader($uploaddir2, $allowedMimetypes, $photomax, $maxwide, $maxhigh);
            if ($uploader2->fetchMedia($_POST['xoops_upload_file'][1])) {
                //       $uploader2->setPrefix("pic_");
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

        if ($listingHandler->insert($obj)) {
            $xoops->redirect('alumni.php', 3, constant($adminLang . '_FORMOK'));

            //notifications
            if (0 == $lid && $xoops->isActiveModule('notifications')) {
                $notificationHandler = Notifications::getInstance()->getHandlerNotification();
                $tags                = array();
                $tags['MODULE_NAME'] = $moduleDirName;
                $tags['ITEM_NAME']   = Request::getString('lname', '', 'POST');
                $tags['ITEM_URL']    = XOOPS_URL . "/modules/{$moduleDirName}/listing.php?lid=" . $new_id;
                $notificationHandler->triggerEvent('global', 0, 'newlisting', $tags);
                $notificationHandler->triggerEvent('item', $new_id, 'newlisting', $tags);
            }
        }

        echo $obj->getHtmlErrors();
        $form = $obj->getAdminForm();
        $form->display();
        break;

    case 'edit_listing':
        $xoops->header();
        $indexAdmin = new Xoops\Module\Admin();
        $indexAdmin->addItemButton(constant($adminLang . '_ADD_LINK'), 'alumni.php?op=new_listing', 'add');
        $indexAdmin->addItemButton(constant($adminLang . '_LISTINGLIST'), 'alumni.php', 'list');
        echo $indexAdmin->renderButton('left', '');
        $obj  = $listingHandler->get(Request::getInt('lid', 0, 'GET'));
        $form = $obj->getAdminForm();
        $form->display();
        break;

    case 'delete_listing':
        $xoops->header();
        $obj = $listingHandler->get(Request::getInt('lid', 0, 'POST'));
        if (1 == Request::getInt('ok', null, 'POST')) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                $xoops->redirect('alumni.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($listingHandler->delete($obj)) {
                $xoops->redirect('alumni.php', 3, constant($adminLang . '_FORMDELOK'));
            } else {
                echo $obj->getHtmlErrors();
            }
        } else {
            $xoops->confirm(array('ok' => 1, 'lid' => Request::getInt('lid', 0, 'GET'), 'op' => 'delete_listing'), Request::getString('REQUEST_URI', '', 'SERVER'), sprintf(constant($adminLang . '_FORMSUREDEL'), $obj->getVar('lid')));
        }
        break;

    case 'update_status':
        $lid = Request::getInt('lid', 0, 'POST');
        if ($lid > 0) {
            $obj = $listingHandler->get($lid);
            $obj->setVar('valid', 1);
            if ($listingHandler->insert($obj)) {
                $xoops->redirect('alumni.php?op=list_moderated', 3, constant($adminLang . '_LISTING_VALIDATED'));
            }
            echo $obj->getHtmlErrors();
        }
        break;

    case 'list_moderated':
        $xoops->header('alumni_admin_moderated.tpl');
        $indexAdmin = new Xoops\Module\Admin();
        $indexAdmin->renderNavigation('alumni.php');

        $xoTheme->addScript(ALUMNI_URL . '/media/jquery/jquery-1.8.3.min.js');
        $xoTheme->addScript(ALUMNI_URL . '/media/jquery/tablesorter-master/js/jquery.tablesorter.js');
        $xoTheme->addScript(ALUMNI_URL . '/media/jquery/tablesorter-master/addons/pager/jquery.tablesorter.pager.js');
        $xoTheme->addScript(ALUMNI_URL . '/media/jquery/tablesorter-master/js/jquery.tablesorter.widgets.js');
        $xoTheme->addScript(ALUMNI_URL . '/media/jquery/pager-custom-controls.js');
        $xoTheme->addScript(ALUMNI_URL . '/media/jquery/myAdminjs.js');
        $xoTheme->addStylesheet(ALUMNI_URL . '/media/jquery/css/theme.blue.css');
        $xoTheme->addStylesheet(ALUMNI_URL . '/media/jquery/tablesorter-master/addons/pager/jquery.tablesorter.pager.css');

//        $listingHandler   = $xoops->getModuleHandler('Listing', 'alumni');
        $alumni           = Alumni::getInstance();
        $moduleId         = $xoops->module->getVar('mid');
        $groups           = $xoops->isUser() ? $xoops->user->getGroups() : SystemLocale::ANONYMOUS_USERS_GROUP;
        $alumniIds        = $alumni->getGrouppermHandler()->getItemIds('alumni_view', $groups, $moduleId);
        $moderateCriteria = new CriteriaCompo();
        $moderateCriteria->add(new Criteria('valid', 0, '='));
        $moderateCriteria->add(new Criteria('cid', '(' . implode(', ', $alumniIds) . ')', 'IN'));
        $listingCount = $listingHandler->getCount($moderateCriteria);
        $listingArray = $listingHandler->getAll($moderateCriteria);

        // Assign Template variables
        $xoops->tpl()->assign('listingCount', $listingCount);
        if ($listingCount > 0) {
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
                $email      = $listingArray[$i]->getVar('email');
                $submitter  = $listingArray[$i]->getVar('submitter');
                $usid       = $listingArray[$i]->getVar('usid');
                $town       = $listingArray[$i]->getVar('town');
                $valid      = $listingArray[$i]->getVar('valid');
                $photo      = $listingArray[$i]->getVar('photo');
                $photo2     = $listingArray[$i]->getVar('photo2');
                $view       = $listingArray[$i]->getVar('view');

                $xoops->tpl()->assign('cat', $cid);

                $listing = array();
                $name    = $myts->undoHtmlSpecialChars($name);
                $mname   = $myts->undoHtmlSpecialChars($mname);
                $lname   = $myts->undoHtmlSpecialChars($lname);
                $school  = $myts->undoHtmlSpecialChars($school);
                $year    = $myts->htmlSpecialChars($year);

                $useroffset = '';

                $newcount  = $xoops->getModuleConfig('' . $moduleDirName . '_countday');
                $startdate = (time() - (86400 * $newcount));
                if ($startdate < $date) {
                    $newitem        = "<img src=\"" . XOOPS_URL . "/modules/{$moduleDirName}/assets/images/newred.gif\" />";
                    $listing['new'] = $newitem;
                }
                if ($xoops->user) {
                    $timezone = $xoops->user->timezone();
                    if (null !== $timezone) {
                        $useroffset = $xoops->user->timezone();
                    } else {
                        $useroffset = $xoopsConfig['default_TZ'];
                    }
                }
                $date = ($useroffset * 3600) + $date;
                $date = XoopsLocale::formatTimestamp($date, 's');

                $listing['lid']        = $lid;
                $listing['name']       = "<a href='alumni.php?op=moderated_listing&amp;lid=$lid'><b>$name&nbsp;$mname&nbsp;$lname</b></a>";
                $listing['school']     = $school;
                $listing['year']       = $year;
                $listing['studies']    = $studies;
                $listing['activities'] = $activities;
                $listing['extrainfo']  = $extrainfo;
                $listing['occ']        = $occ;
                $listing['submitter']  = $submitter;
                $listing['date']       = $date;
                $listing['valid']      = $valid;
                $listing['view']       = $view;

                $cat = addslashes($cid);

                $listing['views'] = $view;
                $xoops->tpl()->append('listing', $listing);
                $xoops->tpl()->assign('valid', AlumniLocale::A_APPROVE);
                $xoops->tpl()->assign('school', AlumniLocale::A_SCHOOL);
                $xoops->tpl()->assign('class_of', AlumniLocale::A_CLASS_OF);
                $xoops->tpl()->assign('moderatedLang', AlumniLocale::A_MODERATED);
                $xoops->tpl()->assign('moderatedLang', XoopsLocale::A_EDIT);
                $xoops->tpl()->assign('studiesLang', AlumniLocale::A_STUDIES);
                $xoops->tpl()->assign('activitiesLang', AlumniLocale::A_ACTIVITIES);
                $xoops->tpl()->assign('extrainfoLang', AlumniLocale::A_EXTRAINFO);
                $xoops->tpl()->assign('occLang', AlumniLocale::A_OCC);
            }
            unset($listing);
        } else {
            $xoops->tpl()->assign('error_message', AlumniLocale::E_NO_LISTING_APPROVE);
        }

        break;

}
$xoops->footer();
