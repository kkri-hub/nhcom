<?php

//////////////////////////////////////////////////////////////////////////////////////////

$form = array();

$form["name"] = array("label"=>getTxt("name"));
$form["email"] = array("label"=>getTxt("emailAddress"));
$form["tel"] = array("label"=>getTxt("tel"));

if (LANG != LANG_JA) {
	$form["country"] = array("label"=>getTxt("country"));
	$form["url"] = array("label"=>"URL");
}

$form["inquiry"] = array("label"=>getTxt("inquiryContents"));

//////////////////////////////////////////////////////////////////////////////////////////

?>