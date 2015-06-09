<?php

$moduleDirName = basename(dirname(dirname(__DIR__)));
$admin_lang    = '_AM_' . strtoupper($moduleDirName);

define($admin_lang . '_CONF', 'Alumni Configuration');
define($admin_lang . '_ADDON', 'Addons');
define($admin_lang . '_CATSMOD', 'School Modified');
define($admin_lang . '_JOBDEL', 'Selected Listing has been deleted');
define($admin_lang . '_ADDCATPRINC', 'Add a School');
define($admin_lang . '_CATNAME', 'Name :');
define($admin_lang . '_ADDSUBCAT', 'Add a Category or School');
define($admin_lang . '_ADD', 'Add');
define($admin_lang . '_CATDEL', 'Selected School has been deleted');
define($admin_lang . '_YES', 'Yes');
define($admin_lang . '_NO', 'No');
define($admin_lang . '_SURDELCAT', 'WARNING: Are you sure you want to remove this School, and all subcategories and Alumni Listings.');
define($admin_lang . '_IN', 'in');
define($admin_lang . '_MODIF', 'Modify');
define($admin_lang . '_MODIFCAT', 'Modify');
define($admin_lang . '_CAT', 'School :');
define($admin_lang . '_SUBCAT', 'Subcategory :');
define($admin_lang . '_CONFMYA', 'Alumni Configuration');
define($admin_lang . '_CATADD', 'School added');
define($admin_lang . '_SUBCATADD', 'Subcategory added');
define($admin_lang . '_JOBMOD', 'Alumni Listing has been changed');
define($admin_lang . '_NOANNVAL', 'There are currently no Alumni to approve');
define($admin_lang . '_NOMODACTIV', 'Moderation is not active, no Alumni to approve');
define($admin_lang . '_MODANN', 'Change a Listing');
define($admin_lang . '_ALLMODANN', '(All Alumni can be modified by the administrator.)');
//	define($admin_lang.'_NUMALUM','Alumni No. :');

// message //
define($admin_lang . '_HELLO', 'Hello, ');
define($admin_lang . '_JOBVALID', 'Alumni has been approved');
define($admin_lang . '_DEL', 'Delete');
define($admin_lang . '_SAVMOD', 'Save your changes');
define($admin_lang . '_MODSCHOOL', 'Modify School');
define($admin_lang . '_ACCEPT', 'Your Alumni Listing has been approved');
define($admin_lang . '_CONSULTTO', 'View it here :');
define($admin_lang . '_THANK', 'Thank you');
define($admin_lang . '_SEENON', 'As seen on');
// message end //

define($admin_lang . '_RETURN', 'Return');
define($admin_lang . '_MODSUBCAT', 'Change subcategory name');
define($admin_lang . '_MODCAT', 'Change main category name');
define($admin_lang . '_GO', 'Go');
define($admin_lang . '_SENDBY', 'Submitted By :');
define($admin_lang . '_EMAIL', 'Email :');
define($admin_lang . '_OCC', 'Occupation :');
define($admin_lang . '_TOWN', 'Current Location :');
define($admin_lang . '_COUNTRY', 'Country :');
define($admin_lang . '_NAME', 'First Name :');
define($admin_lang . '_MNAME', 'Middle/Maiden Name :');
define($admin_lang . '_SCHOOL', 'School :');
define($admin_lang . '_STUDIES', 'Studies :');
define($admin_lang . '_PHOTO', 'Grad. Photo : ');
define($admin_lang . '_PHOTO2', 'Current Photo : ');
define($admin_lang . '_PRICE2', 'Salary :');
define($admin_lang . '_SCHOOL2', 'School :');
define($admin_lang . '_LNAME', 'Last Name :');
define($admin_lang . '_REQUIRE', 'Studies :');
define($admin_lang . '_EXTRAINFO', 'Extra Info :');
define($admin_lang . '_ACTIVITIES', 'Student Activities :');
define($admin_lang . '_OK', 'Approved');
define($admin_lang . '_THEREIS', 'There are ');
define($admin_lang . '_WAIT', 'Alumni Listings waiting to be moderated');
define($admin_lang . '_ADDSCHOOL', 'Add School');
define($admin_lang . '_ERRORSCHOOL', 'ERROR : School');
define($admin_lang . '_EXIST', 'already exists!');
define($admin_lang . '_ERRORCAT', 'ERROR : School');
define($admin_lang . '_ERRORSUBCAT', 'ERROR : Subcategory');
define($admin_lang . '_SCHOOLMOD', 'The School has been modified');
define($admin_lang . '_SCHOOLDEL', 'The School has been deleted');
define($admin_lang . '_ADDSCHOOL2', 'School has been added');
define($admin_lang . '_ACCESMYANN', 'Alumni');
define($admin_lang . '_CLASSOF', 'Class of :');
define($admin_lang . '_SCADDRESS', 'School Address :');
define($admin_lang . '_SCADDRESS2', 'School Address2 :');
define($admin_lang . '_SCCITY', 'School City :');
define($admin_lang . '_SCSTATE', 'School State :');
define($admin_lang . '_SCZIP', 'School Zip Code :');
define($admin_lang . '_SCPHONE', 'School Phone :');
define($admin_lang . '_SCFAX', 'School Fax :');
define($admin_lang . '_SCMOTTO', 'School Motto :');
define($admin_lang . '_SCPHOTO', 'School Photo :');
define($admin_lang . '_SCURL', 'School Website :http://');
define($admin_lang . '_WEB', 'School Website');
define($admin_lang . '_YEAR2', 'Year :');
define($admin_lang . '_IMGCAT', 'Category Icon :');
define($admin_lang . '_REPIMGCAT', 'Image directory :');
define($admin_lang . '_GESTCAT', 'School Maintenance');
define($admin_lang . '_NONE', 'No Picture');
define($admin_lang . '_ORDER', 'School Order :');
define($admin_lang . '_ORDRECLASS', 'School Order :');
define($admin_lang . '_ORDREALPHA', 'Sort alphabetically');
define($admin_lang . '_ORDREPERSO', 'Personalised Order');
define($admin_lang . '_BIGCAT', 'Main Category');
define($admin_lang . '_HELP1', '<b>To add a School :</b> click on the image <img src=\'' . XOOPS_URL . "/modules/{$moduleDirName}/assets/images/plus.gif" . '\' border=0 width=10 height=10 alt=\'Add a School\'> alongside the School you want to add the School under.<p><b>To change or delete a School :</b> click on the name of the School');
define($admin_lang . '_HELP2', '<b>School Order :</b> integer in brackets corresponds to the order within the superior School or of the principal School. Negative integers can be used.: -1');

