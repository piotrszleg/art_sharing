<?php
function linktotag($t){
  global $base_url;
  return htmlescape($base_url."tagged.php?tag=".str_replace('#', '', $t));
}

function linkTags($unlinked){
  $tags_reg="@(#\w+ ?)@";
  $linked_tag="%test";
  preg_match_all($tags_reg, $unlinked, $matches);
  $matches=$matches[0];
  for ($m= 0; $m < count($matches); $m++) {
    $unlinked=str_replace($matches[$m], "<a href='".linktotag($matches[$m])."'>".htmlescape($matches[$m])."</a>", $unlinked);
  }
  return $unlinked;
}

function linktotagBox($t){
  global $base_url;
  return htmlescape($base_url."tagged.php?tag=".str_replace('#', '', $t));
}

function linkTagsBoxes($unlinked){
  $tags_reg="@(#\w+ ?)@";
  $linked_tag="%test";
  preg_match_all($tags_reg, $unlinked, $matches);
  $matches=$matches[0];
  for ($m= 0; $m < count($matches); $m++) {
    $unlinked=str_replace($matches[$m], "<div class='tag' url='".linktotagBox($matches[$m])."'>".htmlescape($matches[$m])."</div>", $unlinked);//url is used in onclick event
  }
  return $unlinked;
}
?>