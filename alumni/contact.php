<?php
//  -----------------------------------------------------------------------  //
//                           Alumni for Xoops 2.6.0                           //
//                           By John Mordo (jlm69)                           //
//  -----------------------------------------------------------------------  //

$lid = isset( $_REQUEST['lid'] ) ? $_REQUEST['lid'] : '' ;
if (!empty($_POST['submit'])) {
	include("header.php");
	
	$mydirname = basename( dirname( __FILE__ ) ) ;

	require_once( XOOPS_ROOT_PATH."/modules/$mydirname/include/gtickets.php" ) ;
	
	global $xoopsConfig, $xoopsDB, $myts, $meta, $mydirname;

    	if ($xoops->getModuleConfig("alumni_use_captcha") == '1' && !$xoops->user->isAdmin()) {
	$xoopsCaptcha = XoopsCaptcha::getInstance();
	if (!$xoopsCaptcha->verify()) {
        $xoops->redirect('javascript:history.go(-1)', 3, $xoopsCaptcha->getMessage());
	exit(0);
	}
	}

	$lid = (int)($_REQUEST["lid"]);

	$body = ( isset($_REQUEST['body']) )? $_REQUEST['body'] : null ;
	$sname = ( isset($_REQUEST['sname']) )? $_REQUEST['sname'] : null ;
	$semail = ( isset($_REQUEST['semail']) )? $_REQUEST['semail'] : null ;
	$listing = ( isset($_REQUEST['listing']) )? $_REQUEST['listing'] : null ;
	$subject = _ALUMNI_CONTACTALUMNI;
	$admin_subject = _ALUMNI_CONTACTADMIN;

        $module_id = $xoops->module->getVar('mid');
        $groups = $xoops->isUser() ? $xoops->user->getGroups() : XOOPS_GROUP_ANONYMOUS;
        $alumni_ids = $alumni->getGrouppermHandler()->getItemIds('alumni_view', $groups, $module_id);
	$alumni_listing_Handler = $xoops->getModuleHandler('alumni_listing', 'alumni');
        $listing_criteria = new CriteriaCompo();
        $listing_criteria->add(new Criteria('lid', $lid, '='));
        $listing_criteria->add(new Criteria('cid', '(' . implode(', ', $alumni_ids) . ')', 'IN'));
	$numrows = $alumni_listing_Handler->getCount($listing_criteria);
	$listing_arr = $alumni_listing_Handler->getall($listing_criteria);
         foreach (array_keys($listing_arr) as $i) {

		$name = $listing_arr[$i]->getVar("name");
		$mname = $listing_arr[$i]->getVar("mname");
		$lname = $listing_arr[$i]->getVar("lname");
		$submitter = $listing_arr[$i]->getVar("submitter");
		$email   = $listing_arr[$i]->getVar("email");
		}
		unset($listing_arr);

	$ipaddress = $_SERVER['REMOTE_ADDR'];
	
	$xoopsMailer = $xoops->getMailer();
	$xoopsMailer->reset();
	$xoopsMailer->useMail();	
	$xoopsMailer->setTemplateDir(XOOPS_ROOT_PATH.'/modules/alumni/language/'.$xoops->getConfig('language').'/mail_template/');
	$xoopsMailer->setTemplate("listing_user_contact.tpl");
	$xoopsMailer->assign('SNAME', $sname); //assign some vars for mail template
	$xoopsMailer->assign('SEMAIL', $semail);
	$xoopsMailer->assign('SUBJECT', $subject);
	$xoopsMailer->assign('BODY', $body);
	$xoopsMailer->assign('FROM',_ALUMNI_FROM);
	$xoopsMailer->assign('SUBMITTER', $submitter);
	$xoopsMailer->assign('HELLO', _ALUMNI_HELLO);
	$xoopsMailer->assign('LISTING', $listing);
	$xoopsMailer->assign('REPLY_TO', _ALUMNI_CANREPLY);
	$xoopsMailer->assign('HAVE_REPLY', _ALUMNI_REPLYTO);
	$xoopsMailer->assign('FROMSITE', _ALUMNI_FROMSITE);
	$xoopsMailer->assign('AT', _ALUMNI_TO);
	$xoopsMailer->assign('WEBMASTER', _ALUMNI_WEBMASTER);
	$xoopsMailer->assign('NO_REPLY', _ALUMNI_NOREPLY);
	$xoopsMailer->setToEmails($email);
	$xoopsMailer->setFromEmail($xoops->getConfig('adminmail'));
	$xoopsMailer->setFromName($xoops->getConfig('sitename'));
	$xoopsMailer->setSubject($subject);
	$xoopsMailer->setBody($body);
	$xoopsMailer->send();
	$xoopsMailer->getErrors();

	$xoopsMailer2 = $xoops->getMailer();
	$xoopsMailer->reset();
	$xoopsMailer2->useMail();
	$xoopsMailer2->setTemplateDir(XOOPS_ROOT_PATH.'/modules/alumni/language/'.$xoops->getConfig('language').'/mail_template/');
	$xoopsMailer2->setTemplate("listing_admin_contact.tpl");
	$xoopsMailer2->assign('SNAME', $sname); //assign some vars for mail template
	$xoopsMailer2->assign('SEMAIL', $semail);
	$xoopsMailer2->assign('SUBJECT', $subject);
	$xoopsMailer2->assign('BODY', $body);
	$xoopsMailer2->assign('IPADDRESS', $ipaddress);
	$xoopsMailer2->assign('FROM', _ALUMNI_FROM);
	$xoopsMailer2->assign('SUBMITTER', $submitter);
	$xoopsMailer2->assign('HELLO', _ALUMNI_HELLO);
	$xoopsMailer2->assign('LISTING', $listing);
	$xoopsMailer2->assign('ADMIN_COPY', _ALUMNI_ADMIN_COPY);
	$xoopsMailer2->assign('REPLY_TO', _ALUMNI_CANREPLY);
	$xoopsMailer2->assign('HAVE_REPLY', _ALUMNI_REPLYTO);
	$xoopsMailer2->assign('FROMSITE', _ALUMNI_FROMSITE);
	$xoopsMailer2->assign('AT', _ALUMNI_TO);
	$xoopsMailer2->assign('WEBMASTER', _ALUMNI_WEBMASTER);
	$xoopsMailer2->assign('NO_REPLY', _ALUMNI_NOREPLY);
	$xoopsMailer2->setToEmails($xoops->getConfig('adminmail'));
	$xoopsMailer2->setFromEmail($xoops->getConfig('adminmail'));
	$xoopsMailer2->setFromName($xoops->getConfig('sitename'));
	$xoopsMailer2->setSubject($admin_subject);
	$xoopsMailer2->setBody($body);
	$xoopsMailer2->send();
	$xoopsMailer2->getErrors();

	$xoops->redirect("index.php", 3, _ALUMNI_MESSEND);

	} else {

	$lid = isset( $_REQUEST['lid'] ) ? $_REQUEST['lid'] : '' ;
	include("header.php");
	$xoops = Xoops::getInstance();
//	Xoops::getInstance()->header();
        $module_id = $xoops->module->getVar('mid');
        $groups = $xoops->isUser() ? $xoops->user->getGroups() : XOOPS_GROUP_ANONYMOUS;
        $alumni_ids = $alumni->getGrouppermHandler()->getItemIds('alumni_view', $groups, $module_id);
	$alumni_listing_Handler = $xoops->getModuleHandler('alumni_listing', 'alumni');
        $listing_criteria = new CriteriaCompo();
        $listing_criteria->add(new Criteria('lid', $lid, '='));
        $listing_criteria->add(new Criteria('cid', '(' . implode(', ', $alumni_ids) . ')', 'IN'));
	$numrows      = $alumni_listing_Handler->getCount($listing_criteria);
	$listing_arr = $alumni_listing_Handler->getall($listing_criteria);
	unset($listing_criteria);
         foreach (array_keys($listing_arr) as $i) {
		$name = $listing_arr[$i]->getVar("name");
		$mname = $listing_arr[$i]->getVar("mname");
		$lname = $listing_arr[$i]->getVar("lname");
		$submitter = $listing_arr[$i]->getVar("submitter");
		$email   = $listing_arr[$i]->getVar("email");
	}
	$listing = $name." ".$mname." ".$lname;
	
	if($xoops->user) {
		$sname =$xoops->user->getVar("uname");
		$sname = ($sname == "") ? $xoops->user->getVar("name") : $sname ;

		$semail =$xoops->user->getVar("email");
	} 
	$sendform = new XoopsThemeForm(_ALUMNI_CONTACTAUTOR.' '.$listing, 'sendform', $_SERVER['PHP_SELF']. '?lid=$lid', 'POST');
	$sendform->addElement(new XoopsFormLabel(_ALUMNI_SUBJECT, $listing));
	$sendform->addElement(new XoopsFormText(_ALUMNI_YOURNAME , 'sname', 50, 100, $sname),true);
	$sendform->addElement(new XoopsFormText(_ALUMNI_YOUREMAIL , 'semail', 50, 50, $semail),true);
	$sendform->addElement(new XoopsFormTextArea(_ALUMNI_YOURMESSAGE, 'body', '', 5, 50, ''));
	if ($xoops->getModuleConfig('alumni_use_captcha') == '1' && !$xoops->user->isAdmin()) {
        $sendform->addElement(new XoopsFormCaptcha());
	}
	$sendform->addElement(new XoopsFormLabel(_ALUMNI_YOUR_IP, "<img src=\"".XOOPS_URL."/modules/alumni/ip_image.php\" alt=\"\" /><br />"._ALUMNI_IP_LOGGED.""));	
	
	$sendform->addElement(new XoopsFormHidden("listing", $listing), FALSE);
	$sendform->addElement(new XoopsFormHidden("email", $email), FALSE);
	$sendform->addElement(new XoopsFormHidden("lid", $lid), FALSE);
	$sendform->addElement(new XoopsFormButton('', 'submit', _ALUMNI_SUBMIT, 'submit'));
	$sendform->display();

    Xoops::getInstance()->footer();
}
