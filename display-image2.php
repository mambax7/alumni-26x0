<?php
//
// ------------------------------------------------------------------------- //
//               E-Xoops: Content Management for the Masses                  //
//                       < http://www.e-xoops.com >                          //
// ------------------------------------------------------------------------- //
// Original Author: Pascal Le Boustouller
// Author Website : pascal.e-xoops@perso-search.com
// Licence Type   : GPL
// ------------------------------------------------------------------------- //
use Xoops\Core\Request;

include __DIR__ . '/header.php';
$lid = Request::getInt('lid', 0, 'POST');

global $xoopsConfig, $xoopsTheme, $xoopsDB, $xoops_footer, $xoopsLogger;
$currenttheme = $xoopsConfig['theme_set'];

// $alumniListingHandler = $xoops->getModuleHandler('Listing', $moduleDirName);
$listingCriteria      = new CriteriaCompo();
$listingCriteria->add(new Criteria('lid', $lid, '='));
$numrows      = $listingHandler->getCount($listingCriteria);
$listingArray = $listingHandler->get($lid);

if ($numrows > '0') {
    $photo2 = $listingArray->getVar('photo2');
    echo '<div style="text-align: center;"><br /><br /><img src="'. XOOPS_URL . "/uploads/{$moduleDirName}/photos/now_photo/{$photo2}" . 'border=0></div>';
}

echo '<div style="text-align: center;"><table><tr><td><a href=#  onClick="window.close()">' . constant($mainLang . '_CLOSEF') . '</a></td></tr></table></div>';
