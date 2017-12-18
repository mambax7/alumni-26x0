<?php
//  -----------------------------------------------------------------------  //
//                           Jobs for Xoops 2.0x                             //
//                              By John Mordo                                //
//  -----------------------------------------------------------------------  //

defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');

include_once dirname(__DIR__) . '/include/common.php';
$xoops  = Xoops::getInstance();
$alumni = Alumni::getInstance();

/**
 * @param $options
 * @return array
 */
function alumni_show($options)
{
    $blockDirName = basename(dirname(__DIR__));
    $blocksLang   = '_MB_' . strtoupper($blockDirName);
    //    $modinfoLang = '_MI_' . strtoupper($blockDirName);

    global $xoops, $helper, $alumni;

    $block                = array();
    $myts                 = MyTextSanitizer::getInstance();
    // $alumniListingHandler = $xoops->getModuleHandler('Listing', $moduleDirName);

    $listings = $listingHandler->getListingPublished(0, $options[1], $options[0], 'DESC');
    foreach (array_keys($listings) as $l) {
        $a_item = array();
        $name   = $myts->undoHtmlSpecialChars($listings[$l]->getVar('name'));
        $mname  = $myts->undoHtmlSpecialChars($listings[$l]->getVar('mname'));
        $lname  = $myts->undoHtmlSpecialChars($listings[$l]->getVar('lname'));
        $school = $myts->undoHtmlSpecialChars($listings[$l]->getVar('school'));
        $year   = $myts->undoHtmlSpecialChars($listings[$l]->getVar('year'));
        $view   = $myts->htmlSpecialChars($listings[$l]->getVar('view'));

        $a_item['name']   = $name;
        $a_item['mname']  = $mname;
        $a_item['lname']  = $lname;
        $a_item['school'] = $school;
        $a_item['year']   = $year;
        $a_item['view']   = $view;
        $a_item['id']     = $listings[$l]->getVar('lid');
        $a_item['cid']    = $listings[$l]->getVar('cid');
        $a_item['link']   = '<a href="' . XOOPS_URL . "/modules/{$blockDirName}/listing.php?lid=" . addslashes($listings[$l]->getVar('lid')) . "\"><b>$year<br />$name $mname $lname</b></a>";

        $block['items'][] = $a_item;
    }
    $block['lang_title'] = constant($blocksLang . '_ITEM');
    $block['lang_date']  = constant($blocksLang . '_DATE');
    $block['link']       = "<a href=\"" . XOOPS_URL . "/modules/{$blockDirName}/index.php\"><b>" . constant($blocksLang . '_ALL_LISTINGS') . "</b></a></div>";

    return $block;
}

/**
 * @param $options
 * @return string
 */
function alumni_edit($options)
{
    global $xoopsDB;
    $blockDirName = basename(dirname(__DIR__));
    $blocksLang   = '_MB_' . strtoupper($blockDirName);

    $form = constant($blocksLang . '_ORDER') . "&nbsp;<select name='options[]'>";
    $form .= "<option value='date'";
    if ($options[0] == 'date') {
        $form .= " selected='selected'";
    }
    $form .= '>' . constant($blocksLang . '_DATE') . "</option>\n";
    $form .= "<option value='view'";
    if ($options[0] == 'view') {
        $form .= " selected='selected'";
    }
    $form .= '>' . constant($blocksLang . '_HITS') . '</option>';
    $form .= "</select>\n";
    $form .= '&nbsp;' . constant($blocksLang . '_DISP') . "&nbsp;<input type='text' name='options[]' value='" . $options[1] . "'/>&nbsp;" . constant($blocksLang . "_LISTINGS");
    $form .= "&nbsp;<br /><br />" . constant($blocksLang . '_CHARS') . "&nbsp;<input type='text' name='options[]' value='" . $options[2] . "'/>&nbsp;" . constant($blocksLang . '_LENGTH') . '<br /><br />';

    return $form;
}