// fichier pref.php //
define($admin_lang . '_CONFSAVE', 'Configuration saved');
define($admin_lang . '_USECAT', 'Use Categories<br />(Ex. high school, univ.) :');
define($admin_lang . '_JOBOCANPOST', 'Anonymous user can add Listings :');
define($admin_lang . '_PERPAGE', 'Alumni per page :');
define($admin_lang . '_NUMNEW', 'Number of New Alumni :');
define($admin_lang . '_MODERAT', 'Moderate Alumni Listings :');
define($admin_lang . '_MAXIIMGS', 'Maximum Photo size :');
define($admin_lang . '_MAXWIDE', 'Maximum Photo Width :');
define($admin_lang . '_MAXHIGH', 'Maximum Photo Height :');
define($admin_lang . '_INOCTET', 'in bytes');
define($admin_lang . '_INPIXEL', 'in pixels');
define($admin_lang . '_INDAYS', 'in days');
define($admin_lang . '_TYPE', 'Type of Block :');
define($admin_lang . '_JOBRAND', 'Random Alumni Listing');
define($admin_lang . '_LASTTEN', 'Last 10 Alumni Listings');
define($admin_lang . '_NEWTIME', 'New Alumni Listings from :');
define($admin_lang . '_TYPEBLOC', 'Type of Block :');
define($admin_lang . '_INTHISCAT', 'in this School');
define($admin_lang . '_DISPLSUBCAT', 'Display subcategories :');
define($admin_lang . '_ONHOME', 'on the Front Page of Module');
define($admin_lang . '_ONCAT', 'Don\'t change after alumni added');
define($admin_lang . '_NBDISPLSUBCAT', 'Number of subcategories to show :');
define($admin_lang . '_IF', 'if');
define($admin_lang . '_ISAT', 'is at');
define($admin_lang . '_VIEWNEWCLASS', 'Show new Alumni Listings :');
define($admin_lang . '_IFSCHOOL', '****** If this is the School fill in below ******');

// Group's Permissions
define($admin_lang . '_GPERM_G_ADD', 'Can add');
define($admin_lang . '_CAT2GROUPDESC', 'Check categories which you allow to access');
define($admin_lang . '_GROUPPERMDESC', 'Select group(s) allowed to submit listings.');
define($admin_lang . '_GROUPPERM', 'Submit Permissions');
define($admin_lang . '_SUBMITFORM', 'Submit Permissions');
define($admin_lang . '_SUBMITFORM_DESC', 'Select, who can submit jobs');

// Directory Permissions
define($admin_lang . '_DIRPERMS', 'Check Directory Permission ! => ');
define($admin_lang . '_CHECKER', 'Directory Checker');

// Added for 2.0 BETA 1

define($admin_lang . '_CAPTCHA', 'Security Code :');

// Added for 3.0 RC1
define($admin_lang . '_GOTOMOD', 'go to module');
define($admin_lang . '_HELP', 'help');
define($admin_lang . '_PREFS', 'Preferences');

// Added for 3.01 RC1

