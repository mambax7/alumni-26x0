<?php
/**
 * Alumni module
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright           XOOPS Project https://xoops.org/
 * @license             http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package             Alumni
 * @since               3.0.0
 * @author              XOOPS Development Team
 * @version             $Id $
 **/

include_once __DIR__ . '/admin_header.php';

//xoops_cp_header();
$xoops = Xoops::getInstance();
$xoops->header();

$aboutAdmin = new Xoops\Module\Admin();

echo $aboutAdmin->displayNavigation('about.php');
echo $aboutAdmin->displayAbout(false);

//include 'admin_footer.php';

$xoops->footer();
