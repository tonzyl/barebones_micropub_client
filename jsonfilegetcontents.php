<?php
/* This is a barebones micropub client script*/
/* I use this to include in scripts that create the posts to be posted*/
/* The script expects to receive a title (can be empty but not NULL, content, and some categories/tags (as array) */
/* title should be in $posttitel, content in $contentspul, the array of categories/tags in $cats */
/* the default post status is draft, but you could turn that into a variable or set to publish */
/* the post information is submitted to the endpoint in JSON, using file_get_contents */
/* it requires getting a bearer token which is not handled in this script. get one manually for your endpoint from https://www.jvt.me/posts/2021/03/06/tokens-pls/ */

$bearertoken = "yourownsecrettoken";
ini_set('user_agent', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:95.0) Gecko/20100101 Firefox/95.0');
$formurl = "yourmicropubendpointaddress";

$html = ['html' => $contentspul];

$formproperties = array (
	'properties' => array (
	'type' => 'h-entry',
	'name' => $posttitel,
	'content' => [$html],
	'category' => $cats,
	'post-status' => 'draft'
	)
	);
	
$jsondata = json_encode($formproperties);

$headers = [
'Accept: application/json',
'Content-type: application/json',
'Authorization: Bearer '.$bearertoken
];

$formOptions = array(
    'http' => array(
        'header'  => $headers,
        'method'  => 'POST',
        'content' => $jsondata
    )
);

$context = stream_context_create($formOptions);
$resp = file_get_contents($formurl, false, $context);

?>
