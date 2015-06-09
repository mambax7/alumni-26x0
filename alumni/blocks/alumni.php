<?php
//  -----------------------------------------------------------------------  //
//                           Jobs for Xoops 2.0x                             //
//                              By John Mordo                                //
//  -----------------------------------------------------------------------  //

defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');

include_once dirname(__DIR__) . '/include/common.php';
$xoops  = Xoops::getInstance();
$alumni = Alumni::getInstance();

function alumni_show($options)
{

    $blockDirName = basename(dirname(__DIR__));
    $block_lang   = '_MB_' . strtoupper($blockDirName);
    $modinfo_lang = '_MI_' . strtoupper($blockDirName);

    global $xoops, $helper, $alumni;

    $block                = array();
    $myts                 = MyTextSanitizer::getInstance();
    $alumniListingHandler = $xoops->getModuleHandler('alumni_listing', 'alumni');

    $listings = $alumniListingHandler->getListingPublished(0, $options[1], $options[0], 'DESC');
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
    $block['lang_title'] = constant($block_lang . '_ITEM');
    $block['lang_date']  = constant($block_lang . '_DATE');
    $block['link']       = "<a href=\"" . XOOPS_URL . "/modules/{$blockDirName}/index.php\"><b>" . constant($block_lang . '_ALL_LISTINGS') . "</b></a></div>";

    return $block;
}

function alumni_edit($options)
{
    global $xoopsDB;
    $blockDirName = basename(dirname(__DIR__));
    $block_lang   = '_MB_' . strtoupper($blockDirName);

    $form = constant($block_lang . '_ORDER') . "&nbsp;<select name='options[]'>";
    $form .= "<option value='date'";
    if ($options[0] == 'date') {
        $form .= " selected='selected'";
    }
    $form .= '>' . constant($block_lang . '_DATE') . "</option>\n";
    $form .= "<option value='view'";
    if ($options[0] == 'view') {
        $form .= " selected='selected'";
    }
    $form .= '>' . constant($block_lang . '_HITS') . '</option>';
    $form .= "</select>\n";
    $form .= '&nbsp;' . constant($block_lang . '_DISP') . "&nbsp;<input type='text' name='options[]' value='" . $options[1] . "'/>&nbsp;" . constant($block_lang . "_LISTINGS");
    $form .= "&nbsp;<br /><br />" . constant($block_lang . '_CHARS') . "&nbsp;<input type='text' name='options[]' value='" . $options[2] . "'/>&nbsp;" . constant($block_lang . '_LENGTH') . '<br /><br />';

    return $form;
}
