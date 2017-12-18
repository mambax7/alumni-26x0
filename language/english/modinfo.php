<?php
// Module Info

$moduleDirName = basename(dirname(dirname(__DIR__)));
$modinfoLang   = '_MI_' . strtoupper($moduleDirName);
$adminLang     = '_AM_' . strtoupper($moduleDirName);

// The name of this module
define($modinfoLang . '_NAME', 'Alumni');

define($modinfoLang . '_MENUADD', 'Add Your Listing');

// A brief description of this module
define($modinfoLang . '_DESC', 'Alumni Module');

// Names of blocks for this module (Not all module has blocks)
define($modinfoLang . '_BNAME', 'Alumni Block2');
define($modinfoLang . '_BNAME_DESC', 'Shows Alumni Block2');
// Names of admin menu items
define($modinfoLang . '_ADMENU1', 'Home');
define($modinfoLang . '_ADMENU2', 'Categories : Schools');
define($modinfoLang . '_ADMENU3', 'Permissions');
define($modinfoLang . '_ADMENU4', 'Preferences');
define($modinfoLang . '_ADMENU5', 'Listings');
define($modinfoLang . '_ADMENU6', 'Back to Module');
define($modinfoLang . '_ADMENU7', 'About');
define($modinfoLang . '_CONFSAVE', 'Configuration saved');
define($modinfoLang . '_KOIVI', 'Use Koivi Editor :');
define($modinfoLang . '_CANPOST', 'Anonymous user can post Alumni Listings :');
define($modinfoLang . '_PERPAGE', 'Alumni Listings per page :');
define($modinfoLang . '_USECAT', 'Use Categories :');
define($modinfoLang . '_NUMNEW', 'Number of new Alumni Listings :');
define($modinfoLang . '_MODERAT', 'Moderate Alumni Listings :');
define($modinfoLang . '_MAXIIMGS', 'Maximum Photo Size :');
define($modinfoLang . '_MAXWIDE', 'Maximum Photo Width :');
define($modinfoLang . '_MAXHIGH', 'Maximum Photo Height :');
define($modinfoLang . '_DURATION', 'Alumni Listing duration :');
define($modinfoLang . '_INBYTES', 'in bytes');
define($modinfoLang . '_INPIXEL', 'in pixels');
define($modinfoLang . '_INDAYS', 'in days');
define($modinfoLang . '_TYPEBLOC', 'Type of Block :');
define($modinfoLang . '_ALUMRAND', 'Random Alumni Listing');
define($modinfoLang . '_LASTTEN', 'Last 10 Alumni Listings');
define($modinfoLang . '_NEWTIME', 'New Alumni Listings from :');
define($modinfoLang . '_INTHISCAT', 'in this category');
define($modinfoLang . '_DISPLSUBCAT', 'Display subcategories :');
define($modinfoLang . '_ONHOME', 'on the Front Page of Module');
define($modinfoLang . '_NUMSUBCAT', 'Number of subcategories to show :');
define($modinfoLang . '_IF', 'if');
define($modinfoLang . '_ISAT', 'is at');
define($modinfoLang . '_VIEWNEWCLASS', 'Show new Alumni Listings :');
define($modinfoLang . '_ORDREALPHA', 'Sort alphabetically');
define($modinfoLang . '_ORDREPERSO', 'Personalised Order');
define($modinfoLang . '_ORDER', 'Category Order :');

define($modinfoLang . '_GPERM_G_ADD', 'Can add');
define($modinfoLang . '_CAT2GROUPDESC', 'Check categories which you allow to access');
define($modinfoLang . '_GROUPPERMDESC', 'Select group(s) allowed to submit listings.');
define($modinfoLang . '_GROUPPERM', 'Submit Permissions');
define($modinfoLang . '_SUBMITFORM', 'Alumni Submit Permissions');
define($modinfoLang . '_SUBMITFORM_DESC', 'Select, who can submit listings');
define($modinfoLang . '_VIEWFORM', 'View Alumni Permissions');
define($modinfoLang . '_VIEWFORM_DESC', 'Select, who can view Alumni');
define($modinfoLang . '_SUPPORT', 'Support this software');
define($modinfoLang . '_OP', 'Read my opinion');
define($modinfoLang . '_PREMIUM', 'Alumni Premium');
define($modinfoLang . '_PREMIUM_DESC', 'Who can select days listing will last');

//Added for 3.0 BETA 1
define($modinfoLang . '_LIST_EDITORS', 'Select the editor to use.');
define($modinfoLang . '_EDITOR', 'Editor to use:');
define($modinfoLang . '_USE_CAPTCHA', 'Use Captcha');
//define($modinfoLang.'_ORDER','Default Order');

define($modinfoLang . '_AORDER', 'Alumni Listing Order :');

define($modinfoLang . '_ORDER_DATE', 'Order by Date');
define($modinfoLang . '_ORDER_NAME', 'Order by Name');
define($modinfoLang . '_ORDER_POP', 'Order by Hits');
define($modinfoLang . '_MUST_ADD_CAT', 'You must add a category first.');

// Notification event descriptions and mail templates

define($modinfoLang . '_CATEGORY_NOTIFY', 'Category');
define($modinfoLang . '_CATEGORY_NOTIFYDSC', 'Notification options that apply to the current category.');
define($modinfoLang . '_NOTIFY', 'Listing');
define($modinfoLang . '_NOTIFYDSC', 'Notification options that apply to the current listing.');
define($modinfoLang . '_GLOBAL_NOTIFY', 'Whole Module ');
define($modinfoLang . '_GLOBAL_NOTIFYDSC', 'Global advert notification options.');

