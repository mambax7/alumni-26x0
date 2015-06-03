<?php
//  -----------------------------------------------------------------------  //
//                           Alumni for Xoops 2.6.0                          //
//                            By John Mordo - jlm69                          //
//                             Licence Type   : GPL                          //
// ------------------------------------------------------------------------- //
include("header.php");

$mydirname = basename( dirname( __FILE__ ) ) ;
$main_lang =  '_' . strtoupper( $mydirname ) ;
require_once( XOOPS_ROOT_PATH."/modules/$mydirname/include/gtickets.php" ) ;
$myts = MyTextSanitizer::getInstance();
$xoops = Xoops::getInstance();
$module_id = $xoops->module->getVar('mid');

if (is_object($xoops->user)) {
    $groups = $xoops->user->getGroups();
} else {
	$groups = XOOPS_GROUP_ANONYMOUS;
}
$gperm_handler = $xoops->getHandler('groupperm');
if (isset($_POST['item_id'])) {
    $perm_itemid = (int)($_POST['item_id']);
} else {
    $perm_itemid = 0;
}
//If no access
if (!$gperm_handler->checkRight("".$mydirname."_view", $perm_itemid, $groups, $module_id)) {
    $xoops->redirect(XOOPS_URL."/index.php", 3, _NOPERM);
    exit();
}
if (!$gperm_handler->checkRight("".$mydirname."_premium", $perm_itemid, $groups, $module_id)) {
    $prem_perm = "0";
} else {
    $prem_perm = "1";
}

