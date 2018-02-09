<?php
require_once('./includes/config.php');
require_once('./includes/skins.php');
require_once('./includes/functions.php');

$db = @mysqli_connect($conf['host'], $conf['user'], $conf['pass'], $conf['name']);
mysqli_query($db, 'SET NAMES utf8');

if(!$db) {	
	echo "Failed to connect to MySQL: (" . mysqli_connect_errno() . ") " . mysqli_connect_error();
}

if ($_GET['a'] == 'search') {
	$TMPL['search'] = '<div class="headerContent">
	<form action="" method="get" onsubmit="document.location=\''.$conf['url'].'/index.php?a=search&q=\'+document.getElementById(\'q\').value;return false;">
	<input type="text" id="q" value="'.$_GET['q'].'" size="30" />
	<input type="submit" value="Search" />
	</form>
	</div>';
	$TMPL['logo'] = 'logo_s';
	$TMPL['contentStyle'] = 'contentSearch';
	} else {
	$TMPL['search'] = '<div class="headerContent"><div class="headerMenu"><a href="'.$conf['url'].'/index.php?a=addurl">Add url</a></div></div>';
	$TMPL['logo'] = 'logo_d';
	$TMPL['contentStyle'] = 'content';
	}
	
if(isset($_GET['a']) && isset($action[$_GET['a']])) {
	$page_name = $action[$_GET['a']];
	} else {
	$page_name = 'welcome'; 
	}
require_once("./sources/{$page_name}.php");

$TMPL['url'] = $conf['url'];
$TMPL['content'] = PageMain();

$queryAds = "SELECT title from users where id = '1'";
$resultAds = mysqli_fetch_row(mysqli_query($db, $queryAds));

$TMPL['footer'] = $resultAds[0];

$skin = new skin('wrapper');
echo $skin->make();

mysqli_close($db);
?>