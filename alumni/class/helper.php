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
 *  Alumni class
 *
 * @copyright       The XUUPS Project http://sourceforge.net/projects/xuups/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Class
 * @subpackage      Utils
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: helper.php 10597 2012-12-29 02:00:28Z trabis $
 */
defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');

/**
 * Class Alumni
 */
class Alumni extends Xoops\Module\Helper\HelperAbstract
{
    /**
     * Init the module
     *
     * @return null|void
     */
    public function init()
    {
//        $this->setDirname('alumni');
        $moduleDirName = basename(dirname(__DIR__));
        $this->setDirname($moduleDirName);
        //$this->setDebug(true);
        //    $this->loadLanguage('modinfo');
    }

    /**
     * @return Alumni
     */
    public static function getInstance()
    {
        return parent::getInstance();
    }

    /**
     * @return AlumniAlumni_listingHandler
     */
    public function getListingHandler()
    {
        return $this->getHandler('Listing');
    }

    /**
     * @return AlumniAlumni_categoriesHandler
     */
    public function getCategoryHandler()
    {
        return $this->getHandler('Category');
    }

    /**
     * @return AlumniPermissionHandler
     */
    public function getPermissionHandler()
    {
        return $this->getHandler('permission');
    }

    /**
     * @return AlumniFileHandler
     */
    //    public function getFileHandler() {
    //        return $this->getHandler('file');
    //    }

    /**
     * @return AluAlumniMimetypeHandler
     */
    //    public function getMimetypeHandler() {
    //        return $this->getHandler('mimetype');
    //    }

    /**
     * @return AlumniRatingHandler
     */
    //    public function getRatingHandler() {
    //        return $this->getHandler('rating');
    //    }

    /**
     * @return AlumniGroupPermHandler
     */
    public function getGrouppermHandler()
    {
        return $this->getHandler('groupperm');
    }

    /**
     * @return int|mixed
     */
    public function getUserId()
    {
        if ($this->xoops()->isUser()) {
            return $this->xoops()->user->getVar('uid');
        }

        return 0;
    }
}
