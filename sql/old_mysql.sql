CREATE TABLE alumni_listing (
  lid        INT(11)      NOT NULL AUTO_INCREMENT,
  cid        INT(11)      NOT NULL DEFAULT '0',
  name       VARCHAR(100) NOT NULL DEFAULT '',
  mname      VARCHAR(100) NOT NULL DEFAULT '',
  lname      VARCHAR(100) NOT NULL DEFAULT '',
  school     VARCHAR(100) NOT NULL DEFAULT '',
  year       VARCHAR(4)   NOT NULL DEFAULT '',
  studies    VARCHAR(100) NOT NULL DEFAULT '',
  activities MEDIUMTEXT   NOT NULL,
  extrainfo  TEXT         NOT NULL,
  occ        VARCHAR(100) NOT NULL DEFAULT '',
  date       VARCHAR(25)           DEFAULT NULL,
  email      VARCHAR(100) NOT NULL DEFAULT '',
  submitter  VARCHAR(60)  NOT NULL DEFAULT '',
  usid       VARCHAR(6)   NOT NULL DEFAULT '',
  town       VARCHAR(100) NOT NULL DEFAULT '',
  valid      VARCHAR(11)  NOT NULL DEFAULT '',
  photo      VARCHAR(100) NOT NULL DEFAULT '',
  photo2     VARCHAR(100) NOT NULL DEFAULT '',
  view       VARCHAR(10)  NOT NULL DEFAULT '0',
  PRIMARY KEY (lid)
)
  ENGINE = MyISAM;


# --------------------------------------------------------

#
# Table structure for table `alumni_price`

CREATE TABLE alumni_categories (
  cid        INT(11)         NOT NULL AUTO_INCREMENT,
  pid        INT(5) UNSIGNED NOT NULL DEFAULT '0',
  title      VARCHAR(100)    NOT NULL DEFAULT '',
  scaddress  VARCHAR(100)    NOT NULL DEFAULT '',
  scaddress2 VARCHAR(100)    NOT NULL DEFAULT '',
  sccity     VARCHAR(100)    NOT NULL DEFAULT '',
  scstate    VARCHAR(100)    NOT NULL DEFAULT '',
  sczip      VARCHAR(20)     NOT NULL DEFAULT '',
  scphone    VARCHAR(30)     NOT NULL DEFAULT '',
  scfax      VARCHAR(30)     NOT NULL DEFAULT '',
  scmotto    VARCHAR(100)    NOT NULL DEFAULT '',
  scurl      VARCHAR(150)    NOT NULL DEFAULT '',
  img        VARCHAR(150)    NOT NULL DEFAULT '',
  scphoto    VARCHAR(150)    NOT NULL DEFAULT '',
  ordre      INT(5)          NOT NULL DEFAULT '0',
  PRIMARY KEY (cid)
)
  ENGINE = MyISAM;


# Table structure for table `alumni_ip_log`

CREATE TABLE `alumni_ip_log` (
  ip_id     INT(11)      NOT NULL AUTO_INCREMENT,
  lid       INT(11)      NOT NULL DEFAULT '0',
  date      VARCHAR(25)           DEFAULT NULL,
  submitter VARCHAR(60)  NOT NULL DEFAULT '',
  ipnumber  VARCHAR(150) NOT NULL DEFAULT '',
  email     VARCHAR(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`ip_id`)
)
  ENGINE = MyISAM
  AUTO_INCREMENT = 1;

