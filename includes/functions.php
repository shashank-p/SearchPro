<?php
function highlightWords($string, $keyword)
{
	$keywords = explode(' ', $keyword); 
	foreach ($keywords as $word) {
		$string = str_ireplace($word, '<strong>'.$word.'</strong>', $string);
	}
	return $string;
}

function getUrl($url) {
	if(@function_exists('curl_init')) {
		$cookie = tempnam ("/tmp", "CURLCOOKIE");
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; CrawlBot/1.0.0)');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT	, 5);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_ENCODING, "");
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    # required for https urls
		curl_setopt($ch, CURLOPT_MAXREDIRS, 15);			
		$site = curl_exec($ch);
		curl_close($ch);
		} else {
		global $site;
		$site = file_get_contents($url);
	}
	return $site;
};
?>