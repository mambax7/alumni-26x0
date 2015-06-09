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
include __DIR__ . '/header.php';
$lid = (int)($_REQUEST['lid']);

global $xoopsUser, $xoopsConfig, $xoopsTheme, $xoopsDB, $xoops_footer, $xoopsLogger;
$currenttheme = $xoopsConfig['theme_set'];

$alumniListingHandler = $xoops->getModuleHandler('alumni_listing', 'alumni');
$listing_criteria     = new CriteriaCompo();
$listing_criteria->add(new Criteria('lid', $lid, '='));
$numrows     = $alumniListingHandler->getCount($listing_criteria);
$listing_arr = $alumniListingHandler->get($lid);

if ($numrows > '0') {
    $photo = $listing_arr->getvar('photo');
    echo '<center><br /><br /><img src="photos/grad_photo/$photo" border=0></center>';
}

echo '<center><table><tr><td><a href=#  onClick="window.close()">' . constant($main_lang . '_CLOSEF') . '</a></td></tr></table></center>';
