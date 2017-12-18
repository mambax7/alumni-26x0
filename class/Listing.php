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
 * ALUMNI module
 *
 * @copyright       XOOPS Project https://xoops.org/
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package         alumni
 * @since           2.6.0
 * @author          John Mordo (jlm69)
 */

use Xoops\Core\Database\Connection;
use Xoops\Core\Request;


//defined('XOOPS_ROOT_PATH') or exit('XOOPS root path not defined');
//$xoops = Xoops::getInstance();

/**
 * Class Listing
 */
class Listing extends Xoops\Core\Kernel\XoopsObject
{
    /**
     * @var Alumni
     * @access public
     */
    public $alumni;

    /**
     * Constructor
     */
    public function __construct()
    {
        $xoops = Xoops::getInstance();
        $this->db = $xoops->db();
        $this->initVar('lid', XOBJ_DTYPE_INT, null, false, 11);
        $this->initVar('cid', XOBJ_DTYPE_INT, null, false, 11);
        $this->initVar('name', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('mname', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('lname', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('school', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('year', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('studies', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('activities', XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar('extrainfo', XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar('occ', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('date', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('email', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('submitter', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('usid', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('town', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('valid', XOBJ_DTYPE_INT, null, false, 3);
        $this->initVar('photo', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('photo2', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('view', XOBJ_DTYPE_TXTBOX, null, false);
    }

    /**
     * @return mixed
     */
    public function get_new_id()
    {
        $xoops  = Xoops::getInstance();
        $new_id = $xoops->db()->getInsertId();

        return $new_id;
    }

    /**
     * @param bool $action
     * @return XoopsThemeForm
     */
    public function getAdminForm($action = false)
    {
//        global $xoopsDB;
        $xoops = Xoops::getInstance();
        if ($action === false) {
            $action = Request::getVar('REQUEST_URI', '', 'SERVER');
        }

        $moduleDirName = basename(dirname(__DIR__));
        $xoops->loadLanguage('admin', $moduleDirName);

        $adminLang = '_AM_' . strtoupper($moduleDirName);

        $title = $this->isNew() ? sprintf(constant($adminLang . '_ADD_LINK')) : sprintf(constant($adminLang . '_LISTING_EDIT'));

        include_once(XOOPS_ROOT_PATH . '/class/xoopsformloader.php');

        $helper = Alumni::getInstance();
        $categoryHandler = $helper->getCategoryHandler();

        $memberHandler = $xoops->getHandlerMember();
        $userGroups    = $memberHandler->getGroupList();

        $form = new Xoops\Form\ThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        $form->addElement(new Xoops\Form\Label(constant($adminLang . '_SUBMITTER'), $xoops->user->uname()));

        // $alumniCategoryHandler = $xoops->getModuleHandler('Category', $moduleDirName);
        $categories              = $categoryHandler->getObjects();
        $mytree                  = new XoopsObjectTree($categories, 'cid', 'pid');
        $categorySelect          = $mytree->makeSelBox('cid', 'title', '--', $this->getVar('cid', 'e'), true);
        $form->addElement(new Xoops\Form\Label(constant($adminLang . '_CAT'), $categorySelect), true);

        $cat_name                = '';
        // $alumniCategoryHandler = $xoops->getModuleHandler('Category', $moduleDirName);
        $catObj                  = $categoryHandler->get($this->getVar('cid'));
        $cat_name                = $catObj->getVar('title');
        $form->addElement(new Xoops\Form\Hidden('school', $cat_name));
        $form->addElement(new Xoops\Form\Text(AlumniLocale::A_NAME_2, 'name', 50, 255, $this->getVar('name')), true);
        $form->addElement(new Xoops\Form\Text(AlumniLocale::A_MNAME_2, 'mname', 50, 255, $this->getVar('mname')), false);
        $form->addElement(new Xoops\Form\Text(AlumniLocale::A_LNAME_2, 'lname', 50, 255, $this->getVar('lname')), true);
        $form->addElement(new Xoops\Form\Text(AlumniLocale::A_CLASS_OF_2, 'year', 50, 255, $this->getVar('year')), true);
        $form->addElement(new Xoops\Form\Text(AlumniLocale::A_STUDIES_2, 'studies', 50, 255, $this->getVar('studies')), false);

        $activities              = $this->getVar('activities', 'e') ?: '';
        $editorConfigs           = array();
        $editorConfigs['name']   = 'activities';
        $editorConfigs['value']  = $activities;
        $editorConfigs['editor'] = $xoops->getModuleConfig('alumni_form_options');
        $editorConfigs['rows']   = 6;
        $editorConfigs['cols']   = 8;
        $form->addElement(new Xoops\Form\Editor(constant($adminLang . '_ACTIVITIES'), 'activities', $editorConfigs), false);

        $extrainfo               = $this->getVar('extrainfo', 'e') ?: '';
        $editorConfigs           = array();
        $editorConfigs['name']   = 'extrainfo';
        $editorConfigs['value']  = $extrainfo;
        $editorConfigs['editor'] = $xoops->getModuleConfig('alumni_form_options');
        $editorConfigs['rows']   = 6;
        $editorConfigs['cols']   = 8;
        $form->addElement(new Xoops\Form\Editor(constant($adminLang . '_EXTRAINFO'), 'extrainfo', $editorConfigs), false);

        $photo_old            = $this->getVar('photo') ?: '';
        $uploadDirectoryPhoto = XOOPS_ROOT_PATH . "/uploads/{$moduleDirName}/photos/grad_photo";
        $imageTrayPhoto       = new Xoops\Form\ElementTray(constant($adminLang . '_PHOTO'), '<br />');
        $imagePathPhoto       = sprintf(constant($adminLang . '_FORMIMAGE_PATH'), $uploadDirectoryPhoto);
        $fileSelectTrayPhoto  = new Xoops\Form\ElementTray('', '<br />');
        $fileSelectTrayPhoto->addElement(new Xoops\Form\File(constant($adminLang . '_FORMUPLOAD'), 'photo', $xoops->getModuleConfig('alumni_photomax')), false);

        if ($photo_old) {
            $fileSelectTrayPhoto->addElement(new Xoops\Form\Label(constant($adminLang . '_GRAD_PIC'), '<a href="'. XOOPS_URL . "/uploads/{$moduleDirName}/photos/grad_photo/" .  $photo_old . '">' . $photo_old . '</a>', false));
            $imageTrayCheckbox = new Xoops\Form\Checkbox('', 'del_photo', 0);
            $imageTrayCheckbox->addOption(1, constant($adminLang . '_DELPICT'));
            $fileSelectTrayPhoto->addElement($imageTrayCheckbox);
        }
        $imageTrayPhoto->addElement($fileSelectTrayPhoto);
        $form->addElement($imageTrayPhoto);
        $form->addElement(new Xoops\Form\Hidden('photo_old', $photo_old));

        $photo2_old            = $this->getVar('photo2') ?: '';
        $uploadDirectoryPhoto2 = XOOPS_ROOT_PATH . "/uploads/{$moduleDirName}/photos/now_photo";
        $imageTrayPhoto2       = new Xoops\Form\ElementTray(constant($adminLang . '_PHOTO2'), '<br />');
        $imagePathPhoto2       = sprintf(constant($adminLang . '_FORMIMAGE_PATH'), $uploadDirectoryPhoto2);
        $fileSelectTrayPhoto2  = new Xoops\Form\ElementTray('', '<br />');
        $fileSelectTrayPhoto2->addElement(new Xoops\Form\File(constant($adminLang . '_FORMUPLOAD'), 'photo2', $xoops->getModuleConfig('alumni_photomax')), false);

        if ($photo_old) {
            $fileSelectTrayPhoto2->addElement(new Xoops\Form\Label(constant($adminLang . '_NOW_PIC'), '<a href="'. XOOPS_URL . "/uploads/{$moduleDirName}/photos/now_photo/" . $photo2_old . '">' . $photo2_old . '</a>', false));

            $imageTrayCheckbox2 = new Xoops\Form\Checkbox('', 'del_photo2', 0);
            $imageTrayCheckbox2->addOption(1, constant($adminLang . '_DELPICT'));
            $fileSelectTrayPhoto2->addElement($imageTrayCheckbox2);
        }
        $imageTrayPhoto2->addElement($fileSelectTrayPhoto2);
        $form->addElement($imageTrayPhoto2);
        $form->addElement(new Xoops\Form\Hidden('photo2_old', $photo2_old));
        $form->addElement(new Xoops\Form\Text(AlumniLocale::A_EMAIL_2, 'email', 50, 255, $this->getVar('email')), true);
        $form->addElement(new Xoops\Form\Text(AlumniLocale::A_OCC_2, 'occ', 50, 255, $this->getVar('occ')), false);
        $form->addElement(new Xoops\Form\Text(AlumniLocale::A_TOWN_2, 'town', 50, 255, $this->getVar('town')), false);
        $form->addElement(new Xoops\Form\RadioYesNo(AlumniLocale::A_APPROVE_2, 'valid', $this->getVar('valid'), XoopsLocale::YES, XoopsLocale::NO));

        if ($tempDate = Request::getString('date', '', 'POST')) {
            $form->addElement(new Xoops\Form\Hidden('date', $tempDate));
        } else {
            $form->addElement(new Xoops\Form\Hidden('date', time()));
        }

        $form->addElement(new Xoops\Form\Hidden('submitter', $xoops->user->uname()));
        $form->addElement(new Xoops\Form\Hidden('usid', $xoops->user->uid()));

        if (!$this->isNew()) {
            $form->addElement(new Xoops\Form\Hidden('lid', (int)($this->getVar('lid', 'e'))));
        }

        $form->addElement(new Xoops\Form\Hidden('op', 'save_listing'));
        $form->addElement(new Xoops\Form\Button('', 'submit', constant($adminLang . '_SUBMIT'), 'submit'));

        return $form;
    }

    /**
     * @param bool $action
     * @return XoopsThemeForm
     */
    public function getForm($action = false)
    {
        $myts = MyTextSanitizer::getInstance();
        $xoops = Xoops::getInstance();

        $moduleDirName = basename(dirname(__DIR__));
        $xoops->loadLanguage('admin', $moduleDirName);
        $helper = Alumni::getInstance();
        $listingHandler  = $helper->getListingHandler();
        $categoryHandler = $helper->getCategoryHandler();
        $adminLang = '_AM_' . strtoupper($moduleDirName);

        if ($action === false) {
            $action = Request::getString('REQUEST_URI', '', 'SERVER');
        }
        if ('1' == $xoops->getModuleConfig('alumni_moderated')) {
            $title = $this->isNew() ? sprintf(constant($adminLang . '_ADD_LINK_MOD')) : sprintf(constant($adminLang . '_LISTING_EDIT_MOD'));
        } else {
            $title = $this->isNew() ? sprintf(constant($adminLang . '_ADD_LINK')) : sprintf(constant($adminLang . '_LISTING_EDIT'));
        }

        include_once(XOOPS_ROOT_PATH . '/class/xoopsformloader.php');
        $memberHandler = $xoops->getHandlerMember();
        $userGroups    = $memberHandler->getGroupList();

        //        if (isset($_REQUEST['lid'])) {
        //            $lid = $_REQUEST['lid'];
        //        }
        $lid = Request::getInt('lid', 0, 'GET');

        $form = new XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');

        $form->addElement(new Xoops\Form\Label(constant($adminLang . '_SUBMITTER'), $xoops->user->uname()));

        // $alumniCategoryHandler = $xoops->getModuleHandler('Category', $moduleDirName);
        $categories              = $categoryHandler->getObjects();
        $mytree                  = new XoopsObjectTree($categories, 'cid', 'pid');

        if ($tempLid = Request::getInt('lid', 0, 'GET')) {
            // $alumniListingHandler = $xoops->getModuleHandler('Listing', $moduleDirName);
            $listingObj           = $listingHandler->get($tempLid);
            $cat_id               = $listingObj->getVar('cid');
            $categorySelect       = $mytree->makeSelBox('cid', 'title', '--', $listingObj->getVar('cid'), true);

            $form->addElement(new Xoops\Form\Label(constant($adminLang . '_CAT'), $categorySelect), true);

            $cat_name                = '';
            // $alumniCategoryHandler = $xoops->getModuleHandler('Category', $moduleDirName);
            $catObj                  = $categoryHandler->get($listingObj->getVar('cid'));
            $cat_name                = $catObj->getVar('title');
        } else {
            if ($tempCid = Request::getInt('cid', 0, 'GET')) {
                // $alumniCategoryHandler = $xoops->getModuleHandler('Category',$moduleDirName);
                $catObj                  = $categoryHandler->get($tempCid);
                $cat_name                = $catObj->getVar('title');

                $categorySelect = $mytree->makeSelBox('cid', 'title', '--', $catObj->getVar('cid'), true);

                $form->addElement(new Xoops\Form\Label(constant($adminLang . '_CAT'), $categorySelect), true);
            }
        }

        $form->addElement(new Xoops\Form\Hidden('school', $cat_name));
        $form->addElement(new Xoops\Form\Text(constant($adminLang . '_NAME'), 'name', 50, 255, $this->getVar('name')), true);
        $form->addElement(new Xoops\Form\Text(constant($adminLang . '_MNAME'), 'mname', 50, 255, $this->getVar('mname')), false);
        $form->addElement(new Xoops\Form\Text(constant($adminLang . '_LNAME'), 'lname', 50, 255, $this->getVar('lname')), true);
        $form->addElement(new Xoops\Form\Text(constant($adminLang . '_YEAR2'), 'year', 50, 255, $this->getVar('year')), true);
        $form->addElement(new Xoops\Form\Text(constant($adminLang . '_STUDIES'), 'studies', 50, 255, $this->getVar('studies')), false);
        $activities              = $this->getVar('activities', 'e') ?: '';
        $editorConfigs           = array();
        $editorConfigs['name']   = 'activities';
        $editorConfigs['value']  = ($activities);
        $editorConfigs['editor'] = $xoops->getModuleConfig('alumni_form_options');
        $editorConfigs['rows']   = 6;
        $editorConfigs['cols']   = 8;

        $form->addElement(new Xoops\Form\Editor(constant($adminLang . '_ACTIVITIES'), 'activities', $editorConfigs), false);
        $extrainfo               = $this->getVar('extrainfo', 'e') ?: '';
        $editorConfigs           = array();
        $editorConfigs['name']   = 'extrainfo';
        $editorConfigs['value']  = $extrainfo;
        $editorConfigs['editor'] = $xoops->getModuleConfig('alumni_form_options');
        $editorConfigs['rows']   = 6;
        $editorConfigs['cols']   = 8;

        $form->addElement(new Xoops\Form\Editor(constant($adminLang . '_EXTRAINFO'), 'extrainfo', $editorConfigs), false);
        $photo_old            = $this->getVar('photo') ?: '';
        $uploadDirectoryPhoto = XOOPS_ROOT_PATH . "/uploads/{$moduleDirName}/photos/grad_photo";
        $imageTrayPhoto       = new Xoops\Form\ElementTray(constant($adminLang . '_GRAD_PIC'), '<br />');
        $imagePathPhoto       = sprintf(constant($adminLang . '_FORMIMAGE_PATH'), $uploadDirectoryPhoto);
        $fileSelectTrayPhoto  = new Xoops\Form\ElementTray('', '<br />');
        $fileSelectTrayPhoto->addElement(new Xoops\Form\File(constant($adminLang . '_FORMUPLOAD'), 'photo', $xoops->getModuleConfig('alumni_photomax')), false);

        if ($photo_old) {
            $fileSelectTrayPhoto->addElement(new Xoops\Form\Label(constant($adminLang . '_GRAD_PIC'), '<a href="'. XOOPS_URL . "/uploads/{$moduleDirName}/photos/grad_photo/" . $photo_old . '">' . $photo_old . '</a>', false));
            $imageTrayCheckbox = new Xoops\Form\Checkbox('', 'del_photo', 0);
            $imageTrayCheckbox->addOption(1, constant($adminLang . '_DELPICT'));
            $fileSelectTrayPhoto->addElement($imageTrayCheckbox);
        }
        $imageTrayPhoto->addElement($fileSelectTrayPhoto);
        $form->addElement($imageTrayPhoto);
        $form->addElement(new Xoops\Form\Hidden('photo_old', $photo_old));

        $photo2_old            = $this->getVar('photo2') ?: '';
        $uploadDirectoryPhoto2 = XOOPS_ROOT_PATH . "/uploads/{$moduleDirName}/photos/now_photo";
        $imageTrayPhoto2       = new Xoops\Form\ElementTray(constant($adminLang . '_NOW_PIC'), '<br />');
        $imagePathPhoto2       = sprintf(constant($adminLang . '_FORMIMAGE_PATH'), $uploadDirectoryPhoto2);
        $fileSelectTrayPhoto2  = new Xoops\Form\ElementTray('', '<br />');
        $fileSelectTrayPhoto2->addElement(new Xoops\Form\File(constant($adminLang . '_FORMUPLOAD'), 'photo2', $xoops->getModuleConfig('alumni_photomax')), false);

        if ($photo_old) {
            $fileSelectTrayPhoto2->addElement(new Xoops\Form\Label(constant($adminLang . '_NOW_PIC'), '<a href="'. XOOPS_URL . "/uploads/{$moduleDirName}/photos/now_photo/" . $photo2_old . '">' . $photo2_old . '</a>', false));
            $imageTrayCheckbox2 = new Xoops\Form\Checkbox('', 'del_photo2', 0);
            $imageTrayCheckbox2->addOption(1, constant($adminLang . '_DELPICT'));
            $fileSelectTrayPhoto2->addElement($imageTrayCheckbox2);
        }
        $imageTrayPhoto2->addElement($fileSelectTrayPhoto2);
        $form->addElement($imageTrayPhoto2);
        $form->addElement(new Xoops\Form\Hidden('photo2_old', $photo2_old));

        $form->addElement(new Xoops\Form\Text(constant($adminLang . '_EMAIL'), 'email', 50, 255, $this->getVar('email')), true);
        $form->addElement(new Xoops\Form\Text(constant($adminLang . '_OCC'), 'occ', 50, 255, $this->getVar('occ')), false);
        $form->addElement(new Xoops\Form\Text(constant($adminLang . '_TOWN'), 'town', 50, 255, $this->getVar('town')), false);

        if ('1' == $xoops->getModuleConfig('alumni_use_captcha')) {
            $form->addElement(new Xoops\Form\Captcha());
        }

        if ($tempDate = Request::getString('date', '', 'POST')) {
            $form->addElement(new Xoops\Form\Hidden('date', $tempDate));
        } else {
            $form->addElement(new XoopsFormHidden('date', time()));
        }

        $form->addElement(new Xoops\Form\Hidden('submitter', $xoops->user->uname()));
        $form->addElement(new Xoops\Form\Hidden('usid', $xoops->user->uid()));

        $form->addElement(new Xoops\Form\Hidden('op', 'save_listing'));
        $form->addElement(new Xoops\Form\Button('', 'submit', constant($adminLang . '_SUBMIT'), 'submit'));

        return $form;
    }

    /**
     * @return mixed
     */
    public function updateCounter()
    {
        return $this->updateCounter($this->getVar('lid'));
    }
}

/**
 * Class AlumniAlumni_listingHandler
 */
class AlumniListingHandler extends XoopsPersistableObjectHandler
{
    /**
     * @param null|Connection|XoopsDatabase $db
     */
    public function __construct(Connection $db = null)
    {
        parent::__construct($db, 'alumni_listing', 'Listing', 'lid', 'title');
    }

    /**
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return array
     */
    public function getListingPublished($start = 0, $limit = 0, $sort = 'date', $order = 'ASC')
    {
        $helper   = Alumni::getInstance();
        $xoops    = $helper->xoops();
        //get local language for SystemLocale
        $xoops->loadLocale('system');
        $moduleId = $helper->getModule()->getVar('mid');
        // get permitted id
        $groups    = $xoops->isUser() ? $xoops->user->getGroups() : SystemLocale::ANONYMOUS_USERS_GROUP;
        $alumniIds = $helper->getGrouppermHandler()->getItemIds('alumni_view', $groups, $moduleId);
        // criteria
        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('valid', 1, '='));
        $criteria->add(new Criteria('cid', '(' . implode(', ', $alumniIds) . ')', 'IN'));
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $criteria->setStart($start);
        $criteria->setLimit($limit);

        return parent::getAll($criteria);
    }

    /**
     * @param null $keys
     * @param null $format
     * @param null $maxDepth
     * @return mixed
     */
    public function getValues($keys = null, $format = null, $maxDepth = null)
    {
        $page             = Page::getInstance();
        $ret              = parent::getValues($keys, $format, $maxDepth);
        $ret['rating']    = number_format($this->getVar('rating'), 1);
        $ret['lid']       = $this->getVar('lid');
        $ret['name']      = $this->getVar('name');
        $ret['mname']     = $this->getVar('mname');
        $ret['lname']     = $this->getVar('lname');
        $ret['school']    = $this->getVar('school');
        $ret['year']      = $this->getVar('year');
        $ret['submitter'] = $this->getVar('submitter');
        $ret['date']      = $this->getVar('date');

        return $ret;
    }

    /**
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    public function countAlumni($start = 0, $limit = 0, $sort = 'date', $order = 'ASC')
    {
        $criteria = new CriteriaCompo();
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $criteria->setStart($start);
        $criteria->setLimit($limit);

        return parent::getCount($criteria);
    }

    /**
     * @param $lid
     * @return bool
     */
    public function updateCounter($lid)
    {
        $xoops      = Xoops::getInstance();
        $listingObj = $this->get($lid);
        if (!is_object($listingObj)) {
            return false;
        }
        $listingObj->setVar('view', $listingObj->getVar('view', 'n') + 1);
        $this->insert($listingObj, true);

        return true;
    }
}
