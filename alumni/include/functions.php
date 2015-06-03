<?php
//  -----------------------------------------------------------------------  //
//                           Alumni for Xoops 2.6.0                          //
//                            By John Mordo - jlm69                          //
//  -----------------------------------------------------------------------  //

$mydirname = basename(dirname(__DIR__));

	require_once( XOOPS_ROOT_PATH."/modules/$mydirname/include/gtickets.php" ) ;

$xoops = Xoops::getInstance();
$alumni_listing_Handler = $xoops->getModuleHandler('alumni_listing', 'alumni');

function alumni_ShowImg()
{	
	global $mydirname;
	
	echo "<script type=\"text/javascript\">\n";
	echo "<!--\n\n";
	echo "function showimage() {\n";
	echo "if (!document.images)\n";
	echo "return\n";
	echo "document.images.avatar.src=\n";
	echo "'".XOOPS_URL."/modules/$mydirname/images/cat/' + document.imcat.img.options[document.imcat.img.selectedIndex].value\n";
	echo "}\n\n";
	echo "//-->\n";
	echo "</script>\n";
}

function alumni_ShowImg2()
{
	global $mydirname;
	
	echo "<script type=\"text/javascript\">\n";
	echo "<!--\n\n";
	echo "function showimage2() {\n";
	echo "if (!document.images)\n";
	echo "return\n";
	echo "document.images.scphoto.src=\n";
	echo "'".XOOPS_URL."/modules/$mydirname/images/schools/' + document.imcat.scphoto.options[document.imcat.scphoto.selectedIndex].value\n";
	echo "}\n\n";
	echo "//-->\n";
	echo "</script>\n";
}
//Reusable Link Sorting Functions
function alumni_convertorderbyin($orderby) {
	switch (trim($orderby)) {
	case "nameA":
		$orderby = "lname ASC";
		break;
	case "schoolA":
		$orderby = "school ASC";
		break;
	case "studiesA":
		$orderby = "studies ASC";
		break;
	case "yearA":
		$orderby = "year ASC";
		break;
	case "dateA":
		$orderby = "date ASC";
		break;
	case "viewA":
		$orderby = "view ASC";
		break;
	case "nameD":
		$orderby = "lname DESC";
		break;
	case "schoolD":
		$orderby = "school DESC";
		break;
	case "studiesD":
		$orderby = "studies DESC";
		break;
	case "yearD":
		$orderby = "year DESC";
		break;
	case "viewD":
		$orderby = "view DESC";
		break;
	case "dateD":
	default:
		$orderby = "date DESC";
		break;
	}
	return $orderby;
}

function alumni_convertorderbytrans($orderby) {

	global $main_lang;

            if ($orderby == "view ASC")    $orderbyTrans = "".constant($main_lang."_POPULARITYLTOM")."";
            if ($orderby == "view DESC")   $orderbyTrans = "".constant($main_lang."_POPULARITYMTOL")."";
            if ($orderby == "lname ASC")    $orderbyTrans = "".constant($main_lang."_NAMEATOZ")."";
	    if ($orderby == "lname DESC")   $orderbyTrans = "".constant($main_lang."_NAMEZTOA")."";
            if ($orderby == "school ASC")  $orderbyTrans = "".constant($main_lang."_SCHOOLATOZ")."";
	    if ($orderby == "school DESC") $orderbyTrans = "".constant($main_lang."_SCHOOLZTOA")."";
            if ($orderby == "studies ASC")  $orderbyTrans = "".constant($main_lang."_STUDIESATOZ")."";
	    if ($orderby == "studies DESC") $orderbyTrans = "".constant($main_lang."_STUDIESZTOA")."";
            if ($orderby == "year ASC")    $orderbyTrans = "".constant($main_lang."_YEAROLD")."";
	    if ($orderby == "year DESC")   $orderbyTrans = "".constant($main_lang."_YEARNEW")."";
            if ($orderby == "date ASC")    $orderbyTrans = "".constant($main_lang."_DATEOLD")."";
            if ($orderby == "date DESC")   $orderbyTrans = "".constant($main_lang."_DATENEW")."";
            return $orderbyTrans;
}
function alumni_convertorderbyout($orderby) {
            if ($orderby == "lname ASC")            $orderby = "nameA";
            if ($orderby == "school ASC")          $orderby = "schoolA";
            if ($orderby == "studies ASC")          $orderby = "studiesA";
            if ($orderby == "year ASC")            $orderby = "yearA";
            if ($orderby == "date ASC")            $orderby = "dateA";
            if ($orderby == "view ASC")            $orderby = "viewA";
            if ($orderby == "lname DESC")           $orderby = "nameD";
            if ($orderby == "school DESC")         $orderby = "schoolD";
            if ($orderby == "studies DESC")         $orderby = "studiesD";
            if ($orderby == "year DESC")           $orderby = "yearD";
            if ($orderby == "date DESC")           $orderby = "dateD";
            if ($orderby == "view DESC")           $orderby = "viewD";
            return $orderby;
}

