<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * page module
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @since           2.6.0
 * @author          Mage Grégory (AKA Mage)
 * @version         $Id: notifications.php 10605 2012-12-29 14:19:09Z trabis $
 */

defined("XOOPS_ROOT_PATH") or die("XOOPS root path not defined");
$mydirname = basename(dirname(dirname(__FILE__)));
include_once (XOOPS_ROOT_PATH . "/modules/alumni/include/functions.php");
//include_once (XOOPS_ROOT_PATH . "/modules/jobs/include/resume_functions.php");




class AlumniNotificationsPlugin extends Xoops\Module\Plugin\PluginAbstract implements NotificationsPluginInterface
{
    /**
     * @param string $category
     * @param int    $item_id
     *
     * @return array
     */
    public function item($category, $item_id)
    {
    

    
    
        $xoops = Xoops::getInstance();
        $item = array();
        $item_id = (int) $item_id;


        
        
        if ($category == 'global') {
            $item['name'] = '';
            $item['url'] = '';
            return $item;
        }


//        global $xoopsDB, $mydirname;    
        
	if ($category=='category') {

		// Assume we have a valid topid id
		$sql = 'SELECT title  FROM '. $xoopsDB->prefix("alumni_categories") .' WHERE cid = '. $item_id .' limit 1';
//echo $sql;
		$result = $xoopsDB->query($sql); // TODO: error check
		$result_array = $xoopsDB->fetchArray($result);
		$item['name'] = $result_array['title'];
//		$item['type'] = $result_array['ann.type'];		
		$item['url'] = XOOPS_URL . '/modules/' . $module->getVar('dirname') . '/categories.php?cid=' .  $item_id;
		return $item;
	}

	if ($category=='listing') {
		// Assume we have a valid post id
		$sql = 'SELECT title FROM ' . $xoopsDB->prefix("alumni_listing").  ' WHERE lid = ' . $item_id . ' LIMIT 1';
		$result = $xoopsDB->query($sql);
		$result_array = $xoopsDB->fetchArray($result);
		$item['name'] = $result_array['title'];
//		$item['catname'] = $result_array['cat.title'];
		$item['url'] = XOOPS_URL . '/modules/' . $module->getVar('dirname') . '/listing.php?lid= ' .  $item_id;
		return $item;
	}
        return $item;
    }

    /**
     * @return array
     */
    public function categories()
    {
     
        $ret = array();
        $ret[1]['name']           = 'global';
        $ret[1]['title']          = _MI_ALUMNI_GLOBAL_NOTIFY;
        $ret[1]['description']    = _MI_ALUMNI_GLOBAL_NOTIFYDSC;
        $ret[1]['subscribe_from'] = array('index.php', 'categories.php');



        $ret[2]['name']           = 'category';
        $ret[2]['title']          = _MI_ALUMNI_CATEGORY_NOTIFY;
        $ret[2]['description']    = _MI_ALUMNI_CATEGORY_NOTIFYDSC;
        $ret[2]['subscribe_from'] = array('categories.php');
        $ret[2]['item_name']      = 'cid';
        $ret[2]['allow_bookmark'] = 1;


        $ret[3]['name']           = 'alumni_listing';
        $ret[3]['title']          = _MI_ALUMNI_NOTIFY;
        $ret[3]['description']    = _MI_ALUMNI_NOTIFYDSC;
        $ret[3]['subscribe_from'] = array('listing.php');
        $ret[3]['item_name']      = 'lid';
        $ret[3]['allow_bookmark'] = 1;


               
        return $ret;
    }

    /**
     * @return array
     */
    public function events()
    {    
        $ret = array();    


//event
//alumni notifications new listings in this category
$ret[1]['name'] = 'new_listing';
$ret[1]['category'] = 'category';
$ret[1]['title'] = _MI_ALUMNI_NEWPOST_NOTIFY;
$ret[1]['caption'] = _MI_ALUMNI_NEWPOST_NOTIFYCAP;
$ret[1]['description'] = _MI_ALUMNI_NEWPOST_NOTIFYDSC;
$ret[1]['mail_template'] = 'listing_newpost_notify';
$ret[1]['mail_subject'] = _MI_ALUMNI_NEWPOST_NOTIFYSBJ;
 
//new listings in all categories posted
$ret[2]['name'] = 'new_listing';
$ret[2]['category'] = 'global';
$ret[2]['title'] = _MI_ALUMNI_GLOBAL_NEWPOST_NOTIFY;
$ret[2]['caption'] = _MI_ALUMNI_GLOBAL_NEWPOST_NOTIFYCAP;
$ret[2]['description'] = _MI_ALUMNI_GLOBAL_NEWPOST_NOTIFYDSC;
$ret[2]['mail_template'] = 'listing_newpost_notify';
$ret[2]['mail_subject'] = _MI_ALUMNI_GLOBAL_NEWPOST_NOTIFYSBJ;


        return $ret;
    }
    
    
    /**
     * @param string $category
     * @param int    $item_id
     * @param string $event
     *
     * @return array
     */
    public function tags($category, $item_id, $event)
    {
        return array();
    }
}