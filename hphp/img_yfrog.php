<?php
/*
 * Created on 19/06/2011
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


function img_yfrog($srcUrl) {
	$rs = strrev($srcUrl);
	$lchar = $rs[0];
	// echo "rs: $rs, lchar: $lchar\n";
	
	if(strstr("jpbtg", $lchar)) {
		return $srcUrl . ":iphone";
	}
	
	return null;
}

?>

 