include(XOOPS_ROOT_PATH."/modules/$mydirname/include/functions.php");
include(XOOPS_ROOT_PATH."/class/pagenav.php");
$xoops->header('module:alumni/alumni_index.tpl');
Xoops::getInstance()->header();
//$xoops->tpl() = $xoops->tpl();
	$xoops->tpl()->assign('xmid', $xoopsModule->getVar('mid'));
	$xoops->tpl()->assign('add_from', _ALUMNI_ADDFROM." ".$xoopsConfig['sitename']);
	$xoops->tpl()->assign('add_from_title', _ALUMNI_ADDFROM );
	$xoops->tpl()->assign('add_from_sitename', $xoopsConfig['sitename']);
	$xoops->tpl()->assign('add_from_title', _ALUMNI_ADDFROM );
	$xoops->tpl()->assign('class_of', _ALUMNI_CLASSOF );
	$xoops->tpl()->assign('front_intro', _ALUMNI_FINTRO );

	if ($xoops->getModuleConfig("".$mydirname."_offer_search") == '1') {

	$xoops->tpl()->assign('offer_search', true);
	$xoops->tpl()->assign('search_listings', constant($main_lang."_SEARCH_LISTINGS") );
	$xoops->tpl()->assign('match', constant($main_lang."_MATCH") );
	$xoops->tpl()->assign('all_words', constant($main_lang."_ALL_WORDS") );
	$xoops->tpl()->assign('any_words', constant($main_lang."_ANY_WORDS") );
	$xoops->tpl()->assign('exact_match', constant($main_lang."_EXACT_MATCH") );
	$xoops->tpl()->assign('byyear', constant($main_lang."_SEARCH_BYYEAR") );
	$xoops->tpl()->assign('bycategory', constant($main_lang."_BYCATEGORY") );
	$xoops->tpl()->assign('keywords', constant($main_lang."_SEARCH_KEYWORDS") );
	$xoops->tpl()->assign('search', constant($main_lang."_SEARCH") );
	
	$alumni_categories_Handler = $xoops->getModuleHandler('alumni_categories', 'alumni');

        $alumni = Alumni::getInstance();
        $module_id = $xoops->module->getVar('mid');

        // get permitted id
        $groups = $xoops->isUser() ? $xoops->user->getGroups() : XOOPS_GROUP_ANONYMOUS;
        $alumni_ids = $alumni->getGrouppermHandler()->getItemIds('alumni_view', $groups, $module_id);
	$cat_criteria = new CriteriaCompo();
        $cat_criteria->add(new Criteria('cid', '(' . implode(', ', $alumni_ids) . ')', 'IN'));
	$cat_criteria->setOrder("".$xoops->getModuleConfig("".$mydirname."_csortorder")."");
	$numcat      = $alumni_categories_Handler->getCount();
	$category_arr = $alumni_categories_Handler->getall($cat_criteria);
	unset($cat_criteria);

        foreach (array_keys($category_arr) as $i) {
	$cid   = $category_arr[$i]->getVar("cid");
        $pid   = $category_arr[$i]->getVar("pid");
        $title = $category_arr[$i]->getVar("title", 'e');
        $img   = $category_arr[$i]->getVar("img");
        $order    = $category_arr[$i]->getVar("ordre");
        $affprice = $category_arr[$i]->getVar("affprice");
	$title = $myts->htmlSpecialChars($title);
	$xoops->tpl()->assign('title', $title);
}
	


	include_once(XOOPS_ROOT_PATH."/modules/alumni/class/alumni_tree.php");
	$cattree = new AlumniObjectTree($category_arr, "cid", "pid");

	

	$categories = $alumni->getCategoryHandler()->getCategoriesForSearch();
	$by_cat = AlumniRequest::getInt('by_cat');
	$select_category = "<select name=\"by_cat\">";
	$select_category .= "<option value=\"all\"";
	if (empty($by_cat) || count($by_cat) == 0) $select_category .= "selected=\"selected\"";
	$select_category .= ">" . XoopsLocale::ALL . "</option>";
	foreach ($categories as $cid => $title) {
	$select_category .= "<option value=\"" . $cid . "\"";
	if ($cid = $by_cat) $select_category .= "selected=\"selected\"";
	$select_category .= ">" . $title . "</option>";
	}
	$select_category .= "</select>";
	$xoops->tpl()->assign('category_select', $select_category);
	}

	$index_banner = $xoops->getbanner();
	$xoops->tpl()->assign('index_banner', $index_banner);
	$index_code_place = $xoops->getModuleConfig("".$mydirname."_code_place");
	$use_extra_code = $xoops->getModuleConfig("".$mydirname."_use_code");
	$use_banner = $xoops->getModuleConfig("".$mydirname."_use_banner");
	$index_extra_code = $xoops->getModuleConfig("".$mydirname."_index_code");
	$xoops->tpl()->assign('use_extra_code', $use_extra_code);
	$xoops->tpl()->assign('use_banner', $use_banner);
	$xoops->tpl()->assign('index_extra_code', "<html>".$index_extra_code."</html>");
	$xoops->tpl()->assign('index_code_place', $index_code_place);

	$cats = $cattree->alumni_getFirstChild(0, $alumni_ids);
	$count = 0;

	foreach (array_keys($cats) as $i) {
	if (in_array($cats[$i]->getVar('cid'), $alumni_ids)) {

        $alumni_listing_Handler = $xoops->getModuleHandler('alumni_listing', 'alumni');
        $count_criteria = new CriteriaCompo();
        $count_criteria->add(new Criteria('cid', $cats[$i]->getVar('cid'), '='));
        $count_criteria->add(new Criteria('valid', 1, '='));
        $count_criteria->add(new Criteria('cid', '(' . implode(', ', $alumni_ids) . ')', 'IN'));
        $listings = $alumni_listing_Handler->getCount($count_criteria);

		$publishdate = isset($listings['date'][$cats[$i]->getVar('cid')]) ? $listings['date'][$cats[$i]->getVar('cid')] : 0;
		$all_subcats = $cattree->alumni_getAllChild($cats[$i]->getVar('cid'));
		if (count($all_subcats) > 0) {
		   foreach (array_keys($all_subcats) as $k) {
		      if (in_array($all_subcats[$k]->getVar('cid'), $alumni_ids)) {
		         $publishdate = (isset($listings['date'][$all_subcats[$k]->getVar('cid')]) AND $listings['date'][$all_subcats[$k]->getVar('cid')] > $publishdate) ? $listings['date'][$all_subcats[$k]->getVar('cid')] : $publishdate;
		      }
		   }
		}

	$cat_img= $cats[$i]->getVar('img');
	if ($cat_img != 'http://'){
	$cat_img = XOOPS_URL . "/modules/$mydirname/images/cat/$cat_img";
	} else {
		$cat_img = '';
	}
        }
	$subcategories = array();

	$count++;

	$alumni_listing_Handler = $xoops->getModuleHandler('alumni_listing', 'alumni');
        $listing_criteria = new CriteriaCompo();
        $listing_criteria->add(new Criteria('cid', $cats[$i]->getVar('cid'), '='));
        $listing_criteria->add(new Criteria('valid', 1, '='));
        $listing_criteria->add(new Criteria('cid', '(' . implode(', ', $alumni_ids) . ')', 'IN'));
        $alumni_count = $alumni_listing_Handler->getCount($listing_criteria);

	if (count($all_subcats) > 0) {
	foreach (array_keys($all_subcats) as $k) {
   
	if (in_array($all_subcats[$k]->getVar('cid'), $alumni_ids)) {
   
   
        $alumni_listing_Handler = $xoops->getModuleHandler('alumni_listing', 'alumni');
        $sub_count_criteria = new CriteriaCompo();
        $sub_count_criteria->add(new Criteria('cid', $all_subcats[$k]->getVar('cid'), '='));
        $sub_count_criteria->add(new Criteria('valid', 1, '='));
        $sub_count_criteria->add(new Criteria('cid', '(' . implode(', ', $alumni_ids) . ')', 'IN'));
        $alumni_subcount = $alumni_listing_Handler->getCount($sub_count_criteria);  
   
         if($xoops->getModuleConfig('alumni_showsubcat') == 1 AND $all_subcats[$k]->getVar('pid') == $cats[$i]->getVar('cid')) { // if we are collecting subcat info for displaying, and this subcat is a first level child...
            $subcategories[] = array("id" => $all_subcats[$k]->getVar('cid'), "title" => $all_subcats[$k]->getVar('title'), "count" => $alumni_subcount);
	    }
	  }
      }
    }

	if($xoops->getModuleConfig('alumni_showsubcat') != 1) {
		unset($subcategories);
	  
		$xoops->tpl()->append('categories', array('image' => $cat_img,
			'id' => (int)($cats[$i]->getVar('cid')),
			'title' => $cats[$i]->getVar('title'),
			'totalcats' => (int)($alumni_count),
			'count' => (int)($count)));
	 } else {
		$xoops->tpl()->append('categories', array('image' => $cat_img,
			'id' => (int)($cats[$i]->getVar('cid')),
			'title' => $cats[$i]->getVar('title'),
			'subcategories' => $subcategories,
			'totalcats' => (int)($alumni_count),
			'count' => (int)($count)));
	 }
	}
	$xoops->tpl()->assign('total_confirm', "");
	$xoops->tpl()->assign('cat_count', $count-1);

	$alumni_listing_Handler = $xoops->getModuleHandler('alumni_listing', 'alumni');

	$xoops->tpl()->assign('moderated', false);
	if ($xoops->getModuleConfig("".$mydirname."_moderated") == '1') {
	$xoops->tpl()->assign('moderated', true);
        $moderate_criteria = new CriteriaCompo();
        $moderate_criteria->add(new Criteria('valid', 0, '='));
        $moderate_criteria->add(new Criteria('cid', '(' . implode(', ', $alumni_ids) . ')', 'IN'));
	$moderate_rows = $alumni_listing_Handler->getCount($moderate_criteria);
	$moderate_arr = $listing_Handler->getall($moderate_criteria);	
	
	if ($xoops->isUser()) {
	if ($xoops->user->isAdmin()) {
	$xoops->tpl()->assign('user_admin', true);

	$xoops->tpl()->assign('admin_block', _ALUMNI_ADMINCADRE);
	if($moderate_rows == 0) {
	$xoops->tpl()->assign('confirm_ads', _ALUMNI_NO_ALUM);
	
	} else {
	$xoops->tpl()->assign('confirm_ads', _ALUMNI_THEREIS." $moderate_rows  "._ALUMNI_WAIT."<br /><a href=\"admin/alumni.php?op=list_moderated\">"._ALUMNI_SEEIT."</a>");
	$xoops->tpl()->assign('total_confirm', _ALUMNI_AND." $moderate_rows "._ALUMNI_WAIT3);
	}
		
	}

		}
	}

        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('valid', 1, '='));
        $criteria->add(new Criteria('cid', '(' . implode(', ', $alumni_ids) . ')', 'IN'));
	$criteria->setLimit($xoops->getModuleConfig("".$mydirname."_per_page"));
	$numrows      = $alumni_listing_Handler->getCount($criteria);

	
		$xoops->tpl()->assign('total_listings', _ALUMNI_ACTUALY." $numrows "._ALUMNI_LISTINGS." "._ALUMNI_INCAT." $numcat "._ALUMNI_CAT2);

		$xoops->tpl()->assign('last_head', _ALUMNI_THE." ".$xoops->getModuleConfig("".$mydirname."_newalumni")." "._ALUMNI_LASTADD);
		$xoops->tpl()->assign('last_head_name', _ALUMNI_NAME2);
		$xoops->tpl()->assign('last_head_school', _ALUMNI_SCHOOL2);
		$xoops->tpl()->assign('last_head_studies', _ALUMNI_STUDIES);
		$xoops->tpl()->assign('last_head_year', _ALUMNI_YEAR);
		$xoops->tpl()->assign('last_head_date', _ALUMNI_DATE);
		$xoops->tpl()->assign('last_head_local', _ALUMNI_LOCAL2);
		$xoops->tpl()->assign('last_head_views', _ALUMNI_VIEW);
		$xoops->tpl()->assign('last_head_photo', _ALUMNI_PHOTO);
		$xoops->tpl()->assign('last_head_photo2', _ALUMNI_PHOTO2);	
	
	
	
	$listing_arr = $listing_Handler->getall($criteria);

         foreach (array_keys($listing_arr) as $i) {
            $lid   = $listing_arr[$i]->getVar("lid");
            $cid   = $listing_arr[$i]->getVar("cid");
            $name = $listing_arr[$i]->getVar("name");
            $mname   = $listing_arr[$i]->getVar("mname");
            $lname   = $listing_arr[$i]->getVar("lname");
            $school    = $listing_arr[$i]->getVar("school");
            $year = $listing_arr[$i]->getVar("year");
            $studies = $listing_arr[$i]->getVar("studies");
            $activities = $listing_arr[$i]->getVar("activities");   
            $extrainfo = $listing_arr[$i]->getVar("extrainfo");
            $occ    = $listing_arr[$i]->getVar("occ"); 
            $date   = $listing_arr[$i]->getVar("date");
            $date = XoopsLocale::formatTimestamp($date,'s');
            $email   = $listing_arr[$i]->getVar("email");
            $submitter = $listing_arr[$i]->getVar("submitter");
            $usid   = $listing_arr[$i]->getVar("usid");
            $town   = $listing_arr[$i]->getVar("town");         
            $valid = $listing_arr[$i]->getVar("valid");
            $photo   = $listing_arr[$i]->getVar("photo");
            $photo2   = $listing_arr[$i]->getVar("photo2");
            $view   = $listing_arr[$i]->getVar("view");



		$rank = 1;

			$a_item = array();
		$a_item['new'] = "";

		$newcount = $xoops->getModuleConfig("".$mydirname."_countday");
		$startdate = (time()-(86400 * $newcount));
		if ($startdate < $date) {
		$newitem = "<img src=\"".XOOPS_URL."/modules/$mydirname/images/newred.gif\" />";
		$a_item['new'] = $newitem;
			}

			$useroffset = "";
	    	if($xoops->user) {
				$timezone = $xoops->user->timezone();
				if(isset($timezone)) {
					$useroffset = $xoops->user->timezone();
				} else {
					$useroffset = $xoopsConfig['default_TZ'];
				}
			}
			$date = ($useroffset*3600) + $date;
			if ($xoops->user) {
				if ($xoops->user->isAdmin()) {
					$a_item['admin'] = "<a href='admin/alumni.php?op=edit_listing&amp;lid=$lid'><img src='images/modif.gif' border=0 alt=\""._ALUMNI_MODADMIN."\" /></a>";
				}
			}

			$a_item['name'] = "<a href='listing.php?lid=$lid'><b>$name&nbsp;$mname&nbsp;$lname</b></a>";
			$a_item['school'] = $school;
			$a_item['year'] = $year;
			$a_item['studies'] = $studies;
			$a_item['date'] = $date;
			$a_item['local'] = '';
			if ($town) {
				$a_item['local'] .= $town;
			}
			
			if ($photo) {
				$a_item['photo'] = "<a href=\"javascript:CLA('display-image.php?lid=$lid')\"><img src=\"".XOOPS_URL."/modules/alumni/images/photo.gif\" border=\"0\" width=\"15\" height=\"11\" alt='"._ALUMNI_IMGPISP."' /></a>";
			}
			if ($photo2) {
				$a_item['photo2'] = "<a href=\"javascript:CLA('display-image2.php?lid=$lid')\"><img src=\"images/photo.gif\" border=\"0\" width=\"15\" height=\"11\" alt='"._ALUMNI_IMGPISP."' /></a>";
			}
			
			$a_item['views'] = $view;

			$rank++;
			$xoops->tpl()->append('items', $a_item);
		}
	
Xoops::getInstance()->footer();
