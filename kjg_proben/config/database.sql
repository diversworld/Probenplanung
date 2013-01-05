-- **********************************************************
-- *                                                        *
-- * IMPORTAND NOTE                                         *
-- *                                                        *
-- * Do not impor this file manually but use the Contao     *
-- * install tool to create and maintain database tables!   *
-- *                                                        *
-- **********************************************************


--
-- Table 'tl_screencast_archive'
--

CREATE TABLE `tl_kjg_proben_archive` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `alias` varbinary(128) NOT NULL default '',
  `slotdate` varchar(10) NOT NULL default '',
  `slotstart` int(10) unsigned NULL default NULL,
  `slotend` int(10) unsigned NULL default NULL,
  `interv` int(10) unsigned NULL default NULL,
  `published` char(1) NOT NULL default '',
  `start` varchar(10) NOT NULL default '',
  `stop` varchar(10) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `alias` (`alias`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table 'tl_screencast'
--

CREATE TABLE `tl_kjg_proben` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pid` int(10) unsigned NOT NULL default '0',
  `sorting` int(10) unsigned NOT NULL default '0',
  `tstamp` int(10) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `alias` varbinary(128) NOT NULL default '',
  `gruppe` varchar(255) NOT NULL default '',
  `sprecher` varchar(255) NOT NULL default '',
  `music` text NULL,
  `info` text NULL,
  `published` char(1) NOT NULL default '',
  `start` varchar(10) NOT NULL default '',
  `stop` varchar(10) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `alias` (`alias`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table 'tl_module'
--

CREATE TABLE `tl_module` (
  `kjg_proben_archives` int(10) unsigned NOT NULL default '0',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table `tl_content`
--

CREATE TABLE `tl_content` (
  `kjg_proben` smallint(5) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
