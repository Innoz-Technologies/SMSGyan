CREATE TABLE IF NOT EXISTS `akosha` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(50) NOT NULL,
  `company` varchar(200) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `number` (`number`,`company`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1910 ;


CREATE TABLE IF NOT EXISTS `ask_songs` (
  `id` int(10) unsigned NOT NULL,
  `tone_code` int(10) unsigned NOT NULL,
  `tone_id` int(10) unsigned NOT NULL,
  `tone_name` varchar(255) NOT NULL,
  `singer` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `auto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msisdn` varchar(20) NOT NULL,
  `vech_no` varchar(50) NOT NULL,
  `msg` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=54 ;

CREATE TABLE IF NOT EXISTS `celebrityName` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msisdn` varchar(10) NOT NULL,
  `name` varchar(500) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

CREATE TABLE IF NOT EXISTS `celebrityTweets` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `celebrityID` int(11) NOT NULL,
  `tweets` varchar(500) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

CREATE TABLE IF NOT EXISTS `chatUsers` (
  `msisdn` varchar(20) NOT NULL,
  `circle` varchar(10) NOT NULL,
  PRIMARY KEY (`msisdn`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `chat_anony` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(20) NOT NULL,
  `circle` varchar(20) NOT NULL,
  `operator` varchar(20) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `updTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `isFree` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `number` (`number`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39441343 ;

CREATE TABLE IF NOT EXISTS `chat_frdlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fromMsisdn` varchar(20) NOT NULL,
  `fromUserName` varchar(20) NOT NULL,
  `toMsisdn` varchar(20) NOT NULL,
  `toUserName` varchar(20) NOT NULL,
  `toCircle` varchar(10) NOT NULL,
  `toOperator` varchar(20) NOT NULL,
  `toIsFree` tinyint(1) NOT NULL,
  `isAccept` tinyint(4) NOT NULL,
  `updTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fromMsisdn` (`fromMsisdn`,`toMsisdn`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

CREATE TABLE IF NOT EXISTS `chat_process` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fromNumber` varchar(20) NOT NULL,
  `toNumber` varchar(20) NOT NULL,
  `fromCircle` varchar(20) NOT NULL,
  `toCircle` varchar(20) NOT NULL,
  `fromOperator` varchar(20) NOT NULL,
  `toOperator` varchar(20) NOT NULL,
  `updTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fromIsFree` tinyint(1) NOT NULL,
  `toIsFree` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fromNumber` (`fromNumber`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=65404 ;


CREATE TABLE IF NOT EXISTS `chat_register` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msisdn` varchar(20) NOT NULL,
  `circle` varchar(10) NOT NULL,
  `operator` varchar(10) NOT NULL,
  `userName` varchar(20) NOT NULL,
  `sex` varchar(10) NOT NULL,
  `city` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `status` tinyint(1) NOT NULL,
  `isFree` tinyint(1) NOT NULL,
  `updTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `msisdn` (`msisdn`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;


CREATE TABLE IF NOT EXISTS `chat_summary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fromNumber` varchar(20) NOT NULL,
  `fromCircle` varchar(10) NOT NULL,
  `fromOperator` varchar(20) NOT NULL,
  `toNumber` varchar(20) NOT NULL,
  `toCircle` varchar(10) NOT NULL,
  `toOperator` varchar(20) NOT NULL,
  `updTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fromQueryID` varchar(50) DEFAULT NULL,
  `toQueryID` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20779955 ;

CREATE TABLE IF NOT EXISTS `city_circle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(200) NOT NULL,
  `circle` varchar(50) NOT NULL,
  `state` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=528 ;


CREATE TABLE IF NOT EXISTS `crush` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sndNo` varchar(50) NOT NULL,
  `sndHash` varchar(50) NOT NULL,
  `rcvNo` varchar(50) NOT NULL,
  `rcvHash` varchar(50) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sndHash` (`sndHash`,`rcvHash`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=923 ;

CREATE TABLE IF NOT EXISTS `crytrack` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msisdn` varchar(100) NOT NULL,
  `circle` varchar(100) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `trackid` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;


CREATE TABLE IF NOT EXISTS `date_data` (
  `msisdn` varchar(20) NOT NULL,
  `circle` varchar(10) NOT NULL,
  `operator` varchar(20) NOT NULL,
  `gender` varchar(10) NOT NULL DEFAULT 'F',
  `age` varchar(10) NOT NULL DEFAULT '18-26',
  `interest` varchar(10) NOT NULL DEFAULT 'hf',
  `date_place` varchar(10) NOT NULL DEFAULT 'cs',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`msisdn`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `devotional` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `religion` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=218 ;

CREATE TABLE IF NOT EXISTS `ebay_data` (
  `msisdn` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `data` text COLLATE latin1_general_ci NOT NULL,
  `start` int(11) NOT NULL,
  `more` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`msisdn`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


CREATE TABLE IF NOT EXISTS `email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mobileNo` varchar(50) NOT NULL,
  `mobileSerial` varchar(200) NOT NULL,
  `mailid` varchar(200) NOT NULL,
  `passwd` varchar(200) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mailid` (`mailid`,`passwd`),
  UNIQUE KEY `mobileSerial` (`mobileSerial`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=62 ;


CREATE TABLE IF NOT EXISTS `eurocup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dated` date NOT NULL,
  `matches` varchar(200) NOT NULL,
  `time` time NOT NULL,
  `week` varchar(20) NOT NULL,
  `result` varchar(200) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `score` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

CREATE TABLE IF NOT EXISTS `eventCalendar` (
  `slno` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(20) NOT NULL,
  `keyword` varchar(30) NOT NULL,
  `vertical` varchar(30) NOT NULL,
  `country` varchar(30) NOT NULL DEFAULT 'All',
  PRIMARY KEY (`slno`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=190 ;

CREATE TABLE IF NOT EXISTS `evernote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `access_token` varchar(255) NOT NULL,
  `token` varchar(50) NOT NULL,
  `mhash` varchar(255) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `operator` varchar(50) NOT NULL,
  `circle` varchar(50) NOT NULL,
  `timestamp` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `access_token` (`access_token`),
  UNIQUE KEY `token` (`token`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59 ;

CREATE TABLE IF NOT EXISTS `fabmart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(500) DEFAULT NULL,
  `vendor` varchar(250) DEFAULT NULL,
  `type` varchar(200) DEFAULT NULL,
  `tags` varchar(200) DEFAULT NULL,
  `optionName1` varchar(200) DEFAULT NULL,
  `optionValue1` varchar(200) DEFAULT NULL,
  `optionName2` varchar(200) DEFAULT NULL,
  `optionValue2` varchar(200) DEFAULT NULL,
  `optionName3` varchar(200) DEFAULT NULL,
  `optionValue3` varchar(200) DEFAULT NULL,
  `price` varchar(100) DEFAULT NULL,
  `Shippig` varchar(10) DEFAULT NULL,
  `tax` varchar(10) DEFAULT NULL,
  `img_src` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `fulltxt` (`title`,`vendor`,`type`,`tags`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6026 ;

CREATE TABLE IF NOT EXISTS `fabmart_buy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msisdn` varchar(20) NOT NULL,
  `circle` varchar(10) NOT NULL,
  `operator` varchar(20) NOT NULL,
  `product` varchar(2000) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;


CREATE TABLE IF NOT EXISTS `fbuser` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `user_mobile` varchar(50) NOT NULL,
  `fbid` varchar(50) NOT NULL,
  `token` text NOT NULL,
  `token_date` date NOT NULL,
  `gender` varchar(10) NOT NULL DEFAULT '0',
  `updated_time` varchar(30) NOT NULL,
  `bio` text NOT NULL,
  `birthday` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `hometown` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `political` varchar(50) NOT NULL,
  `relationship_status` varchar(50) NOT NULL,
  `religion` varchar(50) NOT NULL,
  `conf_no` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fbid` (`fbid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `fleague_match` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `mname` varchar(200) NOT NULL,
  `mdate` date NOT NULL,
  `team1` varchar(100) NOT NULL,
  `team2` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mid` (`mid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=177 ;

-- --------------------------------------------------------

--
-- Table structure for table `fleague_matchplayer`
--

CREATE TABLE IF NOT EXISTS `fleague_matchplayer` (
  `grpid` varchar(20) NOT NULL,
  `playerid` int(11) NOT NULL,
  `teamid` int(11) NOT NULL,
  UNIQUE KEY `grpid` (`grpid`,`playerid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fleague_player`
--

CREATE TABLE IF NOT EXISTS `fleague_player` (
  `teamid` int(11) NOT NULL,
  `playerid` int(11) NOT NULL,
  `playername` varchar(200) NOT NULL,
  PRIMARY KEY (`playerid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fleague_team`
--

CREATE TABLE IF NOT EXISTS `fleague_team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teamid` int(11) NOT NULL,
  `teamname` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `teamid` (`teamid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

-- --------------------------------------------------------

--
-- Table structure for table `fleague_tour`
--

CREATE TABLE IF NOT EXISTS `fleague_tour` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL,
  `tname` varchar(100) NOT NULL,
  `ttype` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tid` (`tid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Table structure for table `football_tricks`
--

CREATE TABLE IF NOT EXISTS `football_tricks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `head` varchar(100) NOT NULL,
  `trick` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

-- --------------------------------------------------------

--
-- Table structure for table `ForumThread`
--

CREATE TABLE IF NOT EXISTS `ForumThread` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topicID` int(11) NOT NULL,
  `thread` text NOT NULL,
  `userID` int(11) NOT NULL,
  `language` varchar(20) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ForumTopic`
--

CREATE TABLE IF NOT EXISTS `ForumTopic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `topic` text NOT NULL,
  `language` varchar(20) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `ForumUser`
--

CREATE TABLE IF NOT EXISTS `ForumUser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(20) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `language` varchar(20) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `number` (`number`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `fsquare`
--

CREATE TABLE IF NOT EXISTS `fsquare` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acc_token` varchar(50) NOT NULL,
  `token` varchar(50) NOT NULL,
  `mhash` varchar(50) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `acc_token` (`acc_token`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `game_cri_bat`
--

CREATE TABLE IF NOT EXISTS `game_cri_bat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msisdn` varchar(20) NOT NULL,
  `circle` varchar(20) NOT NULL,
  `playerID1` int(11) NOT NULL DEFAULT '0',
  `playerID2` int(11) NOT NULL DEFAULT '0',
  `playerName1` varchar(100) NOT NULL,
  `playerName2` varchar(100) NOT NULL,
  `score1` int(11) NOT NULL DEFAULT '0',
  `score2` int(11) NOT NULL DEFAULT '0',
  `totalRun` int(11) NOT NULL DEFAULT '0',
  `totalBall` int(11) NOT NULL DEFAULT '0',
  `wicket` int(11) NOT NULL DEFAULT '0',
  `teamID` int(11) NOT NULL DEFAULT '0',
  `oppTeamID` int(11) NOT NULL DEFAULT '0',
  `team` varchar(50) NOT NULL,
  `oppTeam` varchar(50) NOT NULL,
  `currentBat` int(11) NOT NULL,
  `targetScore` int(11) NOT NULL,
  `targetOver` int(11) NOT NULL DEFAULT '30',
  `oppWicket` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=567326 ;

-- --------------------------------------------------------

--
-- Table structure for table `game_cri_cmtry`
--

CREATE TABLE IF NOT EXISTS `game_cri_cmtry` (
  `id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `commentary` varchar(250) NOT NULL,
  `typed` varchar(100) NOT NULL DEFAULT 'hit',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `game_cri_player`
--

CREATE TABLE IF NOT EXISTS `game_cri_player` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `playerName` varchar(150) NOT NULL,
  `playerType` varchar(50) NOT NULL,
  `teamID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=68 ;

-- --------------------------------------------------------

--
-- Table structure for table `game_cri_team`
--

CREATE TABLE IF NOT EXISTS `game_cri_team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team` varchar(100) NOT NULL,
  `fullName` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `gChat_master`
--

CREATE TABLE IF NOT EXISTS `gChat_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gid` int(11) NOT NULL,
  `groupName` varchar(50) NOT NULL,
  `memberName` varchar(50) NOT NULL,
  `memberNumber` varchar(20) NOT NULL,
  `admin` tinyint(4) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `groupName` (`groupName`,`memberNumber`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=888 ;

-- --------------------------------------------------------

--
-- Table structure for table `gChat_member`
--

CREATE TABLE IF NOT EXISTS `gChat_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupid` int(11) NOT NULL,
  `memberName` varchar(50) NOT NULL,
  `memberNumber` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gChat_message`
--

CREATE TABLE IF NOT EXISTS `gChat_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupid` int(11) NOT NULL,
  `number` varchar(20) NOT NULL,
  `memberName` varchar(50) NOT NULL,
  `message` varchar(400) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4653 ;

-- --------------------------------------------------------

--
-- Table structure for table `generalTips`
--

CREATE TABLE IF NOT EXISTS `generalTips` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(1000) NOT NULL,
  `type` varchar(100) NOT NULL,
  `response` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;


-- --------------------------------------------------------

--
-- Table structure for table `gsmarena_brand`
--

CREATE TABLE IF NOT EXISTS `gsmarena_brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brandName` varchar(200) NOT NULL,
  `url` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `brandName` (`brandName`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=232 ;

-- --------------------------------------------------------

--
-- Table structure for table `gsmarena_model`
--

CREATE TABLE IF NOT EXISTS `gsmarena_model` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_id` int(11) NOT NULL,
  `model` varchar(200) NOT NULL,
  `url` varchar(200) NOT NULL,
  `spec` varchar(10000) NOT NULL,
  `status` varchar(200) NOT NULL,
  `options` varchar(10000) NOT NULL,
  `list` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `brand_id` (`brand_id`,`model`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9382 ;

-- --------------------------------------------------------

--
-- Table structure for table `guitar_tips`
--

CREATE TABLE IF NOT EXISTS `guitar_tips` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `head` varchar(100) NOT NULL,
  `tip` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `hook_checkin`
--

CREATE TABLE IF NOT EXISTS `hook_checkin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `vid` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uid` (`uid`,`vid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `hook_log`
--

CREATE TABLE IF NOT EXISTS `hook_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `vid` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Table structure for table `hook_user`
--

CREATE TABLE IF NOT EXISTS `hook_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uname` varchar(50) NOT NULL,
  `mobile_hash` varchar(50) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mobile_hash` (`mobile_hash`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=159 ;

-- --------------------------------------------------------

--
-- Table structure for table `hook_venue`
--

CREATE TABLE IF NOT EXISTS `hook_venue` (
  `vid` int(11) NOT NULL AUTO_INCREMENT,
  `vname` varchar(100) NOT NULL,
  `rating` int(11) NOT NULL,
  `ucount` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`vid`),
  UNIQUE KEY `vname` (`vname`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `inname`
--

CREATE TABLE IF NOT EXISTS `inname` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(50) NOT NULL,
  `uname` varchar(50) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

-- --------------------------------------------------------

--
-- Table structure for table `innbox`
--

CREATE TABLE IF NOT EXISTS `innbox` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `regid` int(11) NOT NULL,
  `msg` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

-- --------------------------------------------------------

--
-- Table structure for table `instabike_bikes`
--

CREATE TABLE IF NOT EXISTS `instabike_bikes` (
  `city_name` varchar(255) NOT NULL,
  `bike_brand` varchar(255) NOT NULL,
  `bike_model` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`city_name`,`bike_brand`,`bike_model`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `instabike_bike_specs`
--

CREATE TABLE IF NOT EXISTS `instabike_bike_specs` (
  `spec_id` varchar(255) NOT NULL,
  `specs` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`spec_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `instabike_cities`
--

CREATE TABLE IF NOT EXISTS `instabike_cities` (
  `city_name` varchar(100) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`city_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ipcw`
--

CREATE TABLE IF NOT EXISTS `ipcw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ipc` varchar(20) NOT NULL,
  `offence` varchar(500) NOT NULL,
  `punishment` varchar(500) NOT NULL,
  `tags` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `tags` (`tags`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `ipl_stats`
--

CREATE TABLE IF NOT EXISTS `ipl_stats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `player` varchar(200) NOT NULL,
  `url` varchar(200) NOT NULL,
  `data` varchar(2000) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `player` (`player`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=165 ;

-- --------------------------------------------------------

--
-- Table structure for table `ipl_vote`
--

CREATE TABLE IF NOT EXISTS `ipl_vote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team` varchar(50) NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `joinAAP`
--

CREATE TABLE IF NOT EXISTS `joinAAP` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(20) NOT NULL,
  `circle` varchar(20) NOT NULL,
  `operator` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `age` varchar(20) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `address` varchar(100) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `number` (`number`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=275 ;

-- --------------------------------------------------------

--
-- Table structure for table `justeat_area`
--

CREATE TABLE IF NOT EXISTS `justeat_area` (
  `area_id` int(11) NOT NULL,
  `area_name` varchar(200) NOT NULL,
  `region_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `srch` varchar(200) NOT NULL,
  PRIMARY KEY (`area_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `justeat_cities`
--

CREATE TABLE IF NOT EXISTS `justeat_cities` (
  `city_id` int(11) NOT NULL,
  `city_name` varchar(200) NOT NULL,
  `std_code` varchar(20) NOT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  PRIMARY KEY (`city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `justeat_cuisines`
--

CREATE TABLE IF NOT EXISTS `justeat_cuisines` (
  `cuisine_id` int(11) NOT NULL,
  `cuisine_name` varchar(100) NOT NULL,
  PRIMARY KEY (`cuisine_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `justeat_locality`
--

CREATE TABLE IF NOT EXISTS `justeat_locality` (
  `location_id` int(11) NOT NULL,
  `location_name` varchar(200) NOT NULL,
  `city_id` int(11) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `srch` varchar(200) NOT NULL,
  PRIMARY KEY (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kannada`
--

CREATE TABLE IF NOT EXISTS `kannada` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `english` varchar(500) NOT NULL,
  `kannada` varchar(500) NOT NULL,
  `topics` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=335 ;

-- --------------------------------------------------------

--
-- Table structure for table `lyrics`
--

CREATE TABLE IF NOT EXISTS `lyrics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(500) DEFAULT NULL,
  `movie` varchar(500) DEFAULT NULL,
  `singers` varchar(500) DEFAULT NULL,
  `language` varchar(100) DEFAULT NULL,
  `lyrics` varchar(10000) DEFAULT NULL,
  `url` varchar(2000) DEFAULT NULL,
  `timestanp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6343 ;

-- --------------------------------------------------------

--
-- Table structure for table `mardpledge`
--

CREATE TABLE IF NOT EXISTS `mardpledge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `pledge` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `number` (`number`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=645 ;

-- --------------------------------------------------------

--
-- Table structure for table `MaryKomContent`
--

CREATE TABLE IF NOT EXISTS `MaryKomContent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `head` text NOT NULL,
  `tags` varchar(20) NOT NULL,
  `language` varchar(20) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `MaryKomLang`
--


CREATE TABLE IF NOT EXISTS `mensa_question` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question` varchar(255) NOT NULL,
  `answer1` varchar(255) NOT NULL,
  `answer2` varchar(255) NOT NULL,
  `answer3` varchar(255) NOT NULL,
  `answer4` varchar(255) NOT NULL,
  `answer5` varchar(255) NOT NULL,
  `correct_answer` varchar(20) NOT NULL,
  `feedback` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Table structure for table `mensa_user_response`
--

CREATE TABLE IF NOT EXISTS `mensa_user_response` (
  `mhash` varchar(255) NOT NULL,
  `question_id` int(11) unsigned NOT NULL,
  `response` varchar(10) NOT NULL,
  `timestamp` datetime NOT NULL,
  PRIMARY KEY (`mhash`,`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `olacab`
--

CREATE TABLE IF NOT EXISTS `olacab` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msisdn` varchar(12) NOT NULL,
  `circle` varchar(10) NOT NULL,
  `operator` varchar(10) NOT NULL,
  `name` varchar(200) NOT NULL,
  `fromPlace` varchar(200) NOT NULL,
  `toPlace` varchar(200) NOT NULL,
  `city` varchar(200) NOT NULL,
  `cnt` varchar(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `msisdn` (`msisdn`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `pair_friendlist`
--

CREATE TABLE IF NOT EXISTS `pair_friendlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fromNumber` varchar(20) NOT NULL,
  `fromUserName` varchar(100) NOT NULL,
  `toNumber` varchar(20) NOT NULL,
  `toCircle` varchar(10) NOT NULL,
  `toOp` varchar(20) NOT NULL,
  `toUserName` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fromNumber` (`fromNumber`,`toNumber`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `phoneApp`
--

CREATE TABLE IF NOT EXISTS `phoneApp` (
  `source` varchar(50) NOT NULL,
  `sourceid` int(11) NOT NULL,
  PRIMARY KEY (`source`),
  KEY `sourceid` (`sourceid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `photo_tips`
--

CREATE TABLE IF NOT EXISTS `photo_tips` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `head` varchar(200) NOT NULL,
  `description` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `pin_city`
--

CREATE TABLE IF NOT EXISTS `pin_city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state_id` int(11) NOT NULL,
  `district_id` int(11) NOT NULL,
  `city` varchar(200) NOT NULL,
  `url` varchar(200) NOT NULL,
  `pincode` varchar(100) NOT NULL,
  `srch` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `city` (`city`,`state_id`,`district_id`),
  KEY `pincode` (`pincode`),
  FULLTEXT KEY `city_2` (`city`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=181857 ;

-- --------------------------------------------------------

--
-- Table structure for table `pin_district`
--

CREATE TABLE IF NOT EXISTS `pin_district` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state_id` int(11) NOT NULL,
  `district` varchar(200) NOT NULL,
  `url` varchar(200) NOT NULL,
  `srch` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `district` (`district`,`state_id`),
  FULLTEXT KEY `district_2` (`district`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1197 ;

-- --------------------------------------------------------

--
-- Table structure for table `pin_state`
--

CREATE TABLE IF NOT EXISTS `pin_state` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state` varchar(100) NOT NULL,
  `url` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `state` (`state`),
  FULLTEXT KEY `state_2` (`state`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

-- --------------------------------------------------------

--
-- Table structure for table `push_log`
--

CREATE TABLE IF NOT EXISTS `push_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msisdn` varchar(20) NOT NULL,
  `circle` varchar(10) NOT NULL,
  `operator` varchar(10) NOT NULL,
  `isSuccess` tinyint(4) NOT NULL DEFAULT '1',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `msisdn` (`msisdn`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=929011 ;

-- --------------------------------------------------------

--
-- Table structure for table `push_q`
--

CREATE TABLE IF NOT EXISTS `push_q` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msisdn` varchar(20) NOT NULL,
  `circle` varchar(10) NOT NULL,
  `operator` varchar(20) NOT NULL,
  `response` varchar(1500) NOT NULL,
  `bill` float NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=196516805 ;

-- --------------------------------------------------------

--
-- Table structure for table `query_q`
--

CREATE TABLE IF NOT EXISTS `query_q` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `query` varchar(320) NOT NULL,
  `msisdn` varchar(10) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `query_number` (`query`,`msisdn`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=538037856 ;

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE IF NOT EXISTS `quiz` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quizType` varchar(100) NOT NULL,
  `question` varchar(500) NOT NULL,
  `clue1` varchar(100) NOT NULL,
  `clue2` varchar(100) NOT NULL,
  `clue3` varchar(100) NOT NULL,
  `answer` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=104 ;

-- --------------------------------------------------------

--
-- Table structure for table `qxt`
--

CREATE TABLE IF NOT EXISTS `qxt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(500) NOT NULL,
  `answer` text,
  `isAnswered` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `question` (`question`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `QxtAnswer`
--

CREATE TABLE IF NOT EXISTS `QxtAnswer` (
  `ansID` int(11) NOT NULL AUTO_INCREMENT,
  `questionID` int(11) NOT NULL,
  `answer` varchar(500) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ansID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

-- --------------------------------------------------------

--
-- Table structure for table `qxtPushed`
--

CREATE TABLE IF NOT EXISTS `qxtPushed` (
  `msisdn` varchar(20) NOT NULL,
  `circle` varchar(10) NOT NULL,
  `operator` varchar(20) NOT NULL,
  `qid` int(11) NOT NULL,
  `isAns` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`msisdn`),
  KEY `qid` (`qid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `QxtQuestion`
--

CREATE TABLE IF NOT EXISTS `QxtQuestion` (
  `questionID` int(11) NOT NULL,
  `question` varchar(500) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`questionID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `qxtQuestioned`
--

CREATE TABLE IF NOT EXISTS `qxtQuestioned` (
  `msisdn` varchar(20) NOT NULL,
  `circle` varchar(10) NOT NULL,
  `operator` varchar(20) NOT NULL,
  `qid` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`msisdn`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `QxtRequest`
--

CREATE TABLE IF NOT EXISTS `QxtRequest` (
  `questionID` int(11) NOT NULL,
  `number` varchar(20) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `questionID` (`questionID`,`number`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `raksha`
--

CREATE TABLE IF NOT EXISTS `raksha` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `emergency_email` varchar(100) NOT NULL,
  `user_mobile` varchar(50) NOT NULL,
  `emergency_mobile` varchar(50) NOT NULL,
  `code` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `noUserHash` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `noUser` (`user_mobile`,`code`),
  UNIQUE KEY `noUser_2` (`user_mobile`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `redbus_cities`
--

CREATE TABLE IF NOT EXISTS `redbus_cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cityid` int(11) NOT NULL,
  `city` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1390 ;

-- --------------------------------------------------------

--
-- Table structure for table `resolution`
--

CREATE TABLE IF NOT EXISTS `resolution` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(50) NOT NULL,
  `operator` varchar(50) NOT NULL,
  `circle` varchar(20) NOT NULL,
  `resolution` varchar(200) NOT NULL,
  `tillDate` date NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `number` (`number`,`resolution`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=165 ;

-- --------------------------------------------------------

--
-- Table structure for table `retailer`
--

CREATE TABLE IF NOT EXISTS `retailer` (
  `msisdn` varchar(20) NOT NULL,
  PRIMARY KEY (`msisdn`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Revenue_achieved`
--

CREATE TABLE IF NOT EXISTS `Revenue_achieved` (
  `circle` varchar(5) NOT NULL,
  `target` bigint(20) NOT NULL DEFAULT '0',
  `1` float NOT NULL DEFAULT '0' COMMENT 'Service 121',
  `2` float NOT NULL DEFAULT '0' COMMENT '121-2',
  `3` float NOT NULL DEFAULT '0' COMMENT 'App-Code',
  `4` float NOT NULL DEFAULT '0' COMMENT 'Billing',
  `5` float NOT NULL DEFAULT '0' COMMENT 'Infinite',
  `6` float NOT NULL DEFAULT '0' COMMENT 'Solr',
  `7` float NOT NULL DEFAULT '0' COMMENT 'userprofile',
  `8` float NOT NULL DEFAULT '0' COMMENT 'Vodafone',
  PRIMARY KEY (`circle`)
) ENGINE=MEMORY DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `rj_colleges`
--

CREATE TABLE IF NOT EXISTS `rj_colleges` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `courses` text NOT NULL,
  `university` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `cut_off` text NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=364 ;

-- --------------------------------------------------------

--
-- Table structure for table `short_url`
--

CREATE TABLE IF NOT EXISTS `short_url` (
  `long_url` varchar(500) COLLATE latin1_general_ci NOT NULL,
  `short` varchar(100) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`long_url`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sl_mobile`
--

CREATE TABLE IF NOT EXISTS `sl_mobile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mob_id` int(11) NOT NULL,
  `mob_name` varchar(500) NOT NULL,
  `tags` varchar(500) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mob_id` (`mob_id`),
  FULLTEXT KEY `mob_name` (`mob_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=196 ;

-- --------------------------------------------------------

--
-- Table structure for table `snapdeal_city`
--

CREATE TABLE IF NOT EXISTS `snapdeal_city` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `priority` int(11) NOT NULL,
  `defaultLocation` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `snapdeal_dealcategory`
--

CREATE TABLE IF NOT EXISTS `snapdeal_dealcategory` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `groupcode` varchar(50) NOT NULL,
  `srch` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  FULLTEXT KEY `code` (`code`),
  FULLTEXT KEY `srch` (`srch`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `snapdeal_getdeal`
--

CREATE TABLE IF NOT EXISTS `snapdeal_getdeal` (
  `deal_id` int(11) NOT NULL,
  `price` double NOT NULL,
  `payToMerchant` double NOT NULL,
  `voucherPrice` double NOT NULL,
  `discount` double NOT NULL,
  `percentOffDeal` tinyint(1) NOT NULL,
  `startTime` datetime NOT NULL,
  `endTime` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `codValid` tinyint(1) NOT NULL,
  `title` varchar(500) NOT NULL,
  `url` varchar(200) NOT NULL,
  `validUpto` datetime NOT NULL,
  `description` varchar(1000) NOT NULL,
  `newsletterLocations` varchar(500) NOT NULL,
  `dealCategoryId` int(11) NOT NULL,
  `highlight` varchar(1000) NOT NULL,
  `finePrint` varchar(10000) NOT NULL,
  `website` varchar(100) NOT NULL,
  `vendor` varchar(200) NOT NULL,
  `shortUrl` varchar(100) NOT NULL,
  PRIMARY KEY (`deal_id`),
  FULLTEXT KEY `getDeal` (`title`,`description`,`highlight`,`finePrint`,`vendor`),
  FULLTEXT KEY `title` (`title`,`vendor`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `snapdeal_getdeal_address`
--

CREATE TABLE IF NOT EXISTS `snapdeal_getdeal_address` (
  `zone_id` int(11) NOT NULL,
  `deal_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `address` varchar(1000) NOT NULL,
  `timing` varchar(200) NOT NULL,
  `latitude` varchar(100) NOT NULL,
  `longitude` varchar(100) NOT NULL,
  `globalOutlet` tinyint(1) NOT NULL,
  UNIQUE KEY `zone_id` (`zone_id`,`deal_id`,`latitude`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `snapdeal_getdeal_zone`
--

CREATE TABLE IF NOT EXISTS `snapdeal_getdeal_zone` (
  `city_id` int(11) NOT NULL,
  `zone_id` int(11) NOT NULL,
  `deal_id` int(11) NOT NULL,
  UNIQUE KEY `zone_id` (`zone_id`,`deal_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `snapdeal_getprd_prdoff`
--

CREATE TABLE IF NOT EXISTS `snapdeal_getprd_prdoff` (
  `prdoffgrp_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `starttime` datetime NOT NULL,
  `endtime` datetime NOT NULL,
  `updatetime` datetime NOT NULL,
  `codevalid` tinyint(1) NOT NULL,
  `price` double NOT NULL,
  `sellingprice` double NOT NULL,
  `name` varchar(200) NOT NULL,
  `priority` int(11) NOT NULL,
  `shpcharge` float NOT NULL,
  `shpchargebroneby` float NOT NULL,
  `discount` double NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `snapdeal_getprd_prdoffcat`
--

CREATE TABLE IF NOT EXISTS `snapdeal_getprd_prdoffcat` (
  `prdoff_id` int(11) NOT NULL,
  `cname` varchar(100) NOT NULL,
  UNIQUE KEY `prdoff_id` (`prdoff_id`),
  FULLTEXT KEY `cname` (`cname`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `snapdeal_getprd_prdoffcont`
--

CREATE TABLE IF NOT EXISTS `snapdeal_getprd_prdoffcont` (
  `prdoff_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `pageurl` varchar(200) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `subtitle` varchar(200) NOT NULL,
  `warenty` varchar(100) NOT NULL,
  `default` int(11) NOT NULL,
  `shortUrl` varchar(100) NOT NULL,
  `features` text NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `content` (`title`,`description`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `snapdeal_getprd_prdoffgrp`
--

CREATE TABLE IF NOT EXISTS `snapdeal_getprd_prdoffgrp` (
  `id` int(11) NOT NULL,
  `url` varchar(200) NOT NULL,
  `soldout` tinyint(1) NOT NULL,
  `brandName` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `brandName` (`brandName`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `snapdeal_locality`
--

CREATE TABLE IF NOT EXISTS `snapdeal_locality` (
  `id` int(11) NOT NULL,
  `cityName` varchar(100) NOT NULL,
  `locality` varchar(100) NOT NULL,
  `city_id` int(11) NOT NULL,
  `zone_id` int(11) NOT NULL,
  `srch` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `locality` (`locality`),
  KEY `srch` (`srch`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `snapdeal_parentcat`
--

CREATE TABLE IF NOT EXISTS `snapdeal_parentcat` (
  `parent_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `snapdeal_productcategory`
--

CREATE TABLE IF NOT EXISTS `snapdeal_productcategory` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `priority` int(11) NOT NULL,
  `parentId` int(11) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `srch` varchar(100) NOT NULL,
  `par_name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `name_2` (`name`),
  FULLTEXT KEY `srch` (`srch`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `snapdeal_zone`
--

CREATE TABLE IF NOT EXISTS `snapdeal_zone` (
  `id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `pageurl` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `city_id` (`city_id`,`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `solr_gsmarena_brand`
--

CREATE TABLE IF NOT EXISTS `solr_gsmarena_brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brandName` varchar(200) NOT NULL,
  `url` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `brandName` (`brandName`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=232 ;

-- --------------------------------------------------------

--
-- Table structure for table `startupvillage`
--

CREATE TABLE IF NOT EXISTS `startupvillage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '-',
  `email` varchar(200) NOT NULL DEFAULT '-',
  `msisdn` varchar(20) NOT NULL,
  `college` varchar(200) NOT NULL DEFAULT '-',
  `type` varchar(50) NOT NULL DEFAULT 'college',
  `sendMsg` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=366 ;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `mobile` varchar(12) NOT NULL,
  `mstatus` tinyint(1) NOT NULL,
  `id` varchar(32) NOT NULL,
  PRIMARY KEY (`mobile`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `story_epd`
--

CREATE TABLE IF NOT EXISTS `story_epd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `episodes` int(11) NOT NULL,
  `titles` varchar(250) NOT NULL,
  `story` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `teamipl`
--

CREATE TABLE IF NOT EXISTS `teamipl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msisdn` varchar(50) NOT NULL,
  `team` varchar(20) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `msisdn` (`msisdn`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1375 ;

-- --------------------------------------------------------

--
-- Table structure for table `ted_talks`
--

CREATE TABLE IF NOT EXISTS `ted_talks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `speaker` varchar(255) NOT NULL,
  `video_url` varchar(255) NOT NULL,
  `video_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1509 ;

-- --------------------------------------------------------

--
-- Table structure for table `thailand_station`
--

CREATE TABLE IF NOT EXISTS `thailand_station` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `station` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=681 ;

-- --------------------------------------------------------

--
-- Table structure for table `themeMain`
--

CREATE TABLE IF NOT EXISTS `themeMain` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(100) NOT NULL,
  `uname` varchar(50) NOT NULL,
  `groupName` varchar(50) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uname` (`uname`,`number`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=938 ;

-- --------------------------------------------------------

--
-- Table structure for table `themeMsg`
--

CREATE TABLE IF NOT EXISTS `themeMsg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(100) NOT NULL,
  `uname` varchar(50) NOT NULL,
  `msg` varchar(500) NOT NULL,
  `groupName` varchar(20) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50299 ;

-- --------------------------------------------------------

--
-- Table structure for table `tipsntricks`
--

CREATE TABLE IF NOT EXISTS `tipsntricks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `trick` varchar(255) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `trick` (`trick`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1261 ;

-- --------------------------------------------------------

--
-- Table structure for table `tips_content`
--

CREATE TABLE IF NOT EXISTS `tips_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(500) NOT NULL,
  `language` varchar(100) NOT NULL,
  `subtype` varchar(500) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=406 ;

-- --------------------------------------------------------

--
-- Table structure for table `tips_keys`
--

CREATE TABLE IF NOT EXISTS `tips_keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `types` varchar(100) NOT NULL,
  `keywords` varchar(500) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `types` (`types`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

-- --------------------------------------------------------

--
-- Table structure for table `tn_colleges`
--

CREATE TABLE IF NOT EXISTS `tn_colleges` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `courses` text NOT NULL,
  `university` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1685 ;

-- --------------------------------------------------------

--
-- Table structure for table `truecaller`
--

CREATE TABLE IF NOT EXISTS `truecaller` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `score` varchar(20) NOT NULL,
  `ccode` int(11) NOT NULL DEFAULT '91',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `number` (`number`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=251385 ;

-- --------------------------------------------------------

--
-- Table structure for table `twitter`
--

CREATE TABLE IF NOT EXISTS `twitter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mobileNo` varchar(50) NOT NULL,
  `gcmid` varchar(500) NOT NULL DEFAULT 'NULL',
  `mobileSerial` varchar(50) NOT NULL,
  `accessToken` varchar(100) NOT NULL,
  `accessSecret` varchar(100) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mobileSerial` (`mobileSerial`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Table structure for table `vegprice`
--

CREATE TABLE IF NOT EXISTS `vegprice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(200) NOT NULL,
  `vegname` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `vegname` (`vegname`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1045 ;

-- --------------------------------------------------------

--
-- Table structure for table `vote`
--

CREATE TABLE IF NOT EXISTS `vote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ques` varchar(500) NOT NULL,
  `opt1` varchar(50) NOT NULL,
  `opt2` varchar(50) NOT NULL,
  `opt3` varchar(50) NOT NULL,
  `opt4` varchar(50) NOT NULL,
  `count` varchar(1000) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `wapCode`
--

CREATE TABLE IF NOT EXISTS `wapCode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msisdn` varchar(20) NOT NULL,
  `code` varchar(10) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=822 ;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE IF NOT EXISTS `wishlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(50) NOT NULL,
  `operator` varchar(20) NOT NULL,
  `circle` varchar(20) NOT NULL,
  `item` varchar(500) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `number` (`number`,`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8457 ;

-- --------------------------------------------------------

--
-- Table structure for table `womlaw`
--

CREATE TABLE IF NOT EXISTS `womlaw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menuname` varchar(200) NOT NULL,
  `source` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

-- --------------------------------------------------------

--
-- Table structure for table `zorkgame`
--

CREATE TABLE IF NOT EXISTS `zorkgame` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mhash` varchar(100) NOT NULL,
  `cookie` varchar(20) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mhash` (`mhash`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=469 ;
