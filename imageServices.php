<?php
/*
 * Created on 19/06/2011
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

require 'img_yfrog.php';
require 'img_instagram.php';
require 'img_twitpic.php';

global $imageServices;

$imageServices = array("yfrog.com" => 'img_yfrog',
	'instagr.am' => 'img_instagram',
	'twitpic.com' => 'img_twitpic');

?>
