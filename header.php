<head>
  <script>
  function addZero(x, n) {
    while (x.toString().length < n) {
      x = "0" + x;
    }
    return x;
  }
  function convertDateToUTC(date) { 
    return new Date(date.getUTCFullYear(), date.getUTCMonth(), date.getUTCDate(), date.getUTCHours(), date.getUTCMinutes(), date.getUTCSeconds()); 
  }
  function writeTime(){
    var dt = convertDateToUTC(new Date());
  $(".timer").text(
    addZero(23-dt.getHours(), 2)+" : "+
    addZero(59-dt.getMinutes(), 2)+" : "+
    addZero(60-dt.getSeconds(), 2)
    );
  }
  $(function() {
    writeTime();
    setInterval(writeTime, 1000);
  });
  </script>

  <style>
  /* Remove the navbar's default rounded borders and increase the bottom margin */ 
    .navbar {
      margin-bottom: 0px;
      border-radius: 0;
    }

    .timer {
      font-size:1.4em;
    }

    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;} 
    }

  </style>
</head>

</div>

<?php require_once "variables.php"; ?>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href='<?php echo"{$base_url}"?>'>Artwork Sharing</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href='<?php echo"{$base_url}"?>'>Home</a></li>
        <li><a href='<?php echo"{$base_url}submit.php"?>'>Submit</a></li>
        <li><a href='<?php echo"{$base_url}gallery.php"?>'>Gallery</a></li>
        <li><a href='<?php echo"{$base_url}chat.php"?>'>Chat</a></li>
        <li><a href='<?php echo"{$base_url}challenges.php"?>'>Challenges</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a class="timer">00 : 00 : 00</a></li>
      </ul>
    </div>
  </div>
</nav>
<br>