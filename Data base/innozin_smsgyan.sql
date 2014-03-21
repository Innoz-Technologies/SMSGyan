-- phpMyAdmin SQL Dump
-- version 3.3.2deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 21, 2014 at 02:16 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.2-1ubuntu4.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `innozin_smsgyan`
--

-- --------------------------------------------------------

--
-- Table structure for table `abd`
--

CREATE TABLE IF NOT EXISTS `abd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(50) NOT NULL,
  `operator` varchar(50) NOT NULL,
  `circle` varchar(50) NOT NULL,
  `code` varchar(10) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2907 ;

-- --------------------------------------------------------

--
-- Table structure for table `about_india`
--

CREATE TABLE IF NOT EXISTS `about_india` (
  `post` varchar(100) NOT NULL,
  `andra` varchar(100) NOT NULL,
  `arunachal` varchar(100) NOT NULL,
  `Assam` varchar(100) NOT NULL,
  `Bihar` varchar(100) NOT NULL,
  `Chhattisgarh` varchar(100) NOT NULL,
  `Goa` varchar(100) NOT NULL,
  `Gujarat` varchar(100) NOT NULL,
  `Haryana` varchar(100) NOT NULL,
  `Himachal` varchar(100) NOT NULL,
  `Jammu` varchar(100) NOT NULL,
  `Jharkhand` varchar(100) NOT NULL,
  `Karnataka` varchar(100) NOT NULL,
  `Kerala` varchar(100) NOT NULL,
  `Madya` varchar(100) NOT NULL,
  `Maharashtra` varchar(100) NOT NULL,
  `Manipur` varchar(100) NOT NULL,
  `Meghalaya` varchar(100) NOT NULL,
  `Mizoram` varchar(100) NOT NULL,
  `Nagaland` varchar(100) NOT NULL,
  `Orissa` varchar(100) NOT NULL,
  `Punjab` varchar(100) NOT NULL,
  `Rajasthan` varchar(100) NOT NULL,
  `Sikkim` varchar(100) NOT NULL,
  `Tamil` varchar(100) NOT NULL,
  `Tripura` varchar(100) NOT NULL,
  `Uttaranchal` varchar(100) NOT NULL,
  `Uttar` varchar(100) NOT NULL,
  `Bengal` varchar(100) NOT NULL,
  `Andaman` varchar(100) NOT NULL,
  `Chandigarh` varchar(100) NOT NULL,
  `Dadar` varchar(100) NOT NULL,
  `Daman` varchar(100) NOT NULL,
  `Delhi` varchar(100) NOT NULL,
  `Lakshadeep` varchar(100) NOT NULL,
  `Pondicherry` varchar(100) NOT NULL,
  PRIMARY KEY (`post`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `adult_content`
--

CREATE TABLE IF NOT EXISTS `adult_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(2000) NOT NULL,
  `langauage` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `title` (`title`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=113 ;

-- --------------------------------------------------------

--
-- Table structure for table `ad_howto`
--

CREATE TABLE IF NOT EXISTS `ad_howto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `script` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=101 ;

-- --------------------------------------------------------

--
-- Table structure for table `ad_scripts`
--

CREATE TABLE IF NOT EXISTS `ad_scripts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `script` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

-- --------------------------------------------------------

--
-- Table structure for table `ad_scripts_dialog`
--

CREATE TABLE IF NOT EXISTS `ad_scripts_dialog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `script` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Table structure for table `ad_scripts_pak`
--

CREATE TABLE IF NOT EXISTS `ad_scripts_pak` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `script` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

-- --------------------------------------------------------

--
-- Table structure for table `aircel_promoter`
--

CREATE TABLE IF NOT EXISTS `aircel_promoter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_msisdn` varchar(15) NOT NULL,
  `keyword` varchar(15) NOT NULL,
  `msisdn` varchar(15) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `from_msisdn` (`from_msisdn`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=84 ;

-- --------------------------------------------------------

--
-- Table structure for table `airports_ixigo`
--

CREATE TABLE IF NOT EXISTS `airports_ixigo` (
  `StationName` varchar(40) NOT NULL,
  `CodeName` varchar(10) NOT NULL,
  `Country` varchar(30) NOT NULL,
  KEY `StationName` (`StationName`,`CodeName`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `airtel_atn`
--

CREATE TABLE IF NOT EXISTS `airtel_atn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msisdn` varchar(15) NOT NULL,
  `status` varchar(200) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `timestamp` (`timestamp`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7691 ;

-- --------------------------------------------------------

--
-- Table structure for table `appcorrect_log`
--

CREATE TABLE IF NOT EXISTS `appcorrect_log` (
  `query_id` varchar(40) NOT NULL,
  `errorresponse` varchar(8000) NOT NULL,
  `errortime` varchar(20) NOT NULL DEFAULT '2000-01-01 00:00:00',
  `response` varchar(8000) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `remarks` varchar(2000) NOT NULL,
  UNIQUE KEY `query_id` (`query_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `apperror_log`
--

CREATE TABLE IF NOT EXISTS `apperror_log` (
  `query_id` varchar(40) NOT NULL,
  `response` varchar(8000) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `query_id` (`query_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `appsRevenue`
--

CREATE TABLE IF NOT EXISTS `appsRevenue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msisdn` varchar(20) NOT NULL,
  `apps_id` int(11) NOT NULL,
  `apps_name` varchar(100) NOT NULL,
  `apps_date` date NOT NULL,
  `apps_bill` tinyint(4) NOT NULL,
  `operator` varchar(20) NOT NULL,
  `circle` varchar(10) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=306475 ;

-- --------------------------------------------------------

--
-- Table structure for table `appStoreBill`
--

CREATE TABLE IF NOT EXISTS `appStoreBill` (
  `msisdn` varchar(10) NOT NULL,
  `circle` varchar(20) DEFAULT NULL,
  `operator` varchar(50) DEFAULT NULL,
  `billDate` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`msisdn`,`billDate`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_andriod`
--

CREATE TABLE IF NOT EXISTS `app_andriod` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `shortdesc` varchar(500) NOT NULL,
  `desc` text NOT NULL,
  `format` varchar(500) NOT NULL,
  `eg` varchar(200) NOT NULL DEFAULT 'NULL',
  `direct` tinyint(4) NOT NULL DEFAULT '2',
  `default` tinyint(4) NOT NULL DEFAULT '2',
  `imgUrl` varchar(500) NOT NULL,
  `brownie_icon_url` varchar(500) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_andriod_airtel`
--

CREATE TABLE IF NOT EXISTS `app_andriod_airtel` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `shortdesc` varchar(500) NOT NULL,
  `desc` text NOT NULL,
  `format` varchar(500) NOT NULL,
  `eg` varchar(200) NOT NULL DEFAULT 'NULL',
  `direct` tinyint(4) NOT NULL DEFAULT '2',
  `default` tinyint(4) NOT NULL DEFAULT '2',
  `imgUrl` varchar(500) NOT NULL,
  `brownie_icon_url` varchar(500) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_keyword`
--

CREATE TABLE IF NOT EXISTS `app_keyword` (
  `id` int(11) NOT NULL,
  `app_key` varchar(50) NOT NULL,
  `msisdn` varchar(10) NOT NULL,
  `keyword` varchar(30) NOT NULL,
  `category` varchar(50) NOT NULL,
  `status` smallint(6) NOT NULL,
  `type` varchar(10) NOT NULL,
  `api` varchar(500) NOT NULL,
  `response` text NOT NULL,
  `is_paid` tinyint(4) NOT NULL DEFAULT '1',
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `script` varchar(100) DEFAULT NULL,
  `isPromo` tinyint(4) NOT NULL DEFAULT '1',
  `priority` tinyint(4) NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`),
  KEY `keyword` (`keyword`,`status`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `AP_new`
--

CREATE TABLE IF NOT EXISTS `AP_new` (
  `msisdn` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ap_smi_count_query_days`
--

CREATE TABLE IF NOT EXISTS `ap_smi_count_query_days` (
  `msisdn` varchar(10) DEFAULT NULL,
  `count` varchar(100) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ap_smi_que`
--

CREATE TABLE IF NOT EXISTS `ap_smi_que` (
  `msisdn` varchar(100) DEFAULT NULL,
  `query` varchar(400) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(2) NOT NULL,
  `title` varchar(256) NOT NULL,
  `alt_title` varchar(256) NOT NULL,
  `media` text NOT NULL,
  `infobox` text NOT NULL,
  `type` varchar(100) NOT NULL,
  `disambiguation` varchar(256) NOT NULL,
  `image_id` int(11) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  KEY `alt_title` (`alt_title`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5201124 ;

-- --------------------------------------------------------

--
-- Table structure for table `bestApp`
--

CREATE TABLE IF NOT EXISTS `bestApp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appID` int(11) NOT NULL,
  `appName` varchar(50) NOT NULL,
  `subheading` varchar(5000) NOT NULL,
  `keyworddesc` varchar(500) NOT NULL,
  `appactionphrase` varchar(500) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `date` (`date`),
  KEY `appName` (`appName`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `bid_borrowers`
--

CREATE TABLE IF NOT EXISTS `bid_borrowers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(20) NOT NULL,
  `circle` varchar(10) NOT NULL,
  `operator` varchar(20) NOT NULL,
  `bidNumID` int(11) NOT NULL,
  `amount` double NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `bid_numbers`
--

CREATE TABLE IF NOT EXISTS `bid_numbers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(15) NOT NULL,
  `circle` varchar(10) NOT NULL,
  `operator` varchar(20) NOT NULL DEFAULT 'idea',
  `type` varchar(50) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `bikecar_UAE`
--

CREATE TABLE IF NOT EXISTS `bikecar_UAE` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `make_id` int(11) NOT NULL,
  `make` varchar(500) NOT NULL,
  `model` varchar(500) NOT NULL,
  `mvalue` varchar(500) NOT NULL,
  `srch` varchar(500) NOT NULL,
  `vtype` varchar(100) NOT NULL,
  `search` varchar(500) NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `srch` (`srch`),
  FULLTEXT KEY `search` (`search`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=710 ;

-- --------------------------------------------------------

--
-- Table structure for table `bikedekho`
--

CREATE TABLE IF NOT EXISTS `bikedekho` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `make_id` varchar(50) NOT NULL,
  `model_id` varchar(200) NOT NULL,
  `make` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `srch` varchar(50) NOT NULL,
  `category` varchar(10) NOT NULL DEFAULT 'bike',
  PRIMARY KEY (`id`),
  UNIQUE KEY `model_id` (`model_id`),
  FULLTEXT KEY `model` (`model`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=226 ;

-- --------------------------------------------------------

--
-- Table structure for table `billNumber`
--

CREATE TABLE IF NOT EXISTS `billNumber` (
  `msisdn` varchar(20) NOT NULL,
  `isBill` tinyint(4) NOT NULL,
  `billDate` date NOT NULL,
  PRIMARY KEY (`msisdn`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `billNumber1`
--

CREATE TABLE IF NOT EXISTS `billNumber1` (
  `msisdn` varchar(20) NOT NULL,
  `isBill` tinyint(4) NOT NULL,
  `billDate` date NOT NULL,
  PRIMARY KEY (`msisdn`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bing_api_urls`
--

CREATE TABLE IF NOT EXISTS `bing_api_urls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(500) NOT NULL,
  `url_full` varchar(500) NOT NULL DEFAULT '0',
  `query_in` varchar(500) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=235190 ;

-- --------------------------------------------------------

--
-- Table structure for table `blockNumbers`
--

CREATE TABLE IF NOT EXISTS `blockNumbers` (
  `msisdn` varchar(20) NOT NULL,
  `circle` varchar(10) NOT NULL,
  `operator` varchar(20) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`msisdn`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bus_routes_ap`
--

CREATE TABLE IF NOT EXISTS `bus_routes_ap` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `route` varchar(100) NOT NULL,
  `source` varchar(400) NOT NULL,
  `dest` varchar(400) NOT NULL,
  `via` text NOT NULL,
  `bustype` varchar(50) NOT NULL,
  `s_srch` varchar(200) NOT NULL,
  `d_srch` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `route` (`route`,`source`,`dest`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1090 ;

-- --------------------------------------------------------

--
-- Table structure for table `bus_routes_ap_new`
--

CREATE TABLE IF NOT EXISTS `bus_routes_ap_new` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `route` varchar(100) NOT NULL,
  `routeid` varchar(50) NOT NULL,
  `circle` varchar(10) NOT NULL,
  `city` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Route_City` (`route`,`city`),
  FULLTEXT KEY `route` (`route`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7145 ;

-- --------------------------------------------------------

--
-- Table structure for table `bus_routes_nepal`
--

CREATE TABLE IF NOT EXISTS `bus_routes_nepal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source` varchar(100) NOT NULL,
  `dest` varchar(100) NOT NULL,
  `response` varchar(500) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `source` (`source`,`dest`,`response`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Table structure for table `bus_route_response`
--

CREATE TABLE IF NOT EXISTS `bus_route_response` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source` varchar(200) NOT NULL,
  `dest` varchar(200) NOT NULL,
  `route` varchar(50) NOT NULL DEFAULT '',
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `response` text NOT NULL,
  `circle` varchar(50) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `source` (`source`,`dest`,`circle`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1456 ;

-- --------------------------------------------------------

--
-- Table structure for table `bus_stops_ap`
--

CREATE TABLE IF NOT EXISTS `bus_stops_ap` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bus_stop` varchar(100) NOT NULL,
  `srch` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `srch_2` (`srch`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1125 ;

-- --------------------------------------------------------

--
-- Table structure for table `bus_stops_ap_new`
--

CREATE TABLE IF NOT EXISTS `bus_stops_ap_new` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bus_stop` varchar(500) NOT NULL,
  `search_key` varchar(400) NOT NULL,
  `keyid` varchar(50) NOT NULL,
  `city` varchar(10) NOT NULL,
  `circle` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bus_stop` (`bus_stop`,`keyid`,`city`),
  FULLTEXT KEY `bus_stop_2` (`bus_stop`,`search_key`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19899 ;

-- --------------------------------------------------------

--
-- Table structure for table `bus_stops_ap_new_bkup_new`
--

CREATE TABLE IF NOT EXISTS `bus_stops_ap_new_bkup_new` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bus_stop` varchar(500) NOT NULL,
  `search_key` varchar(400) NOT NULL,
  `keyid` varchar(50) NOT NULL,
  `city` varchar(10) NOT NULL,
  `circle` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bus_stop` (`bus_stop`,`keyid`,`city`),
  FULLTEXT KEY `bus_stop_2` (`bus_stop`,`search_key`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13959 ;

-- --------------------------------------------------------

--
-- Table structure for table `bus_stops_ap_t`
--

CREATE TABLE IF NOT EXISTS `bus_stops_ap_t` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bus_stop` varchar(100) NOT NULL,
  `srch` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dup_check` (`bus_stop`,`srch`),
  KEY `srch` (`srch`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=888 ;

-- --------------------------------------------------------

--
-- Table structure for table `bus_stops_blr`
--

CREATE TABLE IF NOT EXISTS `bus_stops_blr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `place` varchar(150) NOT NULL,
  `srch` varchar(450) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `srch` (`srch`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6734 ;

-- --------------------------------------------------------

--
-- Table structure for table `bus_stops_mumbai`
--

CREATE TABLE IF NOT EXISTS `bus_stops_mumbai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bus_stop` varchar(100) NOT NULL,
  `srch` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `srch` (`srch`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2388 ;

-- --------------------------------------------------------

--
-- Table structure for table `buysell`
--

CREATE TABLE IF NOT EXISTS `buysell` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msisdn` varchar(20) NOT NULL,
  `circle` varchar(20) NOT NULL,
  `city` varchar(100) NOT NULL,
  `item` varchar(500) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `circle` (`circle`),
  FULLTEXT KEY `item` (`item`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=312 ;

-- --------------------------------------------------------

--
-- Table structure for table `bvrg`
--

CREATE TABLE IF NOT EXISTS `bvrg` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `srch` varchar(30) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  FULLTEXT KEY `srch` (`srch`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3857 ;

-- --------------------------------------------------------

--
-- Table structure for table `canned_responses`
--

CREATE TABLE IF NOT EXISTS `canned_responses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `image_id` bigint(20) NOT NULL DEFAULT '0',
  `photo_word` varchar(50) NOT NULL,
  `source` varchar(20) NOT NULL DEFAULT 'canned',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1705 ;

-- --------------------------------------------------------

--
-- Table structure for table `carwale`
--

CREATE TABLE IF NOT EXISTS `carwale` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `make_id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `make` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `srch` varchar(100) NOT NULL,
  `category` varchar(10) NOT NULL DEFAULT 'car',
  PRIMARY KEY (`id`),
  UNIQUE KEY `model_id` (`model_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=208 ;

-- --------------------------------------------------------

--
-- Table structure for table `celebrity`
--

CREATE TABLE IF NOT EXISTS `celebrity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `bio` text NOT NULL,
  `movies` text NOT NULL,
  `tweet` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Table structure for table `chapter`
--

CREATE TABLE IF NOT EXISTS `chapter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL,
  `cname` varchar(200) NOT NULL,
  `sid1` int(11) NOT NULL,
  `subid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1412 ;

-- --------------------------------------------------------

--
-- Table structure for table `check_query`
--

CREATE TABLE IF NOT EXISTS `check_query` (
  `msisdn` varchar(10) NOT NULL,
  `circle` varchar(4) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `time` (`time`),
  KEY `msisdn` (`msisdn`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1239689 ;

-- --------------------------------------------------------

--
-- Table structure for table `chickpedia`
--

CREATE TABLE IF NOT EXISTS `chickpedia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `about` varchar(1000) NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5460 ;

-- --------------------------------------------------------

--
-- Table structure for table `circle_profile`
--

CREATE TABLE IF NOT EXISTS `circle_profile` (
  `circle` varchar(10) NOT NULL,
  `word` varchar(20) NOT NULL,
  `count` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `circle` (`circle`,`word`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `citylist`
--

CREATE TABLE IF NOT EXISTS `citylist` (
  `city_id` int(5) NOT NULL,
  `city_name` varchar(50) NOT NULL,
  `latitude` varchar(10) NOT NULL,
  `longitude` varchar(10) NOT NULL,
  `state` varchar(50) NOT NULL,
  PRIMARY KEY (`city_id`),
  KEY `city_name` (`city_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `city_circle`
--

CREATE TABLE IF NOT EXISTS `city_circle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(200) NOT NULL,
  `circle` varchar(50) NOT NULL,
  `state` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=528 ;

-- --------------------------------------------------------

--
-- Table structure for table `clt20`
--

CREATE TABLE IF NOT EXISTS `clt20` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `time` varchar(100) NOT NULL,
  `team1` varchar(200) NOT NULL,
  `team2` varchar(200) NOT NULL,
  `venue` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

-- --------------------------------------------------------

--
-- Table structure for table `clt20_team`
--

CREATE TABLE IF NOT EXISTS `clt20_team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team` varchar(500) NOT NULL,
  `member` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `collegeap`
--

CREATE TABLE IF NOT EXISTS `collegeap` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `collegeName` varchar(200) NOT NULL,
  `collegeCode` varchar(50) NOT NULL,
  `collegeDetails` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `collegeName` (`collegeName`,`collegeCode`),
  FULLTEXT KEY `collegeName_2` (`collegeName`),
  FULLTEXT KEY `collegeCode` (`collegeCode`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=707 ;

-- --------------------------------------------------------

--
-- Table structure for table `colleges`
--

CREATE TABLE IF NOT EXISTS `colleges` (
  `college_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  `address` text NOT NULL,
  `course` text NOT NULL,
  `university` text NOT NULL,
  `city` text NOT NULL,
  `cor` text NOT NULL,
  `state` text NOT NULL,
  PRIMARY KEY (`name`),
  UNIQUE KEY `college_id` (`college_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `college_ap`
--

CREATE TABLE IF NOT EXISTS `college_ap` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `colgName` varchar(100) NOT NULL,
  `colgDet` text NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `colgName` (`colgName`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=228 ;

-- --------------------------------------------------------

--
-- Table structure for table `constituency`
--

CREATE TABLE IF NOT EXISTS `constituency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cons` varchar(200) NOT NULL,
  `cid` int(11) NOT NULL,
  `state` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=250 ;

-- --------------------------------------------------------

--
-- Table structure for table `correct_log`
--

CREATE TABLE IF NOT EXISTS `correct_log` (
  `query_id` varchar(40) NOT NULL,
  `errorresponse` varchar(8000) NOT NULL,
  `errortime` varchar(20) NOT NULL DEFAULT '2000-01-01 00:00:00',
  `response` varchar(8000) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `remarks` varchar(2000) NOT NULL,
  UNIQUE KEY `query_id` (`query_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cp`
--

CREATE TABLE IF NOT EXISTS `cp` (
  `msisdn` varchar(12) NOT NULL,
  UNIQUE KEY `msisdn` (`msisdn`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cricinfo`
--

CREATE TABLE IF NOT EXISTS `cricinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `playerid` int(11) NOT NULL,
  `countryid` int(11) NOT NULL,
  `profile` text NOT NULL,
  `time` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `playerid` (`playerid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=850 ;

-- --------------------------------------------------------

--
-- Table structure for table `crivotes`
--

CREATE TABLE IF NOT EXISTS `crivotes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `a_count` int(11) NOT NULL,
  `a_ans` varchar(100) NOT NULL,
  `b_count` int(11) NOT NULL,
  `b_ans` varchar(100) NOT NULL,
  `c_count` int(11) NOT NULL,
  `c_ans` varchar(100) NOT NULL,
  `c_enable` int(11) NOT NULL,
  `d_count` int(11) NOT NULL,
  `d_ans` varchar(100) NOT NULL,
  `d_enable` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `cri_billing`
--

CREATE TABLE IF NOT EXISTS `cri_billing` (
  `msisdn` varchar(20) NOT NULL,
  `isBill` int(11) NOT NULL,
  `billDate` date NOT NULL,
  PRIMARY KEY (`msisdn`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cri_billKTN`
--

CREATE TABLE IF NOT EXISTS `cri_billKTN` (
  `msisdn` varchar(10) NOT NULL,
  `isBill` tinyint(4) NOT NULL,
  `billDate` date NOT NULL,
  PRIMARY KEY (`msisdn`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cri_rank`
--

CREATE TABLE IF NOT EXISTS `cri_rank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `data` varchar(1000) NOT NULL,
  `dated` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type` (`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2299 ;

-- --------------------------------------------------------

--
-- Table structure for table `cri_records`
--

CREATE TABLE IF NOT EXISTS `cri_records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `record_type` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `cri_type` varchar(20) NOT NULL,
  `data` text NOT NULL,
  `fetched_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `record_type` (`record_type`,`country_id`,`cri_type`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17307 ;

-- --------------------------------------------------------

--
-- Table structure for table `cri_sch`
--

CREATE TABLE IF NOT EXISTS `cri_sch` (
  `id` tinyint(4) NOT NULL,
  `sch` text NOT NULL,
  `dated` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dated` (`dated`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cri_team_bbc`
--

CREATE TABLE IF NOT EXISTS `cri_team_bbc` (
  `id` int(11) NOT NULL,
  `captain` text NOT NULL,
  `keeper` text NOT NULL,
  `fetched_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cri_team_yahoo`
--

CREATE TABLE IF NOT EXISTS `cri_team_yahoo` (
  `country` varchar(50) NOT NULL,
  `captain` varchar(50) NOT NULL,
  `coach` varchar(50) NOT NULL,
  `fetched_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`country`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE IF NOT EXISTS `currency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cur_val` varchar(50) NOT NULL,
  `cur_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cur_name` (`cur_name`),
  FULLTEXT KEY `cur_val` (`cur_val`,`cur_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=631 ;

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE IF NOT EXISTS `data` (
  `global_id` int(11) NOT NULL AUTO_INCREMENT,
  `query` varchar(160) NOT NULL,
  `tags` text NOT NULL,
  `ask_or_wiki` varchar(4) NOT NULL DEFAULT 'wiki',
  `related` varchar(200) NOT NULL,
  `has_weather` varchar(50) NOT NULL,
  `has_stocks` tinyint(1) NOT NULL,
  `movie` varchar(200) NOT NULL,
  `machine_id` tinyint(4) NOT NULL,
  `image_id` varchar(20) NOT NULL,
  PRIMARY KEY (`global_id`),
  UNIQUE KEY `query` (`query`),
  KEY `movie` (`movie`),
  KEY `related` (`related`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19618790 ;

-- --------------------------------------------------------

--
-- Table structure for table `data_acry`
--

CREATE TABLE IF NOT EXISTS `data_acry` (
  `query` varchar(500) NOT NULL,
  `ans` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`query`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `data_ans`
--

CREATE TABLE IF NOT EXISTS `data_ans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `ans` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8690 ;

-- --------------------------------------------------------

--
-- Table structure for table `data_dict`
--

CREATE TABLE IF NOT EXISTS `data_dict` (
  `query` varchar(500) NOT NULL,
  `ans` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`query`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `data_ehow`
--

CREATE TABLE IF NOT EXISTS `data_ehow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `ans` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=95279 ;

-- --------------------------------------------------------

--
-- Table structure for table `data_how`
--

CREATE TABLE IF NOT EXISTS `data_how` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `machine` smallint(6) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19878 ;

-- --------------------------------------------------------

--
-- Table structure for table `data_iforum`
--

CREATE TABLE IF NOT EXISTS `data_iforum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `ans` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=788 ;

-- --------------------------------------------------------

--
-- Table structure for table `data_image`
--

CREATE TABLE IF NOT EXISTS `data_image` (
  `query` varchar(500) NOT NULL,
  `image_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`query`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `data_imdb`
--

CREATE TABLE IF NOT EXISTS `data_imdb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `ans` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41315 ;

-- --------------------------------------------------------

--
-- Table structure for table `data_linked`
--

CREATE TABLE IF NOT EXISTS `data_linked` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `ans` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6833 ;

-- --------------------------------------------------------

--
-- Table structure for table `data_local`
--

CREATE TABLE IF NOT EXISTS `data_local` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `what` varchar(200) NOT NULL,
  `where` varchar(200) NOT NULL,
  `ans` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`what`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7621 ;

-- --------------------------------------------------------

--
-- Table structure for table `data_movie`
--

CREATE TABLE IF NOT EXISTS `data_movie` (
  `query` varchar(500) NOT NULL,
  `ans` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`query`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `data_new`
--

CREATE TABLE IF NOT EXISTS `data_new` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `query` varchar(100) NOT NULL,
  `source` varchar(20) NOT NULL,
  `source_id` int(11) NOT NULL,
  `suggestion` varchar(2000) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `query` (`query`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2349965 ;

-- --------------------------------------------------------

--
-- Table structure for table `data_new1`
--

CREATE TABLE IF NOT EXISTS `data_new1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `query` varchar(100) NOT NULL,
  `source` varchar(20) NOT NULL,
  `source_id` int(11) NOT NULL,
  `suggestion` varchar(2000) NOT NULL,
  `history` varchar(200) NOT NULL,
  `confidence` float NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `query` (`query`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1116790 ;

-- --------------------------------------------------------

--
-- Table structure for table `data_wans`
--

CREATE TABLE IF NOT EXISTS `data_wans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `ans` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=164571 ;

-- --------------------------------------------------------

--
-- Table structure for table `diffquestions`
--

CREATE TABLE IF NOT EXISTS `diffquestions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(500) NOT NULL,
  `url` varchar(500) NOT NULL,
  `response` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `question` (`question`,`url`),
  FULLTEXT KEY `question_2` (`question`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7116 ;

-- --------------------------------------------------------

--
-- Table structure for table `docomobill`
--

CREATE TABLE IF NOT EXISTS `docomobill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msisdn` varchar(20) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `dated` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `msisdn` (`msisdn`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40951 ;

-- --------------------------------------------------------

--
-- Table structure for table `duckduck_count`
--

CREATE TABLE IF NOT EXISTS `duckduck_count` (
  `id` smallint(6) NOT NULL,
  `cnt` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `educart`
--

CREATE TABLE IF NOT EXISTS `educart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msisdn` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `course` varchar(100) NOT NULL,
  `emailid` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `msisdn` (`msisdn`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3725 ;

-- --------------------------------------------------------

--
-- Table structure for table `election`
--

CREATE TABLE IF NOT EXISTS `election` (
  `state` varchar(100) NOT NULL,
  `district` varchar(100) NOT NULL,
  `constituency` text NOT NULL,
  `candidate` text NOT NULL,
  `result` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `election2`
--

CREATE TABLE IF NOT EXISTS `election2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state` varchar(100) NOT NULL,
  `con` varchar(100) NOT NULL,
  `constituency` varchar(100) NOT NULL,
  `result` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `con` (`con`),
  KEY `constituency` (`constituency`),
  KEY `state` (`state`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=225 ;

-- --------------------------------------------------------

--
-- Table structure for table `electionresult`
--

CREATE TABLE IF NOT EXISTS `electionresult` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state` varchar(200) NOT NULL,
  `data` varchar(10000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `election_dec_12`
--

CREATE TABLE IF NOT EXISTS `election_dec_12` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state` varchar(50) NOT NULL,
  `party` varchar(50) NOT NULL,
  `lead` varchar(20) NOT NULL,
  `win` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `state` (`state`,`party`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10800 ;

-- --------------------------------------------------------

--
-- Table structure for table `election_gj`
--

CREATE TABLE IF NOT EXISTS `election_gj` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candate` varchar(200) NOT NULL,
  `place` varchar(200) NOT NULL,
  `place_org` varchar(200) NOT NULL,
  `party` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=502 ;

-- --------------------------------------------------------

--
-- Table structure for table `election_ka`
--

CREATE TABLE IF NOT EXISTS `election_ka` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate` varchar(200) NOT NULL,
  `place_org` varchar(200) NOT NULL,
  `place` varchar(200) NOT NULL,
  `party` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=780 ;

-- --------------------------------------------------------

--
-- Table structure for table `election_plc`
--

CREATE TABLE IF NOT EXISTS `election_plc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typed` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `place` varchar(100) NOT NULL,
  `state1` varchar(100) NOT NULL,
  `data` varchar(10000) NOT NULL,
  `result` varchar(10000) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `typed` (`typed`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1084 ;

-- --------------------------------------------------------

--
-- Table structure for table `epl_fixture`
--

CREATE TABLE IF NOT EXISTS `epl_fixture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `match_date` date NOT NULL,
  `match_time` varchar(10) NOT NULL,
  `home_team` varchar(40) NOT NULL,
  `away_team` varchar(40) NOT NULL,
  `venue` varchar(50) NOT NULL,
  `home_goal` varchar(2) NOT NULL,
  `away_goal` varchar(2) NOT NULL,
  `details` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Home` (`home_team`),
  KEY `Away` (`away_team`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=564 ;

-- --------------------------------------------------------

--
-- Table structure for table `epl_team`
--

CREATE TABLE IF NOT EXISTS `epl_team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shortname` varchar(5) NOT NULL,
  `srch` varchar(50) NOT NULL,
  `team` varchar(30) NOT NULL,
  `played` int(11) NOT NULL,
  `won` int(11) NOT NULL,
  `drawn` int(11) NOT NULL,
  `lost` int(11) NOT NULL,
  `goal_for` int(11) NOT NULL,
  `goal_against` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `srch` (`srch`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

-- --------------------------------------------------------

--
-- Table structure for table `error_log`
--

CREATE TABLE IF NOT EXISTS `error_log` (
  `query_id` varchar(40) NOT NULL,
  `response` varchar(8000) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `query_id` (`query_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `event_log`
--

CREATE TABLE IF NOT EXISTS `event_log` (
  `msisdn` varchar(15) NOT NULL,
  `query` varchar(50) NOT NULL,
  `responce` varchar(200) NOT NULL,
  `billingtime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `amount` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fifa_cup2013`
--

CREATE TABLE IF NOT EXISTS `fifa_cup2013` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `match_date` date DEFAULT NULL,
  `match_time` varchar(10) DEFAULT NULL,
  `team1` varchar(50) DEFAULT NULL,
  `team2` varchar(50) DEFAULT NULL,
  `venue` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `fine_du`
--

CREATE TABLE IF NOT EXISTS `fine_du` (
  `emid` varchar(25) NOT NULL,
  `emirates` varchar(25) NOT NULL,
  `catid` int(11) NOT NULL,
  `category` varchar(25) NOT NULL,
  `codeid` int(11) NOT NULL,
  `code` varchar(25) NOT NULL,
  KEY `emirates` (`emirates`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `food`
--

CREATE TABLE IF NOT EXISTS `food` (
  `fd_id` int(30) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `tag` varchar(30) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`fd_id`),
  UNIQUE KEY `name` (`name`),
  FULLTEXT KEY `tag` (`tag`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1237 ;

-- --------------------------------------------------------

--
-- Table structure for table `free_bees`
--

CREATE TABLE IF NOT EXISTS `free_bees` (
  `msisdn` varchar(12) NOT NULL,
  `circle` varchar(3) NOT NULL,
  `channel` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `msisdn` (`msisdn`),
  KEY `circle` (`circle`,`channel`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `free_bees_un`
--

CREATE TABLE IF NOT EXISTS `free_bees_un` (
  `msisdn` varchar(12) NOT NULL,
  `circle` varchar(3) NOT NULL,
  `channel` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `MSG` int(11) NOT NULL,
  `STS` int(11) NOT NULL,
  UNIQUE KEY `msisdn` (`msisdn`),
  KEY `circle` (`circle`,`channel`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `free_bees_un_all`
--

CREATE TABLE IF NOT EXISTS `free_bees_un_all` (
  `msisdn` varchar(12) NOT NULL,
  `circle` varchar(3) NOT NULL,
  `channel` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `MSG` int(11) NOT NULL,
  `STS` int(11) NOT NULL,
  UNIQUE KEY `msisdn` (`msisdn`),
  KEY `circle` (`circle`,`channel`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `game_data`
--

CREATE TABLE IF NOT EXISTS `game_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hit_time` timestamp NULL DEFAULT NULL,
  `msisdn` varchar(20) NOT NULL,
  `circle` varchar(10) NOT NULL,
  `word_id` int(11) NOT NULL,
  `first_word` varchar(50) NOT NULL,
  `clue_word` varchar(50) NOT NULL,
  `clue_count` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  `level` int(11) NOT NULL DEFAULT '1',
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `msisdn` (`msisdn`),
  KEY `hit_time` (`hit_time`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=58431 ;

-- --------------------------------------------------------

--
-- Table structure for table `game_sum`
--

CREATE TABLE IF NOT EXISTS `game_sum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `startTime` datetime NOT NULL,
  `endTime` datetime NOT NULL,
  `operator` varchar(50) NOT NULL,
  `circle` varchar(100) NOT NULL,
  `msisdn` varchar(20) NOT NULL,
  `point` double NOT NULL,
  `total_hit` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=497345 ;

-- --------------------------------------------------------

--
-- Table structure for table `game_ttt`
--

CREATE TABLE IF NOT EXISTS `game_ttt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msisdn` varchar(20) NOT NULL,
  `circle` varchar(20) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `response` varchar(500) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55382 ;

-- --------------------------------------------------------

--
-- Table structure for table `game_words`
--

CREATE TABLE IF NOT EXISTS `game_words` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `word` varchar(50) NOT NULL,
  `default` varchar(300) NOT NULL,
  `clue1` varchar(300) NOT NULL,
  `clue2` varchar(300) NOT NULL,
  `clue3` varchar(300) NOT NULL,
  `category` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `word` (`word`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=627 ;

-- --------------------------------------------------------

--
-- Table structure for table `general_how`
--

CREATE TABLE IF NOT EXISTS `general_how` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(5000) NOT NULL,
  `answer` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `question` (`question`(1000))
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `giftidea`
--

CREATE TABLE IF NOT EXISTS `giftidea` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `whom` varchar(200) NOT NULL,
  `occasion` varchar(200) NOT NULL,
  `gift` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

-- --------------------------------------------------------

--
-- Table structure for table `gyan_trail`
--

CREATE TABLE IF NOT EXISTS `gyan_trail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `numb` bigint(20) NOT NULL,
  `isused` tinyint(4) NOT NULL DEFAULT '0',
  `msisdn` varchar(12) NOT NULL,
  `circle` varchar(20) NOT NULL,
  `usetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `numb` (`numb`),
  KEY `circle` (`circle`),
  KEY `usetime` (`usetime`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000492 ;

-- --------------------------------------------------------

--
-- Table structure for table `gyan_trail10`
--

CREATE TABLE IF NOT EXISTS `gyan_trail10` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `numb` bigint(20) NOT NULL,
  `isused` tinyint(4) NOT NULL DEFAULT '0',
  `msisdn` varchar(12) NOT NULL,
  `circle` varchar(20) NOT NULL,
  `usetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `numb` (`numb`),
  KEY `circle` (`circle`),
  KEY `usetime` (`usetime`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1001568 ;

-- --------------------------------------------------------

--
-- Table structure for table `gyan_trailMP`
--

CREATE TABLE IF NOT EXISTS `gyan_trailMP` (
  `numb` bigint(20) NOT NULL,
  `isused` tinyint(4) NOT NULL DEFAULT '0',
  `msisdn` varchar(12) NOT NULL,
  `circle` varchar(20) NOT NULL,
  `usetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`numb`),
  KEY `circle` (`circle`),
  KEY `usetime` (`usetime`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hackathon`
--

CREATE TABLE IF NOT EXISTS `hackathon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(50) NOT NULL,
  `number` varchar(50) NOT NULL,
  `description` varchar(500) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `number` (`number`,`category`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=272 ;

-- --------------------------------------------------------

--
-- Table structure for table `hellotuneLog`
--

CREATE TABLE IF NOT EXISTS `hellotuneLog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `operator` varchar(100) NOT NULL,
  `songName` varchar(500) NOT NULL,
  `count` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `songName` (`songName`,`operator`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14811 ;

-- --------------------------------------------------------

--
-- Table structure for table `hellotune_spl`
--

CREATE TABLE IF NOT EXISTS `hellotune_spl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(500) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=213 ;

-- --------------------------------------------------------

--
-- Table structure for table `help_msg`
--

CREATE TABLE IF NOT EXISTS `help_msg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msg` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Table structure for table `help_operator`
--

CREATE TABLE IF NOT EXISTS `help_operator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msg_id` int(11) NOT NULL,
  `circle` varchar(20) NOT NULL,
  `operator` varchar(100) NOT NULL,
  `isFree` tinyint(4) NOT NULL DEFAULT '1',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `keywordid` int(11) NOT NULL DEFAULT '12',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=152 ;

-- --------------------------------------------------------

--
-- Table structure for table `hit_counts`
--

CREATE TABLE IF NOT EXISTS `hit_counts` (
  `A` int(5) DEFAULT NULL,
  `B` varchar(18) DEFAULT NULL,
  `C` int(4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `horoscope`
--

CREATE TABLE IF NOT EXISTS `horoscope` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sign` varchar(50) NOT NULL,
  `time` date NOT NULL,
  `details` varchar(500) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sign` (`sign`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10114 ;

-- --------------------------------------------------------

--
-- Table structure for table `horoscope_yrly`
--

CREATE TABLE IF NOT EXISTS `horoscope_yrly` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `horoscope` varchar(100) NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `how_indian`
--

CREATE TABLE IF NOT EXISTS `how_indian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `hp_candidate`
--

CREATE TABLE IF NOT EXISTS `hp_candidate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `constituencies` text NOT NULL,
  `meta` varchar(100) NOT NULL,
  `congress` varchar(100) NOT NULL,
  `bgp` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=69 ;

-- --------------------------------------------------------

--
-- Table structure for table `htlyrics`
--

CREATE TABLE IF NOT EXISTS `htlyrics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(40) NOT NULL,
  `type` varchar(20) NOT NULL,
  `movie` varchar(100) NOT NULL,
  `file` varchar(40) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tilte` (`title`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4625 ;

-- --------------------------------------------------------

--
-- Table structure for table `ifsc`
--

CREATE TABLE IF NOT EXISTS `ifsc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(500) NOT NULL,
  `ifsc_code` varchar(500) NOT NULL,
  `micr_code` varchar(500) NOT NULL,
  `branch_name` varchar(500) NOT NULL,
  `address` varchar(10000) NOT NULL,
  `contact` varchar(500) NOT NULL,
  `city` varchar(500) NOT NULL,
  `district` varchar(500) NOT NULL,
  `state` varchar(500) NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `bank_name` (`bank_name`),
  FULLTEXT KEY `branch_name` (`branch_name`,`bank_name`,`city`,`district`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=77241 ;

-- --------------------------------------------------------

--
-- Table structure for table `ifsc_bank`
--

CREATE TABLE IF NOT EXISTS `ifsc_bank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bank` varchar(500) NOT NULL,
  `srch` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=102 ;

-- --------------------------------------------------------

--
-- Table structure for table `image_ids`
--

CREATE TABLE IF NOT EXISTS `image_ids` (
  `image_id` varchar(30) NOT NULL,
  `group_id` varchar(30) NOT NULL,
  `source` varchar(30) NOT NULL,
  PRIMARY KEY (`image_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `india_det`
--

CREATE TABLE IF NOT EXISTS `india_det` (
  `post` varchar(100) NOT NULL,
  `india` varchar(100) NOT NULL,
  PRIMARY KEY (`post`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ink`
--

CREATE TABLE IF NOT EXISTS `ink` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(100) NOT NULL,
  `circle` varchar(100) NOT NULL,
  `idea` varchar(5000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

-- --------------------------------------------------------

--
-- Table structure for table `ipl`
--

CREATE TABLE IF NOT EXISTS `ipl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `match_date` date NOT NULL,
  `match_time` varchar(10) NOT NULL,
  `home_team` varchar(40) NOT NULL,
  `away_team` varchar(40) NOT NULL,
  `shrt_home_team` varchar(40) NOT NULL,
  `shrt_away_team` varchar(40) NOT NULL,
  `venue` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `match_date` (`match_date`),
  KEY `home_team` (`home_team`),
  KEY `away_team` (`away_team`),
  KEY `shrt_home_team` (`shrt_home_team`),
  KEY `shrt_away_team` (`shrt_away_team`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=77 ;

-- --------------------------------------------------------

--
-- Table structure for table `ipl_team`
--

CREATE TABLE IF NOT EXISTS `ipl_team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shortname` varchar(40) NOT NULL,
  `team` varchar(50) NOT NULL,
  `members` text NOT NULL,
  `played` int(11) NOT NULL,
  `won` int(11) NOT NULL,
  `lost` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  `net_rr` float NOT NULL,
  PRIMARY KEY (`id`),
  KEY `shortname` (`shortname`),
  KEY `team` (`team`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `ip_blocked`
--

CREATE TABLE IF NOT EXISTS `ip_blocked` (
  `ip` varchar(20) NOT NULL,
  `url` varchar(1000) NOT NULL,
  `timstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `isdcode`
--

CREATE TABLE IF NOT EXISTS `isdcode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country` varchar(50) NOT NULL,
  `isdcode` varchar(20) NOT NULL,
  `iddcode` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=251 ;

-- --------------------------------------------------------

--
-- Table structure for table `job_tips`
--

CREATE TABLE IF NOT EXISTS `job_tips` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `justdial_city`
--

CREATE TABLE IF NOT EXISTS `justdial_city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(200) NOT NULL,
  `city` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `city` (`city`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=269 ;

-- --------------------------------------------------------

--
-- Table structure for table `keywords`
--

CREATE TABLE IF NOT EXISTS `keywords` (
  `order` int(2) NOT NULL,
  `keyword` varchar(20) NOT NULL,
  `short_desc` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `operator` varchar(50) NOT NULL,
  UNIQUE KEY `keyword` (`keyword`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kmb_biennale`
--

CREATE TABLE IF NOT EXISTS `kmb_biennale` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msisdn` varchar(50) NOT NULL,
  `operator` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `Knowledge`
--

CREATE TABLE IF NOT EXISTS `Knowledge` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Type` varchar(200) NOT NULL,
  `Session` varchar(20) NOT NULL,
  `Language` varchar(100) NOT NULL,
  `Subject` varchar(200) NOT NULL,
  `Content` text NOT NULL,
  `Status` int(11) NOT NULL DEFAULT '0',
  `category` varchar(100) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1504 ;

-- --------------------------------------------------------

--
-- Table structure for table `last_exec_time`
--

CREATE TABLE IF NOT EXISTS `last_exec_time` (
  `userflag_mail` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `linkedin`
--

CREATE TABLE IF NOT EXISTS `linkedin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `query` varchar(200) NOT NULL,
  `url` varchar(500) NOT NULL,
  `isDir` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `query` (`query`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=287350 ;

-- --------------------------------------------------------

--
-- Table structure for table `linkedin_photo`
--

CREATE TABLE IF NOT EXISTS `linkedin_photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `query` varchar(200) NOT NULL,
  `imageid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `query` (`query`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8469 ;

-- --------------------------------------------------------

--
-- Table structure for table `list`
--

CREATE TABLE IF NOT EXISTS `list` (
  `msisdn` int(11) NOT NULL,
  `query_id` varchar(40) NOT NULL,
  `list` text NOT NULL,
  `opn_list` text NOT NULL,
  `opn_start` smallint(6) NOT NULL,
  `opn_length` smallint(6) NOT NULL,
  `target` varchar(200) NOT NULL,
  `position` mediumint(9) NOT NULL,
  `machine_id` varchar(10) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`msisdn`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lists`
--

CREATE TABLE IF NOT EXISTS `lists` (
  `machine_id` varchar(1) NOT NULL,
  `number` varchar(15) NOT NULL,
  `query_id` varchar(32) NOT NULL,
  `app` varchar(50) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `livecricket`
--

CREATE TABLE IF NOT EXISTS `livecricket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(100) NOT NULL,
  `cri_order` int(11) NOT NULL,
  `istest` tinyint(1) NOT NULL,
  `hit_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `score` varchar(600) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `name` varchar(200) NOT NULL,
  `match` varchar(500) NOT NULL,
  `scorecard` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `livecricket_test`
--

CREATE TABLE IF NOT EXISTS `livecricket_test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(100) NOT NULL,
  `cri_order` int(11) NOT NULL,
  `istest` tinyint(1) NOT NULL,
  `hit_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `score` varchar(600) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `name` varchar(200) NOT NULL,
  `match` varchar(500) NOT NULL,
  `scorecard` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `log_buffer`
--

CREATE TABLE IF NOT EXISTS `log_buffer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `log_data` text NOT NULL,
  `bill_fail` int(11) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=378 ;

-- --------------------------------------------------------

--
-- Table structure for table `lyrics`
--

CREATE TABLE IF NOT EXISTS `lyrics` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `movie` varchar(255) NOT NULL DEFAULT '',
  `singers` varchar(255) NOT NULL DEFAULT '',
  `language` varchar(25) NOT NULL,
  `lyrics` text NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `ft_title` (`title`),
  FULLTEXT KEY `ft_lyrics` (`lyrics`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11180 ;

-- --------------------------------------------------------

--
-- Table structure for table `lyrics_central`
--

CREATE TABLE IF NOT EXISTS `lyrics_central` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `movie` varchar(255) NOT NULL DEFAULT '',
  `singers` varchar(255) NOT NULL DEFAULT '',
  `language` varchar(25) NOT NULL,
  `lyrics` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `solrindex` (`title`,`movie`,`singers`,`language`),
  KEY `title` (`title`),
  KEY `movie` (`movie`),
  KEY `singers` (`singers`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=114719 ;

-- --------------------------------------------------------

--
-- Table structure for table `lyrics_central_test`
--

CREATE TABLE IF NOT EXISTS `lyrics_central_test` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `movie` varchar(255) NOT NULL DEFAULT '',
  `singers` varchar(255) NOT NULL DEFAULT '',
  `language` varchar(25) NOT NULL,
  `lyrics` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `movie` (`movie`),
  KEY `singers` (`singers`),
  FULLTEXT KEY `common` (`title`,`movie`,`singers`,`language`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=108891 ;

-- --------------------------------------------------------

--
-- Table structure for table `lyrics_fail`
--

CREATE TABLE IF NOT EXISTS `lyrics_fail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `query` varchar(500) NOT NULL,
  `circle` varchar(10) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `query` (`query`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=887 ;

-- --------------------------------------------------------

--
-- Table structure for table `lyrics_trend`
--

CREATE TABLE IF NOT EXISTS `lyrics_trend` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `language` varchar(50) NOT NULL,
  `lyrics_id` int(11) NOT NULL,
  `updatetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `circle` (`language`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=88 ;

-- --------------------------------------------------------

--
-- Table structure for table `masala`
--

CREATE TABLE IF NOT EXISTS `masala` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` varchar(5000) NOT NULL,
  `dated` date NOT NULL,
  `url` varchar(100) NOT NULL,
  `head` varchar(500) NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `gossip` (`head`,`data`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14672 ;

-- --------------------------------------------------------

--
-- Table structure for table `matchfixture`
--

CREATE TABLE IF NOT EXISTS `matchfixture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `match_date` date DEFAULT NULL,
  `match_time` varchar(10) DEFAULT NULL,
  `team1` varchar(50) DEFAULT NULL,
  `team2` varchar(50) DEFAULT NULL,
  `venue` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `matching_keys`
--

CREATE TABLE IF NOT EXISTS `matching_keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keyword` varchar(100) NOT NULL,
  `key_type` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4129 ;

-- --------------------------------------------------------

--
-- Table structure for table `match_horoscope`
--

CREATE TABLE IF NOT EXISTS `match_horoscope` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sign1` varchar(100) NOT NULL,
  `sign2` varchar(100) NOT NULL,
  `contents` varchar(1500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=180 ;

-- --------------------------------------------------------

--
-- Table structure for table `matrimony`
--

CREATE TABLE IF NOT EXISTS `matrimony` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(100) NOT NULL,
  `find` varchar(100) NOT NULL,
  `religion` varchar(100) NOT NULL,
  `community` varchar(100) NOT NULL,
  `caste` varchar(100) NOT NULL,
  `age` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `number` (`number`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mcard_smssub`
--

CREATE TABLE IF NOT EXISTS `mcard_smssub` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `numb` bigint(20) NOT NULL,
  `msisdn` varchar(12) NOT NULL,
  `circle` varchar(20) NOT NULL,
  `usetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `circle` (`circle`),
  KEY `usetime` (`usetime`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `mcard_sub`
--

CREATE TABLE IF NOT EXISTS `mcard_sub` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `numb` bigint(20) NOT NULL,
  `isused` tinyint(4) NOT NULL DEFAULT '0',
  `msisdn` varchar(12) NOT NULL,
  `circle` varchar(20) NOT NULL,
  `usetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `numb` (`numb`),
  KEY `circle` (`circle`),
  KEY `usetime` (`usetime`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=100092 ;

-- --------------------------------------------------------

--
-- Table structure for table `mcard_trail`
--

CREATE TABLE IF NOT EXISTS `mcard_trail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `numb` bigint(20) NOT NULL,
  `isused` tinyint(4) NOT NULL DEFAULT '0',
  `msisdn` varchar(12) NOT NULL,
  `circle` varchar(20) NOT NULL,
  `usetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `circle` (`circle`),
  KEY `usetime` (`usetime`),
  KEY `numb` (`numb`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1812277 ;

-- --------------------------------------------------------

--
-- Table structure for table `mega_user`
--

CREATE TABLE IF NOT EXISTS `mega_user` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `menu_keys`
--

CREATE TABLE IF NOT EXISTS `menu_keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mainKey` varchar(200) NOT NULL,
  `mapKeys` varchar(500) NOT NULL,
  `isAtStart` tinyint(4) NOT NULL DEFAULT '1',
  `isExact` tinyint(4) NOT NULL DEFAULT '1',
  `isDaily` tinyint(4) NOT NULL DEFAULT '0',
  `date` date NOT NULL,
  `totalReturn` text,
  `add_below` varchar(100) NOT NULL,
  `source` varchar(20) NOT NULL,
  `type` varchar(100) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=67 ;

-- --------------------------------------------------------

--
-- Table structure for table `menu_options`
--

CREATE TABLE IF NOT EXISTS `menu_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keyID` int(11) NOT NULL,
  `optionKey` varchar(200) NOT NULL,
  `optionValue` varchar(200) NOT NULL,
  `orderid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=356 ;

-- --------------------------------------------------------

--
-- Table structure for table `message_content`
--

CREATE TABLE IF NOT EXISTS `message_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(500) NOT NULL,
  `language` varchar(100) NOT NULL,
  `subtype` varchar(500) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1135 ;

-- --------------------------------------------------------

--
-- Table structure for table `message_keys`
--

CREATE TABLE IF NOT EXISTS `message_keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `types` varchar(100) NOT NULL,
  `keywords` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=60 ;

-- --------------------------------------------------------

--
-- Table structure for table `message_vodafone`
--

CREATE TABLE IF NOT EXISTS `message_vodafone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(200) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=359 ;

-- --------------------------------------------------------

--
-- Table structure for table `mhssc_push`
--

CREATE TABLE IF NOT EXISTS `mhssc_push` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msisdn` varchar(20) NOT NULL,
  `operator` varchar(50) NOT NULL,
  `circle` varchar(50) NOT NULL,
  `regno` varchar(20) NOT NULL,
  `result` varchar(500) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `msisdn` (`msisdn`,`regno`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11753 ;

-- --------------------------------------------------------

--
-- Table structure for table `mis`
--

CREATE TABLE IF NOT EXISTS `mis` (
  `circle` varchar(15) NOT NULL,
  `data` varchar(1000) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `circle` (`circle`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mobile_data`
--

CREATE TABLE IF NOT EXISTS `mobile_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `query` varchar(200) NOT NULL,
  `mobnprice` varchar(200) NOT NULL,
  `hit_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `data` varchar(500) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `query` (`query`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41130 ;

-- --------------------------------------------------------

--
-- Table structure for table `mobile_price`
--

CREATE TABLE IF NOT EXISTS `mobile_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `model` varchar(30) NOT NULL,
  `vendor` varchar(30) NOT NULL,
  `details` text NOT NULL,
  `price` varchar(25) NOT NULL,
  `tag` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_name` (`model`,`vendor`),
  FULLTEXT KEY `full_text` (`model`,`vendor`),
  FULLTEXT KEY `tag` (`tag`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6922 ;

-- --------------------------------------------------------

--
-- Table structure for table `mobprice_det`
--

CREATE TABLE IF NOT EXISTS `mobprice_det` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `query` varchar(100) NOT NULL,
  `data` varchar(600) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mobprice_list`
--

CREATE TABLE IF NOT EXISTS `mobprice_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `query` varchar(100) NOT NULL,
  `opn_list` varchar(500) NOT NULL,
  `list` varchar(1000) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `movielist`
--

CREATE TABLE IF NOT EXISTS `movielist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `movieName` varchar(200) NOT NULL,
  `movieSearch` varchar(200) NOT NULL,
  `language` varchar(50) NOT NULL,
  `year` varchar(10) NOT NULL,
  `metaMatch` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `moveindx` (`movieName`,`language`,`year`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19126 ;

-- --------------------------------------------------------

--
-- Table structure for table `movie_list`
--

CREATE TABLE IF NOT EXISTS `movie_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `movieName` varchar(100) NOT NULL,
  `movie_keys` varchar(500) NOT NULL,
  `language` varchar(20) NOT NULL,
  `year` varchar(10) NOT NULL,
  `url` varchar(200) DEFAULT NULL,
  `imdb_id` varchar(50) DEFAULT NULL,
  `details` text,
  `director` varchar(200) DEFAULT NULL,
  `producer` varchar(200) DEFAULT NULL,
  `starring` varchar(1000) DEFAULT NULL,
  `screenplay` varchar(200) DEFAULT NULL,
  `musicDirector` varchar(200) DEFAULT NULL,
  `cinematography` varchar(200) DEFAULT NULL,
  `editor` varchar(200) DEFAULT NULL,
  `country` varchar(100) NOT NULL DEFAULT 'India',
  `distributor` varchar(200) DEFAULT NULL,
  `review` text NOT NULL,
  `isParse` tinyint(4) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `movieindex` (`movieName`,`language`,`year`,`url`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=960 ;

-- --------------------------------------------------------

--
-- Table structure for table `movie_song`
--

CREATE TABLE IF NOT EXISTS `movie_song` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `movieId` int(11) NOT NULL,
  `title` varchar(400) NOT NULL,
  `title_keys` varchar(400) NOT NULL,
  `singers` varchar(400) NOT NULL,
  `written` varchar(200) DEFAULT NULL,
  `lyrics` text NOT NULL,
  `isParse` tinyint(4) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `songindex` (`movieId`,`title`,`singers`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3221 ;

-- --------------------------------------------------------

--
-- Table structure for table `msisdn_new`
--

CREATE TABLE IF NOT EXISTS `msisdn_new` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msisdn` varchar(20) NOT NULL,
  `key_val` varchar(10) NOT NULL,
  `circle` varchar(20) NOT NULL,
  `operator` varchar(20) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `upd_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `entry_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `msi_cities`
--

CREATE TABLE IF NOT EXISTS `msi_cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(100) NOT NULL,
  `flag` tinyint(4) NOT NULL DEFAULT '0',
  `machineID` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `city` (`city`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18721 ;

-- --------------------------------------------------------

--
-- Table structure for table `mukhwaak`
--

CREATE TABLE IF NOT EXISTS `mukhwaak` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `response` varchar(1000) NOT NULL,
  `punjabi` varchar(5000) NOT NULL,
  `english` varchar(5000) NOT NULL,
  `fetch_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=64 ;

-- --------------------------------------------------------

--
-- Table structure for table `namaz_free`
--

CREATE TABLE IF NOT EXISTS `namaz_free` (
  `msisdn` varchar(14) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`msisdn`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `namaz_list`
--

CREATE TABLE IF NOT EXISTS `namaz_list` (
  `msisdn` varchar(10) NOT NULL,
  `circle` varchar(3) NOT NULL,
  `area` smallint(6) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`msisdn`),
  KEY `area` (`area`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `namaz_list_new`
--

CREATE TABLE IF NOT EXISTS `namaz_list_new` (
  `msisdn` varchar(10) NOT NULL,
  `circle` varchar(3) NOT NULL,
  `area` smallint(6) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`msisdn`),
  KEY `area` (`area`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `namaz_list_test`
--

CREATE TABLE IF NOT EXISTS `namaz_list_test` (
  `msisdn` varchar(10) NOT NULL,
  `circle` varchar(3) NOT NULL,
  `area` smallint(6) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`msisdn`),
  KEY `area` (`area`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `namaz_loc_match`
--

CREATE TABLE IF NOT EXISTS `namaz_loc_match` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `matched` varchar(50) NOT NULL,
  `Circle` varchar(5) NOT NULL,
  `lat` double NOT NULL DEFAULT '0',
  `lng` double NOT NULL DEFAULT '0',
  `msg1` tinytext NOT NULL,
  `msg2` tinytext NOT NULL,
  `msg3` tinytext NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `match` (`matched`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1376 ;

-- --------------------------------------------------------

--
-- Table structure for table `namaz_loc_srch`
--

CREATE TABLE IF NOT EXISTS `namaz_loc_srch` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `typed` varchar(50) NOT NULL,
  `area` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `typed` (`typed`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1522 ;

-- --------------------------------------------------------

--
-- Table structure for table `nepal_flight_airlines`
--

CREATE TABLE IF NOT EXISTS `nepal_flight_airlines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `airline` varchar(200) NOT NULL,
  `flightcode` varchar(100) NOT NULL,
  `air_srch` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq` (`airline`,`flightcode`),
  FULLTEXT KEY `airline` (`airline`,`air_srch`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

-- --------------------------------------------------------

--
-- Table structure for table `nepal_flight_dest`
--

CREATE TABLE IF NOT EXISTS `nepal_flight_dest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dest_srch` varchar(100) NOT NULL,
  `dest_name` varchar(500) NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `dest_name` (`dest_name`),
  FULLTEXT KEY `dest_srch` (`dest_srch`,`dest_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `nepal_restaurants`
--

CREATE TABLE IF NOT EXISTS `nepal_restaurants` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tag` varchar(30) NOT NULL,
  `name` varchar(50) NOT NULL,
  `details` text NOT NULL,
  `location` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `tag` (`tag`,`name`,`location`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=253 ;

-- --------------------------------------------------------

--
-- Table structure for table `newyear_party`
--

CREATE TABLE IF NOT EXISTS `newyear_party` (
  `msisdn` varchar(15) NOT NULL,
  `city` varchar(50) NOT NULL,
  `data` text NOT NULL,
  `timed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`msisdn`),
  KEY `city` (`city`,`timed`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `new_subscription`
--

CREATE TABLE IF NOT EXISTS `new_subscription` (
  `msisdn` char(10) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `circle` char(2) NOT NULL,
  KEY `time` (`time`),
  KEY `msisdn` (`msisdn`),
  KEY `circle` (`circle`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `niussd_list`
--

CREATE TABLE IF NOT EXISTS `niussd_list` (
  `msisdn` varchar(12) NOT NULL,
  `circle` varchar(3) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `msisdn` (`msisdn`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nowrun_city`
--

CREATE TABLE IF NOT EXISTS `nowrun_city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `url` varchar(200) NOT NULL,
  `city` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=619 ;

-- --------------------------------------------------------

--
-- Table structure for table `olympic`
--

CREATE TABLE IF NOT EXISTS `olympic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `event` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Table structure for table `olympics_fixture`
--

CREATE TABLE IF NOT EXISTS `olympics_fixture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `olympics_game`
--

CREATE TABLE IF NOT EXISTS `olympics_game` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `game` varchar(50) NOT NULL,
  `status` text NOT NULL,
  `score` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `game` (`game`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=779 ;

-- --------------------------------------------------------

--
-- Table structure for table `olympics_india`
--

CREATE TABLE IF NOT EXISTS `olympics_india` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=337 ;

-- --------------------------------------------------------

--
-- Table structure for table `olympics_medal`
--

CREATE TABLE IF NOT EXISTS `olympics_medal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country` varchar(100) NOT NULL,
  `gold` int(11) NOT NULL,
  `silver` int(11) NOT NULL,
  `bronze` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `country` (`country`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=727 ;

-- --------------------------------------------------------

--
-- Table structure for table `olympics_news`
--

CREATE TABLE IF NOT EXISTS `olympics_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=461 ;

-- --------------------------------------------------------

--
-- Table structure for table `operator_cust_care`
--

CREATE TABLE IF NOT EXISTS `operator_cust_care` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `operator` varchar(100) NOT NULL,
  `circle` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=88 ;

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
-- Table structure for table `place_apicount`
--

CREATE TABLE IF NOT EXISTS `place_apicount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dated` date NOT NULL,
  `api1_cnt` int(11) NOT NULL,
  `api2_cnt` int(11) NOT NULL,
  `api3_cnt` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=145 ;

-- --------------------------------------------------------

--
-- Table structure for table `place_data`
--

CREATE TABLE IF NOT EXISTS `place_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key_match` varchar(50) NOT NULL,
  `area` int(11) NOT NULL,
  `msg` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=165750 ;

-- --------------------------------------------------------

--
-- Table structure for table `place_details`
--

CREATE TABLE IF NOT EXISTS `place_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `street` varchar(100) NOT NULL,
  `district` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `zipcode` varchar(20) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `street_add` varchar(300) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `street` (`street_add`,`zipcode`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `place_key`
--

CREATE TABLE IF NOT EXISTS `place_key` (
  `keyid` int(11) NOT NULL AUTO_INCREMENT,
  `typed` varchar(50) NOT NULL,
  `matched` varchar(50) NOT NULL,
  `keyword` varchar(50) NOT NULL,
  PRIMARY KEY (`keyid`),
  KEY `typed` (`typed`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13091 ;

-- --------------------------------------------------------

--
-- Table structure for table `place_match`
--

CREATE TABLE IF NOT EXISTS `place_match` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `matched` varchar(500) NOT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `matched` (`matched`,`lat`,`lng`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=128731 ;

-- --------------------------------------------------------

--
-- Table structure for table `place_match_old`
--

CREATE TABLE IF NOT EXISTS `place_match_old` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `matched` varchar(200) NOT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `matched` (`matched`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=92523 ;

-- --------------------------------------------------------

--
-- Table structure for table `place_srch`
--

CREATE TABLE IF NOT EXISTS `place_srch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typed` varchar(50) NOT NULL,
  `area` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `typed` (`typed`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=244229 ;

-- --------------------------------------------------------

--
-- Table structure for table `place_srch_old`
--

CREATE TABLE IF NOT EXISTS `place_srch_old` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typed` varchar(50) NOT NULL,
  `area` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=173305 ;

-- --------------------------------------------------------

--
-- Table structure for table `product_details`
--

CREATE TABLE IF NOT EXISTS `product_details` (
  `circle` varchar(3) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `price_point` varchar(2) NOT NULL,
  `ussd_msg` varchar(300) NOT NULL,
  `single_confirmation` binary(1) NOT NULL DEFAULT '0',
  UNIQUE KEY `circle` (`circle`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `query_list`
--

CREATE TABLE IF NOT EXISTS `query_list` (
  `query` varchar(400) NOT NULL,
  `msisdn` varchar(10) NOT NULL,
  `circle` varchar(2) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `msisdn` (`msisdn`,`time`),
  KEY `query` (`query`),
  KEY `circle` (`circle`),
  KEY `time` (`time`),
  KEY `msisdn_2` (`msisdn`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `query_list_api`
--

CREATE TABLE IF NOT EXISTS `query_list_api` (
  `query` varchar(400) NOT NULL,
  `msisdn` varchar(10) NOT NULL,
  `circle` varchar(20) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `time` (`time`),
  KEY `circle` (`circle`),
  KEY `query` (`query`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `query_list_KA`
--

CREATE TABLE IF NOT EXISTS `query_list_KA` (
  `msisdn` varchar(10) NOT NULL,
  KEY `msisdn` (`msisdn`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `query_list_old`
--

CREATE TABLE IF NOT EXISTS `query_list_old` (
  `query` varchar(400) NOT NULL,
  `msisdn` varchar(10) NOT NULL,
  `circle` varchar(2) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `msisdn` (`msisdn`,`time`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `query_list_rec`
--

CREATE TABLE IF NOT EXISTS `query_list_rec` (
  `query` varchar(400) NOT NULL,
  `msisdn` varchar(10) NOT NULL,
  `circle` varchar(2) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `msisdn` (`msisdn`,`time`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `query_list_test`
--

CREATE TABLE IF NOT EXISTS `query_list_test` (
  `query` varchar(400) NOT NULL,
  `msisdn` varchar(10) NOT NULL,
  `circle` varchar(2) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `msisdn` (`msisdn`,`time`),
  KEY `time` (`time`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `query_q_test`
--

CREATE TABLE IF NOT EXISTS `query_q_test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `query` varchar(160) NOT NULL,
  `msisdn` varchar(10) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `query_number` (`query`,`msisdn`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `query_words`
--

CREATE TABLE IF NOT EXISTS `query_words` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `word` varchar(20) NOT NULL,
  `circle` varchar(50) NOT NULL,
  `operator` varchar(10) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `word` (`word`),
  KEY `circle` (`circle`),
  KEY `operator` (`operator`),
  KEY `timestamp` (`timestamp`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44885563 ;

-- --------------------------------------------------------

--
-- Table structure for table `quotes`
--

CREATE TABLE IF NOT EXISTS `quotes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quote` varchar(200) NOT NULL,
  `url` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `quote` (`quote`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21448 ;

-- --------------------------------------------------------

--
-- Table structure for table `quotes_data`
--

CREATE TABLE IF NOT EXISTS `quotes_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typed` varchar(200) NOT NULL,
  `quotes` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11025 ;

-- --------------------------------------------------------

--
-- Table structure for table `randomfacts`
--

CREATE TABLE IF NOT EXISTS `randomfacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(200) NOT NULL,
  `head` varchar(200) NOT NULL,
  `subhead` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=112 ;

-- --------------------------------------------------------

--
-- Table structure for table `redlist`
--

CREATE TABLE IF NOT EXISTS `redlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msisdn` varchar(10) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `msisdn` (`msisdn`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE IF NOT EXISTS `request` (
  `mobile` varchar(15) NOT NULL,
  `query` text NOT NULL,
  `target` text,
  `position` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `machine_id` varchar(2) NOT NULL,
  PRIMARY KEY (`mobile`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `restu_cities`
--

CREATE TABLE IF NOT EXISTS `restu_cities` (
  `city_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `has_nightlife` tinyint(1) NOT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `has_events` int(11) NOT NULL,
  `show_zones` tinyint(1) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `srch` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `city_id` (`city_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

-- --------------------------------------------------------

--
-- Table structure for table `restu_cuisines`
--

CREATE TABLE IF NOT EXISTS `restu_cuisines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cuisine_id` int(11) NOT NULL,
  `cuisine_name` varchar(50) NOT NULL,
  `city_id` int(11) NOT NULL,
  `srch` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2508 ;

-- --------------------------------------------------------

--
-- Table structure for table `restu_data`
--

CREATE TABLE IF NOT EXISTS `restu_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subzone_id` int(11) NOT NULL,
  `zone` varchar(50) NOT NULL,
  `city_id` int(11) NOT NULL,
  `cuisine_id` int(11) NOT NULL,
  `cuisine` varchar(50) NOT NULL,
  `msg` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

-- --------------------------------------------------------

--
-- Table structure for table `restu_zone`
--

CREATE TABLE IF NOT EXISTS `restu_zone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subzone_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `zone_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `srch` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subzone_id` (`subzone_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3311 ;

-- --------------------------------------------------------

--
-- Table structure for table `route_result`
--

CREATE TABLE IF NOT EXISTS `route_result` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `source` varchar(50) NOT NULL,
  `dest` varchar(50) NOT NULL,
  `result` text NOT NULL,
  `fetchtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `source` (`source`),
  KEY `dest` (`dest`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53428 ;

-- --------------------------------------------------------

--
-- Table structure for table `rto_reg`
--

CREATE TABLE IF NOT EXISTS `rto_reg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state` varchar(5) NOT NULL,
  `dist` smallint(6) NOT NULL,
  `state_name` varchar(50) NOT NULL,
  `dist_name` varchar(50) NOT NULL,
  `hits` smallint(6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `state` (`state`,`dist`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=985 ;

-- --------------------------------------------------------

--
-- Table structure for table `safesearch`
--

CREATE TABLE IF NOT EXISTS `safesearch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `words` varchar(30) NOT NULL DEFAULT '-',
  PRIMARY KEY (`id`),
  UNIQUE KEY `words` (`words`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

-- --------------------------------------------------------

--
-- Table structure for table `safe_search_numbers`
--

CREATE TABLE IF NOT EXISTS `safe_search_numbers` (
  `msisdn` varchar(10) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`msisdn`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `share_data`
--

CREATE TABLE IF NOT EXISTS `share_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msisdn` varchar(20) NOT NULL,
  `circle` varchar(10) NOT NULL,
  `data` varchar(600) NOT NULL,
  `modified_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `msisdn` (`msisdn`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3725848 ;

-- --------------------------------------------------------

--
-- Table structure for table `slang`
--

CREATE TABLE IF NOT EXISTS `slang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `scode` varchar(50) NOT NULL,
  `smean` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `scode` (`scode`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19824 ;

-- --------------------------------------------------------

--
-- Table structure for table `sl_train_stations`
--

CREATE TABLE IF NOT EXISTS `sl_train_stations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `station_code` varchar(100) NOT NULL,
  `station_name` varchar(100) NOT NULL,
  `other` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=322 ;

-- --------------------------------------------------------

--
-- Table structure for table `smsgyan_api`
--

CREATE TABLE IF NOT EXISTS `smsgyan_api` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `apiKey` varchar(50) NOT NULL,
  `charLimit` int(11) NOT NULL DEFAULT '160',
  `contentType` varchar(50) NOT NULL,
  `opFormat` varchar(20) NOT NULL DEFAULT 'xml',
  `hitCount` int(11) NOT NULL DEFAULT '10',
  `country` varchar(50) NOT NULL DEFAULT 'IN',
  `timeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `sms_chat`
--

CREATE TABLE IF NOT EXISTS `sms_chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msisdn` varchar(20) NOT NULL,
  `status` int(11) NOT NULL,
  `hit_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `msisdn` (`msisdn`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22145 ;

-- --------------------------------------------------------

--
-- Table structure for table `sms_messages`
--

CREATE TABLE IF NOT EXISTS `sms_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keywords` varchar(50) NOT NULL,
  `content` varchar(5000) NOT NULL,
  `tags` varchar(100) NOT NULL,
  `status` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=133 ;

-- --------------------------------------------------------

--
-- Table structure for table `sms_mis`
--

CREATE TABLE IF NOT EXISTS `sms_mis` (
  `operator` varchar(12) NOT NULL,
  `circle` varchar(12) NOT NULL,
  `mis` varchar(1000) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `operator` (`operator`,`circle`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `solr_Car_Bike`
--

CREATE TABLE IF NOT EXISTS `solr_Car_Bike` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `make_id` varchar(50) NOT NULL,
  `model_id` varchar(50) NOT NULL,
  `make` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `srch` varchar(50) NOT NULL,
  `category` varchar(10) NOT NULL,
  `price` varchar(200) NOT NULL,
  `spec` varchar(1000) NOT NULL,
  `Spec_URL` varchar(500) NOT NULL,
  `optionlist` varchar(1000) NOT NULL,
  `list` varchar(2000) NOT NULL,
  `updatetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `srch` (`srch`),
  FULLTEXT KEY `model` (`model`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1556 ;

-- --------------------------------------------------------

--
-- Table structure for table `solr_Car_Bike_test`
--

CREATE TABLE IF NOT EXISTS `solr_Car_Bike_test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `make_id` varchar(50) NOT NULL,
  `model_id` varchar(200) NOT NULL,
  `make` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `srch` varchar(50) NOT NULL,
  `category` varchar(10) NOT NULL,
  `price` varchar(200) NOT NULL,
  `spec` varchar(1000) NOT NULL,
  `Spec_URL` varchar(500) NOT NULL,
  `optionlist` varchar(1000) NOT NULL,
  `list` varchar(2000) NOT NULL,
  `updatetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `srch` (`srch`),
  FULLTEXT KEY `model` (`model`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1927 ;

-- --------------------------------------------------------

--
-- Table structure for table `songsfull`
--

CREATE TABLE IF NOT EXISTS `songsfull` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `movie` varchar(255) NOT NULL DEFAULT '',
  `language` varchar(25) NOT NULL,
  `year` int(11) NOT NULL,
  `wikiLink` varchar(500) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq` (`movie`,`language`,`year`),
  KEY `movie` (`movie`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15051 ;

-- --------------------------------------------------------

--
-- Table structure for table `song_detail`
--

CREATE TABLE IF NOT EXISTS `song_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `movieID` int(11) NOT NULL,
  `movieName` varchar(200) NOT NULL,
  `language` varchar(50) NOT NULL,
  `year` varchar(50) NOT NULL,
  `url` varchar(300) NOT NULL,
  `titles` varchar(200) NOT NULL,
  `singers` varchar(200) NOT NULL,
  `details` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniqt` (`titles`,`singers`,`movieName`,`year`,`language`,`url`),
  FULLTEXT KEY `titles` (`titles`),
  FULLTEXT KEY `movieName` (`movieName`),
  FULLTEXT KEY `fiull` (`titles`,`movieName`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24307 ;

-- --------------------------------------------------------

--
-- Table structure for table `song_detail1`
--

CREATE TABLE IF NOT EXISTS `song_detail1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `movieID` int(11) NOT NULL,
  `movieName` varchar(200) NOT NULL,
  `language` varchar(50) NOT NULL,
  `year` varchar(50) NOT NULL,
  `url` varchar(300) NOT NULL,
  `titles` varchar(200) NOT NULL,
  `singers` varchar(200) NOT NULL,
  `details` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniqt` (`titles`,`singers`,`movieName`,`year`,`language`,`url`),
  FULLTEXT KEY `titles` (`titles`),
  FULLTEXT KEY `movieName` (`movieName`),
  FULLTEXT KEY `fiull` (`titles`,`movieName`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24307 ;

-- --------------------------------------------------------

--
-- Table structure for table `spelling`
--

CREATE TABLE IF NOT EXISTS `spelling` (
  `word_in` varchar(200) NOT NULL,
  `corrected` varchar(200) NOT NULL,
  PRIMARY KEY (`word_in`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `spell_test`
--

CREATE TABLE IF NOT EXISTS `spell_test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `org` varchar(200) NOT NULL,
  `our` varchar(200) NOT NULL,
  `curr` varchar(200) NOT NULL,
  `isold` int(11) NOT NULL,
  `tim` float NOT NULL,
  `timstmp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30076 ;

-- --------------------------------------------------------

--
-- Table structure for table `stdcodes`
--

CREATE TABLE IF NOT EXISTS `stdcodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `code` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `code` (`code`),
  FULLTEXT KEY `city` (`city`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19290 ;

-- --------------------------------------------------------

--
-- Table structure for table `story`
--

CREATE TABLE IF NOT EXISTS `story` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `story_title` varchar(200) NOT NULL,
  `chapter_title` varchar(200) NOT NULL,
  `chapter_name` varchar(200) NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=84 ;

-- --------------------------------------------------------

--
-- Table structure for table `stream`
--

CREATE TABLE IF NOT EXISTS `stream` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(11) NOT NULL,
  `sname` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE IF NOT EXISTS `subject` (
  `id` int(11) NOT NULL,
  `subid` int(11) NOT NULL,
  `subname` varchar(100) NOT NULL,
  `sid1` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE IF NOT EXISTS `subscribers` (
  `msisdn` varchar(12) NOT NULL,
  `circle` varchar(3) NOT NULL,
  UNIQUE KEY `msisdn` (`msisdn`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `superstar`
--

CREATE TABLE IF NOT EXISTS `superstar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `age` int(11) NOT NULL,
  `number` varchar(50) NOT NULL,
  `operator` varchar(50) NOT NULL,
  `circle` varchar(50) NOT NULL,
  `count` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`age`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=67 ;

-- --------------------------------------------------------

--
-- Table structure for table `t20_questn`
--

CREATE TABLE IF NOT EXISTS `t20_questn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(100) NOT NULL,
  `operator` varchar(100) NOT NULL,
  `circle` varchar(100) NOT NULL,
  `question` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `t20_team`
--

CREATE TABLE IF NOT EXISTS `t20_team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shrt_team` varchar(100) NOT NULL,
  `team` varchar(100) NOT NULL,
  `members` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `t20_tweet`
--

CREATE TABLE IF NOT EXISTS `t20_tweet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tweet` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=168 ;

-- --------------------------------------------------------

--
-- Table structure for table `t20_WC`
--

CREATE TABLE IF NOT EXISTS `t20_WC` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `time` varchar(50) NOT NULL,
  `team1` varchar(500) NOT NULL,
  `team2` varchar(100) NOT NULL,
  `shrt_team1` varchar(50) NOT NULL,
  `shrt_team2` varchar(50) NOT NULL,
  `venue` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

-- --------------------------------------------------------

--
-- Table structure for table `tag_responses`
--

CREATE TABLE IF NOT EXISTS `tag_responses` (
  `tag` varchar(100) NOT NULL,
  `response` varchar(480) NOT NULL,
  UNIQUE KEY `tag` (`tag`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `taxi_distime`
--

CREATE TABLE IF NOT EXISTS `taxi_distime` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `origin` varchar(100) NOT NULL,
  `destination` varchar(100) NOT NULL,
  `distance` double NOT NULL,
  `duration` int(11) NOT NULL,
  `cityid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2854 ;

-- --------------------------------------------------------

--
-- Table structure for table `taxi_state`
--

CREATE TABLE IF NOT EXISTS `taxi_state` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sval` int(11) NOT NULL,
  `state` varchar(100) NOT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `state` (`state`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=99 ;

-- --------------------------------------------------------

--
-- Table structure for table `temp`
--

CREATE TABLE IF NOT EXISTS `temp` (
  `msisdn` varchar(10) NOT NULL,
  UNIQUE KEY `msisdn` (`msisdn`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `temp_test`
--

CREATE TABLE IF NOT EXISTS `temp_test` (
  `msisdn` varchar(15) NOT NULL,
  `circle` varchar(5) NOT NULL,
  UNIQUE KEY `msisdn` (`msisdn`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `temp_uu`
--

CREATE TABLE IF NOT EXISTS `temp_uu` (
  `month` varchar(5) NOT NULL,
  `uu` varchar(10) NOT NULL,
  `tothit` varchar(10) NOT NULL,
  KEY `month` (`month`,`uu`,`tothit`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tennis`
--

CREATE TABLE IF NOT EXISTS `tennis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Matches` text,
  `Court` text,
  `Playtime` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=273 ;

-- --------------------------------------------------------

--
-- Table structure for table `tennis_completed`
--

CREATE TABLE IF NOT EXISTS `tennis_completed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `details` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE IF NOT EXISTS `test` (
  `msisdn` varchar(12) NOT NULL,
  `circle` varchar(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `testapp`
--

CREATE TABLE IF NOT EXISTS `testapp` (
  `id` varchar(110) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `testapp2`
--

CREATE TABLE IF NOT EXISTS `testapp2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keyword` varchar(100) NOT NULL,
  `tcount` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=472 ;

-- --------------------------------------------------------

--
-- Table structure for table `tnch_result_reg`
--

CREATE TABLE IF NOT EXISTS `tnch_result_reg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msisdn` varchar(50) NOT NULL,
  `circle` varchar(20) NOT NULL,
  `operator` varchar(20) NOT NULL,
  `regno` varchar(20) NOT NULL,
  `regdate` varchar(50) NOT NULL,
  `type` varchar(20) NOT NULL,
  `result` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `msisdn` (`msisdn`,`regno`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34221 ;

-- --------------------------------------------------------

--
-- Table structure for table `topers`
--

CREATE TABLE IF NOT EXISTS `topers` (
  `msisdn` varchar(12) NOT NULL,
  `circle` varchar(3) NOT NULL,
  UNIQUE KEY `msisdn` (`msisdn`),
  KEY `circle` (`circle`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `topquery`
--

CREATE TABLE IF NOT EXISTS `topquery` (
  `circle` varchar(30) NOT NULL,
  `keyword` varchar(20) NOT NULL,
  `nquery` int(11) NOT NULL,
  `cdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `circle` (`circle`),
  KEY `cdate` (`cdate`),
  KEY `keyword` (`keyword`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `topusers`
--

CREATE TABLE IF NOT EXISTS `topusers` (
  `circle` varchar(3) NOT NULL,
  `count` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`date`),
  UNIQUE KEY `date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `train_number`
--

CREATE TABLE IF NOT EXISTS `train_number` (
  `train_no` varchar(8) DEFAULT NULL,
  `train_name` varchar(40) DEFAULT NULL,
  `source` varchar(50) DEFAULT NULL,
  `destination` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `train_stations`
--

CREATE TABLE IF NOT EXISTS `train_stations` (
  `StationName` varchar(50) NOT NULL,
  `CodeName` varchar(10) NOT NULL,
  KEY `StationName` (`StationName`),
  KEY `CodeName` (`CodeName`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `train_stations_ixigo`
--

CREATE TABLE IF NOT EXISTS `train_stations_ixigo` (
  `StationName` varchar(50) NOT NULL,
  `CodeName` varchar(10) NOT NULL,
  `TrainCount` smallint(6) NOT NULL,
  KEY `StationName` (`StationName`),
  KEY `CodeName` (`CodeName`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `train_stations_mumbai`
--

CREATE TABLE IF NOT EXISTS `train_stations_mumbai` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `region` tinyint(4) NOT NULL,
  `name` varchar(30) NOT NULL,
  `code` varchar(50) NOT NULL,
  `code1` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `region` (`region`,`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=258 ;

-- --------------------------------------------------------

--
-- Table structure for table `train_stations_statewise`
--

CREATE TABLE IF NOT EXISTS `train_stations_statewise` (
  `StationName` varchar(50) NOT NULL,
  `CodeName` varchar(10) NOT NULL,
  `TrainCount` smallint(6) NOT NULL,
  `Circle` varchar(10) NOT NULL,
  KEY `StationName` (`StationName`,`CodeName`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tvchannel_store`
--

CREATE TABLE IF NOT EXISTS `tvchannel_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `channel_id` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `details` varchar(10000) NOT NULL,
  `source` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `channel_id` (`channel_id`,`source`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29271 ;

-- --------------------------------------------------------

--
-- Table structure for table `tvin_channel`
--

CREATE TABLE IF NOT EXISTS `tvin_channel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link` varchar(50) NOT NULL,
  `name` varchar(30) NOT NULL,
  `dname` varchar(30) NOT NULL,
  `search` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=364 ;

-- --------------------------------------------------------

--
-- Table structure for table `tvnow_channel`
--

CREATE TABLE IF NOT EXISTS `tvnow_channel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link` varchar(50) NOT NULL,
  `name` varchar(30) NOT NULL,
  `dname` varchar(30) NOT NULL,
  `search` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=261 ;

-- --------------------------------------------------------

--
-- Table structure for table `tv_channel`
--

CREATE TABLE IF NOT EXISTS `tv_channel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link` varchar(50) NOT NULL,
  `name` varchar(30) NOT NULL,
  `dname` varchar(30) NOT NULL,
  `search` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `dname` (`dname`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=184 ;

-- --------------------------------------------------------

--
-- Table structure for table `unbilled`
--

CREATE TABLE IF NOT EXISTS `unbilled` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msisdn` varchar(10) NOT NULL,
  `source` varchar(100) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33362 ;

-- --------------------------------------------------------

--
-- Table structure for table `unsubscriptions`
--

CREATE TABLE IF NOT EXISTS `unsubscriptions` (
  `msisdn` char(10) NOT NULL,
  `main_id` int(11) NOT NULL,
  `source` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `circle` char(2) NOT NULL,
  `subscribed` tinyint(4) NOT NULL DEFAULT '0',
  KEY `time` (`time`),
  KEY `circle` (`circle`),
  KEY `msisdn` (`msisdn`,`time`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `usage`
--

CREATE TABLE IF NOT EXISTS `usage` (
  `msisdn` varchar(12) NOT NULL,
  `circle` varchar(4) NOT NULL,
  `count` varchar(11) NOT NULL,
  UNIQUE KEY `msisdn` (`msisdn`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_channels`
--

CREATE TABLE IF NOT EXISTS `user_channels` (
  `sub_id` int(11) NOT NULL AUTO_INCREMENT,
  `number` char(10) NOT NULL,
  `circle` char(2) NOT NULL,
  `channel` tinyint(1) NOT NULL,
  `expiry` timestamp NULL DEFAULT NULL,
  `medium` tinyint(1) NOT NULL,
  `pricepoint` int(11) NOT NULL,
  `pre_sent` varchar(20) NOT NULL DEFAULT '0',
  `umedium` tinyint(1) NOT NULL,
  `subscribed` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `last_nob_pass` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `processing` tinyint(4) NOT NULL DEFAULT '0',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`sub_id`),
  UNIQUE KEY `number_2` (`number`),
  KEY `number` (`number`,`channel`),
  KEY `pre_sent` (`pre_sent`),
  KEY `expiry` (`expiry`),
  KEY `status` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=61506 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_constituency`
--

CREATE TABLE IF NOT EXISTS `user_constituency` (
  `msisdn` varchar(10) NOT NULL,
  `constituency` varchar(100) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `ind1` (`msisdn`,`constituency`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_flagged`
--

CREATE TABLE IF NOT EXISTS `user_flagged` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `query` varchar(160) NOT NULL,
  `response` varchar(480) NOT NULL,
  `msisdn` varchar(10) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `query` (`query`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23942 ;

-- --------------------------------------------------------

--
-- Table structure for table `usg_photo`
--

CREATE TABLE IF NOT EXISTS `usg_photo` (
  `msisdn` varchar(12) NOT NULL,
  `circle` varchar(4) NOT NULL,
  `count` int(11) NOT NULL,
  UNIQUE KEY `msisdn` (`msisdn`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE IF NOT EXISTS `vehicle` (
  `code` varchar(100) NOT NULL,
  `place` text NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_movie_new`
--
CREATE TABLE IF NOT EXISTS `view_movie_new` (
`id` int(11)
,`movieName` varchar(100)
,`language` varchar(20)
,`year` varchar(10)
,`title` varchar(400)
,`lyrics` text
);
-- --------------------------------------------------------

--
-- Table structure for table `vote_bcontest`
--

CREATE TABLE IF NOT EXISTS `vote_bcontest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `type` varchar(20) NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

-- --------------------------------------------------------

--
-- Table structure for table `words`
--

CREATE TABLE IF NOT EXISTS `words` (
  `word` varchar(20) NOT NULL,
  `meaning` varchar(1500) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=101 ;

-- --------------------------------------------------------

--
-- Table structure for table `worldcup`
--

CREATE TABLE IF NOT EXISTS `worldcup` (
  `record` text NOT NULL,
  `held` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `world_det`
--

CREATE TABLE IF NOT EXISTS `world_det` (
  `country` varchar(100) NOT NULL,
  `country_dis` varchar(100) NOT NULL,
  `capital` varchar(100) NOT NULL,
  `currency` varchar(100) NOT NULL,
  `head` varchar(100) NOT NULL,
  `head_post` varchar(100) NOT NULL,
  `prime` varchar(100) NOT NULL,
  `foreign` varchar(100) NOT NULL,
  PRIMARY KEY (`country`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure for view `view_movie_new`
--
DROP TABLE IF EXISTS `view_movie_new`;

CREATE ALGORITHM=TEMPTABLE DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_movie_new` AS select `movie_list`.`id` AS `id`,`movie_list`.`movieName` AS `movieName`,`movie_list`.`language` AS `language`,`movie_list`.`year` AS `year`,`movie_song`.`title` AS `title`,`movie_song`.`lyrics` AS `lyrics` from (`movie_list` left join `movie_song` on((`movie_list`.`id` = `movie_song`.`movieId`))) where (`movie_list`.`language` = 'malayalam') order by `movie_list`.`id` desc limit 20;
