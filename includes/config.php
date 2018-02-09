<?php
set_time_limit(-1);
error_reporting(0);
#setlocale(LC_CTYPE, 'cs_CZ'); // ICONV pe GLIB 2.5 (Altfe rezulta "?" la diacritice)

$conf = $TMPL = array();
$conf['host'] = 'localhost';
$conf['user'] = 'root';
$conf['pass'] = '';
$conf['name'] = 'searchpro';
$conf['url'] = 'http://localhost/searchpro/';

$action = array('search'		=> 'search',
				'addurl'		=> 'addurl',
				'admin'			=> 'admin',
				'privacy'       => 'page',
				'disclaimer'	=> 'page',
				'contact'       => 'page',
				'error'			=> 'page',
				'tos'			=> 'page'
				);
?>