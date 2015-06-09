<?php
// Module Info

$moduleDirName = basename(dirname(dirname(__DIR__)));
$modinfo_lang  = '_MI_' . strtoupper($moduleDirName);
$admin_lang    = '_AM_' . strtoupper($moduleDirName);

// The name of this module
define($modinfo_lang . '_NAME', 'Alumni');

define($modinfo_lang . '_MENUADD', 'Add Your Listing');

// A brief description of this module
define($modinfo_lang . '_DESC', 'Alumni Module');

// Names of blocks for this module (Not all module has blocks)
define($modinfo_lang . '_BNAME', 'Alumni Block2');
define($modinfo_lang . '_BNAME_DESC', 'Shows Alumni Block2');
// Names of admin menu items
define($modinfo_lang . '_ADMENU1', 'Home');
define($modinfo_lang . '_ADMENU2', 'Categories : Schools');
define($modinfo_lang . '_ADMENU3', 'Permissions');
define($modinfo_lang . '_ADMENU4', 'Preferences');
define($modinfo_lang . '_ADMENU5', 'Listings');
define($modinfo_lang . '_ADMENU6', 'Back to Module');
define($modinfo_lang . '_ADMENU7', 'About');
define($modinfo_lang . '_CONFSAVE', 'Configuration saved');
define($modinfo_lang . '_KOIVI', 'Use Koivi Editor :');
define($modinfo_lang . '_CANPOST', 'Anonymous user can post Alumni Listings :');
define($modinfo_lang . '_PERPAGE', 'Alumni Listings per page :');
define($modinfo_lang . '_USECAT', 'Use Categories :');
define($modinfo_lang . '_NUMNEW', 'Number of new Alumni Listings :');
define($modinfo_lang . '_MODERAT', 'Moderate Alumni Listings :');
define($modinfo_lang . '_MAXIIMGS', 'Maximum Photo Size :');
define($modinfo_lang . '_MAXWIDE', 'Maximum Photo Width :');
define($modinfo_lang . '_MAXHIGH', 'Maximum Photo Height :');
define($modinfo_lang . '_DURATION', 'Alumni Listing duration :');
define($modinfo_lang . '_INBYTES', 'in bytes');
define($modinfo_lang . '_INPIXEL', 'in pixels');
define($modinfo_lang . '_INDAYS', 'in days');
define($modinfo_lang . '_TYPEBLOC', 'Type of Block :');
define($modinfo_lang . '_ALUMRAND', 'Random Alumni Listing');
define($modinfo_lang . '_LASTTEN', 'Last 10 Alumni Listings');
define($modinfo_lang . '_NEWTIME', 'New Alumni Listings from :');
define($modinfo_lang . '_INTHISCAT', 'in this category');
define($modinfo_lang . '_DISPLSUBCAT', 'Display subcategories :');
define($modinfo_lang . '_ONHOME', 'on the Front Page of Module');
define($modinfo_lang . '_NUMSUBCAT', 'Number of subcategories to show :');
define($modinfo_lang . '_IF', 'if');
define($modinfo_lang . '_ISAT', 'is at');
define($modinfo_lang . '_VIEWNEWCLASS', 'Show new Alumni Listings :');
define($modinfo_lang . '_ORDREALPHA', 'Sort alphabetically');
define($modinfo_lang . '_ORDREPERSO', 'Personalised Order');
define($modinfo_lang . '_ORDER', 'Category Order :');

define($modinfo_lang . '_GPERM_G_ADD', 'Can add');
define($modinfo_lang . '_CAT2GROUPDESC', 'Check categories which you allow to access');
define($modinfo_lang . '_GROUPPERMDESC', 'Select group(s) allowed to submit listings.');
define($modinfo_lang . '_GROUPPERM', 'Submit Permissions');
define($modinfo_lang . '_SUBMITFORM', 'Alumni Submit Permissions');
define($modinfo_lang . '_SUBMITFORM_DESC', 'Select, who can submit listings');
define($modinfo_lang . '_VIEWFORM', 'View Alumni Permissions');
define($modinfo_lang . '_VIEWFORM_DESC', 'Select, who can view Alumni');
define($modinfo_lang . '_SUPPORT', 'Support this software');
define($modinfo_lang . '_OP', 'Read my opinion');
define($modinfo_lang . '_PREMIUM', 'Alumni Premium');
define($modinfo_lang . '_PREMIUM_DESC', 'Who can select days listing will last');

//Added for 3.0 BETA 1
define($modinfo_lang . '_LIST_EDITORS', 'Select the editor to use.');
define($modinfo_lang . '_EDITOR', 'Editor to use:');
define($modinfo_lang . '_USE_CAPTCHA', 'Use Captcha');
//define($modinfo_lang.'_ORDER','Default Order');

define($modinfo_lang . '_AORDER', 'Alumni Listing Order :');

define($modinfo_lang . '_ORDER_DATE', 'Order by Date');
define($modinfo_lang . '_ORDER_NAME', 'Order by Name');
define($modinfo_lang . '_ORDER_POP', 'Order by Hits');
define($modinfo_lang . '_MUST_ADD_CAT', 'You must add a category first.');

// Notification event descriptions and mail templates

define($modinfo_lang . '_CATEGORY_NOTIFY', 'Category');
define($modinfo_lang . '_CATEGORY_NOTIFYDSC', 'Notification options that apply to the current category.');
define($modinfo_lang . '_NOTIFY', 'Listing');
define($modinfo_lang . '_NOTIFYDSC', 'Notification options that apply to the current listing.');
define($modinfo_lang . '_GLOBAL_NOTIFY', 'Whole Module ');
define($modinfo_lang . '_GLOBAL_NOTIFYDSC', 'Global advert notification options.');

