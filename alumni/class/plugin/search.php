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
 * alumni module
 * Edited by John Mordo (jlm69)
 * @copyright       XOOPS Project http://xoops.org/
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @since           2.6.0
 * @author          Mage Grégory (AKA Mage)
 * @version         $Id: $
 */

defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');
//$by_cat = '';
//if (!empty($_GET['by_cat'])) {
//    $by_cat = $_GET['by_cat'];
//} elseif (!empty($_POST['by_cat'])) {
//    $by_cat = $_POST['by_cat'];
//}

$by_cat = Request::getCmd('by_cat', Request::getCmd('by_cat', '', 'POST'), 'GET');

/**
 * Class AlumniSearchPlugin
 */
class AlumniSearchPlugin extends Xoops\Module\Plugin\PluginAbstract implements SearchPluginInterface
{
    /**
     * @param string[] $queries
     * @param string   $andor
     * @param int      $limit
     * @param int      $start
     * @param type     $uid
     * @return array
     */
    public function search($queries, $andor, $limit, $start, $uid)
    {
        $xoops = Xoops::getInstance();
        global $xoopsDB, $by_cat;
        $sql = 'SELECT lid, usid, name, mname, lname, school, year, date FROM ' . $xoopsDB->prefix('alumni_listing') . " WHERE valid='1' AND date<=" . time() . '';

        if (0 != $uid) {
            $sql .= ' AND usid=' . (int)($uid);
        }
        if ('' != $by_cat) {
            $sql .= " AND (cid LIKE '$by_cat')";
        }
        if (is_array($queries) && $count = count($queries)) {
            $sql .= " AND ((name LIKE '%$queries[0]%' OR mname LIKE '%$queries[0]%' OR lname LIKE '%$queries[0]%' OR school LIKE '%$queries[0]%' OR year LIKE '%$queries[0]%')";

            for ($i = 1; $i < $count; ++$i) {
                $sql .= " $andor ";
                $sql .= "(name LIKE '%$queries[$i]%' OR mname LIKE '%$queries[$i]%' OR lname LIKE '%$queries[$i]%' OR school LIKE '%$queries[$i]%' OR year LIKE '%$queries[$i]%')";
            }
            $sql .= ')';
        }
        $sql .= ' ORDER BY date DESC';
        $result = $xoopsDB->queryF($sql, $limit, $start);

        $ret = array();
        $i   = 0;
        while ($myrow = $xoopsDB->fetchArray($result)) {
            $ret[$i]['image'] = 'images/logo_small.png';
            $ret[$i]['link']  = 'listing.php?lid=' . $myrow['lid'];
            $ret[$i]['title'] = $myrow['name'] . ' ' . $myrow['mname'] . ' ' . $myrow['lname'] . '   ---   ' . $myrow['school'] . ' ---   ' . $myrow['year'];
            $ret[$i]['time']  = $myrow['date'];
            //    $ret[$i]["content"] = $myrow["content_text"] . $myrow["content_shorttext"];
            $ret[$i]['uid'] = $myrow['usid'];
            ++$i;
        }

        return $ret;
    }
}
