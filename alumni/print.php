<?php
//  -----------------------------------------------------------------------  //
//                           Alumni for Xoops 2.3.x                             //
//                             By John Mordo                                 //
//                                                                           //
//                                                                           //
//                                                                           //
//                                                                           //
// ------------------------------------------------------------------------- //

include __DIR__ . '/header.php';
$xoops         = Xoops::getInstance();
$moduleDirName = basename(__DIR__);
require_once(XOOPS_ROOT_PATH . "/modules/{$moduleDirName}/class/gtickets.php");
//include(XOOPS_ROOT_PATH."/modules/{$moduleDirName}/include/functions.php");
$myts = MyTextSanitizer::getInstance();

/**
 * @param int $lid
 */
function PrintAlum($lid = 0)
{
    global $xoopsConfig, $useroffset, $myts, $moduleDirName, $mainLang, $xoops;

    $currenttheme = $xoopsConfig['theme_set'];
    $alumni       = Alumni::getInstance();
    //       $xoops = $helper->xoops();
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
        $date = ($useroffset * 3600) + $date;
        //$date = $date;
        $date       = XoopsLocale::formatTimestamp($date, 's');
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

        echo '
    <html>
    <head><title>' . $xoopsConfig['sitename'] . "</title>
	<link rel=\"StyleSheet\" href=\"../../themes/" . $currenttheme . "/style/style.css\" type=\"text/css\">
	</head>
    <body bgcolor=\"#FFFFFF\" text=\"#000000\">
    <table border=0><tr><td>
    <table border=0 width=640 cellpadding=0 cellspacing=1 bgcolor=\"#000000\"><tr><td>
    <table border=0 width=100% cellpadding=8 cellspacing=1 bgcolor=\"#FFFFFF\"><tr><td>";

        echo "<table width=100% border=0 valign=top><tr><td><b>$name&nbsp;$mname&nbsp;$lname<br /> $school " . constant($mainLang . '_CLASSOF') . " $year</b>";
        echo '</td>
	      </tr>';

        if ($studies) {
            echo "<tr>
      <td><b>" . constant($mainLang . '_STUDIES') . "</b><div style=\"text-align:justify;\">$studies</div><p>";
            echo '</td>
	      </tr>';
        }

        if ($activities) {
            echo "<tr><td><b>" . constant($mainLang . '_ACTIVITIES') . "</b><div style=\"text-align:justify;\">$activities</div><p>";
            echo '</td>
	      </tr>';
        }

        if ($occ) {
            echo "<tr><td><b>" . constant($mainLang . '_OCC') . "</b><div style=\"text-align:justify;\">$occ</div><p>";
            echo '</td>
	      </tr>';
        }

        if ($town) {
            echo "<tr><td><b>" . constant($mainLang . '_TOWN') . "</b><div style=\"text-align:justify;\">$town</div>";
            echo '</td></tr>';
        }
        echo "</table><table width=\"100%\" border=0 valign=top>";
        if ($photo) {
            echo "<tr><td width=\"40%\" valign=\"top\"><b>" . constant($mainLang . '_GPHOTO') . "</b><br /><br /><img src=\"".XOOPS_URL . "/uploads/{$moduleDirName}/photos/grad_photo/" . "$photo\" width='125' border=0></td>";
        }

        if ($photo2) {
            echo "<td width=\"60%\" valign=\"top\"><b>" . constant($mainLang . '_RPHOTO') . "</b><br /><br />&nbsp;&nbsp;&nbsp;<img src=\"".XOOPS_URL . "/uploads/{$moduleDirName}/photos/now_photo/" . "$photo2\" width='125' border=0></td></tr>";
        }
        echo '</table><table border=0>';
        echo '<tr><td><b>' . constant($mainLang . '_DATE2') . " $date <br />";
        echo '</td>
	</tr></table>
</td></tr></table></td></tr></table>
    <br /><br /><center>
    ' . constant($mainLang . '_EXTRANN') . ' <b>' . $xoopsConfig['sitename'] . '</b><br />
    <a href="' . XOOPS_URL . "/modules/{$moduleDirName}/\">" . XOOPS_URL . "/modules/{$moduleDirName}/</a>
    </td></tr></table>
    </body>
    </html>";
    }
}

##############################################################

if (!isset($_POST['lid']) && isset($_GET['lid'])) {
    $lid = (int)($_GET['lid']);
} else {
    $lid = (int)($_POST['lid']);
}

$op = '';
if (!empty($_GET['op'])) {
    $op = $_GET['op'];
} elseif (!empty($_POST['op'])) {
    $op = $_POST['op'];
}

switch ($op) {

    case 'PrintAlum':
        PrintAlum($lid);
        break;

    default:
        $xoops->redirect('index.php', 3, '' . _RETURNGLO . '');
        break;

}
