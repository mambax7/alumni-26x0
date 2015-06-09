<?php

$moduleDirName = basename(dirname(dirname(__DIR__)));
$adminLang    = '_AM_' . strtoupper($moduleDirName);

define($adminLang . '_CONF', 'Alumni Configuration');
define($adminLang . '_ADDON', 'Addons');
define($adminLang . '_CATSMOD', 'School Modified');
define($adminLang . '_JOBDEL', 'Selected Listing has been deleted');
define($adminLang . '_ADDCATPRINC', 'Add a School');
define($adminLang . '_CATNAME', 'Name :');
define($adminLang . '_ADDSUBCAT', 'Add a Category or School');
define($adminLang . '_ADD', 'Add');
define($adminLang . '_CATDEL', 'Selected School has been deleted');
define($adminLang . '_YES', 'Yes');
define($adminLang . '_NO', 'No');
define($adminLang . '_SURDELCAT', 'WARNING: Are you sure you want to remove this School, and all subcategories and Alumni Listings.');
define($adminLang . '_IN', 'in');
define($adminLang . '_MODIF', 'Modify');
define($adminLang . '_MODIFCAT', 'Modify');
define($adminLang . '_CAT', 'School :');
define($adminLang . '_SUBCAT', 'Subcategory :');
define($adminLang . '_CONFMYA', 'Alumni Configuration');
define($adminLang . '_CATADD', 'School added');
define($adminLang . '_SUBCATADD', 'Subcategory added');
define($adminLang . '_JOBMOD', 'Alumni Listing has been changed');
define($adminLang . '_NOANNVAL', 'There are currently no Alumni to approve');
define($adminLang . '_NOMODACTIV', 'Moderation is not active, no Alumni to approve');
define($adminLang . '_MODANN', 'Change a Listing');
define($adminLang . '_ALLMODANN', '(All Alumni can be modified by the administrator.)');
//	define($adminLang.'_NUMALUM','Alumni No. :');

// message //
define($adminLang . '_HELLO', 'Hello, ');
define($adminLang . '_JOBVALID', 'Alumni has been approved');
define($adminLang . '_DEL', 'Delete');
define($adminLang . '_SAVMOD', 'Save your changes');
define($adminLang . '_MODSCHOOL', 'Modify School');
define($adminLang . '_ACCEPT', 'Your Alumni Listing has been approved');
define($adminLang . '_CONSULTTO', 'View it here :');
define($adminLang . '_THANK', 'Thank you');
define($adminLang . '_SEENON', 'As seen on');
// message end //

define($adminLang . '_RETURN', 'Return');
define($adminLang . '_MODSUBCAT', 'Change subcategory name');
define($adminLang . '_MODCAT', 'Change main category name');
define($adminLang . '_GO', 'Go');
define($adminLang . '_SENDBY', 'Submitted By :');
define($adminLang . '_EMAIL', 'Email :');
define($adminLang . '_OCC', 'Occupation :');
define($adminLang . '_TOWN', 'Current Location :');
define($adminLang . '_COUNTRY', 'Country :');
define($adminLang . '_NAME', 'First Name :');
define($adminLang . '_MNAME', 'Middle/Maiden Name :');
define($adminLang . '_SCHOOL', 'School :');
define($adminLang . '_STUDIES', 'Studies :');
define($adminLang . '_PHOTO', 'Grad. Photo : ');
define($adminLang . '_PHOTO2', 'Current Photo : ');
define($adminLang . '_PRICE2', 'Salary :');
define($adminLang . '_SCHOOL2', 'School :');
define($adminLang . '_LNAME', 'Last Name :');
define($adminLang . '_REQUIRE', 'Studies :');
define($adminLang . '_EXTRAINFO', 'Extra Info :');
define($adminLang . '_ACTIVITIES', 'Student Activities :');
define($adminLang . '_OK', 'Approved');
define($adminLang . '_THEREIS', 'There are ');
define($adminLang . '_WAIT', 'Alumni Listings waiting to be moderated');
define($adminLang . '_ADDSCHOOL', 'Add School');
define($adminLang . '_ERRORSCHOOL', 'ERROR : School');
define($adminLang . '_EXIST', 'already exists!');
define($adminLang . '_ERRORCAT', 'ERROR : School');
define($adminLang . '_ERRORSUBCAT', 'ERROR : Subcategory');
define($adminLang . '_SCHOOLMOD', 'The School has been modified');
define($adminLang . '_SCHOOLDEL', 'The School has been deleted');
define($adminLang . '_ADDSCHOOL2', 'School has been added');
define($adminLang . '_ACCESMYANN', 'Alumni');
define($adminLang . '_CLASSOF', 'Class of :');
define($adminLang . '_SCADDRESS', 'School Address :');
define($adminLang . '_SCADDRESS2', 'School Address2 :');
define($adminLang . '_SCCITY', 'School City :');
define($adminLang . '_SCSTATE', 'School State :');
define($adminLang . '_SCZIP', 'School Zip Code :');
define($adminLang . '_SCPHONE', 'School Phone :');
define($adminLang . '_SCFAX', 'School Fax :');
define($adminLang . '_SCMOTTO', 'School Motto :');
define($adminLang . '_SCPHOTO', 'School Photo :');
define($adminLang . '_SCURL', 'School Website :http://');
define($adminLang . '_WEB', 'School Website');
define($adminLang . '_YEAR2', 'Year :');
define($adminLang . '_IMGCAT', 'Category Icon :');
define($adminLang . '_REPIMGCAT', 'Image directory :');
define($adminLang . '_GESTCAT', 'School Maintenance');
define($adminLang . '_NONE', 'No Picture');
define($adminLang . '_ORDER', 'School Order :');
define($adminLang . '_ORDRECLASS', 'School Order :');
define($adminLang . '_ORDREALPHA', 'Sort alphabetically');
define($adminLang . '_ORDREPERSO', 'Personalised Order');
define($adminLang . '_BIGCAT', 'Main Category');
define($adminLang . '_HELP1', '<b>To add a School :</b> click on the image <img src=\'' . XOOPS_URL . "/modules/{$moduleDirName}/assets/images/plus.gif" . '\' border=0 width=10 height=10 alt=\'Add a School\'> alongside the School you want to add the School under.<p><b>To change or delete a School :</b> click on the name of the School');
define($adminLang . '_HELP2', '<b>School Order :</b> integer in brackets corresponds to the order within the superior School or of the principal School. Negative integers can be used.: -1');

