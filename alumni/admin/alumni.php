<?php
//                 Alumni for Xoops 2.5.5 and up  by John Mordo - jlm69 at Xoops              //
//                                                                                           //
// include_once '../../../include/cp_header.php';
include __DIR__ . '/admin_header.php';
$mydirname = basename(dirname(dirname(__FILE__)));
include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";
$myts = MyTextSanitizer::getInstance();
$xoops = Xoops::getInstance();

if (isset($_REQUEST['op'])){
$op = $_REQUEST['op'];}
else {
    $op = 'list';
}
  
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
        
        if ($xoops->getModuleConfig("alumni_moderated") == '1') {
        $indexAdmin->addItemButton(AlumniLocale::A_MODERATE_LISTING, 'alumni.php?op=list_moderated', 'add');
        }
        
        $indexAdmin->renderButton('left', '');

        $listing_count = $alumni_listing_Handler->countAlumni();
        $listing_arr = $alumni_listing_Handler->getall();

        // Assign Template variables
        $xoops->tpl()->assign('listing_count', $listing_count);
        if ($listing_count > 0) {
            foreach (array_keys($listing_arr) as $i) {

            $lid   = $listing_arr[$i]->getVar("lid");
            $cid   = $listing_arr[$i]->getVar("cid");
            $name = $listing_arr[$i]->getVar("name");
            $mname   = $listing_arr[$i]->getVar("mname");
            $lname   = $listing_arr[$i]->getVar("lname");
            $school    = $listing_arr[$i]->getVar("school");
            $year = $listing_arr[$i]->getVar("year");
            $studies = $listing_arr[$i]->getVar("studies");
            $activities = $listing_arr[$i]->getVar("activities");   
            $extrainfo = $listing_arr[$i]->getVar("extrainfo");
            $occ    = $listing_arr[$i]->getVar("occ"); 
            $date   = $listing_arr[$i]->getVar("date");
            $email   = $listing_arr[$i]->getVar("email");
            $submitter = $listing_arr[$i]->getVar("submitter");
            $usid   = $listing_arr[$i]->getVar("usid");
            $town   = $listing_arr[$i]->getVar("town");         
            $valid = $listing_arr[$i]->getVar("valid");
            $photo   = $listing_arr[$i]->getVar("photo");
            $photo2   = $listing_arr[$i]->getVar("photo2");
            $view   = $listing_arr[$i]->getVar("view");

	    $xoops->tpl()->assign('cat', $cid);
            
            $listing = array();
		$name = $myts->undoHtmlSpecialChars($name);
		$mname = $myts->undoHtmlSpecialChars($mname);
		$lname = $myts->undoHtmlSpecialChars($lname);
		$school = $myts->undoHtmlSpecialChars($school);
		$year = $myts->htmlSpecialChars($year);
		
		$useroffset = "";
		$newcount = $xoops->getModuleConfig("".$mydirname."_countday");
		$startdate = (time()-(86400 * $newcount));
		if ($startdate < $date) {
		$newitem = "<img src=\"".XOOPS_URL."/modules/$mydirname/images/newred.gif\" />";
		$listing['new'] = $newitem;
			}
		if($xoopsUser) {
			$timezone = $xoopsUser->timezone();
				if(isset($timezone)) {
					$useroffset = $xoopsUser->timezone();
				} else {
					$useroffset = $xoopsConfig['default_TZ'];
				}
			}
			$date = ($useroffset*3600) + $date;
			$date = XoopsLocale::formatTimestamp($date,'s');

			$listing['lid'] = $lid;
			$listing['name'] = "<a href='../listing.php?lid=$lid'><b>$name&nbsp;$mname&nbsp;$lname</b></a>";
			$listing['school'] = $school;
			$listing['year'] = $year;
			$listing['submitter'] = $submitter;
			$listing['date'] = $date;
			$listing['valid'] = $valid;
			$listing['view'] = $view;

			$cat = addslashes($cid);
			
			$listing['views'] = $view;
		$xoopsTpl->append('listing', $listing);
                $xoops->tpl()->assign('valid', AlumniLocale::A_APPROVE);
                $xoops->tpl()->assign('school', AlumniLocale::A_SCHOOL);
                $xoops->tpl()->assign('class_of', AlumniLocale::A_CLASS_OF);
             }   
                unset($listing);
	$xoops->tpl()->assign('error_message', "");
        } else {
            $xoops->tpl()->assign('error_message', AlumniLocale::E_NO_LISTING);
        }
        break;

case "new_listing":
//    xoops_cp_header();

