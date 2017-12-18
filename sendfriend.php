<?php
use Xoops\Core\Request;

include __DIR__ . '/header.php';
$xoops = Xoops::getInstance();
//$alumni = Alumni::getInstance();
$myts          = MyTextSanitizer::getInstance();
$moduleDirName = basename(__DIR__);
//$mainLang =  '_' . strtoupper( $moduleDirName ) ;

//if (!empty($_POST['submit'])) {
if (Request::getString('submit', '', 'POST')){
    if ($xoops->getModuleConfig('alumni_use_captcha') == '1' && !$xoops->user->isAdmin()) {
        $xoopsCaptcha = XoopsCaptcha::getInstance();
        if (!$xoopsCaptcha->verify()) {
            $xoops->redirect(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/index.php', 4, $xoopsCaptcha->getMessage());
            exit(0);
        }
    }

    $yname = Request::getString('yname', '', 'POST'); //$_POST['yname'];
    $ymail = Request::getString('ymail', '', 'POST'); //$_POST['ymail'];
    $fname = Request::getString('fname', '', 'POST'); //$_POST['fname'];
    $fmail = Request::getString('fmail', '', 'POST'); //$_POST['fmail'];

//    $lid = 0;
//    if (isset($_POST['lid'])) {
//        $lid = (int)($_POST['lid']);
//    } elseif (isset($_GET['lid'])) {
//        $lid = (int)($_GET['lid']);
//    }

    $lid = Request::getInt('lid', Request::getInt('lid', 0, 'GET'), 'POST');

    $alumni   = Alumni::getInstance();
    $moduleId = $xoops->module->getVar('mid');

    // get permitted id
    $groups               = $xoops->isUser() ? $xoops->user->getGroups() : SystemLocale::ANONYMOUS_USERS_GROUP;
    $alumniIds            = $alumni->getGrouppermHandler()->getItemIds('alumni_view', $groups, $moduleId);
    // $alumniListingHandler = $xoops->getModuleHandler('Listing', $moduleDirName);
    $listingCriteria      = new CriteriaCompo();
    $listingCriteria->add(new Criteria('lid', $lid, '='));
    $listingCriteria->add(new Criteria('cid', '(' . implode(', ', $alumniIds) . ')', 'IN'));
    $numrows = $listingHandler->getCount($listingCriteria);

    $listingArray = $listingHandler->getAll($listingCriteria);
    unset($listingCriteria);
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

        $useroffset = '';
        if ($xoops->user) {
            $timezone = $xoops->user->timezone();
            if (null !== $timezone) {
                $useroffset = $xoops->user->timezone();
            } else {
                $useroffset = $xoopsConfig['default_TZ'];
            }
        }
        $date       = ($useroffset * 3600) + $date;
        $date       = $date;
        $name       = $myts->htmlSpecialChars($name);
        $mname      = $myts->htmlSpecialChars($mname);
        $lname      = $myts->htmlSpecialChars($lname);
        $school     = $myts->htmlSpecialChars($school);
        $year       = $myts->htmlSpecialChars($year);
        $studies    = $myts->htmlSpecialChars($studies);
        $activities = $myts->displayTarea($activities, 1, 0, 1, 1, 1);
        $occ        = $myts->htmlSpecialChars($occ);
        $submitter  = $myts->htmlSpecialChars($submitter);
        $town       = $myts->htmlSpecialChars($town);

        $tags                       = array();
        $tags['YNAME']              = $yname;
        $tags['YMAIL']              = $ymail;
        $tags['FNAME']              = $fname;
        $tags['FMAIL']              = $fmail;
        $tags['HELLO']              = constant($mainLang . '_HELLO');
        $tags['LID']                = $lid;
        $tags['CLASSOF']            = constant($mainLang . '_CLASSOF');
        $tags['NAME']               = $name;
        $tags['MNAME']              = $mname;
        $tags['LNAME']              = $lname;
        $tags['SCHOOL']             = $school;
        $tags['STUDIES']            = $studies;
        $tags['TOWN']               = $town;
        $tags['YEAR']               = $year;
        $tags['OTHER']              = '' . constant($mainLang . '_INTERESS') . ' ' . $xoopsConfig['sitename'] . '';
        $tags['LISTINGS']           = '' . XOOPS_URL . "/modules/{$moduleDirName}/";
        $tags['LINK_URL']           = '' . XOOPS_URL . "/modules/{$moduleDirName}/listing.php?lid=" . addslashes($lid) . '';
        $tags['THINKS_INTERESTING'] = '' . constant($mainLang . '_MESSAGE') . '';
        $tags['YOU_CAN_VIEW_BELOW'] = '' . constant($mainLang . '_YOU_CAN_VIEW_BELOW') . '';
        $tags['WEBMASTER']          = constant($mainLang . '_WEBMASTER');
        $tags['NO_REPLY']           = constant($mainLang . '_NOREPLY');
        $subject                    = '' . constant($mainLang . '_SUBJET') . ' ' . $xoopsConfig['sitename'] . '';
        //	$xoopsMailer = $xoops->getMailer();
        //	$xoopsMailer->multimailer->isHTML(true);
        //	$xoopsMailer->useMail();

        $xoopsMailer = $xoops->getMailer();
        $xoopsMailer->useMail();
        $xoopsMailer->setTemplateDir(XOOPS_ROOT_PATH . "/modules/{$moduleDirName}/language/english/mail_template/");
        $xoopsMailer->setTemplate('listing_send_friend.tpl');
        $xoopsMailer->setFromEmail($ymail);
        $xoopsMailer->setToEmails($fmail);
        $xoopsMailer->setSubject($subject);
        //    $xoopsMailer->$xoops->multimailer;
        $xoopsMailer->assign($tags);
        $xoopsMailer->send();
        echo $xoopsMailer->getErrors();

        $xoops->redirect('index.php', 3, constant($mainLang . '_ALUM_SEND'));
    }
} else {
    global $xoops;

    $lid = Request::getInt('lid', null, 'GET');
    $xoops->header('alumni_sendfriend.tpl');
    //   Xoops::getInstance()->header();

    include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

    // $alumniListingHandler = $xoops->getModuleHandler('Listing', $moduleDirName);
    $listing_2_send       = $listingHandler->get(Request::getInt('lid', 0, 'GET'));

    $listing_2_send->getVar('name');
    $listing_2_send->getVar('mname');
    $listing_2_send->getVar('lname');

    ob_start();
    $form = new XoopsThemeForm(constant($mainLang . '_SENDTO'), 'sendfriend_form', 'sendfriend.php');
    $form->setExtra('enctype="multipart/form-data"');
    //    $GLOBALS['xoopsGTicket']->addTicketXoopsFormElement($form, __LINE__, 1800, 'token');
    $form->addElement(new XoopsFormLabel(constant($mainLang . '_LISTING_SEND'), $listing_2_send->getVar('name') . ' ' . $listing_2_send->getVar('mname') . ' ' . $listing_2_send->getVar('lname') . ''));
    if ($xoops->user) {
        $idd  = $xoops->user->getVar('name', 'E');
        $idde = $xoops->user->getVar('email', 'E');
    }

    $form->addElement(new XoopsFormText(constant($mainLang . '_NAME'), 'yname', 30, 50, $idd), true);
    $form->addElement(new XoopsFormText(constant($mainLang . '_MAIL'), 'ymail', 30, 60, $idde), true);
    $form->addElement(new XoopsFormText(constant($mainLang . '_NAMEFR'), 'fname', 30, 60, ''), true);
    $form->addElement(new XoopsFormText(constant($mainLang . '_MAILFR'), 'fmail', 30, 60, ''), true);

    if ($xoops->getModuleConfig('alumni_use_captcha') == '1' && !$xoops->user->isAdmin()) {
        $form->addElement(new XoopsFormCaptcha());
    }

    $form->addElement(new XoopsFormHidden('lid', $lid), false);
    $form->addElement(new XoopsFormButton('', 'submit', constant($mainLang . '_SUBMIT'), 'submit'));
    $form->display();
    $xoops->tpl()->assign('sendfriend_form', ob_get_contents());

    ob_end_clean();
}
Xoops::getInstance()->footer();
