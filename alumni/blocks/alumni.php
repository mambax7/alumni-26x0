<?php
//  -----------------------------------------------------------------------  //
//                           Jobs for Xoops 2.0x                             //
//                              By John Mordo                                //
//  -----------------------------------------------------------------------  //

defined("XOOPS_ROOT_PATH") or die("XOOPS root path not defined");

include_once dirname(__DIR__) . '/include/common.php';
$xoops = Xoops::getInstance();
$alumni = Alumni::getInstance();
function alumni_show($options)
{

	$blockdirname = basename( dirname( dirname( __FILE__ ) ) ) ;
	$block_lang = '_MB_' . strtoupper( $blockdirname ) ;

	global $xoops, $helper, $blockdirname, $block_lang, $alumni;

	$block = array();
	$myts = MyTextSanitizer::getInstance();
	$alumni_listing_Handler = $xoops->getModuleHandler('alumni_listing', 'alumni');

	$listings = $alumni_listing_Handler->getListingPublished(0, $options[1], $options[0], 'DESC');
	foreach (array_keys($listings) as $l) {

		$a_item = array();
		$name = $myts->undoHtmlSpecialChars($listings[$l]->getVar("name"));
		$mname = $myts->undoHtmlSpecialChars($listings[$l]->getVar("mname"));
		$lname = $myts->undoHtmlSpecialChars($listings[$l]->getVar("lname"));
		$school = $myts->undoHtmlSpecialChars($listings[$l]->getVar("school"));
		$year = $myts->undoHtmlSpecialChars($listings[$l]->getVar("year"));
		$view = $myts->htmlSpecialChars($listings[$l]->getVar("view"));

	$a_item['name'] = $name;
	$a_item['mname'] = $mname;
	$a_item['lname'] = $lname;
	$a_item['school'] = $school;
	$a_item['year'] = $year;
	$a_item['view'] = $view;
	$a_item['id'] = $listings[$l]->getVar("lid");
	$a_item['cid'] = $listings[$l]->getVar("cid");
    	$a_item['link'] = "<a href=\"".XOOPS_URL."/modules/alumni/listing.php?lid=".addslashes($listings[$l]->getVar("lid"))."\"><b>$year<br />$name $mname $lname</b></a>";

	$block['items'][] = $a_item;
	}
	$block['lang_title'] = _MB_ALUMNI_ITEM;
	$block['lang_date'] = _MB_ALUMNI_DATE;
	$block['link'] = "<a href=\"".XOOPS_URL."/modules/alumni/index.php\"><b>"._MB_ALUMNI_ALL_LISTINGS."</b></a></div>";


	return $block;
	}

function alumni_edit($options) {
 global $xoopsDB;
	$blockdirname = basename( dirname( dirname( __FILE__ ) ) ) ;
	$block_lang = '_MB_' . strtoupper( $blockdirname ) ;

	$form = constant($block_lang."_ORDER")."&nbsp;<select name='options[]'>";
	$form .= "<option value='date'";
	if ( $options[0] == 'date' ) {
        $form .= " selected='selected'";
	}
	$form .= '>'.constant($block_lang."_DATE")."</option>\n";
	$form .= "<option value='view'";
	if($options[0] == 'view'){
        $form .= " selected='selected'";
	}
	$form .= '>'.constant($block_lang."_HITS").'</option>';
	$form .= "</select>\n";
	$form .= '&nbsp;'.constant($block_lang."_DISP")."&nbsp;<input type='text' name='options[]' value='".$options[1]."'/>&nbsp;".constant($block_lang."_LISTINGS");
	$form .= "&nbsp;<br /><br />".constant($block_lang."_CHARS")."&nbsp;<input type='text' name='options[]' value='".$options[2]."'/>&nbsp;".constant($block_lang."_LENGTH").'<br /><br />';

	return $form;
	}
