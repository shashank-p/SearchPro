<?php
function PageMain() {
	global $TMPL, $conf, $db;
	
	$all = 'Sorry, it seems that the movie you where looking for doesn\'t exist or we don\'t have it in our database...';

	$text = $_GET['a'];
	$keyword = htmlspecialchars(urldecode($_GET['q']), ENT_QUOTES);
	$filter = htmlspecialchars($_GET['f'], ENT_QUOTES);
	$order = htmlspecialchars($_GET['o'], ENT_QUOTES);
	
	// Incepe filtrul
	$qo1 = "\""; // Adauga +-ul pentru toate conditiile, exceptand cautarea exacta,
	$qo2 = "\"";  // si-ar putea fii eliminat, daca n-ar exista cautarea exacta (filtrul 4).
	if ($filter == 1) {
		$fil = "+"; // Potriveste cuvant1 + cuvant2.
		} elseif ($filter == 2) {
		$fil = "-"; // Potriveste cuvant1 dar nu si cuvant2.
		} elseif ($filter == 3) {
		$fil = "~"; // Potriveste cuvant1, dar marcheaza rezultatele ce contin cuvant2 mai putin relevante.
		} elseif ($filter == 4) {
		$qo1 = "'\""; // Folosit la cautarea exacta, cuvant-ul cautat trebuie
		$qo2 = "\"'"; // inclus neaparat intre " ", ex: "cuvant1 cuvant2";
		} else {
		$fil = ""; // Optiunea default, cand nu este nici un filtru selectat.
	}
	// Ascedent sau Descendent
	if ($order == 1) {
		$ord = "ASC";
		$TMPL['filtru'] = 'in <strong>ascending</strong> order.';
		} elseif ($order == 0) {
		$ord = "DESC";
		$TMPL['filtru'] = 'in <strong>descending</strong> order (default).';
		} else { 
		$ord = "DESC";
	}
	
	// Aranjeaza query-ul in functie de numarul cuvintelor.
	$arr = explode(' ', $keyword); 
	$wrdCount = str_word_count($keyword);
	if($wrdCount == 1) {
		$out = '+'.$arr[0].'*';
		} elseif ($wrdCount == 2) {
		$out = '+'.$arr[0].'* '.$fil.''.$arr[1].'';
		} elseif ($wrdCount >= 3) {
		$out = '+'.$arr[0].'* '.$fil.''.$arr[1].' '.implode(' ', array_slice($arr, 2)).'';
	}
	$keywordUnclean = trim(preg_replace("/&#?[a-z0-9]+;/i",'',(strip_tags($keyword))));
	$keywordClean = substr(preg_replace('/\s+/', ' ', $keywordUnclean), 0, 255);
		
	if(!empty($keywordClean) && strlen($keywordClean) >= 3) {
		
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		$keywordUnclean = trim(preg_replace("/&#?[a-z0-9]+;/i",'',(strip_tags($keyword))));
		$keywordClean = substr(preg_replace('/\s+/', ' ', $keywordUnclean), 0, 255);
		
		$selectKeyword = "SELECT * FROM keywords WHERE keyword = '$keywordClean'";
		if(mysqli_fetch_row(mysqli_query($db, $selectKeyword)) == NULL) {
		$keywordQuery = sprintf("INSERT INTO `keywords` (`keyword`, `count`) VALUES ('%s', '1')", mysqli_real_escape_string($db, $keywordClean));
		mysqli_query($db, $keywordQuery); 
		} else {
		$keywordQuery = sprintf("UPDATE `keywords` SET `count` = `count` + 1 WHERE keyword = '%s'", mysqli_real_escape_string($db, $keywordClean));
		mysqli_query($db, $keywordQuery);
		}
		
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		$trimKeyword = str_replace(' ', '', $keywordClean);
		$per_page = 20;
		if(!ctype_alpha($trimKeyword)) {
			$page_query = mysqli_query($db, 'SELECT count(title) FROM web WHERE title LIKE \'%%'.$keywordClean.'%\' or url LIKE \'%%'.$keywordClean.'%\' ORDER BY title '.$ord.'');
			$results = mysqli_fetch_array($page_query);
			$pages = ceil($results[0] / $per_page);
			if($results[0] == 0) {
				$TMPL['error'] = '<strong>Whops, something went wrong...</strong>. <br /><br />Please make sure your query meets the following:
				<ul>
					<li>Your query is higher than two characters.</li>
					<li>Your query is as descriptive as possible.</li>
					<li>Try different combination of the keywords.</li>
				</ul>';
			}
		} else {
			$page_query = mysqli_query($db, 'SELECT count(url), (MATCH(url) AGAINST('.$qo1.''.$out.''.$qo2.' IN BOOLEAN MODE) * 0.45 + MATCH(title) AGAINST ('.$qo1.''.$out.''.$qo2.' IN BOOLEAN MODE) * 0.35 + MATCH(description,body) AGAINST('.$qo1.''.$out.''.$qo2.' IN BOOLEAN MODE) * 0.20) AS relevance
			FROM web
			WHERE MATCH(url, title, description, body) AGAINST ('.$qo1.''.$out.''.$qo2.' IN BOOLEAN MODE)
			ORDER BY relevance '.$ord.'');
			$results = mysqli_fetch_array($page_query);
			$pages = ceil($results[0] / $per_page);
			if($results[0] == 0) {
				$TMPL['error'] = '<strong>Whops, something went wrong...</strong>. <br /><br />Please make sure your query meets the following:
				<ul>
					<li>Your query is higher than two characters.</li>
					<li>Your query is as descriptive as possible.</li>
					<li>Try different combination of the keywords.</li>
				</ul>';
			}
		}
		
		$page = (isset($_GET['page']) AND (int)$_GET['page'] > 0) ? (int)$_GET['page'] : 1;
		$start = ($page - 1) * $per_page;
		
		$starttime = microtime(true);
				
		if(!ctype_alpha($trimKeyword)) {
			$query = 'SELECT * FROM web WHERE title LIKE \'%%'.$keywordClean.'%\' or url LIKE \'%%'.$keywordClean.'%\' ORDER BY title '.$ord.' LIMIT '.$start.','.$per_page.'';
			#echo htmlentities($query);
			} else {
			$query = '
			SELECT *, (MATCH(url) AGAINST('.$qo1.''.$out.''.$qo2.' IN BOOLEAN MODE) * 0.45 + MATCH(title) AGAINST ('.$qo1.''.$out.''.$qo2.' IN BOOLEAN MODE) * 0.35 + MATCH(description,body) AGAINST('.$qo1.''.$out.''.$qo2.' IN BOOLEAN MODE) * 0.20) AS relevance
			FROM web
			WHERE MATCH(url, title, description, body) AGAINST ('.$qo1.''.$out.''.$qo2.' IN BOOLEAN MODE)
			ORDER BY relevance '.$ord.' LIMIT '.$start.','.$per_page.'';
			#echo htmlentities($query);
		}
				
		$result = mysqli_query($db, $query);
		$endtime = microtime(true);
		$duration = $endtime - $starttime;
		$TMPL['duration'] = substr($duration, 0, 6);
			
			$TMPL_old = $TMPL; $TMPL = array();
			$skin = new skin('search/rows'); $all = '';
			while($TMPL = mysqli_fetch_assoc($result)) {
				// Title
				$TMPL['site_url'] = $conf['url'];
				
				$TMPL['title'] = highlightWords(substr($TMPL['title'], 0, 64), $keyword);
				if(strlen($TMPL['title']) >= 64) { $TMPL['title'] = $TMPL['title'].'...';}
				
				// Description & Body	
				$TMPL['description'] = highlightWords(substr($TMPL['description'], 0, 200), $keyword);
				$TMPL['body'] = highlightWords(substr($TMPL['body'], 0, 200), $keyword);
				if(!empty($TMPL['description'])) {
					if(strlen($TMPL['description']) >= 200) { $TMPL['description'] = $TMPL['description'].'...';}
				} else { 
					if(strlen($TMPL['body']) >= 200) { $TMPL['description'] = $TMPL['body'].'...';} else { $TMPL['description'] = $TMPL['body']; }
				}
				
				// Author
				if(empty($TMPL['author'])) { $TMPL['authors'] = '';} else { $TMPL['authors'] = ' - <img src="'.$conf['url'].'/images/res_aut.png" height="10" width="10" />'.$TMPL['author'].'';}
				
				// Url
				$TMPL['urlCite'] = strtolower(highlightWords($TMPL['url'], $keyword));
				
				$all .= $skin->make();
			}
			
			// Incepe paginarea
			
			$skin = new skin('shared/pagination'); $pagination = '';
			if ($pages >= 1 && $page <= $pages) {
				$filterPag = $filter;
				$orderPag = $order;
				if (empty($orderPag)) {
					$orderPag = '';
				} else {
					$orderPag = '&o='.$order.'';
				}
				$filterPag = $filter;
				if (empty($filterPag)) {
					$filterPag = '';
				} else {
					$filterPag = '&f='.$filter.'';
				}
				foreach(range(1, $pages) as $page) {
					// Check if we're on the current page in the loop
					if($page == $_GET['page'] || $page == 1 && !isset($_GET['page'])) {
						$TMPL['pagination'] .= '<a href="'.$conf['url'].'/index.php?a=search&q='.urlencode($keyword).'&page='.$page.''.$filterPag.''.$orderPag.'" class="pagination-active">'.$page.'</a> ';
					} else if($page == 1 || $page == $pages || ($page >= $_GET['page'] - 9 && $page <= $_GET['page'] + 9)) {
						$TMPL['pagination'] .= '<a href="'.$conf['url'].'/index.php?a=search&q='.urlencode($keyword).'&page='.$page.''.$filterPag.''.$orderPag.'">'.$page.'</a> ';
					}
				}
				$pagination = $skin->make();
			}
			$TMPL = $TMPL_old; unset($TMPL_old);
			
			$TMPL['rows'] = $all;
			$TMPL['pagination'] = $pagination;
			
			$text = 'content';
		} else { 
		$TMPL_old = $TMPL; $TMPL = array();
			$skin = new skin('search/error');
			$all .= $skin->make();			
			$TMPL = $TMPL_old; unset($TMPL_old);
			
			$TMPL['error'] = '<strong>What are you looking for?</strong> <br /><br />Some tips:
			<ul>
				<li>Be as descriptive as possible.</li>
				<li>Make sure you try different combination of keywords.</li>
				<li>Your query must be longer than two characters.</li>
			</ul>';
			
			$text = 'content';
		}
	if(!empty($_GET['f'])) {
	$TMPL['f'] = '&f='.$_GET['f'].'';
	}
	if(!empty($_GET['o'])) {
	$TMPL['o'] = '&o='.$_GET['o'].'';
	}
	$queryAds = "SELECT ad2,ad3,title from users where id = '1'";
	$resultAds = mysqli_fetch_row(mysqli_query($db, $queryAds));
	
	if(!empty($resultAds[0])) { $TMPL['ad2'] = '<div class="adSpace2">'.$resultAds[0].'</div>'; } else { $TMPL['ad2'] = ''; }
	if(!empty($resultAds[1])) { $TMPL['ad3'] = '<div class="adSpace3">'.$resultAds[1].'</div>'; } else { $TMPL['ad3'] = ''; }
	
	$TMPL['query'] = $keyword;
	$TMPL['title'] = $keyword.' - '.$resultAds[2].'';

	$skin = new skin("search/$text");
	return $skin->make();
}
?>