function alumni_newlinkgraphic($cid) {
	global $xoops, $mydirname;
        $alumni = Alumni::getInstance();
        $module_id = $xoops->module->getVar('mid');
        // get permitted id
        $groups = $xoops->isUser() ? $xoops->user->getGroups() : XOOPS_GROUP_ANONYMOUS;
        $alumni_ids = $alumni->getGrouppermHandler()->getItemIds('alumni_view', $groups, $module_id);
	$alumni_listing_Handler = $xoops->getModuleHandler('alumni_listing', 'alumni');
        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('cid', $cid, '='));
        $criteria->add(new Criteria('valid', 1, '='));
        $criteria->add(new Criteria('cid', '(' . implode(', ', $alumni_ids) . ')', 'IN'));
	$numrows      = $alumni_listing_Handler->getCount($criteria);
	$listing_arr = $alumni_listing_Handler->getall($criteria);
         foreach (array_keys($listing_arr) as $i) {
        $date   = $listing_arr[$i]->getVar("date");
	$count = 1;
	$new = '';
	$startdate = (time()-(86400 * $count));
	if ($startdate < $date) {
	$new = "&nbsp;<img src=\"".XOOPS_URL."/modules/" .$mydirname. "/images/newred.gif\" alt=\"\" />";
}
	
	return $new;
}
}

function alumni_filechecks() {
global $xoopsModule, $xoopsConfig;

	echo "<fieldset>";
	echo "<legend style=\"color: #990000; font-weight: bold;\">" . _AM_ALUMNI_FILECHECKS . "</legend>";

	$photodir = XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar('dirname') . "/photo";
	$photothumbdir = XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar('dirname') . "/photo/thumbs";
	$photohighdir = XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar('dirname') . "/photo/midsize";

	$grad_photo_dir = XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar('dirname') . "/photos/grad_photo";
	$now_photo_dir = XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar('dirname') . "/photos/now_photo";
	$school_photo_dir = XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar('dirname') . "/photos/school_photos";

	// grad_photo_dir
	if(file_exists($grad_photo_dir)) {
		if (!is_writable($grad_photo_dir)) {
			echo "<span style=\" color: red; font-weight: bold;\">Warning:</span> I am unable to write to: " . $grad_photo_dir . "<br />";
		} else {
			echo "<span style=\" color: green; font-weight: bold;\">OK:</span> " . $grad_photo_dir . "<br />";
		}
	} else {
		echo "<span style=\" color: red; font-weight: bold;\">Warning:</span> " . $grad_photo_dir . " does NOT exist!<br />";
	}
	
	//now_photo_dir
	if(file_exists($now_photo_dir)) {
		if (!is_writable($now_photo_dir)) {
			echo "<span style=\" color: red; font-weight: bold;\">Warning:</span> I am unable to write to: " . $now_photo_dir . "<br />";
		} else {
			echo "<span style=\" color: green; font-weight: bold;\">OK:</span> " . $now_photo_dir . "<br />";
		}
	} else {
		echo "<span style=\" color: red; font-weight: bold;\">Warning:</span> " . $now_photo_dir . " does NOT exist!<br />";
	}

	// school_photo_dir
	if(file_exists($school_photo_dir)) {
		if (!is_writable($school_photo_dir)) {
			echo "<span style=\" color: red; font-weight: bold;\">Warning:</span> I am unable to write to: " . $school_photo_dir . "<br />";
		} else {
			echo "<span style=\" color: green; font-weight: bold;\">OK:</span> " . $school_photo_dir . "<br />";
		}
	} else {
		echo "<span style=\" color: red; font-weight: bold;\">Warning:</span> " . $school_photo_dir . " does NOT exist!<br />";
	}

	/**
	* Some info.
	*/
	$uploads = (ini_get('file_uploads')) ? _AM_ALUMNI_UPLOAD_ON : _AM_ALUMNI_UPLOAD_OFF;
	echo "<br />";
	echo "<ul>";
	echo "<li>" . _AM_ALUMNI_UPLOADMAX ."<b>". ini_get('upload_max_filesize') . "</b></li>";
	echo "<li>" . _AM_ALUMNI_POSTMAX ."<b>". ini_get('post_max_size') . "</b></li>";
	echo "<li>" . _AM_ALUMNI_UPLOADS ."<b>". $uploads . "</b></li>";

	$gdinfo = gd_info();
	if(function_exists('gd_info')) {
		echo "<li>" . _AM_ALUMNI_GDIMGSPPRT  ."<b>". _AM_ALUMNI_GDIMGON ."</b></li>";
		echo "<li>". _AM_ALUMNI_GDIMGVRSN ."<b>". $gdinfo['GD Version'] . "</b></li>";
	} else {
		echo "<li>" . _AM_ALUMNI_GDIMGSPPRT  ."<b>". _AM_ALUMNI_GDIMGOFF ."</b></li>";
	}
	echo "</ul>";

	echo "</fieldset>";

} 