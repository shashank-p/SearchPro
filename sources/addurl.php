<?php
function PageMain() {
	global $TMPL, $conf, $db;
	
	$text = $_GET['a'];
	$addurl = htmlspecialchars(urldecode($_GET['q']), ENT_QUOTES);
	$url = $_POST['url'];
	$urls = array($_POST['urls']);
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	if(isset($_POST['url'])) {	
		$content = getUrl($url);
		preg_match('#<title>(.*)</title>#i', $content, $title);
		preg_match_all('/<img src=.([^"\' ]+)/', $content, $img);
		preg_match('/<head>.+<meta name="description" content=.([^"\']+)/is', $content, $description);
		preg_match('/<head>.+<meta name="author" content=.([^"\']+)/is', $content, $author);
		preg_match_all('/href=.([^"\' ]+)/i', $content, $anchor);
		preg_match('/<body.*?>(.*?)<\/body>/is', $content, $body);

		$body_trim = trim(preg_replace("/&#?[a-z0-9]+;/i",'',(strip_tags(@$body[0])))); $bodyContent = substr(preg_replace('/\s+/', ' ', $body_trim), 0, 255);
		
		$description_trim = trim(preg_replace("/&#?[a-z0-9]+;/i",'',(strip_tags(@$description[1])))); $descContent = substr(preg_replace('/\s+/', ' ', $description_trim), 0, 255);	
		
		$bodyContent = str_replace('\'', '', $bodyContent);
		$descContent = str_replace('\'', '', $descContent);
		$date = date("d M Y");
		$purl = parse_url($url);
		if(!isset($purl['path'])) {	
				$selectData = sprintf("SELECT * FROM web WHERE url = '%s'", mysqli_real_escape_string($db, $url));
				if(mysqli_fetch_row(mysqli_query($db, $selectData)) == null) {
					if(!empty($title[1]) AND !empty($description[1]) || !empty($body[1])) {
						$insertData = "INSERT INTO `web` (`url` ,  `title` ,  `description` ,  `body` ,  `author`, `date`) VALUES ('".$url."', '".@$title[1]."', '".@$descContent."', '".$bodyContent."', '".$author[1]."', '".$date."')";
						mysqli_query($db, $insertData);
						$TMPL['success'] = '<div class="success">You have successfuly added <strong>'.$url.'</strong> to our search engine.</div>';
					}
				} else {
				$TMPL['error'] = '<div class="error">The <strong>'.$url.'</strong> is already in our database.</div>';
				}
			}
	}
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	if(isset($_POST['urls'])) {
		foreach($urls as $url) {
			$content = getUrl($url);
			preg_match('#<title>(.*)</title>#i', $content, $title);
			preg_match_all('/<img src=.([^"\' ]+)/', $content, $img);
			preg_match('/<head>.+<meta name="description" content=.([^"\']+)/is', $content, $description);
			preg_match('/<head>.+<meta name="author" content=.([^"\']+)/is', $content, $author);
			preg_match_all('/href=.([^"\' ]+)/i', $content, $anchor);
			preg_match('/<body.*?>(.*?)<\/body>/is', $content, $body);

			$body_trim = trim(preg_replace("/&#?[a-z0-9]+;/i",'',(strip_tags(@$body[0])))); $bodyContent = substr(preg_replace('/\s+/', ' ', $body_trim), 0, 255);
			$description_trim = trim(preg_replace("/&#?[a-z0-9]+;/i",'',(strip_tags(@$description[1])))); $descContent = substr(preg_replace('/\s+/', ' ', $description_trim), 0, 255);	
			
			$bodyContent = str_replace('\'', '', $bodyContent);
			$descContent = str_replace('\'', '', $descContent);
			
			$date = date("d M Y");
			$purl = parse_url($url);
			
			if(!isset($purl['path'])) {
				$selectData = "SELECT * FROM web WHERE url = '$url'";
				if(mysqli_fetch_row(mysqli_query($db, $selectData)) == null) {
					if(!empty($title[1]) AND !empty($description[1]) || !empty($body[1])) {				
						$insertData = "INSERT INTO `web` (`url` ,  `title` ,  `description` ,  `body` ,  `author`, `date`) VALUES ('".$url."', '".@$title[1]."', '".@$descContent."', '".@$bodyContent."', '".@$author[1]."', '".$date."')";
						mysqli_query($db, $insertData);
						$TMPL['success'] = '<div class="success">You have successfuly added '.$url.' and/or other domains to our search engine.</div>';
					}
				} else {
				$TMPL['error'] = '<div class="error">The '.$url.' is already in our database.</div>';
				}
			}
			foreach($anchor[1] as $k) {
				$content = getUrl($k);
				$url = parse_url($k);		
				if(!isset($url['path'])) {
					$selectData = "SELECT * FROM web WHERE url = '$k'";
					if(mysqli_fetch_row(mysqli_query($db, $selectData)) == null) {
						preg_match('#<title>(.*)</title>#i', $content, $title);
						preg_match_all('/<img src=.([^"\' ]+)/', $content, $img);
						preg_match('/<head>.+<meta name="description" content=.([^"\']+)/is', $content, $description);
						preg_match('/<head>.+<meta name="author" content=.([^"\']+)/is', $content, $author);
						preg_match_all('/href=.([^"\' ]+)/i', $content, $anchor);
						preg_match('/<body.*?>(.*?)<\/body>/is', $content, $body);
						if(!empty($title[1]) AND !empty($description[1]) || !empty($body[1])) {
							$description_trim = trim(preg_replace("/&#?[a-z0-9]+;/i",'',(strip_tags(@$description[1])))); $descContent = substr(preg_replace('/\s+/', ' ', $description_trim), 0, 255);	
							$date = date("d M Y");
							$body_trim = trim(preg_replace("/&#?[a-z0-9]+;/i",'',(strip_tags(@$body[0])))); $bodyContent = substr(preg_replace('/\s+/', ' ', $body_trim), 0, 255);
							
							$bodyContent = str_replace('\'', '', $bodyContent);
							$descContent = str_replace('\'', '', $descContent);
							
							$insertData = "INSERT INTO `web` (`url` ,  `title` ,  `description` ,  `body` ,  `author`, `date`) VALUES ('".$k."', '".@$title[1]."', '".@$descContent."', '".@$bodyContent."', '".@$author[1]."', '".$date."')";
							mysqli_query($db, $insertData);
						}
					}
				}
			}
		}
	}
	
	$text = 'content';
		
	$queryTitle = "SELECT title from users where id = '1'";
	$resultTitle = mysqli_fetch_row(mysqli_query($db, $queryTitle));
	
	$TMPL['title'] = 'Add URL - '.$resultTitle[0].'';

	$skin = new skin("addurl/$text");
	return $skin->make();
}
?>