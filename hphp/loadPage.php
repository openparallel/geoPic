<?php
/*
 * Created on 5/07/2011
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
require_once('shorteners.php');
require_once('imageServices.php');


//
// Load a page of tweets, scan for images and put in $results
//
function loadPage($baseurl, $page) {
	global $shorteners, $imageServices, $results;
	
	$fullurl = "$baseurl&page=$page";
	fprintf(STDERR, "Requesting $fullurl\n");
	// create a new cURL resource
	$ch = curl_init();
	
	// set URL and other appropriate options
	curl_setopt($ch, CURLOPT_URL, $fullurl);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	
	$twitterData = curl_exec($ch);
	
	if(!$twitterData) {
		fprintf(STDERR, "Twitter $fullurl returned nothing\n");
		return;
	}
	
	// close cURL resource, and free up system resources
	curl_close($ch);
	
	$twres = json_decode($twitterData);
	
	// var_dump($twres);
	
	if(!property_exists($twres, 'results')) return;
	
	$tweets = $twres->{'results'};
	// var_dump($tweets);
	if(null==$tweets) {
		//echo "$fullurl returned [$twitterData] with no tweets\n";
		return;
	}
	
	foreach($tweets as $twidx => $tweet) {
		//echo $twidx . ", " . $tweet->geo . "\n";
		if(is_null($tweet->geo)) continue;
		
		$twtxt = $tweet->text;
		$urlPos = strpos($twtxt, 'http://');
		
		if($urlPos == FALSE) continue;
          //echo "$twtxt\npos: ($urlPos)\n";
         
		 $matches = array();
		 // reg out http
		 // does an ungreedy match for a string starting with http://
		 // and ending with space or endline
		 // the space doesn't get captured'
		 preg_match_all("/(http\:\/\/.+?)(?:\s|$)/", $twtxt, $urls);
		 // var_dump($urls);
		 
		 foreach($urls[1] as $url) {
		 	$hostpart = extract_host($url);
		 	
			if(array_key_exists($hostpart, $shorteners)) {
				$ch = curl_init();
		
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_HEADER, TRUE);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
				
				$redirect = curl_exec($ch);
				// echo "$redirect\n";
				
				preg_match("/Location\:\s+(.+?)$/m", $redirect, $extract);
				if(count($extract) < 2)
					continue;
					
				$fullurl = trim($extract[1]);
				// echo "Shortened: $url:\n => $fullurl\n";
			}
			else {
				// echo "Full: $url hostpart=$hostpart\n";
				$fullurl = $url;
			}
			
			$hostpart = extract_host($fullurl);
			if($hostpart==null)
				continue;
				
			// echo "hostpart now: $hostpart\n";
			if(array_key_exists($hostpart, $imageServices)) {
				//echo "Run $imageServices[$hostpart]\n ( $fullurl ) \n";
				$imgurl = $imageServices[$hostpart]($fullurl);
				
			if($imgurl!=NULL) {
				//echo $imgurl . "\n";
				$results[] = array('url' =>$imgurl, 'text'=> $twtxt, 'from_user' => $tweet->from_user, 
					'lat' => $tweet->geo->{'coordinates'}[0], 'lon' => $tweet->geo->{'coordinates'}[1]);
				}
			}
		}
	}
}
		
//
// Extract the hostname from a URL
//
function extract_host($src) {
	preg_match("/http\:\/\/(.+?)/", $src, $comps);
	
	if(count($comps)<2) {
		fprintf(STDERR, "$src did not parse to host\n");
		return null;
	}
	
	return $comps[1];
}

?>
