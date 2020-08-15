<!DOCTYPE html>
<html>

<head>
  <title>Artwork Sharing</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="style.css" rel="stylesheet">
  <script>
  $(function() {
    $( "li:contains('Home')" ).addClass("active"); 
  });
  </script>
  <style>

  </style>
</head>

<body>

<?php 
require_once "variables.php";
require_once "utility/setupdatabase.php";
require_once 'Michelf/Markdown.inc.php';
require_once "utility/htmlescape.php";

function getBreakText($t) {
  return strtr($t, array('\\r\\n' => '<br>', '\\r' => '<br>', '\\n' => '<br>'));
}

$text="## Instructions
This is an artwork sharing website with support for commenting and creating group challenges.

- Go to `Submit` to submit new image.
- You can see all submitted images in the `Gallery`.
- Besides image comments there is also a global chat under `Chat` tab.
- You can view and create new challenges in `Challenges`.

---

## Using Markdown
You can add a `#` at the beginning of your line to turn it into a header:

`# Header`
### Header
(remember to write space after #)

---

Or link by writing:

`[link](http://google.com)`

[link](http://google.com)

---

Link your critique image by writing:

`![altext](https://www.w3schools.com/bootstrap/cinqueterre.jpg)`

![altext](https://www.w3schools.com/bootstrap/cinqueterre.jpg)

(link to image procceded by !)

---

There are more things you can do with markdown, like quoting or making tables, but I won't repeat what is already on the internet.
## [longer tutorial](https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet)



";

require "header.php";

echo '<div class="container-fluid page-container">    
<div class="row content">
  <div class="col-sm-3">
  </div>
  <div class="col-sm-6 text-left">';

echo \Michelf\Markdown::defaultTransform(getBreakText($text));

echo '</div>
    <div class="col-sm-3">
    </div>
  </div>
</div>';

require "footer.php"; 
?>

</body>
</html>