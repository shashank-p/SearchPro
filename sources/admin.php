<?php
function PageMain() {
	global $TMPL, $conf, $db;
	
	$time = time()+86400;
	$exp_time = time()-86400;
	
	$TMPL['loginForm'] = '
	<form action="'.$conf['url'].'/index.php?a=admin" method="post">
	Username: <input type="text" name="username" /><br />
	Password: <input type="password" name="password" /><br /><br />
	<input type="submit" value="Log In" name="login"/>
	</form>
	<div class="addurlSmall">Note: The password is case-sensitive.</div>';
	
	if(isset($_POST['login'])) {
		header("Location: ".$conf['url']."/index.php?a=admin");
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		setcookie("username", $username, $time);
		setcookie("password", $password, $time);
				
		$query = sprintf('SELECT * from users where username = "%s" and password ="%s"', mysqli_real_escape_string($db, $_COOKIE['username']), md5(mysqli_real_escape_string($db, $_COOKIE['password'])));
	} elseif(isset($_COOKIE['username']) && isset($_COOKIE['password'])) { 
		$query = sprintf('SELECT * from users where username = "%s" and password ="%s"', mysqli_real_escape_string($db, $_COOKIE['username']), md5(mysqli_real_escape_string($db, $_COOKIE['password'])));
	
		if(mysqli_fetch_row(mysqli_query($db, $query))) {
			$TMPL['success'] = '<div class="success">Welcome <strong>'.$_COOKIE['username'].'</strong>, <a href="'.$conf['url'].'/index.php?a=admin&logout=1">Log Out</a></div>';
			$TMPL['rowsTitle'] = '<h3>Top 15 Keywords</h3><div class="addurlSmall">Delete one or more keywords by clicking the <strong>X</strong> sign.<br /><br /></div>';
			$TMPL['loginForm'] = '';
			
			$TMPL_old = $TMPL; $TMPL = array();
			$skin = new skin('admin/ads'); $ads = '';
			$query = 'SELECT ad1,ad2,ad3 from users';
			$result = mysqli_query($db, $query);
			if(isset($_POST['ads1']) || isset($_POST['ads2']) || isset($_POST['ads3'])) {
				$query = 'UPDATE `users` SET ad1 = \''.$_POST['ads1'].'\', ad2 = \''.$_POST['ads2'].'\', ad3 = \''.$_POST['ads3'].'\' WHERE username = \''.$_COOKIE['username'].'\'';
				mysqli_query($db, $query);
				header("Location: ".$conf['url']."/index.php?a=admin");
			}
			while($TMPL = mysqli_fetch_assoc($result)) {
				$TMPL['url'] = $conf['url'];
				$ads .= $skin->make();
			}
			
			$skin = new skin('admin/rows'); $all = '';
			$query = 'SELECT id,keyword, count from keywords WHERE keyword !="Search..." ORDER BY count DESC LIMIT 0,15';
			$result = mysqli_query($db, $query);
			while($TMPL = mysqli_fetch_assoc($result)) {
				$TMPL['url'] = $conf['url'];
				$all .= $skin->make();
			}
				if(isset($_GET['delete'])) {
					$delQuery = 'DELETE from `keywords` where id = '.$_GET['delete'].'';
					mysqli_query($db, $delQuery);
					header("Location: ".$conf['url']."/index.php?a=admin");
				}
			
			$skin = new skin('admin/remove'); $remove = '';
			$TMPL['url'] = $conf['url'];
			if(isset($_POST['remove'])) {
				$query = 'DELETE from web WHERE id = "'.$_POST['remove'].'"';
				mysqli_query($db, $query);
				header("Location: ".$conf['url']."/index.php?a=admin");
			}
			$remove .= $skin->make();
			
			$skin = new skin('admin/title'); $title = '';
			$TMPL['url'] = $conf['url'];
			$queryTitle = "SELECT title from users where id = '1'";
			$resultTitle = mysqli_fetch_row(mysqli_query($db, $queryTitle));	
			$TMPL['currentTitle'] = $resultTitle[0];
			
			if(isset($_POST['title'])) {
				$query = 'UPDATE `users` SET title = \''.$_POST['title'].'\' WHERE username = \''.$_COOKIE['username'].'\'';
				mysqli_query($db, $query);
				header("Location: ".$conf['url']."/index.php?a=admin");
			}
			$siteTitle .= $skin->make();
			
			$skin = new skin('admin/add'); $title = '';
			$TMPL['url'] = $conf['url'];
			if(isset($_POST['addtitle']) && isset($_POST['addurl']) && isset($_POST['adddesc'])) {
				$url = parse_url($_POST['addurl']);
				$date = date("d M Y");
				$query = "INSERT INTO `web` (`url` ,  `title` ,  `description`, `date`) VALUES ('http://".$url['host']."', '".$_POST['addtitle']."', '".$_POST['adddesc']."', '".$date."')";
				mysqli_query($db, $query);
				header("Location: ".$conf['url']."/index.php?a=admin");
			}
			$add .= $skin->make();
						
			$skin = new skin('admin/password'); $password = '';
			$TMPL['url'] = $conf['url'];
			if(isset($_POST['pwd'])) {
				$pwd = md5($_POST['pwd']);
				$query = 'UPDATE `users` SET password = \''.$pwd.'\' WHERE username = \''.$_COOKIE['username'].'\'';
				mysqli_query($db, $query);
				header("Location: ".$conf['url']."/index.php?a=admin");
			}
			$password .= $skin->make();
		
			$TMPL = $TMPL_old; unset($TMPL_old);
			$TMPL['add'] = $add;
			$TMPL['rows'] = $all;
			$TMPL['ads'] = $ads;
			$TMPL['remove'] = $remove;
			$TMPL['password'] = $password;
			$TMPL['siteTitle'] = $siteTitle;
			
			if(isset($_GET['logout']) == 1) {
				setcookie('username', '', $exp_time);
				setcookie('password', '', $exp_time);
				header("Location: ".$conf['url']."/index.php?a=admin");
				}
			} else { 
			$TMPL['error'] = '<div class="error">Invalid username or password. Remember that the password is case-sensitive.</div>';
			unset($_COOKIE['username']);
			unset($_COOKIE['password']);
		}			
	}
	$queryTitle = "SELECT title from users where id = '1'";
	$resultTitle = mysqli_fetch_row(mysqli_query($db, $queryTitle));
	
	$TMPL['title'] = 'Admin - '.$resultTitle[0].'';

	$skin = new skin('admin/content');
	return $skin->make();
}
?>