//$alumni_listing_Handler = $xoops->getModuleHandler('alumni_listing', 'alumni');

    $xoops->header();
    $indexAdmin = new Xoops\Module\Admin();
    $indexAdmin->displayNavigation("alumni.php");
    $indexAdmin->addItemButton(_AM_ALUMNI_CATEGORYLIST, 'alumni.php');
    echo $indexAdmin->renderButton('left', '');
    $obj  = $alumni_listing_Handler->create();
    $form = $obj->getAdminForm();
    $form->display();
    break;

case "save_listing":
    if (!$GLOBALS["xoopsSecurity"]->check()) {
        $xoops->redirect("alumni.php", 3, implode(",", $GLOBALS["xoopsSecurity"]->getErrors()));
    }

    if ($xoops->getModuleConfig("alumni_use_captcha") == '1' & !$xoops->user->isAdmin()) {
    $xoopsCaptcha = XoopsCaptcha::getInstance();
    if (!$xoopsCaptcha->verify()) {
        $xoops->redirect( XOOPS_URL . "/modules/" . $xoopsModule->getVar('dirname') . "/addlisting.php", 6, $xoopsCaptcha->getMessage());
	exit(0);
}
	}

    $date = time();

    if (isset($_REQUEST["lid"])) {
        $obj = $alumni_listing_Handler->get($_REQUEST["lid"]);
        $obj->setVar("lid", $_REQUEST["lid"]);
    } else {
        $obj = $alumni_listing_Handler->create();
    }

  	$destination = XOOPS_ROOT_PATH."/modules/$mydirname/photos/grad_photo";
	if (isset($_REQUEST["del_photo"])) {
	if($_REQUEST["del_photo"] == "1"){
		if (@file_exists("".$destination."/".$_REQUEST['photo_old']."")) {
			 unlink("".$destination."/".$_REQUEST['photo_old']."");
		}
		$obj->setVar("photo", "");
	}
	}
	$destination2 = XOOPS_ROOT_PATH."/modules/$mydirname/photos/now_photo";
	if (isset($_REQUEST["del_photo2"])) {
	if($_REQUEST["del_photo2"] == "1"){
		if (@file_exists("".$destination2."/".$_REQUEST['photo2_old']."")) {
			 unlink("".$destination2."/".$_REQUEST['photo2_old']."");
		}
		
		$obj->setVar("photo2", "");
	}  
    } 

    if (isset($_REQUEST["cid"])) {
    $cat_name = '';
    $alumni_categories_Handler = $xoops->getModuleHandler('alumni_categories', 'alumni');
    $catObj = $alumni_categories_Handler->get($_REQUEST["cid"]);
    $cat_name = $catObj->getVar("title");
    }

            $obj->setVar("cid", $_REQUEST["cid"]);
            $obj->setVar("name", $_REQUEST["name"]);
            $obj->setVar("mname", $_REQUEST["mname"]);
            $obj->setVar("lname", $_REQUEST["lname"]);
            $obj->setVar("school", $cat_name);
            $obj->setVar("year", $_REQUEST["year"]);
            $obj->setVar("studies", $_REQUEST["studies"]);
            $obj->setVar("activities", $_REQUEST["activities"]);
            $obj->setVar("extrainfo", $_REQUEST["extrainfo"]);
            $obj->setVar("occ", $_REQUEST["occ"]);
            $obj->setVar("date", time());
            $obj->setVar("email", $_REQUEST["email"]);
            $obj->setVar("submitter", $_REQUEST["submitter"]);
            $obj->setVar("usid", $_REQUEST["usid"]);
            $obj->setVar("town", $_REQUEST["town"]);

            if ($xoops->getModuleConfig("alumni_moderate") == "1") {
            $obj->setVar("valid", '0');
            } else {
            $obj->setVar("valid", '1');
            }

    if ( !empty($_FILES['photo']['name']) ) {
    include_once XOOPS_ROOT_PATH . "/class/uploader.php";
    $uploaddir = XOOPS_ROOT_PATH."/modules/alumni/photos/grad_photo";
    $photomax     = $xoops->getModuleConfig('alumni_photomax');
    $maxwide     = $xoops->getModuleConfig('alumni_maxwide');
    $maxhigh     = $xoops->getModuleConfig('alumni_maxhigh');
    $allowed_mimetypes = array('image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png');
    $uploader  = new XoopsMediaUploader($uploaddir, $allowed_mimetypes, $photomax, $maxwide, $maxhigh);
    if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
 //       $uploader->setPrefix("pic_");
        $uploader->setTargetFileName($date.'_'.$_FILES['photo']['name']);
        $uploader->fetchMedia($_POST['xoops_upload_file'][0]);
        if (!$uploader->upload()) {
            $errors = $uploader->getErrors();
            $xoops->redirect("javascript:history.go(-1)", 3, $errors);
        } else {

		$obj->setVar("photo", $uploader->getSavedFileName());

        }
    } else {
        $obj->setVar("photo", $_REQUEST["photo"]);
    }
    }

    if ( !empty($_FILES['photo2']['name']) ) {
    include_once XOOPS_ROOT_PATH . "/class/uploader.php";
    $uploaddir2 = XOOPS_ROOT_PATH."/modules/alumni/photos/now_photo";
    $photomax     = $xoops->getModuleConfig('alumni_photomax');
    $maxwide     = $xoops->getModuleConfig('alumni_maxwide');
    $maxhigh     = $xoops->getModuleConfig('alumni_maxhigh');
    $allowed_mimetypes = array('image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png');
    $uploader2  = new XoopsMediaUploader($uploaddir2, $allowed_mimetypes, $photomax, $maxwide, $maxhigh);
    if ($uploader2->fetchMedia($_POST['xoops_upload_file'][1])) {
 //       $uploader2->setPrefix("pic_");
        $uploader2->setTargetFileName($date.'_'.$_FILES['photo2']['name']);
        $uploader2->fetchMedia($_POST['xoops_upload_file'][1]);
        if (!$uploader2->upload()) {
            $errors = $uploader2->getErrors();
            $xoops->redirect("javascript:history.go(-1)", 3, $errors);
        } else {
            $obj->setVar("photo2", $uploader2->getSavedFileName());
        }
    } else {
        $obj->setVar("photo2", $_REQUEST["photo2"]);
    } 
    }

    if ($alumni_listing_Handler->insert($obj)) {
        $xoops->redirect("alumni.php", 3, _AM_ALUMNI_FORMOK);

                //notifications
                if ($lid == 0 && $xoops->isActiveModule('notifications')) {
                    $notification_handler = Notifications::getInstance()->getHandlerNotification();
                    $tags = array();
                    $tags['MODULE_NAME'] = 'alumni';
                    $tags['ITEM_NAME'] = $request->asStr('lname', '');
                    $tags['ITEM_URL'] = XOOPS_URL . '/modules/alumni/listing.php?lid=' . $new_id;
                    $notification_handler->triggerEvent('global', 0, 'newlisting', $tags);
                    $notification_handler->triggerEvent('item', $new_id, 'newlisting', $tags);
                }     
    }

    echo $obj->getHtmlErrors();
    $form = $obj->getAdminForm();
    $form->display();
    break;

