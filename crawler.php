<?php
require_once('./includes/config.php');
require_once('./includes/functions.php');
set_time_limit(500);
error_reporting(-1);	
header('Content-Type: text/plain; charset=utf-8;');

$db = @mysqli_connect($conf['host'], $conf['user'], $conf['pass'], $conf['name']);
mysqli_query($db, 'SET NAMES utf8');

if(!$db) {	
	echo "Failed to connect to MySQL: (" . mysqli_connect_errno() . ") " . mysqli_connect_error();
}

///////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////MASS CRAWLER - USAGE: Insert links separated by commas.////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////

$url = array('http://WEBSITE.com', 'http://WEBSITE.net', 'WEBSITE.org');

foreach($url as $k) {
	$url = parse_url($k);
	if(!isset($url['path'])) {
		$selectData = "SELECT * FROM web WHERE url = '$k'";
		if(mysqli_fetch_row(mysqli_query($db, $selectData)) == null) {
			$content = getUrl($k);
			preg_match('#<title>(.*)</title>#i', $content, $title);
			preg_match_all('/<img src=.([^"\' ]+)/', $content, $img);
			preg_match('/<head>.+<meta name="description" content=.([^"\']+)/is', $content, $description);
			preg_match('/<head>.+<meta name="author" content=.([^"\']+)/is', $content, $author);
			#preg_match_all('/href=.([^"\' ]+)/i', $content, $anchor);
			preg_match('/<body.*?>(.*?)<\/body>/is', $content, $body);
			if(!empty($title[1]) AND !empty($description[1]) || !empty($body[1])) {
				echo 'Titlu: '; @print_r($title[1]);
				echo "\n";
				$body_trim = trim(preg_replace("/&#?[a-z0-9]+;/i",'',(strip_tags(@$body[0])))); $bodyContent = substr(preg_replace('/\s+/', ' ', $body_trim), 0, 255);
				
				$description_trim = trim(preg_replace("/&#?[a-z0-9]+;/i",'',(strip_tags(@$description[1])))); $descContent = substr(preg_replace('/\s+/', ' ',$description_trim), 0, 255);
				
				$bodyContent = str_replace('\'', '', $bodyContent);
				$descContent = str_replace('\'', '', $descContent);
				echo 'Description: '; @print_r($descContent);
				echo "\n";
				echo 'Author: '; @print_r($author[1]);
				echo "\n";
				echo 'URL: '; @print_r($k); $date = date("d M Y");
				echo "\n";
				echo "\n---------------------------------------------------------------------------\n";
				$insertData = "INSERT INTO `web` (`url` ,  `title` ,  `description` ,  `body` ,  `author`, `date`) VALUES ('".$k."', '".@$title[1]."', '".@$descContent."', '".@$bodyContent."', '".@$author[1]."', '".$date."')";
				#echo $insertData;
				mysqli_query($db, $insertData);
			}
		}
	}
}
?>