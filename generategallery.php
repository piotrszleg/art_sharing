<script type="text/javascript">
  //resize divs to their background image
  function resizeImages(){
    $( ".gallery-image" ).each(function() {
      var img = document.createElement('IMG');
      img.src=$(this).attr('img');
      var div=this;
      $(div).css('height', $(div).width());
      img.onload = function () {
        console.log("Image loaded");
        var proportions=$(div).width()/img.width;
        $(div).css('height', (img.height*proportions).toString());
      };
    });
  }
  $(function() {
    $('[data-toggle="popover"]').popover();//Bootstrap popover
    resizeImages();
    //tag links handling
    $( ".tag" ).click(function(e) {
      e.preventDefault();
      e.stopPropagation();
      window.location = $(this).attr('url');
    });
    $( window ).on('resize', resizeImages);
  });
</script>
<?php

require_once "utility/taglinking.php";
require_once "utility/commentscount.php";
require_once "utility/htmlescape.php";

//stylised containers
$containerstart = ' <div class="container-fluid gallery-container"> <div class="panel-body row" style="width:100%;padding:2px;">';
$rowstart='  <div class="col-xs-2 gallery-row" style="border-left-style: solid;border-right-style: solid;border-color: #eee;border-width:1px">';
function imagebox($username, $imagesource, $tags, $streak, $id, $comments, $link=true) {
  global $base_url;
  $username=htmlescape($username);
  $imagesource=htmlescape($imagesource);
  $tags=htmlescape($tags);
  $tagsBoxes=linkTagsBoxes($tags);
  $streak=htmlescape($streak);
  $id=htmlescape($id);
  $href= htmlescape($link ? $base_url."getpost.php?id={$id}" : "#");//create either link to image or empty href
  return "
    <a href='{$href}'>
        <div class='img-responsive img-rounded gallery-image' style='background-image: url({$imagesource});' img={$imagesource}>
          
            <div class='container-fluid image-description'>
              <div class='row'>
                <div class='col-xs-4'>
                    <b class='username' style='color:black'>{$username}</b><br>
                    <span class='text-muted comments'>{$comments} 
                    <span class='glyphicon glyphicon-comment' aria-hidden='true' style='color:white;text-shadow:-0.1em 0 gray, 0 0.1em gray, 0.1em 0 gray, 0 -0.1em gray;'></span>
                    <span class='sr-only'>comments</span></span>
                </div>
                <div class='col-xs-8 text-right'>
                  <h1 class='streak-text'>
                  <span class='glyphicon glyphicon-remove' aria-hidden='true' style='font-size:0.7em;padding:0px;'></span>
                  <span class='sr-only'>x</span>
                  <b class='streak'>{$streak}</b>
                  </h1>
                </div>
              </div>
            </div>
          <div class='tags-container'>
            {$tagsBoxes}
          </div>
        </div>
      </a>

        
        ";
}
//stylised containers

function generategallery($result){
global $containerstart, $rowstart;

//gallery generator
echo $containerstart;
if ($result->num_rows > 0) {
	$i=0;
  $columnCount=ceil($result->num_rows/6);
  $columnCount=$columnCount>0?$columnCount:1;
	echo $rowstart;
    while($row = $result->fetch_assoc()) {
        echo imagebox($row["username"], $row["imagesource"], $row["tags"], $row["strike"], $row["id"], commentscount($row["id"], 0));
        $i++;
        if($i%$columnCount==0 && $i!=$result->num_rows){
        	//close the previous row and start a new one.
        	echo '</div>';
        	echo $rowstart;
        }
    }
    echo '</div>';
} else {
    echo "<p class='text-center text-muted'>&lt;no images&gt;</p>";
}
echo '</div></div>';
//gallery generator

}

?>