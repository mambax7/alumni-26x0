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
defined("XOOPS_ROOT_PATH") or die("XOOPS root path not defined");

class Alumni extends Xoops\Module\Helper\HelperAbstract
{
    /**
     * Init the module
     *
     * @return null|void
     */
    public function init()
    {
        $this->setDirname('alumni');
        //$this->setDebug(true);
    //    $this->loadLanguage('modinfo');
    }

    /**
     * @return Jobs
     */
    public static function getInstance() {
        return parent::getInstance();
    }

    /**
     * @return JobsItemHandler
     */
    public function getListingHandler()
    {
        return $this->getHandler('alumni_listing');
    }

    /**
     * @return JobsCategoryHandler
     */
    public function getCategoryHandler()
    {
        return $this->getHandler('alumni_categories');
    }

    /**
     * @return JobsPermissionHandler
     */
    public function getPermissionHandler()
    {
        return $this->getHandler('permission');
    }

    /**
     * @return JobsFileHandler

    public function getFileHandler()
    {
        return $this->getHandler('file');
    }
     */
    /**
     * @return JobsMimetypeHandler

    public function getMimetypeHandler()
    {
        return $this->getHandler('mimetype');
    }
     */
    /**
     * @return JobsRatingHandler
     
    public function getRatingHandler()
    {
        return $this->getHandler('rating');
    }
*/
    /**
     * @return JobsGrouppermHandler
     */
    public function getGrouppermHandler()
    {
        return $this->getHandler('groupperm');
    }
    
    public function getUserId()
    {
        if ($this->xoops()->isUser()) {
            return $this->xoops()->user->getVar('uid');
        }
        return 0;
    }    
}
