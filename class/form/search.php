<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

use Xoops\Core\Request;

/**
 * @copyright       XOOPS Project https://xoops.org/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id$
 */

defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');
$moduleDirName = basename(dirname(dirname(__DIR__)));
include_once(XOOPS_ROOT_PATH . "/modules/{$moduleDirName}/class/alumni_tree.php");

/**
 * Class AlumniSearchForm
 */
class AlumniSearchForm extends Xoops\Form\ThemeForm
{
    /**
     * We are not using this for objects but we need to override the constructor
     * @param null $obj
     */
    public function __construct($obj = null)
    {
    }

    /**
     * @param $andor
     * @param $queries
     * @param $mids
     * @param $mid
     * @param $bycat
     * @return $this
     */
    public function alumni_getSearchFrom($andor, $queries, $mids, $mid, $bycat)
    {
        $xoops  = Xoops::getInstance();
        //get local language for SystemLocale
        $xoops->loadLocale('system');
        $alumni = Alumni::getInstance();
        // create form
        parent::__construct(XoopsLocale::SEARCH, 'alumni', 'search.php', 'get');

        // create form elements
        $this->addElement(new XoopsFormText(XoopsLocale::KEYWORDS, 'query', 30, 255, htmlspecialchars(stripslashes(implode(' ', $queries)), ENT_QUOTES)), true);
        $typeSelect = new XoopsFormSelect(XoopsLocale::TYPE, 'andor', $andor);
        $typeSelect->addOptionArray(array(
                                        'AND'   => XoopsLocale::ALL_AND,
                                        'OR'    => XoopsLocale::ANY_OR,
                                        'exact' => XoopsLocale::EXACT_MATCH));
        $this->addElement($typeSelect);

        //   if (isset($_REQUEST['by_cat'])) {
        //      $by_cat = $_REQUEST['by_cat'];
        //       $by_cat = ((int)($by_cat) > 0) ? (int)($by_cat) : 0 ;
        //       }

        //     $by_cat = $request->asInt('by_cat','');
//        $by_cat = 0;
//        if (!empty($_GET['by_cat'])) {
//            $by_cat = (int)($_GET['by_cat']);
//        } elseif (!empty($_POST['by_cat'])) {
//            $by_cat = (int)($_POST['by_cat']);
//        }

        $by_cat = Request::getInt('by_cat', Request::getInt('by_cat', 0, 'POST'), 'GET');

        // $alumniCategoryHandler = $xoops->getModuleHandler('Category', $moduleDirName);
        $search                  = Search::getInstance();
        //      $xoops = $helper->xoops();
        $moduleId = $xoops->module->getVar('mid');

        // get permitted id
        $groups    = $xoops->isUser() ? $xoops->user->getGroups() : SystemLocale::ANONYMOUS_USERS_GROUP;
        $alumniIds = $alumni->getGrouppermHandler()->getItemIds('alumni_view', $groups, $moduleId);
        $criteria  = new CriteriaCompo();
        $criteria->add(new Criteria('cid', '(' . implode(', ', $alumniIds) . ')', 'IN'));
        $criteria->setOrder($xoops->getModuleConfig('alumni_csortorder'));

        $categoryArray = $categoryHandler->getAll($criteria);

        foreach (array_keys($categoryArray) as $i) {
            $cid   = $categoryArray[$i]->getVar('cid');
            $pid   = $categoryArray[$i]->getVar('pid');
            $title = $categoryArray[$i]->getVar('title');

            //$catSelect = new XoopsFormSelect(_ALUMNI_CATEGORIES, 'title', $title);
            //$catSelect->addOption('title', $title);
        }

        //           $cattree = new AlumniObjectTree($categoryArray, 'cid', 'pid');

        //       $this->addElement(new XoopsFormLabel(_ALUMNI_CAT, $cattree->alumni_makeSelBox('bycat', 'title', '-', $by_cat, true)));
        //       $this->addElement(new XoopsFormHidden('bycat', $bycat));

        $categories     = $alumni->getCategoryHandler()->getCategoriesForSearch();
        $categorySelect = new XoopsFormSelect(AlumniLocale::L_ALUMNI_CATEGORIES, 'by_cat', $by_cat);
        foreach ($categories as $cid => $title) {
            $categorySelect->addOption('0', XoopsLocale::ALL);
            $categorySelect->addOptionArray(array($cid => $title));
        }
        $this->addElement($categorySelect);

        if (!empty($mids)) {
            $mods_checkbox = new XoopsFormCheckBox(XoopsLocale::SEARCH_IN, 'mids[]', $mids);
        } else {
            $mods_checkbox = new XoopsFormCheckBox(XoopsLocale::SEARCH_IN, 'mids[]', $mid);
        }
        if (empty($modules)) {
            $groupPermHandler  = $xoops->getHandlerGroupperm();
            $available_modules = $groupPermHandler->getItemIds('module_read', $xoops->getUserGroups());
            $available_plugins = Xoops\Module\Plugin::getPlugins('search');

            //todo, would be nice to have the module ids availabe also
            $criteria = new CriteriaCompo();
            $criteria->add(new Criteria('dirname', '(\'' . implode('\',\'', array_keys($available_plugins)) . '\')', 'IN'));
            if (isset($available_modules) && !empty($available_modules)) {
                $criteria->add(new Criteria('mid', '(' . implode(',', $available_modules) . ')', 'IN'));
            }
            $moduleHandler = $xoops->getHandlerModule();
            $mods_checkbox->addOptionArray($moduleHandler->getNameList($criteria));
        } else {
            /* @var $module XoopsModule */
            $module_array = array();
            foreach ($modules as $mid => $module) {
                $module_array[$mid] = $module->getVar('name');
            }
            $mods_checkbox->addOptionArray($module_array);
        }
        $this->addElement($mods_checkbox);
        if ($search->getConfig('keyword_min') > 0) {
            $this->addElement(new XoopsFormLabel(XoopsLocale::SEARCH_RULE, sprintf(XoopsLocale::EF_KEYWORDS_MUST_BE_GREATER_THAN, $search->getConfig('keyword_min'))));
        }
        $this->addElement(new XoopsFormHidden('action', 'results'));
        $this->addElement(new XoopsFormHiddenToken('id'));
        $this->addElement(new XoopsFormButton('', 'submit', XoopsLocale::SEARCH, 'submit'));

        return $this;
    }
}
