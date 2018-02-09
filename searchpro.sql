-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 19, 2017 at 01:15 PM
-- Server version: 5.7.19
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `searchpro`
--

-- --------------------------------------------------------

--
-- Table structure for table `keywords`
--

DROP TABLE IF EXISTS `keywords`;
CREATE TABLE IF NOT EXISTS `keywords` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keyword` varchar(32) COLLATE utf8_romanian_ci NOT NULL,
  `count` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;

--
-- Dumping data for table `keywords`
--

INSERT INTO `keywords` (`id`, `keyword`, `count`) VALUES
(2, 'ubuntu', 6),
(6, 'Search...', 1),
(47, 'google', 30),
(54, 'Infinitemovies', 3),
(57, 'youtube', 2),
(58, 'amazon', 20),
(59, 'amazom', 1),
(60, 'search', 8),
(61, 'hack', 1),
(62, 'ama', 13),
(63, 'movies', 1),
(64, 'dileep', 2),
(65, 'flipkart', 2),
(66, 'vtu', 1),
(67, 'vtu.ac.in', 1),
(68, 'university', 1),
(69, 'master', 1),
(70, 'masteranime', 1),
(71, 'yahoo', 1),
(72, 'flipkart amazon', 3),
(73, 'online', 11),
(74, 'technolish', 3),
(75, 'online technolish', 6),
(76, 'technolish online', 6),
(77, 'github', 1),
(78, 'online shopping', 2),
(79, 'globe', 1),
(80, 'onl', 7);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(24) COLLATE utf8_romanian_ci NOT NULL,
  `password` varchar(256) COLLATE utf8_romanian_ci NOT NULL,
  `ad1` varchar(2048) COLLATE utf8_romanian_ci NOT NULL,
  `ad2` varchar(2048) COLLATE utf8_romanian_ci NOT NULL,
  `ad3` varchar(2048) COLLATE utf8_romanian_ci NOT NULL,
  `title` varchar(32) COLLATE utf8_romanian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `ad1`, `ad2`, `ad3`, `title`) VALUES
(1, 'admin', 'b0daf16b2532e0cc71b1043c9711d805', '', '', '', 'SearchPro');

-- --------------------------------------------------------

--
-- Table structure for table `web`
--

DROP TABLE IF EXISTS `web`;
CREATE TABLE IF NOT EXISTS `web` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(512) NOT NULL,
  `title` varchar(128) NOT NULL,
  `description` varchar(1024) NOT NULL,
  `body` text NOT NULL,
  `author` varchar(64) NOT NULL,
  `date` varchar(32) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `web`
--

INSERT INTO `web` (`id`, `url`, `title`, `description`, `body`, `author`, `date`) VALUES
(1, 'http://infinitemovies.xyz', 'InfiniteMovies - English Hindi Kannada Telugu Tamil Movies Online', 'English Hindi Kannada Telugu Tamil Movies Online', 'InfiniteMovies English Hindi Kannada Telugu Tamil Movies Online Home English Hindi Kannada Malayalam Marathi Tamil Telugu Teaser/Trailers TV Series Bhikari (2017) Marathi Movie Watch Online Infinite Movies 3 days ago 7 Views0 Comments0 Likes Thupparivaala', '', '31 Oct 2017'),
(2, 'http://technolish.com', 'Technolish : Technology News, Latest &amp; Popular Gadgets Reviews ...', 'Find Latest technology news daily, new best tech gadgets reviews which include mobiles, Laptops , Be updated on Social Networks - Technolish', 'LikesFollowersFollowers Technolish - HomeNewsIndiaMobilesAndroidiPhoneWindows PhoneAppsGadgetsPC/LaptopsGamingReviewsSocialNetworks India Jio Phone First Impressions Technolish Sep 23, 2017 0 News Xiaomi Sold More Than 1 Million Smartphones in 2 Days Duri', '', '31 Oct 2017'),
(4, 'http://www.amazon.com', 'Amazon.com: Online Shopping for Electronics, Apparel, Computers, Books, DVDs & more', 'Online shopping from the earth', '{\"AUI_107069\":null,\"AUI_51744\":null,\"AUI_57326\":null,\"AUI_72554\":null,\"AUI_ACCESSIBILITY_49860\":null,\"AUI_ATTR_VALIDATIONS_1_51371\":null,\"AUI_BOLT_62845\":null,\"AUI_UX_102912\":null,\"AUI_UX_59374\":null,\"AUI_UX_60000\":null,\"AUI_UX_92006\":\"C\",\"AUI_UX_98513\":n', '', '31 Oct 2017'),
(5, 'https://www.amazon.jobs', 'Amazon.jobs: Help us build Earth’s most customer-centric company.', '', 'Explore Amazon JobsHomeReview application statusAmazon culture benefitsLocationsTeamsJob categoriesHelpEnglishČeštinaDeutschEnglishEnglish, BritishEspañol (Europeo)FrançaisItaliano日本語PolskiPortuguês, Brasil简体中文$(document).ready(function', '', '31 Oct 2017'),
(6, 'https://developer.amazon.com', 'Amazon Developer Services', 'The Amazon Developer Services portal allows developers to distribute and sell Android and HTML5 web apps to millions of customers on the Amazon Appstore, and build voice experiences for services and devices by adding skills to Alexa, the voice service tha', '{\"AUI_107069\":null,\"AUI_51744\":null,\"AUI_57326\":null,\"AUI_72554\":null,\"AUI_ACCESSIBILITY_49860\":null,\"AUI_ATTR_VALIDATIONS_1_51371\":null,\"AUI_BOLT_62845\":null,\"AUI_UX_102912\":null,\"AUI_UX_59374\":null,\"AUI_UX_60000\":null,\"AUI_UX_92006\":\"C\",\"AUI_UX_98513\":n', '', '31 Oct 2017'),
(7, 'https://music.amazon.com?ref=dm_aff_amz_com', 'Amazon Music Unlimited  - Stream millions of songs online now.', '', 'div id=\"noscript\" div id=\"header\" img id=amazonMusicLogo src=https://images-na.ssl-images-amazon.com/images/G/01/digital/music/player/web/AmazonMusicGradientLogo._CB509440606_.svg title=Amazon Music (formerly Cloud Player)/img div id=\"accountOptions', '', '31 Oct 2017'),
(10, 'http://www.alexa.com', 'Keyword Research, Competitive Analysis, &amp; Website Ranking | Alexa', 'Boost traffic and revenue with a full suite of SEO and competitor analysis tools. Discover new opportunities to find, reach, and convert your audience.', 'Features SEO ToolsKeyword Difficulty ToolCompetitor Keyword MatrixOn-Page SEO CheckerCompetitor Backlink CheckerSEO Audit ToolCompetitive Analysis ToolsAudience Overlap ToolSite ComparisonsWebsite Traffic StatisticsFind Similar SitesTop Sites5 Tools for a', '', '31 Oct 2017'),
(17, 'http://www.imdb.com', 'IMDb - Movies, TV and Celebrities - IMDb', 'IMDb, the world', 'if (typeof uet == function) { uet(\"bb\"); } if (csm in window) { csm.measure(csm_body_delivery_started); } if (typeof uet == function) { uet(\"ns\"); } IMDb More All Titles TV Episodes Names Companies Keywords Characters Quotes Bios Plots Movies, TV ', '', '31 Oct 2017'),
(19, 'http://www.junglee.com', 'Local Finds @ Amazon.in', 'Online shopping for Local Finds at Amazon.in', '{\"AUI_107069\":null,\"AUI_51744\":null,\"AUI_57326\":null,\"AUI_72554\":null,\"AUI_ACCESSIBILITY_49860\":null,\"AUI_ATTR_VALIDATIONS_1_51371\":null,\"AUI_BOLT_62845\":null,\"AUI_UX_102912\":null,\"AUI_UX_59374\":null,\"AUI_UX_60000\":null,\"AUI_UX_92006\":null,\"AUI_UX_98513\":', '', '31 Oct 2017'),
(20, 'http://kdp.amazon.com', ' Self Publishing | Amazon Kindle Direct Publishing ', 'Amazon', '{\"AUIX_EMBER_92249\":null,\"AUIX_EMBER_92250\":null,\"AUIX_EMBER_92251\":null,\"AUIX_EMBER_92302\":null,\"AUI_51279\":null,\"AUI_51744\":null,\"AUI_57326\":null,\"AUI_58736\":null,\"AUI_72554\":null,\"AUI_83815\":null,\"AUI_86171\":null,\"AUI_ACCESSIBILITY_49860\":null,\"AUI_ATT', '', '31 Oct 2017'),
(24, 'https://www.google.com', 'Google', '', '(function(){var src=/images/nav_logo229.png;var iesg=false;document.body.onload = function(){window.n && window.n();if (document.images){new Image().src=src;} if (!iesg){document.f&&document.f.q.focus();document.gbqf&&document.gbqf.q.focus();} } })(); w', '', '31 Oct 2017'),
(25, 'http://searchbelagavi.com', 'Search Belagavi', '', '(function(i,s,o,g,r,a,m){i[GoogleAnalyticsObject]=r;i[r]=i[r]||function(){ (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o), m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m) })(window,document,', '', '13 Nov 2017'),
(27, 'http://yahoo.com', 'Yahoo', 'News, email and search are just the beginning. Discover more every day. Find your yodel.', 'var resourceTimingAssets = null; if (window.performance && window.performance.mark && window.performance.getEntriesByName) { resourceTimingAssets = {darlaJsLoaded : https://s.yimg.com/rq/darla/3-0-7/js/g-r-min.js}; window.performance.mark(darlaJsLoad', '', '29 Nov 2017'),
(28, 'http://flipkart.com', 'Online Shopping Site for Mobiles, Fashion, Books, Electronics, Home Appliances and More', 'Indias biggest online store for Mobiles,Fashion(Cloths/Shoes),Electronics,Home Appliances,Books,Jewelry,Home,Furniture,Sporting goods,Beauty personal care and more! Largest selection from all brands at lowest price.Payment options - COD,EMI,Credit card,De', 'Sell on FlipkartAdvertiseGift CardDownload App24x7 Customer CareTrack OrderSignupLog InCART0Deals of the Day22 : 09 : 28VIEW ALLCampus Sutra...Under ₹799T-Shirts, Shirts...Body Skin CareUpto 25% + Extra 10%Lakme, Maybelline, Lotus...MonitorsExtra ₹300', '', '29 Nov 2017'),
(29, 'https://rukminim1.flixcart.com', 'Error 400 Bad Request', '', 'HTTP ERROR 400 Problem accessing /. Reason: Bad RequestPowered by Jetty://', '', '29 Nov 2017'),
(30, 'https://www.flipkart.com', 'Online Shopping Site for Mobiles, Fashion, Books, Electronics, Home Appliances and More', 'Indias biggest online store for Mobiles,Fashion(Cloths/Shoes),Electronics,Home Appliances,Books,Jewelry,Home,Furniture,Sporting goods,Beauty personal care and more! Largest selection from all brands at lowest price.Payment options - COD,EMI,Credit card,De', 'Sell on FlipkartAdvertiseGift CardDownload App24x7 Customer CareTrack OrderSignupLog InCART0Deals of the Day22 : 09 : 24VIEW ALLForme PhonesFlat ₹100 OffNow ₹599Home Decor RangeUnder ₹999Decals, Paintings moreSarees, Tops....50-80% OffE_Vastram , Kr', '', '29 Nov 2017'),
(31, 'https://www.flipkart.com?otracker=undefined_footer_navlinks', 'Online Shopping Site for Mobiles, Fashion, Books, Electronics, Home Appliances and More', 'Indias biggest online store for Mobiles,Fashion(Cloths/Shoes),Electronics,Home Appliances,Books,Jewelry,Home,Furniture,Sporting goods,Beauty personal care and more! Largest selection from all brands at lowest price.Payment options - COD,EMI,Credit card,De', 'Sell on FlipkartAdvertiseGift CardDownload App24x7 Customer CareTrack OrderSignupLog InCART0Deals of the Day22 : 09 : 11VIEW ALLForme PhonesFlat ₹100 OffNow ₹599Kitchen Appliances25-30% OffMixer Grinder Electric CookerBody Skin CareUpto 25% + Extra 10', '', '29 Nov 2017'),
(32, 'http://wvsoftek.com', ' World Vision Softek | Web2.0 - Ecommerce | Web & Mobile Apps| Wordpress Development | Enterprise IT Solutions', '', 'Home Company Profile Careers SERVICES RESPONSIVE WEB DESIGN CMS WEBSITE DEVELOPMENT WEB APPS DEVELOPMENT ECOMMERCE SOLUTIONS SOLUTIONS CONTACT .mb64 { margin-bottom: 0px !important; } .pt120 { padding-top: 30px; } .tab-content{ min-height: 110px; } Tekqui', '', '29 Nov 2017'),
(34, 'http://globe.com', 'The Boston Globe', 'A leading news source for Massachusetts, breaking news, business, sports, health, arts & entertainment, politics, education, cars, jobs, real estate & more.', 'Metro Sports Business & Tech Opinion Politics Lifestyle Arts Cars Real Estate Most popular on BostonGlobe.com Look out, wealthy Boston suburbs: Here comes the GOP tax bill In the age of Weinstein, holiday parties sober up Celtics hold off feisty Mavericks', '', '07 Dec 2017'),
(35, 'https://www.bostonglobe.com', 'The Boston Globe', 'A leading news source for Massachusetts, breaking news, business, sports, health, arts & entertainment, politics, education, cars, jobs, real estate & more.', 'Metro Sports Business & Tech Opinion Politics Lifestyle Arts Cars Real Estate Most popular on BostonGlobe.com Look out, wealthy Boston suburbs: Here comes the GOP tax bill In the age of Weinstein, holiday parties sober up Celtics hold off feisty Mavericks', '', '07 Dec 2017'),
(36, 'http://realestate.boston.com?s_campaign=bg:hp:mainnav:realestate', 'Real Estate by Boston.com and Globe.com', 'Listings of homes for sale and for rent, News about Boston and New England real estate markets, Open House schedules, Local perspective.', 'if ( \"undefined\" !== typeof googletag ) { googletag.cmd.push( function() { googletag.display(\"div-gpt-ad-lead1\"); } ); } if ( \"undefined\" !== typeof googletag ) { googletag.cmd.push( function() { googletag.display(\"div-gpt-ad-slidingbillboard\"); } ); } .b', '', '07 Dec 2017'),
(37, 'http://realestate.boston.com?s_campaign=bg:hp:well:realestate', 'Real Estate by Boston.com and Globe.com', 'Listings of homes for sale and for rent, News about Boston and New England real estate markets, Open House schedules, Local perspective.', 'if ( \"undefined\" !== typeof googletag ) { googletag.cmd.push( function() { googletag.display(\"div-gpt-ad-lead1\"); } ); } if ( \"undefined\" !== typeof googletag ) { googletag.cmd.push( function() { googletag.display(\"div-gpt-ad-slidingbillboard\"); } ); } .b', '', '07 Dec 2017');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `web`
--
ALTER TABLE `web` ADD FULLTEXT KEY `url` (`url`);
ALTER TABLE `web` ADD FULLTEXT KEY `title` (`title`);
ALTER TABLE `web` ADD FULLTEXT KEY `description` (`description`);
ALTER TABLE `web` ADD FULLTEXT KEY `body` (`body`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
