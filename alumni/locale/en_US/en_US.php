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
 * page module
 *
 * @copyright       XOOPS Project http://xoops.org/
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package         page
 * @since           2.6.0
 * @author          DuGris (aka Laurent JEN)
 * @version         $Id$
 */

defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');

class AlumniLocaleEn_US /*extends XoopsLocaleEn_US*/
{
    // Module
    const MODULE_NAME = 'Alumni';
    const MODULE_DESC = 'Module for creating Alumni pages';

    // Admin menu
    const SYSTEM_LISTING     = 'Listing';
    const SYSTEM_PERMISSIONS = 'Permissions';
    const SYSTEM_ABOUT       = 'About';

    // Configurations
    const CONF_EDITOR = 'Editor';
    //    const CONF_ADMINPAGER = 'Number listings to display per page in admin page';
    const CONF_USERPAGER  = 'Number listings to display per page in user page';
    const CONF_DATEFORMAT = 'Date format';
    //    const CONF_TIMEFORMAT = 'time format';

    // Blocks
    const BLOCKS_LISTINGS     = 'Listings';
    const BLOCKS_LISTINGS_DSC = 'Display listings';
    const BLOCKS_ID           = 'ID listing';
    const BLOCKS_ID_DSC       = 'Display listing by ID';

    // Notifications
    const NOTIFICATION_GLOBAL                = 'Global Contents';
    const NOTIFICATION_GLOBAL_DSC            = 'Notification options that apply to all listings.';
    const NOTIFICATION_ITEM                  = 'Listing';
    const NOTIFICATION_ITEM_DSC              = 'Notification options that apply to the current listing.';
    const NOTIFICATION_GLOBAL_NEWLISTING     = 'New listing published';
    const NOTIFICATION_GLOBAL_NEWLISTING_CAP = 'Notify me when any new listing is published.';
    const NOTIFICATION_GLOBAL_NEWLISTING_DSC = 'Receive notification when any new listing is published.';
    const NOTIFICATION_GLOBAL_NEWLISTING_SBJ = '[{X_SITENAME}] {X_MODULE} auto-notify : New listing published';

    // Admin index.php
    const LISTINGS        = 'Listings';
    const TOTAL_LISTINGS  = 'There are <span class=\'red bold\'>%s</span> listings in our database';
    const TOTAL_VALID     = 'There are <span class=\'green bold\'>%s</span> approved listings';
    const TOTAL_NOT_VALID = 'There are <span class=\'red bold\'>%s</span> listings waiting to be approved';

    // Admin content
    const A_ADD_LISTING      = 'Add a new listing';
    const A_ADD_CAT          = 'Add a new Category';
    const A_MODERATE_LISTING = 'Moderate Listings';
    const A_EDIT_LISTING     = 'Edit a listing';
    const A_LIST_LISTING     = 'List of listings';
    const A_APPROVE          = 'Approve';
    const A_APPROVE_2        = 'Approve :';
    const A_NAME_2           = 'First Name :';
    const A_MNAME_2          = 'Middle/Maiden Name :';
    const A_LNAME_2          = 'Last Name :';


    const A_SCHOOL       = 'School';
    const A_SCHOOL_2     = 'School :';
    const A_CLASS_OF     = 'Class of';
    const A_CLASS_OF_2   = 'Class of :';
    const A_MODERATED    = 'waiting for approval';
    const A_STUDIES      = 'Studies';
    const A_STUDIES_2    = 'Studies :';
    const A_ACTIVITIES   = 'Activities';
    const A_ACTIVITIES_2 = 'Student Activities :';
    const A_EXTRAINFO    = 'Extra Info';
    const A_OCC          = 'Occupation';
    const A_OCC_2        = 'Occupation :';
    //    const A_EDIT = 'Edit';
    const A_EMAIL_2 = 'Email :';
    const A_TOWN_2  = 'Current Location :';

    const E_NO_LISTING_APPROVE     = 'There are no listings waiting to be approved';
    const E_NO_LISTING             = 'There are no listings';
    const E_NO_CAT                 = 'There are no Categories';
    const ALUMNI_TIPS              = '<ul><li>Add, update or delete listings</li></ul>';
    const ALUMNI_TEXT_DESC         = 'Main content of the page';
    const ALUMNI_META_KEYWORDS     = 'Metas keyword';
    const ALUMNI_META_KEYWORDS_DSC = 'Metas keyword separated by a comma';
    const ALUMNI_META_DESCRIPTION  = 'Metas description';
    const ALUMNI_OPTIONS_DSC       = 'Choose which information will be displayed';
    const ALUMNI_SELECT_GROUPS     = 'Select groups that can view this content';
    const ALUMNI_COPY              = '[copy]';
    const E_WEIGHT                 = 'You need a positive integer';
    const Q_ON_MAIN_PAGE           = 'Content displayed on the home page';
    const L_ALUMNI_DOPDF           = 'PDF icon';
    const L_ALUMNI_DOPRINT         = 'Print icon';
    const L_ALUMNI_DOSOCIAL        = 'Social networks';
    const L_ALUMNI_DOAUTHOR        = 'Author';
    const L_ALUMNI_DOMAIL          = 'Mail icon';
    const L_ALUMNI_DODATE          = 'Date';
    const L_ALUMNI_DOHITS          = 'Hits';
    const L_ALUMNI_DORATING        = 'Rating and vote count';
    const L_ALUMNI_DOCOMS          = 'Comments';
    const L_ALUMNI_DONCOMS         = 'Comments count';
    const L_ALUMNI_DOTITLE         = 'Title';
    const L_ALUMNI_DONOTIFICATIONS = 'Notifications';
    const L_ALUMNI_CATEGORIES      = 'Category/School';

    // Admin permissions
    const PERMISSIONS_RATE    = 'Rate permissions';
    const PERMISSIONS_VIEW    = 'View permissions';
    const PERMISSIONS_SUBMIT  = 'Submit permissions';
    const PERMISSIONS_PREMIUM = 'Premium permissions';


    // Admin Tabs form
    const TAB_MAIN        = 'Main';
    const TAB_METAS       = 'Metas';
    const TAB_OPTIONS     = 'Options';
    const TAB_PERMISSIONS = 'Permissions';

    // main
    const YOUR_VOTE = 'Your vote';
    const OF        = 'of';

    // viewpage
    const E_NOT_EXIST = 'This page does not exist in our database';

    // Print
    const PRINT_COMES = 'This listing comes from';


    // Configuration


    // Block configuration
    const CONF_BLOCK_MODE     = 'Mode';
    const CONF_BLOCK_L_ALUMNI = 'Alumni';
    const CONF_BLOCK_L_LIST   = 'List';

    const CONF_BLOCK_ORDER    = 'Order by';
    const CONF_BLOCK_L_RECENT = 'Recent';
    const CONF_BLOCK_L_HITS   = 'Hits';
    const CONF_BLOCK_L_RATING = 'Rating';
    const CONF_BLOCK_L_RANDOM = 'Random';

    const CONF_BLOCK_SORT   = 'Sort';
    const CONF_BLOCK_L_ASC  = 'Ascending';
    const CONF_BLOCK_L_DESC = 'Descending';

    const CONF_BLOCK_DISPLAY_NUMBER = 'Number to display';

}
