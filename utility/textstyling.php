<?php
require_once 'Michelf/MarkdownExtra.inc.php';
require_once "utility/htmlescape.php";

function getBreakText($t) {
    $t= strtr($t, array('\\r\\n' => '<br>', '\\r' => '<br>', '\\n' => '<br>'));
    return explode('<br>', $t);
}

function markdownTransform($text){
	$lines=getBreakText($text);
	$text="";
	foreach ($lines as &$l){
		$text.=\Michelf\MarkdownExtra::defaultTransform(htmlescape($l));
	}
	return $text;
}
?>