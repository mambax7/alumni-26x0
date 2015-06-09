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
require_once(XOOPS_ROOT_PATH . "/modules/{$moduleDirName}/include/gtickets.php");
//include(XOOPS_ROOT_PATH."/modules/{$moduleDirName}/include/functions.php");
$myts = MyTextSanitizer::getInstance();

function PrintAlum($lid = 0)
{

    global $xoopsConfig, $xoopsUser, $xoopsDB, $xoopsModuleConfig, $useroffset, $myts, $xoopsLogger, $moduleDirName, $mainLang, $xoops;

    $currenttheme = $xoopsConfig['theme_set'];
    $alumni       = Alumni::getInstance();
    //       $xoops = $helper->xoops();
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
            echo "<tr><td width=\"40%\" valign=\"top\"><b>" . constant($mainLang . '_GPHOTO') . "</b><br /><br /><img src=\"photos/grad_photo/$photo\" width='125' border=0></td>";
        }

        if ($photo2) {
            echo "<td width=\"60%\" valign=\"top\"><b>" . constant($mainLang . '_RPHOTO') . "</b><br /><br />&nbsp;&nbsp;&nbsp;<img src=\"photos/now_photo/$photo2\" width='125' border=0></td></tr>";
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