//event

define($modinfo_lang . '_NEWPOST_NOTIFY', 'New Listing');
define($modinfo_lang . '_NEWPOST_NOTIFYCAP', 'Notify me of new listings in the current category.');
define($modinfo_lang . '_NEWPOST_NOTIFYDSC', 'Receive notification when a new listing is posted to the current category.');
define($modinfo_lang . '_NEWPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: auto-notify : New listing in category');
define($modinfo_lang . '_VALIDATE_NEWPOST_NOTIFY', 'New Listing');
define($modinfo_lang . '_VALIDATE_NEWPOST_NOTIFYCAP', 'Notify me of new listings in the current category.');
define($modinfo_lang . '_VALIDATE_NEWPOST_NOTIFYDSC', 'Receive notification when a new listing is posted to the current category.');
define($modinfo_lang . '_VALIDATE_NEWPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: auto-notify : New listing in category');
define($modinfo_lang . '_UPDATE_NEWPOST_NOTIFY', 'Listing Updated');
define($modinfo_lang . '_UPDATE_NEWPOST_NOTIFYCAP', 'Notify me of updated listings in the current category.');
define($modinfo_lang . '_UPDATE_NEWPOST_NOTIFYDSC', 'Receive notification when an listing is updated in the current category.');
define($modinfo_lang . '_UPDATE_NEWPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: auto-notify : New listing in category');
define($modinfo_lang . '_DELETE_NEWPOST_NOTIFY', 'Listing Deleted');
define($modinfo_lang . '_DELETE_NEWPOST_NOTIFYCAP', 'Notify me of new listings in the current category.');
define($modinfo_lang . '_DELETE_NEWPOST_NOTIFYDSC', 'Receive notification when an listing is deleted from the current category.');
define($modinfo_lang . '_DELETE_NEWPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: auto-notify : New listing in category');
define($modinfo_lang . '_GLOBAL_NEWPOST_NOTIFY', 'New Listing');
define($modinfo_lang . '_GLOBAL_NEWPOST_NOTIFYCAP', 'Notify me of new listings in all categories.');
define($modinfo_lang . '_GLOBAL_NEWPOST_NOTIFYDSC', 'Receive notification when a new listing is posted to all categories.');
define($modinfo_lang . '_GLOBAL_NEWPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: auto-notify : New listing in category');
define($modinfo_lang . '_GLOBAL_VALIDATE_NEWPOST_NOTIFY', 'New Listing');
define($modinfo_lang . '_GLOBAL_VALIDATE_NEWPOST_NOTIFYCAP', 'Notify me of new listings in all categories.');
define($modinfo_lang . '_GLOBAL_VALIDATE_NEWPOST_NOTIFYDSC', 'Receive notification when a new listing is posted to all categories.');
define($modinfo_lang . '_GLOBAL_VALIDATE_NEWPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: auto-notify : New listing in category');
define($modinfo_lang . '_GLOBAL_UPDATE_NEWPOST_NOTIFY', 'Listing Updated');
define($modinfo_lang . '_GLOBAL_UPDATE_NEWPOST_NOTIFYCAP', 'Notify me of updated listings in all categories.');
define($modinfo_lang . '_GLOBAL_UPDATE_NEWPOST_NOTIFYDSC', 'Receive notification when an listing is updated in all categories.');
define($modinfo_lang . '_GLOBAL_UPDATE_NEWPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: auto-notify : Listing updated in categories');
define($modinfo_lang . '_GLOBAL_DELETE_NEWPOST_NOTIFY', 'Listing Deleted');
define($modinfo_lang . '_GLOBAL_DELETE_NEWPOST_NOTIFYCAP', 'Notify me of deleted listings in all categories.');
define($modinfo_lang . '_GLOBAL_DELETE_NEWPOST_NOTIFYDSC', 'Receive notification when an listing is deleted in all categories.');
define($modinfo_lang . '_GLOBAL_DELETE_NEWPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: auto-notify : Listing deleted in categories');

// ADDED FOR 3.01

define($modinfo_lang . '_INDEX_CODE', 'Extra Index Page Code');
define($modinfo_lang . '_INDEX_CODE_DESC', 'Put your adsense or other code here');
define($modinfo_lang . '_USE_INDEX_CODE', 'Use Extra Index Page Code');
define($modinfo_lang . '_USE_INDEX_CODE_DESC', 'Put additional code between listings<br />on the index page<br />and the categories page.<br /><br />Banners, Adsense code, etc...');
define($modinfo_lang . '_INDEX_CODE_PLACE', 'Code will show in this place in the list ');
define($modinfo_lang . '_INDEX_CODE_PLACE_DESC', 'Ex. If you choose 4 there will be 3 listings before this code.<br /> Code will be displayed in the 4th slot.');
define($modinfo_lang . '_USE_BANNER', 'Use Xoops Banner Code');
define($modinfo_lang . '_USE_BANNER_DESC', 'Will allow you to insert xoopsbanners in between listings.<br />If you choose Yes<br />Do Not insert any code below');
define($modinfo_lang . '_OFFER_SEARCH', 'Offer search within listings');
define($modinfo_lang . '_OFFER_SEARCH_DESC', 'Select yes to provide a search box');

// ADDED FOR 3.1

define($modinfo_lang . '_USE_CAPTCHA_DESC', '');
