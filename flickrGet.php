<?php
/*
 * Created on 9/07/2011
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

// Get the flixkr images
function loadFlickr($geocode) {
	global $results;
	
	$flickrParts = explode(',', $geocode);
	$flurl = "http://api.flickr.com/services/rest/?method=flickr.photos.search&api_key=76904a42e0e0a2b7eeaf037c8ec2e00b&lat=$flickrParts[0]&lon=$flickrParts[1]&radius=32&radius_units=km&extras=url_m,geo&format=json&nojsoncallback=1&accuracy=3";
	
	// fprintf(STDERR, "Flickr: %s\n", $flurl);
	
	// create a new cURL resource
	$ch = curl_init();
	
	// set URL and other appropriate options
	curl_setopt($ch, CURLOPT_URL, $flurl);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	
	$flickrData = curl_exec($ch);

	// fprintf(STDERR, "Flickr returned %s\n", $flickrData);
		
	if(!$flickrData) {
		fprintf(STDERR, "$flurl returned nothing\n");
		return;
	}
		
	// close cURL resource, and free up system resources
	curl_close($ch);
	
	// var_dump($flickrData);
	
	$flres = json_decode($flickrData);
	
	// var_dump($flres);
	
	$photo = $flres->{'photos'}->{'photo'};
	foreach($photo as $phiidx => $photitm) {
		$results[] = array('url' =>$photitm->{'url_m'}, 'text'=> $photitm->{'title'}, 
			'from_user' => $photitm->{'owner'}, 'lat' => $photitm->{'latitude'}, 'lon' => $photitm->{'longitude'});
	}		
}

?>
