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
 * test1 module for xoops
 *
 * @copyright       XOOPS Project http://xoops.org/
 * @license         GPL 2.0 or later
 * @package         alumni
 * @author          John Mordo (jlm69)
 */

use Xoops\Core\Database\Connection;

defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');

class alumni_categories extends XoopsObject {

    public $alumni = null;

    /**
     * @var array
     */
    public $_categoryPath = false;

    //Constructor
    public function __construct() {
        //		$this->XoopsObject();
        //		$this->alumni = Alumni::getInstance();
        $this->initVar('cid', XOBJ_DTYPE_INT, null, false, 11);
        $this->initVar('pid', XOBJ_DTYPE_INT, null, false, 5);
        $this->initVar('title', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('scaddress', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('scaddress2', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('sccity', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('scstate', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('sczip', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('scphone', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('scfax', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('scmotto', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('scurl', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('img', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('scphoto', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('ordre', XOBJ_DTYPE_INT, null, false, 5);
    }

    public function getForm($action = false) {
        global $xoopsDB;
        $xoops = Xoops::getInstance();
        if ($action === false) {
            $action = $_SERVER['REQUEST_URI'];
        }

        $moduleDirName  = basename(dirname(__DIR__));
        $admin_lang = '_AM_' . strtoupper($moduleDirName);

        $title = $this->isNew() ? sprintf(constant($admin_lang . '_CATEGORY_ADD')) : sprintf(constant($admin_lang . '_CATEGORY_EDIT'));

        include_once(XOOPS_ROOT_PATH . '/class/xoopsformloader.php');

        $form = new XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');


        include_once(XOOPS_ROOT_PATH . '/class/tree.php');
        $alumni_category_Handler = $xoops->getModuleHandler('alumni_categories', 'alumni');
        $arr                     = $alumni_category_Handler->getall();
        //$mytree = new XoopsObjectTree($arr, 'category_id', 'category_pid');
        $mytree = new XoopsObjectTree($arr, 'cid', 'pid');

        $form->addElement(new Xoops\Form\Label(constant($admin_lang . '_CATEGORY_PID'), $mytree->makeSelBox('pid', 'title', '-', $this->getVar('pid'), true)));
        $form->addElement(new Xoops\Form\Text(constant($admin_lang . '_CATEGORY_TITLE'), 'title', 50, 255, $this->getVar('title')), true);
        //$form->addElement(new XoopsFormTextArea(_AM_TEST1_CATEGORY_DESC, 'category_desc', $this->getVar('category_desc'), 4, 47), true);

        $img                         = $this->getVar('img') ? $this->getVar('img') : 'default.gif';
        $uploadirectory_category_img = "/modules/{$moduleDirName}/images/cat";
        $imgtray_category_img        = new Xoops\Form\ElementTray(constant($admin_lang . '_IMGCAT'), '<br />');
        $imgpath_category_img        = sprintf(constant($admin_lang . '_FORMIMAGE_PATH'), $uploadirectory_category_img);
        $imageselect_category_img    = new Xoops\Form\Select($imgpath_category_img, 'img', $img);
        $image_array_category_img    = XoopsLists:: getImgListAsArray(XOOPS_ROOT_PATH . $uploadirectory_category_img);
        foreach ($image_array_category_img as $image_category_img) {
            $imageselect_category_img->addOption("$image_category_img", $image_category_img);
        }
        $imageselect_category_img->setExtra("onchange='showImgSelected(\"image_category_img\", \"img\", \"" . $uploadirectory_category_img . "\", \"\", \"" . XOOPS_URL . "\")'");
        $imgtray_category_img->addElement($imageselect_category_img, false);
        $imgtray_category_img->addElement(new Xoops\Form\Label('', '<br /><img src=\'' . XOOPS_URL . '/' . $uploadirectory_category_img . '/' . $img . "' name='image_category_img' id='image_category_img' alt='' />"));

        $fileseltray_category_img = new Xoops\Form\ElementTray('', '<br />');
        $fileseltray_category_img->addElement(new Xoops\Form\File(constant($admin_lang . '_FORMUPLOAD'), 'img', $xoops->getModuleConfig('alumni_photomax')), false);
        $fileseltray_category_img->addElement(new Xoops\Form\Label(''), false);
        $imgtray_category_img->addElement($fileseltray_category_img);
        $form->addElement($imgtray_category_img);

        $form->addElement(new Xoops\Form\Text(constant($admin_lang . '_ORDER'), 'ordre', 50, 255, $this->getVar('ordre')), false);
        $form->addElement(new Xoops\Form\Label(constant($admin_lang . '_IFSCHOOL'), ''));

        $photo_old            = $this->getVar('scphoto') ? $this->getVar('scphoto') : '';
        $uploadirectory_photo = XOOPS_ROOT_PATH . "/modules/{$moduleDirName}/photos/school_photos";
        $imgtray_photo        = new Xoops\Form\ElementTray(constant($admin_lang . '_SCPHOTO'), '<br />');
        $imgpath_photo        = sprintf(constant($admin_lang . '_FORMIMAGE_PATH'), $uploadirectory_photo);
        $fileseltray_photo    = new Xoops\Form\ElementTray('', '<br />');
        $fileseltray_photo->addElement(new XoopsFormFile(constant($admin_lang . '_FORMUPLOAD'), 'scphoto', $xoops->getModuleConfig('alumni_photomax')), false);
        if ($photo_old) {
            $fileseltray_photo->addElement(new Xoops\Form\Label(constant($admin_lang . '_ACTUALPICT'), '<a href="../photos/school_photos/' . $photo_old . '">' . $photo_old . '</a>', false));
            $imgtray_checkbox = new Xoops\Form\CheckBox('', 'del_photo', 0);
            $imgtray_checkbox->addOption(1, constant($admin_lang . '_DELPICT'));
            $fileseltray_photo->addElement($imgtray_checkbox);
        }
        $imgtray_photo->addElement($fileseltray_photo);
        $form->addElement($imgtray_photo);
        $form->addElement(new Xoops\Form\Hidden('photo_old', $photo_old));
        $form->addElement(new Xoops\Form\Text(constant($admin_lang . '_SCADDRESS'), 'scaddress', 50, 255, $this->getVar('scaddress')), false);
        $form->addElement(new Xoops\Form\Text(constant($admin_lang . '_SCADDRESS2'), 'scaddress2', 50, 255, $this->getVar('scaddress2')), false);
        $form->addElement(new Xoops\Form\Text(constant($admin_lang . '_SCCITY'), 'sccity', 50, 255, $this->getVar('sccity')), false);
        $form->addElement(new Xoops\Form\Text(constant($admin_lang . '_SCSTATE'), 'scstate', 50, 255, $this->getVar('scstate')), false);
        $form->addElement(new Xoops\Form\Text(constant($admin_lang . '_SCZIP'), 'sczip', 50, 255, $this->getVar('sczip')), false);
        $form->addElement(new Xoops\Form\Text(constant($admin_lang . '_SCPHONE'), 'scphone', 50, 255, $this->getVar('scphone')), false);
        $form->addElement(new Xoops\Form\Text(constant($admin_lang . '_SCFAX'), 'scfax', 50, 255, $this->getVar('scfax')), false);
        $form->addElement(new Xoops\Form\Text(constant($admin_lang . '_SCMOTTO'), 'scmotto', 50, 255, $this->getVar('scmotto')), false);
        $form->addElement(new Xoops\Form\Text(constant($admin_lang . '_SCURL'), 'scurl', 50, 255, $this->getVar('scurl')), false);
        $form->addElement(new Xoops\Form\Hidden('op', 'save_category'));
        $form->addElement(new Xoops\Form\Button('', 'submit', constant($admin_lang . '_SUBMIT'), 'submit'));

        return $form;
    }

    public function getPathFromId($id = null, $path = '') {
        $id   = isset($id) ? (int)($id) : $this->cid;
        $myts =& MyTextSanitizer::getInstance();
        $name = $myts->htmlSpecialChars($this->title);
        $path = "/{$name}{$path}";
        if ($this->pid != 0) {
            $path = $this->getPathFromId($this->pid, $path);
        }

        return $path;
    }
}


class AlumniAlumni_categoriesHandler extends XoopsPersistableObjectHandler {

    public $alumni = null;

    public function __construct(Connection $db = null) {
        parent::__construct($db, 'alumni_categories', 'alumni_categories', 'cid', 'title');

    }

    public function getSubCatArray($by_cat, $level, $cat_array, $cat_result) {
        global $theresult;
        $spaces = '';
        for ($j = 0; $j < $level; $j++) {
            $spaces .= '--';
        }
        $theresult[$by_cat['cid']] = $spaces . $by_cat['title'];
        if (isset($cat_array[$by_cat['cid']])) {
            $level = $level + 1;
            foreach ($cat_array[$by_cat['cid']] as $cat) {
                $this->getSubCatArray($cat, $level, $cat_array, $cat_result);
            }
        }
    }

    /**
     * @return array
     */
    public function &getCategoriesForSearch() {
        global $theresult, $xoops, $alumni;
        $xoops     = Xoops::getInstance();
        $module_id = $alumni->getModule()->mid();
        $ret       = array();
        $criteria  = new CriteriaCompo();
        $criteria->setSort('cid');
        $criteria->setOrder('ASC');
        if (!$xoops->isAdmin()) {
            $gperm_handler        = $xoops->gethandler('groupperm');
            $groups               = is_object($xoops->isUser()) ? $$xoops->isUser()->getGroups() : XOOPS_GROUP_ANONYMOUS;
            $allowedCategoriesIds = $gperm_handler->getItemIds('alumni_view', $groups, $module_id);
            if (count($allowedCategoriesIds) > 0) {
                $criteria->add(new Criteria('cid', '(' . implode(',', $allowedCategoriesIds) . ')', 'IN'));
            } else {
                return $ret;
            }
        }
        $categories = $this->getAll($criteria, array('cid', 'pid', 'title'), false, false);
        if (count($categories) == 0) {
            return $ret;
        }
        $cat_array = array();
        foreach ($categories as $cat) {
            $cat_array[$cat['pid']][$cat['cid']] = $cat;
        }
        // Needs to have permission on at least 1 top level category
        if (!isset($cat_array[0])) {
            return $ret;
        }
        $cat_result = array();
        foreach ($cat_array[0] as $thecat) {
            $level = 0;
            $this->getSubCatArray($thecat, $level, $cat_array, $cat_result);
        }

        return $theresult; //this is a global
    }
}