// fichier pref.php //
define($adminLang . '_CONFSAVE', 'Configuration saved');
define($adminLang . '_USECAT', 'Use Categories<br />(Ex. high school, univ.) :');
define($adminLang . '_JOBOCANPOST', 'Anonymous user can add Listings :');
define($adminLang . '_PERPAGE', 'Alumni per page :');
define($adminLang . '_NUMNEW', 'Number of New Alumni :');
define($adminLang . '_MODERAT', 'Moderate Alumni Listings :');
define($adminLang . '_MAXIIMGS', 'Maximum Photo size :');
define($adminLang . '_MAXWIDE', 'Maximum Photo Width :');
define($adminLang . '_MAXHIGH', 'Maximum Photo Height :');
define($adminLang . '_INOCTET', 'in bytes');
define($adminLang . '_INPIXEL', 'in pixels');
define($adminLang . '_INDAYS', 'in days');
define($adminLang . '_TYPE', 'Type of Block :');
define($adminLang . '_JOBRAND', 'Random Alumni Listing');
define($adminLang . '_LASTTEN', 'Last 10 Alumni Listings');
define($adminLang . '_NEWTIME', 'New Alumni Listings from :');
define($adminLang . '_TYPEBLOC', 'Type of Block :');
define($adminLang . '_INTHISCAT', 'in this School');
define($adminLang . '_DISPLSUBCAT', 'Display subcategories :');
define($adminLang . '_ONHOME', 'on the Front Page of Module');
define($adminLang . '_ONCAT', 'Don\'t change after alumni added');
define($adminLang . '_NBDISPLSUBCAT', 'Number of subcategories to show :');
define($adminLang . '_IF', 'if');
define($adminLang . '_ISAT', 'is at');
define($adminLang . '_VIEWNEWCLASS', 'Show new Alumni Listings :');
define($adminLang . '_IFSCHOOL', '****** If this is the School fill in below ******');

// Group's Permissions
define($adminLang . '_GPERM_G_ADD', 'Can add');
define($adminLang . '_CAT2GROUPDESC', 'Check categories which you allow to access');
define($adminLang . '_GROUPPERMDESC', 'Select group(s) allowed to submit listings.');
define($adminLang . '_GROUPPERM', 'Submit Permissions');
define($adminLang . '_SUBMITFORM', 'Submit Permissions');
define($adminLang . '_SUBMITFORM_DESC', 'Select, who can submit jobs');

// Directory Permissions
define($adminLang . '_DIRPERMS', 'Check Directory Permission ! => ');
define($adminLang . '_CHECKER', 'Directory Checker');

// Added for 2.0 BETA 1

define($adminLang . '_CAPTCHA', 'Security Code :');

// Added for 3.0 RC1
define($adminLang . '_GOTOMOD', 'go to module');
define($adminLang . '_HELP', 'help');
define($adminLang . '_PREFS', 'Preferences');

// Added for 3.01 RC1

