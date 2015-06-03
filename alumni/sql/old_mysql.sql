
CREATE TABLE alumni_listing (
  lid int(11) NOT NULL auto_increment,
  cid int(11) NOT NULL default '0',
  name varchar(100) NOT NULL default '', 
  mname varchar(100) NOT NULL default '',
  lname varchar(100) NOT NULL default '',
  school varchar(100) NOT NULL default '',
  year varchar(4) NOT NULL default '',
  studies varchar(100) NOT NULL default '',
  activities mediumtext NOT NULL,
  extrainfo text NOT NULL,
  occ varchar(100) NOT NULL default '',
  date varchar(25) default NULL,
  email varchar(100) NOT NULL default '',
  submitter varchar(60) NOT NULL default '',
  usid varchar(6) NOT NULL default '',
  town varchar(100) NOT NULL default '',
  valid varchar(11) NOT NULL default '',
  photo varchar(100) NOT NULL default '',
  photo2 varchar(100) NOT NULL default '',
  view varchar(10) NOT NULL default '0',
  PRIMARY KEY  (lid)
) ENGINE=MyISAM;


# --------------------------------------------------------

#
# Table structure for table `alumni_price`

CREATE TABLE alumni_categories (
  cid int(11) NOT NULL auto_increment,
  pid int(5) unsigned NOT NULL default '0',
  title varchar(100) NOT NULL default '',
  scaddress varchar(100) NOT NULL default '',
  scaddress2 varchar(100) NOT NULL default '',
  sccity varchar(100) NOT NULL default '',
  scstate varchar(100) NOT NULL default '',
  sczip varchar(20) NOT NULL default '',
  scphone varchar(30) NOT NULL default '',
  scfax varchar(30) NOT NULL default '',
  scmotto varchar(100) NOT NULL default '',
  scurl varchar(150) NOT NULL default '',
  img varchar(150) NOT NULL default '',
  scphoto varchar(150) NOT NULL default '',
  ordre int(5) NOT NULL default '0',
  PRIMARY KEY  (cid)
) ENGINE=MyISAM;


# Table structure for table `alumni_ip_log`

CREATE TABLE `alumni_ip_log` (
  ip_id int(11) NOT NULL auto_increment,
  lid int(11) NOT NULL default '0',
  date varchar(25) default NULL,
  submitter varchar(60) NOT NULL default '',
  ipnumber varchar(150) NOT NULL default '',
  email varchar(100) NOT NULL default '',
  PRIMARY KEY  (`ip_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;

