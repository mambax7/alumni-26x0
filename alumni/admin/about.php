<?php
/**
 * Marquee module
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright    The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license             http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package    Marquee
 * @since        2.5.0
 * @author     Mage, Mamba
 * @version    $Id $
 **/
use Xoops\Core\Request;

include_once __DIR__ . '/admin_header.php';

//xoops_cp_header();
$xoops = Xoops::getInstance();
$xoops->header();


$aboutAdmin = new Xoops\Module\Admin();

echo $aboutAdmin->displayNavigation('about.php');
echo $aboutAdmin->displayAbout(false);

//include 'admin_footer.php';

$xoops->footer();
