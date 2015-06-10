<?php
//  -----------------------------------------------------------------------  //
//                           Alumni for Xoops 2.6.0                           //
//                           By John Mordo (jlm69)                           //
//  -----------------------------------------------------------------------  //
use Xoops\Core\Request;

$lid = Request::getInt('lid', null, 'POST');
if (Request::getString('submit', '', 'POST')) {
    include __DIR__ . '/header.php';

    $moduleDirName = basename(__DIR__);

    require_once(XOOPS_ROOT_PATH . "/modules/{$moduleDirName}/include/gtickets.php");

    global $xoopsConfig, $xoopsDB, $myts, $meta, $moduleDirName;

    if ($xoops->getModuleConfig('alumni_use_captcha') == '1' && !$xoops->user->isAdmin()) {
        $xoopsCaptcha = XoopsCaptcha::getInstance();
        if (!$xoopsCaptcha->verify()) {
            $xoops->redirect('javascript:history.go(-1)', 3, $xoopsCaptcha->getMessage());
            exit(0);
        }
    }

    $lid = Request::getInt('lid', '', 'POST');

    $body          = Request::getString('body', null, 'POST'); //(isset($_REQUEST['body'])) ? $_REQUEST['body'] : null;
    $sname         = Request::getString('sname', null, 'POST'); //(isset($_REQUEST['sname'])) ? $_REQUEST['sname'] : null;
    $semail        = Request::getString('semail', null, 'POST'); //(isset($_REQUEST['semail'])) ? $_REQUEST['semail'] : null;
    $listing       = Request::getString('listing', null, 'POST'); //(isset($_REQUEST['listing'])) ? $_REQUEST['listing'] : null;
    $subject       = constant($mainLang . '_CONTACTALUMNI');
    $admin_subject = constant($mainLang . '_CONTACTADMIN');

    $module_id            = $xoops->module->getVar('mid');
    $groups               = $xoops->isUser() ? $xoops->user->getGroups() : XOOPS_GROUP_ANONYMOUS;
    $alumni_ids           = $alumni->getGrouppermHandler()->getItemIds('alumni_view', $groups, $module_id);
    $alumniListingHandler = $xoops->getModuleHandler('alumni_listing', 'alumni');
    $listing_criteria     = new CriteriaCompo();
    $listing_criteria->add(new Criteria('lid', $lid, '='));
    $listing_criteria->add(new Criteria('cid', '(' . implode(', ', $alumni_ids) . ')', 'IN'));
    $numrows     = $alumniListingHandler->getCount($listing_criteria);
    $listing_arr = $alumniListingHandler->getAll($listing_criteria);
    foreach (array_keys($listing_arr) as $i) {

        $name      = $listing_arr[$i]->getVar('name');
        $mname     = $listing_arr[$i]->getVar('mname');
        $lname     = $listing_arr[$i]->getVar('lname');
        $submitter = $listing_arr[$i]->getVar('submitter');
        $email     = $listing_arr[$i]->getVar('email');
    }
    unset($listing_arr);

    $ipaddress = $_SERVER['REMOTE_ADDR'];

    $xoopsMailer = $xoops->getMailer();
    $xoopsMailer->reset();
    $xoopsMailer->useMail();
    $xoopsMailer->setTemplateDir(XOOPS_ROOT_PATH . "/modules/{$moduleDirName}/language/" . $xoops->getConfig('language') . '/mail_template/');
    $xoopsMailer->setTemplate('listing_user_contact.tpl');
    $xoopsMailer->assign('SNAME', $sname); //assign some vars for mail template
    $xoopsMailer->assign('SEMAIL', $semail);
    $xoopsMailer->assign('SUBJECT', $subject);
    $xoopsMailer->assign('BODY', $body);
    $xoopsMailer->assign('FROM', constant($mainLang . '_FROM'));
    $xoopsMailer->assign('SUBMITTER', $submitter);
    $xoopsMailer->assign('HELLO', constant($mainLang . '_HELLO'));
    $xoopsMailer->assign('LISTING', $listing);
    $xoopsMailer->assign('REPLY_TO', constant($mainLang . '_CANREPLY'));
    $xoopsMailer->assign('HAVE_REPLY', constant($mainLang . '_REPLYTO'));
    $xoopsMailer->assign('FROMSITE', constant($mainLang . '_FROMSITE'));
    $xoopsMailer->assign('AT', constant($mainLang . '_TO'));
    $xoopsMailer->assign('WEBMASTER', constant($mainLang . '_WEBMASTER'));
    $xoopsMailer->assign('NO_REPLY', constant($mainLang . '_NOREPLY'));
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
    $xoopsMailer2->setTemplateDir(XOOPS_ROOT_PATH . "/modules/{$moduleDirName}/language/" . $xoops->getConfig('language') . '/mail_template/');
    $xoopsMailer2->setTemplate('listing_admin_contact.tpl');
    $xoopsMailer2->assign('SNAME', $sname); //assign some vars for mail template
    $xoopsMailer2->assign('SEMAIL', $semail);
    $xoopsMailer2->assign('SUBJECT', $subject);
    $xoopsMailer2->assign('BODY', $body);
    $xoopsMailer2->assign('IPADDRESS', $ipaddress);
    $xoopsMailer2->assign('FROM', constant($mainLang . '_FROM'));
    $xoopsMailer2->assign('SUBMITTER', $submitter);
    $xoopsMailer2->assign('HELLO', constant($mainLang . '_HELLO'));
    $xoopsMailer2->assign('LISTING', $listing);
    $xoopsMailer2->assign('ADMIN_COPY', constant($mainLang . '_ADMIN_COPY'));
    $xoopsMailer2->assign('REPLY_TO', constant($mainLang . '_CANREPLY'));
    $xoopsMailer2->assign('HAVE_REPLY', constant($mainLang . '_REPLYTO'));
    $xoopsMailer2->assign('FROMSITE', constant($mainLang . '_FROMSITE'));
    $xoopsMailer2->assign('AT', constant($mainLang . '_TO'));
    $xoopsMailer2->assign('WEBMASTER', constant($mainLang . '_WEBMASTER'));
    $xoopsMailer2->assign('NO_REPLY', constant($mainLang . '_NOREPLY'));
    $xoopsMailer2->setToEmails($xoops->getConfig('adminmail'));
    $xoopsMailer2->setFromEmail($xoops->getConfig('adminmail'));
    $xoopsMailer2->setFromName($xoops->getConfig('sitename'));
    $xoopsMailer2->setSubject($admin_subject);
    $xoopsMailer2->setBody($body);
    $xoopsMailer2->send();
    $xoopsMailer2->getErrors();

    $xoops->redirect('index.php', 3, constant($mainLang . '_MESSEND'));

} else {

    $lid = Request::getInt('lid', '', 'POST');
    include __DIR__ . '/header.php';
    $xoops = Xoops::getInstance();
    //	Xoops::getInstance()->header();
    $module_id            = $xoops->module->getVar('mid');
    $groups               = $xoops->isUser() ? $xoops->user->getGroups() : XOOPS_GROUP_ANONYMOUS;
    $alumni_ids           = $alumni->getGrouppermHandler()->getItemIds('alumni_view', $groups, $module_id);
    $alumniListingHandler = $xoops->getModuleHandler('alumni_listing', 'alumni');
    $listing_criteria     = new CriteriaCompo();
    $listing_criteria->add(new Criteria('lid', $lid, '='));
    $listing_criteria->add(new Criteria('cid', '(' . implode(', ', $alumni_ids) . ')', 'IN'));
    $numrows     = $alumniListingHandler->getCount($listing_criteria);
    $listing_arr = $alumniListingHandler->getAll($listing_criteria);
    unset($listing_criteria);
    foreach (array_keys($listing_arr) as $i) {
        $name      = $listing_arr[$i]->getVar('name');
        $mname     = $listing_arr[$i]->getVar('mname');
        $lname     = $listing_arr[$i]->getVar('lname');
        $submitter = $listing_arr[$i]->getVar('submitter');
        $email     = $listing_arr[$i]->getVar('email');
    }
    $listing = $name . ' ' . $mname . ' ' . $lname;

    if ($xoops->user) {
        $sname = $xoops->user->getVar('uname');
        $sname = ($sname == '') ? $xoops->user->getVar('name') : $sname;

        $semail = $xoops->user->getVar('email');
    }
    $sendform = new XoopsThemeForm(constant($mainLang . '_CONTACTAUTOR') . ' ' . $listing, 'sendform', $_SERVER['PHP_SELF'] . '?lid=$lid', 'POST');
    $sendform->addElement(new XoopsFormLabel(constant($mainLang . '_SUBJECT'), $listing));
    $sendform->addElement(new XoopsFormText(constant($mainLang . '_YOURNAME'), 'sname', 50, 100, $sname), true);
    $sendform->addElement(new XoopsFormText(constant($mainLang . '_YOUREMAIL'), 'semail', 50, 50, $semail), true);
    $sendform->addElement(new XoopsFormTextArea(constant($mainLang . '_YOURMESSAGE'), 'body', '', 5, 50, ''));
    if ($xoops->getModuleConfig('alumni_use_captcha') == '1' && !$xoops->user->isAdmin()) {
        $sendform->addElement(new XoopsFormCaptcha());
    }
    $sendform->addElement(new XoopsFormLabel(constant($mainLang . '_YOUR_IP'), "<img src=\"" . XOOPS_URL . "/modules/{$moduleDirName}/ip_image.php\" alt=\"\" /><br />" . constant($mainLang . '_IP_LOGGED') . ""));

    $sendform->addElement(new XoopsFormHidden('listing', $listing), false);
    $sendform->addElement(new XoopsFormHidden('email', $email), false);
    $sendform->addElement(new XoopsFormHidden('lid', $lid), false);
    $sendform->addElement(new XoopsFormButton('', 'submit', constant($mainLang . '_SUBMIT'), 'submit'));
    $sendform->display();

    Xoops::getInstance()->footer();
}
