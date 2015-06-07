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
 * @package         Alumni
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: common.php 10747 2013-01-10 20:55:39Z trabis $
 */
defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');

define('ALUMNI_DIRNAME', basename(dirname(__DIR__)));
define('ALUMNI_URL', XOOPS_URL . '/modules/' . ALUMNI_DIRNAME);
define('ALUMNI_ADMIN_URL', ALUMNI_URL . '/admin');
define('ALUMNI_UPLOADS_URL', XOOPS_URL . '/uploads/' . ALUMNI_DIRNAME);
define('ALUMNI_ROOT_PATH', XOOPS_ROOT_PATH . '/modules/' . ALUMNI_DIRNAME);
define('ALUMNI_UPLOADS_PATH', XOOPS_ROOT_PATH . '/uploads/' . ALUMNI_DIRNAME);

$path = dirname(__DIR__);
XoopsLoad::addMap(array(
                      'alumnisession'   => $path . '/class/session.php',
                      'alumni'          => $path . '/class/helper.php',
                      'alumniblockform' => $path . '/class/blockform.php'
                  ));

$alumni = Alumni::getInstance();
