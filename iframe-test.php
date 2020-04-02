<html>
  <head>
    <title>iFrame Test</title>
  </head>
  <body>
    <h1>
      iFrame Scraper Test - <button type="button" onclick="scrape();">Scrape Site</button>
    </h1>
    <div id="res"></div>
    <iframe id="myFrame" src="https://brickseek.com/products/?search=490770318731" style="width:100%; height:500px;"></iframe>
  </body>
  <script>
  function scrape(){
    var iframe = document.getElementById("myFrame");
    var elmnt = iframe.contentWindow.document.getElementsByTagName("DIV")[0];
    document.getElementById('res').innerHTML = elmnt.innerHTML;
  }
  </script>
</html>