<?php
// Blocks
$moduleDirName = basename(dirname(dirname(__DIR__)));
$blocksLang   = '_MB_' . strtoupper($moduleDirName);

define($blocksLang . '_TITLE', 'Alumni Listings');
define($blocksLang . '_ALL_LISTINGS', 'View all Alumni Listings.');
define($blocksLang . '_ITEM', 'Title');
define($blocksLang . '_DATE', 'Date');
define($blocksLang . '_DISP', 'Display');
define($blocksLang . '_CHARS', 'Length of the title');
define($blocksLang . '_LISTINGS', 'Listings');
define($blocksLang . '_LENGTH', ' characters');

define($blocksLang . '_ORDER', ' Order');
define($blocksLang . '_HITS', ' Hits');

define($blocksLang . '_BNAME', 'Alumni Block');
define($blocksLang . '_BNAME_DESC', 'Shows Alumni Block');
