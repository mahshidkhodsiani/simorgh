<?php


echo "<pre>";
var_dump($_SERVER['REQUEST_URI']);


$CurUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$CurUrl = substr($CurUrl,0, strrpos($CurUrl, '/')+1);


var_dump($CurUrl);