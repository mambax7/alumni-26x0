<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/
use Xoops\Module\Plugin\PluginAbstract;
use Xmf\Metagen;
/**
 * alumni module
 * Edited by John Mordo (jlm69)
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @since           2.6.0
 * @author          Mage Grégory (AKA Mage)
 * @version         $Id: $
 */

defined('XOOPS_ROOT_PATH') or die('Restricted access');
include_once(XOOPS_ROOT_PATH."/modules/alumni/include/common.php");
class AlumniSearchPlugin extends PluginAbstract implements SearchPluginInterface
{
    public function search($queries, $andor, $limit, $offset, $uid)
    {
	global $by_cat, $xoops, $query;
	
	
    if (isset($_REQUEST["by_cat"])) {
        $by_cat = $_REQUEST['by_cat'];
        $by_cat = ((int)($by_cat) > 0) ? (int)($by_cat) : 0 ;
        }
	
	$alumni = Alumni::getInstance();
	$xoops = Xoops::getInstance();
//	$request = Xoops_Request::getInstance();
	$action = $_REQUEST['action'];
//	$query = $request->asStr('query');
//	$queries = array();
	$module_id = $xoops->module->getVar('mid');
	$listing_Handler = $xoops->getModuleHandler('alumni_listing', 'alumni');
	$groups = $xoops->isUser() ? $xoops->user->getGroups() : XOOPS_GROUP_ANONYMOUS;
        $alumni_ids = $alumni->getGrouppermHandler()->getItemIds('alumni_view', $groups, $module_id);
        $criteria = new CriteriaCompo();
	$criteria->setStart($offset);
	$criteria->setLimit($limit);
	$criteria->setSort('date');
	$criteria->setOrder('DESC');
        $criteria->add(new Criteria('valid', 1, '='));
        $criteria->add(new Criteria('date', time(), '<='));
        $criteria->add(new Criteria('cid', '(' . implode(', ', $alumni_ids) . ')', 'IN'));
        if ( $uid != 0 ) {
        $criteria->add(new Criteria('usid', $uid, '='));
        }
        
//	if ($by_cat != "0" ) {     
        $criteria->add(new Criteria('cid', $by_cat, '='));
 //       }
//        if ( is_array($queries) && $count = count($queries) )
//        {
	$queries = array($query);
//	$count = count($queries);


	$queries = implode('+', $queries);
	$count = count($queries);
//	$i=1;
  //     $queries = clone($criteria);
//	for ($i = 0; $i < $count; $i ++) {



 
//if ($queries) {
	$criteriaKeywords = new CriteriaCompo();
	for($x = 0; $x < count($queries); $x++) {


//foreach ($queries as $key => $value) {


	$thisSearchTerm  = count($queries) > 0 ? $queries[$x] : '';
	$criteriaKeyword = new CriteriaCompo();
	
        $criteriaKeyword->add(new Criteria('name', '%' . $thisSearchTerm . '%', 'LIKE'), 'AND');
        $criteriaKeyword->add(new Criteria('mname', '%' . $thisSearchTerm . '%', 'LIKE'), 'OR');
        $criteriaKeyword->add(new Criteria('lname', '%' . $thisSearchTerm . '%', 'LIKE'), 'OR');
        $criteriaKeyword->add(new Criteria('school', '%' . $thisSearchTerm . '%', 'LIKE'), 'OR');
        $criteriaKeyword->add(new Criteria('year', '%' . $thisSearchTerm . '%', 'LIKE'), 'OR');
        }
	$criteriaKeywords->add($criteriaKeyword, $andor);
	unset($criteriaKeyword);
	unset($queries);
			
			$criteria->add($criteriaKeywords);
	//	}
	unset($criteriaKeywords);





//	}
		$numrows = $listing_Handler->getCount();
		$this_search = $listing_Handler->getObjects($criteria,true);
	
        	$ret = array();
		$k = 0;    
 
		foreach (array_keys($this_search) as $i) {

		$ret[$k]['image'] = "images/cat/default.gif";
		$ret[$k]['link'] = "listing.php?lid=".$this_search[$i]->getVar('lid')."";
		$ret[$k]['title'] = $this_search[$i]->getVar('name')." ".$this_search[$i]->getVar('mname')." ".$this_search[$i]->getVar('lname')."   ---   ".$this_search[$i]->getVar('school')."   
		---   ".$this_search[$i]->getVar('year');
		$ret[$k]['time'] = $this_search[$i]->getVar('date');
		$ret[$k]['uid'] = $this_search[$i]->getVar('usid');
		++$k;
		}

	return $ret;

}
}