// About.php
define($admin_lang . '_ABOUT_RELEASEDATE', 'Released: ');
define($admin_lang . '_ABOUT_UPDATEDATE', 'Updated: ');
define($admin_lang . '_ABOUT_AUTHOR', 'Author: ');
define($admin_lang . '_ABOUT_CREDITS', 'Credits: ');
define($admin_lang . '_ABOUT_LICENSE', 'License: ');
define($admin_lang . '_ABOUT_MODULE_STATUS', 'Status: ');
define($admin_lang . '_ABOUT_WEBSITE', 'Website: ');
define($admin_lang . '_ABOUT_AUTHOR_NAME', 'Author name: ');
define($admin_lang . '_ABOUT_CHANGELOG', 'Change Log');
define($admin_lang . '_ABOUT_MODULE_INFO', 'Module Info');
define($admin_lang . '_ABOUT_AUTHOR_INFO', 'Author Info');
define($admin_lang . '_ABOUT_DESCRIPTION', 'Description: ');

// Added for 3.1 beta1
define($admin_lang . '_FILECHECKS', 'Information');
define($admin_lang . '_UPLOADMAX', 'Maximum upload size: ');
define($admin_lang . '_POSTMAX', 'Maximum post size: ');
define($admin_lang . '_UPLOADS', 'Uploads allowed: ');
define($admin_lang . '_UPLOAD_ON', 'On');
define($admin_lang . '_UPLOAD_OFF', 'Off');
define($admin_lang . '_GDIMGSPPRT', 'GD image lib supported: ');
define($admin_lang . '_GDIMGON', 'Yes');
define($admin_lang . '_GDIMGOFF', 'No');
define($admin_lang . '_GDIMGVRSN', 'GD image lib version: ');
define($admin_lang . '_UPDATE_SUCCESS', 'Updated Successfully');

define($admin_lang . '_SUMMARY', 'General stats');
define($admin_lang . '_WAITVALCAP', 'Validation:');
define($admin_lang . '_WAITVA_JOB', '%s Alumni are waiting to be <a href=\'alumni.php\'>published</a>.');

define($admin_lang . '_REVIEWTOTCAP', 'Alumni:');
define($admin_lang . '_PUBLISHED', '%s Alumni <a href=\'alumni.php\'>published</a>.');
define($admin_lang . '_CATETOTCAP', 'Alumni Categories:');
define($admin_lang . '_CATETOT', '%s Alumni <a href=\'alumni.php\'>categories</a>.');
define($admin_lang . '_CATTBLCAP', 'Categories');

define($admin_lang . '_PUBLISHEDCAP', 'Published:');

define($admin_lang . '_HIDDENCAP', 'Hidden:');

define($admin_lang . '_MANAGECAT', 'Manage Categories');
define($admin_lang . '_MAN_JOB', 'Manage Alumni Listings');
define($admin_lang . '_NO_JOB', 'No Alumni Listed');
define($admin_lang . '_ADD_LINK', 'Add an Alumni listing');
define($admin_lang . '_CATEGORYLIST', 'List Alumni Categories');

define($admin_lang . '_FULLNAME', 'Full Name :');
define($admin_lang . '_SUBMITTED_ON', 'Submitted On :');
define($admin_lang . '_LISTING_NUM', 'Listing Number :');
define($admin_lang . '_ACTIONS', 'Action :');
define($admin_lang . '_SUBMITTER', 'Submitter :');
define($admin_lang . '_SUBMIT', 'Submit');

// Added for

define($admin_lang . '_FORMOK', 'Added successfully');
define($admin_lang . '_FORMDELOK', 'Deleted successfully');
define($admin_lang . '_FORMSUREDEL', 'Are you sure to delete it?');
define($admin_lang . '_FORMUPLOAD', 'Upload Image');
define($admin_lang . '_FORMIMAGE_PATH', 'Select Image');
define($admin_lang . '_CATEGORY_PID', 'Select Parent');
define($admin_lang . '_CATEGORY_TITLE', 'Category/School Name');
define($admin_lang . '_ADD_SCHOOL', 'Add a Category or School');

define($admin_lang . '_EDIT', 'Edit');
define($admin_lang . '_DELETE', 'Delete');
define($admin_lang . '_DATE', 'Date');
define($admin_lang . '_LISTING_EDIT', 'Edit Listing');
define($admin_lang . '_LISTINGLIST', 'List Alumni Listings');
define($admin_lang . '_HITS', 'Hits');
define($admin_lang . '_SCHOOL_YEAR', 'School - Year');
define($admin_lang . '_FULL_NAME', 'Full Name');
define($admin_lang . '_LISTING', 'Listing');

define($admin_lang . '_CATEGORY_EDIT', 'Edit Category');
define($admin_lang . '_ACTUALPICT', 'School Photo :');
define($admin_lang . '_NEWPICT2', 'New image :');

define($admin_lang . '_DELPICT', 'Delete this Photo');
define($admin_lang . '_GRAD_PIC', 'Graduation Photo :');
define($admin_lang . '_NOW_PIC', 'Recent Photo :');

define($admin_lang . '_LISTING_VALIDATED', 'This listing is now validated');

define($admin_lang . '_CATEGORY_ADD', 'Add Category');