case "edit_listing":
    $xoops->header();
    $indexAdmin = new Xoops\Module\Admin();
    $indexAdmin->addItemButton(_AM_ALUMNI_ADD_LINK, 'alumni.php?op=new_listing', 'add');
    $indexAdmin->addItemButton(_AM_ALUMNI_LISTINGLIST, 'alumni.php', 'list');
    echo $indexAdmin->renderButton('left', '');
    $obj  = $alumni_listing_Handler->get($_REQUEST["lid"]);
    $form = $obj->getAdminForm();
    $form->display();
    break;

case "delete_listing":
    $xoops->header();
    $obj = $alumni_listing_Handler->get($_REQUEST["lid"]);
    if (isset($_REQUEST["ok"]) && $_REQUEST["ok"] == 1) {
        if (!$GLOBALS["xoopsSecurity"]->check()) {
            $xoops->redirect("alumni.php", 3, implode(",", $GLOBALS["xoopsSecurity"]->getErrors()));
        }
        if ($alumni_listing_Handler->delete($obj)) {
            $xoops->redirect("alumni.php", 3, _AM_ALUMNI_FORMDELOK);
        } else {
            echo $obj->getHtmlErrors();
        }
    } else {
        $xoops->confirm(array("ok" => 1, "lid" => $_REQUEST["lid"], "op" => "delete_listing"), $_SERVER["REQUEST_URI"], sprintf(_AM_ALUMNI_FORMSUREDEL, $obj->getVar("lid")));
    }
    break;

    case 'update_status':
        $lid = $request->asInt('lid', 0);
        if ($lid > 0) {
            $obj = $alumni_listing_Handler->get($lid);
            $obj->setVar('valid', 1);
            if ($alumni_listing_Handler->insert($obj)) {
               $xoops->redirect("alumni.php?op=list_moderated", 3, _AM_ALUMNI_LISTING_VALIDATED);
            }
            echo $obj->getHtmlErrors();
        }
        break;
  
    case 'list_moderated':
    $xoops->header('alumni_admin_moderated.html');
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

        $listing_Handler = $xoops->getModuleHandler('alumni_listing', 'alumni');
        $alumni = Alumni::getInstance();
        $module_id = $xoops->module->getVar('mid');
        $groups = $xoops->isUser() ? $xoops->user->getGroups() : XOOPS_GROUP_ANONYMOUS;
        $alumni_ids = $alumni->getGrouppermHandler()->getItemIds('alumni_view', $groups, $module_id);
        $moderate_criteria = new CriteriaCompo();
        $moderate_criteria->add(new Criteria('valid', 0, '='));
        $moderate_criteria->add(new Criteria('cid', '(' . implode(', ', $alumni_ids) . ')', 'IN'));
	$listing_count      = $listing_Handler->getCount($moderate_criteria);
	$listing_arr = $listing_Handler->getall($moderate_criteria);

        // Assign Template variables
        $xoops->tpl()->assign('listing_count', $listing_count);
        if ($listing_count > 0) {
            foreach (array_keys($listing_arr) as $i) {

            $lid   = $listing_arr[$i]->getVar("lid");
            $cid   = $listing_arr[$i]->getVar("cid");
            $name = $listing_arr[$i]->getVar("name");
            $mname   = $listing_arr[$i]->getVar("mname");
            $lname   = $listing_arr[$i]->getVar("lname");
            $school    = $listing_arr[$i]->getVar("school");
            $year = $listing_arr[$i]->getVar("year");
            $studies = $listing_arr[$i]->getVar("studies");
            $activities = $listing_arr[$i]->getVar("activities");   
            $extrainfo = $listing_arr[$i]->getVar("extrainfo");
            $occ    = $listing_arr[$i]->getVar("occ"); 
            $date   = $listing_arr[$i]->getVar("date");
            $email   = $listing_arr[$i]->getVar("email");
            $submitter = $listing_arr[$i]->getVar("submitter");
            $usid   = $listing_arr[$i]->getVar("usid");
            $town   = $listing_arr[$i]->getVar("town");         
            $valid = $listing_arr[$i]->getVar("valid");
            $photo   = $listing_arr[$i]->getVar("photo");
            $photo2   = $listing_arr[$i]->getVar("photo2");
            $view   = $listing_arr[$i]->getVar("view");

	$xoops->tpl()->assign('cat', $cid);
            
            $listing = array();
		$name = $myts->undoHtmlSpecialChars($name);
		$mname = $myts->undoHtmlSpecialChars($mname);
		$lname = $myts->undoHtmlSpecialChars($lname);
		$school = $myts->undoHtmlSpecialChars($school);
		$year = $myts->htmlSpecialChars($year);

		$useroffset = "";

		$newcount = $xoops->getModuleConfig("".$mydirname."_countday");
		$startdate = (time()-(86400 * $newcount));
		if ($startdate < $date) {
		$newitem = "<img src=\"".XOOPS_URL."/modules/$mydirname/images/newred.gif\" />";
		$listing['new'] = $newitem;
			}
		if($xoopsUser) {
			$timezone = $xoopsUser->timezone();
				if(isset($timezone)) {
					$useroffset = $xoopsUser->timezone();
				} else {
					$useroffset = $xoopsConfig['default_TZ'];
				}
			}
			$date = ($useroffset*3600) + $date;
			$date = XoopsLocale::formatTimestamp($date,'s');

			$listing['lid'] = $lid;
			$listing['name'] = "<a href='alumni.php?op=moderated_listing&amp;lid=$lid'><b>$name&nbsp;$mname&nbsp;$lname</b></a>";
			$listing['school'] = $school;
			$listing['year'] = $year;
			$listing['studies'] = $studies;
			$listing['activities'] = $activities;
			$listing['extrainfo'] = $extrainfo;
			$listing['occ'] = $occ;
			$listing['submitter'] = $submitter;
			$listing['date'] = $date;
			$listing['valid'] = $valid;
			$listing['view'] = $view;

			$cat = addslashes($cid);
			
			$listing['views'] = $view;
		$xoopsTpl->append('listing', $listing);
                $xoops->tpl()->assign('valid', AlumniLocale::A_APPROVE);
                $xoops->tpl()->assign('school', AlumniLocale::A_SCHOOL);
                $xoops->tpl()->assign('class_of', AlumniLocale::A_CLASS_OF);
                $xoops->tpl()->assign('moderated_lang', AlumniLocale::A_MODERATED); 
                $xoops->tpl()->assign('moderated_lang', XoopsLocale::A_EDIT);       
                $xoops->tpl()->assign('studies_lang', AlumniLocale::A_STUDIES);            
                $xoops->tpl()->assign('activities_lang', AlumniLocale::A_ACTIVITIES);         
                $xoops->tpl()->assign('extrainfo_lang', AlumniLocale::A_EXTRAINFO);
                $xoops->tpl()->assign('occ_lang', AlumniLocale::A_OCC);   
             }   
                unset($listing);

        } else {
            $xoops->tpl()->assign('error_message', AlumniLocale::E_NO_LISTING_APPROVE);
        }
            
        break;    

}
$xoops->footer();

