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
include("header.php");
$lid = intval($_REQUEST['lid']);

global $xoopsUser, $xoopsConfig, $xoopsTheme, $xoopsDB, $xoops_footer, $xoopsLogger;
$currenttheme = $xoopsConfig['theme_set'];

	$alumni_listing_Handler = $xoops->getModuleHandler('alumni_listing', 'alumni');
        $listing_criteria = new CriteriaCompo();
        $listing_criteria->add(new Criteria('lid', $lid, '='));
	$numrows      = $alumni_listing_Handler->getCount($listing_criteria);
	$listing_arr = $alumni_listing_Handler->get($lid);

if ($numrows > '0')
{
	$photo2 = $listing_arr->getvar('photo2');
	echo "<center><br /><br /><img src=\"photos/now_photo/$photo2\" border=0></center>";
}

echo "<center><table><tr><td><a href=#  onClick='window.close()'>"._ALUMNI_CLOSEF."</a></td></tr></table></center>";