// About.php
define($adminLang . '_ABOUT_RELEASEDATE', 'Released: ');
define($adminLang . '_ABOUT_UPDATEDATE', 'Updated: ');
define($adminLang . '_ABOUT_AUTHOR', 'Author: ');
define($adminLang . '_ABOUT_CREDITS', 'Credits: ');
define($adminLang . '_ABOUT_LICENSE', 'License: ');
define($adminLang . '_ABOUT_MODULE_STATUS', 'Status: ');
define($adminLang . '_ABOUT_WEBSITE', 'Website: ');
define($adminLang . '_ABOUT_AUTHOR_NAME', 'Author name: ');
define($adminLang . '_ABOUT_CHANGELOG', 'Change Log');
define($adminLang . '_ABOUT_MODULE_INFO', 'Module Info');
define($adminLang . '_ABOUT_AUTHOR_INFO', 'Author Info');
define($adminLang . '_ABOUT_DESCRIPTION', 'Description: ');

// Added for 3.1 beta1
define($adminLang . '_FILECHECKS', 'Information');
define($adminLang . '_UPLOADMAX', 'Maximum upload size: ');
define($adminLang . '_POSTMAX', 'Maximum post size: ');
define($adminLang . '_UPLOADS', 'Uploads allowed: ');
define($adminLang . '_UPLOAD_ON', 'On');
define($adminLang . '_UPLOAD_OFF', 'Off');
define($adminLang . '_GDIMGSPPRT', 'GD image lib supported: ');
define($adminLang . '_GDIMGON', 'Yes');
define($adminLang . '_GDIMGOFF', 'No');
define($adminLang . '_GDIMGVRSN', 'GD image lib version: ');
define($adminLang . '_UPDATE_SUCCESS', 'Updated Successfully');

define($adminLang . '_SUMMARY', 'General stats');
define($adminLang . '_WAITVALCAP', 'Validation:');
define($adminLang . '_WAITVA_JOB', '%s Alumni are waiting to be <a href=\'alumni.php\'>published</a>.');

define($adminLang . '_REVIEWTOTCAP', 'Alumni:');
define($adminLang . '_PUBLISHED', '%s Alumni <a href=\'alumni.php\'>published</a>.');
define($adminLang . '_CATETOTCAP', 'Alumni Categories:');
define($adminLang . '_CATETOT', '%s Alumni <a href=\'alumni.php\'>categories</a>.');
define($adminLang . '_CATTBLCAP', 'Categories');

define($adminLang . '_PUBLISHEDCAP', 'Published:');

define($adminLang . '_HIDDENCAP', 'Hidden:');

define($adminLang . '_MANAGECAT', 'Manage Categories');
define($adminLang . '_MAN_JOB', 'Manage Alumni Listings');
define($adminLang . '_NO_JOB', 'No Alumni Listed');
define($adminLang . '_ADD_LINK', 'Add an Alumni listing');
define($adminLang . '_CATEGORYLIST', 'List Alumni Categories');

define($adminLang . '_FULLNAME', 'Full Name :');
define($adminLang . '_SUBMITTED_ON', 'Submitted On :');
define($adminLang . '_LISTING_NUM', 'Listing Number :');
define($adminLang . '_ACTIONS', 'Action :');
define($adminLang . '_SUBMITTER', 'Submitter :');
define($adminLang . '_SUBMIT', 'Submit');

// Added for

define($adminLang . '_FORMOK', 'Added successfully');
define($adminLang . '_FORMDELOK', 'Deleted successfully');
define($adminLang . '_FORMSUREDEL', 'Are you sure to delete it?');
define($adminLang . '_FORMUPLOAD', 'Upload Image');
define($adminLang . '_FORMIMAGE_PATH', 'Select Image');
define($adminLang . '_CATEGORY_PID', 'Select Parent');
define($adminLang . '_CATEGORY_TITLE', 'Category/School Name');
define($adminLang . '_ADD_SCHOOL', 'Add a Category or School');

define($adminLang . '_EDIT', 'Edit');
define($adminLang . '_DELETE', 'Delete');
define($adminLang . '_DATE', 'Date');
define($adminLang . '_LISTING_EDIT', 'Edit Listing');
define($adminLang . '_LISTINGLIST', 'List Alumni Listings');
define($adminLang . '_HITS', 'Hits');
define($adminLang . '_SCHOOL_YEAR', 'School - Year');
define($adminLang . '_FULL_NAME', 'Full Name');
define($adminLang . '_LISTING', 'Listing');

define($adminLang . '_CATEGORY_EDIT', 'Edit Category');
define($adminLang . '_ACTUALPICT', 'School Photo :');
define($adminLang . '_NEWPICT2', 'New image :');

define($adminLang . '_DELPICT', 'Delete this Photo');
define($adminLang . '_GRAD_PIC', 'Graduation Photo :');
define($adminLang . '_NOW_PIC', 'Recent Photo :');

define($adminLang . '_LISTING_VALIDATED', 'This listing is now validated');

define($adminLang . '_CATEGORY_ADD', 'Add Category');
