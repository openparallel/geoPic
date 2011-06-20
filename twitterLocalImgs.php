<?php
/*
 * Created on 16/06/2011
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

$twurl = 'http://search.twitter.com/search.json?geocode=-41.2884,174.784,30km';
while(true) {
	echo "Requesting $twurl\n";
	$twitterData = file_get_contents($twurl);
	// echo $twitterData;
	
	$twres = json_decode($twitterData);
	
	// var_dump($twres);
	$results = $twres->{'results'};
	// var_dump($results);
	
	foreach($results as $twidx => $tweet) {
		//echo $twidx . ", " . $tweet->geo . "\n";
		if(!is_null($tweet->geo)) {
			$twtxt = $tweet->text;
			$urlPos = strpos($twtxt, 'http://');
			
			if($urlPos !== FALSE) {
		         echo "$twtxt\npos: ($urlPos)\n";
				 var_dump($tweet->geo);
			}
		}
	}
	
	if(is_null($twres->next_page)) return;
	
	$twurl = 'http://search.twitter.com/search.json' . $twres->next_page;
}

?>