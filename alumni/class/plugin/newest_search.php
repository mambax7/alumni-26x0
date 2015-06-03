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
 * page module
 *
 * @author          Mage Grégory (AKA Mage)
 * @copyright       2000-2015 The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @since           2.6.0
 */
class AlumniSearchPlugin extends PluginAbstract implements SearchPluginInterface
{
    /**
     * search - search
     *
     * @param string[] $queries search terms
     * @param string   $andor      and/or how to treat search terms
     * @param integer  $limit      max number to return
     * @param integer  $offset     offset of first row to return
     * @param integer  $userid     a specific user id to limit the query
     *
     * @return array of result items
     *           'title' => the item title
     *           'content' => brief content or summary
     *           'link' => link to visit item
     *           'time' => time modified (unix timestamp)
     *           'uid' => author uid
     *           'image' => icon for search display
     *
     */
    public function search($queries, $andor, $limit, $offset, $userid)
    {
        $andor = strtolower($andor)=='and' ? 'and' : 'or';
        $time = time();

        $qb = \Xoops::getInstance()->db()->createXoopsQueryBuilder();
        $eb = $qb->expr();
        $qb ->select('DISTINCT *')
            ->fromPrefix('alumni_listing')
            ->where($eb->neq('valid', '1'))
 //           ->andWhere($eb->neq('date', $time, "!="))
            ->orderBy('date', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit);
        if (is_array($queries) && !empty($queries)) {
            $queryParts = array();
            foreach ($queries as $i => $q) {
                $qterm = ':qterm' . $i;
                $qb->setParameter($qterm, '%' . $q . '%', \PDO::PARAM_STR);
                $queryParts[] = $eb -> orX(
                    $eb->like('name', $qterm),
                    $eb->like('mname', $qterm),
                    $eb->like('lname', $qterm),
                    $eb->like('school', $qterm),
                    $eb->like('year', $qterm)
                );
            }
            if ($andor == 'and') {
                $qb->andWhere(call_user_func_array(array($eb, "andX"), $queryParts));
            } else {
                $qb->andWhere(call_user_func_array(array($eb, "orX"), $queryParts));
            }
        } else {
            $qb->setParameter(':uid', (int) $userid, \PDO::PARAM_INT);
            $qb->andWhere($eb->eq('submitter', ':uid'));
        }

        $myts = MyTextSanitizer::getInstance();
//       $items = array();
        $result = $qb->execute();
        $ret = array();
        $i = 0;
        while ($myrow = $result->fetch(\PDO::FETCH_ASSOC)) {
 //           $content = $myrow["content_shorttext"] . "<br /><br />" . $myrow["content_text"];
 //           $content = $myts->xoopsCodeDecode($content);

            $ret[$i]["image"] = "images/logo_small.png";
            $ret[$i]["link"] = "listing.php?lid=" . $myrow["lid"];
            $ret[$i]["title"] = $myrow['name']." ".$myrow['mname']." ".$myrow['lname']."   ---   ".$myrow['school']." ---   ".$myrow['year'];
            $ret[$i]["time"] = $myrow["date"];
        //    $ret[$i]["content"] = $myrow["content_text"] . $myrow["content_shorttext"];
            $ret[$i]["uid"] = $myrow["usid"];
            $i++;
 
 
 
 
 //$items[] = array(
 //               'title' => $myrow['name']." ".$myrow['mname']." ".$myrow['lname']."   ---   ".$myrow['school']." ---   ".$myrow['year'],
 //               'link' => "listing.php?lid=" . $myrow["lid"],
 //               'time' => $myrow['date'],
 //               'uid' => $myrow['usid'],
 //           );
        }
//        return $items;
return $ret;

    }
}
