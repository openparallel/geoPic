<?php
/*
 * twitterLocalImgs demo
 * 
 * Get images with the request:
 * /twitterLocalImgs.php?geocode=lat,lon,dist&firstpage=N&lastpage=M
 * 
 */

require_once 'loadPage.php';
require_once 'flickrGet.php';

$geocode = $_GET['geocode'];
$firstpage = $_GET['firstpage'];
$lastpage=$_GET['lastpage'];

$twurl = "http://search.twitter.com/search.json?geocode=$geocode&result_type=recent&rpp=100";

//$twurl = 'http://search.twitter.com/search.json?geocode=-41.2884,174.784,200km&result_type=recent&rpp=100';
//$twurl = 'http://search.twitter.com/search.json?geocode=52,0,60km';

// TODO: replace the following with parallel_for
global $results;
$results = array();

loadFlickr($geocode);

for($tpg=$firstpage; $tpg<=$lastpage; $tpg++) {
	loadPage($twurl, $tpg);
}


echo json_encode($results);

?>