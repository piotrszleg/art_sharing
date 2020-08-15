<?php

require_once "variables.php";
require_once "utility/htmlescape.php";
require_once 'Michelf/MarkdownExtra.inc.php';
require_once "utility/textstyling.php";

//connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//connection

function getComments($id, $type){

global $conn, $commentstable;

$id=$conn->real_escape_string($id);

$sql = "SELECT username, comment FROM {$commentstable} WHERE postid = {$id} AND type={$type}";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
  $i=0;
  while($row = $result->fetch_assoc()) {
      echo comment($row["username"], $row["comment"]);
  }
} else {
    echo "<p class='text-center text-muted'>&lt;no comments&gt;</p>";
}

}

function comment($username, $comment) {
	$username=htmlescape($username);
  $comment=markdownTransform($comment);
	return "<div class='panel panel-default' style='width:100%;min-height:100px;'>
        <div class='panel-heading'><h4 class='panel-title'><b>{$username}</b> commented:</h4></div>
         <div class='panel-body'>{$comment}</div>
</div>";
}

?>