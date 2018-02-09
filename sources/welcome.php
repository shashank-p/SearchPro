<?php
function PageMain() {
	global $TMPL, $conf, $db;

	$TMPL_old = $TMPL; $TMPL = array();
	$skin = new skin('welcome/rows'); $all = '';
	$query = 'SELECT keyword, count from keywords WHERE keyword !="Search..." ORDER BY 2 DESC LIMIT 0,15';
	$result = mysqli_query($db, $query);
	while($TMPL = mysqli_fetch_assoc($result)) {
		$TMPL['url'] = $conf['url'];
		$all .= $skin->make();
	}
	$TMPL = $TMPL_old; unset($TMPL_old);
	$TMPL['rows'] = $all;

	$queryAds = "SELECT ad1,title from users where id = '1'";
	$resultAds = mysqli_fetch_row(mysqli_query($db, $queryAds));
	
	if(!empty($resultAds[0])) { $TMPL['ad1'] = '<div class="adSpace1">'.$resultAds[0].'</div>'; } else { $TMPL['ad1'] = ''; }
	
	$TMPL['title'] = $resultAds[1];

	$skin = new skin('welcome/content');
	return $skin->make();
}
?>