//event

define($modinfoLang . '_NEWPOST_NOTIFY', 'New Listing');
define($modinfoLang . '_NEWPOST_NOTIFYCAP', 'Notify me of new listings in the current category.');
define($modinfoLang . '_NEWPOST_NOTIFYDSC', 'Receive notification when a new listing is posted to the current category.');
define($modinfoLang . '_NEWPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: auto-notify : New listing in category');
define($modinfoLang . '_VALIDATE_NEWPOST_NOTIFY', 'New Listing');
define($modinfoLang . '_VALIDATE_NEWPOST_NOTIFYCAP', 'Notify me of new listings in the current category.');
define($modinfoLang . '_VALIDATE_NEWPOST_NOTIFYDSC', 'Receive notification when a new listing is posted to the current category.');
define($modinfoLang . '_VALIDATE_NEWPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: auto-notify : New listing in category');
define($modinfoLang . '_UPDATE_NEWPOST_NOTIFY', 'Listing Updated');
define($modinfoLang . '_UPDATE_NEWPOST_NOTIFYCAP', 'Notify me of updated listings in the current category.');
define($modinfoLang . '_UPDATE_NEWPOST_NOTIFYDSC', 'Receive notification when an listing is updated in the current category.');
define($modinfoLang . '_UPDATE_NEWPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: auto-notify : New listing in category');
define($modinfoLang . '_DELETE_NEWPOST_NOTIFY', 'Listing Deleted');
define($modinfoLang . '_DELETE_NEWPOST_NOTIFYCAP', 'Notify me of new listings in the current category.');
define($modinfoLang . '_DELETE_NEWPOST_NOTIFYDSC', 'Receive notification when an listing is deleted from the current category.');
define($modinfoLang . '_DELETE_NEWPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: auto-notify : New listing in category');
define($modinfoLang . '_GLOBAL_NEWPOST_NOTIFY', 'New Listing');
define($modinfoLang . '_GLOBAL_NEWPOST_NOTIFYCAP', 'Notify me of new listings in all categories.');
define($modinfoLang . '_GLOBAL_NEWPOST_NOTIFYDSC', 'Receive notification when a new listing is posted to all categories.');
define($modinfoLang . '_GLOBAL_NEWPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: auto-notify : New listing in category');
define($modinfoLang . '_GLOBAL_VALIDATE_NEWPOST_NOTIFY', 'New Listing');
define($modinfoLang . '_GLOBAL_VALIDATE_NEWPOST_NOTIFYCAP', 'Notify me of new listings in all categories.');
define($modinfoLang . '_GLOBAL_VALIDATE_NEWPOST_NOTIFYDSC', 'Receive notification when a new listing is posted to all categories.');
define($modinfoLang . '_GLOBAL_VALIDATE_NEWPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: auto-notify : New listing in category');
define($modinfoLang . '_GLOBAL_UPDATE_NEWPOST_NOTIFY', 'Listing Updated');
define($modinfoLang . '_GLOBAL_UPDATE_NEWPOST_NOTIFYCAP', 'Notify me of updated listings in all categories.');
define($modinfoLang . '_GLOBAL_UPDATE_NEWPOST_NOTIFYDSC', 'Receive notification when an listing is updated in all categories.');
define($modinfoLang . '_GLOBAL_UPDATE_NEWPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: auto-notify : Listing updated in categories');
define($modinfoLang . '_GLOBAL_DELETE_NEWPOST_NOTIFY', 'Listing Deleted');
define($modinfoLang . '_GLOBAL_DELETE_NEWPOST_NOTIFYCAP', 'Notify me of deleted listings in all categories.');
define($modinfoLang . '_GLOBAL_DELETE_NEWPOST_NOTIFYDSC', 'Receive notification when an listing is deleted in all categories.');
define($modinfoLang . '_GLOBAL_DELETE_NEWPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: auto-notify : Listing deleted in categories');

// ADDED FOR 3.01

define($modinfoLang . '_INDEX_CODE', 'Extra Index Page Code');
define($modinfoLang . '_INDEX_CODE_DESC', 'Put your adsense or other code here');
define($modinfoLang . '_USE_INDEX_CODE', 'Use Extra Index Page Code');
define($modinfoLang . '_USE_INDEX_CODE_DESC', 'Put additional code between listings<br />on the index page<br />and the categories page.<br /><br />Banners, Adsense code, etc...');
define($modinfoLang . '_indexCodePlace', 'Code will show in this place in the list ');
define($modinfoLang . '_indexCodePlace_DESC', 'Ex. If you choose 4 there will be 3 listings before this code.<br /> Code will be displayed in the 4th slot.');
define($modinfoLang . '_useBanner', 'Use Xoops Banner Code');
define($modinfoLang . '_useBanner_DESC', 'Will allow you to insert xoopsbanners in between listings.<br />If you choose Yes<br />Do Not insert any code below');
define($modinfoLang . '_OFFER_SEARCH', 'Offer search within listings');
define($modinfoLang . '_OFFER_SEARCH_DESC', 'Select yes to provide a search box');

// ADDED FOR 3.1

define($modinfoLang . '_USE_CAPTCHA_DESC', '');
