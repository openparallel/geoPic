<?php
/*
 * Created on 19/06/2011
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


function img_twitpic($srcUrl) {
	$lslash = strrpos($srcUrl, '/');
	if($lslash=== FALSE)
		return NULL;

	$tpcode = substr($srcUrl, $lslash+1);
	// echo "lslash=$lslash, tpcode=$tpcode\n";
	
	return "http://twitpic.com/show/thumb/" . $tpcode . ".jpg";
}

?>