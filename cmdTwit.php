<?php
/*
 * Created on 5/07/2011
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


require_once 'loadPage.php';

$geocode = "-41.2884,174.784,200km";
$firstpage = 1;
$lastpage=100;

$twurl = "http://search.twitter.com/search.json?geocode=$geocode&result_type=recent&rpp=100";

//$twurl = 'http://search.twitter.com/search.json?geocode=-41.2884,174.784,200km&result_type=recent&rpp=100';
//$twurl = 'http://search.twitter.com/search.json?geocode=52,0,60km';

// TODO: replace the following with parallel_for
global $results;
$results = array();

for($tpg=$firstpage; $tpg<=$lastpage; $tpg++) {
	loadPage($twurl, $tpg);
}

var_dump($results);

?>