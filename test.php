<?php
//session_start();
//$_SESSION['refresh_token'] = '';
?>
<html>
  <head>
    <title>Image Dimensions Checkers</title>
    
  </head>
  <body>
    <h1>
      Image Dimensions Checker
    </h1>
    <input type="text" id="img_url" onchange="check_img(this.value);" />
    <br><br>
    <div id="img_size"></div>
  </body>
  <script>
    var data = null;

    var xhr = new XMLHttpRequest();
    xhr.withCredentials = true;

    xhr.addEventListener("readystatechange", function () {
      if (this.readyState === this.DONE) {
        console.log(this.responseText);
      }
    });

    xhr.open("GET", "https://feeditem-target.p.rapidapi.com/itemID/077-03-1873");
    xhr.setRequestHeader("x-rapidapi-host", "feeditem-target.p.rapidapi.com");
    xhr.setRequestHeader("x-rapidapi-key", "bb3c6d2c0cmsh28f3e3f09b863c4p14cbdajsn6e51e6f47faa");

    xhr.send(data);
  </script>
</html>