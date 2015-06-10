<?php
use Xoops\Core\Request;

include __DIR__ . '/header.php';
$xoops = Xoops::getInstance();
//$alumni = Alumni::getInstance();
$myts          = MyTextSanitizer::getInstance();
$moduleDirName = basename(__DIR__);
//$mainLang =  '_' . strtoupper( $moduleDirName ) ;

if (!empty($_POST['submit'])) {
    if ($xoops->getModuleConfig('alumni_use_captcha') == '1' && !$xoops->user->isAdmin()) {
        $xoopsCaptcha = XoopsCaptcha::getInstance();
        if (!$xoopsCaptcha->verify()) {
            $xoops->redirect(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/index.php', 4, $xoopsCaptcha->getMessage());
            exit(0);
        }
    }

    $yname = $_POST['yname'];
    $ymail = $_POST['ymail'];
    $fname = $_POST['fname'];
    $fmail = $_POST['fmail'];

    if (isset($_POST['lid'])) {
        $lid = (int)($_POST['lid']);
    } else {
        if (isset($_GET['lid'])) {
            $lid = (int)($_GET['lid']);
        } else {
            $lid = 0;
        }
    }
    $alumni    = Alumni::getInstance();
    $module_id = $xoops->module->getVar('mid');

    // get permitted id
    $groups               = $xoops->isUser() ? $xoops->user->getGroups() : XOOPS_GROUP_ANONYMOUS;
    $alumni_ids           = $alumni->getGrouppermHandler()->getItemIds('alumni_view', $groups, $module_id);
    $alumniListingHandler = $xoops->getModuleHandler('alumni_listing', 'alumni');
    $listing_criteria     = new CriteriaCompo();
    $listing_criteria->add(new Criteria('lid', $lid, '='));
    $listing_criteria->add(new Criteria('cid', '(' . implode(', ', $alumni_ids) . ')', 'IN'));
    $numrows = $alumniListingHandler->getCount($listing_criteria);

    $listing_arr = $alumniListingHandler->getAll($listing_criteria);
    unset($listing_criteria);
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

        $useroffset = '';
        if ($xoopsUser) {
            $timezone = $xoopsUser->timezone();
            if (isset($timezone)) {
                $useroffset = $xoopsUser->timezone();
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
        exit();
    }
} else {
    global $xoops;

    $lid = Request::getInt('lid', null, 'GET');
    $xoops->header('alumni_sendfriend.tpl');
    //   Xoops::getInstance()->header();

    include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

    $alumniListingHandler = $xoops->getModuleHandler('alumni_listing', 'alumni');
    $listing_2_send       = $alumniListingHandler->get(Request::getInt('lid', 0, 'GET'));

    $listing_2_send->getVar('name');
    $listing_2_send->getVar('mname');
    $listing_2_send->getVar('lname');

    ob_start();
    $form = new XoopsThemeForm(constant($mainLang . '_SENDTO'), 'sendfriend_form', 'sendfriend.php');
    $form->setExtra('enctype="multipart/form-data"');
    //    $GLOBALS['xoopsGTicket']->addTicketXoopsFormElement($form, __LINE__, 1800, 'token');
    $form->addElement(new XoopsFormLabel(constant($mainLang . '_LISTING_SEND'), $listing_2_send->getVar('name') . ' ' . $listing_2_send->getVar('mname') . ' ' . $listing_2_send->getVar('lname') . ''));
    if ($xoopsUser) {
        $idd  = $xoopsUser->getVar('name', 'E');
        $idde = $xoopsUser->getVar('email', 'E');
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
    $xoopsTpl->assign('sendfriend_form', ob_get_contents());

    ob_end_clean();
}
Xoops::getInstance()->footer();
